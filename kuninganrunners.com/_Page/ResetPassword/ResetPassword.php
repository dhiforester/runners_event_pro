<!-- Page Title -->
<div class="sub-page-title dark-background">
    <div class="row">
        <div class="col-md-12 text-left" data-aos="fade-up" data-aos-delay="100"></div>
    </div>
</div>
<!-- End Page Title -->
<!-- Service Details Section -->
<section id="service-details mt-5" class="service-details section">
    <div class="container">
        <form action="javascript:void(0);" id="ProsesResetPassword">
            <div class="row gy-5">
                <div class="col-md-4"></div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-box">
                        <h4>Reset Password</h4>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="email_login">Alamat Email</label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <small>
                                    Kami akan mengirimkan tautan pada email anda untuk mulai mengubah password.
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <img src="_Page/Pendaftaran/Captcha.php" alt="" width="100%">
                                <a href="javascript:void(0);" id="ReloadCaptcha">
                                    <small>
                                        <i class="bi bi-arrow-clockwise"></i> Reload Captcha
                                    </small>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="captcha">Masukan Kode Captcha</label>
                                <input type="text" class="form-control" name="captcha" id="captcha">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12" id="NotifikasiResetPassword">
                                
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <button type="submit" class="button_pendaftaran" id="ButtonResetPassword">
                                    <i class="bi bi-send"></i> Kirim Permintaan
                                </button>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <a href="index.php?Page=Login" class="button_back_to_login">
                                    <i class="bi bi-chevron-left"></i> Ke Halaman Login
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </form>
    </div>
</section>