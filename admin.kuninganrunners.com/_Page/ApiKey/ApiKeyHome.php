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
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    Berikut ini adalah halaman untuk mengelola data API key. Pada halaman ini, anda bisa menambahkan data API key dan melihat log aktifitas penggunaannya.
                    API key adalah sebuah kode unik yang berfungsi untuk memberikan akses dan menghubungkan satu aplikasi dengan aplikasi lainnya.
                    Silahkan kelola data API key Disini dan gunakan kode tersebut dengan bijak.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <b>Perlu Diperhatikan!</b><br>
                    Sebaiknya anda tidak menggunakan satu API key untuk memberikan ijin akses kepada beberapa aplikasi sekaligus. 
                    Gunakan API key secara parsial sehingga mempermudah anda melakukan monitoring dalam pemanfaatan sumberdaya.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <b class="card-title">
                                    <i class="bi bi-table"></i> Data API Key
                                </b>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-md btn-outline-dark btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalFilter">
                                    <i class="bi bi-funnel"></i> Filter
                                </button>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-md btn-primary btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalTambahApiKey">
                                    <i class="bi bi-plus-lg"></i> Tambah Api Key
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="MenampilkanTabelApiKey">

                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>