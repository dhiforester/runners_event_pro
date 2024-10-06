<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <?php
                echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                echo '  Berikut ini adalah halaman pengelolaan data fitur aplikasi yang digunakan oleh pengembang untuk memetakan ijin akses setiap pengguna pada halaman dan modul aplikasi.';
                echo '  Penting untuk diketahui bahwa mengubah data pada halaman ini, akan merubah aturan khusus pada fitur yang digunakan.';
                echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <form action="javascript:void(0);" id="ProsesBatas">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-md btn-outline-dark btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalFilter">
                                    <i class="bi bi-funnel"></i> Filter
                                </button>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-md btn-primary btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalTambahFitur">
                                    <i class="bi bi-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body" id="MenampilkanTabelFitur">

                </div>
            </div>
        </div>
    </div>
</section>