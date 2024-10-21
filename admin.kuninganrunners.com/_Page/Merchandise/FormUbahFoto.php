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
                <div class="col col-md-12">
                    <label for="foto">
                        <small>Foto Merchandise</small>
                    </label>
                </div>
                <div class="col col-md-12">
                    <input type="file" name="foto" id="foto_edit" class="form-control">
                    <small>
                        <code class="text text-grayish">
                            File Foto Maksimal 5 mb (JPG, JPEG, PNG, dan GIF)<br>
                            Gunakan dimensi 500 x 500 untuk hasil tampilan yang lebih baik.
                        </code>
                    </small><br>
                    <small id="ValidasiFileFotoEdit"></small>
                </div>
            </div>
            <script>
               // Validasi file foto
                $('#foto_edit').on('change', function() {
                    var file = this.files[0];
                    var validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    var maxSize = 5 * 1024 * 1024; // 2MB
                    var validasiMessage = $('#ValidasiFileFotoEdit');

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