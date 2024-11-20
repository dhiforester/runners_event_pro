<div class="sub-page-title dark-background">
</div>
<?php
    //Menangkap Nama Album
    if(empty($_GET['album'])){
        echo '<section id="portfolio" class="portfolio section">';
        echo '  <div class="container">';
        echo '      <div class="row">';
        echo '          <div class="col-md-12 text-center text-danger">';
        echo '              Nama Album Tidak Boleh Kosong!';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</section>';
    }else{
        $nama_album=$_GET['album'];
?>
    <section id="portfolio" class="portfolio section">
        <div class="container mb-3">
            <div class="row mb-4">
                <div class="col-md-12 text-center mb-4">
                    <h4>
                        <i class="bi bi-bookmark"></i> Album "<i><?php echo $nama_album; ?></i>"
                    </h4>
                    <small>
                        Menampilkan Semua Galeri Pada Album "<i><?php echo $nama_album; ?></i>"
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="index.php?Page=Galeri" class="button button-back">
                        <i class="bi bi-chevron-left"></i> Kembali Ke Album
                    </a>
                </div>
            </div>
        </div>
        <div class="container mt-3">
            <div class="row mb-3">
                <div class="col-md-12 mb-3">

                </div>
            </div>
            <?php
                //Mengatur Properti halaman
                $NamaAlbumURL = str_replace(' ', '-', $nama_album);
                $WebGaleri=WebGaleri($url_server,$xtoken,$NamaAlbumURL);
                $WebGaleri=json_decode($WebGaleri, true);
                if($WebGaleri['response']['code']!==200){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center text-danger">';
                    echo '      Terjadi kesalahan pada server';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center text-danger">';
                    echo '      '.$WebGaleri['response']['message'].'';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $metadata=$WebGaleri['metadata'];
                    if(empty(count($metadata))){
                        echo "Tidak Ada File Pada Album Yang Ditampilkan";
                    }else{
                        echo '<div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">';
                        echo '  <div class="row gy-4 isotope-container mb-4" data-aos="fade-up" data-aos-delay="200">';
                        foreach($metadata as $metadata_list){
                            $datetime=$metadata_list['datetime'];
                            $nama_galeri=$metadata_list['nama_galeri'];
                            $image=$metadata_list['image'];
                            //Format Tanggal
                            $strtotime=strtotime($datetime);
                            $datetime_format=date('d/m/Y', $strtotime);
                            echo '<div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-3 portfolio-item isotope-item">';
                            echo '  <img src="' . $image . '" class="img-fluid uniform-height" alt="" width="100%">';
                            echo '  <div class="portfolio-info">';
                            echo '      <a href="' . $image . '" title="'.$nama_galeri.' 2" data-gallery="portfolio-gallery-branding" class="glightbox">';
                            echo '          '.$nama_galeri.'';
                            echo '      </a>';
                            echo '      <p>'.$datetime_format.'</p>';
                            echo '  </div>';
                            echo '</div>';
                        }
                        echo '  </div>';
                        echo '</div>';
                    }
                }
            ?>
        </div>
    </section>
<?php } ?>
