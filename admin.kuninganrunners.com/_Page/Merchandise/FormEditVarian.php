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
                //Menghitung Jumlah Karakter
                $nama_varian_length = strlen($nama_varian);
                $stok_varian_length = strlen($stok_varian);
                $harga_varian_length = strlen($harga_varian);
                $keterangan_varian_length = strlen($keterangan_varian);
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
                    <div class="col-md-12">
                        <label for="nama_varian">
                            <small>Nama Varian</small>
                        </label>
                        <div class="input-group">
                            <input type="text" name="nama_varian" id="nama_varian" class="form-control" value="<?php echo "$nama_varian"; ?>">
                            <span class="input-group-text" id="inputGroupPrepend">
                                <small>
                                    <code class="text text-grayish" id="nama_varian_length"><?php echo "$nama_varian_length"; ?>/50</code>
                                </small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="harga_varian">
                            <small>Harga (Rp)</small>
                        </label>
                        <div class="input-group">
                            <input type="text" name="harga_varian" id="harga_varian" class="form-control" value="<?php echo "$harga_varian"; ?>">
                            <span class="input-group-text" id="inputGroupPrepend">
                                <small>
                                    <code class="text text-grayish" id="harga_varian_length"><?php echo "$harga_varian_length"; ?>/10</code>
                                </small>
                            </span>
                        </div>
                        <small>
                            <code class="text text-grayish">
                                Harga utama pada item barang akan menampilkan harga rata-rata dari seluruh item varian.
                            </code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="stok_varian">
                            <small>Stok (<?php echo $satuan; ?>)</small>
                        </label>
                        <div class="input-group">
                            <input type="text" name="stok_varian" id="stok_varian" class="form-control" value="<?php echo "$stok_varian"; ?>">
                            <span class="input-group-text" id="inputGroupPrepend">
                                <small>
                                    <code class="text text-grayish" id="stok_varian_length"><?php echo "$stok_varian_length"; ?>/10</code>
                                </small>
                            </span>
                        </div>
                        <small>
                            <code class="text text-grayish">
                                Jumlah stok barang akan mengikuti jumlah stok varian
                            </code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="keterangan_varian">
                            <small>Keterangan*</small>
                        </label>
                        <textarea name="keterangan_varian" id="keterangan_varian" class="form-control"><?php echo "$keterangan_varian"; ?></textarea>
                        <small>
                            <code class="text text-dark" id="keterangan_varian_length"><?php echo "$keterangan_varian_length"; ?>/200</code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="foto_varian">
                            <small>Foto</small>
                        </label>
                        <input type="file" name="foto_varian" id="foto_varian" class="form-control">
                        <small>
                            <code class="text text-grayish">
                                File foto maksimal 5 Mb (JPEG, JPG, PNG dan GIF)<br>
                                Gunakan dimensi 500 x 500 untuk hasil tampilan yang lebih baik.
                            </code>
                        </small><br>
                        <small id="ValidasiFileFotoVarian"></small>
                    </div>
                </div>
                <script>
                    //Ketika nama_varian di ketik
                    $('#nama_varian').on('input', function() {
                        var value = $(this).val();
                        var length = value.length;
                        var maxLength=50;
                        // Jika panjang melebihi batas, potong sesuai maxLength
                        if (length > maxLength) {
                            value = value.substring(0, maxLength);
                            // Update nilai input
                            $(this).val(value); 
                            // Pastikan panjang sesuai maxLength
                            length = maxLength; 
                        } else {
                            // Update nilai input
                            $(this).val(value); 
                        }
                        // Tampilkan jumlah karakter saat ini
                        $('#nama_varian_length').text(length + '/' + maxLength);
                    });
                    //Ketika harga_varian di ketik
                    $('#harga_varian').on('input', function() {
                        var value = $(this).val();
                        var length = value.length;
                        var maxLength=10;
                        value = value.replace(/[^0-9]/g, '');
                        // Jika panjang melebihi batas, potong sesuai maxLength
                        if (length > maxLength) {
                            value = value.substring(0, maxLength);
                            // Update nilai input
                            $(this).val(value);
                            // Pastikan panjang sesuai maxLength
                            length = maxLength; 
                        } else {
                            // Update nilai input
                            $(this).val(value);
                        }
                        // Tampilkan jumlah karakter saat ini
                        $('#harga_varian_length').text(length + '/' + maxLength);
                    });
                    //Ketika stok_varian di ketik
                    $('#stok_varian').on('input', function() {
                        var value = $(this).val();
                        var length = value.length;
                        var maxLength=10;
                        value = value.replace(/[^0-9]/g, '');
                        // Jika panjang melebihi batas, potong sesuai maxLength
                        if (length > maxLength) {
                            value = value.substring(0, maxLength);
                            // Update nilai input
                            $(this).val(value);
                            // Pastikan panjang sesuai maxLength
                            length = maxLength; 
                        } else {
                            // Update nilai input
                            $(this).val(value);
                        }
                        // Tampilkan jumlah karakter saat ini
                        $('#stok_varian_length').text(length + '/' + maxLength);
                    });
                    //Ketika keterangan_varian di ketik
                    $('#keterangan_varian').on('input', function() {
                        var value = $(this).val();
                        var length = value.length;
                        var maxLength=200;
                        // Jika panjang melebihi batas, potong sesuai maxLength
                        if (length > maxLength) {
                            value = value.substring(0, maxLength);
                            // Update nilai input
                            $(this).val(value);
                            // Pastikan panjang sesuai maxLength
                            length = maxLength; 
                        } else {
                            // Update nilai input
                            $(this).val(value);
                        }
                        // Tampilkan jumlah karakter saat ini
                        $('#keterangan_varian_length').text(length + '/' + maxLength);
                    });
                    // Validasi file foto
                    $('#foto_varian').on('change', function() {
                        var file = this.files[0];
                        var validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                        var maxSize = 5 * 1024 * 1024; // 2MB
                        var validasiMessage = $('#ValidasiFileFotoVarian');

                        if (file) {
                            if ($.inArray(file.type, validTypes) == -1) {
                                validasiMessage.text('Tipe file tidak valid. Hanya diperbolehkan jpeg, png, atau gif.').css('color', 'red');
                                this.value = '';
                            } else if (file.size > maxSize) {
                                validasiMessage.text('Ukuran file maksimal 5MB.').css('color', 'red');
                                this.value = '';
                            } else {
                                validasiMessage.text('File sudah valid dan sesuai persyaratan.').css('color', 'green');
                            }
                        }
                    });
                </script>
<?php 
            } 
        } 
    } 
?>