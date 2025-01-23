<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Cari Ongkir";

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
            // Decode Json Data
            $raw = file_get_contents('php://input');
            $Tangkap = json_decode($raw, true);
            
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
                        
                        //Validasi Kelengkapan Data
                        if(empty($Tangkap['id_member_login'])){
                            $keterangan = "Kata Kunci Pencarian Tidak Boleh Kosong";
                        }else{
                            if(empty($Tangkap['id_destination'])){
                                $keterangan = "ID Tujuan Pengiriman Tidak Boleh Kosong!";
                            }else{
                                if(empty($Tangkap['kurir'])){
                                    $keterangan = "Nama Kurir Tidak Boleh Kosong!";
                                }else{
                                    if(empty($Tangkap['berat'])){
                                        $berat =1000;
                                    }else{
                                        $berat =$Tangkap['berat'];
                                        $berat =$berat*1000;
                                    }
                                    $id_member_login=$Tangkap['id_member_login'];
                                    $id_destination=$Tangkap['id_destination'];
                                    $kurir=$Tangkap['kurir'];
                                    $price="lowest";
                                     //Buka Setting Raja Ongkir
                                    $base_url_raja_ongkir=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'base_url');
                                    $api_key=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'api_key');
                                    $password=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'password');
                                    $origin_id=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'origin_id');

                                    //Kirim Data Car Ongkir
                                    $curl = curl_init();
                                    curl_setopt_array($curl, array(
                                        CURLOPT_URL => ''.$base_url_raja_ongkir.'/calculate/domestic-cost',
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => '',
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 0,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => 'POST',
                                        CURLOPT_POSTFIELDS => 'origin='.$origin_id.'&destination='.$id_destination.'&weight='.$berat.'&courier='.$kurir.'&price='.$price.'',
                                        CURLOPT_HTTPHEADER => array(
                                            'key: '.$api_key.'',
                                            'Content-Type: application/x-www-form-urlencoded'
                                        ),
                                        CURLOPT_SSL_VERIFYPEER => false,
                                        CURLOPT_SSL_VERIFYHOST => 0
                                    ));
                                    $response = curl_exec($curl);
                                    curl_close($curl);
                                    $response_arry =json_decode($response,true);
                                    if($response_arry['meta']['code']!==200){
                                        $keterangan = $response_arry['meta']['message'];
                                        $code = 201;
                                    }else{
                                        // Add to array
                                        $metadata= $response_arry['data'];
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
