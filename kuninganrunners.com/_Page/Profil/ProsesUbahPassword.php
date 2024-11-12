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
        //Validasi Session
        if(empty($_SESSION['id_member_login'])){
            $ValidasiSessionMember="Silahkan login terlebih dulu!";
        }else{
            if($_SESSION['login_expired']<date('Y-m-d H:i:s')){
                $expiredDate=$_SESSION['login_expired'];
                $ValidasiSessionMember="Sesi Akses Member Sudah Berakhir Pada $expiredDate, Silahkan Login Ulang!";
            }else{
                $ValidasiSessionMember="Valid";
            }
        }
        if($ValidasiSessionMember!=="Valid"){
            $message =$ValidasiSessionMember;
            $code =201; 
        }else{
            // Validasi data input tidak boleh kosong
            if (empty($_POST['password'])) {
                $ValidasiKelengkapanData="Password tidak boleh kosong! Anda wajib mengisi form tersebut.";
            }else{
                if (empty($_POST['ulangi_password'])) {
                    $ValidasiKelengkapanData="Password Harus Sama!";
                }else{
                    $ValidasiKelengkapanData="Valid";
                }
            }
            if($ValidasiKelengkapanData!=="Valid"){
                $message =$ValidasiKelengkapanData;
                $code =201; 
                $val_email ="";
            }else{
                // Validasi panjang karakter
                if (strlen($_POST['password']) > 20) { 
                    $ValidasiJumlahKarakter='Password tidak boleh lebih dari 20 karakter.'; 
                }else{
                    $ValidasiJumlahKarakter="Valid";
                }
                if($ValidasiJumlahKarakter!=="Valid"){
                    $message =$ValidasiJumlahKarakter;
                    $code =201; 
                    $val_email ="";
                }else{
                    //Validasi Tipe Data
                    if (!ctype_alnum($_POST['password'])) {
                        $ValidasiTipeData='Password hanya boleh huruf dan angka.';
                    }else{
                        $ValidasiTipeData='Valid';
                    }
                    if($ValidasiTipeData!=="Valid"){
                        $message =$ValidasiTipeData;
                        $code =201; 
                        $val_email ="";
                    }else{
                        // Bersihkan Variabel Sebelum Dikirim
                        $email = $_SESSION['email'];
                        $id_member_login = $_SESSION['id_member_login'];
                        $password = validateAndSanitizeInput($_POST['password']);
                        $ulangi_password = validateAndSanitizeInput($_POST['ulangi_password']);
                        //Validasi Password Harus Sama
                        if($password!==$ulangi_password){
                            $message ="Password yang anda masukan tidak sama";
                            $code =201; 
                        }else{
                            //Persiapan Mengirim Data Ke Server
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => $url_server . '/_Api/Member/UbahPassword.php',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode(array(
                                    "email" => $email,
                                    "id_member_login" => $id_member_login,
                                    "password_baru" => $password
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
