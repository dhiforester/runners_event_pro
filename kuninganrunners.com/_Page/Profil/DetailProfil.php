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
        $jumlah_keranjang=$metadata['jumlah_keranjang'];
        $jumlah_pendaftaran_event=$metadata['jumlah_pendaftaran_event'];
        $jumlah_transaksi_pembelian=$metadata['jumlah_transaksi_pembelian'];
        $transaksi_pendaftaran_menunggu=$metadata['transaksi_pendaftaran_menunggu'];
        $transaksi_pembelian_menunggu=$metadata['transaksi_pembelian_menunggu'];
        $testimoni=$metadata['testimoni'];
        $foto=$metadata['foto'];
        if(empty($foto)){
            $foto="assets/img/No-Image.png";
        }
        //Format Tanggal
        $strtotime=strtotime($datetime);
        $TanggalDaftar=date('d/m/Y H:i',$strtotime);
?>
    <div class="container mb-3">
        <div class="row">
            <div class="col-md-12">
                
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <div class="col-md-12">
            <?php
                if(!empty($_SESSION['notifikasi_proses'])){
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    echo '  '.$_SESSION['notifikasi_proses'].'';
                    echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div><br>';
                    //Hapus Session
                    unset($_SESSION['notifikasi_proses']);
                }
                if(!empty($_SESSION['notifikasi_proses_ubah_profil'])){
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    echo '  '.$_SESSION['notifikasi_proses_ubah_profil'].'';
                    echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div><br>';
                    //Hapus Session
                    unset($_SESSION['notifikasi_proses_ubah_profil']);
                }
                //Tampilkan Aleret Apabila Ada Pembayaran Pendaftaran Yang Menunggu
                if(!empty($transaksi_pendaftaran_menunggu)){
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      Anda memiliki <b>'.$transaksi_pendaftaran_menunggu.'</b> transaksi pendaftaran event yang menunggu pembayaran.';
                    echo '      Silahkan selesaikan pembayaran anda pada tauan ';
                    echo '      <a href="index.php?Page=RiwayatEvent">';
                    echo '          Berikut Ini';
                    echo '      </a>';
                    echo '  </small>';
                    echo '</div><br>';
                }
                //Tampilkan Aleret Apabila Ada Pembayaran Pembelian Yang Menunggu
                if(!empty($transaksi_pembelian_menunggu)){
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      Anda memiliki <b>'.$transaksi_pembelian_menunggu.'</b> transaksi pembelian yang menunggu pembayaran.';
                    echo '      Silahkan selesaikan pembayaran anda pada tauan ';
                    echo '      <a href="index.php?Page=RiwayatTransaksi">';
                    echo '          Berikut Ini';
                    echo '      </a>';
                    echo '  </small>';
                    echo '</div><br>';
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
                <div class="box_custome">
                    <div class="box_custome_header">
                        <h4><i class="bi bi-arrow-right-circle"></i> Opsi Lanjutan</h4>
                    </div>
                    <div class="services-list mt-4">
                        <a href="index.php?Page=Keranjang">
                            <i class="bi bi-bag-check"></i>
                            <small>
                                Keranjang Belanja 
                                <?php
                                    if(!empty($jumlah_keranjang)){
                                        echo '('.$jumlah_keranjang.')';
                                    }
                                ?>
                            </small>
                        </a>
                        <a href="index.php?Page=RiwayatEvent">
                            <i class="bi bi-calendar-check"></i>
                            <small>
                                Riwayat Pendaftaran Event 
                                <?php
                                    if(!empty($jumlah_pendaftaran_event)){
                                        echo '('.$jumlah_pendaftaran_event.')';
                                    }
                                ?>
                            </small>
                        </a>
                        <a href="index.php?Page=RiwayatTransaksi">
                            <i class="bi bi-arrow-right-circle"></i>
                            <small>
                                Riwayat Transaksi Pembelian 
                                <?php
                                    if(!empty($jumlah_transaksi_pembelian)){
                                        echo '('.$jumlah_transaksi_pembelian.')';
                                    }
                                ?>
                            </small>
                        </a>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalLogout">
                            <i class="bi bi-lock"></i><small>Logout</small>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box_custome">
                    <div class="box_custome_header">
                        <h4 class="text-dark">
                            <i class="bi bi-person-circle"></i> Profil Member
                        </h4>
                    </div>
                    <div class="box_custome_content ">
                        <?php
                            if($status=="Pending"){
                                echo '<div class="row mb-3">';
                                echo '  <div class="col col-md-12">';
                                echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                echo '          <small>';
                                echo '              Anda belum melakukan verifikasi akun, silahkan lakukan verifikasi akun pada tautan ';
                                echo '              <a href="index.php?Page=Pendaftaran-Berhasil&email='.$email_member.'">berikut ini.</a>';
                                echo '          </small>';
                                echo '      </div>';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                if(empty($testimoni)){
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col col-md-12">';
                                    echo '      <div class="alert alert-success alert-dismissible fade show" role="alert">';
                                    echo '          <small>';
                                    echo '              Terima kasih telah melakukan verifikasi akun anda. Selanjutnya anda berkesempatan untuk mengisi survey penilaian (testimoni) pada tautan ';
                                    echo '              <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalKirimTestimoni">berikut ini.</a> ';
                                    echo '          </small>';
                                    echo '      </div>';
                                    echo '  </div>';
                                    echo '</div>';
                                }
                            }
                        ?>
                        <div class="row mb-3">
                            <div class="col col-md-4">
                                <small class="mobile-text">Nama</small>
                            </div>
                            <div class="col col-md-8">
                                <small class="mobile-text">
                                    <code class="text text-dark" id="GetName"><?php echo $nama; ?></code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col col-md-4">
                                <small class="mobile-text">Kontak (HP)</small>
                            </div>
                            <div class="col col-md-8">
                                <small class="mobile-text">
                                    <code class="text text-dark" id="GetKontak"><?php echo $kontak; ?></code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col col-md-4">
                                <small class="mobile-text">Email</small>
                            </div>
                            <div class="col col-md-8">
                                <small class="mobile-text">
                                    <code class="text text-dark" id="GetEmail"><?php echo $email; ?></code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col col-md-4">
                                <small class="mobile-text">Provinsi</small>
                            </div>
                            <div class="col col-md-8">
                                <small class="mobile-text">
                                    <code class="text text-dark" id="GetProvinsi"><?php echo $provinsi; ?></code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col col-md-4">
                                <small class="mobile-text">Kabupaten/Kota</small>
                            </div>
                            <div class="col col-md-8">
                                <small class="mobile-text">
                                    <code class="text text-dark" id="GetKabupaten"><?php echo $kabupaten; ?></code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col col-md-4">
                                <small class="mobile-text">Kecamatan</small>
                            </div>
                            <div class="col col-md-8">
                                <small class="mobile-text">
                                    <code class="text text-dark" id="GetKecamatan"><?php echo $kecamatan; ?></code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col col-md-4">
                                <small class="mobile-text">Desa/Kelurahan</small>
                            </div>
                            <div class="col col-md-8">
                                <small class="mobile-text">
                                    <code class="text text-dark" id="GetDesa"><?php echo $desa; ?></code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col col-md-4">
                                <small class="mobile-text">Alamat</small>
                            </div>
                            <div class="col col-md-8">
                                <small class="mobile-text">
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
                                <small class="mobile-text">Kode Pos</small>
                            </div>
                            <div class="col col-md-8">
                                <small class="mobile-text">
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
                                <small class="mobile-text">Status</small>
                            </div>
                            <div class="col col-md-8">
                                <small class="mobile-text">
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
                        <div class="row mb-3">
                            <div class="col col-md-4">
                                <small class="mobile-text">Tgl.Daftar</small>
                            </div>
                            <div class="col col-md-8">
                                <small class="mobile-text">
                                    <code class="text-dark">
                                        <?php
                                            echo "$TanggalDaftar";
                                        ?>
                                    </code>
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="box_custome_footer">
                        <div class="row mt-3">
                            <div class="col-md-12 text-center">
                                <button type="button" class="button_more m-2" class="button_more" data-bs-toggle="modal" data-bs-target="#ModalUbahPassword">
                                    <i class="bi bi-key"></i> Ubah Password
                                </button>
                                <button type="button" class="button_more m-2" class="button_more" data-bs-toggle="modal" data-bs-target="#ModalUbahProfil">
                                    <i class="bi bi-pencil"></i> Ubah Profil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>