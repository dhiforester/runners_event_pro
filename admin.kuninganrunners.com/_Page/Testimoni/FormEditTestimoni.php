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
                <label for="penilaian_edit">
                    <small>Penilaian</small>
                </label>
                <select name="penilaian" id="penilaian_edit" class="form-control">
                    <option <?php if($penilaian==""){echo "selected";} ?> value="">Pilih</option>
                    <option <?php if($penilaian=="5"){echo "selected";} ?> value="5">Sangat Baik</option>
                    <option <?php if($penilaian=="4"){echo "selected";} ?> value="4">Baik</option>
                    <option <?php if($penilaian=="3"){echo "selected";} ?> value="3">Sedang</option>
                    <option <?php if($penilaian=="2"){echo "selected";} ?> value="2">Kurang</option>
                    <option <?php if($penilaian=="1"){echo "selected";} ?> value="1">Buruk</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="testimoni_edit">
                    <small>Testimoni</small>
                </label>
                <textarea name="testimoni" id="testimoni_edit" class="form-control"><?php echo $testimoni; ?></textarea>
                <small>
                    <code class="text text-grayish" id="testimoni_edit_length"><?php echo $testimoni_length; ?>/500</code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="status_edit">
                    <small>Status</small>
                </label>
                <select name="status" id="status_edit" class="form-control">
                    <option <?php if($status==""){echo "selected";} ?> value="">Pilih</option>
                    <option <?php if($status=="Publish"){echo "selected";} ?> value="Publish">Publish</option>
                    <option <?php if($status=="Draft"){echo "selected";} ?> value="Draft">Draft</option>
                </select>
            </div>
        </div>
<?php
            }
        }
    }
?>