<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

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
        if (empty($_POST['id_event'])) {
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
            $id_event = validateAndSanitizeInput($_POST['id_event']);
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
                $JumlahKategori = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_kategori FROM event_kategori WHERE id_event='$id_event'"));
                //Apabila Tidak Ada Data Kategori
                if (empty($JumlahKategori)) {
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12 text-center">';
                    echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
                    echo '          <small class="credit">';
                    echo '              <code class="text-dark">';
                    echo '                  Belum ada kategori untuk event ini.';
                    echo '              </code>';
                    echo '          </small>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                } else {
                    echo '<div class="list-group">';
                    $no=1;
                    $QryKategori = mysqli_query($Conn, "SELECT*FROM event_kategori WHERE id_event='$id_event' ORDER BY id_event_kategori DESC");
                    while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                        $id_event_kategori= $DataKategori['id_event_kategori'];
                        $kategori= $DataKategori['kategori'];
                        $deskripsi= $DataKategori['deskripsi'];
                        $biaya_pendaftaran= $DataKategori['biaya_pendaftaran'];
                        $biaya_pendaftaran_format='Rp ' . number_format($biaya_pendaftaran, 2, ',', '.');
                        $DeskripsiLength=strlen($deskripsi);
                        if($DeskripsiLength>20){
                            $deskripsi= substr($deskripsi, 0, 20) . '...';
                        }
                        $JumlahPeserta = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_peserta FROM event_peserta WHERE id_event_kategori='$id_event_kategori' AND status='Lunas'"));
?>
                    <div class="list-group-item list-group-item-action" aria-current="true">
                        <div class="d-flex w-100 justify-content-between">
                            <span class="mb-1 text-dark"><?php echo "$no. $kategori"; ?></span>
                            <small>
                                <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                    <li class="dropdown-header text-start">
                                        <h6>Option</h6>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailKategori" data-id="<?php echo "$id_event_kategori"; ?>">
                                            <i class="bi bi-info-circle"></i> Detail
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditKategori" data-id="<?php echo "$id_event_kategori"; ?>">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusKategori" data-id="<?php echo "$id_event_kategori"; ?>">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    </li>
                                </ul>
                            </small>
                        </div>
                        <ul>
                            <li>
                                <small>
                                    Pendaftaran :
                                    <code class="text text-grayish"><?php echo "$biaya_pendaftaran_format"; ?></code>
                                </small>
                            </li>
                            <li>
                                <small>
                                    Deskripsi :
                                    <code class="text text-grayish"><?php echo "$deskripsi"; ?></code>
                                </small>
                            </li>
                            <li>
                                <small>
                                    Peserta :
                                    <code class="text text-grayish"><?php echo "$JumlahPeserta Orang"; ?></code>
                                </small>
                            </li>
                        </ul>
                    </div>
<?php
                        $no++;
                    }
                    echo '</div>';
                }
            }
        }
    }
?>
