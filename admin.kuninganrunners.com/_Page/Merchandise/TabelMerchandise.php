<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    $now=date('Y-m-d H:i');
    //Validasi Session Akses Masih ADa
    if(empty($SessionIdAkses)){
        echo '<div class="card">';
        echo '  <div class="card-body text-center">';
        echo '      <code class="text-danger">';
        echo '          Sesi akses sudah berakhir, silahkan login ulang!';
        echo '      </code>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Keyword_by
        if(!empty($_POST['keyword_by'])){
            $keyword_by=$_POST['keyword_by'];
        }else{
            $keyword_by="";
        }
        //keyword
        if(!empty($_POST['keyword'])){
            $keyword=$_POST['keyword'];
        }else{
            $keyword="";
        }
        //batas
        if(!empty($_POST['batas'])){
            $batas=$_POST['batas'];
        }else{
            $batas="10";
        }
        //ShortBy
        if(!empty($_POST['ShortBy'])){
            $ShortBy=$_POST['ShortBy'];
            if($ShortBy=="ASC"){
                $NextShort="DESC";
            }else{
                $NextShort="ASC";
            }
        }else{
            $ShortBy="DESC";
            $NextShort="ASC";
        }
        //OrderBy
        if(!empty($_POST['OrderBy'])){
            $OrderBy=$_POST['OrderBy'];
        }else{
            $OrderBy="id_barang";
        }
        //Atur Page
        if(!empty($_POST['page'])){
            $page=$_POST['page'];
            $posisi = ( $page - 1 ) * $batas;
        }else{
            $page="1";
            $posisi = 0;
        }
        if(empty($keyword_by)){
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang FROM barang"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang FROM barang WHERE nama_barang like '%$keyword%' OR kategori like '%$keyword%' OR satuan like '%$keyword%' OR harga like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang FROM barang"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang FROM barang WHERE $keyword_by like '%$keyword%'"));
            }
        }
        //Mengatur Halaman
        $JmlHalaman = ceil($jml_data/$batas); 
        $prev=$page-1;
        $next=$page+1;
        if($next>$JmlHalaman){
            $next=$page;
        }else{
            $next=$page+1;
        }
        if($prev<"1"){
            $prev="1";
        }else{
            $prev=$page-1;
        }
?>
        <script>
            //ketika klik next
            $('#NextPage').click(function() {
                var page=$('#NextPage').val();
                $('#page').val(page);
                filterAndLoadTable();
            });
            //Ketika klik Previous
            $('#PrevPage').click(function() {
                var page = $('#PrevPage').val();
                $('#page').val(page);
                filterAndLoadTable();
            });
        </script>
        <?php
            if(empty($jml_data)){
                echo '<div class="card">';
                echo '  <div class="card-body text-center">';
                echo '      <code class="text-danger">';
                echo '          Tidak Ada Data Merchandise Yang Dapat Ditampilkan';
                echo '      </code>';
                echo '  </div>';
                echo '</div>';
            }else{
                $no = 1+$posisi;
                //KONDISI PENGATURAN MASING FILTER
                if(empty($keyword_by)){
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM barang ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM barang WHERE nama_barang like '%$keyword%' OR kategori like '%$keyword%' OR satuan like '%$keyword%' OR harga like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }else{
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM barang ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM barang WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }
                while ($data = mysqli_fetch_array($query)) {
                    $id_barang= $data['id_barang'];
                    $nama_barang= $data['nama_barang'];
                    $kategori= $data['kategori'];
                    $satuan= $data['satuan'];
                    $varian= $data['varian'];
                    $datetime= $data['datetime'];
                    $updatetime= $data['updatetime'];
                    //Hitung Varian
                    $VarianArray=json_decode($varian, true);
                    $JumlahVarian=count($VarianArray);
                    //Format Tanggal
                    $strtotime1=strtotime($datetime);
                    $strtotime2=strtotime($updatetime);
                    $DatetimeFormat=date('d M Y H:i',$strtotime1);
                    $UpdatetimeFormat=date('d M Y H:i',$strtotime2);
                    //Labell Varian
                    if(empty($JumlahVarian)){
                        $stok= $data['stok'];
                        $harga= $data['harga'];
                        $HargaFormat='Rp ' . number_format($harga, 2, ',', '.');
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
                    //Item Terjual
                    $JumlahTotalItem = mysqli_fetch_assoc(
                        mysqli_query($Conn, "SELECT SUM(qty) AS total_qty FROM transaksi_rincian WHERE id_barang='$id_barang'")
                    )['total_qty'];
                    if(empty($JumlahTotalItem)){
                        $JumlahTotalItem=0;
                    }
        ?>
                    <div class="card hover-shadow">
                        <div class="card-body">
                            <div class="filter">
                                <a class="icon text-secondary" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
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
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahFoto" data-id="<?php echo "$id_barang"; ?>">
                                            <i class="bi bi-image"></i> Ubah Foto
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapus" data-id="<?php echo "$id_barang"; ?>">
                                            <i class="bi bi-x"></i> Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <b>
                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetail" data-id="<?php echo "$id_barang"; ?>">
                                            <?php echo "$no. $nama_barang"; ?>
                                        </a>
                                    </b>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Kategori</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo $kategori; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Tersedia</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo "$stok $satuan"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Harga</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo "$HargaFormat"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Varian</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <?php echo "$LabelVarian"; ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Item Terjual</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo "$JumlahTotalItem $satuan"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Updatetime</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo "$UpdatetimeFormat"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php
                    $no++; 
                }
            }
        ?>
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="btn-group shadow-0" role="group" aria-label="Basic example">
                    <button class="btn btn-md btn-grayish" id="PrevPage" value="<?php echo $prev;?>">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="btn btn-md btn-outline-grayish">
                        <?php echo "$page of $JmlHalaman"; ?>
                    </button>
                    <button class="btn btn-md btn-grayish" id="NextPage" value="<?php echo $next;?>">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
<?php 
    } 
?>