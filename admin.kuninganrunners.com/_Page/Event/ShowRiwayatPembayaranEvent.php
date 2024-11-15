<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Uang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_event_peserta'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Peserta Event Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_event_peserta=$_POST['id_event_peserta'];
            //Bersihkan Data
            $id_event_peserta=validateAndSanitizeInput($id_event_peserta);
            //Buka Data
            $id_event_peserta_validasi=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event_peserta');
            if(empty($id_event_peserta_validasi)){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
                echo '          <small class="credit">';
                echo '              <code class="text-dark">';
                echo '                  Data Yang Anda Pilih Tidak Ditemukan Pada Database!';
                echo '              </code>';
                echo '          </small>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                //Apakah Pendaftaran Event Peserta Sudah Punya Data Transaksi
                $kode_transaksi=GetDetailData($Conn,'transaksi','kode_transaksi',$id_event_peserta,'kode_transaksi');
                if(empty($kode_transaksi)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12 text-center">';
                    echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
                    echo '          <small class="credit">';
                    echo '              <code class="text-dark">';
                    echo '                  Belum Ada Data Pembayaran Untuk Peserta Event Ini. Silahkan Buat Data Transaksi Terlebih Dulu.';
                    echo '              </code>';
                    echo '          </small>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="row mb-3 text-center">';
                    echo '  <div class="col-md-12">';
                    echo '      <button type="button" class="btn btn-md btn-rounded btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahTransaksiEvent" data-id="'.$id_event_peserta.'">';
                    echo '          <i class="bi bi-plus"></i> Buat Transaksi Pembayaran';
                    echo '      </button>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    echo '<div class="list-group">';
                    $no=1;
                    $QryTransaksi = mysqli_query($Conn, "SELECT*FROM transaksi WHERE kode_transaksi='$id_event_peserta' AND kategori='Pendaftaran' ORDER BY kode_transaksi DESC");
                    while ($DataTransaksi = mysqli_fetch_array($QryTransaksi)) {
                        $kode_transaksi= $DataTransaksi['kode_transaksi'];
                        $id_member= $DataTransaksi['id_member'];
                        $raw_member= $DataTransaksi['raw_member'];
                        $datetime= $DataTransaksi['datetime'];
                        $jumlah= $DataTransaksi['jumlah'];
                        $status= $DataTransaksi['status'];
                        //Format Tanggal
                        $strtotime=strtotime($datetime);
                        $datetime=date('d M Y H:i',$strtotime);
                        //Format Jumlah
                        $jumlah_format='Rp ' . number_format($jumlah, 2, ',', '.');
                        //Hitung Jumlah Data Pembayaran
                        $LogPembayaran = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_payment FROM transaksi_payment WHERE kode_transaksi='$kode_transaksi'"));

?>
                        <div class="list-group-item list-group-item-action mt-4" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                                <span class="mb-1 text-dark"></span>
                                <small>
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                        <li class="dropdown-header text-start">
                                            <h6>Option</h6>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailTransaksi" data-id="<?php echo "$kode_transaksi"; ?>">
                                                <i class="bi bi-info-circle"></i> Detail Transaksi
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditTransaksi" data-id="<?php echo "$kode_transaksi"; ?>">
                                                <i class="bi bi-pencil"></i> Ubah/Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusTransaksi" data-id="<?php echo "$kode_transaksi"; ?>">
                                                <i class="bi bi-trash"></i> Hapus
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalLogPembayaran" data-id="<?php echo "$kode_transaksi"; ?>">
                                                <i class="bi bi-clock-history"></i> Log Pembayaran
                                            </a>
                                        </li>
                                        <?php
                                            if($status=="Pending"){
                                                echo '<li>';
                                                echo '  <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalBayarEvent" data-id="'.$kode_transaksi.'">';
                                                echo '      <i class="bi bi-coin"></i> Bayar';
                                                echo '  </a>';
                                                echo '</li>';
                                            }
                                        ?>
                                    </ul>
                                </small>
                            </div>
                            <div class="row mb-3 mt-3">
                                <div class="col-md-3">
                                    <small>Kode Transaksi</small>
                                </div>
                                <div class="col-md-9">
                                    <small>
                                        <code class="text text-grayish">
                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailTransaksi" data-id="<?php echo "$kode_transaksi"; ?>">
                                                <?php echo "$kode_transaksi"; ?>
                                            </a>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3 mt-3">
                                <div class="col-md-3">
                                    <small>Dibuat Pada</small>
                                </div>
                                <div class="col-md-9">
                                    <small>
                                        <code class="text text-grayish"><?php echo "$datetime"; ?></code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <small>Nominal</small>
                                </div>
                                <div class="col-md-9">
                                    <small>
                                        <code class="text text-grayish"><?php echo "$jumlah_format"; ?></code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <small>Log Pembayaran</small>
                                </div>
                                <div class="col-md-9">
                                    <small>
                                        <?php 
                                            if(empty($LogPembayaran)){
                                                echo '<code>Tidak Ada</code>';
                                            }else{
                                                echo '<code class="text text-grayish">'.$LogPembayaran.' Record</code>';
                                            }
                                        ?>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <small>Status Transaksi</small>
                                </div>
                                <div class="col-md-9">
                                    <small>
                                        <?php 
                                            if($status=="Pending"){
                                                echo '<code>Pending</code>';
                                            }else{
                                                echo '<code class="text text-success">Lunas</code>';
                                            }
                                        ?>
                                    </small>
                                </div>
                            </div>
                        </div>
<?php
                    $no++;
                    }
                    echo '</div>';
                }
            }
        }
    }
?>