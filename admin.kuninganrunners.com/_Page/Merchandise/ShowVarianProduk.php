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
                $varian=GetDetailData($Conn,'barang','id_barang',$id_barang,'varian');
                $satuan=GetDetailData($Conn,'barang','id_barang',$id_barang,'satuan');
                //Uraikan Varian
                $arry_varian=json_decode($varian, true);
                $JumlahVarian=count($arry_varian);
                if(empty($JumlahVarian)){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 mb-3 text-center">';
                    echo '      <code>Item Barang Ini Tidak Memiliki Varian</code>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    echo '<div class="list-group">';
                    $no=1;
                    foreach($arry_varian as $ListVarian){
                        $id_varian=$ListVarian['id_varian'];
                        $nama_varian=$ListVarian['nama_varian'];
                        $harga_varian=$ListVarian['harga_varian'];
                        $stok_varian=$ListVarian['stok_varian'];
                        $keterangan_varian=$ListVarian['keterangan_varian'];
                        $foto_varian=$ListVarian['foto_varian'];
                        $HargaVarianFormat='Rp ' . number_format($harga_varian, 2, ',', '.');
?>
                        <div class="list-group-item list-group-item-action" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                                <small class="mb-1 text-dark"><?php echo "$no. $nama_varian"; ?></small>
                                <small>
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                        <li class="dropdown-header text-start">
                                            <h6>Option</h6>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailVarian" data-id="<?php echo "$id_barang-$id_varian"; ?>">
                                                <i class="bi bi-info-circle"></i> Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditVarian" data-id="<?php echo "$id_barang-$id_varian"; ?>">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusVarian" data-id="<?php echo "$id_barang-$id_varian"; ?>">
                                                <i class="bi bi-trash"></i> Hapus
                                            </a>
                                        </li>
                                    </ul>
                                </small>
                            </div>
                            <ul>
                                <li>
                                    <small>
                                        <code class="text text-dark">Harga : </code>
                                        <code class="text text-grayish"><?php echo "$HargaVarianFormat"; ?></code>
                                    </small>
                                </li>
                                <li>
                                    <small>
                                        <code class="text text-dark">Stok : </code>
                                        <code class="text text-grayish"><?php echo "$stok_varian $satuan"; ?></code>
                                    </small>
                                </li>
                            </ul>
                            
                        </div>
<?php 
                        $no++;
                    } 
                    echo '</div>';
                } 
            } 
        } 
    } 
?>