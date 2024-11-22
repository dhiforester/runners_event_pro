<div class="sub-page-title dark-background">
    <!-- Interval Backgroun -->
</div>
<section id="service-details mt-5" class="service-details section">
    <?php
        //Tangkap Kode
        if(empty($_GET['kode'])){
            $kode_transaksi="";
            echo '<div class="container mb-3">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center mb-3">';
            echo '          <div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '              Kode Transaksi Tidak Boleh Kosong!';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $kode_transaksi=$_GET['kode'];
        }
    ?>
    <div class="container mb-3">
        <div class="row">
            <div class="col-md-12 text-center mb-3">
                <h4>
                    <i class="bi bi-info-circle"></i> Detail Transaksi Pembelian
                </h4>
                <small>
                    Berikut ini adalah halaman detail transaksi.
                </small>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <div class="btn-group">
                    <a href="index.php?Page=Profil" class="btn-outline-dark m-3">
                        <small><i class="bi bi-person-circle"></i> Halaman Profil</small>
                    </a>
                    <a href="index.php?Page=RiwayatTransaksi" class="btn-outline-dark m-3">
                        <small><i class="bi bi-clock-history"></i> Riwayat Transaksi</small>
                    </a>
                </div>
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
                        echo '<div class="row">';
                        echo '  <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">';
                        echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        echo '          <small>';
                        echo '              '.$response['response']['message'].'';
                        echo '          </small>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        $new_expired_date=$response['metadata']['datetime_expired'];
                        $_SESSION['login_expired']=$new_expired_date;
                        //Buka Data Member
                        $DetailProfilMember=DetailProfilMember($url_server,$xtoken,$email_member,$id_member_login);
                        $response=json_decode($DetailProfilMember,true);
                        if($response['response']['code']!==200){
                            echo '<div class="row">';
                            echo '  <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">';
                            echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                            echo '          <small>';
                            echo '              '.$response['response']['message'].'';
                            echo '          </small>';
                            echo '      </div>';
                            echo '  </div>';
                            echo '</div>';
                        }else{
                            $metadata_member=$response['metadata'];
                            $email=$metadata_member['email'];
                            //Apabila Berhasil Tampilkan Detail Transaksi
                            $DetailTransaksi=DetailTransaksi($url_server,$xtoken,$email_member,$id_member_login,$kode_transaksi);
                            $detail_transaksi_arry=json_decode($DetailTransaksi, true);
                            if($detail_transaksi_arry['response']['code']!==200){
                                echo '<div class="row">';
                                echo '  <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">';
                                echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                echo '          <small>';
                                echo '              '.$detail_transaksi_arry['response']['message'].'';
                                echo '          </small>';
                                echo '      </div>';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                //Buka Data Transaksi
                                $metadata=$detail_transaksi_arry['metadata'];
                                $id_member=$metadata['id_member'];
                                $raw_member=$metadata['raw_member'];
                                $kategori=$metadata['kategori'];
                                $datetime=$metadata['datetime'];
                                $jumlah=$metadata['jumlah'];
                                $status=$metadata['status'];
                                $transaksi_rincian=$metadata['transaksi_rincian'];
                                $transaksi_payment=$metadata['transaksi_payment'];
                                $transaksi_pengiriman=$metadata['transaksi_pengiriman'];
                                
                                //Format Kode Transaksi
                                $kode_transaksi = trim($kode_transaksi);
                                $akhir = substr($kode_transaksi, -4);
                                $kode_transaksi_terformat = "***" . $akhir;

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
        ?>
                                <div class="box_custome">
                                    <div class="box_custome_content">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <b>
                                                    <i class="bi bi-info-circle"></i> Informasi Umum
                                                </b>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="row mb-3">
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
                                                <div class="row mb-3">
                                                    <div class="col col-md-4">
                                                        <small>Tanggal/Waktu</small>
                                                    </div>
                                                    <div class="col col-md-8">
                                                        <small>
                                                            <code class="text text-grayish">
                                                                <?php echo "$tanggal_transaksi"; ?>
                                                            </code>
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
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
                                                <div class="row mb-3">
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
                                                <div class="row mb-3">
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
                                            <div class="col-md-12 mb-3">
                                                <b>
                                                    <i class="bi bi-table"></i> Rincian Barang
                                                </b>
                                            </div>
                                        </div>
                                        <?php
                                            $no=1;
                                            $subtotal=0;
                                            foreach($transaksi_rincian as $transaksi_rincian_list){
                                                $id_transaksi_rincian=$transaksi_rincian_list['id_transaksi_rincian'];
                                                $uraian_transaksi=$transaksi_rincian_list['uraian_transaksi'];
                                                $harga=$transaksi_rincian_list['harga'];
                                                $qty=$transaksi_rincian_list['qty'];
                                                $jumlah_uraian=$transaksi_rincian_list['jumlah'];
                                                $subtotal=$subtotal+$jumlah_uraian;
                                                //Format 
                                                $harga='Rp ' . number_format($harga, 0, ',', '.');
                                                $jumlah_uraian_format='Rp ' . number_format($jumlah_uraian, 0, ',', '.');
                                                //Buka Uraian Barang
                                                $kategori_uraian=$uraian_transaksi['kategori'];
                                                $id_barang=$uraian_transaksi['id_barang'];
                                                $id_varian=$uraian_transaksi['id_varian'];
                                                $nama_barang=$uraian_transaksi['nama_barang'];
                                                $nama_varian=$uraian_transaksi['nama_varian'];
                                                echo '<div class="row border-1 border-bottom mb-3">';
                                                echo '  <div class="col col-md-4 mb-3">';
                                                echo '      <small>'.$no.'. '.$nama_barang.' ('.$nama_varian.')</small><br>';
                                                echo '      <small><code class="text text-grayish">'.$harga.'</code></small>';
                                                echo '  </div>';
                                                echo '  <div class="col col-md-4 mb-3">';
                                                echo '      <small>'.$qty.' PCS</small>';
                                                echo '  </div>';
                                                echo '  <div class="col col-md-4 mb-3 text-end">';
                                                echo '      <small>'.$jumlah_uraian_format.'</small>';
                                                echo '  </div>';
                                                echo '</div>';
                                                $no++;
                                            }
                                            $subtotal_format='Rp ' . number_format($subtotal, 0, ',', '.');
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col col-md-8 mb-3">';
                                            echo '      Subtotal';
                                            echo '  </div>';
                                            echo '  <div class="col col-md-4 mb-3 text-end">';
                                            echo '      '.$subtotal_format.'';
                                            echo '  </div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col col-md-8 mb-3">';
                                            echo '      Tarif Ongkir';
                                            echo '  </div>';
                                            echo '  <div class="col col-md-4 mb-3 text-end">';
                                            echo '      '.$jumlah.'';
                                            echo '  </div>';
                                            echo '</div>';
                                            echo '<div class="row border-1 border-bottom mb-3">';
                                            echo '  <div class="col col-md-8 mb-3">';
                                            echo '      <b>Jumlah Total</b>';
                                            echo '  </div>';
                                            echo '  <div class="col col-md-4 mb-3 text-end">';
                                            echo '      <b>'.$jumlah.'</b>';
                                            echo '  </div>';
                                            echo '</div>';
                                        ?>
                                    </div>
                                </div>
        <?php
                            }
                        }
                    }
                }
            }
        ?>
    </div>
</section>


