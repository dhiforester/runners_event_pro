<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <?php
                echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                echo '  Pada halaman ini, memungkinkan anda untuk membagi pengguna menjadi beberapa bagian entitas yang memiliki hak akses berbeda-beda satu dengan yang lainnya.';
                echo '  Dengan menggunakan AksesEntitas ini, dapat mempermudah anda dalam memonitoring pengguna apikasi yang dibagi dalam beberapa kelompok.';
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
                                <button type="button" class="btn btn-md btn-primary btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalTambahAksesEntitas">
                                    <i class="bi bi-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body" id="MenampilkanTabelAksesEntitas">

                </div>
            </div>
        </div>
    </div>
</section>