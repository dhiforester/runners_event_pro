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
        //Tangkap GetDataVarian
        if(empty($_POST['GetDataVarian'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <code>ID Barang Tidak Boleh Kosong</code>';
            echo '  </div>';
            echo '</div>';
        }else{
            $GetDataVarian=$_POST['GetDataVarian'];
            //Bersihkan Variabel
            $GetDataVarian=validateAndSanitizeInput($GetDataVarian);
            //Pecah Variabel
            $explode=explode('-',$GetDataVarian);
            $id_barang=$explode['0'];
            $id_varian=$explode['1'];
            //Buka data barang
            $ValidasiIdBarang=GetDetailData($Conn,'barang','id_barang',$id_barang,'id_barang');
            if(empty($ValidasiIdBarang)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <code>ID Barang Tidak Valid Atau Tidak Ditemukan Pada Database</code>';
                echo '  </div>';
                echo '</div>';
            }else{
                $varian=GetDetailData($Conn,'barang','id_barang',$id_barang,'varian');
                $satuan=GetDetailData($Conn,'barang','id_barang',$id_barang,'satuan');
                $VarianArray=json_decode($varian, true);
                //Inisiasi Variabel Pertama Kali
                $foto_varian="";
                $nama_varian="";
                $stok_varian="";
                $harga_varian="";
                $keterangan_varian="";
                //Buka Data Array
                foreach($VarianArray as $VarianList){
                    if($VarianList['id_varian']==$id_varian){
                        $foto_varian=$VarianList['foto_varian'];
                        $nama_varian=$VarianList['nama_varian'];
                        $stok_varian=$VarianList['stok_varian'];
                        $harga_varian=$VarianList['harga_varian'];
                        $keterangan_varian=$VarianList['keterangan_varian'];
                    }
                }
                //Format Harga
                $HargaFormat='Rp ' . number_format($harga_varian, 2, ',', '.');
                if(!empty($foto_varian)){
                    $PathFoto="assets/img/Marchandise/$foto_varian";
                }else{
                    $PathFoto="assets/img/User/No-Image.png";
                }
?>
            <input type="hidden" name="id_barang" value="<?php echo $id_barang; ?>">
            <input type="hidden" name="id_varian" value="<?php echo $id_varian; ?>">
            <div class="row mb-3">
                <div class="col col-md-4">
                    <small>Nama Varian</small>
                </div>
                <div class="col col-md-8">
                    <small>
                        <code class="text text-grayish"><?php echo $nama_varian; ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <small>Stok</small>
                </div>
                <div class="col col-md-8">
                    <small>
                        <code class="text text-grayish"><?php echo "$stok_varian $satuan"; ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <small>Harga</small>
                </div>
                <div class="col col-md-8">
                    <small>
                        <code class="text text-grayish"><?php echo "$HargaFormat"; ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <small>Keterangan</small>
                </div>
                <div class="col col-md-8">
                    <small>
                        <code class="text text-grayish"><?php echo "$keterangan_varian"; ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-12 text-center">
                    <small class="text text-danger">
                        Apakah Anda Yakin Akan Menghapus Varian Ini?
                    </small>
                </div>
            </div>
<?php 
            } 
        } 
    } 
?>