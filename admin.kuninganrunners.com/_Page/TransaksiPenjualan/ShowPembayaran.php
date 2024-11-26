<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-2">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit mobile-text">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Uang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['kode_transaksi'])){
            echo '<div class="row mb-2">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit mobile-text">';
            echo '              <code class="text-dark">';
            echo '                  Kode Transaksi Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $kode_transaksi=$_POST['kode_transaksi'];
            //Bersihkan Data
            $kode_transaksi=validateAndSanitizeInput($kode_transaksi);
            //Buka Data
            $kode_transaksi_validasi=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kode_transaksi');
            if(empty($kode_transaksi_validasi)){
                echo '<div class="row mb-2">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                echo '          <small class="credit mobile-text">';
                echo '              <code class="text-dark">';
                echo '                  Data Yang Anda Pilih Tidak Ditemukan Pada Database!';
                echo '              </code>';
                echo '          </small>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_payment FROM transaksi_payment WHERE kode_transaksi='$kode_transaksi'"));
                
?>
                <div class="row mb-3 mt-3">
                    <div class="col-md-10 mb-3">
                        <small>
                            <b>Keterangan :</b>
                            <code class="text text-grayish">
                                Data Pembayaran (Order ID) hanya berlaku untuk 1 (satu) kali proses.
                            </code>
                        </small>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="button" class="btn btn-md btn-outline-info btn-block" data-bs-toggle="modal" data-bs-target="#ModalTambahPembayaran" data-id="<?php echo "$kode_transaksi"; ?>">
                            <i class="bi bi-plus"></i> Bayar
                        </button>
                    </div>
                </div>
                <?php
                    if(empty($jml_data)){
                        echo '<div class="row mb-2">';
                        echo '  <div class="col-md-12">';
                        echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                        echo '          <small class="credit mobile-text">';
                        echo '              Belum ada data pembayaran untuk transaksi ini';
                        echo '          </small>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        echo '<ol class="list-group list-group-numbered">';
                        $query = mysqli_query($Conn, "SELECT*FROM transaksi_payment WHERE kode_transaksi='$kode_transaksi' ORDER BY id_transaksi_payment DESC");
                        while ($data = mysqli_fetch_array($query)) {
                            $id_transaksi_payment= $data['id_transaksi_payment'];
                            $order_id= $data['order_id'];
                            $snap_token= $data['snap_token'];
                            $datetime= $data['datetime'];
                            $status= $data['status'];
                            $strtotime1=strtotime($datetime);
                            $DatetimeFormat=date('d M Y H:i T',$strtotime1);
                            //Sensor Kode Transaksi
                            $last_three_kode = substr($order_id, -5);
                            $masked_order_id = '***' . $last_three_kode;
                            //Label Status
                            if($status=="Lunas"){
                                $LabelStatus='<badge class="badge badge-success">Lunas</badge>';
                            }else{
                                $LabelStatus='<badge class="badge badge-warning">Pending</badge>';
                            }
                ?>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-normal">
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailPembayaran" data-id="<?php echo "$id_transaksi_payment"; ?>">
                                    <small class="credit"><?php echo $DatetimeFormat; ?></small>
                                </a>
                            </div>
                            <small>
                                Order-Id :  <code class="text text-grayish"><?php echo "$masked_order_id"; ?></code><br>
                                Status :  <?php echo "$LabelStatus"; ?>
                            </small>
                        </div>
                        <a href="javascript:void(0);" class="text text-grayish" data-bs-toggle="dropdown" aria-expanded="false">
                            <small class="credit">
                                <i class="bi bi-three-dots-vertical"></i>
                            </small>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                            <li class="dropdown-header text-start">
                                <h6>Option</h6>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailPembayaran" data-id="<?php echo "$id_transaksi_payment"; ?>">
                                    <i class="bi bi-info-circle"></i> Detail
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusPembayaran" data-id="<?php echo "$id_transaksi_payment"; ?>">
                                    <i class="bi bi-x"></i> Hapus
                                </a>
                            </li>
                        </ul>
                    </li>
<?php
                    }
                    echo '</ol>';
                }
            }
        }
    }
?>