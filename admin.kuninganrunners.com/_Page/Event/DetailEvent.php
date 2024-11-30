<?php
    if(empty($_GET['id'])){
        echo '<section class="section dashboard">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12">';
        echo '          <div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '              <small>';
        echo '                  <code class="text-dark">';
        echo '                      ID Event Tidak Boleh Kosong!';
        echo '                  </code>';
        echo '              </small>';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</section>';
    }else{
        $id_event=$_GET['id'];
        $id_event=validateAndSanitizeInput($id_event);
        $id_event_validasi=GetDetailData($Conn,'event','id_event',$id_event,'id_event');
        //Apabila ID Event Tidak Ditemukan Pada Database
        if(empty($id_event_validasi)){
            echo '<section class="section dashboard">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12">';
            echo '          <div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '              <small>';
            echo '                  <code class="text-dark">';
            echo '                      ID Event Tidak Valid Atau Tidak Ditemukan Pada Database!';
            echo '                  </code>';
            echo '              </small>';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</section>';
        }else{
            echo '<input type="hidden" id="GetIdEvent" value="'.$id_event.'">';
?>
        <section class="section dashboard">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                        echo '  <small>';
                        echo '      <code class="text-dark">';
                        echo '          Berikut ini adalah halaman detail event yang berfungsi untuk mempermudah anda dalam mengelola informasi event, peserta dan status pendaftaran.';
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
                            <div class="row">
                                <div class="col-md-10 mb-3">
                                    <b class="card-title">
                                        <i class="bi bi-info-circle"></i> Detail Event
                                    </b>
                                </div>
                                <div class="col col-md-2 mb-3">
                                    <a href="index.php?Page=Event" class="btn btn-md btn-dark btn-block btn-rounded">
                                        <i class="bi bi-arrow-left-circle"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                                            1. Informasi Umum
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
                                        <div class="accordion-body mb-4">
                                            <div class="row mt-4 mb-3">
                                                <div class="col col-md-2 mb-3">
                                                    <a class="btn btn-md btn-outline-grayish btn-rounded btn-block" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i> Option
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                                        <li class="dropdown-header text-start">
                                                            <h6>Option</h6>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditEvent" data-id="<?php echo "$id_event"; ?>">
                                                                <i class="bi bi-pencil"></i> Edit Event
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahPoster" data-id="<?php echo "$id_event"; ?>">
                                                                <i class="bi bi-image"></i> Ubah Poster (Image)
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-10"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3" id="ShowDetailEvent">
                                                    <!-- Disini Menampilkan Detail Event -->
                                                </div>
                                                <div class="col-md-6 mb-3 text-center" id="ShowPosterEvent">
                                                    <!-- Disini Menampilkan Poster Event -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                            2. Rute Event
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class="row mt-4 mb-3">
                                                <div class="col col-md-2 mb-3">
                                                    <a class="btn btn-md btn-outline-grayish btn-rounded btn-block" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalGantiRute" data-id="<?php echo "$id_event"; ?>">
                                                        <i class="bi bi-pin-map"></i> Ubah Rute
                                                    </a>
                                                </div>
                                                <div class="col col-md-2 mb-3">
                                                    <a href="<?php echo "$base_url/MapRute.php?id=$id_event"; ?>" class="btn btn-md btn-outline-primary btn-rounded btn-block">
                                                        <i class="bi bi-fullscreen"></i> Layar Penuh
                                                    </a>
                                                </div>
                                                <div class="col-md-10"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 text-center" id="ShowRuteEvent">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                            3. Kategori Event
                                        </button>
                                    </h2>
                                    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body mb-4">
                                            <div class="row mt-4 mb-3">
                                                <div class="col col-md-2">
                                                    <button type="button" class="btn btn-md btn-outline-primary btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalTambahKategori" data-id="<?php echo "$id_event"; ?>">
                                                        <i class="bi bi-plus"></i> Kategori
                                                    </button>
                                                </div>
                                                <div class="col-md-10"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" id="ShowKategoriEvent">
                                                    <!-- Menampilkan Kategori Event -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingFive">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                                            4. Assesment Form
                                        </button>
                                    </h2>
                                    <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body mb-4">
                                            <div class="row mt-4 mb-3">
                                                <div class="col col-md-2">
                                                    <button type="button" class="btn btn-md btn-outline-primary btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalTambahAssesmentForm" data-id="<?php echo "$id_event"; ?>">
                                                        <i class="bi bi-plus"></i> Assesment Form
                                                    </button>
                                                </div>
                                                <div class="col-md-10"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" id="ShowAseesmentFormEvent">
                                                    <!-- Menampilkan Aseesment Form Event -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingFour">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                            5. Daftar Peserta
                                        </button>
                                    </h2>
                                    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body mb-3">
                                            <div class="row mt-4 mb-3">
                                                <div class="col col-md-2">
                                                    <button type="button" class="btn btn-md btn-outline-dark btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalFilterPeserta">
                                                        <i class="bi bi-filter"></i> Filter
                                                    </button>
                                                </div>
                                                <div class="col col-md-2">
                                                    <button type="button" class="btn btn-md btn-outline-primary btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalTambahPeserta" data-id="<?php echo "$id_event"; ?>">
                                                        <i class="bi bi-plus"></i> Peserta
                                                    </button>
                                                </div>
                                                <div class="col-md-8"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" id="ShowPesertaEvent">
                                                    <!-- Menampilkan data peserta -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingSix">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                                            6. Sertifikat
                                        </button>
                                    </h2>
                                    <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body mb-3">
                                            <form action="javascript:void(0);" id="ProsesUbahSertifikat">
                                                <div class="row mt-4">
                                                    <div class="col-md-12" id="ShowDataSertifikat">
                                                        <!-- Menampilkan data pembuatan sertifikat -->
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-md-12" id="NotifikasiUbahSertifikat">
                                                        <!-- Notifikasi Ubah Sertifikat -->
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mb-3 text-center">
                                                        <button type="submit" class="btn btn-md btn-outline-success btn-rounded mb-2" id="ButtonUbahSertifikat">
                                                            <i class="bi bi-save"></i> Simpan Pengaturan
                                                        </button>
                                                        <a href="javascript:void(0);" class="btn btn-md btn-outline-dark btn-rounded mb-2" data-bs-toggle="modal" data-bs-target="#ModalPreviewSertifikat" data-id="<?php echo "$id_event"; ?>">
                                                            <i class="bi bi-eye-fill"></i> Lihat Hasilnya
                                                        </a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php 
        } 
    } 
?>