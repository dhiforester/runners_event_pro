<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Riwayat Transaksi Pembelian";

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
                } else {
                    // Validasi id_member_login tidak boleh kosong
                    if (!isset($Tangkap['id_member_login'])) {
                        $keterangan = "ID Member Login Tidak Boleh Kosong";
                    } else {
                        // Buat Dalam Bentukk Variabel
                        $xtoken = validateAndSanitizeInput($headers['x-token']);
                        $email = validateAndSanitizeInput($Tangkap['email']);
                        $id_member_login = validateAndSanitizeInput($Tangkap['id_member_login']);
                        
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
                                
                                //Validasi email Dan id_member_login
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
                                        //Cek Apakah Email Sesuai
                                        if($email_member!==$email){
                                            $keterangan = "Email dengan ID Login Tidak Sesuai ($email_member | $email)";
                                        }else{
                                            //Buka Riwayat Transaksi
                                            $QryTransaksi = mysqli_query($Conn, "SELECT*FROM transaksi WHERE id_member='$id_member' AND kategori='Pembelian'");
                                            while ($DataTransaksi = mysqli_fetch_array($QryTransaksi)) {
                                                $kode_transaksi= $DataTransaksi['kode_transaksi'];
                                                $raw_member= $DataTransaksi['raw_member'];
                                                $datetime= $DataTransaksi['datetime'];
                                                $jumlah= $DataTransaksi['jumlah'];
                                                $status= $DataTransaksi['status'];
                                                //Ubah Raw Member
                                                $raw_member=json_decode($raw_member, true);
                                                //Buka Data Pengiriman
                                                $no_resi=GetDetailData($Conn, 'transaksi_pengiriman', 'kode_transaksi', $kode_transaksi, 'no_resi');
                                                $kurir=GetDetailData($Conn, 'transaksi_pengiriman', 'kode_transaksi', $kode_transaksi, 'kurir');
                                                $status_pengiriman=GetDetailData($Conn, 'transaksi_pengiriman', 'kode_transaksi', $kode_transaksi, 'status_pengiriman');
                                                $datetime_pengiriman=GetDetailData($Conn, 'transaksi_pengiriman', 'kode_transaksi', $kode_transaksi, 'datetime');
                                                $transaksi_pengiriman= [
                                                    "no_resi" => $no_resi,
                                                    "kurir" => $kurir,
                                                    "status_pengiriman" => $status_pengiriman,
                                                    "datetime_pengiriman" => $datetime_pengiriman
                                                ];
                                                //Buat Transaksi Rincian
                                                $metadata[]= [
                                                    "kode_transaksi" => $kode_transaksi,
                                                    "raw_member" => $raw_member,
                                                    "pengiriman" => $transaksi_pengiriman,
                                                    "datetime" => $datetime,
                                                    "jumlah" => $jumlah,
                                                    "status" => $status
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
                                        }
                                    }
                                }else{
                                    $keterangan = "Sessi Login Tidak Ditemukan";
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
