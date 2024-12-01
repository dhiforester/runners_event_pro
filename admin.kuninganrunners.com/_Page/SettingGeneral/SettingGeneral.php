<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'qLECdqLVgBMjV0BXHUC');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small class="mobile-text">';
                    echo '      Berikut ini adalah halaman pengaturan umum aplikasi.';
                    echo '      Pada halaman ini anda bisa mengatur properti aplikasi sesuai yang anda inginkan dari mulai judul, deskripsi, informasi kontak dan logo.';
                    echo '      Periksa kembali pengaturan yang anda gunakan agar aplikasi berjalan dengan baik.';
                    echo '      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '  </small>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form action="javascript:void(0);" id="ProsesSettingGeneral">
                    <div class="card">
                        <div class="card-header">
                            <b class="card-title">Form Pengaturan Umum</b>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="title_page">Judul Halaman</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <code class="text text-dark" id="title_page_length">0/20</code>
                                            </small>
                                        </span>
                                        <input type="text" name="title_page" id="title_page" class="form-control" value="<?php echo "$title_page"; ?>">
                                    </div>
                                    <small>
                                        <code class="text text-grayish">Menunjukan nama aplikasi, perusahaan atau lembaga.</code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="kata_kunci">Kata Kunci</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <code class="text text-dark" id="keyword_length">0/100</code>
                                            </small>
                                        </span>
                                        <input type="text" name="kata_kunci" id="kata_kunci" class="form-control" value="<?php echo "$kata_kunci"; ?>">
                                    </div>
                                    <small>
                                        <code class="text text-grayish">(Contoh: keyword1, keyword2, keyword3)</code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="deskripsi">Deskripsi</label>
                                </div>
                                <div class="col-md-9">
                                    <textarea name="deskripsi" id="deskripsi" cols="30" rows="3" class="form-control"><?php echo "$deskripsi"; ?></textarea>
                                    <small>
                                        <code class="text text-grayish">Menjelaskan gambaran umum aplikasi</code>
                                        <code class="text text-dark" id="description_length">(0/500)</code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="email">Email</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email" name="email_bisnis" id="email_bisnis" class="form-control" placeholder="email@domain.com" value="<?php echo "$email_bisnis"; ?>">
                                    </div>
                                    <small>
                                        <code class="text text-grayish">Email resmi yang dapat dihubungi</code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="telepon_bisnis">Kontak</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <code class="text text-dark" id="contact_length">0/20</code>
                                            </small>
                                        </span>
                                        <input type="text" name="telepon_bisnis" id="telepon_bisnis" class="form-control" placeholder="+62" value="<?php echo "$telepon_bisnis"; ?>">
                                    </div>
                                    <small>
                                        <code class="text text-grayish">Nomor kontak/telepon administrator pengelola aplikasi</code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="alamat_bisnis">Alamat</label>
                                </div>
                                <div class="col-md-9">
                                    <textarea name="alamat_bisnis" id="alamat_bisnis" cols="30" rows="3" class="form-control"><?php echo "$alamat_bisnis"; ?></textarea>
                                    <small>
                                        <code class="text text-grayish">Alamat kantor/operasional</code>
                                        <code class="text text-dark" id="alamat_length">(0/500)</code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="favicon">File Favicon</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="file" name="favicon" id="favicon" class="form-control">
                                        <?php
                                            if(!empty($favicon)){
                                                echo '<span class="input-group-text" id="inputGroupPrepend">';
                                                echo '<a href="assets/img/'.$favicon.'" target="_blank"><i class="bi bi-image"></i></a>';
                                                echo '</span>';
                                            }
                                        ?>
                                    </div>
                                    <small>
                                        <code class="text text-grayish" id="favicon-error">Maksimal Ukuran File 2 Mb (Format: JPG, JPEG, PNG and GIF)</code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="logo">Logo Image</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="file" name="logo" id="logo" class="form-control">
                                        <?php
                                            if(!empty($logo)){
                                                echo '<span class="input-group-text" id="inputGroupPrepend">';
                                                echo '<a href="assets/img/'.$logo.'" target="_blank"><i class="bi bi-image"></i></a>';
                                                echo '</span>';
                                            }
                                        ?>
                                    </div>
                                    <small>
                                        <code class="text text-grayish" id="logo-error">Maksimal Ukuran File 2 Mb (Format: JPG, JPEG, PNG and GIF)</code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="base_url">Base URL</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <i class="bi bi-globe"></i>
                                        </span>
                                        <input type="url" name="base_url" id="base_url" class="form-control" placeholder="https://" value="<?php echo "$base_url"; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-9 text-right">
                                    <small class="text-dark">Pastikan pengaturan yang anda gunakan sudah sesuai.</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-md btn-primary btn-rounded" id="NotifikasiSimpanSettingGeneral">
                                <i class="bi bi-save"></i> Simpan Pengaturan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
<?php } ?>