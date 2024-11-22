<div class="sub-page-title dark-background">
    <!-- Interval Backgroun -->
</div>
<section id="service-details mt-5" class="service-details section">
    <div class="container mb-3">
        <div class="row">
            <div class="col-md-12 text-center mb-3">
                <h4>
                    <i class="bi bi-bag-check"></i> Keranjang Belanja
                </h4>
                <small>
                    Berikut ini adalah halaman keranjang belanja. Silahkan lanjutkan proses untuk menyelesaikan transaksi.
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-3">

            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <a href="index.php?Page=Profil" class="btn btn-outline-dark m-3">
                    <i class="bi bi-chevron-left"></i> Halaman Profil
                </a>
                <a href="index.php?Page=Merch" class="btn btn-outline-dark m-3">
                    <i class="bi bi-box"></i> Merchandise
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
                            //Buka Kontak Email Dan Alamat
                            $nama=$metadata_member['nama'];
                            $kontak=$metadata_member['kontak'];
                            $email=$metadata_member['email'];
                            $provinsi=$metadata_member['provinsi'];
                            $kabupaten=$metadata_member['kabupaten'];
                            $kecamatan=$metadata_member['kecamatan'];
                            $desa=$metadata_member['desa'];
                            $kode_pos=$metadata_member['kode_pos'];
                            $rt_rw=$metadata_member['rt_rw'];
                            //Apabila Berhasil Tampilkan Keranjang
                            $DataKeranjang=DataKeranjang($url_server,$xtoken,$email_member,$id_member_login);
                            $keranjang_array=json_decode($DataKeranjang, true);
                            if($keranjang_array['response']['code']!==200){
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
                                $metadata=$keranjang_array['metadata'];
                                $keranjang=$metadata['keranjang'];
                                if(empty($keranjang)){
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">';
                                    echo '      <div class="service-box">';
                                    echo '          <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                    echo '              <small>';
                                    echo '                  Belum Ada Item Barang Pada Keranjang Anda. Silahkan tambahkan item Merchandise terlebih dulu.';
                                    echo '              </small>';
                                    echo '          </div>';
                                    echo '      </div>';
                                    echo '  </div>';
                                    echo '</div>';
                                }else{
                                    
        ?>
                                    <form action="javascript:void(0);" id="ProsesTambahTransaksi">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="box_custome">
                                                    <div class="box_custome_content">
                                                        <div class="row mb-3">
                                                            <div class="col-md-12">
                                                                <small>
                                                                    <code class="text text-grayish">
                                                                        Checklist Item Keranjang Sebelum Melanjutkan Kirim Pemesanan
                                                                    </code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <?php
                                                            $no=1;
                                                            $list_keranjang=$metadata['list_keranjang'];
                                                            foreach ($list_keranjang as $list_keranjang_key) {
                                                                $id_transaksi_keranjang=$list_keranjang_key['id_transaksi_keranjang'];
                                                                $id_barang=$list_keranjang_key['id_barang'];
                                                                $detail_barang=$list_keranjang_key['detail_barang'];
                                                                $id_varian_checked=$list_keranjang_key['id_varian_checked'];
                                                                $nama_varian_display=$list_keranjang_key['nama_varian_display'];
                                                                $harga_fix=$list_keranjang_key['harga_fix'];
                                                                $qty=$list_keranjang_key['qty'];
                                                                //Buka Detail Barang
                                                                $nama_barang=$detail_barang['nama_barang'];
                                                                $satuan=$detail_barang['satuan'];
                                                                //Menghitung Jumlah
                                                                $subtotal=$harga_fix*$qty;
                                                                //Format rupiah
                                                                $harga_fix_format='Rp ' . number_format($harga_fix, 0, ',', '.');
                                                                $subtotal_format='Rp ' . number_format($subtotal, 0, ',', '.');
                                                        ?>
                                                            <input type="hidden" name="id_transaksi_keranjang[]" value="<?php echo "$id_transaksi_keranjang"; ?>">
                                                            <input type="hidden" name="id_barang[]" value="<?php echo "$id_barang"; ?>">
                                                            <input type="hidden" name="harga[]" value="<?php echo "$harga_fix"; ?>">
                                                            <input type="hidden" name="qty[]" value="<?php echo "$qty"; ?>">
                                                            <input type="hidden" name="jumlah[]" value="<?php echo $subtotal; ?>">
                                                            <div class="row mb-3 border-1 border-bottom">
                                                                <div class="col-md-6 mb-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" id="<?php echo "Check-$no"; ?>" name="item_keranjang[]" value="<?php echo "$id_transaksi_keranjang|$id_barang|$harga_fix|$qty|$subtotal"; ?>">
                                                                        <label class="form-check-label" for="<?php echo "Check-$no"; ?>">
                                                                            <?php echo "<b>$nama_barang</b>"; ?><br>
                                                                            <small>
                                                                                <code class="text text-grayish"><?php echo "$nama_varian_display"; ?></code>
                                                                            </small>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col col-md-3 mb-3">
                                                                    <small>
                                                                        <code class="text text-grayish">
                                                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalEditKeranjang" data-id="<?php echo "$id_transaksi_keranjang|$nama_barang|$harga_fix|$qty|$subtotal"; ?>">
                                                                                <?php echo "$harga_fix_format X $qty $satuan"; ?> <i class="bi bi-pencil-square"></i>
                                                                            </a>
                                                                        </code>
                                                                    </small>
                                                                </div>
                                                                <div class="col col-md-3 mb-3 text-end">
                                                                    <small class="text text-grayish jumlah-item">
                                                                        <?php echo "$subtotal_format"; ?>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        <?php $no++;} ?>
                                                        <div class="row">
                                                            <div class="col col-md-6">
                                                                <b>Subtotal</b>
                                                            </div>
                                                            <div class="col col-md-6 text-end">
                                                                <b  id="Subtotal">Rp 0</b>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <small>
                                                                    Harga belum termasuk ongkos kirim.<br>
                                                                    Lihat petunjuk dan tahapan transaksi aman pada halaman 
                                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalPetunjukPesanan">berikut ini</a>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box_custome">
                                                    <div class="box_custome_content">
                                                        <div class="row mb-4">
                                                            <div class="col-md-6">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-12">
                                                                        <b>Informasi Member</b>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col col-md-3">
                                                                        <small>Nama Member</small>
                                                                    </div>
                                                                    <div class="col col-md-9">
                                                                        <small>
                                                                            <code class="text text-grayish"><?php echo $nama; ?></code>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col col-md-3">
                                                                        <small>Kontak</small>
                                                                    </div>
                                                                    <div class="col col-md-9">
                                                                        <small>
                                                                            <code class="text text-grayish"><?php echo $kontak; ?></code>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col col-md-3">
                                                                        <small>Email</small>
                                                                    </div>
                                                                    <div class="col col-md-9">
                                                                        <small>
                                                                            <code class="text text-grayish"><?php echo $email; ?></code>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-12">
                                                                        <b>Alamat Pengiriman</b>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col col-md-3">
                                                                        <small>Provinsi</small>
                                                                    </div>
                                                                    <div class="col col-md-9">
                                                                        <small>
                                                                            <code class="text text-grayish"><?php echo $provinsi; ?></code>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col col-md-3">
                                                                        <small>Kabupaten/Kota</small>
                                                                    </div>
                                                                    <div class="col col-md-9">
                                                                        <small>
                                                                            <code class="text text-grayish"><?php echo $kabupaten; ?></code>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col col-md-3">
                                                                        <small>Kecamatan</small>
                                                                    </div>
                                                                    <div class="col col-md-9">
                                                                        <small>
                                                                            <code class="text text-grayish"><?php echo $kecamatan; ?></code>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col col-md-3">
                                                                        <small>Desa/Kelurahan</small>
                                                                    </div>
                                                                    <div class="col col-md-9">
                                                                        <small>
                                                                            <code class="text text-grayish"><?php echo $desa; ?></code>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col col-md-3">
                                                                        <small>RT/RW/Jalan</small>
                                                                    </div>
                                                                    <div class="col col-md-9">
                                                                        <small>
                                                                            <code class="text text-grayish"><?php echo $rt_rw; ?></code>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col col-md-3">
                                                                        <small>Kode Pos</small>
                                                                    </div>
                                                                    <div class="col col-md-9">
                                                                        <small>
                                                                            <code class="text text-grayish"><?php echo $kode_pos; ?></code>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-12">
                                                                <small>
                                                                    <code class="text text-grayish">
                                                                        Perubahan informasi member dan alamat pengiriman hanya bisa dilakukan pada halaman <a href="index.php?Page=Profil">profil</a>.
                                                                    </code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-12" id="NotifikasiTambahTransaksi">
                                                                <!-- Notifikasi Tambah Transaksi Akan Muncul Disini -->
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <button type="submit" class="button_pendaftaran" id="ButtonTambahTransaksi">
                                                                    <i class="bi bi-send"></i> Kirim Pesanan
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
        <?php
                                }
                            }
                        }
                    }
                }
            }
        ?>
    </div>
</section>


