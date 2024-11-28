<?php
    if(empty($_GET['id'])){
        echo '<section class="section dashboard">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12">';
        echo '          <div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '              <small>';
        echo '                  <code class="text-dark">';
        echo '                      ID Member Tidak Boleh Kosong!';
        echo '                  </code>';
        echo '              </small>';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</section>';
    }else{
        $id_member=$_GET['id'];
        //Bersihkan Karakter
        $id_member=validateAndSanitizeInput($id_member);
        $id_member_validasi=GetDetailData($Conn,'member','id_member',$id_member,'id_member');
        //Apabila ID member Tidak Ditemukan Pada Database
        if(empty($id_member_validasi)){
            echo '<section class="section dashboard">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12">';
            echo '          <div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '              <small>';
            echo '                  <code class="text-dark">';
            echo '                      ID Member Tidak Valid Atau Tidak Ditemukan Pada Database!';
            echo '                  </code>';
            echo '              </small>';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</section>';
        }else{
            echo '<input type="hidden" id="GetIdMember" value="'.$id_member.'">';
?>
        <section class="section dashboard">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                        echo '  <small>';
                        echo '      <code class="text-dark">';
                        echo '          Berikut ini adalah halaman detail member yang berfungsi untuk mempermudah anda dalam mengelola informasi member lebih lanjut.';
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
                                <div class="col-md-8 mb-3">
                                    <b class="card-title">
                                        <i class="bi bi-info-circle"></i> Detail Member
                                    </b>
                                </div>
                                <div class="col col-md-2 mb-3">
                                    <a class="btn btn-md btn-outline-dark btn-rounded btn-block" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i> Option
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                        <li class="dropdown-header text-start">
                                            <h6>Option</h6>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailMember" data-id="<?php echo "$id_member"; ?>">
                                                <i class="bi bi-info-circle"></i> Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditMember" data-id="<?php echo "$id_member"; ?>">
                                                <i class="bi bi-pencil"></i> Ubah Identitias
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahPasswordMember" data-id="<?php echo "$id_member"; ?>">
                                                <i class="bi bi-key"></i> Ubah Password
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahFoto" data-id="<?php echo "$id_member"; ?>">
                                                <i class="bi bi-image"></i> Ubah Foto
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col col-md-2 mb-3">
                                    <a href="index.php?Page=Member" class="btn btn-md btn-dark btn-block btn-rounded">
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
                                        <div class="accordion-body">
                                            <div class="row mt-5">
                                                <div class="col-md-4 mb-3 mt-5 text-center" id="ShowFotoMember">
                                                    <!-- Disini Menampilkan Foto Member -->
                                                </div>
                                                <div class="col-md-8 mb-3 mt-5" id="ShowDetailMember">
                                                    <!-- Disini Menampilkan Detail Member -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                            2. Riwayat Pendaftaran Event
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class="row mt-3">
                                                <div class="col-md-12" id="ShowRiwayatEvent">
                                                    <!-- Menampilkan List Riwayat Event -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingTree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTree" aria-expanded="false" aria-controls="flush-collapseTree">
                                            3. Riwayat Pembelian
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTree" class="accordion-collapse collapse" aria-labelledby="flush-headingTree" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class="row mt-3">
                                                <div class="col-md-12" id="ShowRiwayatPembelian">
                                                    <!-- Menampilkan List Riwayat Pembelian -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingFour">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                            4. Riwayat Login
                                        </button>
                                    </h2>
                                    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class="row mt-3">
                                                <div class="col-md-12 mt-4 text-end">
                                                    <button type="button" class="btn btn-md btn-outline-dark btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalFilterRiwayatLogin">
                                                        <i class="bi bi-filter-circle"></i> Shorting
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12 mt-4" id="ShowGrafikRiwayatLogin">
                                                    <!-- Menampilkan List Riwayat Pembelian -->
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12 mt-4" id="ShowRiwayatLogin">
                                                    <!-- Menampilkan List Riwayat Pembelian -->
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
<?php 
        } 
    } 
?>