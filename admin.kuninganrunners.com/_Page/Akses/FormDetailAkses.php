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
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                            A. Identitias Pengguna
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
                        <div class="accordion-body">
                            <div class="row mb-3 mt-3">
                                <div class="col-md-12 mb-4">
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
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            B. Foto Profil
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="row mb-3 mt-3">
                                <div class="col-md-12 text-center">
                                    <img src="assets/img/User/<?php echo $image_akses; ?>" alt="" width="50%" class="rounded-circle">
                                </div>
                                <div class="col-md-12 text-center">
                                    <small>
                                        <code><?php echo $image_akses; ?></code>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            C. Ijin Akses Fitur
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <?php
                                $no=1;
                                echo '<div class="row mb-3 mt-3">';
                                $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM akses_fitur ORDER BY kategori ASC");
                                while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                                    $KategoriList= $DataKategori['kategori'];
                                    echo '  <div class="col-md-12">';
                                    echo '     <small class="credit">'.$no.'. '.$KategoriList.'</small><br>';
                                    echo '      <ul>';
                                    $QryFitur = mysqli_query($Conn, "SELECT * FROM akses_fitur WHERE kategori='$KategoriList' ORDER BY nama ASC");
                                    while ($DataFitur = mysqli_fetch_array($QryFitur)) {
                                        $id_akses_fitur= $DataFitur['id_akses_fitur'];
                                        $KodeFitur= $DataFitur['kode'];
                                        $NamaFitur= $DataFitur['nama'];
                                        $KeteranganFitur= $DataFitur['keterangan'];
                                        //Validasi Apakah Bersangkutan Punya Akses Ini
                                        $Validasi=IjinAksesSaya($Conn,$id_akses,$KodeFitur);
                                        if($Validasi=="Ada"){
                                            echo '<li><code class="text text-grayish">'.$NamaFitur.' <i class="bi bi-check text-success"></i></code></li>';
                                        }else{
                                            echo '<li><code class="text text-grayish">'.$NamaFitur.' <i class="bi bi-x text-danger"></i></code></li>';
                                        }
                                    }
                                    echo '      </ul>';
                                    echo '  </div>';
                                    $no++;
                                }
                                echo '</div>';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
<?php 
        } 
    } 
?>