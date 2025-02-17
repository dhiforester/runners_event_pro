<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Setting Web";

    // Setting default response
    $code = 201;
    $keterangan = "Terjadi kesalahan";
    $metadata = [];

    // Validasi Metode Pengiriman Data
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        $keterangan = "Metode Pengiriman Data Hanya Boleh Menggunakan GET";
    } else {
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
                        
                        //Membuka Pengaturan Website
                        $web_url=GetDetailData($Conn, 'web_setting', 'id_web_setting', '1', 'base_url');
                        $web_pavicon=GetDetailData($Conn, 'web_setting', 'id_web_setting', '1', 'pavicon');
                        $web_icon=GetDetailData($Conn, 'web_setting', 'id_web_setting', '1', 'icon');
                        $web_title=GetDetailData($Conn, 'web_setting', 'id_web_setting', '1', 'title');
                        $web_description=GetDetailData($Conn, 'web_setting', 'id_web_setting', '1', 'description');
                        $web_keyword=GetDetailData($Conn, 'web_setting', 'id_web_setting', '1', 'keyword');
                        $web_author=GetDetailData($Conn, 'web_setting', 'id_web_setting', '1', 'author');
                        //Membuka Tentang
                        $JudulTentang=GetDetailData($Conn, 'web_tentang', 'id_web_tentang', '1', 'judul');
                        $PreviewTentang=GetDetailData($Conn, 'web_tentang', 'id_web_tentang', '1', 'tentang');
                        //Pengaturan Payment
                        $api_key = GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'api_key');
                        $server_key = GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'server_key');
                        $production = GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'production');
                        $api_payment_url =GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'api_payment_url');
                        $urll_call_back=GetDetailData($Conn,'setting_payment','id_setting_payment ','1','urll_call_back');
                        $id_marchant=GetDetailData($Conn,'setting_payment','id_setting_payment ','1','id_marchant');
                        $client_key=GetDetailData($Conn,'setting_payment','id_setting_payment ','1','client_key');
                        $snap_url=GetDetailData($Conn,'setting_payment','id_setting_payment ','1','snap_url');
                        $production=GetDetailData($Conn,'setting_payment','id_setting_payment ','1','production');
                        $aktif_payment_gateway=GetDetailData($Conn,'setting_payment','id_setting_payment ','1','aktif_payment_gateway');
                        //Buat Array Konten Tentang
                        $KontenTentang = [
                            "judul" => $JudulTentang,
                            "preview" => $PreviewTentang,
                        ];
                        //Membuka Kontak
                        $KontakWeb = [
                            "alamat" => $alamat_bisnis,
                            "email" => $email_bisnis,
                            "telepon" => $telepon_bisnis
                        ];
                        //Menampilkan Pengaturan Payment
                        $payment_setting = [
                            "api_key" => $api_key,
                            "production" => $production,
                            "api_payment_url" => $api_payment_url,
                            "client_key" => $client_key,
                            "snap_url" => $snap_url,
                            "production" => $production,
                            "aktif_payment_gateway" => $aktif_payment_gateway
                        ];
                        //Mempersiapkan Metadata
                        $metadata = [
                            "base_url" => $web_url,
                            "pavicon" => "$base_url/assets/img/Web/$web_pavicon",
                            "icon" => "$base_url/assets/img/Web/$web_icon",
                            "title" => $web_title,
                            "description" => $web_description,
                            "keyword" => $web_keyword,
                            "x-author" => $web_author,
                            "tentang" => $KontenTentang,
                            "kontak" => $KontakWeb,
                            "payment_setting" => $payment_setting
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
