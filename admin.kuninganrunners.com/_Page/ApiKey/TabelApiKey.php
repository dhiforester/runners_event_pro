<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_api_key"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_api_key WHERE datetime_creat like '%$keyword%' OR datetime_update like '%$keyword%' OR title_api_key like '%$keyword%' OR description_api_key like '%$keyword%' OR user_key_server like '%$keyword%' OR password_server like '%$keyword%' OR status like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_api_key"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_api_key WHERE $keyword_by like '%$keyword%'"));
        }
    }
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/ApiKey/TabelApiKey.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#MenampilkanTabelApiKey').html(data);
                $('#page').val(valueNext);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/ApiKey/TabelApiKey.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#MenampilkanTabelApiKey').html(data);
                $('#page').val(ValuePrev);
            }
        })
    });
</script>
<div class="card-body">
    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-items-center mb-0">
                    <thead class="">
                        <tr>
                            <th class="text-center">
                                <b>No</b>
                            </th>
                            <th class="text-center">
                                <b>Dibuat</b>
                            </th>
                            <th class="text-center">
                                <b>Update</b>
                            </th>
                            <th class="text-center">
                                <b>Nama</b>
                            </th>
                            <th class="text-center">
                                <b>User Key</b>
                            </th>
                            <th class="text-center">
                                <b>Data Log</b>
                            </th>
                            <th class="text-center">
                                <b>Status</b>
                            </th>
                            <th class="text-center">
                                <b>Opsi</b>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
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
                                    $datetime_creat_tanggal=date('d/m/y',$strtotime1);
                                    $datetime_creat_jam=date('H:i:s T',$strtotime1);
                                    $datetime_update_tanggal=date('d/m/y',$strtotime2);
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
                                    <tr>
                                        <td class="text-center text-xs">
                                            <?php echo "$no" ?>
                                        </td>
                                        <td class="text-left text-xs" align="left">
                                            <small class="credit">
                                                <code class="text-dark">
                                                    <?php 
                                                        echo 'Tgl: '.$datetime_creat_tanggal.'';
                                                    ?>
                                                </code><br>
                                                <code class="text text-grayish">
                                                    <?php 
                                                        echo 'Jam: '.$datetime_creat_jam.'';
                                                    ?>
                                                </code>
                                            </small>
                                        </td>
                                        <td class="text-left text-xs" align="left">
                                            <small class="credit">
                                                <code class="text-dark">
                                                    <?php 
                                                        echo 'Tgl: '.$datetime_update_tanggal.'';
                                                    ?>
                                                </code><br>
                                                <code class="text text-grayish">
                                                    <?php 
                                                        echo 'Jam: '.$datetime_update_jam.'';
                                                    ?>
                                                </code>
                                            </small>
                                        </td>
                                        <td class="text-left" align="left">
                                            <small class="credit">
                                                <code class="text-dark">
                                                    <?php 
                                                        echo ''.$title_api_key.'';
                                                    ?>
                                                </code>
                                            </small>
                                        </td>
                                        <td class="text-left" align="left">
                                            <small class="credit">
                                                <code class="text-dark">
                                                    <?php 
                                                        echo ''.$user_key_server.'';
                                                    ?>
                                                </code><br>
                                                <code class="text text-grayish">
                                                    <?php echo "Lmt Sn: $limit_session ms ($menit min)"; ?>
                                                </code>
                                            </small>
                                        </td>
                                        <td class="text-left" align="left">
                                            <small class="credit">
                                                <?php 
                                                    echo '<code class="text-dark">Log: '.$JumlahLog.' Rcd</code><br>';
                                                    echo '<code class="text-grayish">Sn: '.$JumlahSession.' Rcd</code>';
                                                ?>
                                            </small>
                                        </td>
                                        <td class="text-center" align="center">
                                            <?php
                                                if($status=="Aktif"){
                                                    echo '<span class="badge badge-sm bg-success">Active</span>';
                                                }else{
                                                    echo '<span class="badge badge-sm bg-danger">None</span>';
                                                }
                                            ?>
                                        </td>
                                        <td align="center">
                                            <a class="btn btn-sm btn-outline-grayish" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
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
                                                        <i class="bi bi-pencil"></i> Ubah Informasi
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditPasswordApiKey" data-id="<?php echo "$id_setting_api_key"; ?>">
                                                        <i class="bi bi-pencil"></i> Ubah Password
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
                                        </td>
                                    </tr>
                        <?php
                                    $no++; 
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card-footer text-center">
    <div class="row mb-3">
        <div class="col-md-12 text-center">
            <div class="btn-group shadow-0" role="group" aria-label="Basic example">
                <?php
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
                <button class="btn btn-md btn-info" id="PrevPage" value="<?php echo $prev;?>">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="btn btn-md btn-outline-info">
                    <?php echo "$page/$JmlHalaman"; ?>
                </button>
                <button class="btn btn-md btn-info" id="NextPage" value="<?php echo $next;?>">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>