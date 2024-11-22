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
            //Buka data member
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
                $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                $stok=GetDetailData($Conn,'barang','id_barang',$id_barang,'stok');
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="row mb-3">
                            <div class="col col-md-12">
                                <b><?php echo $nama_barang; ?></b>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <small>Deskripsi</small>
                            </div>
                            <div class="col-md-12">
                                <small>
                                    <code class="text text-grayish">
                                        <?php echo "$deskripsi"; ?>
                                    </code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col col-md-3">
                                <small>Kategori</small>
                            </div>
                            <div class="col col-md-9">
                                <small>
                                    <code class="text text-grayish"><?php echo $kategori; ?></code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col col-md-3">
                                <small>Satuan</small>
                            </div>
                            <div class="col col-md-9">
                                <small>
                                    <code class="text text-grayish"><?php echo $satuan; ?></code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col col-md-3">
                                <small>Tersedia</small>
                            </div>
                            <div class="col col-md-9">
                                <small>
                                    <code class="text text-grayish"><?php echo $stok; ?></code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col col-md-3">
                                <small>Harga</small>
                            </div>
                            <div class="col col-md-9">
                                <small>
                                    <code class="text text-grayish"><?php echo $HargaFormat; ?></code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col col-md-3">
                                <small>Datetime Creat</small>
                            </div>
                            <div class="col col-md-9">
                                <small>
                                    <code class="text text-grayish"><?php echo $DatetimeFormat; ?></code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col col-md-3">
                                <small>Updatetime</small>
                            </div>
                            <div class="col col-md-9">
                                <small>
                                    <code class="text text-grayish"><?php echo $UpdatetimeFormat; ?></code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3 mt-3">
                            <div class="col col-md-3">
                                <small>Dimensi/Ukuran</small>
                            </div>
                            <div class="col col-md-9">
                                <ul>
                                    <li>
                                        <small class="text text-grayish">Berat :</small>
                                        <small>
                                            <code class="text text-grayish">
                                                <?php echo "$berat Kg"; ?>
                                            </code>
                                        </small>
                                    </li>
                                    <li>
                                        <small class="text text-grayish">Panjang :</small>
                                        <small>
                                            <code class="text text-grayish">
                                                <?php echo "$panjang Cm"; ?>
                                            </code>
                                        </small>
                                    </li>
                                    <li>
                                        <small class="text text-grayish">Lebar :</small>
                                        <small>
                                            <code class="text text-grayish">
                                                <?php echo "$lebar Cm"; ?>
                                            </code>
                                        </small>
                                    </li>
                                    <li>
                                        <small class="text text-grayish">Tinggi :</small>
                                        <small>
                                            <code class="text text-grayish">
                                                <?php echo "$tinggi Cm"; ?>
                                            </code>
                                        </small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
<?php 
            } 
        } 
    } 
?>