<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "List Galeri";

    // Setting default response
    $code = 201;
    $keterangan = "Terjadi kesalahan";
    $metadata = [];

    // Validasi Metode Pengiriman Data
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        $keterangan = "Metode Pengiriman Data Hanya Boleh Menggunakan GET";
    } else {
        if(empty($_GET['album'])){
            $keterangan = "Nama Album Tidak Boleh Kosong";
        }else{
            $album=validateAndSanitizeInput($_GET['album']);
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
                            
                            // Persiapkan Query untuk Mengambil Data Galeri
                            $QryGalleri = $Conn->prepare("SELECT * FROM web_galeri WHERE album='$album' ORDER BY nama_galeri ASC");
                            $QryGalleri->execute();
                            $ResultGaleri = $QryGalleri->get_result();
                            
                            while ($DataGaleri = $ResultGaleri->fetch_assoc()) {
                                $datetime=$DataGaleri['datetime'];
                                $nama_galeri=$DataGaleri['nama_galeri'];
                                $file_galeri=$DataGaleri['file_galeri'];
                                $image_path="$base_url/assets/img/Galeri/$file_galeri";
                                $new_width=500;
                                $new_height=500;
                                $image_base64=resizeImage($image_path, $new_width, $new_height);
                                // Add to array
                                $metadata[] = [
                                    "datetime" => $datetime,
                                    "nama_galeri" => $nama_galeri,
                                    "image" => $image_base64
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
