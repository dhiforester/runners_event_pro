<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'5MH1cfu7LzOpalmhbT2');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                    echo '  Berikut ini adalah halaman untuk mengelola bantuan pengguna.';
                    echo '  Halaman ini membantu pengembang dalam menyampaikan petunjuk penggunaan dan berbagai kendala yang mungkkin saja terjadi.';
                    echo '  Buat berbagai artikel yang berkaitan dengan cara penggunaan aplikasi sehingga membantu pengguna dalam memahami aplikasi lebih cepat.';
                    echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-6 mt-3">
                                <b class="card-title">Kelola Data Bantuan</b>
                            </div>
                            <div class="col-md-2 mt-3">
                                <a class="btn btn-md btn-outline-grayish btn-rounded w-100" href="index.php?Page=Help&Sub=HelpHome">
                                    <i class="bi bi-eye"></i> Preview
                                </a>
                            </div>
                            <div class="col-md-2 mt-3">
                                <a class="btn btn-md btn-outline-dark btn-rounded w-100" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalFilter">
                                    <i class="bi bi-filter"></i> Filter
                                </a>
                            </div>
                            <div class="col-md-2 mt-3">
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalTambahBantuan" class="btn btn-md btn-primary btn-block btn-rounded">
                                    <i class="bi bi-save"></i> Tambah
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="MenampilkanTabelHelp">
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>