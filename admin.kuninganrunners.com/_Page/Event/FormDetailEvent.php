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
                $tanggal_mulai=GetDetailData($Conn,'event','id_event',$id_event,'tanggal_mulai');
                $tanggal_selesai=GetDetailData($Conn,'event','id_event',$id_event,'tanggal_selesai');
                $mulai_pendaftaran=GetDetailData($Conn,'event','id_event',$id_event,'mulai_pendaftaran');
                $selesai_pendaftaran=GetDetailData($Conn,'event','id_event',$id_event,'selesai_pendaftaran');
                $nama_event=GetDetailData($Conn,'event','id_event',$id_event,'nama_event');
                $keterangan=GetDetailData($Conn,'event','id_event',$id_event,'keterangan');
                $poster=GetDetailData($Conn,'event','id_event',$id_event,'poster');
                $rute=GetDetailData($Conn,'event','id_event',$id_event,'rute');
                //format Data
                $strtotime1=strtotime($tanggal_mulai);
                $strtotime2=strtotime($tanggal_selesai);
                $strtotime3=strtotime($mulai_pendaftaran);
                $strtotime4=strtotime($selesai_pendaftaran);
                $tanggal_mulai_format=date('d M Y H:i',$strtotime1);
                $tanggal_selesai_format=date('d M Y H:i',$strtotime2);
                $mulai_pendaftaran_format=date('d M Y H:i',$strtotime3);
                $selesai_pendaftaran_format=date('d M Y H:i',$strtotime4);
                if($now<$tanggal_mulai){
                    $LabelStatus='<code class="text text-warning">Coming Soon</code>';
                }else{
                    if($now>$tanggal_selesai){
                        $LabelStatus='<code class="text text-danger">Expired</code>';
                    }else{
                        $LabelStatus='<code class="text text-success">Ongoing</code>';
                    }
                }
?>
        <input type="hidden" name="Page" value="Event">
        <input type="hidden" name="Sub" value="DetailEvent">
        <input type="hidden" name="id" value="<?php echo $id_event; ?>">
        <div class="row mb-3">
            <div class="col col-md-4"><small class="credit">Nama Event</small></div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish"><?php echo "$nama_event"; ?></code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4 mb-3"><small class="credit">Keterangan</small></div>
            <div class="col col-md-8 mb-3">
                <small class="credit">
                    <code class="text text-grayish"><?php echo "$keterangan"; ?></code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4 mb-3"><small class="credit">Mulai Event</small></div>
            <div class="col col-md-8 mb-3">
                <small class="credit">
                    <code class="text text-grayish"><?php echo "$tanggal_mulai_format"; ?></code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4 mb-3"><small class="credit">Selesai Event</small></div>
            <div class="col col-md-8 mb-3">
                <small class="credit">
                    <code class="text text-grayish"><?php echo "$tanggal_selesai_format"; ?></code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4 mb-3"><small class="credit">Mulai Pendaftaran</small></div>
            <div class="col col-md-8 mb-3">
                <small class="credit">
                    <code class="text text-grayish"><?php echo "$mulai_pendaftaran_format"; ?></code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4 mb-3"><small class="credit">Selesai Pendaftaran</small></div>
            <div class="col col-md-8 mb-3">
                <small class="credit">
                    <code class="text text-grayish"><?php echo "$selesai_pendaftaran_format"; ?></code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4 mb-3"><small class="credit">Status</small></div>
            <div class="col col-md-8 mb-3">
                <small class="credit">
                    <?php echo "$LabelStatus"; ?>
                </small>
            </div>
        </div>
<?php
            }
        }
    }
?>