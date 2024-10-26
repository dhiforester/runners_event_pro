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
        if(empty($_POST['id_web_faq'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID FAQ Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_web_faq=$_POST['id_web_faq'];
            //Bersihkan Data
            $id_web_faq=validateAndSanitizeInput($id_web_faq);
            //Buka Data
            $id_web_faq_valid=GetDetailData($Conn,'web_faq','id_web_faq',$id_web_faq,'id_web_faq');
            if(empty($id_web_faq_valid)){
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
                $pertanyaan=GetDetailData($Conn,'web_faq','id_web_faq',$id_web_faq,'pertanyaan');
                $jawaban=GetDetailData($Conn,'web_faq','id_web_faq',$id_web_faq,'jawaban');
?>
        <input type="hidden" name="id_web_faq" value="<?php echo $id_web_faq; ?>">
        <div class="row mb-3">
            <div class="col-md-12 mb-3">
                <small class="credit"><?php echo "$pertanyaan"; ?></small>
            </div>
            <div class="col-md-12 mb-3">
                <small class="credit">
                    <code class="text text-grayish">
                        <i>"<?php echo "$jawaban"; ?>"</i>
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-3">
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