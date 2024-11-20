<!-- HERO -->
<section id="hero" class="hero section hero-background">
    <div id="hero-carousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">
        <!-- Konten Hero Akan Ditampilkan Disini -->
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
        <div class="row mb-3">
            <div class="col-md-4 mb-3 text-center">
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
            <div class="col-md-8 text-center mb-3">
                <h2 class="mb-3">Media Sosial</h2>
                <div class="row mt-3">
                    <div class="col-md-12 text-center" data-aos="zoom-in" data-aos-delay="130">
                        <?php
                            $DataMedsos=WebMediaSosial($url_server,$xtoken);
                            $medsos_arry=json_decode($DataMedsos,true);
                            if($medsos_arry['response']['code']!==200){
                                echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">';
                                echo '  <small>'.$medsos_arry['response']['message'].'</small>';
                                echo '</div>';
                            }else{
                                foreach($medsos_arry['metadata'] as $medsos_list) {
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
        <!-- Album Akan Ditampilkan Dihalaman ini -->
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
                <!-- Show Testimonial Disini -->
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <a href="" class="button_more">
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
                <!-- Menampilkan Data All Event -->
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
            <!-- List March Akan Ditampilkan Disini -->
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
        <h2>Member Baru</h2>
    </div>
    <div class="container">
        <div class="row" id="ShowMemberList">
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
            <!-- List March Akan Ditampilkan Disini -->
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