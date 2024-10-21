<?php
    if(empty($_GET['id'])){
        $ValidasiKelengkapanData="ID Barang Tidak Boleh Kosong!";
    }else{
        $id_barang=$_GET['id'];
        //Bersihkan Karakter
        $id_barang=validateAndSanitizeInput($id_barang);
        $id_barang_validasi=GetDetailData($Conn,'barang','id_barang',$id_barang,'id_barang');
        //Apabila ID Barang Tidak Ditemukan Pada Database
        if(empty($id_barang_validasi)){
            $ValidasiKelengkapanData="ID Barang Tidak Valid Atau Tidak Ditemukan Pada Database!";
        }else{
            $ValidasiKelengkapanData="Valid";
        }
    }
    if($ValidasiKelengkapanData!=="Valid"){
        echo '<section class="section dashboard">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12">';
        echo '          <div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '              <small>';
        echo '                  <code class="text-dark">';
        echo '                      '.$ValidasiKelengkapanData.'';
        echo '                  </code>';
        echo '              </small>';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</section>';
    }else{
        $nama_barang=GetDetailData($Conn,'barang','id_barang',$id_barang,'nama_barang');
        $kategori=GetDetailData($Conn,'barang','id_barang',$id_barang,'kategori');
        $satuan=GetDetailData($Conn,'barang','id_barang',$id_barang,'satuan');
        $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
        $stok=GetDetailData($Conn,'barang','id_barang',$id_barang,'stok');
        $dimensi=GetDetailData($Conn,'barang','id_barang',$id_barang,'dimensi');
        $deskripsi=GetDetailData($Conn,'barang','id_barang',$id_barang,'deskripsi');
        $foto=GetDetailData($Conn,'barang','id_barang',$id_barang,'foto');
        $varian=GetDetailData($Conn,'barang','id_barang',$id_barang,'varian');
        $datetime=GetDetailData($Conn,'barang','id_barang',$id_barang,'datetime');
        $updatetime=GetDetailData($Conn,'barang','id_barang',$id_barang,'updatetime');
        //Format Harga
        if(!empty($harga)){
            $HargaFormat='Rp ' . number_format($harga, 2, ',', '.');
        }else{
            $HargaFormat='Rp 0';
        }
        //Format Tanggal
        $strtotime1=strtotime($datetime);
        $strtotime2=strtotime($updatetime);
        //Menampilkan Tanggal
        $DatetimeFormat=date('d/m/Y H:i:s T', $strtotime1);
        $UpdatetimeFormat=date('d/m/Y H:i:s T', $strtotime2);
        if(!empty($foto)){
            $PathFoto="assets/img/Marchandise/$foto";
        }else{
            $PathFoto="assets/img/User/No-Image.png";
        }
        //Uraikan Dimensi
        $arry_dimensi=json_decode($dimensi, true);
        $berat=$arry_dimensi['berat'];
        $panjang=$arry_dimensi['panjang'];
        $lebar=$arry_dimensi['lebar'];
        $tinggi=$arry_dimensi['tinggi'];
        echo '<input type="hidden" id="GetIdBarang" value="'.$id_barang.'">';
?>
        <section class="section dashboard">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                        echo '  <small>';
                        echo '      <code class="text-dark">';
                        echo '          Berikut ini adalah halaman detail Merchandise yang berfungsi untuk mempermudah anda dalam mengelola informasi Merchandise lebih lanjut.';
                        echo '          Pada halaman ini anda bisa mengatur varian produk, melihat riwayat penjualan dan detail lainnya secara lengkap.';
                        echo '          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '      </code>';
                        echo '  </small>';
                        echo '</div>';
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <b class="card-title">
                                        <i class="bi bi-info-circle"></i> Detail Merchandise
                                    </b>
                                </div>
                                <div class="col col-md-2 mb-3">
                                    <a class="btn btn-md btn-outline-dark btn-rounded btn-block" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i> Option
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                        <li class="dropdown-header text-start">
                                            <h6>Option</h6>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetail" data-id="<?php echo "$id_barang"; ?>">
                                                <i class="bi bi-info-circle"></i> Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEdit" data-id="<?php echo "$id_barang"; ?>">
                                                <i class="bi bi-pencil"></i> Edit Merchandise
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahFoto" data-id="<?php echo "$id_barang"; ?>">
                                                <i class="bi bi-image"></i> Ubah Foto
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col col-md-2 mb-3">
                                    <a href="index.php?Page=Merchandise" class="btn btn-md btn-dark btn-block btn-rounded">
                                        <i class="bi bi-arrow-left-circle"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionFlushDetail">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOneDetail">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOneDetail" aria-expanded="true" aria-controls="flush-collapseOneDetail">
                                            <b>1. Informasi Umum</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOneDetail" class="accordion-collapse collapse show" aria-labelledby="flush-headingOneDetail" data-bs-parent="#accordionFlushDetail" style="">
                                        <div class="accordion-body">
                                            <div class="row mt-5">
                                                <div class="col-md-4 mb-3 mt-5 text-center" id="ShowFotoBarang">
                                                    <!-- Disini Menampilkan Foto Barang -->
                                                </div>
                                                <div class="col-md-8 mb-3 mt-5" id="ShowDetailBarang">
                                                    <!-- Disini Menampilkan Detail Barang -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingTwoDetail">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwoDetail" aria-expanded="false" aria-controls="flush-collapseTwoDetail">
                                            <b>2. Varian Produk</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTwoDetail" class="accordion-collapse collapse" aria-labelledby="flush-headingTwoDetail" data-bs-parent="#accordionFlushDetail">
                                        <div class="accordion-body">
                                            <div class="row mt-3 mb-3">
                                                <div class="col-md-10"></div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-md btn-outline-primary btn-rounded btn-block" data-bs-toggle="modal" data-bs-target="#ModalTambahVarian" data-id="<?php echo "$id_barang"; ?>">
                                                        <i class="bi bi-plus"></i> Tambah Varian
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-md-12" id="ShowVarianProduk">
                                                    <!-- Menampilkan List Varian Produk -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingTreeDetail">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTreeDetail" aria-expanded="false" aria-controls="flush-collapseTreeDetail">
                                            <b>3. Riwayat Penjualan</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTreeDetail" class="accordion-collapse collapse" aria-labelledby="flush-headingTreeDetail" data-bs-parent="#accordionFlushDetail">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-12 text-center" id="ShowRiwayatPenjualan">
                                                    <!-- Menampilkan List Riwayat Penjualan Barang -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php 
    } 
?>