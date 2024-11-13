<!-- Page Title -->
<div class="sub-page-title dark-background">
    <div class="row">
        <div class="col-md-12 text-left" data-aos="fade-up" data-aos-delay="100"></div>
    </div>
</div>
<!-- End Page Title -->
<?php
    //Tangkap Parameter Dari URL
    if(!empty($_GET['id'])){
        $id_member=$_GET['id'];
    }else{
        $id_member="";
    }
    if(!empty($_GET['rest'])){
        $rest=$_GET['rest'];
    }else{
        $rest="";
    }
    if(!empty($_GET['kode'])){
        $kode=$_GET['kode'];
    }else{
        $kode="";
    }
?>
<!-- Service Details Section -->
<section id="service-details mt-5" class="service-details section">
    <div class="container">
        <form action="javascript:void(0);" id="ProsesUbahPassword">
            <input type="hidden" name="id_member" value="<?php echo $id_member; ?>">
            <input type="hidden" name="rest" value="<?php echo $rest; ?>">
            <input type="hidden" name="kode" value="<?php echo $kode; ?>">
            <div class="row gy-5">
                <div class="col-md-4"></div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-box">
                        <h4>Ubah Password</h4>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="password">Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        <small>
                                            <i class="bi bi-key"></i>
                                        </small>
                                    </span>
                                    <input type="password" class="form-control" name="password" id="password">
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        <small>
                                            <code class="text text-dark" id="password_length">0/20</code>
                                        </small>
                                    </span>
                                </div>
                                <small class="credit">
                                    <code class="text-dark">
                                        <label for="password">Password maksimal terdiri dari 6-20 karakter huruf dan angka</label>
                                    </code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="password">Password Baru</label>
                                <input type="password" class="form-control" name="ulangi_password" id="ulangi_password">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="tampilkan_password">
                                    <label class="form-check-label" for="tampilkan_password">
                                        Tampilkan Password
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12" id="NotifikasiUbahPassword">
                                
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <button type="submit" class="button_pendaftaran" id="ButtonUbahPassword">
                                    <i class="bi bi-save"></i> Simpan
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