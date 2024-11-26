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
        if(empty($_POST['kode_transaksi'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  Kode transaksi tidak boleh kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $kode_transaksi=$_POST['kode_transaksi'];
            $datetime=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'datetime');
            $strtotime1=strtotime($datetime);
            $tanggal=date('Y-m-d',$strtotime1);
            $jam=date('H:i:s',$strtotime1);
?>
                <input type="hidden" name="kode_transaksi" value="<?php echo $kode_transaksi; ?>">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="tanggal_transaksi">
                            <small>Tanggal Transaksi</small>
                        </label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-calendar-date"></i>
                            </span>
                            <input type="date" class="form-control" name="tanggal" id="tanggal_transaksi" value="<?php echo $tanggal; ?>">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="jam_transaksi">
                            <small>Jam Transaksi</small>
                        </label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-clock"></i>
                            </span>
                            <input type="time" class="form-control" name="jam" id="jam_transaksi" value="<?php echo $jam; ?>">
                        </div>
                    </div>
                </div>
<?php
        }
    }
?>
