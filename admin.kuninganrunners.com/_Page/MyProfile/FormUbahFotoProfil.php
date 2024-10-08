<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Tangkap id_akses
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12 text-center text-danger">Sessi Login Sudah Berakhir, Silahkan Login Ulang Terlebih Dulu</div>';
        echo '</div>';
    }else{
        $id_akses=$SessionIdAkses;
?>
    <div class="row mb-3">
        <div class="col-md-12">
            <label for="foto_saya">Upload Foto Profil Baru</label>
            <input type="file" name="foto_saya" id="foto_saya" class="form-control">
            <small class="credit" id="ValidasiFileFoto">
                <code class="text text-grayish">
                    Pastikan foto yang anda upload tidak lebih dari 2 Mb (PNG, JPG, JPEG, GIF) 
                </code>
            </small>
            <div id="error-message"></div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#foto_saya').on('change', function() {
                var file = this.files[0];
                var fileType = file.type;
                var fileSize = file.size;
                var validImageTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];

                if ($.inArray(fileType, validImageTypes) < 0) {
                    $('#error-message').html('<code>Format file tidak valid. Harap unggah file dengan format PNG, JPG, JPEG, atau GIF.</code>');
                    this.value = '';
                } else if (fileSize > 2 * 1024 * 1024) {
                    $('#error-message').html('<code>Ukuran file melebihi 2 MB. Harap unggah file yang lebih kecil.</code>');
                    this.value = '';
                } else {
                    $('#error-message').html('<code class="text-success">File siap di upload</code>');
                }
            });
        });
    </script>
<?php } ?>