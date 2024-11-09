<?php
    session_start();
    include "../_Config/Connection.php";
    include "../_Config/GlobalFunction.php";
    //Apabila Session Datetime expired tidak ada
    if(empty($_SESSION['datetime_expired'])){
        //Buat Xtoken
        $response=GenerateXtoken($url_server,$user_key_server,$password_server,$limit);
        $arry_res = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $xtoken ="";
        }else{
            if($arry_res['response']['code']!==200) {
                $xtoken ="";
            }else{
                $metadata = $arry_res['metadata'];
                $xtoken = $metadata['x-token'];
            }
        }
    }else{
        //Cek Apakah xtoken expired
        if(date('Y-m-d H:i:s')<$_SESSION['datetime_expired']){
            //Apabila Masih Aktif Maka Buka Dari Session
            $xtoken=$_SESSION['xtoken'];
        }else{
            //Apabila sudah Expired
            $response=GenerateXtoken($url_server,$user_key_server,$password_server,$limit);
            $arry_res = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $xtoken ="";
            }else{
                if($arry_res['response']['code']!==200) {
                    $xtoken ="";
                }else{
                    $metadata = $arry_res['metadata'];
                    $xtoken = $metadata['x-token'];
                }
            }
        }
    }
    if(empty($xtoken)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <small class="text-danger">';
        echo '          <i>Terjadi Kesalahan Pada Saat Membuat Token!</i>';
        echo '      </small>';
        echo '  </div>';
        echo '</div>';
    }else{
        $PrivacyPolicy=WebPrivacyPolicy($url_server,$xtoken);
        $array= json_decode($PrivacyPolicy, true);
        if($array['response']['code']!==200) {
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center">';
            echo '      <small class="text-danger">';
            echo '          <i>'.$array['response']['message'].'</i>';
            echo '      </small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $metadata = $array['metadata'];
            $privacy_policy = $metadata['privacy_policy'];
            //Format Tanggal
            echo '<div class="row mt-4 mb-4">';
            echo '  <div class="col-md-12">';
            echo        htmlspecialchars_decode($privacy_policy);
            echo '  </div>';
            echo '</div>';
        }
    }
?>