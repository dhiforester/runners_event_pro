<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/SettingEmail.php";
    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Pendaftaran Member";

    // Setting default response
    $code = 201;
    $keterangan = "Terjadi kesalahan";
    $metadata = [];

    // Validasi Metode Pengiriman Data
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $keterangan = "Metode Pengiriman Data Hanya Boleh Menggunakan POST";
    } else {
        try {
            // Variabel Header
            $headers = getallheaders();
            // Decode Json Data
            $raw = file_get_contents('php://input');
            $Tangkap = json_decode($raw, true);
            // Validasi x-token tidak boleh kosong
            if (!isset($headers['x-token'])) {
                $ValidasiKelengkapan = "x-token Tidak Boleh Kosong";
            } else {
                // Validasi nama tidak boleh kosong
                if (!isset($Tangkap['nama'])) {
                    $ValidasiKelengkapan = "Nama Tidak Boleh Kosong";
                } else {
                    // Validasi kontak tidak boleh kosong
                    if (!isset($Tangkap['kontak'])) {
                        $ValidasiKelengkapan = "Kontak Tidak Boleh Kosong";
                    } else {
                        // Validasi email tidak boleh kosong
                        if (!isset($Tangkap['email'])) {
                            $ValidasiKelengkapan = "Email Tidak Boleh Kosong";
                        } else {
                            // Validasi password tidak boleh kosong
                            if (!isset($Tangkap['password'])) {
                                $ValidasiKelengkapan = "Password Tidak Boleh Kosong";
                            } else {
                                // Validasi id_wilayah tidak boleh kosong
                                if (!isset($Tangkap['id_wilayah'])) {
                                    $ValidasiKelengkapan = "Wilayah Administrasi Tidak Boleh Kosong";
                                } else {
                                    $ValidasiKelengkapan = "Valid";
                                }
                            }
                        }
                    }
                }
            }
            if($ValidasiKelengkapan!=="Valid"){
                $keterangan = $ValidasiKelengkapan;
            }else{
                // Validasi panjang karakter
                if (strlen($Tangkap['nama']) > 100) { 
                    $ValidasiJumlahKarakter= 'Nama tidak boleh lebih dari 100 karakter.'; 
                }else{
                    if (strlen($Tangkap['kontak']) > 20) { 
                        $ValidasiJumlahKarakter= 'Kontak tidak boleh lebih dari 20 karakter.'; 
                    }else{
                        if (strlen($Tangkap['email']) > 100) { 
                            $ValidasiJumlahKarakter= 'Email tidak boleh lebih dari 100 karakter.'; 
                        }else{
                            if (strlen($Tangkap['password']) > 20) { 
                                $ValidasiJumlahKarakter='Password tidak boleh lebih dari 20 karakter.'; 
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
                            if (!ctype_alnum($Tangkap['password'])) {
                                $ValidasiTipeData='Password hanya boleh huruf dan angka.';
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
                    }
                    if($ValidasiTipeData!=="Valid"){
                        $keterangan= $ValidasiTipeData;
                    }else{
                        //Buat Variabel
                        $xtoken = validateAndSanitizeInput($headers['x-token']);
                        $nama = validateAndSanitizeInput($Tangkap['nama']);
                        $kontak = validateAndSanitizeInput($Tangkap['kontak']);
                        $email = validateAndSanitizeInput($Tangkap['email']);
                        $password = validateAndSanitizeInput($Tangkap['password']);
                        $id_wilayah = validateAndSanitizeInput($Tangkap['id_wilayah']);
                        if (!isset($Tangkap['kode_pos'])) {
                            $kode_pos = "";
                        } else {
                            $kode_pos = validateAndSanitizeInput($Tangkap['kode_pos']);
                        }
                        if (!isset($Tangkap['rt_rw'])) {
                            $rt_rw = "";
                        } else {
                            $rt_rw = validateAndSanitizeInput($Tangkap['rt_rw']);
                        }
                        $id_member = bin2hex(random_bytes(16));
                        $email_validation =GenerateToken(9);
                        $sumber = "Website";
                        $datetime = date('Y-m-d H:i:s');
                        $password = password_hash($password, PASSWORD_DEFAULT);
                        $status="Pending";
                        $foto="";
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
                                
                                //VALIDASI DUPLIKAT
                                $DuplikasiEmail = GetDetailData($Conn, 'member', 'email', $email, 'id_member');
                                if(!empty($DuplikasiEmail)) {
                                    $ValidasiDuplikatData= 'Email sudah terdaftar.';
                                }else{
                                    $DuplikasiKontak = GetDetailData($Conn, 'member', 'kontak', $kontak, 'id_member');
                                    if(!empty($DuplikasiKontak)) {
                                        $ValidasiDuplikatData= 'Kontak sudah terdaftar.';
                                    }else{
                                        $ValidasiDuplikatData= 'Valid';
                                    }
                                }
                                if($ValidasiDuplikatData!=="Valid"){
                                    $keterangan= $ValidasiDuplikatData;
                                }else{
                                    //Validasi id_wilayah
                                    $kategori_wilayah=GetDetailData($Conn, 'wilayah', 'id_wilayah', $id_wilayah, 'kategori');
                                    if($kategori_wilayah!=="desa"){
                                        $keterangan="ID Wilayah Tidak Valid";
                                    }else{
                                        $provinsi=GetDetailData($Conn, 'wilayah', 'id_wilayah', $id_wilayah, 'propinsi');
                                        $kabupaten=GetDetailData($Conn, 'wilayah', 'id_wilayah', $id_wilayah, 'kabupaten');
                                        $kecamatan=GetDetailData($Conn, 'wilayah', 'id_wilayah', $id_wilayah, 'kecamatan');
                                        $desa=GetDetailData($Conn, 'wilayah', 'id_wilayah', $id_wilayah, 'desa');
                                        
                                        //Simpan Data Ke Database
                                        $query = "INSERT INTO member (
                                            id_member, 
                                            nama, 
                                            kontak, 
                                            email, 
                                            email_validation, 
                                            password, 
                                            provinsi, 
                                            kabupaten, 
                                            kecamatan, 
                                            desa, 
                                            kode_pos, 
                                            rt_rw, 
                                            datetime, 
                                            status, 
                                            sumber, 
                                            foto
                                        ) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                        $stmt = $Conn->prepare($query);
                                        $stmt->bind_param(
                                            "ssssssssssssssss", 
                                            $id_member, 
                                            $nama, 
                                            $kontak, 
                                            $email, 
                                            $email_validation, 
                                            $password, 
                                            $provinsi, 
                                            $kabupaten, 
                                            $kecamatan, 
                                            $desa, 
                                            $kode_pos, 
                                            $rt_rw, 
                                            $datetime,
                                            $status, 
                                            $sumber, 
                                            $foto
                                        );
                                        if ($stmt->execute()) {
                                            //Kirim Email
                                            $pesan='Kepada Yth.'.$nama.'<br>Berikut ini adalah kode verifikasi yang bisa anda gunakan untuk melakukan validasi akun member anda.<p>Kode : '.$email_validation.'</p>';
                                            $ch = curl_init();
                                            $headers = array(
                                                'Content-Type: Application/JSON',          
                                                'Accept: Application/JSON'     
                                            );
                                            $arr = array(
                                                "subjek" => "Validasi Email",
                                                "email_asal" => "$email_gateway",
                                                "password_email_asal" => "$password_gateway",
                                                "url_provider" => "$url_provider",
                                                "nama_pengirim" => "$nama_pengirim",
                                                "email_tujuan" => "$email",
                                                "nama_tujuan" => "$nama",
                                                "pesan" => "$pesan",
                                                "port" => "$port_gateway"
                                            );
                                            $json = json_encode($arr);
                                            curl_setopt($ch, CURLOPT_URL, "$url_service");
                                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                            curl_setopt($ch, CURLOPT_TIMEOUT, 1000); 
                                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                                            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                            $content = curl_exec($ch);
                                            $err = curl_error($ch);
                                            curl_close($ch);
                                            $get =json_decode($content, true);
                                            // Buat Metadata
                                            $metadata = [
                                                "id_member" => $id_member,
                                                "nama" => $nama,
                                                "kontak" => $kontak,
                                                "email" => $email,
                                                "provinsi" => $provinsi,
                                                "kabupaten" => $kabupaten,
                                                "kecamatan" => $kecamatan,
                                                "desa" => $desa,
                                                "kode_pos" => $kode_pos,
                                                "rt_rw" => $rt_rw,
                                                "datetime" => $datetime,
                                                "status" => $status,
                                                "sumber" => $sumber
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
                                        }else{
                                            $keterangan = "Terjadi kesalahan pada saat menyimpan data ke database";
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
