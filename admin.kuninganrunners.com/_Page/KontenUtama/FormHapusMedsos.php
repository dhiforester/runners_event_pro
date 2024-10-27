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
        if(empty($_POST['id_web_medsos'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Medsos Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_web_medsos=$_POST['id_web_medsos'];
            //Bersihkan Data
            $id_web_medsos=validateAndSanitizeInput($id_web_medsos);
            //Buka Data
            $id_web_medsos_valid=GetDetailData($Conn,'web_medsos','id_web_medsos',$id_web_medsos,'id_web_medsos');
            if(empty($id_web_medsos_valid)){
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
                $nama_medsos=GetDetailData($Conn,'web_medsos','id_web_medsos',$id_web_medsos,'nama_medsos');
                $url_medsos=GetDetailData($Conn,'web_medsos','id_web_medsos',$id_web_medsos,'url_medsos');
                $logo=GetDetailData($Conn,'web_medsos','id_web_medsos',$id_web_medsos,'logo');
                $url_logo="assets/img/Medsos/$logo";
?>
        <input type="hidden" name="id_web_medsos" value="<?php echo $id_web_medsos; ?>">
        <div class="row mb-3">
            <div class="col col-md-4">
                <small class="credit">Nama Medsos</small>
            </div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish">
                        <?php echo "$nama_medsos"; ?>
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">
                <small class="credit">URL Medsos</small>
            </div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish">
                        <?php echo "$url_medsos"; ?>
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">
                <small class="credit">Logo</small>
            </div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish">
                        <?php echo "$logo"; ?>
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-12">
                <small class="text-primary">
                    Apakah anda yakin akan menghapus data tersebut?
                </small>
            </div>
        </div>
<?php
            }
        }
    }
?>