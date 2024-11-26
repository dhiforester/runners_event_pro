<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'o1Gi8RxeSp97NsUece2');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        if(empty($_GET['id'])){
            echo '<section class="section dashboard">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12">';
            echo '          <div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '              <small>';
            echo '                  Kode Transaksi Tidak Boleh Kosong.';
            echo '                  Silahkan kembali ke halaman yang benar!';
            echo '              </small>';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</section>';
        }else{
            $kode_transaksi=$_GET['id'];
?>
    <input type="hidden" name="kode_transaksi" id="GetKodeTransaksi" value="<?php echo "$kode_transaksi"; ?>">
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show mobile-text" role="alert">';
                    echo '  <small>';
                    echo '      <code class="text-dark">';
                    echo '          Berikut ini adalah halaman detail transaksi yang digunakan untuk mengelola dan melakukan perubahan pada data transaksi penjualan.';
                    echo '          Pada halaman ini anda bisa melakukan pembaharuan status transaksi, melengkapi informasi pengiriman dan memperbaharui data pembayaran.';
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
                            <div class="col-md-10 mb-2">
                                <h1 class="card-title">
                                    <i class="bi bi-info-circle"></i> Detail Transaksi
                                </h1>
                            </div>
                            <div class="col-md-2 mb-2">
                                <a href="index.php?Page=TransaksiPenjualan" class="btn btn-block btn-md btn-dark btn-rounded mt-3">
                                    <i class="bi bi-chevron-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <b>A. Informasi Transaksi</b>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body" id="ShowInformasiTransaksi">
                                        <!-- Show Informasi Transaksi Akan Muncul Disini -->
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <b>B. Informasi Member</b>
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body" id="ShowInformasiMember">
                                        <!-- Show Informasi Member Akan Muncul Disini -->
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <b>C. Pembayaran</b>
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body" id="ShowPembayaran">
                                        <!-- Informasi Pembayaran Akan Muncul Disini -->
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        <b>D. Pengiriman</b>
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body" id="ShowPengiriman">
                                        <!-- Informasi Pengiriman Akan Muncul Disini -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <small>
                                    Kode Transaksi : 
                                    <code class="text text-grayish">
                                        <?php echo $kode_transaksi; ?>
                                    </code>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
        }
    }
?>