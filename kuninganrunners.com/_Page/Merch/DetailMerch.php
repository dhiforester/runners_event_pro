<div class="sub-page-title dark-background">
    <!-- Interval Background -->
</div>
<section id="service-details" class="service-details section">
    <div class="container mb-3">
        <div class="row">
            <div class="col-md-12 text-center mb-3">
                <h4>
                    <i class="bi bi-box"></i> Detail Merchandise
                </h4>
                <small>
                    Menampilkan Rincian Merchandise Dan Form Pemesanan
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-3">

            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <a href="index.php" class="btn btn-sm btn-outline-dark m-2">
                    <i class="bi bi-chevron-left"></i> Kembali Ke Beranda
                </a>
                <a href="index.php?Page=Merch" class="btn btn-sm btn-outline-dark m-2">
                    <i class="bi bi-list-nested"></i> List Merchandise
                </a>
            </div>
        </div>
    </div>
    <?php
        //Apabila ID Tidak Ada
        if(empty($_GET['id'])){
            echo '  <div class="container">';
            echo '      <div class="row gy-5">';
            echo '          <div class="col-md-4"></div>';
            echo '              <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">';
            echo '                  <div class="service-box">';
            echo '                      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '                          <small>';
            echo '                              ID Event Tidak Boleh Kosong!';
            echo '                          </small>';
            echo '                      </div>';
            echo '                  </div>';
            echo '              </div>';
            echo '          <div class="col-md-4"></div>';
            echo '      </div>';
            echo '  </div>';
        }else{
            //Buat Variabel
            $id_barang=$_GET['id'];
            $id_barang=validateAndSanitizeInput($id_barang);
            $GetDetailBarang=DetailBarang($url_server,$xtoken,$id_barang);
            $response=json_decode($GetDetailBarang,true);
            //Apabila Terjadi Kesalahan Pada Saat Memperpanjang Session
            if($response['response']['code']!==200){
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
            }else{
                $metadata=$response['metadata'];
                $nama_barang=$metadata['nama_barang'];
                $kategori=$metadata['kategori'];
                $deskripsi=$metadata['deskripsi'];
                $satuan=$metadata['satuan'];
                $harga=$metadata['harga'];
                $stok=$metadata['stok'];
                $dimensi=$metadata['dimensi'];
                $datetime=$metadata['datetime'];
                $updatetime=$metadata['updatetime'];
                $varian=$metadata['varian'];
                $marketplace=$metadata['marketplace'];
                $image=$metadata['image'];
                //Format Harga
                $harga_format='Rp ' . number_format($harga, 2, ',', '.');
                //Format tanggal
                $strtotime=strtotime($datetime);
                $DatetimePost=date('d/m/Y',$strtotime);
    ?>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="box_custome">
                        <div class="box_custome_content">
                            <img src="<?php echo $image; ?>" alt="" class="box_image" width="100%">
                        </div>
                    </div>
                    <?php
                        //Apabila Belum Login
                        if(empty($_SESSION['id_member_login'])){
                            //Buat Session Untuk Kembali Ke Halaman Ini Saat User Selesai Login
                            $_SESSION['url_back']="index.php?Page=DetailMerch&id=$id_barang";
                            //Buat Peringatan Untuk Login
                            echo '<div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
                            echo '  <small class="credit">';
                            echo '      Untuk melakukan pemesanan untuk produk Merchandise ini, anda harus';
                            echo '      <a href="index.php?Page=Login">Login/Daftar</a> ';
                            echo '      terlebih dulu.';
                            echo '  </small>';
                            echo '</div>';
                        }else{
                            echo '  <a href="javascript:void(0);" class="button_pendaftaran" data-bs-toggle="modal" data-bs-target="#ModalTambahKeranjang">';
                            echo '      <i class="bi bi-cart-plus"></i> Tambah Ke Keranjang';
                            echo '  </a>';
                            //Cek Apakah Item Barang Ada Di Keranjang
                            $id_member_login=$_SESSION['id_member_login'];
                            $email=$_SESSION['email'];
                            $cek_keranjang=CekBarangDiKeranjang($url_server,$xtoken,$email,$id_member_login,$id_barang);
                            $cek_keranjang_arry=json_decode($cek_keranjang,true);
                            if($cek_keranjang_arry['response']['code']==200){
                                $jumlah_item_keranjang=$cek_keranjang_arry['metadata']['keranjang'];
                                if(!empty($jumlah_item_keranjang)){
                                    echo '  <a href="index.php?Page=Keranjang" class="button_keranjang mt-3">';
                                    echo '      <i class="bi bi-bag-check"></i> Cek Keranjang ('.$jumlah_item_keranjang.')';
                                    echo '  </a>';
                                }
                            }
                        }
                    ?>
                </div>
                <div class="col-md-8">
                    <div class="box_custome">
                        <div class="box_custome_content">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <h4 class="text text-decoration-underline">
                                        <?php echo "$nama_barang"; ?>
                                    </h4>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <small>
                                        <?php echo "$deskripsi"; ?>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <small>Kategori</small>
                                </div>
                                <div class="col-md-8">
                                    <small>
                                        <code class="text-grayish"><?php echo "$kategori"; ?></code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <small>Harga</small>
                                </div>
                                <div class="col-md-8">
                                    <small>
                                        <code class="text-grayish"><?php echo "$harga_format"; ?></code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <small>Stok/Satuan</small>
                                </div>
                                <div class="col-md-8">
                                    <small>
                                        <code class="text-grayish"><?php echo "$stok $satuan"; ?></code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <small>Datetime Post</small>
                                </div>
                                <div class="col-md-8">
                                    <small>
                                        <code class="text-grayish"><?php echo "$DatetimePost"; ?></code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <small>Dimensi</small>
                                </div>
                                <div class="col-md-8">
                                    <small>
                                        <code class="text-grayish">
                                            <?php 
                                                echo '<ol>';
                                                echo '  <li>';
                                                echo '      Berat : '.$dimensi['berat'].' Kg';
                                                echo '  </li>';
                                                echo '  <li>';
                                                echo '      Lebar : '.$dimensi['lebar'].' cm';
                                                echo '  </li>';
                                                echo '  <li>';
                                                echo '      Panjang : '.$dimensi['panjang'].' cm';
                                                echo '  </li>';
                                                echo '  <li>';
                                                echo '      Tinggi : '.$dimensi['tinggi'].' cm';
                                                echo '  </li>';
                                                echo '</ol>';
                                            ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <small>Varian Produk</small>
                                </div>
                                <div class="col-md-8">
                                    <?php
                                        $JumlahVarian=count($varian);
                                        if(!empty($JumlahVarian)){
                                            foreach($varian as $varian_list){
                                                $id_varian=$varian_list['id_varian'];
                                                $foto_varian=$varian_list['foto_varian'];
                                                $nama_varian=$varian_list['nama_varian'];
                                                $stok_varian=$varian_list['stok_varian'];
                                                $harga_varian=$varian_list['harga_varian'];
                                                $keterangan_varian=$varian_list['keterangan_varian'];
                                                //Format Harga Varian
                                                $harga_varian_format='Rp ' . number_format($harga_varian, 2, ',', '.');
                                                echo '<div class="row mb-4">';
                                                echo '  <div class="col col-md-3">';
                                                echo '      <img src="'.$foto_varian.'" width="100%">';
                                                echo '  </div>';
                                                echo '  <div class="col col-md-9">';
                                                echo '      <small>'.$nama_varian.'</small><br>';
                                                echo '      <small><code class="text-grayish">Stok :'.$stok_varian.' '.$satuan.'</code></small><br>';
                                                echo '      <small><code class="text-grayish">Harga : '.$harga_varian_format.'</code></small><br>';
                                                echo '  </div>';
                                                echo '</div>';
                                            }
                                        }else{
                                            echo '<small>';
                                            echo '  <code>';
                                            echo '      Tidak Ada Varian Untuk Merchandise Ini';
                                            echo '  </code>';
                                            echo '</small>';
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php
                                if(!empty($marketplace)){
                                    if(!empty(count($marketplace))){
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4">';
                                        echo '      <small>Link/URL Marketplace</small>';
                                        echo '  </div>';
                                        echo '  <div class="col-md-8">';
                                        echo '      <small>';
                                        echo '          <code class="text-grayish">';
                                        echo '              <ol>';
                                                                foreach($marketplace as $marketplace_list){
                                                                    $nama_marketplace=$marketplace_list['nama_marketplace'];
                                                                    $url_marketplace=$marketplace_list['url_marketplace'];
                                                                    echo '<li>';
                                                                    echo '  '.$nama_marketplace.'';
                                                                    echo '  <a href="'.$url_marketplace.'" target="_blank">[Lihat Disini]</a>';
                                                                    echo '</li>';
                                                                }
                                        echo '              </ol>';
                                        echo '          </code>';
                                        echo '      </small>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
            }
        }
    ?>
</section>


