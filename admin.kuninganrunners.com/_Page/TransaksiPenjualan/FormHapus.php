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
        //Tangkap kode_transaksi
        if(empty($_POST['kode_transaksi'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <code>ID Transaksi Tidak Boleh Kosong</code>';
            echo '  </div>';
            echo '</div>';
        }else{
            $kode_transaksi=$_POST['kode_transaksi'];
            //Bersihkan Variabel
            $kode_transaksi=validateAndSanitizeInput($kode_transaksi);
            //Buka data Transaksi
            $ValidasiTransaksi=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kode_transaksi');
            if(empty($ValidasiTransaksi)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <code>ID Transaksi Tidak Valid Atau Tidak Ditemukan Pada Database</code>';
                echo '  </div>';
                echo '</div>';
            }else{
                $id_member=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'id_member');
                $raw_member=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'raw_member');
                $kategori=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kategori');
                $datetime=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'datetime');
                $jumlah=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'jumlah');
                $ongkir=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'ongkir');
                $ppn_pph=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'ppn_pph');
                $biaya_layanan=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'biaya_layanan');
                $biaya_lainnya=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'biaya_lainnya');
                $potongan_lainnya=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'potongan_lainnya');
                $status=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'status');
                //Format Tanggal
                $strtotime1=strtotime($datetime);
                //Menampilkan Tanggal
                $DatetimeFormat=date('d/m/Y H:i:s T', $strtotime1);
                $NamaMember=GetDetailData($Conn,'member','id_member',$id_member,'nama');
                //Format Rupiah
                $JumlahPembayaran='Rp ' . number_format($jumlah, 0, ',', '.');
                //Routing Label Status
                if($status=="Lunas"){
                    $LabelStatus='<code class="text-success">Lunas</code>';
                }else{
                    if($status=="Menunggu"){
                        $LabelStatus='<code class="text-danger">Menunggu Validasi</code>';
                    }else{
                        $LabelStatus='<code class="text-warning">Pending</code>';
                    }
                }
?>
            <input type="hidden" name="kode_transaksi" value="<?php echo $kode_transaksi; ?>">
            <div class="row mb-3">
                <div class="col col-md-4"><small class="credit">Kode Transaksi</small></div>
                <div class="col col-md-8">
                    <small class="credit mobile-text">
                        <code class="text text-grayish"><?php echo "$kode_transaksi"; ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4"><small class="credit">Tgl/Jam</small></div>
                <div class="col col-md-8">
                    <small class="credit">
                        <code class="text text-grayish"><?php echo "$DatetimeFormat"; ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4 mb-3"><small class="credit">Nama Member</small></div>
                <div class="col col-md-8 mb-3">
                    <small class="credit">
                        <code class="text text-grayish"><?php echo "$NamaMember"; ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4 mb-3"><small class="credit">Total Transaksi</small></div>
                <div class="col col-md-8 mb-3">
                    <small class="credit">
                        <code class="text text-grayish"><?php echo "$JumlahPembayaran"; ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4 mb-3"><small class="credit">Status</small></div>
                <div class="col col-md-8 mb-3">
                    <small class="credit">
                        <?php echo "$LabelStatus"; ?>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <small>
                            <b>Apakah Anda Yakin Akan Menghapus Data Ini?</b><br>
                            Data transaksi yang sudah anda hapus tidak bisa dipulihkan kembali. 
                            Pastikan kembali bahwa data yang akan anda hapus sudah benar.
                        </small>
                    </div>
                </div>
            </div>
<?php 
            } 
        } 
    } 
?>