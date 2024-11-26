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
                    echo '                  Belum Ada Data Tagihan Untuk Peserta Event Ini. Silahkan Buat Data Tagihan Terlebih Dulu.';
                    echo '              </code>';
                    echo '          </small>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="row mb-3 text-center">';
                    echo '  <div class="col-md-12">';
                    echo '      <button type="button" class="btn btn-md btn-rounded btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahTransaksiEvent" data-id="'.$id_event_peserta.'">';
                    echo '          <i class="bi bi-plus"></i> Buat Tagihan';
                    echo '      </button>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $kode_transaksi=GetDetailData($Conn,'transaksi','kode_transaksi',$id_event_peserta,'kode_transaksi');
                    $id_member=GetDetailData($Conn,'transaksi','kode_transaksi',$id_event_peserta,'id_member');
                    $raw_member=GetDetailData($Conn,'transaksi','kode_transaksi',$id_event_peserta,'raw_member');
                    $datetime=GetDetailData($Conn,'transaksi','kode_transaksi',$id_event_peserta,'datetime');
                    $tagihan=GetDetailData($Conn,'transaksi','kode_transaksi',$id_event_peserta,'tagihan');
                    $ppn_pph=GetDetailData($Conn,'transaksi','kode_transaksi',$id_event_peserta,'ppn_pph');
                    $biaya_layanan=GetDetailData($Conn,'transaksi','kode_transaksi',$id_event_peserta,'biaya_layanan');
                    $biaya_lainnya=GetDetailData($Conn,'transaksi','kode_transaksi',$id_event_peserta,'biaya_lainnya');
                    $potongan_lainnya=GetDetailData($Conn,'transaksi','kode_transaksi',$id_event_peserta,'potongan_lainnya');
                    $jumlah=GetDetailData($Conn,'transaksi','kode_transaksi',$id_event_peserta,'jumlah');
                    $status=GetDetailData($Conn,'transaksi','kode_transaksi',$id_event_peserta,'status');
                    //Format Tanggal
                    $strtotime=strtotime($datetime);
                    $datetime=date('d/m/Y H:i',$strtotime);
                    //Menghitung Biaya Lain-lain
                    $biaya_lain_lain=0;
                    if(!empty($biaya_lainnya)){
                        $biaya_lainnya_arry=json_decode($biaya_lainnya, true);
                        if(!empty(count($biaya_lainnya_arry))){
                            foreach ($biaya_lainnya_arry as $biaya_lainnya_list) {
                                $nominal_biaya=$biaya_lainnya_list['nominal_biaya'];
                                $biaya_lain_lain=$biaya_lain_lain+$nominal_biaya;
                            }
                        }
                    }
                    //Menghitung Potongan Lain-lain
                    $potongan_lain_lain=0;
                    if(!empty($potongan_lainnya)){
                        $potongan_lainnya_arry=json_decode($potongan_lainnya, true);
                        if(!empty(count($potongan_lainnya_arry))){
                            foreach ($potongan_lainnya_arry as $potongan_lainnya_list) {
                                $nominal_potongan=$potongan_lainnya_list['nominal_potongan'];
                                $potongan_lain_lain=$potongan_lain_lain+$nominal_potongan;
                            }
                        }
                    }
                    //Format Jumlah
                    $jumlah_format='Rp ' . number_format($jumlah, 0, ',', '.');
                    $ppn_pph_format='Rp ' . number_format($ppn_pph, 0, ',', '.');
                    $biaya_layanan_format='Rp ' . number_format($biaya_layanan, 0, ',', '.');
                    $biaya_lain_lain_format='Rp ' . number_format($biaya_lain_lain, 0, ',', '.');
                    $potongan_lain_lain_format='Rp ' . number_format($potongan_lain_lain, 0, ',', '.');
                    $tagihan_format='Rp ' . number_format($tagihan, 0, ',', '.');
                    //Hitung Jumlah Data Pembayaran
                    $LogPembayaran = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_payment FROM transaksi_payment WHERE kode_transaksi='$kode_transaksi'"));
                    //Sensor Kode Transaksi
                    $last_three_kode = substr($kode_transaksi, -6);
                    $masked_kode_transaksi = '****' . $last_three_kode;

?>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" class="btn btn-sm btn-outline-info btn-rounded btn-block">
                                <i class="bi bi-three-dots"></i> Option
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
                        </div>
                        <div class="col-md-10"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="list-group">
                                <li class="list-group-item hover-shadow">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Kode Transaksi</small>
                                        </div>
                                        <div class="col col-md-8 text-end">
                                            <small>
                                                <code class="text text-grayish">
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailTransaksi" data-id="<?php echo "$kode_transaksi"; ?>">
                                                        <?php echo "$masked_kode_transaksi"; ?>
                                                    </a>
                                                </code>
                                            </small>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item hover-shadow">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Tanggal/Jam</small>
                                        </div>
                                        <div class="col col-md-8 text-end">
                                            <small>
                                                <code class="text text-grayish"><?php echo "$datetime"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item hover-shadow">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Subtotal</small>
                                        </div>
                                        <div class="col col-md-8 text-end">
                                            <small>
                                                <code class="text text-grayish"><?php echo "$tagihan_format"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item hover-shadow">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>PPN</small>
                                        </div>
                                        <div class="col col-md-8 text-end">
                                            <small>
                                                <code class="text text-grayish"><?php echo "$ppn_pph_format"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item hover-shadow">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Biaya Layanan</small>
                                        </div>
                                        <div class="col col-md-8 text-end">
                                            <small>
                                                <code class="text text-grayish"><?php echo "$biaya_layanan_format"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item hover-shadow">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Biaya Lain-lain</small>
                                        </div>
                                        <div class="col col-md-8 text-end">
                                            <small>
                                                <?php
                                                    if(!empty($biaya_lain_lain)){
                                                        echo '<code class="text text-success"> '.$biaya_lain_lain_format.'</code>';
                                                    }else{
                                                        echo '<code class="text text-grayish">Rp 0</code>';
                                                    }
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item hover-shadow">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Potongan Lain-lain</small>
                                        </div>
                                        <div class="col col-md-8 text-end">
                                            <small>
                                                <?php
                                                    if(!empty($potongan_lain_lain)){
                                                        echo '<code class="text text-danger">- '.$potongan_lain_lain_format.'</code>';
                                                    }else{
                                                        echo '<code class="text text-grayish">Rp 0</code>';
                                                    }
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item hover-shadow">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Total Tagihan</small>
                                        </div>
                                        <div class="col col-md-8 text-end">
                                            <small>
                                                <code class="text text-dark text-decoration-underline"><?php echo "$jumlah_format"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item hover-shadow">
                                    <div class="row">
                                        <div class="col ol-md-4">
                                            <small>Log Pembayaran</small>
                                        </div>
                                        <div class="col col-md-8 text-end">
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
                                </li>
                                <li class="list-group-item hover-shadow">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Status Transaksi</small>
                                        </div>
                                        <div class="col col-md-8 text-end">
                                            <small>
                                            
                                                <?php 
                                                    if($status=="Pending"){
                                                        echo '<span class="badge rounded-pill bg-danger"><i class="bi bi-clock"></i> Pending</span>';
                                                    }else{
                                                        echo '<span class="badge rounded-pill bg-success"><i class="bi bi-check-circle"></i> Lunas</span>';
                                                    }
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
<?php
                }
            }
        }
    }
?>