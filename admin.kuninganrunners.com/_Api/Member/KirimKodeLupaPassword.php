<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/SettingEmail.php";
    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Reset Password Member";

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
                    $ValidasiKelengkapan = "Valid";
                }
            }
            if($ValidasiKelengkapan!=="Valid"){
                $keterangan = $ValidasiKelengkapan;
            }else{
                // Validasi panjang karakter
                if (strlen($Tangkap['email']) > 100) { 
                    $ValidasiJumlahKarakter= 'Email tidak boleh lebih dari 100 karakter.'; 
                }else{
                    $ValidasiJumlahKarakter='Valid'; 
                }
                if($ValidasiJumlahKarakter!=="Valid"){
                    $keterangan = $ValidasiJumlahKarakter;
                }else{
                    //Buat Variabel
                    $xtoken = validateAndSanitizeInput($headers['x-token']);
                    $email = validateAndSanitizeInput($Tangkap['email']);
                    $kode =GenerateToken(36);

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
                            
                            // Apakah Email Terdaftar
                            $id_member = GetDetailData($Conn, 'member', 'email', $email, 'id_member');
                            if(empty($id_member)){
                                $keterangan= 'Email tidak terdaftar pada database'; 
                            }else{
                                //Apakah Sebelumnya Sudah Punya Kode
                                $id_member_lp_pass = GetDetailData($Conn, 'member_lp_pass', 'id_member', $id_member, 'id_member_lp_pass');
                                if(empty($id_member_lp_pass)){
                                    $id_member_lp_pass =GenerateToken(36);
                                    //Simpan Data Ke Database
                                    $status="Active";
                                    $query = "INSERT INTO member_lp_pass (
                                        id_member_lp_pass, 
                                        id_member, 
                                        kode, 
                                        status
                                    ) 
                                    VALUES (?, ?, ?, ?)";
                                    $stmt = $Conn->prepare($query);
                                    $stmt->bind_param(
                                        "ssss", 
                                        $id_member_lp_pass, 
                                        $id_member, 
                                        $kode, 
                                        $status
                                    );
                                    if ($stmt->execute()) {
                                        $ValidasiProses="Berhasil";
                                    }else{
                                        $ValidasiProses="Terjadi Kesalahan Pada Saat Menambahkan Data Ke Database";
                                    }
                                }else{
                                    //Update Jika Sudah Ada
                                    $updateQuery = "UPDATE member_lp_pass SET kode = ? WHERE id_member_lp_pass = ?";
                                    $stmtUpdate = $Conn->prepare($updateQuery);
                                    $stmtUpdate->bind_param('ss', $kode, $id_member_lp_pass);
                                    if ($stmtUpdate->execute()) {
                                        $ValidasiProses="Berhasil";
                                    }else{
                                        $ValidasiProses="Terjadi Kesalahan Pada Saat Update Data Ke Database";
                                    }
                                }
                                if($ValidasiProses!=="Berhasil"){
                                    $keterangan= $ValidasiProses; 
                                }else{
                                    $nama = GetDetailData($Conn, 'member', 'email', $email, 'nama');
                                    $web_base_url = GetDetailData($Conn, 'web_setting', 'id_web_setting', '1', 'base_url');
                                    //Kirim Email
                                    $pesan='Kepada Yth.'.$nama.'<br>Berikut ini adalah tautan untuk melakukan reset password akun anda : <a href="'.$web_base_url.'/reset-password-member.php?id='.$id_member.'&rest='.$id_member_lp_pass.'&kode='.$kode.'">Klik Pada Tautan Berikut Ini Untuk Reset Password</a>';
                                    $ch = curl_init();
                                    $headers = array(
                                        'Content-Type: Application/JSON',          
                                        'Accept: Application/JSON'     
                                    );
                                    $arr = array(
                                        "subjek" => "Validasi Email",
                                        "email_asal" => "$email_gateway",
                                        "password_email_asal" => "$password_gateway",
                                        "url_provider" => "$url_provider",
                                        "nama_pengirim" => "$nama_pengirim",
                                        "email_tujuan" => "$email",
                                        "nama_tujuan" => "$nama",
                                        "pesan" => "$pesan",
                                        "port" => "$port_gateway"
                                    );
                                    $json = json_encode($arr);
                                    curl_setopt($ch, CURLOPT_URL, "$url_service");
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                    curl_setopt($ch, CURLOPT_TIMEOUT, 1000); 
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $content = curl_exec($ch);
                                    $err = curl_error($ch);
                                    curl_close($ch);
                                    $get =json_decode($content, true);
                                    //menyimpan Log
                                    $SimpanLog = insertLogApi($Conn, $id_setting_api_key, $title_api_key, $service_name, 200, "success", $now);
                                    if ($SimpanLog !== "Success") {
                                        $keterangan = "Gagal Menyimpan Log Service";
                                        $code = 201;
                                    } else {
                                        $keterangan = "success";
                                        $code = 200;
                                    }
                                }
                            }
                        } else {
                            $keterangan = "X-Token Yang Digunakan Sudah Tidak Berlaku";
                        }
                    }else{
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
