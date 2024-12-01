<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'gd7YgKyL1WMQctJLgaq');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <section class="section dashboard">
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <small class="mobile-text">
                        Berikut ini adalah halaman untuk mengelola data API key. 
                        API key adalah sebuah kode unik yang berfungsi untuk memvalidasi penggunan service yang tersedia.
                        Pada halaman ini, anda bisa menambahkan data API key dan melihat log aktivitas penggunaannya.
                        Lebih lanjut silahkan lihat dokumentasi 
                        <a href="https://www.postman.com/rsuelsyifa/kuningan-runners/collection/5uknkuv/restful-api-basics-blueprint" target="_blank">postman berikut ini</a>.
                    </small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <b class="card-title">
                                    <i class="bi bi-table"></i> Data API Key
                                </b>
                            </div>
                            <div class="col col-md-2 mb-3">
                                <button type="button" class="btn btn-md btn-outline-dark btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalFilter">
                                    <i class="bi bi-funnel"></i> Filter
                                </button>
                            </div>
                            <div class="col col-md-2 mb-3">
                                <button type="button" class="btn btn-md btn-primary btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalTambahApiKey">
                                    <i class="bi bi-plus-lg"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="MenampilkanTabelApiKey">
                <!-- Menampilkan List API Key -->
            </div>
        </div>
    </section>
<?php } ?>