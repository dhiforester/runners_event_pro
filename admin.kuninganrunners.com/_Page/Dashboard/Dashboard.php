<?php
    //Menghitung jumlah member
    $JumlahMember= mysqli_num_rows(mysqli_query($Conn, "SELECT id_member FROM member"));
    //Jumlah Event
    $JumlahEvent = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event FROM event"));
    //Jumlah Merchandise
    $JumlahMerchandise = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang FROM barang"));
    //Jumlah Transaksi
    $JumlahTransaksi = mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi"));
?>
<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-secondary">
                                    <i class="bi bi-person-circle text-white"></i>
                                </div>
                                <div class="ps-3">
                                    <h4><?php echo $JumlahMember;?></h4>
                                    <span class="text text-grayish small pt-1">Member</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary">
                                    <i class="bi bi-calendar text-white"></i>
                                </div>
                                <div class="ps-3">
                                    <h4><?php echo $JumlahEvent;?></h4>
                                    <span class="text text-grayish small pt-1">Event</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning">
                                    <i class="bi bi-bag-check text-white"></i>
                                </div>
                                <div class="ps-3">
                                    <h4><?php echo $JumlahMerchandise;?></h4>
                                    <span class="text text-grayish small pt-1">Merch</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info">
                                    <i class="bi bi-cart text-white"></i>
                                </div>
                                <div class="ps-3">
                                    <h4><?php echo $JumlahTransaksi;?></h4>
                                    <span class="text text-grayish small pt-1">Transaksi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body" id="GrafikPendaftaranMember">
                    <!-- Line Chart Ditampilkan Disini-->
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Member<span>| 6 Pendaftar Baru</span></h5>
                    <div class="activity">
                        <?php
                            if(empty($JumlahMember)){
                                echo '<div class="activity-item d-flex">';
                                echo '  Belum Ada Pendaftar';
                                echo '</div>';
                            }else{
                                //Arraykan Pendaftaran Member
                                $QryMember = mysqli_query($Conn, "SELECT datetime, nama FROM member ORDER BY datetime DESC LIMIT 5");
                                while ($DataMember = mysqli_fetch_array($QryMember)) {
                                    $nama= $DataMember['nama'];
                                    $datetime= $DataMember['datetime'];
                                    $strtotime= strtotime($datetime);
                                    $TanggalDaftar=date('d/m/y H:i', $strtotime);
                                    echo '<div class="activity-item d-flex">';
                                    // echo '  <div class="activite-label">'.$WaktuLog.'</div>';
                                    echo '  <i class="bi bi-circle-fill activity-badge text-success align-self-start"></i>';
                                    echo '  <div class="activity-content">';
                                    echo '      <b>'.$nama.'</b><br><small class="text text-grayish"><i class="bi bi-calendar"></i> '.$TanggalDaftar.'</small>';
                                    echo '  </div>';
                                    echo '</div>';
                                }
                            }
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php
            //Menghitung jumlah member Pending
            $JumlahmemberPending= mysqli_num_rows(mysqli_query($Conn, "SELECT id_member FROM member WHERE status='Pending'"));
            $JumlahmemberPending='' . number_format($JumlahmemberPending, 0, ',', '.');
            //Menghitung jumlah member Active
            $JumlahmemberAktif= mysqli_num_rows(mysqli_query($Conn, "SELECT id_member FROM member WHERE status='Active'"));
            $JumlahmemberAktif='' . number_format($JumlahmemberAktif, 0, ',', '.');
            //Jumlah Total
            $JumlahMembertotal='' . number_format($JumlahMember, 0, ',', '.');
        ?>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <b class="card-title">Status Member</b>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col col-md-6">
                            <small>Pending</small>
                        </div>
                        <div class="col col-md-6">
                            <small>
                                <code class="text text-grayish">
                                    <?php echo "$JumlahmemberPending Orang"; ?>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-6">
                            <small>Active</small>
                        </div>
                        <div class="col col-md-6">
                            <small>
                                <code class="text text-grayish">
                                    <?php echo "$JumlahmemberAktif Orang"; ?>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-6">
                            <small>Total</small>
                        </div>
                        <div class="col col-md-6">
                            <small>
                                <code class="text text-grayish">
                                    <?php echo "$JumlahMembertotal Orang"; ?>
                                </code>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="index.php?Page=Member" class="btn btn-sm btn-outline-grayish btn-rounded">
                        <small>Halaman Member <i class="bi bi-arrow-right-circle"></i></small>
                    </a>
                </div>
            </div>
        </div>
        <?php
            $sekarang=date('Y-m-d H:i:s');
            //Menghitung Jumlah Event Rencana
            $JumlahEventRencana= mysqli_num_rows(mysqli_query($Conn, "SELECT id_event FROM event WHERE tanggal_mulai>'$sekarang'"));
            $JumlahEventRencana='' . number_format($JumlahEventRencana, 0, ',', '.');
            //Menghitung Jumlah Event Selesai
            $JumlahEventSelesai= mysqli_num_rows(mysqli_query($Conn, "SELECT id_event FROM event WHERE tanggal_mulai<'$sekarang'"));
            $JumlahEventSelesai='' . number_format($JumlahEventSelesai, 0, ',', '.');
            //Jumlah Total
            $JumlahEventTotal='' . number_format($JumlahEvent, 0, ',', '.');
        ?>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <b class="card-title">Status Event</b>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col col-md-6">
                            <small>Rencana</small>
                        </div>
                        <div class="col col-md-6">
                            <small>
                                <code class="text text-grayish">
                                    <?php echo "$JumlahEventRencana Event"; ?>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-6">
                            <small>Selesai</small>
                        </div>
                        <div class="col col-md-6">
                            <small>
                                <code class="text text-grayish">
                                    <?php echo "$JumlahEventSelesai Event"; ?>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-6">
                            <small>Total</small>
                        </div>
                        <div class="col col-md-6">
                            <small>
                                <code class="text text-grayish">
                                    <?php echo "$JumlahEventTotal Event"; ?>
                                </code>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="index.php?Page=Event" class="btn btn-sm btn-outline-grayish btn-rounded">
                        <small>Halaman Event <i class="bi bi-arrow-right-circle"></i></small>
                    </a>
                </div>
            </div>
        </div>
        <?php
            //Menghitung Jumlah Transaksi Event
            $JumlahTransaksiEvent= mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi WHERE kategori='Pendaftaran'"));
            $JumlahTransaksiEvent='' . number_format($JumlahTransaksiEvent, 0, ',', '.');
            //Menghitung Jumlah Transaksi Penjualan
            $JumlahTransaksiPenjualan= mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi WHERE kategori='Pembelian'"));
            $JumlahTransaksiPenjualan='' . number_format($JumlahTransaksiPenjualan, 0, ',', '.');
            //Jumlah Total
            $JumlahTransaksiTotal='' . number_format($JumlahTransaksi, 0, ',', '.');
        ?>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <b class="card-title">Kategori Transaksi</b>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col col-md-6">
                            <small>Event</small>
                        </div>
                        <div class="col col-md-6">
                            <small>
                                <code class="text text-grayish">
                                    <?php echo "$JumlahTransaksiEvent Record"; ?>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-6">
                            <small>Penjualan</small>
                        </div>
                        <div class="col col-md-6">
                            <small>
                                <code class="text text-grayish">
                                    <?php echo "$JumlahTransaksiPenjualan Record"; ?>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-6">
                            <small>Total</small>
                        </div>
                        <div class="col col-md-6">
                            <small>
                                <code class="text text-grayish">
                                    <?php echo "$JumlahTransaksiTotal Record"; ?>
                                </code>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="index.php?Page=RegistrasiEvent" class="btn btn-sm btn-outline-grayish btn-rounded">
                        <small>Transaksi Event <i class="bi bi-arrow-right-circle"></i></small>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                </div>
            </div>
        </div>
    </div> -->
</section>