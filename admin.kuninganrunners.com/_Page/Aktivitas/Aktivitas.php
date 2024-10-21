<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'eoR7DjC6Nl2EoqOGxb6');
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
                    echo '      Berikut ini adalah halaman log aktivitas aplikasi.';
                    echo '      Semua record aktivitas pengguna pada sistem tercatat pada halaman ini.';
                    echo '      Informasi aktivitas berguna untuk membantu dalam pemantauan keamanan sistem dan pemanfaatan aplikasi oleh pengguna.';
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
                            <i class="bi bi-graph-down-arrow"></i> Grafik Log Aktivitas
                        </b>
                    </div>
                    <div class="card-body">
                        <div id="reportsChart">
                            <!-- Line Chart -->
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
                            <div class="col-md-8 mt-3">
                                <b class="card-title"><i class="bi bi-table"></i> Log Aktivitas</b>
                            </div>
                            <div class="col col-md-2 mt-3">
                                <button type="button" class="btn btn-md btn-outline-dark btn-block btn-rounded" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-filter"></i> Grafik
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalGrafik" data-id="id_akses">
                                            <i class="bi bi-graph-up-arrow"></i> Grafik By User Akses
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalGrafik" data-id="kategori_log">
                                            <i class="bi bi-graph-up-arrow"></i> Grafik By Kategori
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col col-md-2 mt-3">
                                <button type="button" class="btn btn-md btn-outline-dark btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalFilterAktivitasUmum">
                                    <i class="bi bi-funnel"></i> Filter
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="MenampilkanTabelAktivitasUmum">

                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>