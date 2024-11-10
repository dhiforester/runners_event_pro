<?php
    //Menangkap Email
    if(!empty($_GET['email'])){
        $email=$_GET['email'];
    }else{
        $email="";
    }
?>
<!-- Page Title -->
<div class="sub-page-title dark-background">
    <!-- <div class="row">
        <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">
            <img src="assets/img/login.png" alt="" width="100%">
        </div>
    </div> -->
</div>
<!-- End Page Title -->
<!-- Service Details Section -->
<section id="service-details mt-5" class="service-details section">
    <div class="container">
        <div class="row gy-5">
            <div class="col-md-4"></div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="service-box">
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <h4 class="text-success">
                                <i class="bi bi-check-circle"></i> Verifikasi Selesai
                            </h4>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <img src="assets/img/pendaftaran-selesai.png" alt="" width="100%">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                <small>
                                    Anda berhasil melakukan verifikasi akun.
                                    Silahkan login menggunakan email dan password yang anda miliki.
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <a href="index.php?Page=Login" class="button_back_to_login">
                                <i class="bi bi-lock"></i> Kembali Ke Halaman Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</section>
