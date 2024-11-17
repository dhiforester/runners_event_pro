<div class="sub-page-title dark-background">
</div>
<section id="portfolio" class="portfolio section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h4>
                    <i class="bi bi-bookmark"></i> Album Kegiatan
                </h4>
                <small>
                    Menampilkan Semua Riwayat Album Kegaiatan
                </small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <button type="button" class="button button-back" id="KembaliKeBeranda">
                    <i class="bi bi-chevron-left"></i> Kembali Ke Beranda
                </button>
            </div>
        </div>
    </div>
</section>
<section id="blog-posts" class="blog-posts section">
    <div class="container">
        <?php
            //Mengatur Properti halaman
            $page_album=1;
            $limit_album=8;
            $WebAlbum=WebAlbum($url_server,$xtoken,$page_album,$limit_album);
            $WebAlbum=json_decode($WebAlbum, true);
            if($WebAlbum['response']['code']!==200){
                echo "Terjadi kesalahan pada server";
            }else{
                $jumlah_album=$WebAlbum['metadata']['jumlah_album'];
                $jumlah_halaman=$WebAlbum['metadata']['jumlah_halaman'];
                $list_album=$WebAlbum['metadata']['list_album'];
                if(empty($jumlah_album)){
                    echo "Tidak Ada ALbum Yang Ditampilkan";
                }
                echo '<div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">';
                echo '  <div class="row gy-4 isotope-container mb-4" data-aos="fade-up" data-aos-delay="200">';
                foreach($list_album as $album_web_list){
                    $nama_album=$album_web_list['album'];
                    $jumlah_galeri=$album_web_list['galeri'];
                    $cover_album=$album_web_list['image'];
                    echo '<div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-3 portfolio-item isotope-item">';
                    echo '  <article>';
                    echo '      <div class="post-img">';
                    echo '          <img src="data:image/jpeg;base64,' . $cover_album . '" class="img-fluid" alt="" width="100%">';
                    echo '      </div>';
                    echo '      <p class="post-category">';
                    echo '          <a href="index.php?Page=Galeri&album='.$nama_album.'">'.$nama_album.'</a>';
                    echo '      </p>';
                    echo '      <small>'.$jumlah_galeri.' Galeri</small>';
                    echo '  </article>';
                    echo '</div>';
                }
                echo '  </div>';
                if($jumlah_halaman>1){
                    echo '<div class="row mb-4">';
                    echo '  <div class="col-xl-12 text-center">';
                    echo '      <a href="index.php?Page=Album" class="button_more">';
                    echo '         Album Lainnya';
                    echo '      </a>';
                    echo '  </div>';
                    echo '</div>';
                }
                echo '</div>';
            }
        ?>
    </div>
</section>