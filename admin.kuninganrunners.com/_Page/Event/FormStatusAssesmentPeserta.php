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
        if(empty($_POST['id_event_assesment'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Assesment Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_event_assesment=$_POST['id_event_assesment'];
            //Bersihkan Data
            $id_event_assesment=validateAndSanitizeInput($id_event_assesment);
            //Buka Data
            $id_event_assesment_valid=GetDetailData($Conn,'event_assesment','id_event_assesment',$id_event_assesment,'id_event_assesment');
            if(empty($id_event_assesment_valid)){
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
                $id_event_assesment_form=GetDetailData($Conn,'event_assesment','id_event_assesment',$id_event_assesment,'id_event_assesment_form');
                $id_event_peserta=GetDetailData($Conn,'event_assesment','id_event_assesment',$id_event_assesment,'id_event_peserta');
                $ValueForm=GetDetailData($Conn,'event_assesment','id_event_assesment',$id_event_assesment,'assesment_value');
                $status_assesment=GetDetailData($Conn,'event_assesment','id_event_assesment',$id_event_assesment,'status_assesment');
                //Detail Form
                $form_name=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'form_name');
                $form_type=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'form_type');
                $mandatori=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'mandatori');
                //Menguraikan Status
                $status_assesment_array = json_decode($status_assesment, true);
                $status=$status_assesment_array['status_assesment'];
                $komentar=$status_assesment_array['komentar'];
?>
        <input type="hidden" name="id_event_assesment" value="<?php echo "$id_event_assesment"; ?>">
        <div class="row mb-3">
            <div class="col col-md-12">
                <small class="credit">
                    <label for="status_assesment">Status Assesment</label>
                </small>
                <select name="status_assesment" id="status_assesment" class="form-control">
                    <option <?php if($status==""){echo "selected";} ?> value="">Pilih</option>
                    <option <?php if($status=="Pending"){echo "selected";} ?> value="Pending">Pending</option>
                    <option <?php if($status=="Valid"){echo "selected";} ?> value="Valid">Valid</option>
                    <option <?php if($status=="Refisi"){echo "selected";} ?> value="Refisi">Refisi</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-12">
                <small class="credit">
                    <label for="komentar_assesment">Komentar</label>
                </small>
                <textarea name="komentar_assesment" id="komentar_assesment" class="form-control"></textarea>
                <small>
                    <code class="text text-grayish">
                        Komentar yang anda tulis akan ditampilkan pada halaman peserta.
                    </code>
                </small>
            </div>
        </div>
<?php
            }
        }
    }
?>