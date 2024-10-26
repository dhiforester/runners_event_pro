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
                $pertanyaan_length=strlen($pertanyaan);
                $jawaban_length=strlen($jawaban);
?>
        <input type="hidden" name="id_web_faq" value="<?php echo $id_web_faq; ?>">
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="pertanyaan">
                    <small>Pertanyaan</small>
                </label>
                
                <div class="input-group">
                    <span class="input-group-text" id="inputGroupPrepend">
                        <small>
                            <code class="text text-dark" id="pertanyaan_edit_length"><?php echo $pertanyaan_length; ?>/100</code>
                        </small>
                    </span>
                    <input type="text" name="pertanyaan" id="pertanyaan_edit" class="form-control" value="<?php echo $pertanyaan; ?>">
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="jawaban">
                    <small>Jawaban</small>
                </label>
                <textarea name="jawaban" id="jawaban_edit" class="form-control"><?php echo $jawaban; ?></textarea>
                <small>
                    <code class="text text-grayish" id="jawaban_edit_length"><?php echo $jawaban_length; ?>/500</code>
                </small>
            </div>
        </div>
        <script>
            //Ketika Pertanyaan Diketik
            $('#pertanyaan_edit').on('input', function() {
                var value = $(this).val();
                var maxLength = 100;
                // Jika panjang melebihi batas, potong sesuai maxLength
                if (value.length > maxLength) {
                    value = value.substring(0, maxLength);
                }
                // Update nilai input
                $(this).val(value); 
                // Tampilkan jumlah karakter saat ini
                $('#pertanyaan_edit_length').text(value.length + '/' + maxLength);
            });
            //Ketika Jawaban Diketik
            $('#jawaban_edit').on('input', function() {
                var value = $(this).val();
                var maxLength = 500;
                // Jika panjang melebihi batas, potong sesuai maxLength
                if (value.length > maxLength) {
                    value = value.substring(0, maxLength);
                }
                // Update nilai input
                $(this).val(value); 
                // Tampilkan jumlah karakter saat ini
                $('#jawaban_edit_length').text(value.length + '/' + maxLength);
            });
        </script>
<?php
            }
        }
    }
?>