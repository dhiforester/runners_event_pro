<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Harus Login Terlebih Dulu
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <code>Sesi Login Sudah Berakhir, Silahkan Login Ulang!</code>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Tangkap id_akses
        if(empty($_POST['id_akses'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <code>ID Akses Tidak Boleh Kosong</code>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_akses=$_POST['id_akses'];
            //Bersihkan Variabel
            $id_akses=validateAndSanitizeInput($id_akses);
            //Buka data askes
            $nama_akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'nama_akses');
            $kontak_akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'kontak_akses');
            $email_akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'email_akses');
            $image_akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'image_akses');
            $akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'akses');
            $datetime_daftar=GetDetailData($Conn,'akses','id_akses',$id_akses,'datetime_daftar');
            $datetime_update=GetDetailData($Conn,'akses','id_akses',$id_akses,'datetime_update');
            //Jumlah
            $JumlahAktivitas =mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses FROM log WHERE id_akses='$id_akses'"));
            $JumlahRole =mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM akses_ijin WHERE id_akses='$id_akses'"));
            //Format Tanggal
            $strtotime1=strtotime($datetime_daftar);
            $strtotime2=strtotime($datetime_update);
            //Menampilkan Tanggal
            $DateDaftar=date('d/m/Y H:i:s T', $strtotime1);
            $DateUpdate=date('d/m/Y H:i:s T', $strtotime2);
            if(!empty($image_akses)){
                $image_akses=$image_akses;
            }else{
                $image_akses="No-Image.png";
            }
?>
        <input type="hidden" name="id_akses" id="id_akses_edit" value="<?php echo "$id_akses"; ?>">
        <div class="row mb-3">
            <div class="col col-md-4">
                <label for="nama_akses_edit">
                    <small>Nama Lengkap</small>
                </label>
            </div>
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text" id="inputGroupPrepend">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text" name="nama_akses" id="nama_akses_edit" class="form-control" value="<?php echo "$nama_akses"; ?>">
                    <span class="input-group-text" id="inputGroupPrepend">
                        <small>
                            <code class="text text-dark" id="nama_akses_edit_length">0/100</code>
                        </small>
                    </span>
                </div>
                <small>
                    <code class="text text-grayish">Nama lengkap pengguna</code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">
                <label for="kontak_akses_edit">
                    <small>No Kontak/HP</small>
                </label>
            </div>
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text" id="inputGroupPrepend">
                        <i class="bi bi-phone"></i>
                    </span>
                    <input type="text" name="kontak_akses" id="kontak_akses_edit" class="form-control" placeholder="62" value="<?php echo "$kontak_akses"; ?>">
                    <span class="input-group-text" id="inputGroupPrepend">
                        <small>
                            <code class="text text-dark" id="kontak_akses_edit_length">0/20</code>
                        </small>
                    </span>
                </div>
                <small>
                    <code class="text text-grayish">Kontak/HP yang bisa dihubungi</code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">
                <label for="email_akses_edit">
                    <small>Email</small>
                </label>
            </div>
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text" id="inputGroupPrepend">
                        <small>
                            <i class="bi bi-envelope"></i>
                        </small>
                    </span>
                    <input type="email" name="email_akses" id="email_akses_edit" class="form-control" value="<?php echo "$email_akses"; ?>">
                </div>
                <small>
                    <code class="text text-grayish">Alamat email pengguna yang valid</code>
                </small>
            </div>
        </div>
        <script>
            //Validasi Form Tambah Akses
            var nama_akses_edit_max_length = 100;
            var kontak_akses_edit_max_length = 20;
            function updateCharCountNamaAksesEdit() {
                var charCount = $('#nama_akses_edit').val().length;
                $('#nama_akses_edit_length').text(charCount + '/' + nama_akses_edit_max_length);
            }
            function updateCharCountKontakAksesEdit() {
                var charCount = $('#kontak_akses_edit').val().length;
                $('#kontak_akses_edit_length').text(charCount + '/' + kontak_akses_edit_max_length);
            }
            // Fungsi untuk membatasi input hanya pada huruf dan spasi
            function restrictInput2(value) {
                return value.replace(/[^a-zA-Z\s]/g, '');
            }
            function restrictNumberInput2(value) {
                return value.replace(/[^0-9\s]/g, '');
            }
            updateCharCountNamaAksesEdit();
            updateCharCountKontakAksesEdit();
            $('#nama_akses_edit').on('input', function() {
                var currentValue = $(this).val();
                currentValue = restrictInput2(currentValue);
                var charCount = currentValue.length;
                // Cek apakah jumlah karakter melebihi
                if (charCount > nama_akses_edit_max_length) {
                    // Jika melebihi, batasi input
                    currentValue = currentValue.substring(0, nama_akses_edit_max_length);
                }
                // Perbarui nilai input
                $('#nama_akses_edit').val(currentValue);
                // Update tampilan jumlah karakter
                updateCharCountNamaAksesEdit();
            });
            $('#nama_akses_edit').on('change', function() {
                var currentValue = $(this).val();
                currentValue = restrictInput2(currentValue);
                var charCount = currentValue.length;
                // Cek apakah jumlah karakter melebihi
                if (charCount > nama_akses_edit_max_length) {
                    // Jika melebihi, batasi input
                    currentValue = currentValue.substring(0, nama_akses_edit_max_length);
                }
                // Perbarui nilai input
                $('#nama_akses_edit').val(currentValue);
                // Update tampilan jumlah karakter
                updateCharCountNamaAksesEdit();
            });
            $('#kontak_akses_edit').on('input', function() {
                var currentValue = $(this).val();
                currentValue = restrictNumberInput2(currentValue);
                var charCount = currentValue.length;
                // Cek apakah jumlah karakter melebihi
                if (charCount > kontak_akses_edit_max_length) {
                    // Jika melebihi, batasi input
                    currentValue = currentValue.substring(0, kontak_akses_edit_max_length);
                }
                // Perbarui nilai input
                $('#kontak_akses_edit').val(currentValue);
                // Update tampilan jumlah karakter
                updateCharCountKontakAksesEdit();
            });
            $('#kontak_akses_edit').on('change', function() {
                var currentValue = $(this).val();
                currentValue = restrictNumberInput2(currentValue);
                var charCount = currentValue.length;
                // Cek apakah jumlah karakter melebihi
                if (charCount > kontak_akses_edit_max_length) {
                    // Jika melebihi, batasi input
                    currentValue = currentValue.substring(0, kontak_akses_edit_max_length);
                }
                // Perbarui nilai input
                $('#kontak_akses_edit').val(currentValue);
                // Update tampilan jumlah karakter
                updateCharCountKontakAksesEdit();
            });
        </script>
<?php 
        } 
    } 
?>