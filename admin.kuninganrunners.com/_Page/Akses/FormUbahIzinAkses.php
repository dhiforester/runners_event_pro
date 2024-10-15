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
        //Tangkap id_akses
        if(empty($_POST['id_akses'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <code>ID Akses Tidak Boleh Kosong</code>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_akses=$_POST['id_akses'];
            //Bersihkan Variabel
            $id_akses=validateAndSanitizeInput($id_akses);
            //Buka data askes
            $nama_akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'nama_akses');
            $kontak_akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'kontak_akses');
            $email_akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'email_akses');
            $image_akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'image_akses');
            $akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'akses');
            $datetime_daftar=GetDetailData($Conn,'akses','id_akses',$id_akses,'datetime_daftar');
            $datetime_update=GetDetailData($Conn,'akses','id_akses',$id_akses,'datetime_update');
            //Jumlah
            $JumlahAktivitas =mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses FROM log WHERE id_akses='$id_akses'"));
            $JumlahRole =mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM akses_ijin WHERE id_akses='$id_akses'"));
            //Format Tanggal
            $strtotime1=strtotime($datetime_daftar);
            $strtotime2=strtotime($datetime_update);
            //Menampilkan Tanggal
            $DateDaftar=date('d/m/Y H:i:s T', $strtotime1);
            $DateUpdate=date('d/m/Y H:i:s T', $strtotime2);
            if(!empty($image_akses)){
                $image_akses=$image_akses;
            }else{
                $image_akses="No-Image.png";
            }
?>
    <input type="hidden" name="id_akses" id="id_akses_edit" value="<?php echo "$id_akses"; ?>">
    <div class="accordion accordion-flush" id="AkordionIjinAkses">
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingIjinAkses1">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseIjinAkses1" aria-expanded="false" aria-controls="flush-collapseIjinAkses1">
                    A. Detail Akses
                </button>
            </h2>
            <div id="flush-collapseIjinAkses1" class="accordion-collapse collapse" aria-labelledby="flush-headingIjinAkses1" data-bs-parent="#AkordionIjinAkses">
                <div class="accordion-body">
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Nama Lengkap</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish"><?php echo $nama_akses; ?></code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Kontak</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish"><?php echo $kontak_akses; ?></code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Email</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish"><?php echo $email_akses; ?></code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Akses</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish"><?php echo $akses; ?></code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Datetime Creat</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish"><?php echo $DateDaftar; ?></code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Update Time</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish"><?php echo $DateUpdate; ?></code>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingIjinAkses2">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseIjinAkses2" aria-expanded="true" aria-controls="flush-collapseIjinAkses2">
                    B. Ijin Akses
                </button>
            </h2>
            <div id="flush-collapseIjinAkses2" class="accordion-collapse collapse show" aria-labelledby="flush-headingIjinAkses2" data-bs-parent="#AkordionIjinAkses">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_fitur"));
                                if(empty($jml_data)){
                                    echo '<code class="text-center text-danger">Belum ada data fitur aplikasi, silahkan tambahkan fitur aplikasi terlebih dulu</code>';
                                }else{
                                    echo '<div class="row">';
                                    $no_kategori=1;
                                    $QryKategoriFitur = mysqli_query($Conn, "SELECT DISTINCT kategori FROM akses_fitur ORDER BY kategori ASC");
                                    while ($DataKategori = mysqli_fetch_array($QryKategoriFitur)) {
                                        $kategori= $DataKategori['kategori'];
                                        echo '<div class="col-md-12 mb-2">';
                                        echo '  <small class="credit">'.$no_kategori.'. '.$kategori.'</small>';
                                        echo '  <ul>';
                                        $QryFitur = mysqli_query($Conn, "SELECT * FROM akses_fitur WHERE kategori='$kategori' ORDER BY nama ASC");
                                        while ($DataFitur = mysqli_fetch_array($QryFitur)) {
                                            $id_akses_fitur= $DataFitur['id_akses_fitur'];
                                            $NamaFitur= $DataFitur['nama'];
                                            $kode= $DataFitur['kode'];
                                            echo '<li>';
                                            //Validasi Apakah Bersangkutan Punya Akses Ini
                                            $Validasi=IjinAksesSaya($Conn,$id_akses,$kode);
                                            if($Validasi=="Ada"){
                                                echo '<input type="checkbox" checked name="rules[]" id="IdFiturEdit'.$id_akses_fitur.'" value="'.$id_akses_fitur.'"> ';
                                                echo '<label for="IdFiturEdit'.$id_akses_fitur.'"><small class="credit"><code class="text text-grayish">'.$NamaFitur.'</code></small></label>';
                                            }else{
                                                echo '<input type="checkbox" name="rules[]" id="IdFiturEdit'.$id_akses_fitur.'" value="'.$id_akses_fitur.'"> ';
                                                echo '<label for="IdFiturEdit'.$id_akses_fitur.'"><small class="credit"><code class="text text-grayish">'.$NamaFitur.'</code></small></label>';
                                            }
                                            echo '  </td>';
                                            echo '</li>';
                                        }
                                        echo '  </ul>';
                                        echo '</div>';
                                        $no_kategori++;
                                    }
                                    echo '</div>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php 
        } 
    } 
?>