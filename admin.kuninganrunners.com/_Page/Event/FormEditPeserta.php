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
            <div class="col-md-12">
                <label for="kategori_event_edit">
                    <small>Kategori Event</small>
                </label>
                <select name="kategori_event" id="kategori_event_edit" class="form-control">
                    <?php
                        echo '<option value="">Pilih</option>';
                        $query = mysqli_query($Conn, "SELECT id_event_kategori, kategori FROM event_kategori WHERE id_event='$id_event'");
                        while ($data = mysqli_fetch_array($query)) {
                            $IdEventKategori= $data['id_event_kategori'];
                            $kategori= $data['kategori'];
                            if($IdEventKategori==$id_event_kategori){
                                echo '<option selected value="'.$IdEventKategori.'">'.$kategori.'</option>';
                            }else{
                                echo '<option value="'.$IdEventKategori.'">'.$kategori.'</option>';
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="status_pembayaran_edit">
                    <small>Status Pembayaran</small>
                </label>
                <select name="status_pembayaran" id="status_pembayaran_edit" class="form-control">
                    <option <?php if($status==""){echo "selected";} ?> value="">Pilih</option>
                    <option <?php if($status=="Lunas"){echo "selected";} ?> value="Lunas">Lunas</option>
                    <option <?php if($status=="Pending"){echo "selected";} ?> value="Pending">Pending</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <small>
                    Pastikan data peserta yang anda input sudah sesuai.
                </small>
            </div>
        </div>
<?php
            }
        }
    }
?>