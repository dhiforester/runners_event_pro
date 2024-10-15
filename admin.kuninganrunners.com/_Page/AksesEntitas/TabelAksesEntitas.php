<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
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
            $OrderBy="akses";
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
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_entitas"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_entitas WHERE akses like '%$keyword%' OR keterangan like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_entitas"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_entitas WHERE $keyword_by like '%$keyword%'"));
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
                echo '          Tidak Ada Data Entitias Yang Dapat Ditampilkan';
                echo '      </code>';
                echo '  </div>';
                echo '</div>';
            }else{
                $no = 1+$posisi;
                //KONDISI PENGATURAN MASING FILTER
                if(empty($keyword_by)){
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM akses_entitas ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM akses_entitas WHERE akses like '%$keyword%' OR keterangan like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }else{
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM akses_entitas ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM akses_entitas WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }
                while ($data = mysqli_fetch_array($query)) {
                    $uuid_akses_entitas= $data['uuid_akses_entitas'];
                    $akses= $data['akses'];
                    $keterangan= $data['keterangan'];
                    //Potong Karakter Yang terlalu panjang
                    $uuid_akses_entitas_short = substr($data['uuid_akses_entitas'], 0, 15) . '...';
                    $keterangan_short = substr($data['keterangan'], 0, 15) . '...';
                    //Jumlah
                    $JumlahPengguna =mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses FROM akses WHERE akses='$akses'"));
                    $JumlahRole =mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses_referensi FROM akses_referensi WHERE uuid_akses_entitas='$uuid_akses_entitas'"));
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
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailEntitias" data-id="<?php echo "$uuid_akses_entitas"; ?>">
                                            <i class="bi bi-info-circle"></i> Detail
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditAksesEntitas" data-id="<?php echo "$uuid_akses_entitas"; ?>">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusAksesEntitas" data-id="<?php echo "$uuid_akses_entitas"; ?>">
                                            <i class="bi bi-x"></i> Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <b>
                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailEntitias" data-id="<?php echo "$uuid_akses_entitas"; ?>">
                                            <?php echo "$no. $akses"; ?>
                                        </a>
                                    </b>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>UUID</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo $uuid_akses_entitas_short; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Keterangan</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo "$keterangan_short"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Pengguna</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo "$JumlahPengguna Orang"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Ijin/Fitur</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo "$JumlahRole Record"; ?></code>
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