<?php
    session_start();
    date_default_timezone_set('Asia/Jakarta');
    include "../_Config/Connection.php";
    include "../_Config/GlobalFunction.php";
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
    if(empty($xtoken)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <small class="text-danger">';
        echo '          <i>Terjadi Kesalahan Pada Saat Membuat Token!</i>';
        echo '      </small>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Buat Session
        $_SESSION['datetime_expired'] = $datetime_expired;
        $_SESSION['xtoken'] = $xtoken;
        //Buka Data
        $TermOfService=WebTermOfService($url_server,$xtoken);
        $array= json_decode($TermOfService, true);
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
            $term_of_service = $metadata['term_of_service'];
            //term_of_service
            echo '<div class="row mt-4 mb-4">';
            echo '  <div class="col-md-12">';
            echo        htmlspecialchars_decode($term_of_service);
            echo '  </div>';
            echo '</div>';
        }
    }
?>