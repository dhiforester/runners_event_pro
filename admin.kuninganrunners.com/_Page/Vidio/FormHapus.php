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
                $thumbnail=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'thumbnail');
                $datetime=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'datetime');
                $strtotime1=strtotime($datetime);
                $DatetimeFormat=date('d M Y H:i',$strtotime1);
                $CuplikanPath="$base_url/assets/img/Vidio/$thumbnail";
?>
                <input type="hidden" name="id_web_vidio" value="<?php echo "$id_web_vidio"; ?>">
                <div class="row mb-3">
                    <div class="col-md-4"><small>Judul</small></div>
                    <div class="col-md-8"><small><code class="text text-grayish"><?php echo "$title_vidio"; ?></code></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><small>Sumber Vidio</small></div>
                    <div class="col-md-8"><small><code class="text text-grayish"><?php echo "$sumber_vidio"; ?></code></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><small>Datetime</small></div>
                    <div class="col-md-8"><small><code class="text text-grayish"><?php echo "$datetime"; ?></code></small></div>
                </div>
<?php
            }
        }
    }
?>