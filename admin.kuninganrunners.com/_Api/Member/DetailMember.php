<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Detail Member";

    // Setting default response
    $code = 201;
    $keterangan = "Terjadi kesalahan";
    $metadata = [];

    // Validasi Metode Pengiriman Data
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $keterangan = "Metode Pengiriman Data Hanya Boleh Menggunakan GET";
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
                } else {
                     // Validasi password tidak boleh kosong
                    if (!isset($Tangkap['password'])) {
                        $keterangan = "Password Tidak Boleh Kosong";
                    } else {
                        // Buat Dalam Bentukk Variabel
                        $xtoken = validateAndSanitizeInput($headers['x-token']);
                        $email = validateAndSanitizeInput($Tangkap['email']);
                        $password = validateAndSanitizeInput($Tangkap['password']);
                        
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
                                
                                //Validasi Email Dan Password
                                $stmt = $Conn->prepare("SELECT * FROM member WHERE email = ?");
                                $stmt->bind_param("s", $email);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $DataMember = $result->fetch_assoc();
                                if ($DataMember && password_verify($password, $DataMember['password'])) {
                                    // Persiapkan Query untuk Mengambil Data Member
                                    $metadata = [
                                        "nama" => $DataMember['nama'] ?? null,
                                        "kontak" => $DataMember['kontak'] ?? null,
                                        "email" => $DataMember['email'] ?? null,
                                        "provinsi" => $DataMember['provinsi'] ?? null,
                                        "kabupaten" => $DataMember['kabupaten'] ?? null,
                                        "kecamatan" => $DataMember['kecamatan'] ?? null,
                                        "desa" => $DataMember['desa'] ?? null,
                                        "kode_pos" => $DataMember['kode_pos'] ?? null,
                                        "rt_rw" => $DataMember['rt_rw'] ?? null,
                                        "datetime" => $DataMember['datetime'] ?? null,
                                        "status" => $DataMember['status'] ?? null,
                                        "sumber" => $DataMember['sumber'] ?? null,
                                        "foto" => $DataMember['foto'] ?? null,
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
                                }else{
                                    $keterangan = "Kombinasi Password Dan Email Tidak Valid";
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