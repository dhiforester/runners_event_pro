<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
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
            $OrderBy="id_akses";
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
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses WHERE nama_akses like '%$keyword%' OR kontak_akses like '%$keyword%' OR email_akses like '%$keyword%' OR akses like '%$keyword%' OR datetime_daftar like '%$keyword%' OR datetime_update like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses WHERE $keyword_by like '%$keyword%'"));
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
                        $query = mysqli_query($Conn, "SELECT*FROM akses ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM akses WHERE nama_akses like '%$keyword%' OR kontak_akses like '%$keyword%' OR email_akses like '%$keyword%' OR akses like '%$keyword%' OR datetime_daftar like '%$keyword%' OR datetime_update like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }else{
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM akses ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM akses WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }
                while ($data = mysqli_fetch_array($query)) {
                    $id_akses= $data['id_akses'];
                    $nama_akses= $data['nama_akses'];
                    $kontak_akses= $data['kontak_akses'];
                    $email_akses= $data['email_akses'];
                    $akses= $data['akses'];
                    $datetime_daftar= $data['datetime_daftar'];
                    $datetime_update= $data['datetime_update'];
                    //Jumlah
                    $JumlahAktivitas =mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses FROM log WHERE id_akses='$id_akses'"));
                    $JumlahRole =mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM akses_ijin WHERE id_akses='$id_akses'"));
                    //Format Tanggal
                    $strtotime1=strtotime($datetime_daftar);
                    $strtotime2=strtotime($datetime_update);
                    //Menampilkan Tanggal
                    $DateDaftar=date('d/m/Y H:i:s', $strtotime1);
                    $DateUpdate=date('d/m/Y H:i:s', $strtotime2);
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
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailAkses" data-id="<?php echo "$id_akses"; ?>">
                                            <i class="bi bi-info-circle"></i> Detail
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditAkses" data-id="<?php echo "$id_akses"; ?>">
                                            <i class="bi bi-pencil"></i> Ubah Info
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditLevelAkses" data-id="<?php echo "$id_akses"; ?>">
                                            <i class="bi bi-tag"></i> Ubah Level
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahFotoAkses" data-id="<?php echo "$id_akses"; ?>">
                                            <i class="bi bi-image"></i> Ubah Foto
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahPassword" data-id="<?php echo "$id_akses"; ?>">
                                            <i class="bi bi-lock"></i> Ubah Password
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahIzinAkses" data-id="<?php echo "$id_akses"; ?>">
                                            <i class="bi bi-key"></i> Izin Akses
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalLogAkses" data-id="<?php echo "$id_akses"; ?>">
                                            <i class="bi bi-list-check"></i> Log Aktivitas
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusAkses" data-id="<?php echo "$id_akses"; ?>">
                                            <i class="bi bi-x"></i> Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <b>
                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailAkses" data-id="<?php echo "$id_akses"; ?>">
                                            <?php echo "$no. $nama_akses"; ?>
                                        </a>
                                    </b>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small class="credit">Dibuat</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small class="credit">
                                                <code class="text text-grayish"><?php echo $DateDaftar; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small class="credit">Update</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small class="credit">
                                                <code class="text text-grayish"><?php echo $DateUpdate; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small class="credit">Email</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small class="credit">
                                                <code class="text text-grayish"><?php echo "$email_akses"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small class="credit">Kontak</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small class="credit">
                                                <code class="text text-grayish"><?php echo "$kontak_akses"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small class="credit">Entitias</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small class="credit">
                                                <code class="text text-grayish"><?php echo "$akses"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small class="credit">Aktivitas</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small class="credit">
                                                <code class="text text-grayish"><?php echo "$JumlahAktivitas Record"; ?></code>
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