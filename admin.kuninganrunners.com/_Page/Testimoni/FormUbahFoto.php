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
                //Buka Foto Member
                $foto=GetDetailData($Conn,'member','id_member',$id_member,'foto');
                if(empty($foto)){
                    $path_foto="assets/img/no_image.jpg";
                }else{
                    $path_foto="assets/img/Member/$foto";
                }
?>
        <input type="hidden" name="id_web_testimoni" value="<?php echo $id_web_testimoni; ?>">
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="sumber_foto">
                    <small>Sumber Foto</small>
                </label>
                <select name="sumber_foto" id="sumber_foto" class="form-control">
                    <option value="">Pilih</option>
                    <option value="upload_file">Upload Manual</option>
                    <option value="foto_profil">Foto Profil</option>
                </select>
            </div>
        </div>
        <div class="row mb-3" id="FormUploadFile">
            <div class="col-md-12">
                <label for="file_foto">
                    <small>Upload File</small>
                </label>
                <input type="file" class="form-control" name="file_foto" id="file_foto">
                <small>
                    <code class="text text-grayish" id="notifikasi_file_foto">
                        File maksimal 2 Mb dengan format JPG, JPEG, PNG, dan GIF
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-3" id="FormPreviewFoto">
            <div class="col-md-12 text-center">
                <img src="<?php echo "$path_foto"; ?>" alt="" width="180px" height="180px" class="rounded-circle">
            </div>
        </div>
<?php
            }
        }
    }
?>
<script>
    $(document).ready(function () {
        // Sembunyikan elemen pada awal
        $('#FormUploadFile').hide();
        $('#FormPreviewFoto').hide();

        // Event ketika pilihan di dropdown berubah
        $('#sumber_foto').on('change', function () {
            var selectedValue = $(this).val();

            if (selectedValue === 'upload_file') {
                // Tampilkan FormUploadFile
                $('#FormUploadFile').show();
                // Sembunyikan FormPreviewFoto
                $('#FormPreviewFoto').hide();
            } else if (selectedValue === 'foto_profil') {
                // Tampilkan FormPreviewFoto
                $('#FormPreviewFoto').show();
                // Sembunyikan FormUploadFile
                $('#FormUploadFile').hide();
            } else {
                // Jika tidak ada pilihan yang valid
                $('#FormUploadFile').hide();
                $('#FormPreviewFoto').hide();
            }
        });
    });
</script>