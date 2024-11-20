<?php
    session_start();
    date_default_timezone_set('Asia/Jakarta');
    if(empty($_POST['id_web_vidio'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <small class="text-danger">';
        echo '          <i>Tidak Ada ID Vidio Yang Dipilih!</i>';
        echo '      </small>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_web_vidio=$_POST['id_web_vidio'];
        include "../../_Config/Connection.php";
        include "../../_Config/GlobalFunction.php";
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
            $_SESSION['datetime_expired'] = $datetime_expired;
            $_SESSION['xtoken'] = $xtoken;
            $DetailVidio=WebDetailVidio($url_server,$xtoken,$id_web_vidio);
            $arry_detail_vidio = json_decode($DetailVidio, true);
            if($arry_detail_vidio['response']['code']!==200) {
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center">';
                echo '      <small class="text-danger">';
                echo '          <i>'.$arry_detail_vidio['response']['message'].'</i>';
                echo '      </small>';
                echo '  </div>';
                echo '</div>';
            }else{
                $metadata = $arry_detail_vidio['metadata'];
                $title_vidio = $metadata['title_vidio'];
                $deskripsi = $metadata['deskripsi'];
                $datetime = $metadata['datetime'];
                $iframe = $metadata['iframe'];
                //Format Tanggal
                $strtotime=strtotime($datetime);
                $datetime_format=date('d M Y H:i',$strtotime);
                echo '<div class="row mt-4">';
                echo '  <div class="col-md-12">';
                echo '      '.$iframe.'';
                echo '  </div>';
                echo '</div>';
                echo '<div class="row mb-4">';
                echo '  <div class="col-md-12 text-center">';
                echo '      <h4>'.$title_vidio.'</h4>';
                echo '      <small><i>'.$datetime_format.'</i></small>';
                echo '      <p>';
                echo '          <i class="bi bi-quote quote-icon-left"></i><small>'.$deskripsi.'</small><i class="bi bi-quote quote-icon-right"></i>';
                echo '      </p>';
                echo '  </div>';
                echo '</div>';
                echo '<div class="row mb-4">';
                echo '  <div class="col-md-12 text-center">';
                echo '      <button type="button" class="button-back" data-bs-dismiss="modal">';
                echo '          <i class="bi bi-x-circle"></i> Tutup';
                echo '      </button>';
                echo '  </div>';
                echo '</div>';
            }
        }
    }
?>