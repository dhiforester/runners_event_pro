<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <?php
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                echo '  <small>';
                echo '      <code class="text-dark">';
                echo '          Halaman event digunakan untuk mengelola data penyelenggaraan event beserta dengan properti infromasi yang diperlukan.';
                echo '          Pada halaman ini penyelenggara bisa mengatur waktu pendaftaran, data peserta yang sudah mendaftar dan pembayaran biaya pendaftaran.';
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
                            <button type="button" class="btn btn-md btn-primary btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalTambahEvent">
                                <i class="bi bi-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="MenampilkanTabelEvent"></div>
    </div>
</section>