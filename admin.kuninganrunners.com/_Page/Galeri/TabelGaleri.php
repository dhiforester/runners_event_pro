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
            $OrderBy="id_web_galeri";
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
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_galeri FROM web_galeri"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_galeri FROM web_galeri WHERE album like '%$keyword%' OR nama_galeri like '%$keyword%' OR datetime like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_galeri FROM web_galeri"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_galeri FROM web_galeri WHERE $keyword_by like '%$keyword%'"));
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
        <div class="row">
            <?php
                if(empty($jml_data)){
                    echo '<div class="card">';
                    echo '  <div class="card-body text-center">';
                    echo '      <code class="text-danger">';
                    echo '          Tidak Ada Galeri Yang Dapat Ditampilkan';
                    echo '      </code>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $no = 1+$posisi;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($keyword_by)){
                        if(empty($keyword)){
                            $query = mysqli_query($Conn, "SELECT*FROM web_galeri ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM web_galeri WHERE album like '%$keyword%' OR nama_galeri like '%$keyword%' OR datetime like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                    }else{
                        if(empty($keyword)){
                            $query = mysqli_query($Conn, "SELECT*FROM web_galeri ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM web_galeri WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_web_galeri= $data['id_web_galeri'];
                        $album= $data['album'];
                        $nama_galeri= $data['nama_galeri'];
                        $datetime= $data['datetime'];
                        $file_galeri= $data['file_galeri'];
                        //Format Tanggal
                        $strtotime1=strtotime($datetime);
                        $DatetimeFormat=date('d M Y H:i',$strtotime1);
                        //Url Image
                        $GaleriPath="assets/img/Galeri/$file_galeri";
            ?>
                    <div class="col-md-3">
                        <div class="card hover-shadow">
                            <!-- Display the image full-width at the top -->
                            <div class="image-overlay album">
                                <img src="<?php echo $GaleriPath; ?>" alt="" class="img-fluid rounded-top">
                            </div>
                            
                            <div class="card-body">
                                <div class="filter">
                                    
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailGaleri" data-id="<?php echo "$id_web_galeri"; ?>">
                                            <small><?php echo "$no. $nama_galeri"; ?></small>
                                        </a><br>
                                        <small>
                                            <code class="text text-grayish">
                                                <i class="bi bi-tag"></i> <?php echo "$album"; ?>
                                            </code><br>
                                            <code class="text text-grayish">
                                                <i class="bi bi-calendar"></i> <?php echo "$DatetimeFormat"; ?>
                                            </code><br>
                                        </small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <a class="icon" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                            <small>
                                                <code class="text-primary">
                                                    <i class="bi bi-three-dots"></i> Option
                                                </code>
                                            </small>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                            <li class="dropdown-header text-start">
                                                <h6>Option</h6>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailGaleri" data-id="<?php echo "$id_web_galeri"; ?>">
                                                    <i class="bi bi-info-circle"></i> Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditGaleri" data-id="<?php echo "$id_web_galeri"; ?>">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusGaleri" data-id="<?php echo "$id_web_galeri"; ?>">
                                                    <i class="bi bi-x"></i> Hapus
                                                </a>
                                            </li>
                                        </ul>
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
        </div>
            
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