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
                    <a href="index.php?Page=Profil" class="btn btn-sm btn-outline-dark">
                            <small><i class="bi bi-person-circle"></i> Halaman Profil</small>
                        </a>
                        <a href="index.php?Page=RiwayatTransaksi" class="btn btn-sm btn-outline-dark">
                            <small><i class="bi bi-clock-history"></i> Transaksi</small>
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
                $_SESSION['url_back']="index.php?Page=DetailTransaksi&kode=$kode_transaksi";
                include "_Page/Profil/no_access_member.php";
            }else{
                //Apabila Session Sudah Expired
                if($_SESSION['login_expired']<date('Y-m-d H:i:s')){
                    $_SESSION['url_back']="index.php?Page=DetailTransaksi&kode=$kode_transaksi";
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
                                $tagihan=$metadata['tagihan'];
                                $ongkir=$metadata['ongkir'];
                                $ppn_pph=$metadata['ppn_pph'];
                                $biaya_layanan=$metadata['biaya_layanan'];
                                $biaya_lainnya=$metadata['biaya_lainnya'];
                                $potongan_lainnya=$metadata['potongan_lainnya'];
                                $jumlah=$metadata['jumlah'];
                                $pengiriman=$metadata['pengiriman'];
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
                                $jumlah_format='Rp ' . number_format($jumlah, 0, ',', '.');

                                //Buka Nomor Resi
                                if(!empty($transaksi_pengiriman)){
                                    if(empty($transaksi_pengiriman['no_resi'])){
                                        $no_resi="Tidak Ada";
                                    }else{
                                        $no_resi=$transaksi_pengiriman['no_resi'];
                                    }
                                    if(!empty($transaksi_pengiriman['tujuan_pengiriman'])){
                                        $tujuan_pengiriman=$transaksi_pengiriman['tujuan_pengiriman'];
                                        $metode_pengiriman=$tujuan_pengiriman['metode_pengiriman'];
                                    }else{
                                        $metode_pengiriman="";
                                    }
                                }else{
                                    $no_resi="Tidak Ada";
                                }
                                
                                //Inisiasi status Transaksi
                                if($status=="Lunas"){
                                    $LabelStatus='<code class="text text-success"><i class="bi bi-check-circle"></i> Lunas</code>';
                                }else{
                                    if($status=="Menunggu"){
                                        $LabelStatus='<code class="text text-danger"><i class="bi bi-clock"></i> Menunggu Validasi</code>';
                                    }else{
                                        $LabelStatus='<code class="text text-warning"><i class="bi bi-clock-history"></i> Menunggu Pembayaran</code>';
                                    }
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
                                                <div class="row mb-2">
                                                    <div class="col col-md-4">
                                                        <small class="mobile-text">Kode Transaksi</small>
                                                    </div>
                                                    <div class="col col-md-8">
                                                        <small class="mobile-text">
                                                            <code class="text text-grayish">
                                                                <?php echo "$kode_transaksi_terformat"; ?>
                                                            </code>
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col col-md-4">
                                                        <small class="mobile-text">Tgl/Jam</small>
                                                    </div>
                                                    <div class="col col-md-8">
                                                        <small class="mobile-text">
                                                            <code class="text text-grayish">
                                                                <?php echo "$tanggal_transaksi"; ?>
                                                            </code>
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col col-md-4">
                                                        <small class="mobile-text">Total Tagihan</small>
                                                    </div>
                                                    <div class="col col-md-8">
                                                        <small class="mobile-text">
                                                            <code class="text text-grayish">
                                                                <?php echo "$jumlah_format"; ?>
                                                            </code>
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col col-md-4">
                                                        <small class="mobile-text">No.Resi</small>
                                                    </div>
                                                    <div class="col col-md-8">
                                                        <small class="mobile-text">
                                                            <code class="text text-grayish">
                                                                <?php echo "$no_resi"; ?>
                                                            </code>
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col col-md-4">
                                                        <small class="mobile-text">Status Transaksi</small>
                                                    </div>
                                                    <div class="col col-md-8">
                                                        <small class="mobile-text">
                                                            <code class="text text-grayish">
                                                                <?php echo "$LabelStatus"; ?>
                                                            </code>
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col col-md-4">
                                                        <small class="mobile-text">Metode Pengiriman</small>
                                                    </div>
                                                    <div class="col col-md-8">
                                                        <small class="mobile-text">
                                                            <code class="text text-grayish">
                                                                <?php 
                                                                    echo "$pengiriman"; 
                                                                    if($metode_pengiriman=="Diambil"){
                                                                        echo "<br>(Alamat Toko : $kontak_alamat)";
                                                                    }
                                                                ?>
                                                            </code>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box_custome">
                                    <div class="box_custome_content">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <b>
                                                    <i class="bi bi-table"></i> Rincian Transaksi
                                                </b>
                                            </div>
                                        </div>
                                        <?php
                                            $no=1;
                                            $subtotal_format='Rp ' . number_format($tagihan, 0, ',', '.');
                                            foreach($transaksi_rincian as $transaksi_rincian_list){
                                                $id_transaksi_rincian=$transaksi_rincian_list['id_transaksi_rincian'];
                                                $id_barang=$transaksi_rincian_list['id_barang'];
                                                $nama_barang=$transaksi_rincian_list['nama_barang'];
                                                $varian=$transaksi_rincian_list['varian'];
                                                $harga=$transaksi_rincian_list['harga'];
                                                $qty=$transaksi_rincian_list['qty'];
                                                $jumlah_uraian=$transaksi_rincian_list['jumlah'];
                                                //Format 
                                                $harga_format='' . number_format($harga, 0, ',', '.');
                                                $jumlah_uraian_format='Rp ' . number_format($jumlah_uraian, 0, ',', '.');
                                                //Buka Varian
                                                if(!empty($varian)){
                                                    $nama_varian=$varian['nama_varian'];
                                                    if(empty($nama_varian)){
                                                        $nama_varian="";
                                                    }else{
                                                        $nama_varian="($nama_varian)";
                                                    }
                                                }else{
                                                    $nama_varian="";
                                                }
                                                //Tampilkan List
                                                echo '<div class="row border-dashed-bottom mb-2">';
                                                echo '  <div class="col col-md-4 mb-3">';
                                                echo '      <small class="mobile-text">'.$nama_barang.' '.$nama_varian.'</small><br>';
                                                echo '  </div>';
                                                echo '  <div class="col col-md-4 mb-3">';
                                                echo '      <small class="mobile-text">';
                                                echo '          <code class="text-grayish">'.$harga_format.' X '.$qty.'</code>';
                                                echo '      </small>';
                                                echo '  </div>';
                                                echo '  <div class="col col-md-4 mb-3 text-end">';
                                                echo '      <small class="mobile-text">';
                                                echo '          <code class="text-grayish">'.$jumlah_uraian_format.'</code>';
                                                echo '      </small>';
                                                echo '  </div>';
                                                echo '</div>';
                                                $no++;
                                            }
                                            //Menampilkan Subtotal
                                            echo '<div class="row mt-3 mb-2">';
                                            echo '  <div class="col col-md-8">';
                                            echo '      <small class="mobile-text">Subtotal</small>';
                                            echo '  </div>';
                                            echo '  <div class="col col-md-4 text-end">';
                                            echo '      <small class="mobile-text">';
                                            echo '          <code class="text-dark">'.$subtotal_format.'</code>';
                                            echo '      </small>';
                                            echo '  </div>';
                                            echo '</div>';
                                            //menampilkan Baris PPN
                                            if(!empty($ppn_pph)){
                                                //Hitung Persentase PPN
                                                if(!empty($tagihan)){
                                                    $ppn_pph_persen=($ppn_pph/$tagihan)*100;
                                                    $ppn_pph_persen=round($ppn_pph_persen);
                                                }else{
                                                    $ppn_pph_persen=0;
                                                }
                                                //Format Rupiah PPN
                                                $ppn_pph_foramt='Rp ' . number_format($ppn_pph, 0, ',', '.');
                                                echo '<div class="row mb-2">';
                                                echo '  <div class="col col-md-8">';
                                                echo '      <small class="mobile-text">Pajak PPN ('.$ppn_pph_persen.' %)</small>';
                                                echo '  </div>';
                                                echo '  <div class="col col-md-4 text-end">';
                                                echo '      <small class="mobile-text">';
                                                echo '          <code class="text-dark">'.$ppn_pph_foramt.'</code>';
                                                echo '      </small>';
                                                echo '  </div>';
                                                echo '</div>';
                                            }
                                            //Menampilkan Ongkir
                                            if(empty($ongkir)){
                                                if($status=="Menunggu"){
                                                    $ongkir_format='<small class="mobile-text"><code class="text-danger">Belum Diatur</code></small>';
                                                }else{
                                                    $ongkir_format='<small class="mobile-text"><code class="text-warning">Tidak Ada</code></small>';
                                                }
                                            }else{
                                                $ongkir_rp='Rp ' . number_format($ongkir, 0, ',', '.');
                                                $ongkir_format='<small class="mobile-text"><code class="text-dark">'.$ongkir_rp.'</code></small>';
                                            }
                                            echo '<div class="row mb-2">';
                                            echo '  <div class="col col-md-8">';
                                            echo '      <small class="mobile-text">Tarif Ongkir</small>';
                                            echo '  </div>';
                                            echo '  <div class="col col-md-4 text-end">';
                                            echo '      '.$ongkir_format.'';
                                            echo '  </div>';
                                            echo '</div>';
                                            //Menampilkan Biaya Layanan
                                            if(!empty($biaya_layanan)){
                                                $biaya_layanan_format='Rp ' . number_format($biaya_layanan, 0, ',', '.');
                                                echo '<div class="row mb-2">';
                                                echo '  <div class="col col-md-8">';
                                                echo '      <small class="mobile-text">Biaya Layanan</small>';
                                                echo '  </div>';
                                                echo '  <div class="col col-md-4 text-end">';
                                                echo '      <small class="mobile-text">';
                                                echo '          <code class="text-dark">'.$biaya_layanan_format.'</code>';
                                                echo '      </small>';
                                                echo '  </div>';
                                                echo '</div>';
                                            }
                                            //Menampilkan Biaya Lain-Lain
                                            if(!empty($biaya_lainnya)){
                                                echo '<div class="row">';
                                                echo '  <div class="col col-md-12">';
                                                echo '      <small class="mobile-text">Biaya Lain-lain :</small>';
                                                echo '  </div>';
                                                echo '</div>';
                                                foreach ($biaya_lainnya as $biaya_lainnya_list) {
                                                    $biaya_lainnya_nama=$biaya_lainnya_list['nama_biaya'];
                                                    $biaya_lainnya_nominal=$biaya_lainnya_list['nominal_biaya'];
                                                    $biaya_lainnya_nominal_format='Rp ' . number_format($biaya_lainnya_nominal, 0, ',', '.');
                                                    echo '<div class="row mb-2">';
                                                    echo '  <div class="col col-md-8">';
                                                    echo '      <small class="mobile-text"><code class="text-grayish">- '.$biaya_lainnya_nama.'</code></small>';
                                                    echo '  </div>';
                                                    echo '  <div class="col col-md-4 text-end">';
                                                    echo '      <small class="mobile-text">';
                                                    echo '          <code class="text-grayish">'.$biaya_lainnya_nominal_format.'</code>';
                                                    echo '      </small>';
                                                    echo '  </div>';
                                                    echo '</div>';
                                                }
                                            }
                                            //Menampilkan Potongan Lain-Lain
                                            if(!empty($potongan_lainnya)){
                                                echo '<div class="row">';
                                                echo '  <div class="col col-md-12">';
                                                echo '      <small class="mobile-text">Potongan Lain-lain :</small>';
                                                echo '  </div>';
                                                echo '</div>';
                                                foreach ($potongan_lainnya as $potongan_lainnya_list) {
                                                    $potongan_lainnya_nama=$potongan_lainnya_list['nama_potongan'];
                                                    $potongan_lainnya_nominal=$potongan_lainnya_list['nominal_potongan'];
                                                    $potongan_lainnya_nominal_format='Rp ' . number_format($potongan_lainnya_nominal, 0, ',', '.');
                                                    echo '<div class="row mb-2">';
                                                    echo '  <div class="col col-md-8">';
                                                    echo '      <small class="mobile-text"><code class="text-grayish">- '.$potongan_lainnya_nama.'</code></small>';
                                                    echo '  </div>';
                                                    echo '  <div class="col col-md-4 text-end">';
                                                    echo '      <small class="mobile-text">';
                                                    echo '          <code class="text-danger">- '.$potongan_lainnya_nominal_format.'</code>';
                                                    echo '      </small>';
                                                    echo '  </div>';
                                                    echo '</div>';
                                                }
                                            }
                                            //Menampilkan Total
                                            echo '<div class="row border-dashed-top mb-2 mt-3">';
                                            echo '  <div class="col col-md-8">';
                                            echo '      <small class="mobile-text"><b>Total</b></small>';
                                            echo '  </div>';
                                            echo '  <div class="col col-md-4 text-end">';
                                            echo '      <small class="mobile-text">';
                                            echo '          <code class="text-dark"><b>'.$jumlah_format.'</b></code>';
                                            echo '      </small>';
                                            echo '  </div>';
                                            echo '</div>';
                                            if($status=="Pending"){
                                                echo '<div class="row mb-2 mt-3">';
                                                echo '  <div class="col col-md-12 text-center">';
                                                echo '      <button type="button" class="button_more" data-bs-toggle="modal" data-bs-target="#ModalPembayaran" data-id="'.$kode_transaksi.'">';
                                                echo '          Selesaikan Pembayaran';
                                                echo '      </button>';
                                                echo '  </div>';
                                                echo '</div>';
                                            }
                                        ?>
                                    </div>
                                </div>
                                <!-- Menampilkan Informasi Pengiriman -->
                                <?php
                                    if(empty($transaksi_pengiriman)){
                                        echo '
                                            <div class="box_custome">
                                                <div class="box_custome_content">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                <small class="mobile-text">
                                                                    Belum ada informasi pengiriman untuk transaksi ini
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        ';
                                    }else{
                                        $no_resi=$transaksi_pengiriman['no_resi'];
                                        $kurir=$transaksi_pengiriman['kurir'];
                                        $asal_pengiriman=$transaksi_pengiriman['asal_pengiriman'];
                                        $tujuan_pengiriman=$transaksi_pengiriman['tujuan_pengiriman'];
                                        $status_pengiriman=$transaksi_pengiriman['status_pengiriman'];
                                        $datetime_pengiriman=$transaksi_pengiriman['datetime_pengiriman'];
                                        $link_pengiriman=$transaksi_pengiriman['link_pengiriman'];
                                        //Format Tanggal
                                        $datetime_pengiriman=date('d/m/Y H:i T',strtotime($datetime_pengiriman));
                                        //Inisiasi status Pengiriman
                                        if($status_pengiriman=="Pending"){
                                            $LabelStatusPengiriman='<code class="text text-dark">Belum Dikirim</code>';
                                        }else{
                                            if($status=="Proses"){
                                                $LabelStatusPengiriman='<code class="text text-warning">Dalam Perjalanan</code>';
                                            }else{
                                                if($status=="Selesai"){
                                                    $LabelStatusPengiriman='<code class="text text-success">Sampai Tujuan</code>';
                                                }else{
                                                    if($status=="Batal"){
                                                        $LabelStatusPengiriman='<code class="text text-danger">Batal/Dikembalikan</code>';
                                                    }else{
                                                        $LabelStatusPengiriman='<code class="text text-grayish">None</code>';
                                                    }
                                                }
                                            }
                                        }
                                        //Buka Asal Pengiriman
                                        $asal_pengiriman_provinsi=$asal_pengiriman['provinsi'];
                                        $asal_pengiriman_kabupaten=$asal_pengiriman['kabupaten'];
                                        $asal_pengiriman_kecamatan=$asal_pengiriman['kecamatan'];
                                        $asal_pengiriman_desa=$asal_pengiriman['desa'];
                                        $asal_pengiriman_rt_rw=$asal_pengiriman['rt_rw'];
                                        $asal_pengiriman_kode_pos=$asal_pengiriman['kode_pos'];
                                        $asal_pengiriman_kontak=$asal_pengiriman['kontak'];
                                        $asal_pengiriman_nama=$asal_pengiriman['nama'];
                                        //Buka Tujuan Pengiriman
                                        $metode_pengiriman=$tujuan_pengiriman['metode_pengiriman'];
                                        $alamt_pengiriman=$tujuan_pengiriman['alamt_pengiriman'];
                                        $kurir=$tujuan_pengiriman['kurir'];
                                        $cost_ongkir_item=$tujuan_pengiriman['cost_ongkir_item'];
                                        $tujuan_pengiriman_rt_rw=$tujuan_pengiriman['rt_rw'];
                                        $tujuan_pengiriman_kontak=$tujuan_pengiriman['kontak'];
                                        $tujuan_pengiriman_nama=$tujuan_pengiriman['nama'];

                                        //Menampilkan Informasi Pengiriman
                                        if($metode_pengiriman=="Dikirim"){
                                            if(empty($transaksi_pengiriman['no_resi'])){
                                                $label_resi='<span class="text-danger">Belum Dikirim</span>';
                                            }else{
                                                $label_resi='<span class="text-dark text-decoration-underline">'.$transaksi_pengiriman['no_resi'].'</span>';
                                            }
                                            echo '
                                                <div class="box_custome">
                                                    <div class="box_custome_content">
                                                        <div class="row mb-2">
                                                            <div class="col col-md-4"><small class="mobile-text">No.Resi</small></div>
                                                            <div class="col col-md-8">
                                                                <small class="mobile-text"><code class="text-grayish">'.$no_resi.'</code></small>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col col-md-4"><small class="mobile-text">Kurir</small></div>
                                                            <div class="col col-md-8">
                                                                <small class="mobile-text"><code class="text-grayish">'.$kurir.'</code></small>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col col-md-4"><small class="mobile-text">Tgl/Jam Pengiriman</small></div>
                                                            <div class="col col-md-8">
                                                                <small class="mobile-text"><code class="text-grayish">'.$datetime_pengiriman.'</code></small>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col col-md-4"><small class="mobile-text">Status Pengiriman</small></div>
                                                            <div class="col col-md-8">
                                                                <small class="mobile-text"><code class="text-grayish">'.$LabelStatusPengiriman.'</code></small>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col col-md-4"><small class="mobile-text">Dikirim Dari</small></div>
                                                            <div class="col col-md-8">
                                                                <small class="mobile-text">
                                                                    <code class="text text-grayish">A/N '.$asal_pengiriman_nama.' ('.$asal_pengiriman_kontak.')</code><br>
                                                                    <code class="text text-grayish">'.$asal_pengiriman_desa.', '.$asal_pengiriman_kecamatan.', '.$asal_pengiriman_kabupaten.'</code><br>
                                                                    <code class="text text-grayish">'.$asal_pengiriman_provinsi.'</code><br>
                                                                    <code class="text text-grayish">'.$asal_pengiriman_rt_rw.' '.$asal_pengiriman_kode_pos.'</code><br>
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col col-md-4"><small class="mobile-text">Dikirim Kepada</small></div>
                                                            <div class="col col-md-8">
                                                                <small class="mobile-text">
                                                                    <code class="text text-grayish">A/N '.$tujuan_pengiriman_nama.' ('.$tujuan_pengiriman_kontak.')</code><br>
                                                                    <code class="text text-grayish">'.$alamt_pengiriman.'</code><br>
                                                                    <code class="text text-grayish">'.$tujuan_pengiriman_rt_rw.'</code><br>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            ';
                                            if(!empty($link_pengiriman)){
                                                echo '<div class="row mt-3 mb-2">';
                                                echo '  <div class="col-md-12">';
                                                echo '      <a href="'.$link_pengiriman.'" class="button_pendaftaran" target="_blank">Lacak Paket</a>';
                                                echo '  </div>';
                                                echo '</div>';
                                            }
                                        }
                                    }
                                if($status!=="Lunas"){
                                    echo '<div class="row mb-2 mt-3">';
                                    echo '  <div class="col col-md-12 text-center">';
                                    echo '      <button type="button" class="button_batal" data-bs-toggle="modal" data-bs-target="#ModalBatalkanTransaksi" data-id="'.$kode_transaksi.'">';
                                    echo '          <i class="bi bi-trash"></i> Batalkan Transaksi';
                                    echo '      </button>';
                                    echo '  </div>';
                                    echo '</div>';
                                }
                            }
                        }
                    }
                }
            }
        ?>
    </div>
</section>


