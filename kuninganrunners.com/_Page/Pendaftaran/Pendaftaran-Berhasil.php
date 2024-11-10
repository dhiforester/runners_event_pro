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
        <form action="javascript:void(0);" id="ProsesVerifikasiAkun">
            <div class="row gy-5">
                <div class="col-md-4"></div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-box">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4 class="text-success">
                                    <i class="bi bi-check-circle"></i> Pendaftaran Berhasil
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                    <small>
                                        Kami telah mengirimkan tautan kode verifikasi akun melalui email.
                                        Silahkan cek pada inbox atau kotak spam dan gunakan tautan tersebut untuk melanjutkan proses pendafataran.
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="email">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        <small>@</small>
                                    </span>
                                    <input type="text" class="form-control" name="email" id="email" value="<?php echo $email; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="kode">Kode Verifikasi</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        <small>
                                            <i class="bi bi-key"></i>
                                        </small>
                                    </span>
                                    <input type="text" class="form-control" name="kode" id="kode">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12" id="NotifikasiVerifikasiAkun">
                                <!-- Notifikasi Verifikasi Akun Akan Muncul Disini -->
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <button type="submit" class="button_pendaftaran" id="ButtonVerifikasiAkun">
                                    <i class="bi bi-check-circle"></i> Konfirmasi Kode
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </form>
    </div>
</section>
