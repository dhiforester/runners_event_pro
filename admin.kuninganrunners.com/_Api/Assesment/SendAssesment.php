<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Kirim Assesment";
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
                } else if (!isset($Tangkap['password'])) {
                    $keterangan = "Password Tidak Boleh Kosong";
                } else if (!isset($Tangkap['id_event'])) {
                    $keterangan = "ID Event Tidak Boleh Kosong";
                } else if (!isset($Tangkap['id_event_assesment_form'])) {
                    $keterangan = "ID Assesment Form Tidak Boleh Kosong";
                } else if (!isset($Tangkap['form_value'])) {
                    $keterangan = "Nilai/Isi Form Tidak Boleh Kosong";
                } else {
                    // Buat Variabel
                    $xtoken = validateAndSanitizeInput($headers['x-token']);
                    $email = validateAndSanitizeInput($Tangkap['email']);
                    $password = validateAndSanitizeInput($Tangkap['password']);
                    $id_event = validateAndSanitizeInput($Tangkap['id_event']);
                    $id_event_assesment_form = validateAndSanitizeInput($Tangkap['id_event_assesment_form']);
                    $form_value =$Tangkap['form_value'];
                    //Validasi Tipe Dan Karakter Data
                    if (strlen($Tangkap['id_event']) > 36) { 
                        $ValidasiJumlahKarakter= 'ID Event Tidak Valid Karena Terlalu Panjang'; 
                    }else{
                        if (strlen($Tangkap['id_event_assesment_form']) > 36) { 
                            $ValidasiJumlahKarakter= 'ID Assesment Form Tidak Valid Karena Terlalu Panjang'; 
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
                                $stmt = $Conn->prepare("SELECT * FROM member WHERE email = ?");
                                $stmt->bind_param("s", $email);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $DataMember = $result->fetch_assoc();

                                if ($DataMember && password_verify($password, $DataMember['password'])) {
                                    if ($DataMember['status'] !== "Active") {
                                        $keterangan = "Member Belum Melakukan Validasi Email";
                                    } else {
                                        //Validasi id_event
                                        $ValidasiEvent=GetDetailData($Conn, 'event', 'id_event', $id_event, 'id_event');
                                        if(empty($ValidasiEvent)){
                                            $ValidasiKebenaranData="ID Event Tidak Valid";
                                        }else{
                                            //Validasi ID Assesment Form
                                            $ValidasiAssesmentForm=GetDetailData($Conn, 'event_assesment_form', 'id_event_assesment_form', $id_event_assesment_form, 'id_event');
                                            if(empty($ValidasiAssesmentForm)){
                                                $ValidasiKebenaranData="ID Assesment Form Tidak Valid";
                                            }else{
                                                //Validasi Event Dan Kesesuain dengan kategori
                                                if($ValidasiAssesmentForm!==$ValidasiEvent){
                                                    $ValidasiKebenaranData="ID Pada Assesment Form Tidak Sesuai Dengan Event";
                                                }else{
                                                    $ValidasiKebenaranData="Valid";
                                                }
                                            }
                                        }
                                        if($ValidasiKebenaranData!=="Valid"){
                                            $keterangan =$ValidasiKebenaranData;
                                        }else{
                                            //Validasi Tanggal Penyelenggaraan Event
                                            $mulai_pendaftaran=GetDetailData($Conn, 'event', 'id_event', $id_event, 'mulai_pendaftaran');
                                            $selesai_pendaftaran=GetDetailData($Conn, 'event', 'id_event', $id_event, 'selesai_pendaftaran');
                                            if($now<$mulai_pendaftaran){
                                                $ValidasiPenyelenggaraanEvent="Pendaftaran Event Tersebut Belum Dimulai";
                                            }else{
                                                if($now>$selesai_pendaftaran){
                                                    $ValidasiPenyelenggaraanEvent="Pendaftaran Event Tersebut Sudah Berakhir";
                                                }else{
                                                    $ValidasiPenyelenggaraanEvent="Valid";
                                                }
                                            }
                                            if($ValidasiPenyelenggaraanEvent!=="Valid"){
                                                $keterangan =$ValidasiPenyelenggaraanEvent;
                                            }else{
                                                $id_member=$DataMember['id_member'];
                                                //Buka Detail Form
                                                $form_type=GetDetailData($Conn, 'event_assesment_form', 'id_event_assesment_form', $id_event_assesment_form, 'form_type');
                                                $alternatif=GetDetailData($Conn, 'event_assesment_form', 'id_event_assesment_form', $id_event_assesment_form, 'alternatif');
                                                //Buka ID Peserta
                                                $QryPeserta = $Conn->prepare("SELECT id_event_peserta FROM event_peserta WHERE id_event = ? AND id_member = ?");
                                                if ($QryPeserta === false) {
                                                    $ValidasiPeserta="Terjadi Kesalahan Pada Saat Membuka ID Peserta";
                                                }
                                                // Bind parameter
                                                $QryPeserta->bind_param("ss", $id_event, $id_member);
                                                // Eksekusi query
                                                if (!$QryPeserta->execute()) {
                                                    $ValidasiPeserta="Terjadi Kesalahan Pada Saat Membuka ID Peserta Dari Database";
                                                }
                                                // Mengambil hasil
                                                $ResultPeserta = $QryPeserta->get_result();
                                                $DataPeserta = $ResultPeserta->fetch_assoc();
                                                // Menutup statement
                                                $QryPeserta->close();
                                                // Mengembalikan hasil
                                                if (empty($DataPeserta['id_event_peserta'])) {
                                                    $ValidasiPeserta="ID Peserta Tidak Ditemukan";
                                                } else {
                                                    $id_event_peserta=$DataPeserta['id_event_peserta'];
                                                    $ValidasiPeserta="Valid";
                                                }
                                                //Apabila Validasi Peserta Tidak Valid
                                                if($ValidasiPeserta!=="Valid"){
                                                    $keterangan=$ValidasiPeserta;
                                                }else{
                                                    //Buka Data Assesment Jika Ada
                                                    $QryAssesment = $Conn->prepare("SELECT id_event_assesment FROM event_assesment WHERE id_event_assesment_form = ? AND id_event_peserta  = ?");
                                                    if ($QryAssesment === false) {
                                                        $ValidasiBukaDataAssesmentLama="Terjadi Kesalahan Pada Saat Membuka Assesment Lama";
                                                    }
                                                    $QryAssesment->bind_param("ss", $id_event_assesment_form, $id_event_peserta);
                                                    if (!$QryAssesment->execute()) {
                                                        $ValidasiBukaDataAssesmentLama="Terjadi Kesalahan Pada Saat Data Assesment Dari Database";
                                                    }
                                                    $ResultAssesment = $QryAssesment->get_result();
                                                    $DataAssesment = $ResultAssesment->fetch_assoc();
                                                    if (empty($DataAssesment['id_event_assesment'])) {
                                                        $id_event_assesment="";
                                                        $ValidasiBukaDataAssesmentLama="Valid";
                                                    } else {
                                                        $id_event_assesment=$DataAssesment['id_event_assesment'];
                                                        $ValidasiBukaDataAssesmentLama="Valid";
                                                    }
                                                    if($ValidasiBukaDataAssesmentLama!=="Valid"){
                                                        $keterangan=$ValidasiBukaDataAssesmentLama;
                                                    }else{
                                                        // Menutup statement
                                                        $QryAssesment->close();
                                                        //Validasi Untuk Tipe Form
                                                        if($form_type=="file_foto"||$form_type=="file_pdf"){
                                                            $decoded_image = base64_decode($form_value, true);
                                                            if ($decoded_image === false) {
                                                                $ValidasiFormValue = "Base 64 Image Tidak Valid";
                                                            } else {
                                                                //Validasi Size
                                                                $max_size=5 * 1024 * 1024;
                                                                if (strlen($decoded_image) > $max_size) {
                                                                    $ValidasiFormValue = "File Terlalu Besar (Maksimal 5 Mb)";
                                                                }else{
                                                                    //Vaidasi Tipe
                                                                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                                                    $mime_type = finfo_buffer($finfo, $decoded_image);
                                                                    finfo_close($finfo);
                                                                    if($form_type=="file_foto"){
                                                                        $mime_type_list = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                                                                    }else{
                                                                        $mime_type_list = ['application/pdf'];
                                                                    }
                                                                    if (!in_array(trim($mime_type), $mime_type_list)) {
                                                                        $ValidasiFormValue = "Tipe File Tidak Valid";
                                                                    }else{
                                                                        if($mime_type=='image/jpeg'){
                                                                            $extension=".jpeg";
                                                                        }else{
                                                                            if($mime_type=='image/jpg'){
                                                                                $extension=".jpg";
                                                                            }else{
                                                                                if($mime_type=='image/png'){
                                                                                    $extension=".png";
                                                                                }else{
                                                                                    if($mime_type=='image/gif'){
                                                                                        $extension=".gif";
                                                                                    }else{
                                                                                        if($mime_type=='image/jpeg'){
                                                                                            $extension=".jpeg";
                                                                                        }else{
                                                                                            if($mime_type=='application/pdf'){
                                                                                                $extension=".pdf";
                                                                                            }else{
                                                                                                $extension="";
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                        $newFileName = bin2hex(random_bytes(16)) . ''.$extension.'';
                                                                        $uploadDir = '../../assets/img/Assesment/';
                                                                        $uploadPath = $uploadDir . $newFileName;
                                                                        if (file_put_contents($uploadPath, $decoded_image)) {
                                                                            // Hapus foto lama jika ada
                                                                            if (!empty($id_event_assesment)) {
                                                                                $assesment_value=GetDetailData($Conn,'event_assesment','id_event_assesment',$id_event_assesment,'assesment_value');
                                                                                $assesment_value_path = '../../assets/img/Assesment/'.$assesment_value.'';
                                                                                unlink($assesment_value_path);
                                                                            }
                                                                            $ValidasiFormValue = "Valid";
                                                                            $form_value=$newFileName;
                                                                        } else {
                                                                            $ValidasiFormValue = "Terjadi kesalahan saat upload file Foto";
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }else{
                                                            if($form_type=="radio"||$form_type=="select_option"){
                                                                $alternatif_list=json_decode($alternatif, true);
                                                                $ValueMatching=0;
                                                                $AlternatifListString=[];
                                                                foreach ($alternatif_list as $alternatif_list_arr){
                                                                    if($alternatif_list_arr['value']==$form_value){
                                                                        $ValueMatching=$ValueMatching+1;
                                                                    }else{
                                                                        $ValueMatching=$ValueMatching+0;
                                                                    }
                                                                    $AlternatifListString[]=$alternatif_list_arr['value'];
                                                                }
                                                                $AlternatifListStringRaw=json_encode($AlternatifListString);
                                                                if (empty($ValueMatching)) {
                                                                    $ValidasiFormValue = "Data Yang Anda Kirim Tidak Ada pada Alternatif $AlternatifListStringRaw";
                                                                }else{
                                                                    $ValidasiFormValue = "Valid";
                                                                }
                                                            }else{
                                                                if($form_type=="checkbox"){
                                                                    $alternatif_array = json_decode($alternatif, true);
                                                                    //Membuat array alternatif
                                                                    $alt_arry=[];
                                                                    foreach($alternatif_array as $alternatif_list){
                                                                        $alt_arry[]=$alternatif_list['value'];
                                                                    }
                                                                    $alt_json = json_encode($alt_arry);
                                                                    //Looping Form Value
                                                                    $ValueInvalid=0;
                                                                    $form_value_array=[];
                                                                    foreach($form_value as $form_value_list){
                                                                        if (!in_array(trim($form_value_list), $alt_arry)) {
                                                                            $ValueInvalid=$ValueInvalid+1;
                                                                        }else{
                                                                            $ValueInvalid=$ValueInvalid+0;
                                                                            $form_value_array[]=$form_value_list;
                                                                        }
                                                                    }
                                                                    if (!empty($ValueInvalid)) {
                                                                        $ValidasiFormValue = "Terdapat $ValueInvalid data yang tidak ada pada $alt_json";
                                                                    }else{
                                                                        //Ubah Form Value Menjadi JSON string
                                                                        $form_value=json_encode($form_value_array);
                                                                        $ValidasiFormValue = "Valid";
                                                                    }
                                                                }else{
                                                                    if($form_type=="text"){
                                                                        $form_value_length=strlen($form_value);
                                                                        if($form_value_length>100){
                                                                            $ValidasiFormValue = "Data Yang Anda Kirim Tidak Boleh Lebih Dari 100 Karakter";
                                                                        }else{
                                                                            $ValidasiFormValue = "Valid";
                                                                        }
                                                                    }else{
                                                                        if($form_type=="textarea"){
                                                                            $form_value_length=strlen($form_value);
                                                                            if($form_value_length>500){
                                                                                $ValidasiFormValue = "Data Yang Anda Kirim Tidak Boleh Lebih Dari 500 Karakter";
                                                                            }else{
                                                                                $ValidasiFormValue = "Valid";
                                                                            }
                                                                        }else{
                                                                            $ValidasiFormValue = "Tipe Form Tidak Diketahui";
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        if($ValidasiFormValue!=="Valid"){
                                                            $keterangan=$ValidasiFormValue;
                                                        }else{
                                                            //Apabila Data Belum ADa Maka Insert
                                                            if(empty($id_event_assesment)) {
                                                                //Buat JSON Status
                                                                $status_assesment_array=[
                                                                    "status_assesment" => "Pending",
                                                                    "komentar" => "",
                                                                ];
                                                                $status_assesment = json_encode($status_assesment_array);
                                                                // Insert data ke database
                                                                $query = "INSERT INTO event_assesment (
                                                                    id_event_assesment_form, 
                                                                    id_event_peserta, 
                                                                    assesment_value, 
                                                                    status_assesment
                                                                ) 
                                                                VALUES (?, ?, ?, ?)";
                                                                $stmt = $Conn->prepare($query);
                                                                $stmt->bind_param(
                                                                    "ssss", 
                                                                    $id_event_assesment_form, 
                                                                    $id_event_peserta, 
                                                                    $form_value, 
                                                                    $status_assesment
                                                                );
                                                                if ($stmt->execute()) {
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
                                                                    $keterangan = "Terjadi kesalahan saat menyimpan ke database";
                                                                }
                                                            }else{
                                                                //Kalau Sudah ADa Update
                                                                //Update
                                                                $sql = "UPDATE event_assesment SET 
                                                                    assesment_value = ?
                                                                WHERE id_event_assesment = ?";
                                                                // Menyiapkan statement
                                                                $stmt = $Conn->prepare($sql);
                                                                $stmt->bind_param('ss', $form_value, $id_event_assesment);
                                                                // Eksekusi statement dan cek apakah berhasil
                                                                if ($stmt->execute()) {
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
                                                                    $keterangan= 'Terjadi kesalahan pada saat update data pada database!.';
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $keterangan = "Kombinasi Password Dan Email Tidak Valid";
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
