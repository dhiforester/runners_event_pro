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
        $nama=GetDetailData($Conn,'akses','id_akses',$id_akses,'nama_akses');
        $kontak=GetDetailData($Conn,'akses','id_akses',$id_akses,'kontak_akses');
        $email=GetDetailData($Conn,'akses','id_akses',$id_akses,'email_akses');
?>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="nama_akses">Nama Lengkap</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="nama_akses" id="nama_akses" class="form-control" value="<?php echo "$nama"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="kontak_akses">Nomor Kontak</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="kontak_akses" id="kontak_akses" class="form-control" value="<?php echo "$kontak"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="email">Email</label>
        </div>
        <div class="col-md-8">
            <input type="email" name="email" id="email" class="form-control" value="<?php echo "$email"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <code class="text text-grayish">
                Pastikan informasi profil yang anda input sudah sesuai.
            </code>
        </div>
    </div>
    <script>
        $('#kontak_akses').on('input', function() {
            var value = this.value.replace(/[^0-9]/g, '');
            this.value = value;
        });
    </script>
<?php } ?>