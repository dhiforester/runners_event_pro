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
        if(empty($_POST['uuid_akses_entitas'])){
            echo '<code>ID Entitias Tidak Boleh Kosong!</code>';
        }else{
            $uuid_akses_entitas=$_POST['uuid_akses_entitas'];
            $uuid_akses_entitas=validateAndSanitizeInput($uuid_akses_entitas);
            //Bersihkan Data
            $uuid_akses_entitas=GetDetailData($Conn,'akses_entitas','uuid_akses_entitas',$uuid_akses_entitas,'uuid_akses_entitas');
            if(empty($uuid_akses_entitas)){
                echo '<code>ID Entitias Tidak Valid, Atau Tidak Ditemukan Pada Database!</code>';
            }else{
                $NamaAkses=GetDetailData($Conn,'akses_entitas','uuid_akses_entitas',$uuid_akses_entitas,'akses');
                $KeteranganEntitias=GetDetailData($Conn,'akses_entitas','uuid_akses_entitas',$uuid_akses_entitas,'keterangan');
?>
        <input type="hidden" name="uuid_akses_entitas" value="<?php echo $uuid_akses_entitas; ?>">
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="akses_edit">Nama Entitias</label>
            </div>
            <div class="col-md-9">
                <div class="input-group">
                    <span class="input-group-text" id="inputGroupPrepend">
                        <small>
                            <code class="text text-dark" id="akses_length_edit">0/20</code>
                        </small>
                    </span>
                    <input type="text" class="form-control" name="akses" id="akses_edit" value="<?php echo $NamaAkses; ?>">
                </div>
                <small>
                    <code class="text text-grayish">
                        Nama level akses, unit kerja atau bisa diisi dengan nama jabatan.
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="keterangan_edit">Keterangan</label>
            </div>
            <div class="col-md-9">
                <div class="input-group">
                    <span class="input-group-text" id="inputGroupPrepend">
                        <small>
                            <code class="text text-dark" id="keterangan_length_edit">0/200</code>
                        </small>
                    </span>
                    <input type="text" class="form-control" name="keterangan" id="keterangan_edit" value="<?php echo $KeteranganEntitias; ?>">
                </div>
                <small>
                    <code class="text text-grayish">
                        Gambaran umum tugas dan fungsi entitas tersebut.
                    </code>
                </small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-3">
                Ijin Akses
            </div>
            <div class="col-md-12">
                <?php
                    //Tampilkan Kategori Ijin Akses
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_fitur"));
                    if(empty($jml_data)){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center text-danger">';
                        echo '      <smal>';
                        echo '          <code cass="text-danger">';
                        echo '              Belum Ada Data Akses Yang Dibuat';
                        echo '          </code>';
                        echo '      </smal>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        echo '<div class="accordion" id="accordionExample2">';
                        $no_kategori=1;
                        $QryKategoriFitur = mysqli_query($Conn, "SELECT DISTINCT kategori FROM akses_fitur ORDER BY kategori ASC");
                        while ($DataKategori = mysqli_fetch_array($QryKategoriFitur)) {
                            $kategori= $DataKategori['kategori'];
                            echo '<div class="accordion-item">';
                            echo '  <h2 class="accordion-header" id="heading_edit'.$no_kategori.'">';
                            echo '      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_edit'.$no_kategori.'" aria-expanded="false" aria-controls="collapse_edit'.$no_kategori.'">';
                            echo '          <small class="credit">'.$no_kategori.'. '.$kategori.'</small>';
                            echo '      </button>';
                            echo '  </h2>';
                            echo '  <div id="collapse_edit'.$no_kategori.'" class="accordion-collapse collapse" aria-labelledby="heading_edit'.$no_kategori.'" data-bs-parent="#accordionExample2" style="">';
                            echo '      <div class="accordion-body">';
                            echo '          <ul class="">';
                                                $no_fitur=1;
                                                $QryFitur = mysqli_query($Conn, "SELECT * FROM akses_fitur WHERE kategori='$kategori' ORDER BY nama ASC");
                                                while ($DataFitur = mysqli_fetch_array($QryFitur)) {
                                                    $id_akses_fitur= $DataFitur['id_akses_fitur'];
                                                    $nama= $DataFitur['nama'];
                                                    $keterangan= $DataFitur['keterangan'];
                                                    $kode= $DataFitur['kode'];
                                                    echo '<li class="">';
                                                    echo '  <div cass="row">';
                                                    echo '      <div cass="col-md-12">';
                                                    //Validasi Apakah Bersangkutan Punya Akses Ini
                                                    $Validasi=CekFiturEntitias($Conn,$uuid_akses_entitas,$id_akses_fitur);
                                                    if($Validasi=="Ada"){
                                                        echo '<input type="checkbox" checked name="rules[]" class="ListFitur" kategori="'.$no_kategori.'" id="IdFiturEdit'.$id_akses_fitur.'" value="'.$id_akses_fitur.'">';
                                                    }else{
                                                        echo '<input type="checkbox" name="rules[]" class="ListFitur" kategori="'.$no_kategori.'" id="IdFiturEdit'.$id_akses_fitur.'" value="'.$id_akses_fitur.'">';
                                                    }
                                                    echo '          <label for="IdFiturEdit'.$id_akses_fitur.'" title="'.$keterangan.'"><smal><code class="text text-grayish">'.$nama.'</code></smal></label>';
                                                    echo '      </div>';
                                                    echo '  </div>';
                                                    echo '</li>';
                                                }
                            echo '          </ul>';
                            echo '      </div>';
                            echo '  </div>';
                            echo '</div>';
                            $no_kategori++;
                        }
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                var akses_max_length_edit = 20;
                var keterangan_max_length_edit = 200;
                function updateCharCountAksesEdit() {
                    var charCount2 = $('#akses_edit').val().length;
                    $('#akses_length_edit').text(charCount2 + '/' + akses_max_length_edit);
                }
                function updateCharCountKeteranganEdit() {
                    var charCount2 = $('#keterangan_edit').val().length;
                    $('#keterangan_length_edit').text(charCount2 + '/' + keterangan_max_length_edit);
                }
                updateCharCountAksesEdit();
                updateCharCountKeteranganEdit();
                $('#akses_edit').on('input', function() {
                    var currentValue2 = $(this).val();
                    var charCount2 = currentValue2.length;
                    // Cek apakah jumlah karakter melebihi
                    if (charCount2 > akses_max_length_edit) {
                        // Jika melebihi, batasi input
                        $(this).val(currentValue2.substring(0, akses_max_length_edit));
                    }
                    // Update tampilan jumlah karakter
                    updateCharCountAksesEdit();
                });
                $('#keterangan_edit').on('input', function() {
                    var currentValue2 = $(this).val();
                    var charCount2 = currentValue2.length;
                    // Cek apakah jumlah karakter melebihi
                    if (charCount2 > keterangan_max_length_edit) {
                        // Jika melebihi, batasi input
                        $(this).val(currentValue2.substring(0, keterangan_max_length_edit));
                    }
                    // Update tampilan jumlah karakter
                    updateCharCountKeteranganEdit();
                });
            });
        </script>
<?php
            }
        }
    }
?>