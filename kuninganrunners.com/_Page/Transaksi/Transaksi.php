<div class="sub-page-title dark-background">
    <!-- Interval Backgroun -->
</div>
<section id="service-details mt-5" class="service-details section">
    <div class="container mb-3">
        <div class="row">
            <div class="col-md-12 text-center mb-3">
                <h4>
                    <i class="bi bi-cart-check"></i> Riwayat Transaksi Pembelian
                </h4>
                <small>
                    Berikut ini adalah halaman riwayat transaksi yang sudah anda lakukan.
                </small>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <a href="index.php?Page=Profil" class="btn btn-outline-dark m-3">
                    <i class="bi bi-chevron-left"></i> Kembali Ke Profil
                </a>
            </div>
        </div>
    </div>
    <div class="container mb-3">
        <?php
            //Sebelum Menampilkan Halaman Login, Lakukan Validasi Terhadap Session id_member_login
            //Apabila Session Tidak Ada
            if(empty($_SESSION['id_member_login'])&&empty($_SESSION['id_member_login'])){
                $_SESSION['url_back']="index.php?Page=Keranjang";
                include "_Page/Profil/no_access_member.php";
            }else{
                //Apabila Session Sudah Expired
                if($_SESSION['login_expired']<date('Y-m-d H:i:s')){
                    $_SESSION['url_back']="index.php?Page=Keranjang";
                    include "_Page/Profil/no_access_member.php";
                }else{
                //Perpanjang Session Akses Member
                    $email_member=$_SESSION['email'];
                    $id_member_login=$_SESSION['id_member_login'];
                    $UpdateSessionMemberLogin=UpdateSessionMemberLogin($url_server,$xtoken,$email_member,$id_member_login);
                    $response=json_decode($UpdateSessionMemberLogin,true);
                    //Apabila Terjadi Kesalahan Pada Saat Memperpanjang Session
                    if($response['response']['code']!==200){
                        echo '      <div class="row">';
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
                    }else{
                        $new_expired_date=$response['metadata']['datetime_expired'];
                        $_SESSION['login_expired']=$new_expired_date;
                        //Buka Data Member
                        $DetailProfilMember=DetailProfilMember($url_server,$xtoken,$email_member,$id_member_login);
                        $response=json_decode($DetailProfilMember,true);
                        if($response['response']['code']!==200){
                            echo '      <div class="row">';
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
                        }else{
                            $metadata_member=$response['metadata'];
                            $email=$metadata_member['email'];
                            //Apabila Berhasil Tampilkan Riwayat Transaksi
                            $DataRiwayatTransaksi=DataRiwayatTransaksi($url_server,$xtoken,$email_member,$id_member_login);
                            $riwayat_transaksi_arry=json_decode($DataRiwayatTransaksi, true);
                            if($riwayat_transaksi_arry['response']['code']!==200){
                                echo '      <div class="row">';
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
                            }else{
                                $metadata=$riwayat_transaksi_arry['metadata'];
                                if(empty(count($metadata))){
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">';
                                    echo '      <div class="service-box">';
                                    echo '          <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                    echo '              <small>';
                                    echo '                  Anda Tidak Mempunyai  Riwayat Transaksi Pembelian';
                                    echo '              </small>';
                                    echo '          </div>';
                                    echo '      </div>';
                                    echo '  </div>';
                                    echo '</div>';
                                }else{
                                    //Tampilkan Data
                                    $no=1;
                                    foreach ($metadata as $list_transaksi) {
                                        $kode_transaksi=$list_transaksi['kode_transaksi'];
                                        $raw_member=$list_transaksi['raw_member'];
                                        $pengiriman=$list_transaksi['pengiriman'];
                                        $datetime=$list_transaksi['datetime'];
                                        $jumlah=$list_transaksi['jumlah'];
                                        $status=$list_transaksi['status'];
                                        //Format Tanggal Transaksi
                                        $strtotime=strtotime($datetime);
                                        $tanggal_transaksi=date('d F Y H:i',$strtotime);
                                        //Format jumlah
                                        $jumlah='Rp ' . number_format($jumlah, 0, ',', '.');
                                        //Buka Nomor Resi
                                        if(!empty($pengiriman)){
                                            if(empty($pengiriman['no_resi'])){
                                                $no_resi="Tidak Ada";
                                            }else{
                                                $no_resi=$pengiriman['no_resi'];
                                            }
                                        }else{
                                            $no_resi="Tidak Ada";
                                        }
                                        //Inisiasi status
                                        if($status=="Lunas"){
                                            $LabelStatus='<code class="text text-success"><i class="bi bi-check-circle"></i> Lunas</code>';
                                        }else{
                                            $LabelStatus='<code class="text text-danger"><i class="bi bi-clock-history"></i> Pending</code>';
                                        }
                                        //Sensor Kode Transaksi
                                        // Trim untuk menghilangkan spasi di awal/akhir
                                        $kode_transaksi = trim($kode_transaksi);

                                        // Ambil 4 digit terakhir
                                        $akhir = substr($kode_transaksi, -4);

                                        // Tambahkan tanda bintang di depannya
                                        $kode_transaksi_terformat = "***" . $akhir;
        ?>
                                        <div class="box_custome">
                                            <div class="box_custome_content">
                                                <div class="row border-1 border-bottom mb-3">
                                                    <div class="col-md-12 mb-3">
                                                        <b>
                                                            <a href="index.php?Page=DetailTransaksi&kode=<?php echo "$kode_transaksi"; ?>">
                                                                <i class="bi bi-calendar-check"></i> <?php echo "$tanggal_transaksi"; ?>
                                                            </a>
                                                        </b>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col col-md-4">
                                                                <small>Kode Transaksi</small>
                                                            </div>
                                                            <div class="col col-md-8">
                                                                <small>
                                                                    <code class="text text-grayish">
                                                                        <?php echo "$kode_transaksi_terformat"; ?>
                                                                    </code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col col-md-4">
                                                                <small>Jumlah Tagihan</small>
                                                            </div>
                                                            <div class="col col-md-8">
                                                                <small>
                                                                    <code class="text text-grayish">
                                                                        <?php echo "$jumlah"; ?>
                                                                    </code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col col-md-4">
                                                                <small>No.Resi</small>
                                                            </div>
                                                            <div class="col col-md-8">
                                                                <small>
                                                                    <code class="text text-grayish">
                                                                        <?php echo "$no_resi"; ?>
                                                                    </code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col col-md-4">
                                                                <small>Status Transaksi</small>
                                                            </div>
                                                            <div class="col col-md-8">
                                                                <small>
                                                                    <code class="text text-grayish">
                                                                        <?php echo "$LabelStatus"; ?>
                                                                    </code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <small>
                                                            <code>
                                                                <a href="index.php?Page=DetailTransaksi&kode=<?php echo "$kode_transaksi"; ?>">
                                                                    Lihat Detail <i class="bi bi-three-dots"></i>
                                                                </a>
                                                            </code>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        <?php
                                    }
                                }
                            }
                        }
                    }
                }
            }
        ?>
    </div>
</section>


