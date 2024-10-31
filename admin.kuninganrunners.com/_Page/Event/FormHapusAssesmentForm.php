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
        if(empty($_POST['id_event_assesment_form'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Assesment Form Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_event_assesment_form=$_POST['id_event_assesment_form'];
            //Bersihkan Data
            $id_event_assesment_form=validateAndSanitizeInput($id_event_assesment_form);
            //Buka Data
            $id_event_assesment_form=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'id_event_assesment_form');
            if(empty($id_event_assesment_form)){
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
                $form_name=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'form_name');
                $form_type=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'form_type');
                $mandatori=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'mandatori');
                $alternatif=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'alternatif');
                $komentar=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'komentar');
                $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_assesment_form FROM event_assesment WHERE id_event_assesment_form='$id_event_assesment_form'"));
?>
        <input type="hidden" name="id_event_assesment_form" value="<?php echo $id_event_assesment_form; ?>">
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
            <div class="col col-md-4"><small class="credit">Mandatori</small></div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish"><?php echo "$mandatori"; ?></code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4"><small class="credit">Alternatif</small></div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish">
                        <?php 
                            if(empty($alternatif)){
                                echo "None";
                            }else{
                                if($alternatif!=="null"&&$alternatif!==Null){
                                    $alternatif=json_decode($alternatif, true);
                                    foreach($alternatif as $alternatif_list){
                                        $alternatif_display=$alternatif_list['display'];
                                        $alternatif_value=$alternatif_list['value'];
                                        echo "$alternatif_display($alternatif_value), ";
                                    }
                                }else{
                                    echo "None";
                                }
                            }
                        ?>
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4"><small class="credit">Komentar</small></div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish"><?php echo "$komentar"; ?></code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-12 text text-primary">
                <small>
                    Apakah anda yakin akan menghapus data ini?
                </small>
            </div>
        </div>
<?php
            }
        }
    }
?>