<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Edit Profil Member";
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
                    $keterangan = "ID Member login Tidak Boleh Kosong";
                } else if (!isset($Tangkap['nama'])) {
                    $keterangan = "Nama Tidak Boleh Kosong";
                } else if (!isset($Tangkap['kontak'])) {
                    $keterangan = "Kontak Tidak Boleh Kosong";
                } else if (!isset($Tangkap['id_wilayah'])) {
                    $keterangan = "ID Wilayah Tidak Boleh Kosong";
                } else {
                    // Buat Variabel
                    $xtoken = validateAndSanitizeInput($headers['x-token']);
                    $email = validateAndSanitizeInput($Tangkap['email']);
                    $id_member_login = validateAndSanitizeInput($Tangkap['id_member_login']);
                    $nama = validateAndSanitizeInput($Tangkap['nama']);
                    $kontak = validateAndSanitizeInput($Tangkap['kontak']);
                    $id_wilayah = validateAndSanitizeInput($Tangkap['id_wilayah']);
                    if(empty($Tangkap['kode_pos'])){
                        $kode_pos="";
                    }else{
                        $kode_pos = validateAndSanitizeInput($Tangkap['kode_pos']);
                    }
                    if(empty($Tangkap['rt_rw'])){
                        $rt_rw="";
                    }else{
                        $rt_rw = validateAndSanitizeInput($Tangkap['rt_rw']);
                    }
                    //Validasi Tipe Dan Karakter Data
                    if (strlen($Tangkap['nama']) > 100) { 
                        $ValidasiJumlahKarakter= 'Nama tidak boleh lebih dari 100 karakter.'; 
                    }else{
                        if (strlen($Tangkap['kontak']) > 20) { 
                            $ValidasiJumlahKarakter= 'Kontak tidak boleh lebih dari 20 karakter.'; 
                        }else{
                            if (strlen($Tangkap['email']) > 100) { 
                                $ValidasiJumlahKarakter= 'Email tidak boleh lebih dari 100 karakter.'; 
                            }else{
                                if (isset($Tangkap['kode_pos']) && strlen($Tangkap['kode_pos']) > 10) { 
                                    $ValidasiJumlahKarakter='Kode pos tidak boleh lebih dari 10 karakter.'; 
                                }else{
                                    if (isset($Tangkap['rt_rw']) && strlen($Tangkap['rt_rw']) > 50) { 
                                        $ValidasiJumlahKarakter='RT/RW tidak boleh lebih dari 50 karakter.'; 
                                    }else{
                                        $ValidasiJumlahKarakter='Valid'; 
                                    }
                                }
                            }
                        }
                    }
                    if($ValidasiJumlahKarakter!=="Valid"){
                        $keterangan = $ValidasiJumlahKarakter;
                    }else{
                         //Validasi Tipe Data
                        if (!preg_match("/^[a-zA-Z\s]+$/", $Tangkap['nama'])) {
                            $ValidasiTipeData= 'Nama hanya boleh huruf dan spasi.';
                        }else{
                            if (!ctype_digit($Tangkap['kontak'])) {
                                $ValidasiTipeData='Kontak hanya boleh angka.';
                            }else{
                                if (!empty($Tangkap['kode_pos'])) {
                                    if(!ctype_alnum($Tangkap['kode_pos'])){
                                        $ValidasiTipeData='Kode pos hanya boleh angka.';
                                    }else{
                                        $ValidasiTipeData='Valid';
                                    }
                                }else{
                                    $ValidasiTipeData='Valid';
                                }
                            }
                        }
                        if($ValidasiTipeData!=="Valid"){
                            $keterangan= $ValidasiTipeData;
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
                                    
                                    // Validasi Email dan id_member_login
                                    $stmt = $Conn->prepare("SELECT * FROM member_login WHERE id_member_login = ?");
                                    $stmt->bind_param("s", $id_member_login);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $DataMember = $result->fetch_assoc();

                                    if (!empty($DataMember['id_member'])) {
                                        //Buka ID Member
                                        $id_member=$DataMember['id_member'];
                                        $datetime_expired=$DataMember['datetime_expired'];
                                        //Cek Apakah Sessi Login Sudah Berakhir?
                                        if($datetime_expired<$now){
                                            $keterangan = "Sessi Login Sudah Berakhir";
                                        }else{
                                            //Buka Email Di Database
                                            $email_member=GetDetailData($Conn, 'member', 'id_member', $id_member, 'email');
                                            $status_member=GetDetailData($Conn, 'member', 'id_member', $id_member, 'status');
                                            //Cek Apakah Email Sesuai
                                            if($email_member!==$email){
                                                $keterangan = "Email dengan ID Login Tidak Sesuai";
                                            }else{
                                                if ($status_member !== "Active") {
                                                    $keterangan = "Member Belum Melakukan Validasi Email";
                                                } else {
                                                    //Validasi id_wilayah
                                                    $kategori_wilayah=GetDetailData($Conn, 'wilayah', 'id_wilayah', $id_wilayah, 'kategori');
                                                    if($kategori_wilayah!=="desa"){
                                                        $keterangan="ID Wilayah Tidak Valid";
                                                    }else{
                                                        $provinsi=GetDetailData($Conn, 'wilayah', 'id_wilayah', $id_wilayah, 'propinsi');
                                                        $kabupaten=GetDetailData($Conn, 'wilayah', 'id_wilayah', $id_wilayah, 'kabupaten');
                                                        $kecamatan=GetDetailData($Conn, 'wilayah', 'id_wilayah', $id_wilayah, 'kecamatan');
                                                        $desa=GetDetailData($Conn, 'wilayah', 'id_wilayah', $id_wilayah, 'desa');
                                                        $id_member = $DataMember['id_member'];
                                                        // Update Member
                                                        $updateQuery = "UPDATE member SET 
                                                            nama = ?, 
                                                            kontak = ?, 
                                                            provinsi = ?, 
                                                            kabupaten = ?, 
                                                            kecamatan = ?, 
                                                            desa = ?, 
                                                            kode_pos = ?, 
                                                            rt_rw = ? 
                                                        WHERE id_member = ?";
                                                        $stmtUpdate = $Conn->prepare($updateQuery);
                                                        $stmtUpdate->bind_param(
                                                            'sssssssss', 
                                                            $nama, 
                                                            $kontak, 
                                                            $provinsi, 
                                                            $kabupaten, 
                                                            $kecamatan, 
                                                            $desa, 
                                                            $kode_pos, 
                                                            $rt_rw, 
                                                            $id_member
                                                        );
                                                        if ($stmtUpdate->execute()) {
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
                                    } else {
                                        $keterangan = "Sessi Member Tidak Valid";
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
