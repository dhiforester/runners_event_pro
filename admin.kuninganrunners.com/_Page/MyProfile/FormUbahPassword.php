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
        <div class="col-md-4">
            <label for="password1">Password Baru</label>
        </div>
        <div class="col-md-8">
            <input type="password" name="password1" id="password1" class="form-control">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="password2">Ulangi Password</label>
        </div>
        <div class="col-md-8">
            <input type="password" name="password2" id="password2" class="form-control">
            <small>
                <input type="checkbox" name="TampilkanPassword" id="TampilkanPassword" value="Ya">
                <label for="TampilkanPassword">
                    <code class="text-dark">Tampilkan Password</code>
                </label>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"></div>
        <div class="col-md-8">
            <code class="text text-grayish">
                Pastikan password yang anda input memiliki 6-20 karakter yang terdiri huruf dan angka.
            </code>
        </div>
    </div>
    <script>
        //Kondisi saat tampilkan password
        $('#TampilkanPassword').click(function(){
            if($(this).is(':checked')){
                $('#password1').attr('type','text');
                $('#password2').attr('type','text');
            }else{
                $('#password1').attr('type','password');
                $('#password2').attr('type','password');
            }
        });
    </script>
<?php } ?>