<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'CJSNYMcGurSdRuHHuEC');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        $QryTentang = mysqli_query($Conn,"SELECT * FROM web_tentang WHERE id_web_tentang='1'")or die(mysqli_error($Conn));
        $DataTentang = mysqli_fetch_array($QryTentang);
        if(!empty($DataTentang['judul'])){
            $JudulTentang= $DataTentang['judul'];
            $TentangSafe= $DataTentang['tentang'];
        }else{
            $JudulTentang="";
            $TentangSafe="";
        }
        //Membuka Pengaturan Website
        $web_url=GetDetailData($Conn, 'web_setting', 'id_web_setting', '1', 'base_url');
        $web_pavicon=GetDetailData($Conn, 'web_setting', 'id_web_setting', '1', 'pavicon');
        $web_icon=GetDetailData($Conn, 'web_setting', 'id_web_setting', '1', 'icon');
        $web_title=GetDetailData($Conn, 'web_setting', 'id_web_setting', '1', 'title');
        $web_description=GetDetailData($Conn, 'web_setting', 'id_web_setting', '1', 'description');
        $web_keyword=GetDetailData($Conn, 'web_setting', 'id_web_setting', '1', 'keyword');
        $web_author=GetDetailData($Conn, 'web_setting', 'id_web_setting', '1', 'author');
        //panjang Karakter
        $web_base_url_length=strlen($web_url);
        $web_title_length=strlen($web_title);
        $web_description_length=strlen($web_description);
        $web_keyword_length=strlen($web_keyword);
        $web_author_length=strlen($web_author);
