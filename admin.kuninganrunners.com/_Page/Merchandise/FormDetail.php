<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Harus Login Terlebih Dulu
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <code>Sesi Login Sudah Berakhir, Silahkan Login Ulang!</code>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Tangkap id_barang
        if(empty($_POST['id_barang'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <code>ID Barang Tidak Boleh Kosong</code>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_barang=$_POST['id_barang'];
            //Bersihkan Variabel
            $id_barang=validateAndSanitizeInput($id_barang);
            //Buka data Barang
            $ValidasiIdBarang=GetDetailData($Conn,'barang','id_barang',$id_barang,'id_barang');
            if(empty($ValidasiIdBarang)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <code>ID Barang Tidak Valid Atau Tidak Ditemukan Pada Database</code>';
                echo '  </div>';
                echo '</div>';
            }else{
                $nama_barang=GetDetailData($Conn,'barang','id_barang',$id_barang,'nama_barang');
                $kategori=GetDetailData($Conn,'barang','id_barang',$id_barang,'kategori');
                $satuan=GetDetailData($Conn,'barang','id_barang',$id_barang,'satuan');
                $dimensi=GetDetailData($Conn,'barang','id_barang',$id_barang,'dimensi');
                $deskripsi=GetDetailData($Conn,'barang','id_barang',$id_barang,'deskripsi');
                $foto=GetDetailData($Conn,'barang','id_barang',$id_barang,'foto');
                $varian=GetDetailData($Conn,'barang','id_barang',$id_barang,'varian');
                $datetime=GetDetailData($Conn,'barang','id_barang',$id_barang,'datetime');
                $updatetime=GetDetailData($Conn,'barang','id_barang',$id_barang,'updatetime');
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
                //Membuka Varian
                $VarianArray=json_decode($varian, true);
                $JumlahVarian=count($VarianArray);
                //Labell Varian
                if(empty($JumlahVarian)){
                    $stok=GetDetailData($Conn,'barang','id_barang',$id_barang,'stok');
                    $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                    if(!empty($harga)){
                        $HargaFormat='Rp ' . number_format($harga, 2, ',', '.');
                    }else{
                        $HargaFormat='Rp 0';
                    }
                    $LabelVarian='<badge class="badge badge-danger">Tidak Ada</badge>';
                }else{
                    $stok=0;
                    $TotalHarga=0;
                    foreach($VarianArray as $VarianList){
                        $stok_varian=$VarianList['stok_varian'];
                        $harga_varian=$VarianList['harga_varian'];
                        $stok=$stok+$stok_varian;
                        $TotalHarga=$TotalHarga+$harga_varian;
                        $hargaList[] = $harga_varian;
                    }
                    // Tentukan harga tertinggi dan terendah
                    $harga_terendah = min($hargaList);
                    $harga_tertinggi = max($hargaList);
                    $harga=$TotalHarga/$JumlahVarian;
                    $harga=round($harga);
                    $HargaFormat1='' . number_format($harga_terendah, 0, ',', '.');
                    $HargaFormat2='' . number_format($harga_tertinggi, 0, ',', '.');
                    $HargaFormat="$HargaFormat1-$HargaFormat2";
                    $LabelVarian='<badge class="badge badge-info">Tersedia '.$JumlahVarian.'</badge>';
                }
?>
            <input type="hidden" name="Page" value="Merchandise">
            <input type="hidden" name="Sub" value="DetailMerchandise">
            <input type="hidden" name="id" value="<?php echo $id_barang; ?>">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                            A. Informasi Umum
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
                        <div class="accordion-body">
                            <div class="row mb-3 mt-3">
                                <div class="col-md-12 mb-4">
                                    <div class="row mb-3">
                                        <div class="col col-md-4">
                                            <small>Nama Merchandise</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo $nama_barang; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col col-md-4">
                                            <small>Kategori</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo $kategori; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col col-md-4">
                                            <small>Satuan</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo $satuan; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col col-md-4">
                                            <small>Tersedia</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo $stok; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col col-md-4">
                                            <small>Harga</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo $HargaFormat; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col col-md-4">
                                            <small>Deskripsi</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo $deskripsi; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col col-md-4">
                                            <small>Datetime Creat</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo $DatetimeFormat; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col col-md-4">
                                            <small>Updatetime</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo $UpdatetimeFormat; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            B. Berat dan Ukuran Dimensi
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="row mb-3 mt-3">
                                <div class="col col-md-4">
                                    <small>Berat</small>
                                </div>
                                <div class="col col-md-8">
                                    <small>
                                        <code class="text text-grayish">
                                            <?php echo "$berat Kg"; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col col-md-4">
                                    <small>Panjang</small>
                                </div>
                                <div class="col col-md-8">
                                    <small>
                                        <code class="text text-grayish">
                                            <?php echo "$panjang Cm"; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col col-md-4">
                                    <small>Lebar</small>
                                </div>
                                <div class="col col-md-8">
                                    <small>
                                        <code class="text text-grayish">
                                            <?php echo "$lebar Cm"; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col col-md-4">
                                    <small>Tinggi</small>
                                </div>
                                <div class="col col-md-8">
                                    <small>
                                        <code class="text text-grayish">
                                            <?php echo "$tinggi Cm"; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            C. Foto
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="row mb-3 mt-3">
                                <div class="col col-md-12 text-center">
                                    <img src="<?php echo $PathFoto; ?>" alt="" width="50%" class="rounded-circle">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                            D. Varian
                        </button>
                    </h2>
                    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="row mb-3 mt-3">
                                <div class="col col-md-12">
                                    <?php
                                        if(empty($JumlahVarian)){
                                            echo '<div class="row">';
                                            echo '  <div class="col-md-12 mb-3 text-center">';
                                            echo '      <code>Item Barang Ini Tidak Memiliki Varian</code>';
                                            echo '  </div>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="list-group">';
                                            $no=1;
                                            foreach($VarianArray as $ListVarian){
                                                $id_varian=$ListVarian['id_varian'];
                                                $nama_varian=$ListVarian['nama_varian'];
                                                $harga_varian=$ListVarian['harga_varian'];
                                                $stok_varian=$ListVarian['stok_varian'];
                                                $keterangan_varian=$ListVarian['keterangan_varian'];
                                                $foto_varian=$ListVarian['foto_varian'];
                                                $HargaVarianFormat='Rp ' . number_format($harga_varian, 2, ',', '.');
                                                echo '<div class="list-group-item list-group-item-action" aria-current="true">';
                                                echo '  <div class="d-flex w-100 justify-content-between">';
                                                echo '      <small class="mb-1 text-dark">'.$no.'. '.$nama_varian.'</small>';
                                                echo '  </div>';
                                                echo '  <ul>';
                                                echo '      <li>';
                                                echo '          <small><code class="text text-dark">Harga : </code> <code class="text text-grayish">'.$HargaVarianFormat.'</code></small>';
                                                echo '      </li>';
                                                echo '      <li>';
                                                echo '          <small><code class="text text-dark">Stok : </code> <code class="text text-grayish">'.$stok_varian.' '.$satuan.'</code></small>';
                                                echo '      </li>';
                                                echo '  </ul>';
                                                echo '</div>';
                                                $no++;
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php 
            } 
        } 
    } 
?>