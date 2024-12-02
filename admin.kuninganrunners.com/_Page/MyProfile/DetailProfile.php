<?php
    date_default_timezone_set('Asia/Jakarta');
    //Membuka Detail Akses
    $nama=GetDetailData($Conn,'akses','id_akses',$SessionIdAkses,'nama_akses');
    $kontak=GetDetailData($Conn,'akses','id_akses',$SessionIdAkses,'kontak_akses');
    $email=GetDetailData($Conn,'akses','id_akses',$SessionIdAkses,'email_akses');
    $gambar=GetDetailData($Conn,'akses','id_akses',$SessionIdAkses,'image_akses');
    $akses=GetDetailData($Conn,'akses','id_akses',$SessionIdAkses,'akses');
    $datetime_daftar=GetDetailData($Conn,'akses','id_akses',$SessionIdAkses,'datetime_daftar');
    $datetime_update=GetDetailData($Conn,'akses','id_akses',$SessionIdAkses,'datetime_update');
    $rules=GetDetailData($Conn,'akses','id_akses',$SessionIdAkses,'rules');
    if(empty($gambar)){
        $gambar="No-Image.png";
    }
    $strtotime=strtotime($datetime_update);
    $UpdateTime=date('d/m/Y H:i T',$strtotime);
?>
<div class="row mb-3">
    <div class="col-md-12">
        <?php
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
            echo '  <small class="modal-text">';
            echo '      Berikut ini adalah halaman profil pengguna. Hanya anda yang bisa melihat informasi pada halaman ini.<br>';
            echo '      Anda bisa mengelola informasi profil, mengubah foto dan password anda sendiri.';
            echo '      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '  </small>';
            echo '</div>';
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header text-center">
                <b class="card-title">
                    <i class="bi bi-info-circle"></i> Informasi Pengguna
                </b>
            </div>
            <div class="card-body">
                <div class="row mb-3 border-1 border-bottom">
                    <div class="col-md-12 mb-3 text-center">
                        <img src="assets/img/User/<?php echo "$SessionGambar"; ?>" alt="" width="180px" height="180px" class="rounded-circle">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-6">Nama</div>
                    <div class="col col-md-6">
                        <small class="credit">
                            <code class="text text-grayish"><?php echo "$nama"; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-6">Email</div>
                    <div class="col col-md-6">
                        <small class="credit">
                            <code class="text text-grayish"><?php echo "$email"; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-6">Kontak</div>
                    <div class="col col-md-6">
                        <small class="credit">
                            <code class="text text-grayish"><?php echo "$kontak"; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-6">Akses</div>
                    <div class="col col-md-6">
                        <small class="credit">
                            <code class="text text-grayish"><?php echo "$akses"; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-6 mb-3">Last Update</div>
                    <div class="col col-md-6 mb-3">
                        <small class="credit">
                            <code class="text text-grayish"><?php echo "$UpdateTime"; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-12">
                        <div class="list-group">
                            <button type="button" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#ModalUbahFotoProfil">
                                <i class="bi bi-image"></i> Ubah Foto
                            </button>
                            <button type="button" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#ModalUbahInformasiProfil">
                                <i class="bi bi-person-circle"></i> Ubah Profil
                            </button>
                            <button type="button" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#ModalUbahPassword">
                                <i class="bi bi-key"></i> Ubah Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 mb-3">
        <div class="card">
            <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered border-1 border-bottom" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview" aria-selected="true" role="tab">
                            Rules
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit" aria-selected="false" role="tab" tabindex="-1">
                            Aktivitas
                        </button>
                    </li>
                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade profile-overview active show" id="profile-overview" role="tabpanel">
                        <div class="row mt-3">
                            <?php
                                $NoKategori=1;
                                $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM akses_fitur ORDER BY kategori ASC");
                                while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                                    $kategori= $DataKategori['kategori'];
                                    echo '<div class="col-md-4">';
                                    echo '  <b>'.$NoKategori.'. '.$kategori.'</b>';
                                    echo '  <ul>';
                                    $NoFitur=1;
                                    $QryFitur = mysqli_query($Conn, "SELECT * FROM akses_fitur WHERE kategori='$kategori' ORDER BY nama ASC");
                                    while ($DataFitur = mysqli_fetch_array($QryFitur)) {
                                        $KodeFitur= $DataFitur['kode'];
                                        $NamaFitur= $DataFitur['nama'];
                                        $KeteranganFitur= $DataFitur['keterangan'];
                                        //Cek Apakah User Memiliki Akses Ke halaman Ini
                                        $array_rules=json_decode($rules, true);
                                        $CekIjinAkses=IjinAksesSaya($Conn,$SessionIdAkses,$KodeFitur);
                                        if($CekIjinAkses=="Ada"){
                                            $LabelIjinAkses='<span class="text-success"><i class="bi bi-check"></i></span>';
                                            echo '<li>';
                                            echo '  <small>'.$NamaFitur.'</small>';
                                            echo '  '.$LabelIjinAkses.'';
                                            echo '</li>';
                                        }else{
                                            $LabelIjinAkses='<span class="text-dark"><i class="bi bi-x"></i></span>';
                                            echo '<li>';
                                            echo '  <small class="text text-grayish">'.$NamaFitur.'</small>';
                                            echo '</li>';
                                        }
                                        $NoFitur++;
                                    }
                                    echo '</ul>';
                                    echo '</div>';
                                    $NoKategori++;
                                }
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit" role="tabpanel">
                        <!-- Menampilkan Tabel Aktivitas -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <?php
                                    echo '<div class="alert alert-warning  alert-dismissible fade show" role="alert">';
                                    echo '  Berikut ini adalah halaman yang menampilkan data aktivitas penggunaan aplikasi.<br>';
                                    echo '  Anda bisa mengirimkan laporan ketika anda menemukan aktivitas mencurigakan.';
                                    echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                                    echo '</div>';
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                <a class="btn btn-md btn-outline-dark btn-rounded w-100" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalFilterAktivitas">
                                    <i class="bi bi-filter"></i> Filter
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" id="MenampilkanTabelAktivitas">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                
            </div>
        </div>
    </div>
</div>