<?php
    //Mengirim Permintaan Data Summary Ke Server
    $WebSummaryReq=WebSummary($url_server,$xtoken);
    $WebSummary=json_decode($WebSummaryReq, true);
    if($WebSummary['response']['code']!==200){
        echo "Terjadi Kesalahan Koneksi Data Dengan Server";
    }else{
?>
    <!-- HERO -->
    <section id="hero" class="hero section hero-background">
        <div id="hero-carousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">
            <div class="carousel-item active">
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown">Selamat Datang</h2>
                    <p class="animate__animated animate__fadeInUp">
                        Selamat datang di platform komunikasi dan informasi bagi komunitas lari Kabupaten Kuningan, Jawa Barat. 
                    </p>
                    <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Selengkapnya</a>
                </div>
            </div>
            <?php
                //Buka Fungsi List Event
                $list_event=$WebSummary['metadata']['event_list'];
                $jumlah_event=count($list_event);
                if(!empty($jumlah_event)){
                    foreach($list_event as $event_list){
                        $id_event=$event_list['id_event'];
                        $tanggal_mulai=$event_list['tanggal_mulai'];
                        $tanggal_selesai=$event_list['tanggal_selesai'];
                        $mulai_pendaftaran=$event_list['mulai_pendaftaran'];
                        $selesai_pendaftaran=$event_list['selesai_pendaftaran'];
                        $nama_event=$event_list['nama_event'];
                        $keterangan=$event_list['keterangan'];
                        //Format Datetime
                        $strtotime1=strtotime($tanggal_mulai);
                        $strtotime2=strtotime($tanggal_selesai);
                        $strtotime3=strtotime($mulai_pendaftaran);
                        $strtotime4=strtotime($selesai_pendaftaran);
                        $tanggal_mulai_format=date('d F Y',$strtotime1);
                        $tanggal_selesai_format=date('d F Y',$strtotime2);
                        $mulai_pendaftaran_format=date('d F Y',$strtotime3);
                        $selesai_pendaftaran_format=date('d F Y',$strtotime4);
            ?>
                                <div class="carousel-item">
                                    <div class="carousel-container">
                                        <h2 class="animate__animated animate__fadeInDown">
                                            <?php echo $nama_event; ?>
                                        </h2>
                                        <p class="animate__animated animate__fadeInUp">
                                            <?php echo "$tanggal_mulai_format<br>"; ?>
                                        </p>
                                        <a href="index.php?Page=DetailEvent&id=<?php echo $id_event; ?>" class="btn-get-started animate__animated animate__fadeInUp scrollto">Selengkapnya</a>
                                    </div>
                                </div>
            <?php
                    }
                }
            ?>

            <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a>
        </div>
        <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
            <defs>
                <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
            </defs>
            <g class="wave1">
                <use xlink:href="#wave-path" x="50" y="3"></use>
            </g>
            <g class="wave2">
                <use xlink:href="#wave-path" x="50" y="0"></use>
            </g>
            <g class="wave3">
                <use xlink:href="#wave-path" x="50" y="9"></use>
            </g>
        </svg>
    </section>
    <!-- TENTANG KAMI -->
    <section id="about" class="about section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Tentang Kami</h2>
            <p><?php echo "$tentang_judul"; ?></p>
        </div><!-- End Section Title -->
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-12 content" data-aos="fade-up" data-aos-delay="100">
                    <small id="KontenTentangKami">
                        <?php echo "$tentang_preview"; ?>
                    </small>
                </div>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-md-12 text-center">
                    <button type="button" class="button_more" id="ButtonTentangKamiMore">
                        Baca Selengkapnya
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- KONTAK -->
    <section id="call-to-action" class="call-to-action section kontak-background">
        <div class="container">
            <div class="row mb-3 mt-3">
                <div class="col-md-4 mb-3 mt-3 text-center">
                    <h2>Kontak Kami</h2>
                    <div class="row mb-3 mt-3" data-aos="zoom-in" data-aos-delay="100">
                        <div class="col-md-12 text-center"><b><small>Alamat</small></b></div>
                        <div class="col-md-12 text-center"><small><?php echo "$kontak_alamat"; ?></small></div>
                    </div>
                    <div class="row mb-3" data-aos="zoom-in" data-aos-delay="110">
                        <div class="col-md-12 text-center"><b><small>Email</small></b></div>
                        <div class="col-md-12 text-center"><small><?php echo "$kontak_email"; ?></small></div>
                    </div>
                    <div class="row mb-3" data-aos="zoom-in" data-aos-delay="120">
                        <div class="col-md-12 text-center"><b><small>Kontak </small></b></div>
                        <div class="col-md-12 text-center"><small><?php echo "$kontak_telepon"; ?></small></div>
                    </div>
                </div>
                <div class="col-md-8 text-center mb-3 mt-3">
                    <h2 class="mb-3">Media Sosial</h2>
                    <div class="row mt-3">
                        <div class="col-md-12 text-center" data-aos="zoom-in" data-aos-delay="130">
                            <?php
                                $medsos=$WebSummary['metadata']['medsos'];
                                $jumlah_medsos=count($medsos);
                                if(!empty($jumlah_medsos)){
                                    foreach($medsos as $medsos_list) {
                                        $nama_medsos =$medsos_list['nama_medsos'];
                                        $logo = $medsos_list['logo']; // Base64 dari server harus valid
                                        $url_medsos = htmlspecialchars($medsos_list['url_medsos'], ENT_QUOTES, 'UTF-8');
                                    
                                        echo '<a href="' . $url_medsos . '" title="' . $nama_medsos . '">';
                                        echo '  <img src="' . $logo . '" alt="' . $nama_medsos . '" class="medsos-logo">';
                                        echo '</a>';
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ALBUM -->
    <section id="blog-posts" class="blog-posts section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Album</h2>
            <p>Dokumentasi Kegiatan</p>
        </div>
        <div class="container" id="ShowAlbum">
            <?php
                $album=$WebSummary['metadata']['album_list'];
                $jumlah_album=count($album);
                if(empty($jumlah_album)){
                    echo '<div class="col-md-12 portfolio-item isotope-item">';
                    echo '  <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo '      <small class="mobile-text">';
                    echo "          Tidak Ada Album Yang Ditampilkan";
                    echo '      </small>';
                    echo '  </div>';
                    echo '</div>';
                }
                echo '<div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">';
                echo '  <div class="row gy-4 isotope-container mb-4" data-aos="fade-up" data-aos-delay="200">';
                foreach($album as $album_web_list){
                    $nama_album=$album_web_list['album'];
                    $jumlah_galeri=$album_web_list['galeri'];
                    $cover_album=$album_web_list['image'];
                    echo '<div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-3 portfolio-item isotope-item">';
                    echo '  <article class="bg_utama">';
                    echo '      <a href="index.php?Page=Galeri&album='.$nama_album.'">';
                    echo '          <div class="post-img image-container">';
                    echo '              <img src="' . $cover_album . '" class="img-fluid zoomed_image" alt="" width="100%">';
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
                echo '  <div class="row mb-4">';
                echo '      <div class="col-xl-12 text-center">';
                echo '          <a href="index.php?Page=Galeri" class="button_more">';
                echo '              Selengkapnya';
                echo '          </a>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            ?>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section testimoni-background">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Testimonials</h2>
            <p>Pendapat Dari Member</p>
        </div>
        <!-- End Section Title -->
        <div class="container" data-aos="fade-up" data-aos-delay="100" id="">
            <!-- Testimoni Ditampilkan Disini -->
            <div class="swiper init-swiper">
                <script type="application/json" class="swiper-config">
                    {
                        "loop": true,
                        "speed": 600,
                        "autoplay": {
                        "delay": 5000
                        },
                        "slidesPerView": "auto",
                        "pagination": {
                        "el": ".swiper-pagination",
                        "type": "bullets",
                        "clickable": true
                        },
                        "breakpoints": {
                        "320": {
                            "slidesPerView": 1,
                            "spaceBetween": 40
                        },
                        "1200": {
                            "slidesPerView": 3,
                            "spaceBetween": 10
                        }
                        }
                    }
                </script>
                <div class="swiper-wrapper" id="ShowTestimonial">
                    <?php
                        $no=1;
                        $testimoni_list=$WebSummary['metadata']['testimoni_list'];
                        $jumlah_testimoni=count($testimoni_list);
                        if(!empty($jumlah_testimoni)){
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
                            } 
                        } 
                    ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <a href="index.php?Page=Testimoni" class="button_more">
                        Lihat Selengkapnya
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Faq Section -->
    <section id="faq" class="faq section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Frequently Asked Questions</h2>
            <p>Pertanyaan yang Sering Diajukan</p>
        </div>
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-12">
                    <div class="custom-accordion" id="accordion-faq">
                        <!-- FAQ Akan Ditampilkan Disini -->
                        <?php
                            $faq_list_arry=$WebSummary['metadata']['faq_list'];
                            $jumlah_faq=count($faq_list_arry);
                            if(!empty($jumlah_faq)){
                                foreach($faq_list_arry as $faq_list){
                                    $urutan=$faq_list['urutan'];
                                    $pertanyaan=$faq_list['pertanyaan'];
                                    $jawaban=$faq_list['jawaban'];
                                    echo '<div class="accordion-item">';
                                    echo '  <h2 class="mb-0">';
                                    echo '      <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-'.$urutan.'">';
                                    echo '          '.$pertanyaan.'';
                                    echo '      </button>';
                                    echo '  </h2>';
                                    echo '  <div id="collapse-faq-'.$urutan.'" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-faq">';
                                    echo '      <div class="accordion-body">';
                                    echo '         '.$jawaban.'';
                                    echo '      </h4>';
                                    echo '  </div>';
                                    echo '</div>';
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- List All Event -->
    <section id="event" class="event section event-background">
        <div class="container section-title" data-aos="fade-up">
            <h2>Event Runner's</h2>
            <p>Kalender Event</p>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12" id="ListAllEvent">
                    <?php
                        $event_list_arry=$WebSummary['metadata']['event_list_all'];
                        $jumlah_event_all=count($event_list_arry);
                        if(!empty($jumlah_event_all)){
                            foreach($event_list_arry as $event_list){
                                $id_event=$event_list['id_event'];
                                $tanggal_mulai=$event_list['tanggal_mulai'];
                                $nama_event=$event_list['nama_event'];
                                //Format Datetime
                                $strtotime1=strtotime($tanggal_mulai);
                                $tanggal_mulai_format=date('d F Y',$strtotime1);
                    ?>
                                <a href="index.php?Page=DetailEvent&id=<?php echo $id_event; ?>">
                                    <div class="card mb-3 card-event" id="">
                                        <div class="card-body" >
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <small><i class="bi bi-calendar"></i> <?php echo $tanggal_mulai_format; ?></small>
                                                </div>
                                                <div class="col-md-9">
                                                    <small class="text text-grayish"><?php echo $nama_event; ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                    <?php
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <section id="product" class="team section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Merchandise</h2>
        </div>
        <div class="container">
            <div class="row mb-4" id="ShowMerchandise">
                <?php
                    $list_barang=$WebSummary['metadata']['list_barang'];
                    $jumlah_barang=count($list_barang);
                    if(!empty($jumlah_barang)){
                        foreach($list_barang as $list_barang_arry){
                            $id_barang=$list_barang_arry['id_barang'];
                            $nama_barang=$list_barang_arry['nama_barang'];
                            $harga=$list_barang_arry['harga'];
                            $image=$list_barang_arry['image'];
                            //Mengubah Gambar
                            $new_width=500;
                            $new_height=500;
                            $ImageBase64=resizeImage($image, $new_width, $new_height);
                            //Format Rupiah
                            $harga_format='Rp ' . number_format($harga, 0, ',', '.');
                ?>
                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 d-flex align-items-stretch mb-4" data-aos="fade-up" data-aos-delay="100">
                                <a href="index.php?Page=DetailMerch&id=<?php echo $id_barang; ?>" class="team-member">
                                    <div class="member-img">
                                        <img src="<?php echo "data:image/jpeg;base64,$ImageBase64"; ?>" class="img-fluid" alt="">
                                    </div>
                                    <div class="member-info">
                                        <h4><?php echo $harga_format; ?></h4>
                                        <span><?php echo $nama_barang; ?></span>
                                    </div>
                                </a>
                            </div>
                <?php 
                        }
                    }
                ?>
            </div>
        </div>
        <div class="container">
            <div class="row mb-4 mt-4">
                <div class="col-md-12 text-center">
                    <a href="index.php?Page=Merch" class="button_more">
                        Lihat Selengkapnya
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- List Member Baru -->
    <section id="member-baru" class="member-baru section event-background">
        <div class="container section-title" data-aos="fade-up">
            <h2>Baru Bergabung</h2>
        </div>
        <div class="container">
            <div class="row" id="ShowMemberList">
                <?php
                    $list_member_arry=$WebSummary['metadata']['list_member'];
                    $jumlah_list_member=count($list_member_arry);
                    if(!empty($jumlah_list_member)){
                        foreach($list_member_arry as $list_member){
                            $nama=$list_member['nama'];
                            $foto=$list_member['foto'];
                            $datetime=$list_member['datetime'];
                            //Format Tanggal Daftar
                            $strtotime=strtotime($datetime);
                            $tanggal_daftar=date('d/m/Y H:i', $strtotime);
                            //Format Foto
                            if(empty($foto)){
                                $foto_path="assets/img/No-Image.png";
                            }else{
                                $foto_path=$foto;
                            }
                ?>
                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <a href="<?php echo "$foto_path"; ?>" title="<?php echo $nama; ?><br><code><?php echo $tanggal_daftar; ?></code>" data-gallery="portfolio-gallery-branding" class="glightbox">
                                    <div class="card mb-3 card-member" id="">
                                        <div class="card-body" >
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <img src="<?php echo "$foto_path"; ?>" class="image_member" width="100px" height="100px">
                                                </div>
                                                <div class="col-md-12 text-center">
                                                    <small class="text text-light"><?php echo $nama; ?></small><br>
                                                    <small class="mobile-text text-light">
                                                        <code><?php echo $tanggal_daftar; ?></code>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                <?php 
                        }
                    }
                ?>
            </div>
        </div>
    </section>
    <!-- Konten Vidio -->
    <section id="vidio" class="team section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Konten Vidio</h2>
        </div>
        <div class="container">
            <div class="row mb-4" id="ShowVidio">
                <?php
                    $list_vidio_arry=$WebSummary['metadata']['list_vidio'];
                    $jumlah_list_vidio=count($list_vidio_arry);
                    if(!empty($jumlah_list_vidio)){
                        foreach($list_vidio_arry as $list_vidio){
                            $id_web_vidio=$list_vidio['id_web_vidio'];
                            $sumber_vidio=$list_vidio['sumber_vidio'];
                            $title_vidio=$list_vidio['title_vidio'];
                            $thumbnail=$list_vidio['thumbnail'];
                            //Format Datetime
                            $datetime_format=date('d/m/Y', strtotime($datetime));
                ?>
                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 d-flex align-items-stretch mb-4" data-aos="fade-up" data-aos-delay="100">
                                <a href="javascript:void(0);" class="team-member" data-bs-toggle="modal" data-bs-target="#ModalDetailVidio" data-id="<?php echo $id_web_vidio; ?>">
                                    <div class="member-img">
                                        <img src="<?php echo "$thumbnail"; ?>" class="img-fluid" alt="">
                                    </div>
                                    <div class="member-info">
                                        <?php echo $title_vidio; ?>
                                        <span><?php echo $datetime_format; ?></span>
                                    </div>
                                </a>
                            </div>
                <?php
                        }
                    }
                ?>
            </div>
        </div>
        <div class="container">
            <div class="row mb-4 mt-4">
                <div class="col-md-12 text-center">
                    <a href="index.php?Page=Vidio" class="button_more">
                        Lihat Selengkapnya
                    </a>
                </div>
            </div>
        </div>
    </section>
<?php } ?>