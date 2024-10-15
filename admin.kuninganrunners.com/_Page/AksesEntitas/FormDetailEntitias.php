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
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="accordion accordion-flush" id="accordionFlushExampleEntitias">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOneEntitasx">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOnex" aria-expanded="true" aria-controls="flush-headingOneEntitasx">
                                Detail Entitias
                            </button>
                        </h2>
                        <div id="flush-collapseOnex" class="accordion-collapse collapse show" aria-labelledby="flush-headingOneEntitasx" data-bs-parent="#accordionFlushExampleEntitias">
                            <div class="row mb-3">
                                <div class="col col-md-4"><small class="credit">Nama Entitias</small></div>
                                <div class="col col-md-8">
                                    <small class="credit">
                                        <code class="text text-grayish"><?php echo "$NamaAkses"; ?></code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col col-md-4 mb-3"><small class="credit">Keterangan</small></div>
                                <div class="col col-md-8 mb-3">
                                    <small class="credit">
                                        <code class="text text-grayish"><?php echo "$KeteranganEntitias"; ?></code>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        $no=1;
                        $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM akses_fitur ORDER BY kategori ASC");
                        while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                            $KategoriList= $DataKategori['kategori'];
                            echo '  <div class="accordion-item">';
                            echo '      <h2 class="accordion-header" id="flush-headingOneEntitas'.$no.'">';
                            echo '          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne'.$no.'" aria-expanded="false" aria-controls="flush-headingOneEntitas'.$no.'">';
                            echo '              <small class="credit">'.$no.'. '.$KategoriList.'</small>';
                            echo '          </button>';
                            echo '      </h2>';
                            echo '      <div id="flush-collapseOne'.$no.'" class="accordion-collapse collapse" aria-labelledby="flush-headingOneEntitas'.$no.'" data-bs-parent="#accordionFlushExampleEntitias">';
                            echo '';
                            echo '          <ul>';
                                            $QryFitur = mysqli_query($Conn, "SELECT * FROM akses_fitur WHERE kategori='$KategoriList' ORDER BY nama ASC");
                                            while ($DataFitur = mysqli_fetch_array($QryFitur)) {
                                                $id_akses_fitur= $DataFitur['id_akses_fitur'];
                                                $KodeFitur= $DataFitur['kode'];
                                                $NamaFitur= $DataFitur['nama'];
                                                $KeteranganFitur= $DataFitur['keterangan'];
                                                //Validasi Apakah Bersangkutan Punya Akses Ini
                                                $Validasi=CekFiturEntitias($Conn,$uuid_akses_entitas,$id_akses_fitur);
                                                if($Validasi=="Ada"){
                                                    echo '<li><small><code class="text text-grayish">'.$NamaFitur.' <i class="bi bi-check text-success"></i></code></small></li>';
                                                }else{
                                                    echo '<li><small><code class="text text-grayish">'.$NamaFitur.' <i class="bi bi-x text-danger"></i></code></small></li>';
                                                }
                                            }
                            echo '          </ul>';
                            echo '      </div>';
                            echo '  </div>';
                            $no++;
                        }
                    ?>
                </div>
            </div>
        </div>
<?php
            }
        }
    }
?>