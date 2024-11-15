<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";
    //Validasi Kelengkapan Data
    if (empty($SessionIdAkses)) {
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Ulang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    } else {
        if (empty($_POST['id_event_peserta'])) {
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12 text-center">';
            echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Event Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        } else {
            $id_event = validateAndSanitizeInput($_POST['id_event_peserta']);
            // Validasi apakah data event ada di database
            $id_event_validasi = GetDetailData($Conn, 'event', 'id_event', $id_event, 'id_event');
            if (empty($id_event_validasi)) {
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12 text-center">';
                echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
                echo '          <small class="credit">';
                echo '              <code class="text-dark">';
                echo '                  Data Yang Anda Pilih Tidak Ditemukan Pada Database!';
                echo '              </code>';
                echo '          </small>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
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
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12 text-center">';
                    echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
                    echo '          <small class="credit">';
                    echo '              <code class="text-dark">';
                    echo '                  Belum ada peserta untuk event ini.';
                    echo '              </code>';
                    echo '          </small>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else {
?>
                <script>
                    //ketika klik NextPagePeserta
                    $('#NextPagePeserta').click(function() {
                        var page=$('#NextPagePeserta').val();
                        $('#page_peserta').val(page);
                        ShowPesertaEvent();
                    });
                    //Ketika klik PrevPagePeserta
                    $('#PrevPagePeserta').click(function() {
                        var page = $('#PrevPagePeserta').val();
                        $('#page_peserta').val(page);
                        ShowPesertaEvent();
                    });
                </script>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="list-group">
                            <?php
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
                            ?>
                                <div class="list-group-item list-group-item-action" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between">
                                        <span class="mb-1 text-dark">
                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailPeserta" data-id="<?php echo "$id_event_peserta"; ?>">
                                                <?php echo "$no. $nama"; ?>
                                            </a>
                                        </span>
                                        <small>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                                <li class="dropdown-header text-start">
                                                    <h6>Option</h6>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailPeserta" data-id="<?php echo "$id_event_peserta"; ?>">
                                                        <i class="bi bi-info-circle"></i> Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditPeserta" data-id="<?php echo "$id_event_peserta"; ?>">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusPeserta" data-id="<?php echo "$id_event_peserta"; ?>">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </a>
                                                </li>
                                            </ul>
                                        </small>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row mb-3">
                                                <div class="col col-md-4">
                                                    <small>Email</small>
                                                </div>
                                                <div class="col col-md-8">
                                                    <small>
                                                        <code class="text text-grayish"><?php echo "$email"; ?></code>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col col-md-4">
                                                    <small>Tgl.Daftar</small>
                                                </div>
                                                <div class="col col-md-8">
                                                    <small>
                                                        <code class="text text-grayish"><?php echo "$TanggalDaftar"; ?></code>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row mb-3">
                                                <div class="col col-md-4">
                                                    <small>Kategori</small>
                                                </div>
                                                <div class="col col-md-8">
                                                    <small>
                                                        <code class="text text-grayish"><?php echo "$kategori"; ?></code>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col col-md-4">
                                                    <small>Biaya</small>
                                                </div>
                                                <div class="col col-md-8">
                                                    <small>
                                                        <code class="text text-grayish"><?php echo "$biaya_pendaftaran_format"; ?></code>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row mb-3">
                                                <div class="col col-md-4">
                                                    <small>Transaksi</small>
                                                </div>
                                                <div class="col col-md-8">
                                                    <small>
                                                        <code class="text text-grayish"><?php echo "$JumlahRiwayatTransaksi Record"; ?></code>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col col-md-4">
                                                    <small>Status</small>
                                                </div>
                                                <div class="col col-md-8">
                                                    <small>
                                                        <?php
                                                            if($status=="Lunas"){
                                                                echo '<code class="text-success">Lunas</code>';
                                                            }else{
                                                                echo '<code class="text-danger">Pending</code>';
                                                            }
                                                        ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                                    $no++;
                                } 
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12 text-center">
                        <div class="btn-group shadow-0" role="group" aria-label="Basic example">
                            <button class="btn btn-md btn-grayish" id="PrevPagePeserta" value="<?php echo $prev;?>">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button class="btn btn-md btn-outline-grayish">
                                <?php echo "$page of $JmlHalaman"; ?>
                            </button>
                            <button class="btn btn-md btn-grayish" id="NextPagePeserta" value="<?php echo $next;?>">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
<?php
                }
            }
        }
    }
?>
