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
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="password1">
                <small>
                    Password Baru
                </small>
            </label>
            <div class="input-group">
                <span class="input-group-text" id="inputGroupPrepend">
                    <small>
                        <i class="bi bi-key"></i>
                    </small>
                </span>
                <input type="password" name="password1" id="password1_edit" class="form-control">
                <span class="input-group-text" id="inputGroupPrepend">
                    <small>
                        <code class="text text-dark" id="password1_edit_length">0/20</code>
                    </small>
                </span>
            </div>
            <small class="credit">
                <code class="text text-grayish">Password terdiri dari 6-20 karakter angka dan huruf</code>
            </small>
        </div>
        <div class="col-md-12 mb-3">
            <label for="password2">
                <small>Ulangi Password</small>
            </label>
            <div class="input-group">
                <span class="input-group-text" id="inputGroupPrepend">
                    <small>
                        <i class="bi bi-key"></i>
                    </small>
                </span>
                <input type="password" name="password2" id="password2_edit" class="form-control">
            </div>
            
            <small class="credit">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Tampilkan" id="TampilkanPassword2" name="TampilkanPassword2">
                    <label class="form-check-label" for="TampilkanPassword2">
                        <small>Tampilkan Password</small>
                    </label>
                </div>
            </small>
        </div>
    </div>
    <script>
        //Kondisi saat tampilkan password
        $('#TampilkanPassword2').click(function(){
            if($(this).is(':checked')){
                $('#password1_edit').attr('type','text');
                $('#password2_edit').attr('type','text');
            }else{
                $('#password1_edit').attr('type','password');
                $('#password2_edit').attr('type','password');
            }
        });
        var password1_edit_max_length = 20;
        function updateCharCountPasswordAkses1_edit() {
            var charCount = $('#password1_edit').val().length;
            $('#password1_edit_length').text(charCount + '/' + password1_edit_max_length);
        }
        updateCharCountPasswordAkses1_edit();
        $('#password1_edit').on('input', function() {
            var currentValue = $(this).val();
            var charCount = currentValue.length;
            // Cek apakah jumlah karakter melebihi
            if (charCount > password1_edit_max_length) {
                // Jika melebihi, batasi input
                currentValue = currentValue.substring(0, password1_edit_max_length);
            }
            // Perbarui nilai input
            $('#password1_edit').val(currentValue);
            // Update tampilan jumlah karakter
            updateCharCountPasswordAkses1_edit();
        });
    </script>
<?php 
        } 
    } 
?>