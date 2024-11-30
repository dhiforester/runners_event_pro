<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Detail Event Peserta";

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
                            $id_event_peserta = validateAndSanitizeInput($_GET['id']);
                            // Validasi ID Event
                            $id_event_peserta_validasi=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event_peserta');
                            if(empty($id_event_peserta_validasi)){
                                $keterangan = "ID Event Peserta Tidak Valid";
                            }else{
                                //Buka Detail Event
                                $id_event =GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event');
                                $id_event_kategori =GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event_kategori');
                                $nama =GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'nama');
                                $email =GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'email');
                                $biaya_pendaftaran =GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'biaya_pendaftaran');
                                $datetime =GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'datetime');
                                $status =GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'status');
                                //Buka Detail Event
                                $NamaEvent =GetDetailData($Conn,'event','id_event',$id_event,'nama_event');
                                $DeskripsiEvent =GetDetailData($Conn,'event','id_event',$id_event,'keterangan');
                                $tanggal_mulai =GetDetailData($Conn,'event','id_event',$id_event,'tanggal_mulai');
                                $tanggal_selesai =GetDetailData($Conn,'event','id_event',$id_event,'tanggal_selesai');
                                $mulai_pendaftaran =GetDetailData($Conn,'event','id_event',$id_event,'mulai_pendaftaran');
                                $selesai_pendaftaran =GetDetailData($Conn,'event','id_event',$id_event,'selesai_pendaftaran');
                                $sertifikat_event =GetDetailData($Conn,'event','id_event',$id_event,'sertifikat');
                                $sertifikat_event_arry=json_decode($sertifikat_event,true);
                                //Buka Kategori
                                $NamaKategori =GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'kategori');
                                $deskripsi =GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'deskripsi');
                                $biaya_pendaftaran_kategori=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'biaya_pendaftaran');
                                //Buat Detail Kategori
                                $kategori= [
                                    "id_event_kategori" => $id_event_kategori,
                                    "kategori" => $NamaKategori,
                                    "deskripsi" => $deskripsi,
                                    "biaya_pendaftaran" => $biaya_pendaftaran_kategori
                                ];
                                $event= [
                                    "nama_event" => $NamaEvent,
                                    "keterangan" => $DeskripsiEvent,
                                    "tanggal_mulai" => $tanggal_mulai,
                                    "tanggal_selesai" => $tanggal_selesai,
                                    "mulai_pendaftaran" => $mulai_pendaftaran,
                                    "selesai_pendaftaran" => $selesai_pendaftaran,
                                    "sertifikat" => $sertifikat_event_arry
                                ];
                                $metadata= [
                                    "id_event" => $id_event,
                                    "id_event_kategori" => $id_event_kategori,
                                    "nama" => $nama,
                                    "email" => $email,
                                    "biaya_pendaftaran" => $biaya_pendaftaran,
                                    "datetime" => $datetime,
                                    "status" => $status,
                                    "kategori" => $kategori,
                                    "event" => $event
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
