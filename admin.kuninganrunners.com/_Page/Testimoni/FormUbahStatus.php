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
        if(empty($_POST['id_web_testimoni'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Testimoni Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_web_testimoni=$_POST['id_web_testimoni'];
            //Bersihkan Data
            $id_web_testimoni=validateAndSanitizeInput($id_web_testimoni);
            //Buka Data
            $id_web_testimoni_Valid=GetDetailData($Conn,'web_testimoni','id_web_testimoni',$id_web_testimoni,'id_web_testimoni');
            if(empty($id_web_testimoni_Valid)){
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
                $id_member=GetDetailData($Conn,'web_testimoni','id_web_testimoni',$id_web_testimoni,'id_member');
                $penilaian=GetDetailData($Conn,'web_testimoni','id_web_testimoni',$id_web_testimoni,'penilaian');
                $testimoni=GetDetailData($Conn,'web_testimoni','id_web_testimoni',$id_web_testimoni,'testimoni');
                $sumber=GetDetailData($Conn,'web_testimoni','id_web_testimoni',$id_web_testimoni,'sumber');
                $datetime=GetDetailData($Conn,'web_testimoni','id_web_testimoni',$id_web_testimoni,'datetime');
                $status=GetDetailData($Conn,'web_testimoni','id_web_testimoni',$id_web_testimoni,'status');
                $testimoni_length=strlen($testimoni);
?>
        <input type="hidden" name="id_web_testimoni" value="<?php echo $id_web_testimoni; ?>">
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="status_edit">
                    <small>Status Testimoni</small>
                </label>
                <select name="status" id="status_edit" class="form-control">
                    <option <?php if($status==""){echo "selected";} ?> value="">Pilih</option>
                    <option <?php if($status=="Publish"){echo "selected";} ?> value="Publish">Publish</option>
                    <option <?php if($status=="Draft"){echo "selected";} ?> value="Draft">Draft</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="PemberitahuanEmail" name="PemberitahuanEmail" checked="" value="1">
                    <label class="form-check-label" for="PemberitahuanEmail">
                        <small>
                            <code class="text text-grayish">Beritahu Member Atas Perubahan Ini</code>
                        </small>
                    </label>
                </div>
            </div>
        </div>
<?php
            }
        }
    }
?>