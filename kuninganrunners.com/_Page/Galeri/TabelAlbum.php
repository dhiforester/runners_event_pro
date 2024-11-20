<?php
    session_start();
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    //Menangkan xtoken dari session
    if(empty($_SESSION['xtoken'])){
        echo '<div class="row mb-4">';
        echo '  <div class="col-md-12">';
        echo '      <div class="card mb-3">';
        echo '          <div class="card-body text-center text-danger">';
        echo '              <small>Tidak Ada Sesi Token</small>';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $xtoken=$_SESSION['xtoken'];
        //Mengatur Properti halaman
        //Buka Fungsi List Barang
        $limit=8;
        if(empty($_POST['page'])){
            $page=1;
        }else{
            $page=$_POST['page'];
        }
        $WebAlbum=WebAlbum($url_server,$xtoken,$page,$limit);
        $WebAlbum=json_decode($WebAlbum, true);
        if($WebAlbum['response']['code']!==200){
            echo '<div class="row mb-4">';
            echo '  <div class="col-md-12">';
            echo '      <div class="card mb-3">';
            echo '          <div class="card-body text-center text-danger">';
            echo '              '.$WebAlbum['response']['message'].'';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $jumlah_album=$WebAlbum['metadata']['jumlah_album'];
            $jumlah_halaman=$WebAlbum['metadata']['jumlah_halaman'];
            $list_album=$WebAlbum['metadata']['list_album'];
            if(empty($jumlah_album)){
                echo '<div class="row mb-4">';
                echo '  <div class="col-md-12">';
                echo '      <div class="card mb-3">';
                echo '          <div class="card-body text-center text-danger">';
                echo '              Tidak Ada Data Yang Ditampilkan';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
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
                echo '          <img src="data:image/jpeg;base64,' . $cover_album . '" class="img-fluid zoomed_image" alt="" width="100%">';
                echo '      </div>';
                echo '      <p class="post-category">';
                echo '          <b class="text text-dark">'.$nama_album.'</b>';
                echo '      </p>';
                echo '      <small class="text text-grayish"><i class="bi bi-image"></i> '.$jumlah_galeri.' Galeri</small><br>';
                echo '      <a href="index.php?Page=Galeri&album='.$nama_album.'">';
                echo '          <small>';
                echo '              <code class="text text-primary"><i class="bi bi-three-dots"></i> Lihat Galeri</code>';
                echo '          </small>';
                echo '      </a>';
                echo '  </article>';
                echo '</div>';
            }
            echo '  </div>';
            echo '  <div class="row mb-4 mt-4">';
            echo '      <section id="blog-pagination" class="blog-pagination section">';
            echo '          <div class="container">';
            echo '              <div class="d-flex justify-content-center">';
            echo '                  <ul>';
            for ($i=1; $i <=$jumlah_halaman; $i++) { 
                if($i==$page){
                    echo '<li><a href="javascript:void(0);" class="page active">'.$i.'</a></li>';
                }else{
                    echo '<li><a href="javascript:void(0);" class="page">'.$i.'</a></li>';
                }
            }
            echo '                  </ul>';
            echo '              </div>';
            echo '          </div>';
            echo '      </section>';
            echo '  </div>';
            echo '</div>';
        }
    }
?>
<script>
    $(document).on('click', '.page', function () {
        // Ambil nilai teks dari elemen yang diklik
        let pageValue = $(this).text();
        $('#put_page').val(pageValue);
        FilterAlbum();
    });
</script>