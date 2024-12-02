<?php
    //Menangkan xtoken dari session
    session_start();
    if(empty($_SESSION['xtoken'])){
        echo "Silahkan Muat Ulang Halaman Terlebih Dulu!";
    }else{
        $xtoken=$_SESSION['xtoken'];
        include "../_Config/Connection.php";
        include "../_Config/GlobalFunction.php";
        //Mengatur Properti halaman
        $page_album=1;
        $limit_album=4;
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
                // echo '<div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-3 portfolio-item isotope-item">';
                // echo '  <a href="index.php?Page=Galeri&album='.$nama_album.'">';
                // echo '      <img src="data:image/jpeg;base64,' . $cover_album . '" class="img-fluid" alt="" width="100%">';
                // echo '  </a>';
                // echo '  <div class="portfolio-info">';
                // echo '      <h4>';
                // echo '          <a href="index.php?Page=Galeri&album='.$nama_album.'">'.$nama_album.'</a>';
                // echo '      </h4>';
                // echo '      <p>'.$jumlah_galeri.' Galeri</p>';
                // echo '  </div>';
                // echo '</div>';

                echo '<div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-3 portfolio-item isotope-item">';
                echo '  <article class="bg_utama">';
                echo '      <a href="index.php?Page=Galeri&album='.$nama_album.'">';
                echo '          <div class="post-img">';
                echo '              <img src="data:image/jpeg;base64,' . $cover_album . '" class="img-fluid zoomed_image" alt="" width="100%">';
                echo '          </div>';
                echo '          <p class="post-category">';
                echo '              <b class="text text-white">'.$nama_album.'</b>';
                echo '          </p>';
                echo '          <small class="mobile-text text text-white"><i class="bi bi-image"></i> '.$jumlah_galeri.' Galeri</small><br>';
                echo '      </a>';
                echo '  </article>';
                echo '</div>';
            }
            echo '  </div>';
            if($jumlah_halaman>1){
                echo '<div class="row mb-4">';
                echo '  <div class="col-xl-12 text-center">';
                echo '      <a href="index.php?Page=Galeri" class="button_more">';
                echo '         Album Lainnya';
                echo '      </a>';
                echo '  </div>';
                echo '</div>';
            }
            echo '</div>';
        }
    }
?>
