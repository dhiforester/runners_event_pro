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
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_assesment_form FROM event_assesment_form WHERE id_event='$id_event'"));
                //Apabila Tidak Ada Data Peserta
                if (empty($jml_data)) {
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12 text-center">';
                    echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
                    echo '          <small class="credit">';
                    echo '              <code class="text-dark">';
                    echo '                  Belum ada form assesment untuk event ini.';
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
                                $query = mysqli_query($Conn, "SELECT*FROM event_assesment_form WHERE id_event='$id_event' ORDER BY form_name ASC");
                                while ($data = mysqli_fetch_array($query)) {
                                    $id_event_assesment_form= $data['id_event_assesment_form'];
                                    $form_name= $data['form_name'];
                                    $form_type= $data['form_type'];
                                    $mandatori= $data['mandatori'];
                                    $komentar= $data['komentar'];
                                    $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_assesment_form FROM event_assesment WHERE id_event_assesment_form='$id_event_assesment_form'"));
                            ?>
                                <div class="list-group-item list-group-item-action" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between">
                                        <span class="mb-1 text-dark">
                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailAssesmentForm" data-id="<?php echo "$id_event_assesment_form"; ?>">
                                                <?php echo "$no. $form_name"; ?>
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
                                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailAssesmentForm" data-id="<?php echo "$id_event_assesment_form"; ?>">
                                                        <i class="bi bi-info-circle"></i> Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditAssesmentForm" data-id="<?php echo "$id_event_assesment_form"; ?>">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusAssesmentForm" data-id="<?php echo "$id_event_assesment_form"; ?>">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </a>
                                                </li>
                                            </ul>
                                        </small>
                                    </div>
                                    <ul>
                                        <li>
                                            <small>Form Name : <code class="text text-grayish"><?php echo "$form_name"; ?></code></small>
                                        </li>
                                        <li>
                                            <small>Form Type : <code class="text text-grayish"><?php echo "$form_type"; ?></code></small>
                                        </li>
                                        <li>
                                            <small>Data : <code class="text text-grayish"><?php echo "$JumlahData Record"; ?></code></small>
                                        </li>
                                    </ul>
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
        }
    }
?>
