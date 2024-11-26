<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Uang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['put_id_member'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  <b>Belum Ada Member Yang Dipilih</b><br>';
            echo '                  Silahkan Pilih Member Terlebih Dulu<br>';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_member=$_POST['put_id_member'];
            //Menghitung Subtotal
            $subtotal=0;
            $jumlah_keranjang=mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_keranjang FROM transaksi_keranjang WHERE id_member='$id_member'"));
            if(!empty($jumlah_keranjang)){
                $query = mysqli_query($Conn, "SELECT*FROM transaksi_keranjang WHERE id_member='$id_member'");
                while ($data = mysqli_fetch_array($query)) {
                    $id_transaksi_keranjang= $data['id_transaksi_keranjang'];
                    $id_barang= $data['id_barang'];
                    $id_varian= $data['id_varian'];
                    $qty= $data['qty'];
                    $nama_varian="";
                    //Buka Data Barang
                    $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                    $stok=GetDetailData($Conn,'barang','id_barang',$id_barang,'stok');
                    $varian=GetDetailData($Conn,'barang','id_barang',$id_barang,'varian');
                    if(!empty($varian)){
                        $varian_arry=json_decode($varian,true);
                        foreach($varian_arry as $varian_list){
                            $id_varian_list=$varian_list['id_varian'];
                            if($id_varian_list==$id_varian){
                                $harga=$varian_list['harga_varian'];
                                $nama_varian=$varian_list['nama_varian'];
                            }
                        }
                    }
                    //Menghitung Jumlah
                    $jumlah=$qty*$harga;
                    $subtotal=$subtotal+$jumlah;
                }
            }
            //Ongkir
            if(!empty($_POST['ongkir'])){
                $ongkir=$_POST['ongkir'];
            }else{
                $ongkir=0;
            }
            //ppn_pph
            if(!empty($_POST['ppn_pph'])){
                $ppn_pph=$_POST['ppn_pph'];
                if(!empty($subtotal)){
                    $ppn_pph=$subtotal*($ppn_pph/100);
                    $ppn_pph=round($ppn_pph);
                }else{
                    $ppn_pph=0;
                }
            }else{
                $ppn_pph=0;
            }
            //Biaya Layanan
            if(!empty($_POST['biaya_layanan'])){
                $biaya_layanan=$_POST['biaya_layanan'];
            }else{
                $biaya_layanan=0;
            }
            //Biaya Lain-lain
            if(!empty($_POST['nominal_biaya'])){
                $nominal_biaya=$_POST['nominal_biaya'];
                $biaya_lainnya=0;
                foreach ($nominal_biaya as $index => $nominal) {
                    if(!empty($nominal)){
                        $biaya_lainnya=$biaya_lainnya+$nominal;
                    }
                }
            }else{
                $biaya_lainnya=0;
            }
            //Potongan Lain-lain
            if(!empty($_POST['nominal_potongan'])){
                $nominal_potongan=$_POST['nominal_potongan'];
                $potongan_lainnya=0;
                foreach ($nominal_potongan as $index => $potongan) {
                    if(!empty($potongan)){
                        $potongan_lainnya=$potongan_lainnya+$potongan;
                    }
                }
            }else{
                $potongan_lainnya=0;
            }
            $jumlah_total=($subtotal+$ongkir+$ppn_pph+$biaya_layanan+$biaya_lainnya)-$potongan_lainnya;
?>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <small class="mobile-text">Subtotal</small>
                </div>
                <div class="col col-md-8">
                    <small class="mobile-text">
                        <code class="text text-grayish"><?php echo 'Rp ' . number_format($subtotal, 0, ',', '.'); ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <small class="mobile-text">Ongkir</small>
                </div>
                <div class="col col-md-8">
                    <small class="mobile-text">
                        <code class="text text-grayish"><?php echo 'Rp ' . number_format($ongkir, 0, ',', '.'); ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <small class="mobile-text">Pajak PPN</small>
                </div>
                <div class="col col-md-8">
                    <small class="mobile-text">
                        <code class="text text-grayish"><?php echo 'Rp ' . number_format($ppn_pph, 0, ',', '.'); ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <small class="mobile-text">Biaya Layanan</small>
                </div>
                <div class="col col-md-8">
                    <small class="mobile-text">
                        <code class="text text-grayish"><?php echo 'Rp ' . number_format($biaya_layanan, 0, ',', '.'); ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <small class="mobile-text">Biaya Lain-lain</small>
                </div>
                <div class="col col-md-8">
                    <small class="mobile-text">
                        <code class="text text-grayish"><?php echo 'Rp ' . number_format($biaya_lainnya, 0, ',', '.'); ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <small class="mobile-text">Potongan Penjualan</small>
                </div>
                <div class="col col-md-8">
                    <small class="mobile-text">
                        <code class="text text-grayish"><?php echo 'Rp ' . number_format($potongan_lainnya, 0, ',', '.'); ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3 border-1 border-bottom">
                <div class="col col-md-4 mb-3">
                    <b class="mobile-text">Jumlah Total</b>
                </div>
                <div class="col col-md-8 mb-3">
                    <b class="mobile-text">
                        <?php echo 'Rp ' . number_format($jumlah_total, 0, ',', '.'); ?>
                    </b>
                </div>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col col-md-12">
                    <label for="status_transaksi">
                        <small>Status Transaksi</small>
                    </label>
                </div>
                <div class="col col-md-12">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="status_transaksi" id="status_transaksi_menunggu" value="Menunggu">
                        <label class="form-check-label" for="status_transaksi_menunggu">
                            <small>Menunggu Verifikasi</small>
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="status_transaksi" id="status_transaksi_pending" value="Pending">
                        <label class="form-check-label" for="status_transaksi_pending">
                            <small>Pending (tertunda)</small>
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="status_transaksi" id="status_transaksi_lunas" value="Lunas">
                        <label class="form-check-label" for="status_transaksi_lunas">
                            <small>Lunas (Selesai)</small>
                        </label>
                    </div>
                </div>
            </div>
<?php
        }
    }
?>

