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
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_medsos FROM web_medsos"));
        //Apabila Tidak Ada Data Peserta
        if (empty($jml_data)) {
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12 text-center">';
            echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  Belum ada konten media sosial yang bisa ditampilkan.';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else {
?>
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="list-group">
                    <?php
                        $no = 1;
                        $query = mysqli_query($Conn, "SELECT*FROM web_medsos ORDER BY id_web_medsos DESC");
                        while ($data = mysqli_fetch_array($query)) {
                            $id_web_medsos= $data['id_web_medsos'];
                            $nama_medsos= $data['nama_medsos'];
                            $url_medsos= $data['url_medsos'];
                            $logo= $data['logo'];
                    ?>
                        <div class="list-group-item list-group-item-action" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                                <span class="mb-1 text-dark">
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailMedsos" data-id="<?php echo "$id_web_medsos"; ?>">
                                        <small>
                                            <?php echo "$no. $nama_medsos"; ?>
                                        </small>
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
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailMedsos" data-id="<?php echo "$id_web_medsos"; ?>">
                                                <i class="bi bi-info-circle"></i> Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditMedsos" data-id="<?php echo "$id_web_medsos"; ?>">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusMedsos" data-id="<?php echo "$id_web_medsos"; ?>">
                                                <i class="bi bi-trash"></i> Hapus
                                            </a>
                                        </li>
                                    </ul>
                                </small>
                            </div>
                            <small>
                                <code class="text text-grayish"><?php echo "$url_medsos"; ?></code>
                            </small>
                        </div>
                    <?php 
                            $no++;
                        } 
                    ?>
                </div>
            </div>
        </div>
<?php
        }
    }
?>
