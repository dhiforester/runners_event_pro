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
                        $Qry = $Conn->prepare("SELECT id_event_assesment, assesment_value, status_assesment FROM event_assesment WHERE id_event_assesment_form = ? AND id_event_peserta = ?");
                        if ($Qry === false) {
                            $ValueForm='<code class="text-danger">Query Preparation Failed: '.$Conn->error.'</code>';
                            $id_event_assesment="";
                            $status_assesment="";
                            $status='<code class="text-danger">None</code>';
                            $komentar='<code class="text-danger">None</code>';
                        }
                        // Bind parameter
                        $Qry->bind_param("ss", $id_event_assesment_form, $id_event_peserta);
                        // Eksekusi query
                        if (!$Qry->execute()) {
                            $ValueForm='<code class="text-danger">Query Execution Failed: '.$Conn->error.'</code>';
                            $id_event_assesment="";
                            $status_assesment="";
                            $status='<code class="text-danger">None</code>';
                            $komentar='<code class="text-danger">None</code>';
                        }
                        // Mengambil hasil
                        $Result = $Qry->get_result();
                        $Data = $Result->fetch_assoc();
                        // Menutup statement
                        $Qry->close();
                        // Mengembalikan hasil
                        if (empty($Data['id_event_assesment'])) {
                            $id_event_assesment="";
                            $status_assesment="";
                            $ValueForm='<code class="text-danger">None (Tidak Ada)</code>';
                            $status='<code class="text-danger">None</code>';
                            $komentar='<code class="text-danger">None</code>';
                        } else {
                            $id_event_assesment=$Data['id_event_assesment'];
                            $status_assesment=$Data['status_assesment'];
                            $ValueForm=$Data['assesment_value'];
                            
                            //Apabila tipe form adalah checkbox
                            if($form_type=="checkbox"){
                                $arrayValues = json_decode($ValueForm, true);
                                $ValueForm = implode(", ", $arrayValues);
                                $ValueForm='<code class="text text-grayish">'.$ValueForm.'</code>';
                            }else{
                                if($form_type=="file_foto"){
                                    $file_path ="assets/img/Assesment/$ValueForm";
                                    $ValueForm='<a href="'.$file_path.'" target="_blank"><code class="text text-success">'.$ValueForm.'</code></a>';
                                }else{
                                    if($form_type=="file_pdf"){
                                        $file_path ="assets/img/Assesment/$ValueForm";
                                        $ValueForm='<a href="'.$file_path.'" target="_blank"><code class="text text-success">'.$ValueForm.'</code></a>';
                                    }else{
                                        $ValueForm='<code class="text text-grayish">'.$ValueForm.'</code>';
                                    }
                                }
                            }
                            //Menguraikan Status
                            $status_assesment_array = json_decode($status_assesment, true);
                            $status=$status_assesment_array['status_assesment'];
                            $komentar=$status_assesment_array['komentar'];
                            if($status=="Pending"){
                                $status='<code class="text-warning">Pending</code>';
                            }else{
                                if($status=="Refisi"){
                                    $status='<code class="text-danger">Refisi</code>';
                                }else{
                                    $status='<code class="text-success">Valid</code>';
                                }
                            }
                            if(empty($komentar)){
                                $komentar='<code class="text-grayish">Tidak Ada</code>';
                            }else{
                                $komentar='<code class="text-grayish">'.$komentar.'</code>';
                            }
                            
                        }
?>
                        <div class="list-group-item list-group-item-action" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                                <span class="mb-1 text-dark"><?php echo "$no. $form_name"; ?></span>
                                <small>
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                        <li class="dropdown-header text-start">
                                            <h6>Option</h6>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahAssesmentPeserta" data-id="<?php echo "$id_event_peserta,$id_event_assesment_form"; ?>">
                                                <i class="bi bi-pencil"></i> Edit Manual
                                            </a>
                                        </li>
                                        <?php
                                            if(!empty($id_event_assesment)){
                                                echo '<li>';
                                                echo '  <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailAssesmentPeserta" data-id="'.$id_event_assesment.'">';
                                                echo '      <i class="bi bi-info-circle"></i> Detail';
                                                echo '  </a>';
                                                echo '</li>';
                                                echo '<li>';
                                                echo '  <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalStatusAssesmentPeserta" data-id="'.$id_event_assesment.'">';
                                                echo '      <i class="bi bi-check-circle"></i> Status & Komentar';
                                                echo '  </a>';
                                                echo '</li>';
                                                echo '<li>';
                                                echo '  <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusAssesmentPeserta" data-id="'.$id_event_assesment.'">';
                                                echo '      <i class="bi bi-trash"></i> Hapus';
                                                echo '  </a>';
                                                echo '</li>';
                                            }
                                        ?>
                                    </ul>
                                </small>
                            </div>
                            <ul>
                                <li>
                                    <small>Value : <code class="text text-grayish"><?php echo "$ValueForm"; ?></code></small>
                                </li>
                                <li>
                                    <small>
                                        Status : <?php echo "$status"; ?>
                                    </small>
                                </li>
                                <li>
                                    <small>
                                        Komentar : <?php echo "$komentar"; ?>
                                    </small>
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