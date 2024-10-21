<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE id_akses like '%$keyword%' OR datetime_log like '%$keyword%' OR kategori_log like '%$keyword%' OR deskripsi_log like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE $keyword_by like '%$keyword%'"));
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
    $(document).ready(function() {
        var page="<?php echo "$page"; ?>";
        var PageInfo="<?php echo "$page/$JmlHalaman"; ?>";
        $('#PutPage').val(page);
        $('#PageInfo').html(PageInfo);
    });
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext="<?php echo "$next"; ?>";
        var PageInfo="<?php echo "$next/$JmlHalaman"; ?>";
        $('#PutPage').val(valueNext);
        $('#PageInfo').html(PageInfo);
        filterAndLoadTableLogAktivitas();
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev ="<?php echo "$prev"; ?>";
        var PageInfo="<?php echo "$prev/$JmlHalaman"; ?>";
        $('#PageInfo').html(PageInfo);
        $('#PutPage').val(ValuePrev);
        filterAndLoadTableLogAktivitas();
    });
    //Kondisi Checkbox
    // Ketika checkbox dengan class "check_all" dicentang atau di-uncheck
    $('.check_all').change(function() {
        // Mengambil status dari checkbox "check_all"
        var checked = $(this).prop('checked');

        // Mencentang atau meng-uncheck semua checkbox dengan class "check_item" sesuai status dari "check_all"
        $('.check_item').prop('checked', checked);
    });
    
    // Jika semua checkbox individu di-check secara manual, maka checkbox "check_all" juga harus dicentang
    $('.check_item').change(function() {
        // Jika semua checkbox individu dicentang
        if ($('.check_item:checked').length == $('.check_item').length) {
            // Mencentang checkbox "check_all"
            $('.check_all').prop('checked', true);
        } else {
            // Jika ada checkbox individu yang tidak dicentang, maka checkbox "check_all" harus di-uncheck
            $('.check_all').prop('checked', false);
        }
    });
    //Kondisi Ketika Modal Hapus Log Aktivitas Muncul
    $('#ModalHapusItemLog').on('show.bs.modal', function (e) {
        var FormTabelAktivitasUmum = $('#FormTabelAktivitasUmum').serialize();
        $('#FormHapusItemLog').html('Loading...');
        $('#NotifikasiHapusItemLog').html('');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Aktivitas/FormHapusItemLog.php',
            data 	    :  FormTabelAktivitasUmum,
            success     : function(data){
                $('#FormHapusItemLog').html(data);
            }
        });
    });
</script>
<div class="card-body">
    <form action="javascript:void(0);" id="FormTabelAktivitasUmum">
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-items-center mb-0">
                        <thead class="">
                            <tr>
                                <th class="text-center">
                                    <input type="checkbox" class="form-check-input check_all" name="CheckAll">
                                </th>
                                <th class="text-center">
                                    <b>No</b>
                                </th>
                                <th class="text-center">
                                    <b>User Akses</b>
                                </th>
                                <th class="text-center">
                                    <b>Datetime</b>
                                </th>
                                <th class="text-center">
                                    <b>Kategori</b>
                                </th>
                                <th class="text-center">
                                    <b>Deskripsi</b>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(empty($jml_data)){
                                    echo '<tr>';
                                    echo '  <td colspan="6" class="text-center text-danger">';
                                    echo '      Tidak Ada Data Log Yang Ditampilkan';
                                    echo '  </td>';
                                    echo '</tr>';
                                }else{
                                    $no = 1+$posisi;
                                    //KONDISI PENGATURAN MASING FILTER
                                    if(empty($keyword_by)){
                                        if(empty($keyword)){
                                            $query = mysqli_query($Conn, "SELECT*FROM log ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                        }else{
                                            $query = mysqli_query($Conn, "SELECT*FROM log WHERE id_akses like '%$keyword%' OR datetime_log like '%$keyword%' OR kategori_log like '%$keyword%' OR deskripsi_log like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                        }
                                    }else{
                                        if(empty($keyword)){
                                            $query = mysqli_query($Conn, "SELECT*FROM log ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                        }else{
                                            $query = mysqli_query($Conn, "SELECT*FROM log WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                        }
                                    }
                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_log= $data['id_log'];
                                        $id_akses= $data['id_akses'];
                                        $datetime_log= $data['datetime_log'];
                                        $kategori_log= $data['kategori_log'];
                                        $deskripsi_log= $data['deskripsi_log'];
                                        //Buka data akses
                                        $QryAkses=mysqli_query($Conn,"SELECT * FROM akses WHERE id_akses='$id_akses'")or die(mysqli_error($Conn));
                                        $DataAkses=mysqli_fetch_array($QryAkses);
                                        if(empty($DataAkses['nama_akses'])){
                                            $nama_akses='<span class="text-danger">None</span>';
                                        }else{
                                            $nama_akses=$DataAkses['nama_akses'];
                                            $nama_akses='<span class="text-dark">'.$nama_akses.'</span>';
                                        }
                                        //Mengubah format tanggal
                                        $datetime_log=strtotime($datetime_log);
                                        $datetime_log=date('d/m/Y H:i:s T', $datetime_log);
                                ?>
                            <tr>
                                <td class="text-center text-xs">
                                    <input type="checkbox" class="form-check-input check_item" name="CheckLogItem[]" value="<?php echo $id_log; ?>">
                                </td>
                                <td class="text-center text-xs">
                                    <small><?php echo "$no" ?></small>
                                </td>
                                <td class="text-left" align="left">
                                    <small class="credit">
                                        <?php echo "$nama_akses" ?>
                                    </small>
                                </td>
                                <td class="text-left" align="left">
                                    <?php 
                                        echo "<small>$datetime_log</small>";
                                    ?>
                                </td>
                                <td class="text-left" align="left">
                                    <?php 
                                        echo "<small>$kategori_log</small>";
                                    ?>
                                </td>
                                <td class="text-left" align="left">
                                    <?php 
                                        echo "<small>$deskripsi_log</small>";
                                    ?>
                                </td>
                            </tr>
                            <?php
                                $no++; }}
                            ?>
                        </tbody>
                    </table>
                </div>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalHapusItemLog" class="btn btn-sm btn-outline-danger mt-2">
                    <i class="bi bi-trash"></i> Hapus
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="btn-group shadow-0" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-md btn-info" id="PrevPage">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button type="button" class="btn btn-md btn-outline-info" id="PageInfo">
                        ...
                    </button>
                    <button type="button" class="btn btn-md btn-info" id="NextPage">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>