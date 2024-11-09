<!-- Page Title -->
<div class="page-title dark-background">
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
            <div class="col-md-8" data-aos="fade-up" data-aos-delay="100">
                <div class="service-box">
                    <h4>Form Pendaftaran</h4>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nama">Nama Lengkap</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nama" id="nama">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kontak">Kontak (HP)</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="kontak" id="kontak" placeholder="62">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="provinsi">Provinsi</label>
                        </div>
                        <div class="col-md-8">
                            <select name="provinsi" id="provinsi" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kabupaten">Kabupaten/Kota</label>
                        </div>
                        <div class="col-md-8">
                            <select name="kabupaten" id="kabupaten" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kecamatan">Kecamatan</label>
                        </div>
                        <div class="col-md-8">
                            <select name="kecamatan" id="kecamatan" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="desa">Desa/Kelurahan</label>
                        </div>
                        <div class="col-md-8">
                            <select name="desa" id="desa" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="rt_rw">RT/RW/Gang</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="rt_rw" id="rt_rw" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kode_pos">Kode Pos</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="kode_pos" id="kode_pos" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="email">Alamat Email</label>
                        </div>
                        <div class="col-md-8">
                            <input type="email" class="form-control" name="email" id="email" placeholder="alamat-email@domain.com">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="password">Password</label>
                        </div>
                        <div class="col-md-8">
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="ulangi_password">Ulangi Password</label>
                        </div>
                        <div class="col-md-8">
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
                        <div class="col-md-12">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="service-box">
                    <h4>Konfirmasi Pendaftaran</h4>
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
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="konfirmasi_pendaftaran">
                                <label class="form-check-label" for="konfirmasi_pendaftaran">
                                    <small>
                                        Saya setuju dan telah membaca berbagai ketentuan dan peraturan yang telah ditetapkan pada 
                                        <a href="">Privacy Policy</a> dan <a href="">Term Of Condition</a>.
                                    </small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-4">
                            <button type="submit" class="button_pendaftaran">
                                <i class="bi bi-send"></i> Kirim Pendaftaran
                            </button>
                        </div>
                        <div class="col-md-12">
                            <a href="index.php?Page=Login" class="button_back_to_login">
                                <i class="bi bi-lock"></i> Halaman Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
   
</script>