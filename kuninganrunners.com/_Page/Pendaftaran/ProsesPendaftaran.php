<?php
    session_start();
    // Koneksi Dan Pengaturan lainnya
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    date_default_timezone_set("Asia/Jakarta");
    //Apabila Session Datetime expired tidak ada
    if(empty($_SESSION['datetime_expired'])){
        // Apabila Session X token tidak ada
        $response=GenerateXtoken($url_server,$user_key_server,$password_server);
        $arry_res = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $xtoken ="";
            $datetime_expired ="";
        }else{
            if($arry_res['response']['code']!==200) {
                $xtoken ="";
                $datetime_expired ="";
            }else{
                $metadata = $arry_res['metadata'];
                $datetime_expired = $metadata['datetime_expired'];
                $xtoken = $metadata['x-token'];
            }
        }
    }else{
        //Cek Apakah xtoken expired
        if(date('Y-m-d H:i:s')<$_SESSION['datetime_expired']){
            //Apabila Masih Aktif Maka Buka Dari Session
            $xtoken=$_SESSION['xtoken'];
            $datetime_expired=$_SESSION['datetime_expired'];
        }else{
            //Apabila sudah Expired
            $response=GenerateXtoken($url_server,$user_key_server,$password_server);
            $arry_res = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $xtoken ="";
                $datetime_expired ="";
            }else{
                if($arry_res['response']['code']!==200) {
                    $xtoken ="";
                    $datetime_expired ="";
                }else{
                    $metadata = $arry_res['metadata'];
                    $datetime_expired = $metadata['datetime_expired'];
                    $xtoken = $metadata['x-token'];
                }
            }
        }
    }
    // Inisialisasi pesan error
    $val_email ="";
    $message ="";
    $code =201; 
    //Periksa Apakah Token Ada atau Berhasil Dibuat
    if(empty($xtoken)){
        $message ="Terjadi Kesalahan Pada Saat Membuat Token Akses Ke Server";
        $code =201; 
    }else{
        //Buat Session
        $_SESSION['datetime_expired'] = $datetime_expired;
        $_SESSION['xtoken'] = $xtoken;
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
                        if (empty($_POST['ulangi_password'])) {
                            $ValidasiKelengkapanData="Password Harus Sama!";
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
                                            if (empty($_POST['captcha'])) {
                                                $ValidasiKelengkapanData="Kode captcha tidak boleh kosong! Anda wajib mengisi form tersebut.";
                                            }else{
                                                if (empty($_POST['konfirmasi_pendaftaran'])) {
                                                    $ValidasiKelengkapanData="Anda harus setuju dengan syarat dan ketentuan yang sudah kami nyatakan pada form pendaftaran";
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
            $message =$ValidasiKelengkapanData;
            $code =201; 
            $val_email ="";
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
                                    $ValidasiJumlahKarakter="Valid";
                                }
                            }
                        }
                    }
                }
            }
            if($ValidasiJumlahKarakter!=="Valid"){
                $message =$ValidasiJumlahKarakter;
                $code =201; 
                $val_email ="";
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
                if($ValidasiTipeData!=="Valid"){
                    $message =$ValidasiTipeData;
                    $code =201; 
                    $val_email ="";
                }else{
                    // Bersihkan Variabel Sebelum Dikirim
                    $nama = validateAndSanitizeInput($_POST['nama']);
                    $kontak = validateAndSanitizeInput($_POST['kontak']);
                    $email = validateAndSanitizeInput($_POST['email']);
                    $password = validateAndSanitizeInput($_POST['password']);
                    $ulangi_password = validateAndSanitizeInput($_POST['ulangi_password']);
                    $provinsi = validateAndSanitizeInput($_POST['provinsi']);
                    $kabupaten = validateAndSanitizeInput($_POST['kabupaten']);
                    $kecamatan = validateAndSanitizeInput($_POST['kecamatan']);
                    $desa = validateAndSanitizeInput($_POST['desa']);
                    $rt_rw = isset($_POST['rt_rw']) ? validateAndSanitizeInput($_POST['rt_rw']) : '';
                    $kode_pos = isset($_POST['kode_pos']) ? validateAndSanitizeInput($_POST['kode_pos']) : '';
                    $captcha = validateAndSanitizeInput($_POST['captcha']);
                    //Validasi Password Harus Sama
                    if($password!==$ulangi_password){
                        $message ="Password yang anda masukan tidak sama";
                        $code =201; 
                    }else{
                        //Validasi Captcha
                        if ($captcha !== $_SESSION["captcha_validation_form"]) {
                            $message = "Kode Captcha yang Anda masukkan tidak valid";
                            $code = 201;
                        } else {
                            //Persiapan Mengirim Data Ke Server
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => $url_server . '/_Api/Member/PendafataranMember.php',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode(array(
                                    "nama" => $nama,
                                    "kontak" => $kontak,
                                    "email" => $email,
                                    "password" => $password,
                                    "id_wilayah" => $desa,
                                    "kode_pos" => $kode_pos,
                                    "rt_rw" => $rt_rw
                                )),
                                CURLOPT_HTTPHEADER => array(
                                    'x-token: ' . $xtoken,
                                    'Content-Type: application/json'
                                ),
                            ));

                            // Tambahkan opsi ini jika Anda ingin menonaktifkan verifikasi SSL
                            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                            $response = curl_exec($curl);
                            //Konmdisi Response Error
                            if (curl_errno($curl)) {
                                $error_msg = curl_error($curl);
                                $message =$error_msg;
                                $code =201; 
                                $val_email ="";
                            }else{
                                if (empty($response)) {
                                    $message ="Tidak Ada Response Apapun";
                                    $code =201; 
                                    $val_email ="";
                                }else{
                                    $arry = json_decode($response, true);
                                    if ($arry['response']['code'] !== 200) {
                                        $val_email ="";
                                        $message =$arry['response']['message'];
                                        $code =201; 
                                    }else{
                                        $val_email =$email;
                                        $message=$arry['response']['message'];
                                        $code =$arry['response']['code'];
                                    }
                                }
                            }
                            curl_close($curl);
                        }
                    }
                }
            }
        }
    }
    //Membuat Array
    $response=[
        "email" => "$val_email",
        "message" => "$message",
        "code"=> $code
    ];
    echo json_encode($response);
    exit;
?>
