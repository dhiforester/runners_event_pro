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
        if(empty($_POST['id_event_peserta'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Peserta Event Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_event_peserta=$_POST['id_event_peserta'];
            //Bersihkan Data
            $id_event_peserta=validateAndSanitizeInput($id_event_peserta);
            //Buka Data
            $id_event_peserta_validasi=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event_peserta');
            if(empty($id_event_peserta_validasi)){
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
                $id_event=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event');
                //Jumlah Assesment Form
                $JumlahAssesmentForm = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_assesment_form FROM event_assesment_form WHERE id_event='$id_event'"));
                if(empty($JumlahAssesmentForm)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12">';
                    echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                    echo '          <small class="credit">';
                    echo '              <code class="text-dark">';
                    echo '                  Tidak Ada Assesment Form Untuk Event Ini';
                    echo '              </code>';
                    echo '          </small>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    echo '<div class="row mt-4 mb-3">';
                    echo '  <div class="col-md-12">';
                    echo '      <div class="list-group">';
                    $no=1;
                    $QryAssesmentForm = mysqli_query($Conn, "SELECT*FROM event_assesment_form WHERE id_event='$id_event' ORDER BY form_name ASC");
                    while ($DataAssesmentForm = mysqli_fetch_array($QryAssesmentForm)) {
                        $id_event_assesment_form= $DataAssesmentForm['id_event_assesment_form'];
                        $form_name= $DataAssesmentForm['form_name'];
                        $form_type= $DataAssesmentForm['form_type'];
                        $mandatori= $DataAssesmentForm['mandatori'];
                        $alternatif= $DataAssesmentForm['alternatif'];
                        $komentar= $DataAssesmentForm['komentar'];
                        //Membuka Nilai
                        $Qry = $Conn->prepare("SELECT assesment_value FROM event_assesment WHERE id_event_assesment_form = ? AND id_event_peserta = ?");
                        if ($Qry === false) {
                            $ValueForm="Query Preparation Failed: " . $Conn->error;
                        }
                        // Bind parameter
                        $Qry->bind_param("ss", $id_event_assesment_form, $id_event_peserta);
                        // Eksekusi query
                        if (!$Qry->execute()) {
                            $ValueForm="Query Execution Failed: " . $Qry->error;
                        }
                        // Mengambil hasil
                        $Result = $Qry->get_result();
                        $Data = $Result->fetch_assoc();
                        // Menutup statement
                        $Qry->close();
                        // Mengembalikan hasil
                        if (empty($Data['assesment_value'])) {
                            $ValueForm="None (Tidak Ada)";
                        } else {
                            $ValueForm=$Data['assesment_value'];
                        }
?>
                        <div class="list-group-item list-group-item-action" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                                <span class="mb-1 text-dark"><?php echo "$no. $form_name"; ?></span>
                                <small>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#ModalUbahAssesmentPeserta" data-id="<?php echo "$id_event_peserta,$id_event_assesment_form"; ?>">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </small>
                            </div>
                            <ul>
                                <li class="mb-2">
                                    <small>Form Type : <code class="text text-grayish"><?php echo "$form_type"; ?></code></small>
                                </li>
                                <li class="mb-2">
                                    <small>Mandatori : <code class="text text-grayish"><?php echo "$mandatori"; ?></code></small>
                                </li>
                                <li class="mb-2">
                                    <small>Value : <code class="text text-grayish"><?php echo "$ValueForm"; ?></code></small>
                                </li>
                            </ul>
                        </div>
<?php
                        $no++;
                    }
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }
            }
        }
    }
?>