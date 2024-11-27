<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Generate Snap Token Pembelian";
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

                // Validasi kelengkapan data tidak boleh kosong
                if (!isset($Tangkap['email'])) {
                    $keterangan = "Email Tidak Boleh Kosong";
                } else if (!isset($Tangkap['id_member_login'])) {
                    $keterangan = "ID Member Login Tidak Boleh Kosong";
                } else if (!isset($Tangkap['kode_transaksi'])) {
                    $keterangan = "Kode Transaksi Tidak Boleh Kosong";
                } else {
                    // Buat Variabel
                    $xtoken = validateAndSanitizeInput($headers['x-token']);
                    $email = validateAndSanitizeInput($Tangkap['email']);
                    $id_member_login = validateAndSanitizeInput($Tangkap['id_member_login']);
                    $kode_transaksi = validateAndSanitizeInput($Tangkap['kode_transaksi']);
                    //Validasi Tipe Dan Karakter Data
                    if (strlen($Tangkap['id_member_login']) > 36) { 
                        $ValidasiJumlahKarakter= 'ID Login Tidak Valid Karena Terlalu Panjang'; 
                    }else{
                        if (strlen($Tangkap['kode_transaksi']) > 36) { 
                            $ValidasiJumlahKarakter= 'Kode Transaksi Tidak Valid Karena Terlalu Panjang'; 
                        }else{
                            $ValidasiJumlahKarakter='Valid'; 
                        }
                    }
                    if($ValidasiJumlahKarakter!=="Valid"){
                        $keterangan = $ValidasiJumlahKarakter;
                    }else{
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
                                
                                // Validasi Email dan Password
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
                                        //Validasi kode_transaksi
                                        $ValidasiKodeTransaksi=GetDetailData($Conn, 'transaksi', 'kode_transaksi', $kode_transaksi, 'kode_transaksi');
                                        if(empty($ValidasiKodeTransaksi)){
                                            $keterangan="Kode Transaksi Event Tidak Valid";
                                        }else{
                                            //Buka Informasi Member
                                            $id_member=GetDetailData($Conn, 'transaksi', 'kode_transaksi', $kode_transaksi, 'id_member');
                                            $raw_member=GetDetailData($Conn, 'transaksi', 'kode_transaksi', $kode_transaksi, 'raw_member');
                                            $jumlah=GetDetailData($Conn, 'transaksi', 'kode_transaksi', $kode_transaksi, 'jumlah');
                                            //Apabila Kode Transaksi Tidak Ada
                                            if(empty($jumlah)){
                                                $keterangan="Tidak ada jumlah uang yang harus dibayar";
                                            }else{
                                                $datetime=GetDetailData($Conn, 'transaksi', 'kode_transaksi', $kode_transaksi, 'datetime');
                                                $jumlah=GetDetailData($Conn, 'transaksi', 'kode_transaksi', $kode_transaksi, 'jumlah');
                                                $status=GetDetailData($Conn, 'transaksi', 'kode_transaksi', $kode_transaksi, 'status');
                                                //Buka Raw Member
                                                $array=json_decode($raw_member, true);
                                                $nama=$array['nama'];
                                                $email=$array['email'];
                                                $kontak=$array['kontak'];
                                                $id_member=$array['id_member'];
                                                $last_name=$array['last_name'];
                                                $first_name=$array['first_name'];
                                                // Ambil Server Key dan Production dari database
                                                $api_key = GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'api_key');
                                                $server_key = GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'server_key');
                                                $production = GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'production');
                                                $api_payment_url =GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'api_payment_url');
                                                //Buka Pengaturan
                                                $urll_call_back=GetDetailData($Conn,'setting_payment','id_setting_payment ','1','urll_call_back');
                                                $id_marchant=GetDetailData($Conn,'setting_payment','id_setting_payment ','1','id_marchant');
                                                $client_key=GetDetailData($Conn,'setting_payment','id_setting_payment ','1','client_key');
                                                $snap_url=GetDetailData($Conn,'setting_payment','id_setting_payment ','1','snap_url');
                                                $production=GetDetailData($Conn,'setting_payment','id_setting_payment ','1','production');
                                                $aktif_payment_gateway=GetDetailData($Conn,'setting_payment','id_setting_payment ','1','aktif_payment_gateway');
                                                //Buat Snap Token
                                                $order_id=GenerateToken(32);
                                                // Set header
                                                $headers = array(
                                                    'Content-Type: Application/x-www-form-urlencoded',
                                                );
                                                // Array data untuk dikirim via CURL
                                                $order = array(
                                                    "order_id" => $order_id,
                                                    "gross_amount" => $jumlah,
                                                    "first_name" => $first_name,
                                                    "last_name" => $last_name,
                                                    "email" => $email,
                                                    "phone" => $kontak,
                                                    "kode_transaksi" => $kode_transaksi,
                                                );
                                                $arr = array(
                                                    "api_key" => $api_key,
                                                    "order" => $order
                                                );
                                                $json = json_encode($arr);

                                                // CURL init
                                                $curl = curl_init();
                                                curl_setopt($curl, CURLOPT_URL, "$api_payment_url/GenerateSnapToken.php");
                                                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                                                curl_setopt($curl, CURLOPT_TIMEOUT, 10); // Timeout lebih lama
                                                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                                                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                                                curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
                                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                                                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                                                // Eksekusi CURL dan cek error
                                                $response_curl = curl_exec($curl);
                                                if ($response_curl === false) {
                                                    $response_service= 'CURL Error: ' . curl_error($curl);
                                                } else {
                                                    $data = json_decode($response_curl, true); // Decode response JSON
                                                    if (json_last_error() === JSON_ERROR_NONE) {
                                                        $code_service = $data["code"];
                                                        if ($code_service == "200") {
                                                            $response_service= 'success';
                                                            $snap_token= $data["token"];
                                                        } else {
                                                            $response_service= 'Snap Token Gagal Dibuat! Kode: ' . $code;
                                                        }
                                                    } else {
                                                        $response_service= 'Error pada decoding JSON: '.$response_curl.' ' . json_last_error_msg();
                                                    }
                                                }
                                                // Tutup CURL
                                                curl_close($curl);
                                                //Apabila Response Gagal
                                                if($response_service!=="success"){
                                                    $keterangan=$response_service;
                                                }else{
                                                    $status="Pending";
                                                    //Simpan Ke dalam Transaksi Paymenta
                                                    $query = "INSERT INTO transaksi_payment (
                                                        kode_transaksi, 
                                                        order_id, 
                                                        snap_token, 
                                                        datetime, 
                                                        status
                                                    ) VALUES (
                                                        ?,  
                                                        ?, 
                                                        ?, 
                                                        ?,  
                                                        ?
                                                    )";
                                                    $stmt = $Conn->prepare($query);
                                                    $stmt->bind_param(
                                                        "sssss", 
                                                        $kode_transaksi, 
                                                        $order_id, 
                                                        $snap_token, 
                                                        $now, 
                                                        $status
                                                    );
                                                    if ($stmt->execute()) {
                                                        $metadata= [
                                                            "kode_transaksi" => $kode_transaksi,
                                                            "order_id" => $order_id,
                                                            "snap_token" => $snap_token,
                                                            "datetime" => $now,
                                                            "status" => $status
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
                                                        $keterangan = "Terjadi kesalahan pada saat menyimpan data pembayaran";
                                                        $code = 201;
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
