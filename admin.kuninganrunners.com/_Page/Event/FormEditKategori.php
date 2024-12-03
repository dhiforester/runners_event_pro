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
        if(empty($_POST['id_event_kategori'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Kategori Event Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_event_kategori=$_POST['id_event_kategori'];
            //Bersihkan Data
            $id_event_kategori=validateAndSanitizeInput($id_event_kategori);
            //Buka Data
            $id_event_kategori_validasi=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'id_event_kategori');
            if(empty($id_event_kategori_validasi)){
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
                $id_event=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'id_event');
                $kategori=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'kategori');
                $deskripsi=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'deskripsi');
                $biaya_pendaftaran=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'biaya_pendaftaran');
                if(empty($biaya_pendaftaran)){
                    $biaya_pendaftaran=0;
                }
                //Hitung Jumlah Karakter
                $kategori_length=strlen($kategori);
                $deskripsi_length=strlen($deskripsi);
?>
            <input type="hidden" name="id_event_kategori" value="<?php echo $id_event_kategori; ?>">
            <input type="hidden" name="id_event" value="<?php echo $id_event; ?>">
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="kategori_edit">
                        <small>Kategori Event</small>
                    </label>
                    <div class="input-group">
                        <input type="text" name="kategori" id="kategori_edit" class="form-control" placeholder="Contoh : Cabang Pelajar, Dewasa dll" value="<?php echo $kategori; ?>">
                        <span class="input-group-text" id="inputGroupPrepend">
                            <small>
                                <code id="kategori_edit_length" class="text text-grayish"><?php echo $kategori_length; ?>/50</code>
                            </small>
                        </span>
                    </div>
                    
                    <small>
                        <code class="text text-grayish">
                            Kategori event hanya diisi dengan huruf, angka dan spasi
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="biaya_pendaftaran_edit">
                        <small>Biaya Pendaftaran</small>
                    </label>
                    <input type="text" name="biaya_pendaftaran" id="biaya_pendaftaran_edit" class="form-control" placeholder="Rp" value="<?php echo $biaya_pendaftaran; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="deskripsi_edit">
                        <small>Keterangan/Deskripsi</small>
                    </label>
                    <textarea name="deskripsi" id="deskripsi_edit" class="form-control"><?php echo $deskripsi; ?></textarea>
                    <small>
                        <code class="text text-grayish" id="deskripsi_edit_length">
                            <?php echo $deskripsi_length; ?>/500
                        </code>
                    </small>
                </div>
            </div>
            <script>
                $('#kategori_edit').on('input', function() {
                    var value = $(this).val();
                    var maxLength = 50;
                    // Jika panjang melebihi batas, potong sesuai maxLength
                    if (value.length > maxLength) {
                        value = value.substring(0, maxLength);
                    }
                    // Update nilai input
                    $(this).val(value); 
                    // Tampilkan jumlah karakter saat ini
                    $('#kategori_edit_length').text(value.length + '/' + maxLength);
                });
                $('#biaya_pendaftaran_edit').on('input', function() {
                    var value = $(this).val();
                    var maxLength = 10;
                    // Validasi Karakter: Hanya izinkan huruf dan spasi
                    value = value.replace(/[^0-9]/g, '');
                    // Jika panjang melebihi batas, potong sesuai maxLength
                    if (value.length > maxLength) {
                        value = value.substring(0, maxLength);
                    }
                    // Update nilai input
                    $(this).val(value); 
                });
                $('#deskripsi_edit').on('input', function() {
                    var value = $(this).val();
                    var maxLength = 500;
                    // Jika panjang melebihi batas, potong sesuai maxLength
                    if (value.length > maxLength) {
                        value = value.substring(0, maxLength);
                    }
                    // Update nilai input
                    $(this).val(value); 
                    // Tampilkan jumlah karakter saat ini
                    $('#deskripsi_edit_length').text(value.length + '/' + maxLength);
                });
            </script>
<?php
            }
        }
    }
?>