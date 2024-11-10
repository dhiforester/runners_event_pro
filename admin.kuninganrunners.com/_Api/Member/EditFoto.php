<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Edit Foto Member";
    // Setting default response
    $code = 201;
    $keterangan = "Terjadi kesalahan";
    $metadata = [];

    // Validasi Metode Pengiriman Data
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $keterangan = "Metode Pengiriman Data Hanya Boleh Menggunakan POST";
    } else {
        try {
            // Tangkap Header
            $headers = getallheaders();

            // Validasi x-token tidak boleh kosong
            if (!isset($headers['x-token'])) {
                $keterangan = "x-token Tidak Boleh Kosong";
            } else {
                // Tangkap data dan decode
                $raw = file_get_contents('php://input');
                $Tangkap = json_decode($raw, true);

                // Validasi email tidak boleh kosong
                if (!isset($Tangkap['email'])) {
                    $keterangan = "Email Tidak Boleh Kosong";
                } else if (!isset($Tangkap['id_member_login'])) {
                    $keterangan = "ID Member Login Tidak Boleh Kosong";
                } else if (!isset($Tangkap['base64'])) {
                    $keterangan = "File Foto Tidak Boleh Kosong";
                } else {
                    // Buat Variabel
                    $xtoken = validateAndSanitizeInput($headers['x-token']);
                    $email = validateAndSanitizeInput($Tangkap['email']);
                    $id_member_login = validateAndSanitizeInput($Tangkap['id_member_login']);
                    $base64 = validateAndSanitizeInput($Tangkap['base64']);

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
                            $id_api_session = $DataValidasiToken['id_api_session'];
                            $id_setting_api_key = $DataValidasiToken['id_setting_api_key'];
                            $title_api_key = GetDetailData($Conn, 'setting_api_key', 'id_setting_api_key', $id_setting_api_key, 'title_api_key');
                            
                            // Validasi id_member_login
                            $stmt = $Conn->prepare("SELECT * FROM member_login WHERE id_member_login = ?");
                            $stmt->bind_param("s", $id_member_login);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $DataMember = $result->fetch_assoc();

                            if (!empty($DataMember['id_member'])) {
                                $id_member=$DataMember['id_member'];
                                $datetime_expired=$DataMember['datetime_expired'];
                                //Cek Apakah Sessi Login Sudah Berakhir?
                                if($datetime_expired<$now){
                                    $keterangan = "Sessi Login Sudah Berakhir";
                                }else{
                                    //Buka Email Di Database
                                    $email_member=GetDetailData($Conn, 'member', 'id_member', $id_member, 'email');
                                    $status_member=GetDetailData($Conn, 'member', 'id_member', $id_member, 'status');
                                    //Cek Apakah Email Sesuai
                                    if($email_member!==$email){
                                        $keterangan = "Email dengan ID Login Tidak Sesuai";
                                    }else{
                                        if ($status_member !== "Active") {
                                            $keterangan = "Member Belum Melakukan Validasi Email";
                                        } else {
                                            $decoded_image = base64_decode($base64, true);
                                            if ($decoded_image === false) {
                                                $keterangan = "Base 64 Image Tidak Valid";
                                            } else {
                                                //Validasi Size
                                                $max_size=5 * 1024 * 1024;
                                                if (strlen($decoded_image) > $max_size) {
                                                    $keterangan = "File Terlalu Besar (Maksimal 5 Mb)";
                                                }else{
                                                    //Vaidasi Tipe
                                                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                                    $mime_type = finfo_buffer($finfo, $decoded_image);
                                                    finfo_close($finfo);

                                                    if ($mime_type !== 'image/jpeg' && $mime_type !== 'image/jpg' && $mime_type !== 'image/png' && $mime_type !== 'image/gif') {
                                                        $keterangan = "Tipe File Tidak Valid (Hanya Boleh JPG, JPEG, GIF dan PNG)";
                                                    }else{
                                                        if($mime_type=='image/jpeg'){
                                                            $extension=".jpeg";
                                                        }else{
                                                            if($mime_type=='image/jpg'){
                                                                $extension=".jpg";
                                                            }else{
                                                                if($mime_type=='image/png'){
                                                                    $extension=".png";
                                                                }else{
                                                                    if($mime_type=='image/gif'){
                                                                        $extension=".gif";
                                                                    }else{
                                                                        $extension=".jpeg";
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        $newFileName = bin2hex(random_bytes(16)) . ''.$extension.'';
                                                        $uploadDir = '../../assets/img/Member/';
                                                        $uploadPath = $uploadDir . $newFileName;

                                                        if (file_put_contents($uploadPath, $decoded_image)) {
                                                            // Hapus foto lama jika ada
                                                            if (!empty($DataMember['foto'])) {
                                                                unlink($uploadDir . $DataMember['foto']);
                                                            }

                                                            // Update Data Foto Member
                                                            $updateQuery = "UPDATE member SET foto = ? WHERE id_member = ?";
                                                            $stmtUpdate = $Conn->prepare($updateQuery);
                                                            $stmtUpdate->bind_param('ss', $newFileName, $id_member);
                                                            if ($stmtUpdate->execute()) {
                                                                $metadata = [
                                                                    "foto" => $newFileName
                                                                ];
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
                                                                $keterangan = "Terjadi kesalahan saat menyimpan ke database";
                                                            }
                                                        } else {
                                                            $keterangan = "Terjadi kesalahan saat upload file";
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            } else {
                                $keterangan = "Sesi Login Tidak Valid";
                            }
                        } else {
                            $keterangan = "X-Token Yang Digunakan Sudah Tidak Berlaku";
                        }
                    } else {
                        $keterangan = "X-Token Yang Digunakan Tidak Valid";
                    }
                    
                    $stmt->close();
                }
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
