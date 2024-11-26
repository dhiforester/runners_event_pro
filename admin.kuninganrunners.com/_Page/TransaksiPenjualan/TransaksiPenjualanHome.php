<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'ChLtm24VuMrfiotGILt');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show mobile-text" role="alert">';
                    echo '  <small>';
                    echo '      <code class="text-dark">';
                    echo '          Halaman transaksi penjualan digunakan untuk mengelola transaksi penjualan Merchandise baik yang berlangsung secara online maupun offline.';
                    echo '          Transaksi penjualan ini bisa berasal dari pelanggan yang merupakan member pada website, sehingga memerlukan peninjauan dari admin aplikasi untuk melakukan penyelesaian pembayaran.';
                    echo '          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '      </code>';
                    echo '  </small>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                
                            </div>
                            <div class="col col-md-2 mb-3">
                                <button type="button" class="btn btn-md btn-outline-dark btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalFilter">
                                    <i class="bi bi-funnel"></i> Filter
                                </button>
                            </div>
                            <div class="col col-md-2 mb-3">
                                <a href="index.php?Page=TransaksiPenjualan&Sub=Tambah" class="btn btn-md btn-primary btn-block btn-rounded">
                                    <i class="bi bi-plus"></i> Tambah
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="MenampilkanTabel"></div>
        </div>
    </section>
<?php
    }
?>