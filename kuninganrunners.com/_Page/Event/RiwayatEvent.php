<!-- Page Title -->
<div class="sub-page-title dark-background">
</div>
<!-- End Page Title -->
<?php
    //Apabila ID Tidak Ada
    if(empty($_SESSION['id_member_login'])){
        echo '<section id="service-details mt-5" class="service-details section">';
        echo '  <div class="container">';
        echo '      <div class="row gy-5">';
        echo '          <div class="col-md-4"></div>';
        echo '              <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">';
        echo '                  <div class="service-box">';
        echo '                      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '                          <small>';
        echo '                              Anda Tidak Punya Akses Masuk Ke Halaman Ini';
        echo '                          </small>';
        echo '                      </div>';
        echo '                  </div>';
        echo '              </div>';
        echo '          <div class="col-md-4"></div>';
        echo '      </div>';
        echo '  </div>';
        echo '</section>';
    }else{
        //Buat Variabel
        $email=$_SESSION['email'];
        $id_member_login=$_SESSION['id_member_login'];
        //Bersihkan Variabel
        $email=validateAndSanitizeInput($email);
        $id_member_login=validateAndSanitizeInput($id_member_login);
        //Buka Detail Event Peserta
        $GetRiwayatEvent=RiwayatEventMember($url_server,$xtoken,$email,$id_member_login);
        $response=json_decode($GetRiwayatEvent,true);
        //Apabila Terjadi Kesalahan Pada Saat Memperpanjang Session
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
?>
            <section id="service-details" class="service-details section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4>
                                <i class="bi bi-clock-history"></i> Riwayat Event
                            </h4>
                            <small>
                                Riwayat Semua Event Yang Pernah Diikuti
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                            <div class="box_custome">
                                <div class="services-list">
                                    <a href="index.php?Page=Profil">
                                        <i class="bi bi-person-circle"></i> <span>Profil</span>
                                    </a>
                                    <a href="index.php?Page=KalenderEvent">
                                        <i class="bi bi-calendar"></i><span>Kalender Event</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <?php
                                $no=1;
                                foreach($metadata as $ListRiwayatEvent){
                                    $id_event_peserta=$ListRiwayatEvent['id_event_peserta'];
                                    $event=$ListRiwayatEvent['event'];
                                    $kategori=$ListRiwayatEvent['kategori'];
                                    $nama=$ListRiwayatEvent['nama'];
                                    $email=$ListRiwayatEvent['email'];
                                    $datetime=$ListRiwayatEvent['datetime'];
                                    $status=$ListRiwayatEvent['status'];
                                    $nama_event=$event['nama_event'];
                                    //Format Tanggal Daftar
                                    $strtotime1=strtotime($datetime);
                                    $tangaal_daftar_format=date('d/m/Y H:i',$strtotime1);
                            ?>
                                <div class="box_custome">
                                    <div class="box_custome_content">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <b>
                                                    <a href="index.php?Page=DetailPendaftaranEvent&id=<?php echo "$id_event_peserta"; ?>">
                                                        <?php echo "$no. $nama_event"; ?>
                                                    </a>
                                                </b>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <div class="col col-md-4"><small>Nama</small></div>
                                                    <div class="col col-md-8"><small><code class="text-dark"><?php echo "$nama"; ?></code></small></div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col col-md-4"><small>Email</small></div>
                                                    <div class="col col-md-8"><small><code class="text-dark"><?php echo "$email"; ?></code></small></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <div class="col col-md-4"><small>Tanggal</small></div>
                                                    <div class="col col-md-8"><small><code class="text-dark"><?php echo "$tangaal_daftar_format"; ?></code></small></div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col col-md-4"><small>Status</small></div>
                                                    <div class="col col-md-8"><small><code class="text-dark"><?php echo "$email"; ?></code></small></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                    $no++;
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </section>
<?php
        }
    }
?>

