<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Sesi Login Sudah Berakhir, Silahkan Login Ulang';
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
            $OrderBy="id_log";
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
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE id_akses='$SessionIdAkses'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE (id_akses='$SessionIdAkses') AND (datetime_log like '%$keyword%' OR kategori_log like '%$keyword%' OR deskripsi_log like '%$keyword%')"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE id_akses='$SessionIdAkses'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE (id_akses='$SessionIdAkses') AND ($keyword_by like '%$keyword%')"));
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
    $('#NextPageAktivitas').click(function() {
        var valueNext=$('#NextPageAktivitas').val();
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/MyProfile/TabelAktivitas.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#MenampilkanTabelAktivitas').html(data);
                $('#PageFilterAktivitas').val(valueNext);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPageAktivitas').click(function() {
        var ValuePrev = $('#PrevPageAktivitas').val();
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/MyProfile/TabelAktivitas.php",
            method  : "POST",
            data 	:  { page: ValuePrev, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#MenampilkanTabelAktivitas').html(data);
                $('#PageFilterAktivitas').val(valueNext);
            }
        })
    });
</script>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover align-items-center mb-0">
                <thead class="">
                    <tr>
                        <th class="text-center">
                            <b>No</b>
                        </th>
                        <th class="text-center">
                            <b>Tanggal</b>
                        </th>
                        <th class="text-center">
                            <b>Keterangan</b>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($jml_data)){
                            echo '<tr>';
                            echo '  <td colspan="3" class="text-center text-danger">';
                            echo '      Tidak Ada Data Log';
                            echo '  </td>';
                            echo '</tr>';
                        }else{
                            $no = 1+$posisi;
                            //KONDISI PENGATURAN MASING FILTER
                            if(empty($keyword_by)){
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT*FROM log WHERE id_akses='$SessionIdAkses' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM log WHERE (id_akses='$SessionIdAkses') AND (datetime_log like '%$keyword%' OR kategori_log like '%$keyword%' OR deskripsi_log like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }else{
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT*FROM log WHERE id_akses='$SessionIdAkses' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM log WHERE (id_akses='$SessionIdAkses') AND ($keyword_by like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $id_log= $data['id_log'];
                                $datetime_log= $data['datetime_log'];
                                $kategori_log= $data['kategori_log'];
                                $deskripsi_log= $data['deskripsi_log'];
                                //Mengubah format tanggal
                                $datetime_log=strtotime($datetime_log);
                                $Tanggal=date('d/m/Y', $datetime_log);
                                $Jam=date('H:i:s T', $datetime_log);
                        ?>
                    <tr>
                        <td class="text-center text-xs">
                            <small><?php echo "$no" ?></small>
                        </td>
                        <td class="text-left" align="left">
                            <small class="credit">
                                <?php 
                                    echo '<code class="text-dark">'.$Tanggal.'</code><br>';
                                    echo '<code class="text text-grayish">'.$Jam.'</code><br>';
                                ?>
                            </small>
                        </td>
                        <td class="text-left" align="left">
                            <small class="credit">
                                <?php 
                                    echo '<code class="text-dark">'.$kategori_log.'</code><br>';
                                    echo '<code class="text text-grayish">'.$deskripsi_log.'</code><br>';
                                ?>
                            </small>
                        </td>
                    </tr>
                    <?php
                        $no++; }}
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12 text-center">
        <div class="btn-group shadow-0" role="group" aria-label="Basic example">
            <button class="btn btn-md btn-info" id="PrevPageAktivitas" value="<?php echo $prev;?>">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button class="btn btn-md btn-outline-info">
                <?php echo "$page/$JmlHalaman"; ?>
            </button>
            <button class="btn btn-md btn-info" id="NextPageAktivitas" value="<?php echo $next;?>">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
</div>
<?php } ?>