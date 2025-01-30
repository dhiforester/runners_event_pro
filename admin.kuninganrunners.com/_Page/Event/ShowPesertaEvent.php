<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

    //Inisiasi Halaman
    $prev="";
    $next="";
    $page="";
    $JmlHalaman="";
    //Validasi Kelengkapan Data
    if (empty($SessionIdAkses)) {
        echo '
            <tr>
                <td colspan="8" class="text-center">
                    Sesi Akses Sudah Berakhir, Silahkan Login Ulang!
                </td>
            </tr>
        ';
    } else {
        if (empty($_POST['id_event_peserta'])) {
            echo '
                <tr>
                    <td colspan="8" class="text-center">
                        ID Event Tidak Boleh Kosong!
                    </td>
                </tr>
            ';
        } else {
            $id_event = validateAndSanitizeInput($_POST['id_event_peserta']);
            // Validasi apakah data event ada di database
            $id_event_validasi = GetDetailData($Conn, 'event', 'id_event', $id_event, 'id_event');
            if (empty($id_event_validasi)) {
                echo '
                    <tr>
                        <td colspan="8" class="text-center">
                            Data Yang Anda Pilih Tidak Ditemukan Pada Database!
                        </td>
                    </tr>
                ';
            } else {
                //Keyword_by
                if(!empty($_POST['KeywordByPeserta'])){
                    $keyword_by=$_POST['KeywordByPeserta'];
                }else{
                    $keyword_by="";
                }
                //keyword
                if(!empty($_POST['keyword_peserta'])){
                    $keyword=$_POST['keyword_peserta'];
                }else{
                    $keyword="";
                }
                //batas
                if(!empty($_POST['batas_peserta'])){
                    $batas=$_POST['batas_peserta'];
                }else{
                    $batas="10";
                }
                //ShortBy
                if(!empty($_POST['ShortByPeserta'])){
                    $ShortBy=$_POST['ShortByPeserta'];
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
                if(!empty($_POST['OrderByPeserta'])){
                    $OrderBy=$_POST['OrderByPeserta'];
                }else{
                    $OrderBy="datetime";
                }
                //Atur Page
                if(!empty($_POST['page_peserta'])){
                    $page=$_POST['page_peserta'];
                    $posisi = ( $page - 1 ) * $batas;
                }else{
                    $page="1";
                    $posisi = 0;
                }
                if(empty($keyword_by)){
                    if(empty($keyword)){
                        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_peserta FROM event_peserta WHERE id_event='$id_event'"));
                    }else{
                        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_peserta FROM event_peserta WHERE (id_event='$id_event') AND (nama like '%$keyword%' OR email like '%$keyword%' OR datetime like '%$keyword%' OR status like '%$keyword%')"));
                    }
                }else{
                    if(empty($keyword)){
                        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_peserta FROM event_peserta WHERE id_event='$id_event'"));
                    }else{
                        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_peserta FROM event_peserta WHERE (id_event='$id_event') AND ($keyword_by like '%$keyword%')"));
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
                //Apabila Tidak Ada Data Peserta
                if (empty($jml_data)) {
                    echo '
                        <tr>
                            <td colspan="8" class="text-center">
                                Data Peserta Tidak Ditemukan!
                            </td>
                        </tr>
                    ';
                }else {
                    $no = 1+$posisi;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($keyword_by)){
                        if(empty($keyword)){
                            $query = mysqli_query($Conn, "SELECT*FROM event_peserta WHERE id_event='$id_event' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM event_peserta WHERE (id_event='$id_event') AND (nama like '%$keyword%' OR datetime like '%$keyword%' OR kode_sertifikat like '%$keyword%' OR status like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                    }else{
                        if(empty($keyword)){
                            $query = mysqli_query($Conn, "SELECT*FROM event_peserta WHERE id_event='$id_event' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM event_peserta WHERE (id_event='$id_event') AND ($keyword_by like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_event_peserta= $data['id_event_peserta'];
                        $id_event_kategori= $data['id_event_kategori'];
                        $id_member= $data['id_member'];
                        $nama= $data['nama'];
                        $email= $data['email'];
                        $biaya_pendaftaran= $data['biaya_pendaftaran'];
                        $datetime= $data['datetime'];
                        $status= $data['status'];
                        //Format Tanggal
                        $strtotime=strtotime($datetime);
                        $TanggalDaftar=date('d/m/Y H:i', $strtotime);
                        //Buka Kategori
                        $kategori=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'kategori');
                        //Biaya Pendaftaran
                        $biaya_pendaftaran_format='Rp ' . number_format($biaya_pendaftaran, 2, ',', '.');
                        //Jumlah Riwayat Transaksi
                        $JumlahRiwayatTransaksi = mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi WHERE kode_transaksi='$id_event_peserta' AND kategori='Pendaftaran'"));
                        //Sensor Email Peserta
                        $email_sensor=SensorEmail($email);
                        //Buka Kontak Member
                        $kontak=GetDetailData($Conn,'member','id_member',$id_member,'kontak');
                        //Sensor Kontak Jika Ada
                        if(!empty($kontak)){
                            $sensor_kontak=SensorKontak($kontak);
                        }else{
                            $sensor_kontak="-";
                        }
                        //Hitung Assesment
                        $JumlahAssesment = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_assesment FROM event_assesment WHERE id_event_peserta='$id_event_peserta'"));
                        $shortened_id = '***' . substr($id_event_peserta, 0, 5);
                        //Routing status label
                        if($status=="Lunas"){
                            $LabelStatus='<code class="text-success">Lunas</code>';
                        }else{
                            $LabelStatus='<code class="text-danger">Pending</code>';
                        }
                        echo '
                            <tr>
                                <td class="text-left"><small>'.$shortened_id.'</small></td>
                                <td class="text-left"><small>'.$TanggalDaftar.'</small></td>
                                <td class="text-left">
                                    <small>
                                        <a href="javascript:void(0);" class="text text-decoration-underline" data-bs-toggle="modal" data-bs-target="#ModalDetailPeserta" data-id="'.$id_event_peserta.'">
                                            '.$nama.'
                                        </a>
                                    </small>
                                </td>
                                <td class="text-left"><small>'.$email_sensor.'</small></td>
                                <td class="text-left"><small>'.$sensor_kontak.'</small></td>
                                <td class="text-left"><small>'.$kategori.'</small></td>
                                <td class="text-left"><small>'.$LabelStatus.'</small></td>
                                <td class="text-left">
                                    <small>
                                        <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                            <li class="dropdown-header text-start">
                                                <h6>Option</h6>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailPeserta" data-id="'.$id_event_peserta.'">
                                                    <i class="bi bi-info-circle"></i> Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditPeserta" data-id="'.$id_event_peserta.'">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusPeserta" data-id="'.$id_event_peserta.'">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </a>
                                            </li>
                                        </ul>
                                    </small>
                                </td>
                            </tr>
                        ';
                        $no++;
                    } 
                }
            }
        }
    }
?>
<script>
    var next="<?php echo $next; ?>";
    var prev="<?php echo $prev; ?>";
    var halaman="<?php echo $JmlHalaman; ?>";
    var page="<?php echo $page; ?>";
    //Tempelkan Ke Tombol Halaman
    $('#PrevPagePeserta').val(prev);
    $('#NextPagePeserta').val(next);
    $('#PageButtonPeserta').html(''+page+'/'+halaman+'');
    // Disable prev button if on the first page
    if (page == 1) {
        $('#PrevPagePeserta').prop('disabled', true);
    }else{
        $('#PrevPagePeserta').prop('disabled', false);
    }

    // Disable next button if on the last page
    if (page == halaman) {
        $('#NextPagePeserta').prop('disabled', true);
    }else{
        $('#NextPagePeserta').prop('disabled', false);
    }
</script>
