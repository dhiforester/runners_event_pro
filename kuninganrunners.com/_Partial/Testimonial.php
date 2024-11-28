<?php
    $jumlah_testimoni=0;
    //Menangkan xtoken dari session
    session_start();
    if(empty($_SESSION['xtoken'])){
        echo "Silahkan Muat Ulang Halaman Terlebih Dulu!";
    }else{
        $xtoken=$_SESSION['xtoken'];
        include "../_Config/Connection.php";
        include "../_Config/GlobalFunction.php";
        //Mengatur Properti halaman
        $page_testimoni=1;
        $limit_testimoni=12;
        $WebTestimoni=WebTestimoni($url_server,$xtoken,$page_testimoni,$limit_testimoni);
        $WebTestimoni=json_decode($WebTestimoni, true);
        if($WebTestimoni['response']['code']!==200){
            echo "Terjadi kesalahan pada server";
        }else{
            $jumlah_testimoni=$WebTestimoni['metadata']['jumlah_testimoni'];
            $jumlah_halaman=$WebTestimoni['metadata']['jumlah_halaman'];
            $testimoni_list=$WebTestimoni['metadata']['testimoni_list'];
            if(empty($jumlah_testimoni)){
                echo "Tidak Ada Testimoni Yang Ditampilkan";
            }else{
                $no=1;
                foreach($testimoni_list as $testimoni_list_row){
                    $id_web_testimoni=$testimoni_list_row['id_web_testimoni'];
                    $nama=$testimoni_list_row['nama'];
                    $penilaian=$testimoni_list_row['penilaian'];
                    $datetime=$testimoni_list_row['datetime'];
                    $foto_profil=$testimoni_list_row['foto_profil'];
                    if(empty($foto_profil)){
                        $foto_profil="assets/img/No-Image.png";
                    }
                    //Format Datetime
                    $strtotime=strtotime($datetime);
                    $datetime_format=date('d M Y H:i',$strtotime);
?>
                    <div class="swiper-slide">
                        <div class="testimonial-item text-center">
                            <img src="<?php echo "$foto_profil"; ?>" class="testimonial-img" alt="">
                            <h3><?php echo "$nama"; ?></h3>
                            <h4 class="text-mobile"><?php echo "$datetime_format"; ?></h4>
                            <div class="stars">
                                <?php
                                    for ($i = 1; $i <= $penilaian; $i++) {
                                        echo '<i class="bi bi-star-fill text-warning"></i>';
                                    }
                                ?>
                            </div>
                            <p>
                                <button type="button" class="btn btn-sm btn-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalDetailTestimoni" data-id="<?php echo "$id_web_testimoni"; ?>">
                                    Baca Komentar
                                </button>
                            </p>
                        </div>
                    </div>
<?php
                    $no++;
                }
            }
        }
    }
?>