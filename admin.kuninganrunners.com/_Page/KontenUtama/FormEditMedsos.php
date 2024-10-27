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
        if(empty($_POST['id_web_medsos'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Medsos Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_web_medsos=$_POST['id_web_medsos'];
            //Bersihkan Data
            $id_web_medsos=validateAndSanitizeInput($id_web_medsos);
            //Buka Data
            $id_web_medsos_valid=GetDetailData($Conn,'web_medsos','id_web_medsos',$id_web_medsos,'id_web_medsos');
            if(empty($id_web_medsos_valid)){
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
                $nama_medsos=GetDetailData($Conn,'web_medsos','id_web_medsos',$id_web_medsos,'nama_medsos');
                $url_medsos=GetDetailData($Conn,'web_medsos','id_web_medsos',$id_web_medsos,'url_medsos');
                $logo=GetDetailData($Conn,'web_medsos','id_web_medsos',$id_web_medsos,'logo');
                $url_logo="assets/img/Medsos/$logo";
                //Menghitung Jumlah Karakter
                $nama_medsos_length=strlen($nama_medsos);
                $url_medsos_length=strlen($url_medsos);
?>
                <input type="hidden" name="id_web_medsos" value="<?php echo $id_web_medsos; ?>">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="nama_medsos_edit">
                            <small>Nama Medsos</small>
                        </label>
                        
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroupPrepend">
                                <small>
                                    <code class="text text-dark" id="nama_medsos_edit_length"><?php echo $nama_medsos_length; ?>/100</code>
                                </small>
                            </span>
                            <input type="text" name="nama_medsos" id="nama_medsos_edit" class="form-control" placeholder="Contoh: Facebook, Instagram" value="<?php echo $nama_medsos; ?>">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="url_medsos_edit">
                            <small>URL Medsos</small>
                        </label>
                        
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroupPrepend">
                                <small>
                                    <code class="text text-dark" id="url_medsos_edit_length"><?php echo $url_medsos_length; ?>/250</code>
                                </small>
                            </span>
                            <input type="url" name="url_medsos" id="url_medsos_edit" class="form-control" placeholder="https://" value="<?php echo $url_medsos; ?>">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="logo_edit">
                            <small>Logo Medsos</small>
                        </label>
                        <input type="file" name="logo" id="logo_edit" class="form-control">
                        <small id="ValidasiLogoEdit">
                            <code class="text text-dark">
                                Logo yang digunakan maksimal 2 MB (JPG, JPEG, PNG Atau GIF)
                            </code>
                        </small>
                    </div>
                </div>
                <script>
                    //Ketika nama medsos Diketik
                    $('#nama_medsos_edit').on('input', function() {
                        var value = $(this).val();
                        var maxLength = 100;
                        // Jika panjang melebihi batas, potong sesuai maxLength
                        if (value.length > maxLength) {
                            value = value.substring(0, maxLength);
                        }
                        // Update nilai input
                        $(this).val(value); 
                        // Tampilkan jumlah karakter saat ini
                        $('#nama_medsos_edit_length').text(value.length + '/' + maxLength);
                    });
                    //Ketika url_medsos Diketik
                    $('#url_medsos_edit').on('input', function() {
                        var value = $(this).val();
                        var maxLength = 250;
                        // Jika panjang melebihi batas, potong sesuai maxLength
                        if (value.length > maxLength) {
                            value = value.substring(0, maxLength);
                        }
                        // Update nilai input
                        $(this).val(value); 
                        // Tampilkan jumlah karakter saat ini
                        $('#url_medsos_edit_length').text(value.length + '/' + maxLength);
                    });
                    // Validasi file logo
                    $('#logo_edit').on('change', function() {
                        var file = this.files[0];
                        var validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                        var maxSize = 2 * 1024 * 1024; // 2MB
                        var validasiMessage = $('#ValidasiLogoEdit');

                        if (file) {
                            if ($.inArray(file.type, validTypes) == -1) {
                                validasiMessage.text('Tipe file tidak valid. Hanya diperbolehkan jpeg, png, atau gif.').css('color', 'red');
                                this.value = '';
                            } else if (file.size > maxSize) {
                                validasiMessage.text('Ukuran file maksimal 2 MB.').css('color', 'red');
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