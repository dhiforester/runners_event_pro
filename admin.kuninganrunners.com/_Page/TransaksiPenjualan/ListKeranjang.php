<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Uang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_member'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  <b>Belum Ada Member Yang Dipilih</b><br>';
            echo '                  Silahkan Pilih Member Terlebih Dulu<br>';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_member=$_POST['id_member'];
            //Menampilkan Tombol Tambah Keranjang
            echo '<div class="row border-1 border-bottom mb-3">';
            echo '  <div class="col-md-3 mb-3">';
            echo '      <button type="button" class="btn btn-md btn-outline-primary btn-rounded btn-block" data-bs-toggle="modal" data-bs-target="#ModalBarang">';
            echo '          <i class="bi bi-plus"></i> Tambah Merchandise';
            echo '      </button>';
            echo '  </div>';
            echo '  <div class="col-md-9 mb-3 text-center"></div>';
            echo '</div>';
            //Menghitung Jumlah transaksi_keranjang
            $jumlah_keranjang=mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_keranjang FROM transaksi_keranjang WHERE id_member='$id_member'"));
            if(empty($jumlah_keranjang)){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12 text-center">';
                echo '      <small class="credit">';
                echo '          <code class="text-danger">';
                echo '              Belum Ada Item Barang Pada Keranjang Member Ini';
                echo '          </code>';
                echo '      </small>';
                echo '  </div>';
                echo '</div>';
            }else{
                $no=1;
                $subtotal=0;
                //Membuka Keranjang Berdasarkan id_member
                $query = mysqli_query($Conn, "SELECT*FROM transaksi_keranjang WHERE id_member='$id_member'");
                while ($data = mysqli_fetch_array($query)) {
                    $id_transaksi_keranjang= $data['id_transaksi_keranjang'];
                    $id_barang= $data['id_barang'];
                    $id_varian= $data['id_varian'];
                    $qty= $data['qty'];
                    $nama_varian="";
                    //Buka Data Barang
                    $nama_barang=GetDetailData($Conn,'barang','id_barang',$id_barang,'nama_barang');
                    $kategori=GetDetailData($Conn,'barang','id_barang',$id_barang,'kategori');
                    $satuan=GetDetailData($Conn,'barang','id_barang',$id_barang,'satuan');
                    $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                    $stok=GetDetailData($Conn,'barang','id_barang',$id_barang,'stok');
                    $dimensi=GetDetailData($Conn,'barang','id_barang',$id_barang,'dimensi');
                    $deskripsi=GetDetailData($Conn,'barang','id_barang',$id_barang,'deskripsi');
                    $foto=GetDetailData($Conn,'barang','id_barang',$id_barang,'foto');
                    $varian=GetDetailData($Conn,'barang','id_barang',$id_barang,'varian');
                    if(!empty($varian)){
                        $varian_arry=json_decode($varian,true);
                        foreach($varian_arry as $varian_list){
                            $id_varian_list=$varian_list['id_varian'];
                            if($id_varian_list==$id_varian){
                                $harga=$varian_list['harga_varian'];
                                $nama_varian=$varian_list['nama_varian'];
                            }
                        }
                    }
                    //Menghitung Jumlah
                    $jumlah=$qty*$harga;
                    $subtotal=$subtotal+$jumlah;
                    $harga='' . number_format($harga, 0, ',', '.');
                    $jumlah='' . number_format($jumlah, 0, ',', '.');
?>
                    <div class="row mb-3">
                        <div class="col col-md-4 mb-3">
                            <small class="mobile-text">
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalEditKeranjang" data-id="<?php echo $id_transaksi_keranjang; ?>">
                                    <?php echo "$no. $nama_barang"; ?> <i class="bi bi-pencil-square"></i>
                                </a>
                                
                                <br>
                                <?php
                                    if(!empty( $nama_varian)){
                                        echo '<code class="text text-grayish">('.$nama_varian.')</code>';
                                    }
                                ?>
                            </small>
                        </div>
                        <div class="col col-md-4 mb-3">
                            <small class="mobile-text">
                                <?php
                                    echo '<code class="text text-grayish">'.$harga.' X '.$qty.'</code>';
                                ?>
                            </small>
                        </div>
                        <div class="col col-md-4 mb-3 text-end">
                            <small class="mobile-text">
                                <?php
                                    echo '<code class="text text-grayish">'.$jumlah.'</code>';
                                ?>
                            </small>
                        </div>
                    </div>
<?php
                    $no++;
                }
                $subtotal_format='' . number_format($subtotal, 0, ',', '.');
                echo '<div class="row mb-3">';
                echo '  <div class="col col-md-6 mb-3">';
                echo '      <small>Subtotal</small>';
                echo '  </div>';
                echo '  <div class="col col-md-6 mb-3 text-end">';
                echo '      <small>'.$subtotal_format.'</small>';
                echo '  </div>';
                echo '</div>';
            }
        }
    }
?>

