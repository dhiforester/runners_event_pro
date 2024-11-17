<!-- About Section -->
<section id="about" class="about section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Tentang Kami</h2>
        <p><?php echo "$tentang_judul"; ?></p>
    </div><!-- End Section Title -->
    <div class="container">
        <div class="row gy-4 mb-3">
            <div class="col-lg-12 content" data-aos="fade-up" data-aos-delay="100">
                <small><?php echo "$tentang_preview"; ?></small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-center">
                <?php
                    if(empty($_SESSION['id_member_login'])){
                        echo '<a href="" class="button_pendaftaran">';
                        echo '  Daftar Sekarang';
                        echo '</a>';
                    }
                ?>
            </div>
        </div>
    </div>
</section>