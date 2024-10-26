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
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                            1. Tentang Kami
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
                                            2. Frequently Asked Questions (FAQ)
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
                                            3. Media Sosial
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