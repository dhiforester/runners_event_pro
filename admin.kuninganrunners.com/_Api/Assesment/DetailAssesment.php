<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Detail Assesment";
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
                if (!isset($Tangkap['id_event_assesment_form'])) {
                    $keterangan = "ID Assesment Form Tidak Boleh Kosong";
                } else if (!isset($Tangkap['id_event_peserta'])) {
                    $keterangan = "ID Peserta Event Tidak Boleh Kosong";
                } else {
                    // Buat Variabel
                    $xtoken = validateAndSanitizeInput($headers['x-token']);
                    $id_event_assesment_form = validateAndSanitizeInput($Tangkap['id_event_assesment_form']);
                    $id_event_peserta = validateAndSanitizeInput($Tangkap['id_event_peserta']);
                    //Validasi Tipe Dan Karakter Data
                    if (strlen($Tangkap['id_event_assesment_form']) > 36) { 
                        $ValidasiJumlahKarakter= 'ID Assesment Form Tidak Valid Karena Terlalu Panjang'; 
                    }else{
                        if (strlen($Tangkap['id_event_peserta']) > 36) { 
                            $ValidasiJumlahKarakter= 'ID Peserta Tidak Valid Karena Terlalu Panjang'; 
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
                                //Validasi id_event_assesment_form
                                $ValidasiAssesmentForm=GetDetailData($Conn, 'event', 'event_assesment_form', $id_event_assesment_form, 'id_event_assesment_form');
                                if(empty($ValidasiAssesmentForm)){
                                    $ValidasiKebenaranData="ID Form Tidak Valid";
                                }else{
                                    //Validasi Peserta
                                    $ValidasiIdPeserta=GetDetailData($Conn, 'event_peserta', 'id_event_peserta', $id_event_peserta, 'id_event_peserta');
                                    if(empty($ValidasiIdPeserta)){
                                        $ValidasiKebenaranData="ID Peserta Tidak Valid";
                                    }else{
                                        $ValidasiKebenaranData="Valid";
                                    }
                                }
                                if($ValidasiKebenaranData!=="Valid"){
                                    $keterangan =$ValidasiKebenaranData;
                                }else{
                                    $ValidasiDetailData="Valid";
                                    //Buka Detail Data
                                    $QryEventAssesment = $Conn->prepare("SELECT * FROM event_assesment WHERE id_event_peserta = ? AND id_event_assesment_form = ?");
                                    if ($QryEventAssesment === false) {
                                        $ValidasiDetailData="Terjadi Kesalahan Pada Saat Membuka Event Assesment";
                                    }
                                    // Bind parameter
                                    $QryEventAssesment->bind_param("ss", $id_event_peserta, $id_event_assesment_form);
                                    // Eksekusi query
                                    if (!$QryEventAssesment->execute()) {
                                        $ValidasiDetailData="Terjadi Kesalahan Pada Saat Membuka ID Dari Database";
                                    }
                                    // Mengambil hasil
                                    $ResultAssesment = $QryEventAssesment->get_result();
                                    $DataAssesment = $ResultAssesment->fetch_assoc();
                                    // Menutup statement
                                    $QryEventAssesment->close();
                                    //Apabila Validasi Peserta Tidak Valid
                                    if($ValidasiDetailData!=="Valid"){
                                        $keterangan=$ValidasiPeserta;
                                    }else{
                                        $assesment_value=$DataAssesment['assesment_value'];
                                        $status_assesment=$DataAssesment['status_assesment'];
                                        $form_type=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'form_type');
                                        //Buat JSON Status
                                        $status_assesment=json_decode($status_assesment, true);
                                        //Sesuaikan assesment_value berdasarkan type
                                        if($form_type=="checkbox"){
                                            $assesment_value=json_decode($assesment_value, true);
                                        }
                                        if($form_type=="file_foto"){
                                            if(!empty($assesment_value)){
                                                $assesment_value="$base_url/assets/img/Assesment/$assesment_value";
                                            }else{
                                                $assesment_value="";
                                            }
                                            
                                        }
                                        if($form_type=="file_pdf"){
                                            if(!empty($assesment_value)){
                                                $assesment_value="$base_url/assets/img/Assesment/$assesment_value";
                                            }else{
                                                $assesment_value="";
                                            }
                                        }
                                        $metadata=[
                                            "id_event_assesment_form" => $id_event_assesment_form,
                                            "id_event_peserta" => $id_event_peserta,
                                            "form_type" => $form_type,
                                            "assesment_value" => $assesment_value,
                                            "status_assesment" => $status_assesment
                                        ];
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
