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
        if(empty($_POST['id_event_assesment'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Assesment Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_event_assesment=$_POST['id_event_assesment'];
            //Bersihkan Data
            $id_event_assesment=validateAndSanitizeInput($id_event_assesment);
            //Buka Data
            $id_event_assesment_valid=GetDetailData($Conn,'event_assesment','id_event_assesment',$id_event_assesment,'id_event_assesment');
            if(empty($id_event_assesment_valid)){
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
                $id_event_assesment_form=GetDetailData($Conn,'event_assesment','id_event_assesment',$id_event_assesment,'id_event_assesment_form');
                $id_event_peserta=GetDetailData($Conn,'event_assesment','id_event_assesment',$id_event_assesment,'id_event_peserta');
                $ValueForm=GetDetailData($Conn,'event_assesment','id_event_assesment',$id_event_assesment,'assesment_value');
                $status_assesment=GetDetailData($Conn,'event_assesment','id_event_assesment',$id_event_assesment,'status_assesment');
                //Detail Form
                $form_name=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'form_name');
                $form_type=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'form_type');
                $mandatori=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'mandatori');
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
?>
        <input type="hidden" name="id_event_assesment" value="<?php echo "$id_event_assesment"; ?>">
        <div class="row mb-3">
            <div class="col col-md-4"><small class="credit">Form Name</small></div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish"><?php echo "$form_name"; ?></code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4"><small class="credit">Form Type</small></div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish"><?php echo "$form_type"; ?></code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4"><small class="credit">Value</small></div>
            <div class="col col-md-8">
                <small class="credit">
                    <?php echo "$ValueForm"; ?>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4"><small class="credit">Status</small></div>
            <div class="col col-md-8">
                <small class="credit">
                    <?php echo "$status"; ?>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4"><small class="credit">Komentar</small></div>
            <div class="col col-md-8">
                <small class="credit">
                    <?php echo "$komentar"; ?>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-12">
                <small class="text text-primary">
                    Apakah anda yakin akan menghapus data tersebut?
                </small>
            </div>
        </div>
<?php
            }
        }
    }
?>