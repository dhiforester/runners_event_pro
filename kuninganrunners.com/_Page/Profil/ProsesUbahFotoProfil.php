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
        // Validasi data input tidak boleh kosong
        if(empty($_FILES['foto']['name'])){
            $ValidasiKelengkapanData="File foto tidak boleh kosong";
        }else{
            $ValidasiKelengkapanData="Valid";
        }
        if($ValidasiKelengkapanData!=="Valid"){
            $message =$ValidasiKelengkapanData;
            $code =201; 
        }else{
            //Validasi tipe dan ukuran file
            $max_size=5 * 1024 * 1024;
            $ukuran_gambar = $_FILES['foto']['size']; 
            $tipe_gambar = $_FILES['foto']['type']; 
            $tmp_gambar = $_FILES['foto']['tmp_name'];
            if($tipe_gambar == "image/jpeg"||$tipe_gambar == "image/jpg"||$tipe_gambar == "image/gif"||$tipe_gambar == "image/png"){
                if($ukuran_gambar<$max_size){
                    $ValidasiFile="Valid";
                }else{
                    $ValidasiFile="File tidak boleh lebih dari 5 mb";
                }
            }else{
                $ValidasiFile="Tipe file hanya boleh JPG, Jpeg, PNG dan GIF";
            }
            if($ValidasiFile!=="Valid"){
                $message =$ValidasiFile;
                $code =201; 
            }else{
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
                    // Mengambil konten file dan mengonversinya ke base64
                    $gambar_base64 = base64_encode(file_get_contents($tmp_gambar));
                    //Persiapan Mengirim Data Ke Server
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $url_server . '/_Api/Member/EditFoto.php',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => json_encode(array(
                            "email" => $_SESSION['email'],
                            "id_member_login" => $_SESSION['id_member_login'],
                            "base64" => $gambar_base64
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
                    }else{
                        //Apabila Tidak Ada Response
                        if (empty($response)) {
                            $message ="Tidak Ada Response Apapun";
                            $code =201; 
                        }else{
                            $arry = json_decode($response, true);
                            //Apabila Response Kode Bukan 200
                            if ($arry['response']['code'] !== 200) {
                                $message =$arry['response']['message'];
                                $code =201; 
                            }else{
                                //Apabila Berhasil
                                $_SESSION['notifikasi_proses']="Ubah Foto Profil Berhasil!";
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
    //Membuat Array
    $response=[
        "message" => "$message",
        "code"=> $code
    ];
    echo json_encode($response);
    exit;
?>
