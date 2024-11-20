<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Uang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_web_vidio'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Konten Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_web_vidio=$_POST['id_web_vidio'];
            //Bersihkan Data
            $id_web_vidio=validateAndSanitizeInput($id_web_vidio);
            //Buka Data
            $id_web_vidio_validasi=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'id_web_vidio');
            if(empty($id_web_vidio_validasi)){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                echo '          <small class="credit">';
                echo '              <code class="text-dark">';
                echo '                  Data Yang Anda Pilih Tidak Ditemukan Pada Database!';
                echo '              </code>';
                echo '          </small>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $sumber_vidio=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'sumber_vidio');
                $title_vidio=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'title_vidio');
                $deskripsi=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'deskripsi');
                $vidio=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'vidio');
                $datetime=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'datetime');
                $strtotime1=strtotime($datetime);
                $DatetimeFormat=date('d M Y H:i',$strtotime1);
                //Url Image
                if($sumber_vidio=="Local"){
                    $GaleriPath="$base_url/assets/img/Vidio/$vidio";
                }else{
                    if($sumber_vidio=="Url"){
                        $GaleriPath=$vidio;
                    }else{
                        // Regex untuk mengekstrak nilai src
                        preg_match('/src="([^"]+)"/', $vidio, $matches);
                        // Cek apakah src ditemukan
                        if (isset($matches[1])) {
                            $GaleriPath = $matches[1];
                        } else {
                            $GaleriPath="";
                        }
                    }
                }
?>
        <div class="row mb-3">
            <div class="col-md-12 text-center">
                <?php
                    echo '<iframe width="100%" height="350" src="'.$GaleriPath.'" title="'.$title_vidio.'" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
                ?>
            </div>
            <div class="col col-md-12">
                <small class="credit">
                    <?php echo "$title_vidio"; ?>
                </small>
                <br>
                <small class="text text-grayish">
                    <i class="bi bi-tag"></i> <?php echo "$sumber_vidio"; ?>
                </small>
                <br>
                <small class="text-grayish">
                    <i class="bi bi-calendar"></i> <?php echo "$DatetimeFormat"; ?>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-12">
                <small class="credit">
                    <code class="text text-grayish">
                        <?php echo "$deskripsi"; ?>
                    </code>
                </small>
            </div>
        </div>
<?php
            }
        }
    }
?>