<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Harus Login Terlebih Dulu
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <code>Sesi Login Sudah Berakhir, Silahkan Login Ulang!</code>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Tangkap id_barang
        if(empty($_POST['id_barang'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <code>ID Barang Tidak Boleh Kosong</code>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_barang=$_POST['id_barang'];
            //Bersihkan Variabel
            $id_barang=validateAndSanitizeInput($id_barang);
            //Buka Data Barang
            $nama_barang=GetDetailData($Conn,'barang','id_barang',$id_barang,'nama_barang');

            //Apabila Data Tidak Ada
            if(empty($nama_barang)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <code>ID Barang Tersebut Tidak Valid (Tidak Ditemukan Pada Database)</code>';
                echo '  </div>';
                echo '</div>';
            }else{
                $kategori=GetDetailData($Conn,'barang','id_barang',$id_barang,'kategori');
                $satuan=GetDetailData($Conn,'barang','id_barang',$id_barang,'satuan');
                //Hitung Data Riwayat Penjualan
                $JumlahPenjualanBarang=mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_rincian FROM transaksi_rincian WHERE id_barang='$id_barang'"));
                //Item Terjual
                $JumlahTotalItem = mysqli_fetch_assoc(
                    mysqli_query($Conn, "SELECT SUM(qty) AS total_qty FROM transaksi_rincian WHERE id_barang='$id_barang'")
                )['total_qty'];
                if(empty($JumlahTotalItem)){
                    $JumlahTotalItem=0;
                }
?>
                <div class="row mb-2">
                    <div class="col col-md-3"><small>Nama Barang</small></div>
                    <div class="col col-md-9">
                        <small>
                            <code class="text text-grayish">
                                <?php echo "$nama_barang"; ?>
                            </code>
                        </small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-3"><small>Kategori</small></div>
                    <div class="col col-md-9">
                        <small>
                            <code class="text text-grayish">
                                <?php echo "$kategori"; ?>
                            </code>
                        </small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-3"><small>Jumlah Transaksi</small></div>
                    <div class="col col-md-9">
                        <small>
                            <code class="text text-grayish">
                                <?php echo "$JumlahPenjualanBarang Reord"; ?>
                            </code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-3"><small>Item Terjual</small></div>
                    <div class="col col-md-9">
                        <small>
                            <code class="text text-grayish">
                                <?php echo "$JumlahTotalItem $satuan"; ?>
                            </code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12" id="MenampilkanRiwayatTransaksiBarang">
                        <!-- Menampilkan Tabel Riwayat Transaksi Barang -->
                    </div>
                </div>
<?php 
            } 
        } 
    } 
?>
<script>
    $(document).ready(function () {
        
    });
</script>