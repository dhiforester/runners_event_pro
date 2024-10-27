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
                //Format Waktu
                $strtotime1=strtotime($datetime);
                $DatetimeFormat=date('d M Y H:i',$strtotime1);
                //Buka Member
                $nama=GetDetailData($Conn,'member','id_member',$id_member,'nama');
                $email=GetDetailData($Conn,'member','id_member',$id_member,'email');
                //Format Status
                if($status=="Publish"){
                    $status='<badge class="badge badge-success">Publish</badge>';
                }else{
                    $status='<badge class="badge badge-warning">Draft</badge>';
                }
?>
        <input type="hidden" name="id_web_testimoni" value="<?php echo $id_web_testimoni; ?>">
        <div class="row mb-3">
            <div class="col col-md-4">
                <small class="credit">Nama Member</small>
            </div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish">
                        <?php echo "$nama"; ?>
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">
                <small class="credit">Email</small>
            </div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish">
                        <?php echo "$email"; ?>
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">
                <small class="credit">Penilaian</small>
            </div>
            <div class="col col-md-8">
                <small class="credit">
                    <?php 
                        for ($i = 1; $i <= $penilaian; $i++) {
                            echo '<i class="bi bi-star-fill text-warning"></i>';
                        }
                    ?>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">
                <small class="credit">Sumber</small>
            </div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish">
                        <?php echo "$sumber"; ?>
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">
                <small class="credit">Status</small>
            </div>
            <div class="col col-md-8">
                <small class="credit">
                    <?php echo "$status"; ?>
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
        <div class="row mb-3">
            <div class="col-md-4">
                <small class="credit">Testimoni</small>
            </div>
            <div class="col-md-8">
                <small class="credit">
                    <code class="text text-grayish">
                        <?php echo "$testimoni"; ?>
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <small class="text-primary">
                    Apakah anda yakin akan menghapus data ini?
                </small>
            </div>
        </div>
<?php
            }
        }
    }
?>