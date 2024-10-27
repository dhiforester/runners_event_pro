<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
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
        if(empty($_POST['id_web_galeri'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Galeri Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_web_galeri=$_POST['id_web_galeri'];
            //Bersihkan Data
            $id_web_galeri=validateAndSanitizeInput($id_web_galeri);
            //Buka Data
            $id_web_galeri_valid=GetDetailData($Conn,'web_galeri','id_web_galeri',$id_web_galeri,'id_web_galeri');
            if(empty($id_web_galeri_valid)){
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
                $album=GetDetailData($Conn,'web_galeri','id_web_galeri',$id_web_galeri,'album');
                $nama_galeri=GetDetailData($Conn,'web_galeri','id_web_galeri',$id_web_galeri,'nama_galeri');
                $datetime=GetDetailData($Conn,'web_galeri','id_web_galeri',$id_web_galeri,'datetime');
                $file_galeri=GetDetailData($Conn,'web_galeri','id_web_galeri',$id_web_galeri,'file_galeri');
                $file_galeri_path="assets/img/Galeri/$file_galeri";
                $strtotime1=strtotime($datetime);
                $DatetimeFormat=date('d M Y H:i',$strtotime1);
?>
        <div class="row mb-3">
            <div class="col-md-12 text-center mb-3">
                <img src="<?php echo "$file_galeri_path"; ?>" alt="" width="50%">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">
                <small class="credit">Nama/Title</small>
            </div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish">
                        <?php echo "$nama_galeri"; ?>
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">
                <small class="credit">Album</small>
            </div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish">
                        <?php echo "$album"; ?>
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">
                <small class="credit">Datetime</small>
            </div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish">
                        <?php echo "$DatetimeFormat"; ?>
                    </code>
                </small>
            </div>
        </div>
<?php
            }
        }
    }
?>