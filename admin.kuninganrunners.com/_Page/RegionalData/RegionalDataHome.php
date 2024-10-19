<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <?php
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                echo '  <small>';
                echo '      <code class="text-dark">';
                echo '          Berikut ini adalah halaman pengelolaan referensi wilayah administratif.';
                echo '          Selanjutnya data yang ada pada halaman ini akan digunakan oleh pengguna sebagai data dasar identifikasi wilayah.';
                echo '      </code>';
                echo '  </small>';
                echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-8 mb-3"></div>
                        <div class="col col-md-2 mb-3">
                            <a class="btn btn-outline-dark btn-md btn-rounded btn-block" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i> Lanjutan
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalFilterRegionalData">
                                        <i class="bi bi-funnel"></i> Filter
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalMaintenanceRegionalData">
                                        <i class="bi bi-table"></i> Maintenance
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalWilayahByLevel">
                                        <i class="bi bi-list-check"></i> List
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col col-md-2 mb-3">
                            <button type="button" class="btn btn-md btn-primary btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalTambahRegionalData">
                                <i class="bi bi-plus-lg"></i> Tambah
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="MenampilkanTabelRegionalData">
        <!-- Tabel Data Regional Ditampilkan Disini -->
    </div>
</section>