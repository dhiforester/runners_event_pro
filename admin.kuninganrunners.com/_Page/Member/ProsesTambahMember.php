<?php
    // Koneksi Dan Pengaturan lainnya
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingEmail.php";
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    // Inisialisasi pesan error
    $response = ['success' => false, 'message' => ''];
    $errors = []; 
    // Harus Login Terlebih Dulu
    if (empty($SessionIdAkses)) {
        $ValidasiKelengkapanData='Sesi akses sudah berakhir, silahkan login ulang!.';
    }else{
        // Validasi data input tidak boleh kosong
        if (empty($_POST['nama'])) {
            $ValidasiKelengkapanData="Nama tidak boleh kosong! Anda wajib mengisi form tersebut.";
        }else{
            if (empty($_POST['kontak'])) {
                $ValidasiKelengkapanData="Kontak tidak boleh kosong! Anda wajib mengisi form tersebut.";
            }else{
                if (empty($_POST['email'])) {
                    $ValidasiKelengkapanData="Email tidak boleh kosong! Anda wajib mengisi form tersebut.";
                }else{
                    if (empty($_POST['password'])) {
                        $ValidasiKelengkapanData="Password tidak boleh kosong! Anda wajib mengisi form tersebut.";
                    }else{
                        if (empty($_POST['provinsi'])) {
                            $ValidasiKelengkapanData="Provinsi tidak boleh kosong! Anda wajib mengisi form tersebut.";
                        }else{
                            if (empty($_POST['kabupaten'])) {
                                $ValidasiKelengkapanData="Kabupaten tidak boleh kosong! Anda wajib mengisi form tersebut.";
                            }else{
                                if (empty($_POST['kecamatan'])) {
                                    $ValidasiKelengkapanData="Kecamatan tidak boleh kosong! Anda wajib mengisi form tersebut.";
                                }else{
                                    if (empty($_POST['desa'])) {
                                        $ValidasiKelengkapanData="Desa tidak boleh kosong! Anda wajib mengisi form tersebut.";
                                    }else{
                                        if (empty($_POST['status'])) {
                                            $ValidasiKelengkapanData="Status tidak boleh kosong! Anda wajib mengisi form tersebut.";
                                        }else{
                                            if (empty($_POST['email_validation'])) {
                                                $ValidasiKelengkapanData="Kode Validasi Email tidak boleh kosong! Anda wajib mengisi form tersebut.";
                                            }else{
                                                $ValidasiKelengkapanData="Valid";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    if($ValidasiKelengkapanData!=="Valid"){
        $errors[] = $ValidasiKelengkapanData;
    }else{
        // Validasi panjang karakter
        if (strlen($_POST['nama']) > 100) { 
            $ValidasiJumlahKarakter= 'Nama tidak boleh lebih dari 100 karakter.'; 
        }else{
            if (strlen($_POST['kontak']) > 20) { 
                $ValidasiJumlahKarakter= 'Kontak tidak boleh lebih dari 20 karakter.'; 
            }else{
                if (strlen($_POST['email']) > 100) { 
                    $ValidasiJumlahKarakter= 'Email tidak boleh lebih dari 100 karakter.'; 
                }else{
                    if (strlen($_POST['password']) > 20) { 
                        $ValidasiJumlahKarakter='Password tidak boleh lebih dari 20 karakter.'; 
                    }else{
                        if (isset($_POST['kode_pos']) && strlen($_POST['kode_pos']) > 10) { 
                            $ValidasiJumlahKarakter='Kode pos tidak boleh lebih dari 10 karakter.'; 
                        }else{
                            if (isset($_POST['rt_rw']) && strlen($_POST['rt_rw']) > 50) { 
                                $ValidasiJumlahKarakter='RT/RW tidak boleh lebih dari 50 karakter.'; 
                            }else{
                                if (isset($_POST['email_validation']) && strlen($_POST['email_validation']) > 9) { 
                                    $ValidasiJumlahKarakter='Kode validasi email tidak boleh lebih dari 9 karakter.'; 
                                }else{
                                    $ValidasiJumlahKarakter="Valid";
                                }
                            }
                        }
                    }
                }
            }
        }
        if($ValidasiJumlahKarakter!=="Valid"){
            $errors[] = $ValidasiJumlahKarakter;
        }else{
            //Validasi Tipe Data
            if (!preg_match("/^[a-zA-Z\s]+$/", $_POST['nama'])) {
                $ValidasiTipeData= 'Nama hanya boleh huruf dan spasi.';
            }else{
                if (!ctype_digit($_POST['kontak'])) {
                    $ValidasiTipeData='Kontak hanya boleh angka.';
                }else{
                    if (!ctype_alnum($_POST['password'])) {
                        $ValidasiTipeData='Password hanya boleh huruf dan angka.';
                    }else{
                        if(!ctype_alnum($_POST['email_validation'])){
                            $ValidasiTipeData='Kode validasi email hanya boleh huruf dan angka.';
                        }else{
                            if (!empty($_POST['kode_pos'])) {
                                if(!ctype_alnum($_POST['kode_pos'])){
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
            }
            if($ValidasiTipeData!=="Valid"){
                $errors[] = $ValidasiTipeData;
            }else{
                // Cek duplikasi email
                $stmt = $Conn->prepare("SELECT COUNT(*) FROM member WHERE email = ?");
                $stmt->bind_param("s", $_POST['email']);
                $stmt->execute();
                $stmt->bind_result($email_count);
                $stmt->fetch();
                $stmt->close();
                if ($email_count > 0) {
                    $ValidasiDuplikatData= 'Email sudah terdaftar.';
                }else{
                    // Cek duplikasi kontak
                    $stmt = $Conn->prepare("SELECT COUNT(*) FROM member WHERE kontak = ?");
                    $stmt->bind_param("s", $_POST['kontak']);
                    $stmt->execute();
                    $stmt->bind_result($kontak_count);
                    $stmt->fetch();
                    $stmt->close();
                    if ($kontak_count > 0) {
                        $ValidasiDuplikatData= 'Kontak sudah terdaftar.';
                    }else{
                        // Cek duplikasi email_validation jika ada
                        if (!empty($_POST['email_validation'])) {
                            $stmt = $Conn->prepare("SELECT COUNT(*) FROM member WHERE email_validation = ?");
                            $stmt->bind_param("s", $_POST['email_validation']);
                            $stmt->execute();
                            $stmt->bind_result($email_validation_count);
                            $stmt->fetch();
                            $stmt->close();
                            if ($email_validation_count > 0) {
                                $ValidasiDuplikatData= 'Kode validasi email sudah digunakan.';
                            }else{
                                $ValidasiDuplikatData= 'Valid';
                            }
                        }else{
                            $ValidasiDuplikatData= 'Valid';
                        }
                    }
                }
                if($ValidasiDuplikatData!=="Valid"){
                    $errors[] = $ValidasiDuplikatData;
                }else{
                    //Validasi Upload Foto Profil
                    if (!empty($_FILES['foto']['name'])) {
                        $foto_ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
                        $allowed_foto_types = ['png', 'jpg', 'jpeg', 'gif'];
                        if (!in_array($foto_ext, $allowed_foto_types)) {
                            $ValidasiFoto= 'Format file foto harus PNG, JPG, JPEG, atau GIF.';
                        } else {
                            $foto = bin2hex(random_bytes(16)) . '.' . $foto_ext;
                            $foto_path = '../../assets/img/Member/' . $foto;
                            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path)) {
                                $ValidasiFoto== 'Gagal mengunggah foto, silakan coba lagi.';
                            }else{
                                $ValidasiFoto="Valid";
                            }
                        }
                    }else{
                        $foto = '';
                        $ValidasiFoto="Valid";
                    }
                    if($ValidasiFoto!=="Valid"){
                        $errors[] = $ValidasiFoto;
                    }else{
                        // Generate UUID dan siapkan data untuk dimasukkan
                        $id_member = bin2hex(random_bytes(16));
                        $nama = validateAndSanitizeInput($_POST['nama']);
                        $kontak = validateAndSanitizeInput($_POST['kontak']);
                        $email = validateAndSanitizeInput($_POST['email']);
                        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                        $provinsi = validateAndSanitizeInput($_POST['provinsi']);
                        $kabupaten = validateAndSanitizeInput($_POST['kabupaten']);
                        $kecamatan = validateAndSanitizeInput($_POST['kecamatan']);
                        $desa = validateAndSanitizeInput($_POST['desa']);
                        $status = validateAndSanitizeInput($_POST['status']);
                        $rt_rw = isset($_POST['rt_rw']) ? validateAndSanitizeInput($_POST['rt_rw']) : '';
                        $kode_pos = isset($_POST['kode_pos']) ? validateAndSanitizeInput($_POST['kode_pos']) : '';
                        $email_validation = isset($_POST['email_validation']) ? validateAndSanitizeInput($_POST['email_validation']) : '';
                        $sumber = "Manual";
                        $datetime = date('Y-m-d H:i:s');

                        // Insert data ke database
                        $query = "INSERT INTO member (id_member, nama, kontak, email, email_validation, password, provinsi, kabupaten, kecamatan, desa, kode_pos, rt_rw, datetime, status, sumber, foto) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $Conn->prepare($query);
                        $stmt->bind_param("ssssssssssssssss", $id_member, $nama, $kontak, $email, $email_validation, $password, $provinsi, $kabupaten, $kecamatan, $desa, $kode_pos, $rt_rw, $datetime, $status, $sumber, $foto);

                        if ($stmt->execute()) {
                            //Jika status Pending Kirim Email
                            if($status=="Pending"){
                                $pesan='Kepada Yth.'.$nama.'<br>Berikut ini adalah kode verifikasi yang bisa anda gunakan untuk melakukan validasi akun member anda.<p>Kode : '.$email_validation.'</p>';
                                //Kirim email
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
                            }
                            //Menyimpan Log
                            addLog($Conn, $SessionIdAkses, $now, "Member", "Input Member");
                            $response['success'] = true;
                            $response['message'] = 'Tambah Member Berhasil';
                        } else {
                            $errors[]= 'Gagal menyimpan data, coba lagi.';
                        }
                    }
                }
            }
        }
    }
    // Jika ada error, kirim respons dengan daftar pesan error
    if (!empty($errors)) {
        $response['message'] = implode('<br>', $errors);
        echo json_encode($response);
        exit;
    }else{
        echo json_encode($response);
    }
?>
