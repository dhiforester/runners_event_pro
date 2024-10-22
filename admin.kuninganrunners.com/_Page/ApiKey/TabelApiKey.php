<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    //Validasi akses
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
        }else{
            $ShortBy="DESC";
        }
        //OrderBy
        if(!empty($_POST['OrderBy'])){
            $OrderBy=$_POST['OrderBy'];
        }else{
            $OrderBy="id_setting_api_key";
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
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_setting_api_key FROM setting_api_key"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_setting_api_key FROM setting_api_key WHERE datetime_creat like '%$keyword%' OR datetime_update like '%$keyword%' OR title_api_key like '%$keyword%' OR description_api_key like '%$keyword%' OR user_key_server like '%$keyword%' OR password_server like '%$keyword%' OR status like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_setting_api_key FROM setting_api_key"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_setting_api_key FROM setting_api_key WHERE $keyword_by like '%$keyword%'"));
            }
        }
        //Mengatur Halaman
        $JmlHalaman = ceil($jml_data/$batas); 
        $JmlHalaman_real = ceil($jml_data/$batas); 
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
            var valueNext=$('#NextPage').val();
            $('#page').val(valueNext);
            filterAndLoadTable();
        });
        //Ketika klik Previous
        $('#PrevPage').click(function() {
            var ValuePrev = $('#PrevPage').val();
            $('#page').val(ValuePrev);
            filterAndLoadTable();
        });
    </script>
    <?php
        if(empty($jml_data)){
            echo '<tr>';
            echo '  <td colspan="8">';
            echo '      <span class="text-danger">Belum Ada Data Yang Bisa Ditampilkan</span>';
            echo '  </td>';
            echo '</tr>';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM setting_api_key ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM setting_api_key WHERE datetime_creat like '%$keyword%' OR datetime_update like '%$keyword%' OR title_api_key like '%$keyword%' OR description_api_key like '%$keyword%' OR user_key_server like '%$keyword%' OR password_server like '%$keyword%' OR status like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM setting_api_key ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM setting_api_key WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_setting_api_key= $data['id_setting_api_key'];
                $datetime_creat= $data['datetime_creat'];
                $datetime_update= $data['datetime_update'];
                $title_api_key= $data['title_api_key'];
                $description_api_key= $data['description_api_key'];
                $user_key_server= $data['user_key_server'];
                $password_server= $data['password_server'];
                $status= $data['status'];
                //Format Tanggal
                $strtotime1=strtotime($datetime_creat);
                $strtotime2=strtotime($datetime_update);
                $datetime_creat_tanggal=date('d/m/y H:i',$strtotime1);
                $datetime_creat_jam=date('H:i:s T',$strtotime1);
                $datetime_update_tanggal=date('d/m/y H:i',$strtotime2);
                $datetime_update_jam=date('H:i:s T',$strtotime2);
                //Menghitung Jumlah Log
                $JumlahLog = mysqli_num_rows(mysqli_query($Conn, "SELECT id_log_api FROM log_api WHERE id_setting_api_key='$id_setting_api_key'"));
                $JumlahLog=number_format($JumlahLog, 0, ',', '.');
                //Menghitung Jumlah Session
                $JumlahSession = mysqli_num_rows(mysqli_query($Conn, "SELECT id_api_session FROM api_session WHERE id_setting_api_key='$id_setting_api_key'"));
                $JumlahSession=number_format($JumlahSession, 0, ',', '.');
                //Limit Session
                if(!empty($data['limit_session'])){
                    $limit_session= $data['limit_session'];
                    $detik=$limit_session/1000;
                    $menit=$detik/60;
                    $menit=round($menit,2);
                }else{
                    $limit_session=0;
                    $detik=0;
                    $menit=0;
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
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailInformasiApiKey" data-id="<?php echo "$id_setting_api_key"; ?>">
                                        <i class="bi bi-info-circle"></i> Detail API Key
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditInformasiApiKey" data-id="<?php echo "$id_setting_api_key"; ?>">
                                        <i class="bi bi-pencil"></i> Edit API Key
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditPasswordApiKey" data-id="<?php echo "$id_setting_api_key"; ?>">
                                        <i class="bi bi-key"></i> Ubah Password
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusApiKey" data-id="<?php echo "$id_setting_api_key"; ?>">
                                        <i class="bi bi-x"></i> Hapus
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalLogApiKey" data-id="<?php echo "$id_setting_api_key"; ?>">
                                        <i class="bi bi-table"></i> Log Record
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailInformasiApiKey" data-id="<?php echo "$id_setting_api_key"; ?>">
                                    <b>
                                        <?php 
                                            echo ''.$no.'. '.$title_api_key.'';
                                        ?>
                                    </b>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col col-md-4">
                                        <small>Datetime Creat</small>
                                    </div>
                                    <div class="col col-md-8">
                                        <small>
                                            <code class="text text-grayish"><?php echo ''.$datetime_creat_tanggal.''; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-md-4">
                                        <small>Updatetime</small>
                                    </div>
                                    <div class="col col-md-8">
                                        <small>
                                            <code class="text text-grayish"><?php echo ''.$datetime_update_tanggal.''; ?></code>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col col-md-4">
                                        <small>Log Request</small>
                                    </div>
                                    <div class="col col-md-8">
                                        <small>
                                            <?php 
                                                echo '<code class="text-grayish">'.$JumlahLog.' Rcd</code>';
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-md-4">
                                        <small>Session</small>
                                    </div>
                                    <div class="col col-md-8">
                                        <small>
                                            <?php 
                                                echo '<code class="text-grayish">'.$JumlahSession.' Rcd</code>';
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col col-md-4">
                                        <small>Time Limit</small>
                                    </div>
                                    <div class="col col-md-8">
                                        <small>
                                            <code class="text text-grayish"><?php echo "$menit min"; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col col-md-4">
                                        <small>Status</small>
                                    </div>
                                    <div class="col col-md-8">
                                        <small>
                                            <?php
                                                if($status=="Aktif"){
                                                    echo '<code class="text text-success"><i class="bi bi-check-circle"></i> Active</code>';
                                                }else{
                                                    echo '<code class="text text-danger"><i class="bi bi-x-circle"></i> No Active</code>';
                                                }
                                            ?>
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
            <div class="btn-group">
                <button class="btn btn-md btn-grayish" id="PrevPage" value="<?php echo $prev;?>">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="btn btn-md btn-outline-grayish">
                    <?php echo "$page/$JmlHalaman"; ?>
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