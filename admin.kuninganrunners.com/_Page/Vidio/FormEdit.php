<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";
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
        if(empty($_POST['id_web_vidio'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Konten Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_web_vidio=$_POST['id_web_vidio'];
            //Bersihkan Data
            $id_web_vidio=validateAndSanitizeInput($id_web_vidio);
            //Buka Data
            $id_web_vidio_validasi=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'id_web_vidio');
            if(empty($id_web_vidio_validasi)){
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
                $sumber_vidio=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'sumber_vidio');
                $title_vidio=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'title_vidio');
                $deskripsi=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'deskripsi');
                $vidio=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'vidio');
                $datetime=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'datetime');
                $JumlahKarakterJudul=strlen($title_vidio);
                $JumlahKarakterDeskripsi=strlen($deskripsi);
?>
        <input type="hidden" name="id_web_vidio" value="<?php echo $id_web_vidio; ?>">
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="judul_edit">
                    <small>Judul Vidio</small>
                </label>
                <div class="input-group">
                    <span class="input-group-text" id="inputGroupPrepend">
                        <small>
                            <code class="text text-dark" id="judul_edit_length"><?php echo $JumlahKarakterJudul; ?>/100</code>
                        </small>
                    </span>
                    <input type="text" name="judul" id="judul_edit" class="form-control" placeholder="Contoh: Kegiatan HUT RI" value="<?php echo $title_vidio; ?>">
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="deskripsi_edit">
                    <small>Deskripsi/Keterangan</small>
                </label>
                <textarea name="deskripsi" id="deskripsi_edit" class="form-control"><?php echo $deskripsi; ?></textarea>
                <small>
                    <code class="text text-dark" id="deskripsi_edit_length"><?php echo $JumlahKarakterDeskripsi; ?>/250</code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="sumber_vidio_edit">
                    <small>Sumber Vidio</small>
                </label>
                <select name="sumber_vidio" id="sumber_vidio_edit" class="form-control">
                    <option <?php if($sumber_vidio=="Local"){echo "selected";} ?> value="Local">Local File</option>
                    <option <?php if($sumber_vidio=="Url"){echo "selected";} ?> value="Url">URL</option>
                    <option <?php if($sumber_vidio=="Embed"){echo "selected";} ?> value="Embed">Embed Code</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="vidio_form_edit">
                <!-- Form File Vidio Akan Muncul Disini -->
                <?php
                if($sumber_vidio=="Local"){
                    echo '<label for="vidio_edit"><small>File Vidio</small></label>';
                    echo '<input type="file" name="vidio" id="vidio_edit" accept="video/*" class="form-control">';
                    echo '<small id="ValidasiFileGaleriEdit">';
                    echo '  <code class="text text-grayish">';
                    echo '      File yang digunakan maksimal 10 MB (mp4, webm, ogg, AVI, QuickTime, MPEG, 3GP, FLV, WMV)';
                    echo '  </code>';
                    echo '</small>';
                }else{
                    if($sumber_vidio=="Url"){
                        echo '<label for="vidio_edit"><small>Link/Url Vidio</small></label>';
                        echo '<input type="text" name="vidio" id="vidio_edit" class="form-control" placeholder="https://" value="'.$vidio.'">';
                        echo '<small>';
                        echo '  <code class="text text-grayish">';
                        echo '      Masukan link/url vidio yang anda miliki secara lengkap.';
                        echo '  </code>';
                        echo '</small>';
                    }else{
                        echo '<label for="vidio_edit"><small>Embed Code Vidio</small></label>';
                        echo '<textarea name="vidio" id="vidio_edit" class="form-control">'.$vidio.'</textarea>';
                    }
                }
                ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="thumbnail_edit"><small>Gambar Cuplikan</small></label>
                <input type="file" name="thumbnail" id="thumbnail_edit" class="form-control">
                <small id="ValidasiFileThumbnailEdit">
                    <code class="text text-grayish">
                        File yang digunakan maksimal 1 MB (JPEG, JPG, PNG, GIF)
                    </code>
                </small>
            </div>
        </div>
        <script>
            //Validasi Jumlah Karakter
            $('#judul_edit').on('input', function() {
                var value = $(this).val();
                var maxLength = 100;
                // Jika panjang melebihi batas, potong sesuai maxLength
                if (value.length > maxLength) {
                    value = value.substring(0, maxLength);
                }
                // Update nilai input
                $(this).val(value); 
                // Tampilkan jumlah karakter saat ini
                $('#judul_edit_length').text(value.length + '/' + maxLength);
            });
            $('#deskripsi_edit').on('input', function() {
                var value = $(this).val();
                var maxLength = 250;
                // Jika panjang melebihi batas, potong sesuai maxLength
                if (value.length > maxLength) {
                    value = value.substring(0, maxLength);
                }
                // Update nilai input
                $(this).val(value); 
                // Tampilkan jumlah karakter saat ini
                $('#deskripsi_edit_length').text(value.length + '/' + maxLength);
            });
            //Ketika Sumber Vidio Diubah
            $('#sumber_vidio_edit').on('change', function() {
                var value_vidio=$('#vidio_edit').val();
                var sumber_vidio_edit=$('#sumber_vidio_edit').val();
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Vidio/vidio_form_edit.php',
                    data        : {sumber_vidio: sumber_vidio_edit, value_vidio: value_vidio},
                    success     : function(data){
                        $('#vidio_form_edit').html(data);
                    }
                });
            });
        </script>
<?php
            }
        }
    }
?>