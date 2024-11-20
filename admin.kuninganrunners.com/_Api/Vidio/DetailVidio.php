<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Detail Vidio";

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
                        //ID Tidak Boleh Kosong!
                        if(empty($_GET['id'])){
                            $keterangan = "ID Vidio Tidak Boleh Kosong!";
                        }else{
                            $id_web_vidio = validateAndSanitizeInput($_GET['id']);
                            // Validasi ID Event
                            $id_web_vidio_validasi=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'id_web_vidio');
                            if(empty($id_web_vidio_validasi)){
                                $keterangan = "ID Vidio Tidak Valid";
                            }else{
                                $sumber_vidio=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'sumber_vidio');
                                $title_vidio=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'title_vidio');
                                $deskripsi=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'deskripsi');
                                $vidio=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'vidio');
                                $datetime=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'datetime');
                                $strtotime1=strtotime($datetime);
                                $DatetimeFormat=date('d M Y H:i',$strtotime1);
                                //Url Image
                                if($sumber_vidio=="Local"){
                                    $GaleriPath="$base_url/_Api/Vidio/VidioProxy.php?vidio=$vidio";
                                }else{
                                    if($sumber_vidio=="Url"){
                                        $GaleriPath=$vidio;
                                    }else{
                                        // Regex untuk mengekstrak nilai src
                                        preg_match('/src="([^"]+)"/', $vidio, $matches);
                                        // Cek apakah src ditemukan
                                        if (isset($matches[1])) {
                                            $GaleriPath = $matches[1];
                                        } else {
                                            $GaleriPath="";
                                        }
                                    }
                                }
                                $iframe='<iframe width="100%" height="350" src="'.$GaleriPath.'" title="'.$title_vidio.'" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
                                $metadata= [
                                    "id_web_vidio" => $id_web_vidio,
                                    "title_vidio" => $title_vidio,
                                    "deskripsi" => $deskripsi,
                                    "datetime" => $datetime,
                                    "iframe" => $iframe,
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
