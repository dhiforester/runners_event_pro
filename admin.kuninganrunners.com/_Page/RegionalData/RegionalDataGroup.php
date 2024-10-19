<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksessaya($Conn,$SessionIdAkses,'U1S6XDJxFV');
    if(empty($IjinAksesSaya)){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                    echo '  Berikut ini adalah halaman pengelolaan referensi wilayah administratif.';
                    echo '  Selanjutnya data yang ada pada halaman ini akan digunakan oleh pengguna sebagai data dasar identifikasi wilayah sesuai otoritas masing-masing pengguna.';
                    echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-8 mt-3"></div>
            <div class="col-md-2 mt-3">
                <div class="btn-group w-100">
                    <button type="button" class="btn btn-md btn-outline-dark" data-bs-toggle="modal" data-bs-target="#ModalTambahProvinsi">
                        <i class="bi bi-plus"></i> Tambah Provinsi
                    </button>
                </div>
            </div>
            <div class="col-md-2 text-center mt-3">
                <a href="index.php?Page=Wilayah" class="btn btn-md btn-dark btn-block">
                    <i class="bi bi-plus-lg"></i> Kembali
                </a>
            </div>
        </div>
        <div id="MenampilkanTabelProvinsi">
            <!-- Tabel Data Regional Ditampilkan Disini -->
        </div>
    </section>
<?php } ?>