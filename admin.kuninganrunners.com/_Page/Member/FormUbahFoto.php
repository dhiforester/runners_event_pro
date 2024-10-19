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
        if(empty($_POST['id_member'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Member Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_member=$_POST['id_member'];
            //Bersihkan Data
            $id_member=validateAndSanitizeInput($id_member);
            //Buka Data
            $id_member_validasi=GetDetailData($Conn,'member','id_member',$id_member,'id_member');
            if(empty($id_member_validasi)){
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
        <input type="hidden" name="id_member" id="GetIdMember" value="<?php echo $id_member; ?>">
        <?php
            //Apabila File Foto ADa 
            $foto=GetDetailData($Conn,'member','id_member',$id_member,'foto');
            if(!empty($foto)){
                $PathFoto="assets/img/Member/$foto";
                echo '<div class="row border-1 border-bottom">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <img src="'.$PathFoto.'" alt="" width="50%" class="rounded-circle">';
                echo '  </div>';
                echo '  <div class="col-md-12 mb-3 text-center" id="NotifikasiHapusFoto"></div>';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <a href="javascript:void(0);" class="btn btn-sm btn-danger btn-rounded" id="ButtonHapusFoto"><i class="bi bi-trash"></i> Hapus Foto</a>';
                echo '  </div>';
                echo '</div>';
            }
        ?>
        <div class="row mt-3">
            <div class="col col-md-12 mb-3">
                <label for="foto_edit">
                    <small>Upload File Foto Member</small>
                </label>
                <input type="file" class="form-control" name="foto" id="foto_edit">
                <small id="ValidasiFileFotoEdit">
                    <!-- Notifikasi Validasi File Disini -->
                </small>
            </div>
        </div>
        <script>
            $('#ValidasiFileFotoEdit').html('<code class="text text-grayish">File Foto maksimal 5 mb (JPEG, JPG, PNG, GIF)</code>');
            // Validasi file foto
            $('#foto_edit').on('change', function() {
                var file = this.files[0];
                var validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                var maxSize = 5 * 1024 * 1024; // 2MB
                var validasiMessage = $('#ValidasiFileFotoEdit');

                if (file) {
                    if ($.inArray(file.type, validTypes) == -1) {
                        validasiMessage.html('<code class="text text-danger"><i class="bi bi-exclamation-circle"></i> Tipe file tidak valid. Hanya diperbolehkan jpeg, png, atau gif.</code>');
                        this.value = '';
                    } else if (file.size > maxSize) {
                        validasiMessage.html('<code class="text text-danger"><i class="bi bi-exclamation-circle"></i> Ukuran file maksimal 5MB</code>');
                        this.value = '';
                    } else {
                        validasiMessage.html('<code class="text text-success"><i class="bi bi-check-circle"></i> File Valid & Siap Di Upload</code>');
                    }
                }
            });
            //Apabila Foto Di Hapus
            $('#ButtonHapusFoto').click(function(){
                $('#ButtonHapusFoto').html('Loading...').prop('disabled', true);
                var id_member = $('#GetIdMember').val();
                $.ajax({
                    type    : 'POST',
                    url     : '_Page/Member/ProsesHapusFoto.php',
                    data    : {id_member: id_member},
                    success: function (response) {
                        $('#ButtonHapusFoto').html('<i class="bi bi-trash"></i> Hapus Foto').prop('disabled', false);
                        var result;
                        try {
                            result = JSON.parse(response); // Mencoba untuk parse JSON
                        } catch (e) {
                            $('#NotifikasiHapusFoto').html('<code class="text text-danger">Gagal memproses respons dari server.</code>');
                            return; // Keluar dari fungsi jika JSON tidak valid
                        }
                        if (result.success) {
                            ShowFotoMember();
                            $('#ButtonHapusFoto').html('<i class="bi bi-trash"></i> Hapus Foto').prop('disabled', false);
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/Member/FormUbahFoto.php',
                                data        : {id_member: id_member},
                                success     : function(data){
                                    $('#FormUbahFoto').html(data);
                                    $('#NotifikasiHapusFoto').html('');
                                }
                            });
                        } else {
                            // Menampilkan pesan kesalahan dari server
                            $('#NotifikasiHapusFoto').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                        }
                    },
                    error: function () {
                        $('#ButtonHapusFoto').html('<i class="bi bi-trash"></i> Hapus Foto').prop('disabled', false);
                        $('#NotifikasiHapusFoto').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
                    }
                });
            });
        </script>
<?php
            }
        }
    }
?>