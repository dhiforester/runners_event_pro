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
        if(empty($_POST['id_event_kategori'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Kategori Event Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_event_kategori=$_POST['id_event_kategori'];
            //Bersihkan Data
            $id_event_kategori=validateAndSanitizeInput($id_event_kategori);
            //Buka Data
            $id_event_kategori_validasi=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'id_event_kategori');
            if(empty($id_event_kategori_validasi)){
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
                $kategori=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'kategori');
                $deskripsi=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'deskripsi');
                $biaya_pendaftaran=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'biaya_pendaftaran');
                if(empty($biaya_pendaftaran)){
                    $biaya_pendaftaran=0;
                }
                $biaya_pendaftaran_format='Rp ' . number_format($biaya_pendaftaran, 2, ',', '.');
                $DeskripsiLength=strlen($deskripsi);
                if($DeskripsiLength>20){
                    $deskripsi= substr($deskripsi, 0, 20) . '...';
                }
                $JumlahPeserta = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_peserta FROM event_peserta WHERE id_event_kategori='$id_event_kategori' AND status='Lunas'"));
?>
        <input type="hidden" name="id_event_kategori" value="<?php echo $id_event_kategori; ?>">
        <input type="hidden" id="JumlahPeserta" value="<?php echo $JumlahPeserta; ?>">
        <div class="row mb-3">
            <div class="col col-md-4"><small class="credit">Kategori</small></div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish"><?php echo "$kategori"; ?></code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4"><small class="credit">Biaya Pendaftaran</small></div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish"><?php echo "$biaya_pendaftaran_format"; ?></code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4"><small class="credit">Keterangan/Deskripsi</small></div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish"><?php echo "$deskripsi"; ?></code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-12">
                <?php
                    if(empty($JumlahPeserta)){
                        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                        echo '  <small>';
                        echo '      <code class="text-dark">';
                        echo '          Apakah anda yakin akan menghapus kategori event tersebut?';
                        echo '      </code>';
                        echo '  </small>';
                        echo '</div>';
                    }else{
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        echo '  <small>';
                        echo '      <code class="text-dark">';
                        echo '          Kategori event tersebut sudah memiliki data peserta. Anda tidak bisa menghapus kategori event secara langsung,';
                        echo '          silahkan kelola peserta yang sudah ada tersebut pada tab peserta.';
                        echo '      </code>';
                        echo '  </small>';
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
<?php
            }
        }
    }
?>