<?php
    //Buka Detail Member
    $email_member=$_SESSION['email'];
    $id_member_login=$_SESSION['id_member_login'];
    $DetailProfilMember=DetailProfilMember($url_server,$xtoken,$email_member,$id_member_login);
    $response=json_decode($DetailProfilMember,true);
    if($response['response']['code']!==200){
        echo '<section id="service-details mt-5" class="service-details section">';
        echo '  <div class="container">';
        echo '      <div class="row gy-5">';
        echo '          <div class="col-md-4"></div>';
        echo '              <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">';
        echo '                  <div class="service-box">';
        echo '                      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '                          <small>';
        echo '                              '.$response['response']['message'].'';
        echo '                          </small>';
        echo '                      </div>';
        echo '                  </div>';
        echo '              </div>';
        echo '          <div class="col-md-4"></div>';
        echo '      </div>';
        echo '  </div>';
        echo '</section>';
    }else{
        $metadata=$response['metadata'];
        $nama=$metadata['nama'];
        $kontak=$metadata['kontak'];
        $email=$metadata['email'];
        $provinsi=$metadata['provinsi'];
        $kabupaten=$metadata['kabupaten'];
        $kecamatan=$metadata['kecamatan'];
        $desa=$metadata['desa'];
        $kode_pos=$metadata['kode_pos'];
        $rt_rw=$metadata['rt_rw'];
        $datetime=$metadata['datetime'];
        $status=$metadata['status'];
        $foto=$metadata['foto'];
        if(empty($foto)){
            $foto="assets/img/No-Image.png";
        }
?>
        <section id="service-details" class="service-details section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                    <?php
                        if(!empty($_SESSION['notifikasi_proses'])){
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                            echo '  '.$_SESSION['notifikasi_proses'].'';
                            echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            echo '</div>';
                            //Hapus Session
                            unset($_SESSION['notifikasi_proses']);
                        }
                        if(!empty($_SESSION['notifikasi_proses_ubah_profil'])){
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                            echo '  '.$_SESSION['notifikasi_proses_ubah_profil'].'';
                            echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            echo '</div>';
                            //Hapus Session
                            unset($_SESSION['notifikasi_proses_ubah_profil']);
                        }
                    ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="box_custome">
                            <div class="box_custome_header">
                                <h4>
                                    <i class="bi bi-image"></i> Foto Profil
                                </h4>
                            </div>
                            <div class="box_custome_content">
                                <div class="row mt-3">
                                    <div class="col-md-12 text-center">
                                        <img src="<?php echo $foto; ?>" alt="" width="200px">
                                    </div>
                                </div>
                            </div>
                            <div class="box_custome_footer">
                                <div class="row mt-3">
                                    <div class="col-md-12 text-center">
                                        <button type="button" class="button_more" data-bs-toggle="modal" data-bs-target="#ModalUbahFotoProfil">
                                            <i class="bi bi-upload"></i> Ubah Foto
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="box_custome">
                            <div class="box_custome_header">
                                <h4 class="text-dark">
                                    <i class="bi bi-person-circle"></i> Profil Member
                                </h4>
                            </div>
                            <div class="box_custome_content ">
                                <div class="row mb-3">
                                    <div class="col col-md-4">
                                        <small>Nama</small>
                                    </div>
                                    <div class="col col-md-8">
                                        <small>
                                            <code class="text text-dark" id="GetName"><?php echo $nama; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4">
                                        <small>Kontak (HP)</small>
                                    </div>
                                    <div class="col col-md-8">
                                        <small>
                                            <code class="text text-dark" id="GetKontak"><?php echo $kontak; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4">
                                        <small>Email</small>
                                    </div>
                                    <div class="col col-md-8">
                                        <small>
                                            <code class="text text-dark" id="GetEmail"><?php echo $email; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4">
                                        <small>Provinsi</small>
                                    </div>
                                    <div class="col col-md-8">
                                        <small>
                                            <code class="text text-dark" id="GetProvinsi"><?php echo $provinsi; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4">
                                        <small>Kabupaten/Kota</small>
                                    </div>
                                    <div class="col col-md-8">
                                        <small>
                                            <code class="text text-dark" id="GetKabupaten"><?php echo $kabupaten; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4">
                                        <small>Kecamatan</small>
                                    </div>
                                    <div class="col col-md-8">
                                        <small>
                                            <code class="text text-dark" id="GetKecamatan"><?php echo $kecamatan; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4">
                                        <small>Desa/Kelurahan</small>
                                    </div>
                                    <div class="col col-md-8">
                                        <small>
                                            <code class="text text-dark" id="GetDesa"><?php echo $desa; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4">
                                        <small>RT/RW</small>
                                    </div>
                                    <div class="col col-md-8">
                                        <small>
                                            <?php 
                                                if(empty($rt_rw)){
                                                    echo '<code class="text text-danger" id="GetRtRw">None</code>';
                                                }else{
                                                    echo '<code class="text text-dark" id="GetRtRw">'.$rt_rw.'</code>';
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4">
                                        <small>Kode Pos</small>
                                    </div>
                                    <div class="col col-md-8">
                                        <small>
                                            <?php 
                                                if(empty($kode_pos)){
                                                    echo '<code class="text text-danger" id="GetKodePos">None</code>';
                                                }else{
                                                    echo '<code class="text text-dark" id="GetKodePos">'.$kode_pos.'</code>';
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4">
                                        <small>Status</small>
                                    </div>
                                    <div class="col col-md-8">
                                        <small>
                                            <?php
                                                if($status=="Active"){
                                                    echo '<code class="text-success" id="GetStatus">'.$status.'</code>';
                                                }else{
                                                    echo '<code class="text-danger" id="GetStatus">'.$status.'</code>';
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="box_custome_footer">
                                <div class="row mt-3">
                                    <div class="col-md-12 text-center">
                                        <button type="button" class="button_more" class="button_more" data-bs-toggle="modal" data-bs-target="#ModalUbahProfil">
                                            <i class="bi bi-pencil"></i> Ubah Profil
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                        <div class="box_custome">
                            <div class="box_custome_header">
                                <h4><i class="bi bi-arrow-right-circle"></i> Lanjutan</h4>
                            </div>
                            <div class="services-list mt-4">
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalUbahPassword">
                                    <i class="bi bi-key"></i><span>Ubah Password</span>
                                </a>
                                <a href="javascript:void(0);">
                                    <i class="bi bi-arrow-right-circle"></i><span>Riwayat Event</span>
                                </a>
                                <a href="javascript:void(0);">
                                    <i class="bi bi-arrow-right-circle"></i><span>Riwayat Pembelian</span>
                                </a>
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalLogout">
                                    <i class="bi bi-lock"></i><span>Logout</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php } ?>