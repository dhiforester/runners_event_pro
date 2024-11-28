<?php
    if(empty($_POST['id_member'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '          ID Member Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Koneksi
        $id_member=$_POST['id_member'];
        date_default_timezone_set('Asia/Jakarta');
        include "../../_Config/Connection.php";
        include "../../_Config/SettingGeneral.php";
        include "../../_Config/GlobalFunction.php";
        include "../../_Config/Session.php";
        //Hitung Jumlah Data
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi WHERE id_member='$id_member' AND kategori='Pembelian'"));
        if(empty($jml_data)){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '          Belum ada riwayat pendaftaran pada event manapun';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            echo '<div class="list-group"> ';
            //Tampilkan Data
            $no=1;
            $query = mysqli_query($Conn, "SELECT*FROM transaksi WHERE id_member='$id_member' AND kategori='Pembelian' ORDER BY datetime DESC");
            while ($data = mysqli_fetch_array($query)) {
                $kode_transaksi= $data['kode_transaksi'];
                $raw_member= $data['raw_member'];
                $datetime= $data['datetime'];
                $tagihan= $data['tagihan'];
                $jumlah= $data['jumlah'];
                $status= $data['status'];
                //Format Tanggal
                $TanggalTransaksi=date('d/m/Y H:i T',strtotime($datetime));
                //Format Rupiah
                $Subtotal='Rp ' . number_format($tagihan, 0, ',', '.');
                $Total='Rp ' . number_format($jumlah, 0, ',', '.');
                //Hitung Jumlah Item
                $jumlah_rincian = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_rincian FROM transaksi_rincian WHERE kode_transaksi='$kode_transaksi'"));
                //Jumlah Data Pembayaran
                $jumlah_pembayaran = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_payment FROM transaksi_payment WHERE kode_transaksi='$kode_transaksi'"));
?>
                <div class="list-group-item list-group-item-action" aria-current="true">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <a href="javascript:void(0);" class="text text-decoration-underline" data-bs-toggle="modal" data-bs-target="#ModalDetailTransaksi" data-id="<?php echo "$kode_transaksi"; ?>">
                                <?php echo "$TanggalTransaksi"; ?>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col col-md-4">
                                    <small class="mobile-text">Kode Transaksi</small>
                                </div>
                                <div class="col col-md-8">
                                    <small class="mobile-text">
                                        <?php 
                                            if(empty($kode_transaksi)){
                                                echo '<code>Tidak Ada</code>';
                                            }else{
                                                //Masked Kode Transaksi
                                                $last_five_digits = substr($kode_transaksi, -5);
                                                $formatted_id = '***' . $last_five_digits;
                                                echo '<code class="text text-grayish">'.$formatted_id.'</code>';
                                            }
                                        ?>
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-4">
                                    <small class="mobile-text">Jumlah Item</small>
                                </div>
                                <div class="col col-md-8">
                                    <small class="mobile-text">
                                        <code class="text text-grayish">
                                            <?php echo "$jumlah_rincian Item"; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-4">
                                    <small class="mobile-text">Subtotal</small>
                                </div>
                                <div class="col col-md-8">
                                    <small class="mobile-text">
                                        <code class="text text-grayish">
                                            <?php echo $Subtotal; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col col-md-4">
                                    <small class="mobile-text">Total Tagihan</small>
                                </div>
                                <div class="col col-md-8">
                                    <small class="mobile-text">
                                        <code class="text text-grayish">
                                            <?php echo $Total; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-4">
                                    <small class="mobile-text">Pembayaran</small>
                                </div>
                                <div class="col col-md-8">
                                    <small class="mobile-text">
                                        <code class="text text-grayish">
                                            <?php echo "$jumlah_pembayaran Record"; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-4">
                                    <small class="mobile-text">Status</small>
                                </div>
                                <div class="col col-md-8">
                                    <small class="mobile-text">
                                        <code class="text text-grayish">
                                            <?php 
                                                if($status=="Lunas"){
                                                    echo '<code class="text text-success">Lunas</code>';
                                                }else{
                                                    echo '<code class="text text-danger">Pending</code>';
                                                }
                                            ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php 
                $no++;
            } 
            echo '</div>';
        } 
    } 
?>