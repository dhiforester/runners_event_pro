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
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_faq FROM web_faq"));
        //Apabila Tidak Ada Data Peserta
        if (empty($jml_data)) {
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12 text-center">';
            echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  Belum ada konten FAQ yang bisa ditampilkan.';
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
                        $query = mysqli_query($Conn, "SELECT*FROM web_faq ORDER BY urutan ASC");
                        while ($data = mysqli_fetch_array($query)) {
                            $id_web_faq= $data['id_web_faq'];
                            $urutan= $data['urutan'];
                            $pertanyaan= $data['pertanyaan'];
                            $jawaban= $data['jawaban'];
                            // if (strlen($pertanyaan) > 30) {
                            //     $pertanyaan = substr($pertanyaan, 0, 30) . '...';
                            // }
                            if (strlen($jawaban) > 30) {
                                $jawaban = substr($jawaban, 0, 30) . '...';
                            }
                            //Mencari Nilai Terbesar
                            $query_max = "SELECT MAX(urutan) AS max_urutan FROM web_faq";
                            $result_max = mysqli_query($Conn, $query_max);
                            $row_max = mysqli_fetch_assoc($result_max);
                            $UrutanMax = $row_max['max_urutan'];
                            //Mencari Nilai Terkecil
                            $query_min = "SELECT MIN(urutan) AS min_urutan FROM web_faq";
                            $result_min = mysqli_query($Conn, $query_min);
                            $row_min= mysqli_fetch_assoc($result_min);
                            $UrutanMin = $row_min['min_urutan'];
                    ?>
                        <div class="list-group-item list-group-item-action" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                                <span class="mb-1 text-dark">
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailFaq" data-id="<?php echo "$id_web_faq"; ?>">
                                        <small>
                                            <?php echo "$urutan. $pertanyaan"; ?>
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
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailFaq" data-id="<?php echo "$id_web_faq"; ?>">
                                                <i class="bi bi-info-circle"></i> Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditFaq" data-id="<?php echo "$id_web_faq"; ?>">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusFaq" data-id="<?php echo "$id_web_faq"; ?>">
                                                <i class="bi bi-trash"></i> Hapus
                                            </a>
                                        </li>
                                        <?php
                                            if($UrutanMin!==$urutan){
                                                echo '<li>';
                                                echo '  <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalTurunNaik" data-id="Naik-'.$id_web_faq.'">';
                                                echo '      <i class="bi bi-arrow-up"></i> Naik';
                                                echo '  </a>';
                                                echo '</li>';
                                            }
                                            if($UrutanMax!==$urutan){
                                                echo '<li>';
                                                echo '  <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalTurunNaik" data-id="Turun-'.$id_web_faq.'">';
                                                echo '      <i class="bi bi-arrow-down"></i> Turun';
                                                echo '  </a>';
                                                echo '</li>';
                                            }
                                        ?>
                                    </ul>
                                </small>
                            </div>
                            <small>
                                <code class="text text-grayish"><?php echo "$jawaban"; ?></code>
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
