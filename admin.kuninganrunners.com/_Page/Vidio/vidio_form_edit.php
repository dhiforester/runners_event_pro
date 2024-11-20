<?php
    if(empty($_POST['sumber_vidio'])){
        $sumber_vidio="Local";
    }else{
        $sumber_vidio=$_POST['sumber_vidio'];
    }
    if(empty($_POST['value_vidio'])){
        $value_vidio="";
    }else{
        $value_vidio=$_POST['value_vidio'];
    }
    if($sumber_vidio=="Local"){
        echo '<label for="vidio_edit"><small>File Vidio</small></label>';
        echo '<input type="file" name="vidio" id="vidio_edit" accept="video/*" class="form-control">';
        echo '<small id="ValidasiFileGaleriEdit">';
        echo '  <code class="text text-grayish">';
        echo '      File yang digunakan maksimal 10 MB (mp4, webm, ogg, AVI, QuickTime, MPEG, 3GP, FLV, WMV)';
        echo '  </code>';
        echo '</small>';
    }else{
        if($sumber_vidio=="Url"){
            echo '<label for="vidio_edit"><small>Link/Url Vidio</small></label>';
            echo '<input type="text" name="vidio" id="vidio_edit" class="form-control" placeholder="https://" value="">';
            echo '<small>';
            echo '  <code class="text text-grayish">';
            echo '      Masukan link/url vidio yang anda miliki secara lengkap.';
            echo '  </code>';
            echo '</small>';
        }else{
            echo '<label for="vidio_edit"><small>Embed Code Vidio</small></label>';
            echo '<textarea name="vidio" id="vidio_edit" class="form-control"></textarea>';
        }
    }
?>
<!-- Routing Script -->
<?php
    if($sumber_vidio=="Local"){
?>
    <script>
        // Validasi file Vidio
        $('#vidio_edit').on('change', function() {
            var file = this.files[0];
            var validTypes = ['video/mp4', 'video/webm', 'video/ogg', 'video/x-msvideo', 'video/quicktime', 'video/mpeg', 'video/3gpp', 'video/x-flv', 'video/x-ms-wmv'];
            var maxSize = 10 * 1024 * 1024; // 2MB
            var validasiMessage = $('#ValidasiFileGaleriEdit');

            if (file) {
                if ($.inArray(file.type, validTypes) == -1) {
                    $('#ValidasiFileGaleriEdit').html('<code class="text text-danger">Tipe file tidak valid. Hanya diperbolehkan mp4, webm, ogg, AVI, QuickTime, MPEG, 3GP, FLV, WMV.</code>');
                    this.value = '';
                } else if (file.size > maxSize) {
                    $('#ValidasiFileGaleriEdit').html('<code class="text text-danger">Ukuran file maksimal 10 MB.</code>');
                    this.value = '';
                } else {
                    $('#ValidasiFileGaleriEdit').html('<code class="text text-success">File sudah valid dan sesuai persyaratan.</code>');
                }
            }
        });
    </script>
<?php } ?>