?>
        <section class="section dashboard">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                        echo '  <small>';
                        echo '      <code class="text-dark">';
                        echo '          Berikut ini adalah halaman pengelolaan konten statis pada website.';
                        echo '          Silahkan atur isi website pada halaman ini sesuai dengan keinginan anda.';
                        echo '          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '      </code>';
                        echo '  </small>';
                        echo '</div>';
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <b class="card-title">Konten Utama website</b>
                        </div>
                        <div class="card-body" >
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseZero" aria-expanded="false" aria-controls="flush-collapseZero">
                                            1. Pengaturan Website
                                        </button>
                                    </h2>
                                    <div id="flush-collapseZero" class="accordion-collapse collapse" aria-labelledby="flush-headingZero" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body mb-4">
                                            <div class="row mt-4 mb-3">
                                                <div class="col-md-12 mb-3">
                                                    <form action="javascript:void(0);" id="ProsesSimpanPengaturanWebsite">
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <small>
                                                                    <label for="web_base_url">Web URL</label>
                                                                </small>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <span class="input-group-text" id="inputGroupPrepend">
                                                                        <small>
                                                                            <code class="text text-dark" id="web_base_url_length"><?php echo $web_base_url_length; ?>/250</code>
                                                                        </small>
                                                                    </span>
                                                                    <input type="text" name="web_base_url" id="web_base_url" class="form-control" value="<?php echo "$web_url"; ?>" placeholder="https://">
                                                                </div>
                                                                <small>
                                                                    <code class="text text-grayish">Alamat URL/Link Website</code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <small>
                                                                    <label for="web_title">Judul / Title</label>
                                                                </small>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <span class="input-group-text" id="inputGroupPrepend">
                                                                        <small>
                                                                            <code class="text text-dark" id="web_title_length"><?php echo $web_title_length; ?>/50</code>
                                                                        </small>
                                                                    </span>
                                                                    <input type="text" name="web_title" id="web_title" class="form-control" value="<?php echo "$web_title"; ?>">
                                                                </div>
                                                                <small>
                                                                    <code class="text text-grayish">Judul halaman utama website</code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <small>
                                                                    <label for="web_description">Keterangan / Description</label>
                                                                </small>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <textarea name="web_description" id="web_description" class="form-control"><?php echo "$web_description"; ?></textarea>
                                                                <small>
                                                                    <code class="text text-dark" id="web_description_length"><?php echo "$web_description_length"; ?>/250</code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <small>
                                                                    <label for="web_keyword">Kata Kunci</label>
                                                                </small>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <span class="input-group-text" id="inputGroupPrepend">
                                                                        <small>
                                                                            <code class="text text-dark" id="web_keyword_length"><?php echo $web_keyword_length; ?>/100</code>
                                                                        </small>
                                                                    </span>
                                                                    <input type="text" name="web_keyword" id="web_keyword" class="form-control" value="<?php echo "$web_keyword"; ?>">
                                                                </div>
                                                                <small>
                                                                    <code class="text text-grayish">Contoh : Pusat Informasi, Ibu Kota</code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <small>
                                                                    <label for="web_author">Web Author</label>
                                                                </small>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <span class="input-group-text" id="inputGroupPrepend">
                                                                        <small>
                                                                            <code class="text text-dark" id="web_author_length"><?php echo $web_author_length; ?>/100</code>
                                                                        </small>
                                                                    </span>
                                                                    <input type="text" name="web_author" id="web_author" class="form-control" value="<?php echo "$web_author"; ?>">
                                                                </div>
                                                                
                                                                <small>
                                                                    <code class="text text-grayish">Nama pembuat/pengembang (Perusahaan)</code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <small>
                                                                    <label for="web_pavicon">Pavicon</label>
                                                                </small>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input type="file" name="web_pavicon" id="web_pavicon" class="form-control">
                                                                    <span class="input-group-text" id="inputGroupPrepend">
                                                                        <small>
                                                                            <a href="<?php echo "assets/img/Web/$web_pavicon"; ?>" target="_blank">
                                                                                <i class="bi bi-image"></i>
                                                                            </a>
                                                                        </small>
                                                                    </span>
                                                                </div>
                                                                <small>
                                                                    <code id="ValidasiWebPavicon"></code>
                                                                    <code class="text text-grayish">File maksimal 1 mb (PNG, JPG, JPEG, GIF)</code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <small>
                                                                    <label for="web_icon">Icon</label>
                                                                </small>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input type="file" name="web_icon" id="web_icon" class="form-control">
                                                                    <span class="input-group-text" id="inputGroupPrepend">
                                                                        <small>
                                                                            <a href="<?php echo "assets/img/Web/$web_icon"; ?>" target="_blank">
                                                                                <i class="bi bi-image"></i>
                                                                            </a>
                                                                        </small>
                                                                    </span>
                                                                </div>
                                                                <small>
                                                                    <code id="ValidasiWebIcon"></code>
                                                                    <code class="text text-grayish">File maksimal 1 mb (PNG, JPG, JPEG, GIF)</code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3"></div>
                                                            <div class="col-md-9">
                                                                <small class="text-dark">Pastikan pengaturan website yang anda masukan sudah sesuai</small>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3"></div>
                                                            <div class="col-md-9" id="NotifikasiSimpanPengaturanWebsite"></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-2 mb-3">
                                                                <button type="submit" class="btn btn-md btn-rounded btn-success btn-block" id="ButtonSimpanPengaturanWebsite">
                                                                    <i class="bi bi-save"></i> Simpan
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                            2. Tentang Kami
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body mb-4">
                                            <div class="row mt-4 mb-3">
                                                <div class="col-md-12 mb-3">
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <label for="judul">Judul</label>
                                                            <input type="text" name="judul" id="judul" class="form-control" value="<?php echo "$JudulTentang"; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <textarea name="tentang" id="tentang" cols="30" rows="3" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <span class="text-dark">Pastikan data yang anda input sudah sesuai</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-3"></div>
                                                        <div class="col-md-9" id="NotifikasiTentangKami"></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2 mb-3">
                                                            <button type="submit" class="btn btn-md btn-rounded btn-success btn-block" id="ClickSimpanTentangKami">
                                                                <i class="bi bi-save"></i> Simpan
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                            3. Frequently Asked Questions (FAQ)
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class="row mt-4 mb-3">
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-md btn-rounded btn-block btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahFaq">
                                                        <i class="bi bi-plus"></i> Tambah
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row mt-4 mb-3">
                                                <div class="col-md-12" id="ShowFaq">
                                                    <!-- Disini Menampilkan ShowFaq-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                            4. Media Sosial
                                        </button>
                                    </h2>
                                    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body mb-4">
                                            <div class="row mt-4 mb-3">
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-md btn-rounded btn-block btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahMedsos">
                                                        <i class="bi bi-plus"></i> Tambah
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row mt-4 mb-3">
                                                <div class="col-md-12" id="ShowMedsos">
                                                    <!-- Menampilkan ShowMedsos-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php } ?>