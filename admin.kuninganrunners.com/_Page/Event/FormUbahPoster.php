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
        if(empty($_POST['id_event'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Event Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_event=$_POST['id_event'];
            //Bersihkan Data
            $id_event=validateAndSanitizeInput($id_event);
            //Buka Data
            $id_event_validasi=GetDetailData($Conn,'event','id_event',$id_event,'id_event');
            if(empty($id_event_validasi)){
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
                
?>
        <input type="hidden" name="id_event" value="<?php echo $id_event; ?>">
        <div class="row">
            <div class="col col-md-12 mb-3">
                <label for="poster_edit">
                    <small>Upload File Poster</small>
                </label>
                <input type="file" class="form-control" name="poster" id="poster_edit">
                <small>
                    <code class="text text-grayish">
                        File poster maksimal 5 mb (JPEG, JPG, PNG, GIF)
                    </code>
                </small>
            </div>
        </div>
<?php
            }
        }
    }
?>