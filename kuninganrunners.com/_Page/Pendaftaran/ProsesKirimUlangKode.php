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
        if (empty($_POST['email'])) {
            $ValidasiKelengkapanData="Email tidak boleh kosong! Anda wajib mengisi form tersebut.";
        }else{
            $ValidasiKelengkapanData="Valid";
        }
        if($ValidasiKelengkapanData!=="Valid"){
            $message =$ValidasiKelengkapanData;
            $code =201; 
        }else{
            // Bersihkan Variabel Sebelum Dikirim
            $email = validateAndSanitizeInput($_POST['email']);
            //Persiapan Mengirim Data Ke Server
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url_server . '/_Api/Member/KirimUlangKodeVerifikasi.php',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode(array(
                    "email" => $email
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
                        $message=$arry['response']['message'];
                        $code =$arry['response']['code'];
                    }
                }
            }
            curl_close($curl);
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
