<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'8Ib11Wn6x94DnEfvKRq');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <section class="section dashboard">
        <div class="row mb-3">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      Berikut ini adalah halaman untuk menampilkan data viewer website.';
                    echo '      Semua record pengunjung website akan ditampilkan pada halaman ini.';
                    echo '      Informasi ini berguna untuk mengetahui kinerja website dan jumlah pengunjung yang tertarik dengan website anda.';
                    echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '  </small>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <b class="card-title">
                            <i class="bi bi-graph-down-arrow"></i> Grafik Log Viewer
                        </b>
                    </div>
                    <div class="card-body">
                        <div id="GrafikViewer">
                            <!-- Grafik Pengunjung Website Akan Ditampilkan Pada Elemen Ini -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10 mt-3">
                                <b class="card-title"><i class="bi bi-table"></i> Log Viewer</b>
                            </div>
                            <div class="col col-md-2 mt-3">
                                <button type="button" class="btn btn-md btn-outline-dark btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalFilter">
                                    <i class="bi bi-funnel"></i> Filter
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="MenampilkanTabelViewer">

                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>