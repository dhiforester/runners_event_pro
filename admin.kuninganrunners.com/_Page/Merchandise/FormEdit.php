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
            //Buka data Barang
            $ValidasiIdBarang=GetDetailData($Conn,'barang','id_barang',$id_barang,'id_barang');
            if(empty($ValidasiIdBarang)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <code>ID Barang Tidak Valid Atau Tidak Ditemukan Pada Database</code>';
                echo '  </div>';
                echo '</div>';
            }else{
                $nama_barang=GetDetailData($Conn,'barang','id_barang',$id_barang,'nama_barang');
                $kategori=GetDetailData($Conn,'barang','id_barang',$id_barang,'kategori');
                $satuan=GetDetailData($Conn,'barang','id_barang',$id_barang,'satuan');
                $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                $stok=GetDetailData($Conn,'barang','id_barang',$id_barang,'stok');
                $dimensi=GetDetailData($Conn,'barang','id_barang',$id_barang,'dimensi');
                $deskripsi=GetDetailData($Conn,'barang','id_barang',$id_barang,'deskripsi');
                $foto=GetDetailData($Conn,'barang','id_barang',$id_barang,'foto');
                $varian=GetDetailData($Conn,'barang','id_barang',$id_barang,'varian');
                $datetime=GetDetailData($Conn,'barang','id_barang',$id_barang,'datetime');
                $updatetime=GetDetailData($Conn,'barang','id_barang',$id_barang,'updatetime');
                $arry_dimensi=json_decode($dimensi, true);
                $berat=$arry_dimensi['berat'];
                $panjang=$arry_dimensi['panjang'];
                $lebar=$arry_dimensi['lebar'];
                $tinggi=$arry_dimensi['tinggi'];
                //Menghitung Jumlah Karakter
                $nama_barang_edit_length = str_replace(' ', '', $nama_barang);
                $kategori_edit_length = str_replace(' ', '', $kategori);
                $satuan_edit_length = str_replace(' ', '', $satuan);
                $deskripsi_edit_length = str_replace(' ', '', $deskripsi);
?>
            <input type="hidden" name="id_barang" value="<?php echo $id_barang; ?>">
            <div class="row mb-3">
                <div class="col col-md-4">
                    <label for="nama_barang_edit">
                        <small>Nama Merchandise</small>
                    </label>
                </div>
                <div class="col col-md-8">
                    <div class="input-group">
                        <input type="text" class="form-control" name="nama_barang" id="nama_barang_edit" value="<?php echo "$nama_barang"; ?>">
                        <span class="input-group-text" id="inputGroupPrepend">
                            <small>
                                <code class="text text-grayish" id="nama_barang_edit_length"><?php echo "$nama_barang_edit_length"; ?>/50</code>
                            </small>
                        </span>
                    </div>
                    <small>
                        <code class="text text-grayish">
                            Nama item atau merek dagang yang digunakan
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <label for="kategori_edit">
                        <small>Kategori</small>
                    </label>
                </div>
                <div class="col col-md-8">
                    <div class="input-group">
                        <input type="text" class="form-control" name="kategori" id="kategori_edit" value="<?php echo "$kategori"; ?>">
                        <span class="input-group-text" id="inputGroupPrepend">
                            <small>
                                <code class="text text-grayish" id="kategori_edit_length"><?php echo "$kategori_edit_length"; ?>/20</code>
                            </small>
                        </span>
                    </div>
                    <small>
                        <code class="text text-grayish">
                            Kategori yang menunjukan group item tertentu (Contoh : Tshirt)
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <label for="satuan_edit">
                        <small>Satuan</small>
                    </label>
                </div>
                <div class="col col-md-8">
                    <div class="input-group">
                        <input type="text" class="form-control" name="satuan" id="satuan_edit" value="<?php echo "$satuan"; ?>">
                        <span class="input-group-text" id="inputGroupPrepend">
                            <small>
                                <code class="text text-grayish" id="satuan_edit_length"><?php echo "$satuan_edit_length"; ?>/10</code>
                            </small>
                        </span>
                    </div>
                    <small>
                        <code class="text text-grayish">
                            Satuan yang digunakan per setiap item (Contoh : PCS, Set)
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <label for="harga_edit">
                        <small>Harga Jual</small>
                    </label>
                </div>
                <div class="col col-md-8">
                    <input type="text" class="form-control" name="harga" id="harga_edit" placeholder="Rp" value="<?php echo "$harga"; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <label for="stok_edit">
                        <small>Stok Sekarang</small>
                    </label>
                </div>
                <div class="col col-md-8">
                    <input type="text" class="form-control" name="stok" id="stok_edit" placeholder="Rp" value="<?php echo "$stok"; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <label for="berat_edit">
                        <small>Berat</small>
                    </label>
                </div>
                <div class="col col-md-8">
                    <input type="text" class="form-control" name="berat" id="berat_edit" placeholder="00.00" placeholder="Rp" value="<?php echo "$berat"; ?>">
                    <small>
                        <code class="text text-grayish">
                            Dalam satuan kilogram (kg)
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <label for="panjang_edit">
                        <small>Dimensi Panjang</small>
                    </label>
                </div>
                <div class="col col-md-8">
                    <input type="text" class="form-control" name="panjang" id="panjang_edit" placeholder="00.00" value="<?php echo "$panjang"; ?>">
                    <small>
                        <code class="text text-grayish">
                            Dalam satuan centimeter (Cm)
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <label for="lebar_edit">
                        <small>Dimensi Lebar</small>
                    </label>
                </div>
                <div class="col col-md-8">
                    <input type="text" class="form-control" name="lebar" id="lebar_edit" placeholder="00.00" value="<?php echo "$lebar"; ?>">
                    <small>
                        <code class="text text-grayish">
                            Dalam satuan centimeter (Cm)
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <label for="tinggi_edit">
                        <small>Dimensi Tinggi</small>
                    </label>
                </div>
                <div class="col col-md-8">
                    <input type="text" class="form-control" name="tinggi" id="tinggi_edit" placeholder="00.00" value="<?php echo "$tinggi"; ?>">
                    <small>
                        <code class="text text-grayish">
                            Dalam satuan centimeter (Cm)
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <label for="deskripsi_edit">
                        <small>Deskripsi</small>
                    </label>
                </div>
                <div class="col col-md-8">
                    <small>
                        <code class="text text-dark" id="deskripsi_edit_length"><?php echo "$deskripsi_edit_length"; ?>/500</code>
                    </small>
                    <textarea name="deskripsi" id="deskripsi_edit" class="form-control"><?php echo "$deskripsi"; ?></textarea>
                    <small>
                        <code class="text text-grayish">Gambaran dan spesifikasi produk</code>
                    </small>
                </div>
            </div>
            <script>
                //Validasi Form
                updateCharacterLength('#nama_barang_edit', '#nama_barang_edit_length', 50);
                updateCharacterLength('#kategori_edit', '#kategori_edit_length', 20);
                updateCharacterLength('#satuan_edit', '#satuan_edit_length', 10);
                updateCharacterLength('#harga_edit', '#harga_edit_length', 10);
                updateCharacterLength('#stok_edit', '#stok_edit_length', 10);
                updateCharacterLength('#berat_edit', '#berat_edit_length', 10);
                updateCharacterLength('#panjang_edit', '#panjang_edit_length', 10);
                updateCharacterLength('#lebar_edit', '#lebar_edit_length', 10);
                updateCharacterLength('#tinggi_edit', '#tinggi_edit_length', 10);
                updateCharacterLength('#deskripsi_edit', '#deskripsi_edit_length', 500);
            </script>
<?php 
            } 
        } 
    } 
?>