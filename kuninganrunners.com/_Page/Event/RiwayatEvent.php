<!-- Page Title -->
<div class="sub-page-title dark-background">
</div>
<section id="service-details" class="service-details section">
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12 mb-3">
                <!-- Interval -->
            </div>
        </div>
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
            <div class="col-md-12 text-center">
                <a href="index.php?Page=Profil" class="btn btn-sm btn-outline-dark m-3">
                    <i class="bi bi-chevron-left"></i> Halaman Profil
                </a>
            </div>
        </div>
    </div>
        <?php
            //Apabila ID Tidak Ada
            if(empty($_SESSION['id_member_login'])){
                $_SESSION['url_back']="index.php?Page=RiwayatEvent";
                include "_Page/Profil/no_access_member.php";
            }else{
                 //Apabila Session Sudah Expired
                if($_SESSION['login_expired']<date('Y-m-d H:i:s')){
                    $_SESSION['url_back']="index.php?Page=RiwayatEvent";
                    include "_Page/Profil/no_access_member.php";
                }else{
                    echo '<div class="container">';
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
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-3"></div>';
                        echo '  <div class="col-md-6 text-center" data-aos="fade-up" data-aos-delay="100">';
                        echo '      <img src="assets/img/no_data.png">';
                        echo '  </div>';
                        echo '  <div class="col-md-3"></div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-3"></div>';
                        echo '  <div class="col-md-6 text-center" data-aos="fade-up" data-aos-delay="100">';
                        echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        echo '          <small>';
                        echo '              '.$response['response']['message'].'';
                        echo '          </small>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '  <div class="col-md-3"></div>';
                        echo '</div>';
                    }else{
                        $metadata=$response['metadata'];
        ?>
            <div class="row">
                <div class="col-md-12">
                    <?php
                        $no=1;
                        foreach($metadata as $ListRiwayatEvent){
                            $id_event_peserta=$ListRiwayatEvent['id_event_peserta'];
                            $event=$ListRiwayatEvent['event'];
                            $tanggal_mulai=$ListRiwayatEvent['event']['tanggal_mulai'];
                            $kategori_pendaftaran=$ListRiwayatEvent['kategori']['kategori'];
                            if(empty($ListRiwayatEvent['kategori']['biaya_pendaftaran'])){
                                $biaya_pendaftaran=0;
                            }else{
                                $biaya_pendaftaran=$ListRiwayatEvent['kategori']['biaya_pendaftaran'];
                            }
                            $nama=$ListRiwayatEvent['nama'];
                            $email=$ListRiwayatEvent['email'];
                            $datetime=$ListRiwayatEvent['datetime'];
                            $status=$ListRiwayatEvent['status'];
                            $nama_event=$event['nama_event'];
                            //Format Tanggal Daftar
                            $strtotime1=strtotime($datetime);
                            $strtotime2=strtotime($tanggal_mulai);
                            $tangaal_daftar_format=date('d/m/Y',$strtotime1);
                            $pelaksanaan_format=date('d/m/Y',$strtotime2);
                            $jam_daftar_format=date('H:i T',$strtotime1);
                            //Format Biaya
                            $biaya_pendaftaran_format="Rp " . number_format($biaya_pendaftaran, 0, ',', '.');
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
                                        <div class="row">
                                            <div class="col col-md-4"><small class="mobile-text">Pelaksanaan</small></div>
                                            <div class="col col-md-8">
                                                <small class="mobile-text">
                                                    <code class="text text-grayish">
                                                        <?php echo "$pelaksanaan_format"; ?>
                                                    </code>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-md-4"><small class="mobile-text">Biaya Pendaftaran</small></div>
                                            <div class="col col-md-8">
                                                <small class="mobile-text">
                                                    <code class="text-grayish">
                                                        <?php echo "$biaya_pendaftaran_format"; ?>
                                                    </code>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-md-4"><small class="mobile-text">Kategori</small></div>
                                            <div class="col col-md-8">
                                                <small class="mobile-text">
                                                    <code class="text-grayish">
                                                        <?php echo "$kategori_pendaftaran"; ?>
                                                    </code>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col col-md-4"><small class="mobile-text">Tanggal Daftar</small></div>
                                            <div class="col col-md-8">
                                                <small class="mobile-text">
                                                    <code class="text-grayish">
                                                        <?php echo "$tangaal_daftar_format"; ?>
                                                    </code>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-md-4"><small class="mobile-text">Jam Daftar</small></div>
                                            <div class="col col-md-8">
                                                <small class="mobile-text">
                                                    <code class="text-grayish">
                                                        <?php echo "$jam_daftar_format"; ?>
                                                    </code>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-md-4"><small class="mobile-text">Status</small></div>
                                            <div class="col col-md-8">
                                                <small class="mobile-text">
                                                    <?php 
                                                        if($status=="Pending"){
                                                            echo '<code class="text-danger"><i class="bi bi-clock me-1"></i> Pending</code>';
                                                        }else{
                                                            echo '<code class="text-success"><i class="bi bi-check-circle me-1"></i> Lunas</code>';
                                                        }
                                                    ?>
                                                </small>
                                            </div>
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
        <?php
                    }
                }
            }
        ?>
    </div>
</section>


