<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "List Testimoni";

    // Setting default response
    $code = 201;
    $keterangan = "Terjadi kesalahan";
    $metadata = [];

    // Validasi Metode Pengiriman Data
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        $keterangan = "Metode Pengiriman Data Hanya Boleh Menggunakan GET";
    } else {
        try {
            // Tangkap Header
            $headers = getallheaders();
            
            // Validasi x-token tidak boleh kosong
            if (!isset($headers['x-token'])) {
                $keterangan = "x-token Tidak Boleh Kosong";
            } else {
                // Buat Dalam Bentukk Variabel
                $xtoken = validateAndSanitizeInput($headers['x-token']);
                
                // Validasi x-token menggunakan prepared statements
                $stmt = $Conn->prepare("SELECT * FROM api_session WHERE xtoken = ?");
                $stmt->bind_param("s", $xtoken);
                $stmt->execute();
                $result = $stmt->get_result();
                $DataValidasiToken = $result->fetch_assoc();
                
                if ($DataValidasiToken) {
                    $datetime_creat = $DataValidasiToken['datetime_creat'];
                    $datetime_expired = $DataValidasiToken['datetime_expired'];
                    
                    // Cek Token Apakah Masih Berlaku
                    if ($now >= $datetime_creat && $now <= $datetime_expired) {
                        // Validasi berhasil, lanjutkan dengan logika
                        $id_api_session = $DataValidasiToken['id_api_session'];
                        $id_setting_api_key = $DataValidasiToken['id_setting_api_key'];
                        $title_api_key = GetDetailData($Conn, 'setting_api_key', 'id_setting_api_key', $id_setting_api_key, 'title_api_key');
                        
                        // Persiapkan Query untuk Mengambil Data Album
                        $QryTestimoni = $Conn->prepare("SELECT id_member, penilaian, testimoni, datetime FROM web_testimoni WHERE status='Publish' ORDER BY datetime ASC");
                        $QryTestimoni->execute();
                        $ResultTestimoni = $QryTestimoni->get_result();
                        
                        while ($DataTestimoni = $ResultTestimoni->fetch_assoc()) {
                            $id_member=$DataTestimoni['id_member'];
                            $penilaian=$DataTestimoni['penilaian'];
                            $testimoni=$DataTestimoni['testimoni'];
                            $datetime=$DataTestimoni['datetime'];
                            //Membuka Member
                            $nama = GetDetailData($Conn, 'member', 'id_member', $id_member, 'nama');
                            $foto = GetDetailData($Conn, 'member', 'id_member', $id_member, 'foto');
                            $image_path="../../assets/img/Member/$foto";
                            // Desired width and height for the resized image
                            $new_width = 200;
                            $new_height = 200;

                            // Check if file exists
                            if (file_exists($image_path)) {
                                // Get the original image dimensions and type
                                list($width, $height, $type) = getimagesize($image_path);
                                // Create an image resource from the file based on its type
                                switch ($type) {
                                    case IMAGETYPE_JPEG:
                                        $src_image = imagecreatefromjpeg($image_path);
                                        break;
                                    case IMAGETYPE_PNG:
                                        $src_image = imagecreatefrompng($image_path);
                                        break;
                                    case IMAGETYPE_GIF:
                                        $src_image = imagecreatefromgif($image_path);
                                        break;
                                    default:
                                        $foto_profil="File Type No Support";
                                }
                                // Create a new true color image with the desired dimensions
                                $resized_image = imagecreatetruecolor($new_width, $new_height);

                                // Resize the image
                                imagecopyresampled($resized_image, $src_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

                                // Start output buffering to capture the output
                                ob_start();

                                // Output the resized image as JPEG to buffer
                                imagejpeg($resized_image, null, 85); // 85 is the quality level

                                // Get the contents of the buffer and encode it in Base64
                                $image_data = ob_get_clean();
                                $foto_profil = "data:image/jpeg;base64," . base64_encode($image_data);

                                // Clean up memory
                                imagedestroy($src_image);
                                imagedestroy($resized_image);
                            } else {
                                $foto_profil="No File";
                            }
                            // Add to array
                            $metadata[] = [
                                "nama" => $nama,
                                "penilaian" => $penilaian,
                                "testimoni" => $testimoni,
                                "datetime" => $datetime,
                                "foto_profil" => $foto_profil
                            ];
                        }
                        
                        //menyimpan Log
                        $SimpanLog = insertLogApi($Conn, $id_setting_api_key, $title_api_key, $service_name, 200, "success", $now);
                        if ($SimpanLog !== "Success") {
                            $keterangan = "Gagal Menyimpan Log Service";
                            $code = 201;
                        } else {
                            $keterangan = "success";
                            $code = 200;
                        }
                    } else {
                        $keterangan = "X-Token Yang Digunakan Sudah Tidak Berlaku";
                    }
                } else {
                    $keterangan = "X-Token Yang Digunakan Tidak Valid";
                }
                
                $stmt->close();
            }
        } catch (Exception $e) {
            $keterangan = "Terjadi kesalahan sistem: " . $e->getMessage();
            $code = 500;
        }
    }

    // Menyiapkan respons
    $response = [
        "message" => $keterangan,
        "code" => $code,
    ];

    $Array = [
        "response" => $response,
        "metadata" => $metadata ?? []
    ];

    // Kirim JSON response
    header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + (10 * 60)));
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header('Content-Type: application/json');
    header('Pragma: no-cache');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, x-token, token");
    echo json_encode($Array, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit();
?>
