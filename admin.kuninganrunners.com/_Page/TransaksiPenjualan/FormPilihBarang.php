<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Uang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_barang'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  Tidak ada item barang yang dipilih!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            if(empty($_POST['id_member'])){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                echo '          <small class="credit">';
                echo '              <code class="text-dark">';
                echo '                  Tidak ada member yang dipilih!';
                echo '              </code>';
                echo '          </small>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $id_barang=$_POST['id_barang'];
                $id_member=$_POST['id_member'];
                //Buka Detail Barang
                $nama_barang=GetDetailData($Conn,'barang','id_barang',$id_barang,'nama_barang');
                $kategori=GetDetailData($Conn,'barang','id_barang',$id_barang,'kategori');
                $satuan=GetDetailData($Conn,'barang','id_barang',$id_barang,'satuan');
                $dimensi=GetDetailData($Conn,'barang','id_barang',$id_barang,'dimensi');
                $deskripsi=GetDetailData($Conn,'barang','id_barang',$id_barang,'deskripsi');
                $foto=GetDetailData($Conn,'barang','id_barang',$id_barang,'foto');
                $varian=GetDetailData($Conn,'barang','id_barang',$id_barang,'varian');
                $datetime=GetDetailData($Conn,'barang','id_barang',$id_barang,'datetime');
                $updatetime=GetDetailData($Conn,'barang','id_barang',$id_barang,'updatetime');
?>
                <input type="hidden" name="id_barang" value="<?php echo $id_barang; ?>">
                <input type="hidden" name="id_member" value="<?php echo $id_member; ?>">
                <div class="row mb-3">
                    <div class="col col-md-4">
                        <small>Nama Barang</small>
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
                <?php
                    //Membuka Varian
                    $VarianArray=json_decode($varian, true);
                    $JumlahVarian=count($VarianArray);
                    if(empty($JumlahVarian)){
                        $stok=GetDetailData($Conn,'barang','id_barang',$id_barang,'stok');
                        $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                        if(!empty($harga)){
                            $HargaFormat='Rp ' . number_format($harga, 0, ',', '.');
                        }else{
                            $HargaFormat='Rp 0';
                        }
                        echo '<div class="row mb-3">';
                        echo '  <div class="col col-md-4">';
                        echo '      <small>Stok</small>';
                        echo '  </div>';
                        echo '  <div class="col col-md-8">';
                        echo '      <small>';
                        echo '          <code class="text text-grayish">'.$stok.' '.$satuan.'</code>';
                        echo '      </small>';
                        echo '  </div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col col-md-4">';
                        echo '      <small>Harga</small>';
                        echo '  </div>';
                        echo '  <div class="col col-md-8">';
                        echo '      <small>';
                        echo '          <code class="text text-grayish">'.$HargaFormat.'</code>';
                        echo '      </small>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        echo '<div class="row mb-3">';
                        echo '  <div class="col col-md-4">';
                        echo '      <label for="id_varian"><small>Varian</small></label>';
                        echo '  </div>';
                        echo '  <div class="col col-md-8">';
                        foreach($VarianArray as $VarianList){
                            $id_varian=$VarianList['id_varian'];
                            $stok_varian=$VarianList['stok_varian'];
                            $nama_varian=$VarianList['nama_varian'];
                            $harga_varian=$VarianList['harga_varian'];
                            $harga_varian='Rp ' . number_format($harga_varian, 0, ',', '.');
                            echo '<div class="form-check mb-3">';
                            echo '  <input class="form-check-input" type="radio" name="id_varian" id="id_varian'.$id_varian.'" value="'.$id_varian.'">';
                            echo '  <label class="form-check-label" for="id_varian'.$id_varian.'">';
                            echo '      <small>'.$nama_varian.'</small><br>';
                            echo '      <small><code class="text text-grayish">'.$harga_varian.' ('.$stok_varian.' '.$satuan.')</code></small><br>';
                            echo '  </label>';
                            echo '</div>';
                        }
                        echo '  </div>';
                        echo '</div>';
                    }
                ?>
                <div class="row mb-3">
                    <div class="col col-md-4">
                        <small>
                            <label for="qty">Banyaknya (Qty)</label>
                        </small>
                    </div>
                    <div class="col col-md-8">
                        <input type="number" min="1" step="1" class="form-control" name="qty" id="qty" value="1">
                    </div>
                </div>
<?php
            }
        }
    }
?>