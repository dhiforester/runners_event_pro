<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Detail Event";

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
                        if(empty($_GET['id'])){
                            $keterangan = "ID Event Tidak Boleh Kosong!";
                        }else{
                            $id_event = validateAndSanitizeInput($_GET['id']);
                            // Validasi ID Event
                            $id_event_validasi=GetDetailData($Conn,'event','id_event',$id_event,'id_event');
                            if(empty($id_event_validasi)){
                                $keterangan = "ID Event Tidak Valid";
                            }else{
                                //Buka Detail Event
                                $tanggal_mulai=GetDetailData($Conn,'event','id_event',$id_event,'tanggal_mulai');
                                $tanggal_selesai=GetDetailData($Conn,'event','id_event',$id_event,'tanggal_selesai');
                                $mulai_pendaftaran=GetDetailData($Conn,'event','id_event',$id_event,'mulai_pendaftaran');
                                $selesai_pendaftaran=GetDetailData($Conn,'event','id_event',$id_event,'selesai_pendaftaran');
                                $nama_event=GetDetailData($Conn,'event','id_event',$id_event,'nama_event');
                                $keterangan=GetDetailData($Conn,'event','id_event',$id_event,'keterangan');
                                $poster=GetDetailData($Conn,'event','id_event',$id_event,'poster');
                                $rute=GetDetailData($Conn,'event','id_event',$id_event,'rute');
                                //Buat List Kategori
                                $kategori=[];
                                $QryKategori = $Conn->prepare("SELECT * FROM event_kategori WHERE id_event >= ? ORDER BY id_event_kategori ASC");
                                $QryKategori->bind_param("s", $id_event);
                                $QryKategori->execute();
                                $ResultKategori = $QryKategori->get_result();
                                while ($DataKategori = $ResultKategori->fetch_assoc()) {
                                    $id_event_kategori=$DataKategori['id_event_kategori'];
                                    $kategori_list=$DataKategori['kategori'];
                                    if(empty($DataKategori['deskripsi'])){
                                        $deskripsi_list="";
                                    }else{
                                        $deskripsi_list=$DataKategori['deskripsi'];
                                    }
                                    if(empty($DataKategori['biaya_pendaftaran'])){
                                        $biaya_pendaftaran_list="";
                                    }else{
                                        $biaya_pendaftaran_list=$DataKategori['biaya_pendaftaran'];
                                    }
                                    $kategori[] = [
                                        "id_event_kategori" => $id_event_kategori,
                                        "kategori" => $kategori_list,
                                        "deskripsi" => $deskripsi_list,
                                        "biaya_pendaftaran" => $biaya_pendaftaran_list
                                    ];
                                }
                                $metadata= [
                                    "id_event" => $id_event,
                                    "tanggal_mulai" => $tanggal_mulai,
                                    "tanggal_selesai" => $tanggal_selesai,
                                    "mulai_pendaftaran" => $mulai_pendaftaran,
                                    "selesai_pendaftaran" => $selesai_pendaftaran,
                                    "nama_event" => $nama_event,
                                    "keterangan" => $keterangan,
                                    "poster" => "$base_url/assets/img/Poster/$poster",
                                    "rute" => "$base_url/assets/img/Rute/$rute",
                                    "kategori" => $kategori
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
