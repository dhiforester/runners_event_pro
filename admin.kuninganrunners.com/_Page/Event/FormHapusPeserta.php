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
                $id_event_kategori=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event_kategori');
                $nama=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'nama');
                $email=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'email');
                $datetime=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'datetime');
                $status=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'status');
                //Format Tanggal
                $strtotime=strtotime($datetime);
                $TanggalDaftar=date('d/m/Y H:i', $strtotime);
                //Buka Kategori
                $kategori=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'kategori');
?>
        <input type="hidden" name="id_event_peserta" value="<?php echo $id_event_peserta; ?>">
        <div class="row mb-3">
            <div class="col col-md-4"><small class="credit">Nama Peserta</small></div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish"><?php echo "$nama"; ?></code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4"><small class="credit">Email</small></div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish"><?php echo "$email"; ?></code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4"><small class="credit">Tgl.Daftar</small></div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish"><?php echo "$TanggalDaftar"; ?></code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4"><small class="credit">Status</small></div>
            <div class="col col-md-8">
                <small class="credit">
                    <?php
                        if($status=="Lunas"){
                            echo '<code class="text-success">Lunas</code>';
                        }else{
                            echo '<code class="text-danger">Pending</code>';
                        }
                    ?>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-12">
                <small class="credit">Apakah anda yakin akan menghapus data ini?</small>
            </div>
        </div>
<?php
            }
        }
    }
?>