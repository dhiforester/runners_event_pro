<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Detail Transaksi Pembelian";

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
                        // Validasi id_barang tidak boleh kosong
                        if (!isset($Tangkap['kode_transaksi'])) {
                            $keterangan = "Kode Transaksi Tidak Boleh Kosong";
                        } else {
                            // Buat Dalam Bentukk Variabel
                            $xtoken = validateAndSanitizeInput($headers['x-token']);
                            $email = validateAndSanitizeInput($Tangkap['email']);
                            $id_member_login = validateAndSanitizeInput($Tangkap['id_member_login']);
                            $kode_transaksi = validateAndSanitizeInput($Tangkap['kode_transaksi']);
                            
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
                                                // Cek Apakah Kode Transaksi Sesuai
                                                $ValidasiKodeTransaksi = mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi WHERE kode_transaksi='$kode_transaksi' AND id_member='$id_member' AND kategori='Pembelian'"));
                                                if(empty($ValidasiKodeTransaksi)){
                                                    $keterangan = "Kode Transaksi Yang Anda Gunakan Tidak Valid";
                                                }else{
                                                    //Buka Data Transaksi
                                                    $raw_member = GetDetailData($Conn, 'transaksi', 'kode_transaksi', $kode_transaksi, 'raw_member');
                                                    $kategori = GetDetailData($Conn, 'transaksi', 'kode_transaksi', $kode_transaksi, 'kategori');
                                                    $datetime_transaksi = GetDetailData($Conn, 'transaksi', 'kode_transaksi', $kode_transaksi, 'datetime');
                                                    $jumlah = GetDetailData($Conn, 'transaksi', 'kode_transaksi', $kode_transaksi, 'jumlah');
                                                    $status = GetDetailData($Conn, 'transaksi', 'kode_transaksi', $kode_transaksi, 'status');
                                                    //Ubah Raw Member Menjadi Array
                                                    $raw_member=json_decode($raw_member, true);
                                                    //Buka Data Rincian
                                                    $transaksi_rincian=[];
                                                    $QryTransaksiRincian = mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE kode_transaksi='$kode_transaksi'");
                                                    while ($DataTransaksiRincian = mysqli_fetch_array($QryTransaksiRincian)) {
                                                        $id_transaksi_rincian= $DataTransaksiRincian['id_transaksi_rincian'];
                                                        $uraian_transaksi= $DataTransaksiRincian['uraian_transaksi'];
                                                        $harga= $DataTransaksiRincian['harga'];
                                                        $qty= $DataTransaksiRincian['qty'];
                                                        $jumlah= $DataTransaksiRincian['jumlah'];
                                                        //Ubah Uraian Menjadi Array
                                                        $uraian_transaksi=json_decode($uraian_transaksi, true);
                                                        //Buat Transaksi Rincian
                                                        $transaksi_rincian[]= [
                                                            "id_transaksi_rincian" => $id_transaksi_rincian,
                                                            "uraian_transaksi" => $uraian_transaksi,
                                                            "harga" => $harga,
                                                            "qty" => $qty,
                                                            "jumlah" => $jumlah
                                                        ];
                                                    }
                                                    //Buka Transaksi Payment
                                                    $id_transaksi_payment = GetDetailData($Conn, 'transaksi_payment', 'kode_transaksi', $kode_transaksi, 'id_transaksi_payment');
                                                    $order_id = GetDetailData($Conn, 'transaksi_payment', 'kode_transaksi', $kode_transaksi, 'order_id');
                                                    $snap_token = GetDetailData($Conn, 'transaksi_payment', 'kode_transaksi', $kode_transaksi, 'snap_token');
                                                    $datetime_payment = GetDetailData($Conn, 'transaksi_payment', 'kode_transaksi', $kode_transaksi, 'datetime');
                                                    $status_payment = GetDetailData($Conn, 'transaksi_payment', 'kode_transaksi', $kode_transaksi, 'status');
                                                    //Buat Transaksi Payment
                                                    $transaksi_payment= [
                                                        "id_transaksi_payment" => $id_transaksi_payment,
                                                        "order_id" => $order_id,
                                                        "snap_token" => $snap_token,
                                                        "datetime" => $datetime_payment,
                                                        "status" => $status_payment
                                                    ];
                                                    //Buka Transaksi Pengiriman
                                                    $id_transaksi_pengiriman = GetDetailData($Conn, 'transaksi_pengiriman', 'kode_transaksi', $kode_transaksi, 'id_transaksi_pengiriman');
                                                    $no_resi = GetDetailData($Conn, 'transaksi_pengiriman', 'kode_transaksi', $kode_transaksi, 'no_resi');
                                                    $kurir = GetDetailData($Conn, 'transaksi_pengiriman', 'kode_transaksi', $kode_transaksi, 'kurir');
                                                    $status_pengiriman = GetDetailData($Conn, 'transaksi_pengiriman', 'kode_transaksi', $kode_transaksi, 'status_pengiriman');
                                                    $datetime = GetDetailData($Conn, 'transaksi_pengiriman', 'kode_transaksi', $kode_transaksi, 'datetime');
                                                    //Buat Transaksi Payment
                                                    $transaksi_pengiriman= [
                                                        "id_transaksi_pengiriman" => $id_transaksi_pengiriman,
                                                        "no_resi" => $no_resi,
                                                        "kurir" => $kurir,
                                                        "status_pengiriman" => $status_pengiriman,
                                                        "datetime" => $datetime
                                                    ];
                                                    $metadata = [
                                                        "kode_transaksi" => $kode_transaksi,
                                                        "id_member" => $id_member,
                                                        "raw_member" => $raw_member,
                                                        "kategori" => $kategori,
                                                        "datetime" => $datetime_transaksi,
                                                        "jumlah" => $jumlah,
                                                        "status" => $status,
                                                        "transaksi_rincian" => $transaksi_rincian,
                                                        "transaksi_payment" => $transaksi_payment,
                                                        "transaksi_pengiriman" => $transaksi_pengiriman
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
