<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Pendafataran Event";
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
                } else if (!isset($Tangkap['id_event'])) {
                    $keterangan = "ID Event Tidak Boleh Kosong";
                } else if (!isset($Tangkap['id_event_kategori'])) {
                    $keterangan = "Kategori Event Tidak Boleh Kosong";
                } else {
                    // Buat Variabel
                    $xtoken = validateAndSanitizeInput($headers['x-token']);
                    $email = validateAndSanitizeInput($Tangkap['email']);
                    $id_member_login = validateAndSanitizeInput($Tangkap['id_member_login']);
                    $id_event = validateAndSanitizeInput($Tangkap['id_event']);
                    $id_event_kategori = validateAndSanitizeInput($Tangkap['id_event_kategori']);
                    //Validasi Tipe Dan Karakter Data
                    if (strlen($Tangkap['id_event']) > 36) { 
                        $ValidasiJumlahKarakter= 'ID Event Tidak Valid Karena Terlalu Panjang'; 
                    }else{
                        $ValidasiJumlahKarakter='Valid'; 
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
                                        //Validasi id_event
                                        $ValidasiEvent=GetDetailData($Conn, 'event', 'id_event', $id_event, 'id_event');
                                        if(empty($ValidasiEvent)){
                                            $keterangan="ID Event Tidak Valid";
                                        }else{
                                            //Validasi Kategori Event
                                            $ValidasiKategoriEvent=GetDetailData($Conn, 'event_kategori', 'id_event_kategori', $id_event_kategori, 'id_event');
                                            if(empty($ValidasiKategoriEvent)){
                                                $keterangan="ID Kategori Event Tidak Valid";
                                            }else{
                                                //Validasi Event Dan Kesesuain dengan kategori
                                                if($ValidasiKategoriEvent!==$ValidasiEvent){
                                                    $keterangan="Kategori Event Tidak Sesuai Dengan Event";
                                                }else{
                                                    //Validasi Waktu Pendaftaran Event
                                                    $mulai_pendaftaran=GetDetailData($Conn, 'event', 'id_event', $id_event, 'mulai_pendaftaran');
                                                    $selesai_pendaftaran=GetDetailData($Conn, 'event', 'id_event', $id_event, 'selesai_pendaftaran');
                                                    if($now<$mulai_pendaftaran){
                                                        $keterangan="Pendaftaran Event Tersebut Belum Dimulai";
                                                    }else{
                                                        if($now>$selesai_pendaftaran){
                                                            $keterangan="Pendaftaran Event Tersebut Sudah Berakhir";
                                                        }else{
                                                            $id_member=$DataMember['id_member'];
                                                            $nama=GetDetailData($Conn, 'member', 'id_member', $id_member, 'nama');
                                                            $email=GetDetailData($Conn, 'member', 'id_member', $id_member, 'email');
                                                            $biaya_pendaftaran=GetDetailData($Conn, 'event_kategori', 'id_event_kategori', $id_event_kategori, 'biaya_pendaftaran');
                                                            $status="Pending";
                                                            $id_event_peserta=GenerateToken(36);
                                                            //Validasi Duplikat Data
                                                            $ValidasiDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_peserta FROM event_peserta WHERE id_event='$id_event' AND id_member='$id_member'"));
                                                            if(!empty($ValidasiDuplikat)){
                                                                $keterangan="Member Tersebut Sudah Terdaftar Sebelumnya Pada Event Yang Sama";
                                                            }else{
                                                                // Insert data ke database
                                                                $query = "INSERT INTO event_peserta (
                                                                    id_event_peserta, 
                                                                    id_event, 
                                                                    id_event_kategori, 
                                                                    id_member, 
                                                                    nama, 
                                                                    email, 
                                                                    biaya_pendaftaran, 
                                                                    datetime, 
                                                                    status
                                                                ) 
                                                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                                                $stmt = $Conn->prepare($query);
                                                                $stmt->bind_param(
                                                                    "sssssssss", 
                                                                    $id_event_peserta, 
                                                                    $id_event, 
                                                                    $id_event_kategori, 
                                                                    $id_member, 
                                                                    $nama, 
                                                                    $email, 
                                                                    $biaya_pendaftaran, 
                                                                    $now, 
                                                                    $status
                                                                );
                                                                if ($stmt->execute()) {
                                                                    $metadata= [
                                                                        "id_event_peserta" => $id_event_peserta,
                                                                        "id_event" => $id_event,
                                                                        "id_event_kategori" => $id_event_kategori,
                                                                        "id_member" => $id_member,
                                                                        "nama" => $nama,
                                                                        "email" => $email,
                                                                        "biaya_pendaftaran" => $biaya_pendaftaran,
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
                                                                } else {
                                                                    $keterangan = "Terjadi kesalahan saat menyimpan ke database";
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
