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
        if(empty($_POST['id_event'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Event Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_event=$_POST['id_event'];
            //Bersihkan Data
            $id_event=validateAndSanitizeInput($id_event);
            //Buka Data
            $id_event_validasi=GetDetailData($Conn,'event','id_event',$id_event,'id_event');
            if(empty($id_event_validasi)){
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
?>    
    
    <html>
        <head>
            <!-- Tambahkan di dalam tag <head> -->
            <style>
                #deskripsi_editor {
                    height: 200px;
                    overflow-y: auto;
                }
            </style>
        </head>
        <body>
            <input type="hidden" name="id_event" id="PutIdEventForAddKategori" value="<?php echo $id_event; ?>">
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="kategori">
                        <small>Kategori Event</small>
                    </label>
                    <div class="input-group">
                        <input type="text" name="kategori" id="kategori" class="form-control" placeholder="Contoh : Cabang Pelajar, Dewasa dll">
                        <span class="input-group-text" id="inputGroupPrepend">
                            <small>
                                <code id="kategori_length" class="text text-grayish">0/50</code>
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
                    <label for="biaya_pendaftaran">
                        <small>Biaya Pendaftaran</small>
                    </label>
                    <input type="text" name="biaya_pendaftaran" id="biaya_pendaftaran" class="form-control" placeholder="Rp">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="deskripsi">
                        <small>Keterangan/Deskripsi</small>
                    </label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
                    <small>
                        <code class="text text-grayish" id="deskripsi_length">
                            0/500
                        </code>
                    </small>
                </div>
            </div>
            <script>
                $('#kategori').on('input', function() {
                    var value = $(this).val();
                    var maxLength = 50;
                    // Jika panjang melebihi batas, potong sesuai maxLength
                    if (value.length > maxLength) {
                        value = value.substring(0, maxLength);
                    }
                    // Update nilai input
                    $(this).val(value); 
                    // Tampilkan jumlah karakter saat ini
                    $('#kategori_length').text(value.length + '/' + maxLength);
                });
                $('#biaya_pendaftaran').on('input', function() {
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
                $('#deskripsi').on('input', function() {
                    var value = $(this).val();
                    var maxLength = 500;
                    // Jika panjang melebihi batas, potong sesuai maxLength
                    if (value.length > maxLength) {
                        value = value.substring(0, maxLength);
                    }
                    // Update nilai input
                    $(this).val(value); 
                    // Tampilkan jumlah karakter saat ini
                    $('#deskripsi_length').text(value.length + '/' + maxLength);
                });
            </script>
        </body>
    </html>
<?php
            }
        }
    }
?>