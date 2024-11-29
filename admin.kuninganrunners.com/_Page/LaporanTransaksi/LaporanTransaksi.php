<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'1hhuWX92twjdXcUq5D2');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        // Ambil data filter dari form
        if(empty($_POST['periode'])){
            $periode="Bulanan";
        }else{
            $periode=$_POST['periode'];
        }
        if(empty($_POST['periode_tahun'])){
            $tahun=date('Y');
        }else{
            $tahun=$_POST['periode_tahun'];
        }
        if(empty($_POST['periode_bulan'])){
            $bulan=date('m');
        }else{
            $bulan=$_POST['periode_bulan'];
        }
        $nama_bulan=getNamaBulan($bulan);
?>
    <form action="javascript:void(0);" id="FormFilterLaporanTransaksi">
        <input type="hidden" name="periode" value="<?php echo $periode; ?>">
        <input type="hidden" name="tahun" value="<?php echo $tahun; ?>">
        <input type="hidden" name="bulan" value="<?php echo $bulan; ?>">
    </form>
    <section class="section dashboard">
        <div class="row mb-3">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      Berikut ini adalah halaman laporan transaksi untuk menampilkan rekapitulasi transaksi secara spesifik.';
                    echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '  </small>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center text-dark">
                        <h3>
                            Laporan Transaksi <?php echo $periode; ?>
                        </h3>
                        <?php 
                            if($periode=="Harian"){
                                echo "Bulan $nama_bulan Tahun $tahun"; 
                            }else{
                                echo "Tahun $tahun"; 
                            }
                        ?>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col col-md-12 mb-3 text-center">
                                <button type="button" class="btn btn-md btn-outline-dark btn-rounded" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalFilterGrapik" >
                                    <i class="bi bi-filter"></i> Filter Laporan
                                </button>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col col-md-12 mb-3" id="ShowGrafikLaporanTransaksi">
                                <!-- Show Grafik Laporan Transaksi -->
                            </div>
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
                            <div class="col-md-12 mt-3">
                                <b class="card-title"><i class="bi bi-table"></i> Log Transaksi</b>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="MenampilkanTabelTransaksi">
                        <!-- Menampilkan Tabel Transaksi -->
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>