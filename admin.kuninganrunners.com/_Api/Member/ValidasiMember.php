<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/SettingEmail.php";
    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Validasi Email Member";

    // Setting default response
    $code = 201;
    $keterangan = "Terjadi kesalahan";
    $metadata = [];

    // Validasi Metode Pengiriman Data
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $keterangan = "Metode Pengiriman Data Hanya Boleh Menggunakan POST";
    } else {
        try {
            // Variabel Header
            $headers = getallheaders();
            // Decode Json Data
            $raw = file_get_contents('php://input');
            $Tangkap = json_decode($raw, true);
            // Validasi x-token tidak boleh kosong
            if (!isset($headers['x-token'])) {
                $ValidasiKelengkapan = "x-token Tidak Boleh Kosong";
            } else {
                // Validasi email tidak boleh kosong
                if (!isset($Tangkap['email'])) {
                    $ValidasiKelengkapan = "Email Tidak Boleh Kosong";
                } else {
                    // Validasi kode_validasi tidak boleh kosong
                    if (!isset($Tangkap['kode_validasi'])) {
                        $ValidasiKelengkapan = "Kode Validasi Tidak Boleh Kosong";
                    } else {
                        $ValidasiKelengkapan = "Valid";
                    }
                }
            }
            if($ValidasiKelengkapan!=="Valid"){
                $keterangan = $ValidasiKelengkapan;
            }else{
                // Validasi panjang karakter
                if (strlen($Tangkap['kode_validasi']) > 9) { 
                    $ValidasiJumlahKarakter= 'Kode validasi tidak boleh lebih dari 9 karakter.'; 
                }else{
                    $ValidasiJumlahKarakter='Valid'; 
                }
                if($ValidasiJumlahKarakter!=="Valid"){
                    $keterangan = $ValidasiJumlahKarakter;
                }else{
                    //Validasi Tipe Data
                    if (!ctype_alnum($Tangkap['kode_validasi'])) {
                        $ValidasiTipeData='Kode Validasi hanya boleh huruf dan angka.';
                    }else{
                        $ValidasiTipeData='Valid';
                    }
                    if($ValidasiTipeData!=="Valid"){
                        $keterangan= $ValidasiTipeData;
                    }else{
                        //Buat Variabel
                        $xtoken = validateAndSanitizeInput($headers['x-token']);
                        $email = validateAndSanitizeInput($Tangkap['email']);
                        $kode_validasi = validateAndSanitizeInput($Tangkap['kode_validasi']);
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
                                
                                //Validasi Kode dan email
                                $status="Pending";
                                $stmt2 = $Conn->prepare("SELECT * FROM member WHERE email = ? AND email_validation = ? AND status = ?");
                                $stmt2->bind_param("sss", $email, $kode_validasi, $status);
                                $stmt2->execute();
                                $result2 = $stmt2->get_result();
                                $DataMember = $result2->fetch_assoc();
                                if ($DataMember) {
                                    $id_member = $DataMember['id_member'];
                                    //Update Status Member
                                    $status="Active";
                                    $updateQuery = "UPDATE member SET status = ? WHERE id_member = ?";
                                    $stmtUpdate = $Conn->prepare($updateQuery);
                                    $stmtUpdate->bind_param('ss', $status, $id_member);
                                    if ($stmtUpdate->execute()) {
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
                                        $keterangan = "Terjadi kesalahan pada saat proses update status member";
                                    }
                                    $stmtUpdate->close();
                                }else{
                                    $keterangan = "Kombinasi email dan kode validasi tidak valid";
                                }
                                $stmt2->close();
                            } else {
                                $keterangan = "X-Token Yang Digunakan Sudah Tidak Berlaku";
                            }
                        } else {
                            $keterangan = "X-Token Yang Digunakan Tidak Valid";
                        }
                        $stmt->close();
                    }
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
