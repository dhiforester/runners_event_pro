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
                                                //Buka Data Transaksi
                                                $kategori_transaksi="Pembelian";
                                                $stmt_transaksi = $Conn->prepare("SELECT * FROM transaksi WHERE kode_transaksi=? AND id_member=? AND kategori=?");
                                                $stmt_transaksi->bind_param("sss", $kode_transaksi, $id_member, $kategori_transaksi);
                                                $stmt_transaksi->execute();
                                                $result_transaksi = $stmt_transaksi->get_result();
                                                $DataTransaksi = $result_transaksi->fetch_assoc();
                                                if (empty($DataTransaksi['kode_transaksi'])) {
                                                    $keterangan = "Kode Transaksi Yang Anda Gunakan Tidak Valid";
                                                }else{
                                                    $raw_member =$DataTransaksi['raw_member'];
                                                    $kategori =$DataTransaksi['kategori'];
                                                    $datetime_transaksi =$DataTransaksi['datetime'];
                                                    $tagihan =$DataTransaksi['tagihan'];
                                                    $ongkir =$DataTransaksi['ongkir'];
                                                    $ppn_pph =$DataTransaksi['ppn_pph'];
                                                    $biaya_layanan =$DataTransaksi['biaya_layanan'];
                                                    $biaya_lainnya =$DataTransaksi['biaya_lainnya'];
                                                    $potongan_lainnya =$DataTransaksi['potongan_lainnya'];
                                                    $jumlah_total =$DataTransaksi['jumlah'];
                                                    $pengiriman =$DataTransaksi['pengiriman'];
                                                    $status =$DataTransaksi['status'];
                                                    //Ubah Biaya lain-lain menjadi arry
                                                    $biaya_lainnya_arry=json_decode($biaya_lainnya,true);
                                                    //Ubah Potongan lain-lain menjadi arry
                                                    $potongan_lainnya_arry=json_decode($potongan_lainnya,true);
                                                    //Ubah Raw Member Menjadi Array
                                                    $raw_member=json_decode($raw_member, true);
                                                    
                                                    //Buka Data Rincian
                                                    $transaksi_rincian=[];
                                                    $QryTransaksiRincian = mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE kode_transaksi='$kode_transaksi'");
                                                    while ($DataTransaksiRincian = mysqli_fetch_array($QryTransaksiRincian)) {
                                                        $id_transaksi_rincian= $DataTransaksiRincian['id_transaksi_rincian'];
                                                        $id_barang= $DataTransaksiRincian['id_barang'];
                                                        $nama_barang= $DataTransaksiRincian['nama_barang'];
                                                        $varian= $DataTransaksiRincian['varian'];
                                                        $harga= $DataTransaksiRincian['harga'];
                                                        $qty= $DataTransaksiRincian['qty'];
                                                        $jumlah= $DataTransaksiRincian['jumlah'];
                                                        //Ubah Uraian Menjadi Array
                                                        $varian=json_decode($varian, true);
                                                        //Buat Transaksi Rincian
                                                        $transaksi_rincian[]= [
                                                            "id_transaksi_rincian" => $id_transaksi_rincian,
                                                            "id_barang" => $id_barang,
                                                            "nama_barang" => $nama_barang,
                                                            "varian" => $varian,
                                                            "harga" => $harga,
                                                            "qty" => $qty,
                                                            "jumlah" => $jumlah
                                                        ];
                                                    }
                                                    
                                                    //Buka Transaksi Payment
                                                    $transaksi_payment=[];
                                                    $QryPayment = mysqli_query($Conn, "SELECT*FROM transaksi_payment WHERE kode_transaksi='$kode_transaksi'");
                                                    while ($DataPayment = mysqli_fetch_array($QryPayment)) {
                                                        $id_transaksi_payment =$DataPayment['id_transaksi_payment'];
                                                        $order_id =$DataPayment['order_id'];
                                                        $snap_token =$DataPayment['snap_token'];
                                                        $datetime_payment =$DataPayment['datetime'];
                                                        $status_payment =$DataPayment['status'];
                                                        //Cek Status Pembayaran Dari Payment Gateway
                                                        $api_key = GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'api_key');
                                                        $server_key = GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'server_key');
                                                        $production = GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'production');
                                                        $api_payment_url =GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'api_payment_url');
                                                        //Persiapkan request ke payment gateway
                                                        $update_process_transaksi_payment="No Process";
                                                        $update_process_transaksi="No Process";
                                                        $cek_status_transaksi=transaction_status_by_order_id($api_payment_url, $api_key, $order_id);
                                                        $arry_status_transaksi=json_decode($cek_status_transaksi,true);
                                                        if(!empty($arry_status_transaksi)){
                                                            if(!empty($arry_status_transaksi['response'])){
                                                                if($arry_status_transaksi['response']['code']==200){
                                                                    //Buka metadatanya
                                                                    if(!empty($arry_status_transaksi['metadata'])){
                                                                        if(!empty($arry_status_transaksi['metadata']['transaction_status'])){
                                                                            $resume_cek_status_transaksi=$arry_status_transaksi['metadata']['transaction_status'];
                                                                            //Apabiiila resume status diketahui settlement maka update transaksi
                                                                            if($resume_cek_status_transaksi=="settlement"){
                                                                                //Melakukan Update 'transaksi_payment' Jika status belum Lunas
                                                                                $status2 =GetDetailData($Conn,'transaksi_payment','order_id',$order_id,'status');
                                                                                if($status2!=="Lunas"){
                                                                                    $update_transaksi_payment = mysqli_query($Conn,"UPDATE transaksi_payment SET 
                                                                                        status='Lunas'
                                                                                    WHERE order_id='$order_id'") or die(mysqli_error($Conn)); 
                                                                                    if($update_transaksi_payment){
                                                                                        $update_process_transaksi_payment="Success";
                                                                                    }else{
                                                                                        $update_process_transaksi_payment="Error Update 'transaksi_payment' table";
                                                                                    }
                                                                                }
                                                                                //Melakukan Update 'transaksi' Jika status belum Lunas
                                                                                $status3 =GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'status');
                                                                                if($status3!=="Lunas"){
                                                                                    $update_transaksi = mysqli_query($Conn,"UPDATE transaksi SET 
                                                                                        status='Lunas'
                                                                                    WHERE kode_transaksi='$kode_transaksi'") or die(mysqli_error($Conn)); 
                                                                                    if($update_transaksi){
                                                                                        $update_process_transaksi="Success";
                                                                                    }else{
                                                                                        $update_process_transaksi="Error Update 'transaksi_payment' table";
                                                                                    }
                                                                                }
                                                                            }
                                                                        }else{
                                                                            $resume_cek_status_transaksi="No Response 005";
                                                                        }
                                                                    }else{
                                                                        $resume_cek_status_transaksi="No Response 004";
                                                                    }
                                                                }else{
                                                                    $resume_cek_status_transaksi="No Response 003";
                                                                }
                                                            }else{
                                                                $resume_cek_status_transaksi="No Response 002";
                                                            }
                                                        }else{
                                                            $resume_cek_status_transaksi="No Response 001";
                                                        }
                                                        //Buat Transaksi Payment
                                                        $transaksi_payment[]= [
                                                            "id_transaksi_payment" => $id_transaksi_payment,
                                                            "order_id" => $order_id,
                                                            "snap_token" => $snap_token,
                                                            "datetime" => $datetime_payment,
                                                            "status" => $status_payment,
                                                            "cek_status_transaksi" => $resume_cek_status_transaksi,
                                                            "update_process_transaksi_payment" => $update_process_transaksi_payment,
                                                            "update_process_transaksi" => $update_process_transaksi,
                                                        ];
                                                    }
                                                    
                                                    //Buka Transaksi Pengiriman
                                                    $stmt_pengriman = $Conn->prepare("SELECT * FROM transaksi_pengiriman WHERE kode_transaksi=?");
                                                    $stmt_pengriman->bind_param("s", $kode_transaksi);
                                                    $stmt_pengriman->execute();
                                                    $result_pengiriman = $stmt_pengriman->get_result();
                                                    $data_pengiriman = $result_pengiriman->fetch_assoc();
                                                    $id_transaksi_pengiriman =$data_pengiriman['id_transaksi_pengiriman'];
                                                    $no_resi =$data_pengiriman['no_resi'];
                                                    $kurir =$data_pengiriman['kurir'];
                                                    $asal_pengiriman =$data_pengiriman['asal_pengiriman'];
                                                    $tujuan_pengiriman =$data_pengiriman['tujuan_pengiriman'];
                                                    $ongkir =$data_pengiriman['ongkir'];
                                                    $status_pengiriman =$data_pengiriman['status_pengiriman'];
                                                    $datetime_pengiriman =$data_pengiriman['datetime_pengiriman'];
                                                    $link_pengiriman =$data_pengiriman['link_pengiriman'];
                                                    //Ubah Asal Pengiriman Menjadi Arry
                                                    $asal_pengiriman_arry=json_decode($asal_pengiriman,true);
                                                    $tujuan_pengiriman_arry=json_decode($tujuan_pengiriman,true);
                                                    //Buat Transaksi Payment
                                                    $transaksi_pengiriman= [
                                                        "id_transaksi_pengiriman" => $id_transaksi_pengiriman,
                                                        "no_resi" => $no_resi,
                                                        "kurir" => $kurir,
                                                        "asal_pengiriman" => $asal_pengiriman_arry,
                                                        "tujuan_pengiriman" => $tujuan_pengiriman_arry,
                                                        "status_pengiriman" => $status_pengiriman,
                                                        "datetime_pengiriman" => $datetime_pengiriman,
                                                        "link_pengiriman" => $link_pengiriman
                                                    ];
                                                    $metadata = [
                                                        "kode_transaksi" => $kode_transaksi,
                                                        "id_member" => $id_member,
                                                        "raw_member" => $raw_member,
                                                        "kategori" => $kategori,
                                                        "datetime" => $datetime_transaksi,
                                                        "tagihan" => $tagihan,
                                                        "ongkir" => $ongkir,
                                                        "ppn_pph" => $ppn_pph,
                                                        "biaya_layanan" => $biaya_layanan,
                                                        "biaya_lainnya" => $biaya_lainnya_arry,
                                                        "potongan_lainnya" => $potongan_lainnya_arry,
                                                        "jumlah" => $jumlah_total,
                                                        "pengiriman" => $pengiriman,
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
