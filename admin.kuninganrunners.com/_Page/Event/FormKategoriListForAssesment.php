<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Uang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_event'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Event Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_event=$_POST['id_event'];
            //Bersihkan Data
            $id_event=validateAndSanitizeInput($id_event);
            //Buka Data
            $id_event_validasi=GetDetailData($Conn,'event','id_event',$id_event,'id_event');
            if(empty($id_event_validasi)){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                echo '          <small class="credit">';
                echo '              <code class="text-dark">';
                echo '                  Data Yang Anda Pilih Tidak Ditemukan Pada Database!';
                echo '              </code>';
                echo '          </small>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_kategori FROM event_kategori WHERE id_event='$id_event'"));
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <label for="list_kategori_assesment"><small>Pilih Kategori Event</small></label>';
                //Apabila Tidak Ada Kategori Untuk Event Ini
                if(empty($jml_data)){
                    echo '<div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                    echo '  <small class="credit">';
                    echo '      Tidak Ada Kategori Untuk Event Ini.';
                    echo '  </small>';
                    echo '</div>';
                }else{
                    //Buka List Kategori
                    $query = mysqli_query($Conn, "SELECT id_event_kategori, kategori FROM event_kategori WHERE id_event='$id_event'");
                    while ($data = mysqli_fetch_array($query)) {
                        $id_event_kategori= $data['id_event_kategori'];
                        $kategori= $data['kategori'];
                        echo '<div class="form-check">';
                        echo '  <input class="form-check-input" type="checkbox" id="list_kategori_assesment'.$id_event_kategori.'" name="list_kategori_assesment[]" value="'.$id_event_kategori.'">';
                        echo '  <label class="form-check-label" for="list_kategori_assesment'.$id_event_kategori.'">';
                        echo '      <small>'.$kategori.'</small>';
                        echo '  </label>';
                        echo '</div>';
                    }
                }
                echo '  </div>';
                echo '</div>';
            }
        }
    }
?>