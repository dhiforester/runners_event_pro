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
        if(empty($_POST['id_web_galeri'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Galeri Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_web_galeri=$_POST['id_web_galeri'];
            //Bersihkan Data
            $id_web_galeri=validateAndSanitizeInput($id_web_galeri);
            //Buka Data
            $id_web_galeri_valid=GetDetailData($Conn,'web_galeri','id_web_galeri',$id_web_galeri,'id_web_galeri');
            if(empty($id_web_galeri_valid)){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                echo '          <small class="credit">';
                echo '              <code class="text-dark">';
                echo '                  Data Yang Anda Pilih Tidak Ditemukan Pada Database!';
                echo '              </code>';
                echo '          </small>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $album=GetDetailData($Conn,'web_galeri','id_web_galeri',$id_web_galeri,'album');
                $nama_galeri=GetDetailData($Conn,'web_galeri','id_web_galeri',$id_web_galeri,'nama_galeri');
                $datetime=GetDetailData($Conn,'web_galeri','id_web_galeri',$id_web_galeri,'datetime');
                //Panjang karakter
                $album_length=strlen($album);
                $nama_galeri_length=strlen($nama_galeri);
?>
            <input type="hidden" name="id_web_galeri" value="<?php echo $id_web_galeri; ?>">
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="album_edit">
                        <small>Album</small>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text" id="inputGroupPrepend">
                            <small>
                                <code class="text text-dark" id="album_edit_length"><?php echo "$album_length"; ?>/50</code>
                            </small>
                        </span>
                        <input type="text" name="album" id="album_edit" list="list_album_edit" class="form-control" placeholder="Contoh: Event, Kegiatan Rutin" value="<?php echo "$album"; ?>">
                        <datalist id="list_album_edit">
                            <?php
                                $QryAlbum = mysqli_query($Conn, "SELECT DISTINCT album FROM web_galeri ORDER BY album ASC");
                                while ($DataAlbum = mysqli_fetch_array($QryAlbum)) {
                                    $album= $DataAlbum['album'];
                                    echo '<option value="'.$album.'">';
                                }
                            ?>
                        </datalist>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="nama_galeri_edit">
                        <small>Nama Foto</small>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text" id="inputGroupPrepend">
                            <small>
                                <code class="text text-dark" id="nama_galeri_edit_length"><?php echo "$nama_galeri_length"; ?>/100</code>
                            </small>
                        </span>
                        <input type="text" name="nama_galeri" id="nama_galeri_edit" class="form-control" placeholder="Cntoh: Foto Bersama" value="<?php echo "$nama_galeri"; ?>">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="file_galeri_edit">
                        <small>Foto</small>
                    </label>
                    <input type="file" name="file_galeri" id="file_galeri_edit" class="form-control">
                    <small id="ValidasiFileGaleriEdit">
                        <code class="text text-dark">
                            Foto yang digunakan maksimal 5 MB (JPG, JPEG, PNG Atau GIF)
                        </code>
                    </small>
                </div>
            </div>
            <script>
                //Validasi Jumlah Karakter
                $('#album_edit').on('input', function() {
                    var value = $(this).val();
                    var maxLength = 50;
                    // Jika panjang melebihi batas, potong sesuai maxLength
                    if (value.length > maxLength) {
                        value = value.substring(0, maxLength);
                    }
                    // Update nilai input
                    $(this).val(value); 
                    // Tampilkan jumlah karakter saat ini
                    $('#album_edit_length').text(value.length + '/' + maxLength);
                });
                $('#nama_galeri_edit').on('input', function() {
                    var value = $(this).val();
                    var maxLength = 100;
                    // Jika panjang melebihi batas, potong sesuai maxLength
                    if (value.length > maxLength) {
                        value = value.substring(0, maxLength);
                    }
                    // Update nilai input
                    $(this).val(value); 
                    // Tampilkan jumlah karakter saat ini
                    $('#nama_galeri_edit_length').text(value.length + '/' + maxLength);
                });
                // Validasi file Foto
                $('#file_galeri_edit').on('change', function() {
                    var file = this.files[0];
                    var validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    var maxSize = 5 * 1024 * 1024; // 2MB
                    var validasiMessage = $('#ValidasiFileGaleriEdit');

                    if (file) {
                        if ($.inArray(file.type, validTypes) == -1) {
                            validasiMessage.text('Tipe file tidak valid. Hanya diperbolehkan jpeg, jpg, png, atau gif.').css('color', 'red');
                            this.value = '';
                        } else if (file.size > maxSize) {
                            validasiMessage.text('Ukuran file maksimal 5 MB.').css('color', 'red');
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