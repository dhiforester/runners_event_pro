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
            $keyword = mysqli_real_escape_string($Conn, $keyword);
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
            $OrderBy="id_web_testimoni";
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
                $query = "
                    SELECT COUNT(*) as jml_data 
                    FROM web_testimoni 
                ";
            }else{
                $query = "
                    SELECT COUNT(*) as jml_data 
                    FROM web_testimoni 
                    LEFT JOIN member ON web_testimoni.id_member = member.id_member 
                    WHERE 
                        web_testimoni.penilaian LIKE '%$keyword%' OR 
                        web_testimoni.testimoni LIKE '%$keyword%' OR 
                        web_testimoni.sumber LIKE '%$keyword%' OR 
                        web_testimoni.datetime LIKE '%$keyword%' OR 
                        web_testimoni.status LIKE '%$keyword%' OR
                        member.nama LIKE '%$keyword%' OR
                        member.email LIKE '%$keyword%'
                ";
            }
        }else{
            if(empty($keyword)){
                $query = "
                    SELECT COUNT(*) as jml_data 
                    FROM web_testimoni 
                ";
            }else{
                $query = "
                    SELECT COUNT(*) as jml_data 
                    FROM web_testimoni 
                    LEFT JOIN member ON web_testimoni.id_member = member.id_member 
                    WHERE 
                        $keyword_by LIKE '%$keyword%' 
                ";
            }
        }
        $result = mysqli_query($Conn, $query);
        $row = mysqli_fetch_assoc($result);
        $jml_data = $row['jml_data'];
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
                echo '          Tidak Ada Data Event Yang Dapat Ditampilkan';
                echo '      </code>';
                echo '  </div>';
                echo '</div>';
            }else{
                $no = 1 + $posisi;

                // KONDISI PENGATURAN MASING-MASING FILTER
                if (empty($keyword_by)) {
                    if (empty($keyword)) {
                        $qry = "
                            SELECT 
                                web_testimoni.*, 
                                member.nama, 
                                member.email, 
                                web_testimoni.status AS status_testimoni, 
                                member.status AS status_member 
                            FROM web_testimoni 
                            LEFT JOIN member ON web_testimoni.id_member = member.id_member 
                            ORDER BY $OrderBy $ShortBy 
                            LIMIT $posisi, $batas
                        ";
                    } else {
                        $qry = "
                            SELECT 
                                web_testimoni.*, 
                                member.nama, 
                                member.email, 
                                web_testimoni.status AS status_testimoni, 
                                member.status AS status_member 
                            FROM web_testimoni 
                            LEFT JOIN member ON web_testimoni.id_member = member.id_member 
                            WHERE 
                                web_testimoni.penilaian LIKE '%$keyword%' OR 
                                web_testimoni.testimoni LIKE '%$keyword%' OR 
                                web_testimoni.sumber LIKE '%$keyword%' OR 
                                web_testimoni.datetime LIKE '%$keyword%' OR 
                                web_testimoni.status LIKE '%$keyword%' OR
                                member.nama LIKE '%$keyword%' OR
                                member.email LIKE '%$keyword%' 
                            ORDER BY $OrderBy $ShortBy 
                            LIMIT $posisi, $batas
                        ";
                    }
                } else {
                    if (empty($keyword)) {
                        $qry = "
                            SELECT 
                                web_testimoni.*, 
                                member.nama, 
                                member.email, 
                                web_testimoni.status AS status_testimoni, 
                                member.status AS status_member  
                            FROM web_testimoni 
                            LEFT JOIN member ON web_testimoni.id_member = member.id_member 
                            ORDER BY $OrderBy $ShortBy 
                            LIMIT $posisi, $batas
                        ";
                    } else {
                        $qry = "
                            SELECT 
                                web_testimoni.*, 
                                member.nama, 
                                member.email, 
                                web_testimoni.status AS status_testimoni, 
                                member.status AS status_member  
                            FROM web_testimoni 
                            LEFT JOIN member ON web_testimoni.id_member = member.id_member 
                            WHERE 
                                $keyword_by LIKE '%$keyword%' 
                            ORDER BY $OrderBy $ShortBy 
                            LIMIT $posisi, $batas
                        ";
                    }
                }
                
                // Eksekusi Query
                $query = mysqli_query($Conn, $qry);
                if (!$query) {
                    die("Query Error: " . mysqli_error($Conn));
                }
                
                // Looping hasil query
                while ($data = mysqli_fetch_array($query)) {
                    // Mengakses nilai dari kolom web_testimoni dan member
                    $id_web_testimoni = $data['id_web_testimoni'];
                    $id_member = $data['id_member'];
                    $penilaian = $data['penilaian'];
                    $testimoni = $data['testimoni'];
                    $sumber = $data['sumber'];
                    $datetime = $data['datetime'];
                    $status = $data['status_testimoni'];
                    $nama = $data['nama'];
                    $email = $data['email'];
                    // Format Tanggal
                    $strtotime=strtotime($datetime);
                    $DatetimeFormat=date('d/m/Y H:i', $strtotime);
                    //Potong Alamat email
                    if(strlen($email)>18){
                        $email = "***" . substr($email, -15);
                    }
                    if(strlen($testimoni)>20){
                        $testimoni = substr($testimoni, 0, 20) . '...';
                    }
                    if($status=="Publish"){
                        $status='<badge class="badge badge-success">Publish</badge>';
                    }else{
                        $status='<badge class="badge badge-warning">Draft</badge>';
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
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModelDetailTestimoni" data-id="<?php echo "$id_web_testimoni"; ?>">
                                            <i class="bi bi-info-circle"></i> Detail
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModelEditTestimoni" data-id="<?php echo "$id_web_testimoni"; ?>">
                                            <i class="bi bi-pencil"></i> Edit Konten
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahStatus" data-id="<?php echo "$id_web_testimoni"; ?>">
                                            <i class="bi bi-tag"></i> Ubah Status
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahFoto" data-id="<?php echo "$id_web_testimoni"; ?>">
                                            <i class="bi bi-image"></i> Ubah Foto
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModelHapusTestimoni" data-id="<?php echo "$id_web_testimoni"; ?>">
                                            <i class="bi bi-x"></i> Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <b>
                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModelDetailTestimoni" data-id="<?php echo "$id_web_testimoni"; ?>">
                                            <?php echo "$no. $nama"; ?>
                                        </a>
                                    </b>
                                </div>
                                <div class="col-md-4">
                                    <div class="row mb-3">
                                        <div class="col col-md-4">
                                            <small>Email</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo $email; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col col-md-4">
                                            <small>Datetime</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo "$DatetimeFormat"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row mb-3">
                                        <div class="col col-md-4">
                                            <small>Penilaian</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <?php 
                                                    for ($i = 1; $i <= $penilaian; $i++) {
                                                        echo '<i class="bi bi-star-fill text-warning"></i>';
                                                    }
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col col-md-4">
                                            <small>Testimoni</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo "$testimoni"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row mb-3">
                                        <div class="col col-md-4">
                                            <small>Sumber</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo "$sumber"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col col-md-4">
                                            <small>Status</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <?php echo "$status"; ?>
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