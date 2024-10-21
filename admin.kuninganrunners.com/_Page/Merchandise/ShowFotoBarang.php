<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

    if (empty($SessionIdAkses)) {
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
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
        if (empty($_POST['id_barang'])) {
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Barang Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        } else {
            $id_barang = validateAndSanitizeInput($_POST['id_barang']);
            // Validasi apakah data event ada di database
            $id_barang_validasi = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'id_barang');

            if (empty($id_barang_validasi)) {
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
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
                $foto = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'foto');
                $foto_path = __DIR__ . "/../../assets/img/Marchandise/" . basename($foto);
                $foto_url = "$base_url/assets/img/Marchandise/" . basename($foto);

                // Pastikan file foto ada dan merupakan file yang aman untuk ditampilkan
                if (!file_exists($foto_path)) {
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12">';
                    echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
                    echo '          <small class="credit">';
                    echo '              <code class="text-dark">';
                    echo '                  Foto tidak ditemukan pada directory yang dimaksud: ' . htmlspecialchars($foto_path) . '';
                    echo '              </code>';
                    echo '          </small>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                } else {
                    if (in_array(pathinfo($foto_path, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif'])) {
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-12 text-center">';
                        echo '      <img src="' . htmlspecialchars($foto_url) . '" alt="Foto Barang" class="rounded-circle" width="200px">';
                        echo '  </div>';
                        echo '</div>';
                    } else {
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-12">';
                        echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
                        echo '          <small class="credit">';
                        echo '              <code class="text-dark">';
                        echo '                  Foto memiliki format tidak didukung.';
                        echo '              </code>';
                        echo '          </small>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    }
                }
            }
        }
    }
?>
