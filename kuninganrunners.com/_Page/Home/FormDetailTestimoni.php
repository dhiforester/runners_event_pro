<?php
    session_start();
    date_default_timezone_set('Asia/Jakarta');
    if(empty($_POST['id_web_testimoni'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <small class="text-danger">';
        echo '          <i>Tidak Ada ID Testimoni Yang Dipilih!</i>';
        echo '      </small>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_web_testimoni=$_POST['id_web_testimoni'];
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
            $DetailTestimoni=WebDetailTestimoni($url_server,$xtoken,$id_web_testimoni);
            $arry_detail_testimoni = json_decode($DetailTestimoni, true);
            if($arry_detail_testimoni['response']['code']!==200) {
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center">';
                echo '      <small class="text-danger">';
                echo '          <i>'.$arry_detail_testimoni['response']['message'].'</i>';
                echo '      </small>';
                echo '  </div>';
                echo '</div>';
            }else{
                $metadata = $arry_detail_testimoni['metadata'];
                $nama = $metadata['nama'];
                $penilaian = $metadata['penilaian'];
                $testimoni = $metadata['testimoni'];
                $datetime = $metadata['datetime'];
                $foto_profil = $metadata['foto_profil'];
                if(empty($foto_profil)){
                    $foto_profil="assets/img/No-Image.png";
                }
                //Format Tanggal
                $strtotime=strtotime($datetime);
                $datetime_format=date('d M Y H:i',$strtotime);
                echo '<div class="row mt-4 mb-4">';
                echo '  <div class="col-md-12 text-center">';
                echo '      <img src="'.$foto_profil.'" class="img-thumbnail mb-3" alt="" width="200px">';
                echo '      <h3>'.$nama.'</h3>';
                echo '      <h5>'.$datetime_format.'</h5>';
                echo '      <div class="stars">';
                            for ($i = 1; $i <= $penilaian; $i++) {
                                echo '<i class="bi bi-star-fill text-warning"></i>';
                            }
                echo '      </div>';
                echo '      <p>';
                echo '          <i class="bi bi-quote quote-icon-left"></i><small>'.$testimoni.'</small><i class="bi bi-quote quote-icon-right"></i>';
                echo '      </p>';
                echo '  </div>';
                echo '</div>';
            }
        }
    }
?>