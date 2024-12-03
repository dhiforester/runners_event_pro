<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Form Assesment Event";

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
                if (!isset($_GET['id'])) {
                    $keterangan = "ID peserta Tidak Boleh Kosong!";
                } else {
                    // Buat Dalam Bentukk Variabel
                    $xtoken = validateAndSanitizeInput($headers['x-token']);
                    $id_event_peserta = validateAndSanitizeInput($_GET['id']);
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
                            
                            //Buka id_event
                            $id_event=GetDetailData($Conn, 'event_peserta', 'id_event_peserta', $id_event_peserta, 'id_event');
                            if(empty($id_event)){
                                $keterangan = "ID Peserta Event Tidak Valid";
                            }else{
                                $id_event_kategori=GetDetailData($Conn, 'event_peserta', 'id_event_peserta', $id_event_peserta, 'id_event_kategori');
                                // Persiapkan Query untuk Mengambil Form Assesment
                                $QryFormAssesment = $Conn->prepare("SELECT * FROM event_assesment_form WHERE id_event = ? ORDER BY form_name ASC");
                                $QryFormAssesment->bind_param("s", $id_event);
                                $QryFormAssesment->execute();
                                $ResultFormAssesment = $QryFormAssesment->get_result();
                                while ($DataFormAssesment = $ResultFormAssesment->fetch_assoc()) {
                                    $id_event_assesment_form=$DataFormAssesment['id_event_assesment_form'];
                                    $form_name=$DataFormAssesment['form_name'];
                                    $form_type=$DataFormAssesment['form_type'];
                                    $mandatori=$DataFormAssesment['mandatori'];
                                    $alternatif=$DataFormAssesment['alternatif'];
                                    $komentar=$DataFormAssesment['komentar'];
                                    $kategori_list=$DataFormAssesment['kategori_list'];
                                    // Pastikan kategori_list adalah string JSON valid
                                    if (!empty($kategori_list)) {
                                        $kategori_array = json_decode($kategori_list, true);
                                        // Jika decoding gagal, gunakan array kosong
                                        if (!is_array($kategori_array)) {
                                            $kategori_array = [];
                                        }
                                    } else {
                                        $kategori_array = [];
                                    }
                                    if(!empty($alternatif)){
                                        $alternatif=json_decode($alternatif, true);
                                    }
                                    if(in_array($id_event_kategori, $kategori_array)){
                                        // Add to array
                                        $metadata[] = [
                                            "id_event_assesment_form" => $id_event_assesment_form,
                                            "form_name" => $form_name,
                                            "form_type" => $form_type,
                                            "mandatori" => $mandatori,
                                            "alternatif" => $alternatif,
                                            "komentar" => $komentar
                                        ];
                                    }
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
