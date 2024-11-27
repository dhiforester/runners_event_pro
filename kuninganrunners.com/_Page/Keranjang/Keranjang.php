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
        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <div class="btn-group">
                    <a href="index.php?Page=Profil" class="btn btn-sm btn-outline-dark">
                        <i class="bi bi-person-circle"></i> Profil
                    </a>
                    <a href="index.php?Page=Merch" class="btn btn-sm btn-outline-dark">
                        <i class="bi bi-box"></i> Merchandise
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
                            $provinsi_member=$metadata_member['provinsi'];
                            $kabupaten_member=$metadata_member['kabupaten'];
                            $kecamatan_member=$metadata_member['kecamatan'];
                            $desa_member=$metadata_member['desa'];
                            $kode_pos_member=$metadata_member['kode_pos'];
                            $rt_rw_member=$metadata_member['rt_rw'];
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
                                        <input type="hidden" name="nama_member" value="<?php echo $nama; ?>">
                                        <input type="hidden" name="kontak_member" value="<?php echo $kontak; ?>">
                                        <input type="hidden" id="PutKabupatenMember" value="<?php echo $kabupaten_member; ?>">
                                        <input type="hidden" id="PutKecamatanMember" value="<?php echo $kecamatan_member; ?>">
                                        <input type="hidden" id="PutDesaMember" value="<?php echo $desa_member; ?>">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="box_custome">
                                                    <div class="box_custome_content">
                                                        <div class="row mb-3">
                                                            <div class="col-md-12">
                                                                <b>Rincian Item Barang</b>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-12 mb-3">
                                                                <small>
                                                                    <code class="text text-dark">
                                                                        Pilih item barang terlebih dulu sebelum melanjutkan transaksi.
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
                                                                $harga_fix_format='' . number_format($harga_fix, 0, ',', '.');
                                                                $subtotal_format='Rp ' . number_format($subtotal, 0, ',', '.');
                                                        ?>
                                                            <input type="hidden" name="id_transaksi_keranjang[]" value="<?php echo "$id_transaksi_keranjang"; ?>">
                                                            <input type="hidden" name="id_barang[]" value="<?php echo "$id_barang"; ?>">
                                                            <input type="hidden" name="harga[]" value="<?php echo "$harga_fix"; ?>">
                                                            <input type="hidden" name="qty[]" value="<?php echo "$qty"; ?>">
                                                            <input type="hidden" name="jumlah[]" value="<?php echo $subtotal; ?>">
                                                            <div class="row mb-3 border-1 border-bottom">
                                                                <div class="col col-md-6">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" id="<?php echo "Check-$no"; ?>" name="item_keranjang[]" value="<?php echo "$id_transaksi_keranjang|$id_barang|$harga_fix|$qty|$subtotal"; ?>">
                                                                        <label class="form-check-label" for="<?php echo "Check-$no"; ?>">
                                                                            <small class="mobile-text">
                                                                                <?php 
                                                                                    echo "<b>$nama_barang</b>"; 
                                                                                    if(!empty($nama_varian_display)){
                                                                                        echo ' - <code class="text text-grayish">('.$nama_varian_display.')</code>';
                                                                                    }
                                                                                ?> 
                                                                            </small>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col col-md-6 text-end">
                                                                    <small class="mobile-text">
                                                                        <code class="text text-grayish">
                                                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalEditKeranjang" data-id="<?php echo "$id_transaksi_keranjang|$nama_barang|$harga_fix|$qty|$subtotal"; ?>">
                                                                                <?php echo "($harga_fix_format X $qty)"; ?>
                                                                            </a>
                                                                        </code>
                                                                    </small>
                                                                </div>
                                                                <div class="col-md-12 mb-2 text-end">
                                                                    <small class="mobile-text text-grayish jumlah-item">
                                                                        <?php echo "$subtotal_format"; ?>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        <?php $no++;} ?>
                                                        <div class="row border-1 border-bottom">
                                                            <div class="col col-md-6 mb-3">
                                                                <b class="mobile-text">Subtotal</b>
                                                            </div>
                                                            <div class="col col-md-6 text-end">
                                                                <b class="mobile-text" id="Subtotal">Rp 0</b>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <small class="mobile-text">
                                                                    Harga belum termasuk ongkos kirim. 
                                                                    Tombol pembayaran akan muncul setelah kami melakukan validasi pesanan anda. 
                                                                    Lihat petunjuk dan tahapan transaksi aman pada halaman 
                                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalPetunjukPesanan">berikut ini</a>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="box_custome">
                                                    <div class="box_custome_content">
                                                        <div class="row mb-3">
                                                            <div class="col-md-12">
                                                                <b>Informasi Pengiriman</b>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col col-md-3">
                                                                <small>Nama</small>
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
                                                        <div class="row mb-3 border-dashed-bottom">
                                                            <div class="col col-md-12"></div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="provinsi_pengiriman">
                                                                    <small>Provinsi</small>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <select name="provinsi" id="provinsi_pengiriman" class="form-control">
                                                                    <option value="">Pilih</option>
                                                                    <?php
                                                                        $ListProvinsi=ListProvinsi($url_server,$xtoken);
                                                                        $array_provinsi= json_decode($ListProvinsi, true);
                                                                        if($array_provinsi['response']['code']==200) {
                                                                            if(!empty($array_provinsi['metadata'])){
                                                                                $provinsi = $array_provinsi['metadata'];
                                                                                foreach($provinsi as $list_provinsi){
                                                                                    $id_propinsi=$list_provinsi['id_propinsi'];
                                                                                    $propinsi=$list_provinsi['propinsi'];
                                                                                    if($provinsi_member==$propinsi){
                                                                                        echo '<option selected value="'.$id_propinsi.'">'.$propinsi.'</option>';
                                                                                    }else{
                                                                                        echo '<option value="'.$id_propinsi.'">'.$propinsi.'</option>';
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="kabupaten_pengiriman">
                                                                    <small>Kab/Kota</small>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <select name="kabupaten" id="kabupaten_pengiriman" class="form-control">
                                                                    <option value="">Pilih</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="kecamatan_pengiriman">
                                                                    <small>Kecamatan</small>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <select name="kecamatan" id="kecamatan_pengiriman" class="form-control">
                                                                    <option value="">Pilih</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="desa_pengiriman"><small>Desa/Kel</small></label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <select name="desa" id="desa_pengiriman" class="form-control">
                                                                    <option value="">Pilih</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="rt_rw">
                                                                    <small>Alamat</small>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <textarea name="rt_rw" id="rt_rw" class="form-control"><?php echo $rt_rw_member; ?></textarea>
                                                                <small>
                                                                    <code class="text text-grayish">
                                                                        Nomor Rumah, Jalan/Gang, RT/RW
                                                                    </code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="">
                                                                    <small>Kode Pos</small>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" name="kode_pos" id="kode_pos" class="form-control" value="<?php echo $kode_pos_member; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-12">
                                                                <small class="mobile-text">
                                                                    Pastikan alamat pengiriman sudah sesuai. Periksa kembali informasi tersebut sebelum anda melanjutkan transaksi.
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


