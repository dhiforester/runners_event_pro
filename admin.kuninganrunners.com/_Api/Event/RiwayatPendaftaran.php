<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Riwayat Pendaftaran";
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
                } else {
                    // Buat Variabel
                    $xtoken = validateAndSanitizeInput($headers['x-token']);
                    $email = validateAndSanitizeInput($Tangkap['email']);
                    $id_member_login = validateAndSanitizeInput($Tangkap['id_member_login']);
                        
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
                                        //Apakah Yang Bersangkutan Punya Riwayat Event?
                                        $ValidasiRiwayatEvent = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_peserta FROM event_peserta WHERE id_member='$id_member'"));
                                        if(empty($ValidasiRiwayatEvent)){
                                            $keterangan = "Anda Belum Memiliki Riwayat Ikut Serta Dalam Event Apapun";
                                        }else{
                                            // Persiapkan Query untuk Mengambil Data Event
                                            $QryEvent = $Conn->prepare("SELECT * FROM event_peserta WHERE id_member = ? ORDER BY id_event_peserta DESC");
                                            $QryEvent->bind_param("s", $id_member);
                                            $QryEvent->execute();
                                            $resultEvent = $QryEvent->get_result();
                                            
                                            while ($DataEvent = $resultEvent->fetch_assoc()) {
                                                $id_event_peserta=$DataEvent['id_event_peserta'];
                                                $id_event=$DataEvent['id_event'];
                                                $id_event_kategori=$DataEvent['id_event_kategori'];
                                                $nama=$DataEvent['nama'];
                                                $email=$DataEvent['email'];
                                                $biaya_pendaftaran=$DataEvent['biaya_pendaftaran'];
                                                $datetime=$DataEvent['datetime'];
                                                $status=$DataEvent['status'];
                                                //Buka Data Event
                                                $tanggal_mulai=GetDetailData($Conn,'event','id_event',$id_event,'tanggal_mulai');
                                                $tanggal_selesai=GetDetailData($Conn,'event','id_event',$id_event,'tanggal_selesai');
                                                $mulai_pendaftaran=GetDetailData($Conn,'event','id_event',$id_event,'mulai_pendaftaran');
                                                $selesai_pendaftaran=GetDetailData($Conn,'event','id_event',$id_event,'selesai_pendaftaran');
                                                $nama_event=GetDetailData($Conn,'event','id_event',$id_event,'nama_event');
                                                $keterangan=GetDetailData($Conn,'event','id_event',$id_event,'keterangan');
                                                //Buka Data Kategori
                                                $kategori=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'kategori');
                                                $deskripsi=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'deskripsi');
                                                $biaya_pendaftaran=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'biaya_pendaftaran');
                                                $event= [
                                                    "id_event" => $id_event,
                                                    "tanggal_mulai" => $tanggal_mulai,
                                                    "tanggal_selesai" => $tanggal_selesai,
                                                    "mulai_pendaftaran" => $mulai_pendaftaran,
                                                    "selesai_pendaftaran" => $selesai_pendaftaran,
                                                    "nama_event" => $nama_event,
                                                    "keterangan" => $keterangan
                                                ];
                                                $kategori= [
                                                    "id_event_kategori" => $id_event_kategori,
                                                    "kategori" => $kategori,
                                                    "deskripsi" => $deskripsi,
                                                    "biaya_pendaftaran" => $biaya_pendaftaran
                                                ];
                                                $metadata[] = [
                                                    "id_event_peserta" => $id_event_peserta,
                                                    "event" => $event,
                                                    "kategori" => $kategori,
                                                    "nama" => $nama,
                                                    "email" => $email,
                                                    "datetime" => $datetime,
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
