<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    date_default_timezone_set("Asia/Jakarta");
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
        $OrderBy="id_akses_fitur";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_fitur"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_fitur WHERE kategori like '%$keyword%' OR nama like '%$keyword%' OR kode like '%$keyword%' OR keterangan like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_fitur"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_fitur WHERE $keyword_by like '%$keyword%'"));
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
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/AksesFitur/TabelAksesFitur.php",
            method  : "POST",
            data 	:  { page: page, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#MenampilkanTabelFitur').html(data);
                $('#page').val(page);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var page = $('#PrevPage').val();
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/AksesFitur/TabelAksesFitur.php",
            method  : "POST",
            data 	:  { page: page, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#MenampilkanTabelFitur').html(data);
                $('#page').val(page);
            }
        })
    });
</script>
<div class="row mb-3">
    <div class="col-md-4">
        <small class="credit">
            Halaman : <code class="text-grayish"><?php echo "$page/$JmlHalaman"; ?></code>
        </small><br>
        <small class="credit">
            Row : <code class="text-grayish"><?php echo "$jml_data Record"; ?></code>
        </small>
    </div>
</div>
<div class="row mb-3">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <td align="center"><b>No</b></td>
                    <td align="center"><b>Kategori</b></td>
                    <td align="center"><b>Nama Fitur</b></td>
                    <td align="center"><b>Keterangan</b></td>
                    <td align="center"><b>Kode</b></td>
                    <td align="center"><b>Akses</b></td>
                    <td align="center"><b>Option</b></td>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="7" class="text-center">';
                        echo '      <code class="text-danger">';
                        echo '          Tidak Ada Data Fitur Yang Dapat Ditampilkan';
                        echo '      </code>';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($keyword_by)){
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM akses_fitur ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM akses_fitur WHERE kategori like '%$keyword%' OR nama like '%$keyword%' OR kode like '%$keyword%' OR keterangan like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }else{
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM akses_fitur ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM akses_fitur WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_akses_fitur= $data['id_akses_fitur'];
                            $kategori= $data['kategori'];
                            $nama= $data['nama'];
                            $kode= $data['kode'];
                            $keterangan= $data['keterangan'];
                            //Jumlah Pengguna
                            $JumlahPengguna =mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses FROM akses_ijin WHERE id_akses_fitur='$id_akses_fitur'"));
                ?>
                            <tr>
                                <td align="center"><?php echo $no; ?></td>
                                <td align="left"><?php echo $kategori; ?></td>
                                <td align="left"><?php echo $nama; ?></td>
                                <td align="left"><?php echo $keterangan; ?></td>
                                <td align="left">
                                    <code class="text-grayish"><?php echo $kode; ?></code>
                                </td>
                                <td align="right"><?php echo "$JumlahPengguna Orang"; ?></td>
                                <td align="center">
                                    <a class="btn btn-sm btn-outline-dark btn-rounded" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                        <li class="dropdown-header text-start">
                                            <h6>Option</h6>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditFitur" data-id="<?php echo "$id_akses_fitur"; ?>">
                                                <i class="bi bi-pencil"></i> Edit Fitur
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusFitur" data-id="<?php echo "$id_akses_fitur"; ?>">
                                                <i class="bi bi-x"></i> Hapus Fitur
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
<div class="row mt-5">
    <div class="col-md-12 text-center">
        <div class="btn-group shadow-0" role="group" aria-label="Basic example">
            <button class="btn btn-sm btn-info" id="PrevPage" value="<?php echo $prev;?>">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button class="btn btn-sm btn-outline-info">
                <?php echo "$page of $JmlHalaman"; ?>
            </button>
            <button class="btn btn-sm btn-info" id="NextPage" value="<?php echo $next;?>">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
</div>