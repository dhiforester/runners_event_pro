<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <?php
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                echo '  <small>';
                echo '      <code class="text-dark">';
                echo '          Berikut ini adalah halaman transaksi pembayaran untuk pendaftaran event.';
                echo '          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '      </code>';
                echo '  </small>';
                echo '</div>';
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 mb-3"></div>
        <div class="col col-md-2 mb-3">
            <button type="button" class="btn btn-md btn-outline-dark btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalFilter">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="MenampilkanTabelRegistrasiEvent">
            <!-- Menampilkan Data Merchandise -->
        </div>
    </div>
</section>