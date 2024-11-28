<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Riwayat Transaksi Peserta";
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
                    $keterangan = "ID Login Tidak Boleh Kosong";
                }else if (!isset($Tangkap['id_event_peserta'])) {
                    $keterangan = "ID Peserta Event Tidak Boleh Kosong";
                } else {
                    // Buat Variabel
                    $xtoken = validateAndSanitizeInput($headers['x-token']);
                    $email = validateAndSanitizeInput($Tangkap['email']);
                    $id_member_login = validateAndSanitizeInput($Tangkap['id_member_login']);
                    $id_event_peserta = validateAndSanitizeInput($Tangkap['id_event_peserta']);
                        
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
                                    //Buka Email Di Database
                                    $email_member=GetDetailData($Conn, 'member', 'id_member', $id_member, 'email');
                                    //Cek Apakah Email Sesuai
                                    if($email_member!==$email){
                                        $keterangan = "Email dengan ID Login Tidak Sesuai ($email_member | $email)";
                                    }else{
                                        $nama=GetDetailData($Conn, 'member', 'id_member', $id_member, 'nama');
                                        //Apakah Yang Bersangkutan Punya Riwayat Transaksi
                                        $kode_transaksi = GetDetailData($Conn, 'transaksi', 'kode_transaksi', $id_event_peserta, 'kode_transaksi');
                                        if(empty($kode_transaksi)){
                                            $keterangan = "Belum Ada Data Tagihan Pembayaran. Pendaftaran Peserta Masih Dalam Peninjauan";
                                        }else{
                                            $raw_member = GetDetailData($Conn, 'transaksi', 'kode_transaksi', $id_event_peserta, 'raw_member');
                                            $kategori = GetDetailData($Conn, 'transaksi', 'kode_transaksi', $id_event_peserta, 'kategori');
                                            $datetime = GetDetailData($Conn, 'transaksi', 'kode_transaksi', $id_event_peserta, 'datetime');
                                            $subtotal = GetDetailData($Conn, 'transaksi', 'kode_transaksi', $id_event_peserta, 'tagihan');
                                            $ongkir = GetDetailData($Conn, 'transaksi', 'kode_transaksi', $id_event_peserta, 'ongkir');
                                            $ppn_pph = GetDetailData($Conn, 'transaksi', 'kode_transaksi', $id_event_peserta, 'ppn_pph');
                                            $biaya_layanan = GetDetailData($Conn, 'transaksi', 'kode_transaksi', $id_event_peserta, 'biaya_layanan');
                                            $biaya_lainnya = GetDetailData($Conn, 'transaksi', 'kode_transaksi', $id_event_peserta, 'biaya_lainnya');
                                            $potongan_lainnya = GetDetailData($Conn, 'transaksi', 'kode_transaksi', $id_event_peserta, 'potongan_lainnya');
                                            $jumlah = GetDetailData($Conn, 'transaksi', 'kode_transaksi', $id_event_peserta, 'jumlah');
                                            $status = GetDetailData($Conn, 'transaksi', 'kode_transaksi', $id_event_peserta, 'status');
                                            //Konversi JSON Raw Ke Array
                                            $raw_member_arry =json_decode($raw_member, true);
                                            $biaya_lainnya_arry =json_decode($biaya_lainnya, true);
                                            $potongan_lainnya_arry =json_decode($potongan_lainnya, true);
                                            //Apabila Ada Data Transaksi
                                            $metadata= [
                                                "kode_transaksi" => $kode_transaksi,
                                                "raw_member" => $raw_member_arry,
                                                "kategori" => $kategori,
                                                "datetime" => $datetime,
                                                "subtotal" => $subtotal,
                                                "ongkir" => $ongkir,
                                                "ppn_pph" => $ppn_pph,
                                                "biaya_layanan" => $biaya_layanan,
                                                "biaya_lainnya" => $biaya_lainnya_arry,
                                                "potongan_lainnya" => $potongan_lainnya_arry,
                                                "jumlah" => $jumlah,
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
                                        }
                                    }
                                }
                            } else {
                                $keterangan = "ID Login Tidak Valid";
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
