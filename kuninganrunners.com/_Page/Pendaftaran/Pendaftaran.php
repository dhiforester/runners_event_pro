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
        <form action="javascript:void(0);" id="ProsesPendaftaran">
            <div class="row gy-5">
                <div class="col-md-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-box">
                        <h4>Form Pendaftaran</h4>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="nama">Nama Lengkap</label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        <small>
                                            <i class="bi bi-person"></i>
                                        </small>
                                    </span>
                                    <input type="text" class="form-control" name="nama" id="nama">
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        <small>
                                            <code class="text text-dark" id="nama_length">0/100</code>
                                        </small>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="kontak">Kontak (HP)</label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        <small>
                                            <i class="bi bi-phone"></i>
                                        </small>
                                    </span>
                                    <input type="text" class="form-control" name="kontak" id="kontak" placeholder="62">
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        <small>
                                            <code class="text text-dark" id="kontak_length">0/20</code>
                                        </small>
                                    </span>
                                </div>
                                <small>
                                    <code class="text-dark">
                                        <label for="kontak">Nomor HP/WA yang bisa dihubungi</label>
                                    </code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="provinsi">Provinsi</label>
                            </div>
                            <div class="col-md-8">
                                <select name="provinsi" id="provinsi" class="form-control">
                                    <option value="">Pilih</option>
                                    <?php
                                        $ListProvinsi=ListProvinsi($url_server,$xtoken);
                                        $array_provinsi= json_decode($ListProvinsi, true);
                                        if($array_provinsi['response']['code']==200) {
                                            if(!empty($array_provinsi['metadata'])){
                                                $provinsi = $array_provinsi['metadata'];
                                                foreach($provinsi as $list_provinsi){
                                                    $id_propinsi=$list_provinsi['id_propinsi'];
                                                    $propinsi=$list_provinsi['propinsi'];
                                                    echo '<option value="'.$id_propinsi.'">'.$propinsi.'</option>';
                                                }
                                            }
                                        }
                                    ?>
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
                                <label for="rt_rw">Alamat</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="rt_rw" id="rt_rw" class="form-control">
                                <small>
                                    <code class="text text-grayish">
                                        Nomor Rumah, Jalan/Gang, RT/RW
                                    </code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="kode_pos">Kode Pos</label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        <small>
                                            <i class="bi bi-postcard"></i>
                                        </small>
                                    </span>
                                    <input type="text" name="kode_pos" id="kode_pos" class="form-control" placeholder="45514">
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        <small>
                                            <code class="text text-dark" id="kode_pos_length">0/10</code>
                                        </small>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="email">Alamat Email</label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        <small>
                                            <i class="bi bi-envelope"></i>
                                        </small>
                                    </span>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="email@domain.com">
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        <small>
                                            <code class="text text-dark" id="email_length">0/100</code>
                                        </small>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="password">Password</label>
                            </div>
                            <div class="col-md-8">
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
                                    <input class="form-check-input" type="checkbox" name="konfirmasi_pendaftaran" id="konfirmasi_pendaftaran"  value="Ya">
                                    <label class="form-check-label" for="konfirmasi_pendaftaran">
                                        <small>
                                            Saya setuju dan telah membaca berbagai ketentuan dan peraturan yang telah ditetapkan pada 
                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalPrivacyPolicy">Privacy Policy</a> 
                                            dan 
                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalTermOfService">Term Of Condition</a>.
                                        </small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12" id="NotifikasiPendaftaran">
                                <!-- Notifikasi Error Pada Saat Pendaftaran Akan Muncul Disini -->
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 mb-4">
                                <button type="submit" class="button_pendaftaran" id="ButtonPendaftaran">
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
        </form>
    </div>
</section>
