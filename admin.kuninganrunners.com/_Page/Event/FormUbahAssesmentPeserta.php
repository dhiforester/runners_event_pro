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
            echo '                  ID Peserta Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_event_peserta=$_POST['id_event_peserta'];
            //Pecahkan Data
            $explode=explode(',',$id_event_peserta);
            $id_event_peserta=$explode[0];
            $id_event_assesment_form=$explode[1];
            //Bersihkan Data
            $id_event_peserta=validateAndSanitizeInput($id_event_peserta);
            $id_event_assesment_form=validateAndSanitizeInput($id_event_assesment_form);
            $id_event_peserta_valid=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event_peserta');
            $id_event_assesment_form_valid=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'id_event_assesment_form');
            if(empty($id_event_peserta_valid)){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                echo '          <small class="credit">';
                echo '              <code class="text-dark">';
                echo '                  Peserta Yang Anda Pilih Tidak Ditemukan Pada Database!';
                echo '              </code>';
                echo '          </small>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                if(empty($id_event_assesment_form_valid)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12">';
                    echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                    echo '          <small class="credit">';
                    echo '              <code class="text-dark">';
                    echo '                  Form Yang Anda Pilih Tidak Ditemukan Pada Database!';
                    echo '              </code>';
                    echo '          </small>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $id_event=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event');
                    //Buka Detail Assesment Form
                    $form_name=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'form_name');
                    $form_type=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'form_type');
                    $mandatori=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'mandatori');
                    $alternatif= GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'alternatif');
                    $komentar=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'komentar');
                    echo '<input type="hidden" name="id_event_assesment_form" value="'.$id_event_assesment_form.'">';
                    echo '<input type="hidden" name="id_event_peserta" value="'.$id_event_peserta.'">';
                    echo '<input type="hidden" name="id_event" value="'.$id_event.'">';
                    echo '<input type="hidden" name="form_type" id="put_form_type" value="'.$form_type.'">';
                    //Membuka Nilai
                    $Qry = $Conn->prepare("SELECT assesment_value FROM event_assesment WHERE id_event_assesment_form = ? AND id_event_peserta = ?");
                    if ($Qry === false) {
                        $ValueForm="";
                    }
                    // Bind parameter
                    $Qry->bind_param("ss", $id_event_assesment_form, $id_event_peserta);
                    // Eksekusi query
                    if (!$Qry->execute()) {
                        $ValueForm="";
                    }
                    // Mengambil hasil
                    $Result = $Qry->get_result();
                    $Data = $Result->fetch_assoc();
                    // Menutup statement
                    $Qry->close();
                    // Mengembalikan hasil
                    if (empty($Data['assesment_value'])) {
                        $ValueForm="";
                    } else {
                        $ValueForm=$Data['assesment_value'];
                    }
                    //Menghitung Jumlah Karakter
                    $ValueFormLength=strlen($ValueForm);
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12">';
                    echo '      <label for="'.$id_event_assesment_form.'_'.$id_event_peserta.'"><small>'.$form_name.'</small></label>';
                    if($form_type=="text"){
                        echo '  <div class="input-group">';
                        echo '      <input type="text" name="'.$id_event_assesment_form.'" id="'.$id_event_assesment_form.'_'.$id_event_peserta.'" class="form-control" value="'.$ValueForm.'">';
                        echo '      <span class="input-group-text">';
                        echo '          <small>';
                        echo '              <code id="'.$id_event_assesment_form.'_length" class="text text-grayish">'.$ValueFormLength.'/100</code>';
                        echo '          </small>';
                        echo '      </span>';
                        echo '  </div>';
                    }else{
                        if($form_type=="textarea"){
                            echo '<textarea name="'.$id_event_assesment_form.'" id="'.$id_event_assesment_form.'_'.$id_event_peserta.'" class="form-control">'.$ValueForm.'</textarea>';
                            echo '<small>';
                            echo '  <code id="'.$id_event_assesment_form.'_length" class="text text-grayish">'.$ValueFormLength.'/100</code>';
                            echo '</small><br>';
                        }else{
                            if($form_type=="file_foto"){
                                echo '  <div class="input-group">';
                                echo '      <input type="file" name="'.$id_event_assesment_form.'" id="'.$id_event_assesment_form.'_'.$id_event_peserta.'" class="form-control" value="'.$ValueForm.'">';
                                echo '      <span class="input-group-text">';
                                echo '          <small>';
                                echo '              <code class="text text-grayish">Max 5 Mb</code>';
                                echo '          </small>';
                                echo '      </span>';
                                echo '  </div>';
                                echo '  <small><code class="text text-info">Tipe File JPG, JPEG, PNG dan GIF</code></small><br>';
                            }else{
                                if($form_type=="file_pdf"){
                                    echo '  <div class="input-group">';
                                    echo '      <input type="file" name="'.$id_event_assesment_form.'" id="'.$id_event_assesment_form.'_'.$id_event_peserta.'" class="form-control" value="'.$ValueForm.'">';
                                    echo '      <span class="input-group-text">';
                                    echo '          <small>';
                                    echo '              <code class="text text-grayish">Max 5 Mb</code>';
                                    echo '          </small>';
                                    echo '      </span>';
                                    echo '  </div>';
                                    echo '  <small><code class="text text-info">Tipe File PDF</code></small><br>';
                                }else{
                                    if($form_type=="select_option"){
                                        $alternatif_array=json_decode($alternatif, true);
                                        echo '  <select class="form-control" name="'.$id_event_assesment_form.'" id="'.$id_event_assesment_form.'_'.$id_event_peserta.'">';
                                        echo '      <option value="">Pilih</option>';
                                        foreach($alternatif_array as $alternatif_list){
                                            if($ValueForm==$alternatif_list['value']){
                                                echo '  <option selected value="'.$alternatif_list['value'].'">'.$alternatif_list['display'].'</option>';
                                            }else{
                                                echo '  <option value="'.$alternatif_list['value'].'">'.$alternatif_list['display'].'</option>';
                                            }
                                            
                                        }
                                        echo '';
                                        echo '  </select>';
                                    }else{
                                        if($form_type=="checkbox"){
                                            $alternatif_array=json_decode($alternatif, true);
                                            $no=1;
                                            foreach($alternatif_array as $alternatif_list){
                                                if($ValueForm==$alternatif_list['value']){
                                                    echo '<div class="form-check">';
                                                    echo '  <input class="form-check-input" checked type="checkbox" name="'.$id_event_assesment_form.'[]" id="'.$id_event_assesment_form.'_'.$id_event_peserta.'_'.$no.'" value="'.$alternatif_list['value'].'">';
                                                    echo '  <label class="form-check-label" for="'.$id_event_assesment_form.'_'.$id_event_peserta.'_'.$no.'"><small>'.$alternatif_list['display'].'</small></label>';
                                                    echo '</div>';
                                                }else{
                                                    echo '<div class="form-check">';
                                                    echo '  <input class="form-check-input" type="checkbox" name="'.$id_event_assesment_form.'[]" id="'.$id_event_assesment_form.'_'.$id_event_peserta.'_'.$no.'" value="'.$alternatif_list['value'].'">';
                                                    echo '  <label class="form-check-label" for="'.$id_event_assesment_form.'_'.$id_event_peserta.'_'.$no.'"><small>'.$alternatif_list['display'].'</small></label>';
                                                    echo '</div>';
                                                }
                                                $no++;
                                            }
                                        }else{
                                            if($form_type=="radio"){
                                                $alternatif_array=json_decode($alternatif, true);
                                                $no=1;
                                                foreach($alternatif_array as $alternatif_list){
                                                    if($ValueForm==$alternatif_list['value']){
                                                        echo '<div class="form-check">';
                                                        echo '  <input class="form-check-input" checked type="radio" name="'.$id_event_assesment_form.'" id="'.$id_event_assesment_form.'_'.$id_event_peserta.'_'.$no.'" value="'.$alternatif_list['value'].'">';
                                                        echo '  <label class="form-check-label" for="'.$id_event_assesment_form.'_'.$id_event_peserta.'_'.$no.'"><small>'.$alternatif_list['display'].'</small></label>';
                                                        echo '</div>';
                                                    }else{
                                                        echo '<div class="form-check">';
                                                        echo '  <input class="form-check-input" type="radio" name="'.$id_event_assesment_form.'" id="'.$id_event_assesment_form.'_'.$id_event_peserta.'_'.$no.'" value="'.$alternatif_list['value'].'">';
                                                        echo '  <label class="form-check-label" for="'.$id_event_assesment_form.'_'.$id_event_peserta.'_'.$no.'"><small>'.$alternatif_list['display'].'</small></label>';
                                                        echo '</div>';
                                                    }
                                                    $no++;
                                                }
                                            }else{
                                                echo "Tipe Form Tidak Diketahui";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    echo '      <small><code class="text text-grayish">'.$komentar.'</code></small>';
                    echo '  </div>';
                    echo '</div>';
                }
            }
        }
    }
?>
<script>

</script>