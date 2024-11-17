<!-- HERO -->
<section id="hero" class="hero section dark-background">
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
        <?php
            if(!empty($_SESSION['id_member_login'])){
                echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">';
                echo '  <b>Selamat Datang</b> <i>'.$_SESSION['email'].'</i><br>';
                echo '  Pada saat ini anda sudah login. Lihat halaman <a href="index.php?Page=Profil">profil</a> untuk melihat detail lengkap akun anda.';
                echo '</div>';
            }
        ?>
        <h2>Tentang Kami</h2>
        <p><?php echo "$tentang_judul"; ?></p>
    </div><!-- End Section Title -->
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-12 content" data-aos="fade-up" data-aos-delay="100">
                <small><?php echo "$tentang_preview"; ?></small>
            </div>
        </div>
        <div class="row mb-3 mt-3">
            <div class="col-md-12 text-center">
                <?php
                    if(empty($_SESSION['id_member_login'])){
                        echo '<a href="index.php?Page=Pendaftaran" class="button_more">';
                        echo '  Daftar Menjadi Member Sekarang';
                        echo '</a>';
                    }
                ?>
            </div>
        </div>
    </div>
</section>

<!-- KONTAK -->
<section id="call-to-action" class="call-to-action section dark-background">
    <div class="container">
        <div class="row mb-3" data-aos="zoom-in" data-aos-delay="100">
            <div class="col-md-4 mb-3 text-center">
                <h2>Kontak Kami</h2>
                <div class="row mb-3 mt-3" data-aos="zoom-in" data-aos-delay="100">
                    <div class="col-md-12 text-center"><b><small>Alamat</small></b></div>
                    <div class="col-md-12 text-center"><small><?php echo "$kontak_alamat"; ?></small></div>
                </div>
                <div class="row mb-3" data-aos="zoom-in" data-aos-delay="100">
                    <div class="col-md-12 text-center"><b><small>Email</small></b></div>
                    <div class="col-md-12 text-center"><small><?php echo "$kontak_email"; ?></small></div>
                </div>
                <div class="row mb-3" data-aos="zoom-in" data-aos-delay="100">
                    <div class="col-md-12 text-center"><b><small>Kontak </small></b></div>
                    <div class="col-md-12 text-center"><small><?php echo "$kontak_telepon"; ?></small></div>
                </div>
            </div>
            <div class="col-md-8 text-center mb-3">
                <h2 class="mb-3">Media Sosial</h2>
                <div class="row mt-3">
                    <div class="col-md-12 text-center">
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
<section id="testimonials" class="testimonials section dark-background">
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
                    <div class="accordion-item">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-1">
                                Apa itu Kuningan Runners?
                            </button>
                        </h2>
                        <div id="collapse-faq-1" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-faq">
                            <div class="accordion-body">
                                Kuningan Runners adalah komunitas lari yang berbasis di Kabupaten Kuningan, Jawa Barat. 
                                Kami mengadakan kegiatan lari rutin serta berbagai acara olahraga untuk meningkatkan kebugaran dan 
                                mempererat persaudaraan antaranggota.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-2">
                                Siapa saja yang bisa bergabung dengan Kuningan Runners?
                            </button>
                        </h2>
                        <div id="collapse-faq-2" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-faq">
                            <div class="accordion-body">
                                Siapa pun dapat bergabung, baik pelari pemula maupun profesional. 
                                Kami menyambut semua kalangan yang memiliki minat terhadap olahraga lari, 
                                tanpa memandang usia atau tingkat kemampuan.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-3">
                                Bagaimana cara bergabung dengan Kuningan Runners?
                            </button>
                        </h2>
                        <div id="collapse-faq-3" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-faq">
                            <div class="accordion-body">
                                Anda dapat bergabung dengan menghubungi admin melalui media sosial resmi Kuningan Runners 
                                atau datang langsung ke salah satu acara lari rutin kami. 
                                Informasi lebih lanjut tentang jadwal kegiatan dapat dilihat di platform kami.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-4">
                                Apakah ada biaya untuk bergabung dengan Kuningan Runners?
                            </button>
                        </h2>
                        <div id="collapse-faq-4" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-faq">
                            <div class="accordion-body">
                                Tidak ada biaya pendaftaran untuk bergabung dengan Kuningan Runners. 
                                Kami adalah komunitas yang terbuka untuk semua orang. 
                                Namun, jika ada acara khusus atau perlombaan, mungkin akan ada biaya partisipasi sesuai dengan kebutuhan acara.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-5">
                                Kapan dan di mana jadwal lari rutin Kuningan Runners?
                            </button>
                        </h2>
                        <div id="collapse-faq-5" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-faq">
                            <div class="accordion-body">
                                Kuningan Runners mengadakan lari rutin setiap akhir pekan, 
                                biasanya di beberapa lokasi ikonik di Kuningan seperti Stadion Mashud Wisnusaputra atau Taman Kota. 
                                Jadwal dan lokasi dapat bervariasi, jadi selalu pantau media sosial kami untuk update terbaru.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-6">
                                Apakah Kuningan Runners mengadakan acara selain lari rutin?
                            </button>
                        </h2>
                        <div id="collapse-faq-6" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-faq">
                            <div class="accordion-body">
                                Ya, selain lari rutin, kami juga mengadakan berbagai acara seperti lomba lari, 
                                fun run, serta kegiatan sosial seperti donor darah dan kampanye kesehatan. 
                                Kami juga mendukung partisipasi anggota dalam berbagai event lari tingkat regional dan nasional.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-7">
                                Apakah saya harus memiliki pengalaman lari sebelum bergabung?
                            </button>
                        </h2>
                        <div id="collapse-faq-7" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-faq">
                            <div class="accordion-body">
                                Tidak perlu! Kuningan Runners terbuka untuk semua level kemampuan, 
                                dari pemula yang baru mulai berlari hingga pelari berpengalaman. 
                                Kami bahkan menyediakan program latihan khusus untuk membantu pelari pemula membangun stamina dan 
                                keterampilan lari.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-8">
                                Bagaimana saya bisa mendapatkan informasi terbaru tentang Kuningan Runners?
                            </button>
                        </h2>
                        <div id="collapse-faq-8" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-faq">
                            <div class="accordion-body">
                                Anda bisa mengikuti kami di media sosial seperti Instagram dan Facebook, di mana kami rutin 
                                membagikan update tentang jadwal kegiatan, tips lari, dan informasi acara. 
                                Anda juga bisa bergabung dengan grup WhatsApp atau Telegram kami untuk komunikasi langsung dengan 
                                anggota lainnya.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-9">
                                Apakah Kuningan Runners mendukung pelari dalam mengikuti lomba lari?
                            </button>
                        </h2>
                        <div id="collapse-faq-9" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-faq">
                            <div class="accordion-body">
                                Tentu saja! Kuningan Runners selalu mendukung anggotanya untuk mengikuti berbagai perlombaan, 
                                baik di dalam maupun luar daerah. 
                                Kami sering mendaftarkan tim komunitas untuk ikut serta dalam event lari resmi dan membantu 
                                anggota yang ingin berkompetisi.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-10">
                                Bagaimana cara mendapatkan jersey atau merchandise resmi Kuningan Runners?
                            </button>
                        </h2>
                        <div id="collapse-faq-10" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-faq">
                            <div class="accordion-body">
                                Kami secara berkala membuka pre-order untuk jersey dan merchandise resmi Kuningan Runners. 
                                Informasi tentang ketersediaan dan cara pemesanan tersedia pada halaman web ini.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- KONTAK -->
    <section id="Event-Runner" class="Event-Runner section dark-background">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Event Runner's</h2>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<section id="product" class="team section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Merchandise</h2>
        <p>Produk Resmi Kami</p>
    </div>
    <div class="container">
        <div class="row gy-4 mb-4">
            <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                <div class="team-member">
                    <div class="member-img">
                        <img src="assets/img/Product/1.jpg" class="img-fluid" alt="">
                        <div class="social">
                            <!-- <a href="https://wa.me/6285161209131?text=Hai%20Kak%20saya%20ingin%20pesan%20JERSEY%20ini">
                                <i class="bi bi-whatsapp"></i>
                            </a> -->
                        </div>
                    </div>
                    <div class="member-info">
                        <h4>IDR 125.000</h4>
                        <span>The 4th Anniversary</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                <div class="team-member">
                    <div class="member-img">
                        <img src="assets/img/Product/2.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="member-info">
                        <h4>IDR 210.000</h4>
                        <span>JERSEY KATILU KNGR</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                <div class="team-member">
                    <div class="member-img">
                        <img src="assets/img/Product/3.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="member-info">
                        <h4>IDR 220.000</h4>
                        <span>JERSEY KAOPAT KNGR</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                <div class="team-member">
                    <div class="member-img">
                        <img src="assets/img/Product/4.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="member-info">
                        <h4>IDR 125.000</h4>
                        <span>The Challenger</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-4">
            <div class="col-md-12">
                <h4>
                    <b>Cara Pemesanan</b>
                </h4>
                <ol>
                    <li class="mb-3">
                        <strong>Buka Akun Instagram</strong><br>
                        Buka aplikasi Instagram di ponsel Anda atau kunjungi situs web Instagram melalui browser.
                    </li>
                    <li class="mb-3">
                        <strong>Kunjungi Profil Kuningan Runners</strong><br>
                        Kunjungi akun resmi Kuningan Runners di <a href="https://www.instagram.com/kuningan_runners/" target="_blank">kuningan_runners</a>
                    </li>
                    <li class="mb-3">
                        <strong>Kirim Pesan Melalui Direct Message (DM)</strong><br>
                        Klik tombol <em>"Message"</em> atau <em>"Kirim Pesan"</em> di profil Kuningan Runners. Tulis pesan dengan format berikut:
                        <br>
                        <code>
                            Halo, saya ingin memesan merchandise Kuningan Runners. Berikut detailnya:<br>
                            Nama: [Nama Anda]<br>
                            Barang yang dipesan: [Nama merchandise]<br>
                            Jumlah: [Jumlah barang]<br>
                            Ukuran (jika ada): [Ukuran yang diinginkan]<br>
                            Alamat pengiriman: [Alamat lengkap]<br>
                            Kontak: [Nomor telepon yang bisa dihubungi]<br>
                            Terima kasih!
                        </code>
                    </li>
                    <li class="mb-3">
                        <strong>Tunggu Konfirmasi</strong><br>
                        Setelah mengirim pesan, tim Kuningan Runners akan menghubungi Anda kembali untuk mengonfirmasi pesanan, total harga, dan detail pengiriman.
                    </li>
                    <li class="mb-3">
                        <strong>Lakukan Pembayaran</strong><br>
                        Setelah mendapatkan konfirmasi pesanan, lakukan pembayaran sesuai dengan instruksi yang diberikan. Kirim bukti pembayaran kembali melalui DM untuk verifikasi.
                    </li>
                    <li class="mb-3">
                        <strong>Pengiriman Pesanan</strong><br>
                        Pesanan Anda akan diproses setelah pembayaran terverifikasi. Tim Kuningan Runners akan memberikan nomor resi pengiriman untuk pelacakan barang.
                    </li>
                </ol>
            </div>
        </div>
    </div>
</section>