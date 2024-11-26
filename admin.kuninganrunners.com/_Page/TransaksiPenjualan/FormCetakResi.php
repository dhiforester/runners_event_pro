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
            echo '                  Kode Transaksi Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $kode_transaksi=$_POST['kode_transaksi'];
            //Bersihkan Data
            $kode_transaksi=validateAndSanitizeInput($kode_transaksi);
            //Buka Data
            $kode_transaksi_validasi=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kode_transaksi');
            if(empty($kode_transaksi_validasi)){
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
                $id_transaksi_pengiriman=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'id_transaksi_pengiriman');
                $no_resi=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'no_resi');
                if(empty($id_transaksi_pengiriman)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12">';
                    echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                    echo '          <small class="credit">';
                    echo '              <code class="text-dark">';
                    echo '                  Data Pengiriman Belum Ada, Silahkan Lengkapi Terlebih Dulu Data Pengiriman Transaksi ini';
                    echo '              </code>';
                    echo '          </small>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    if(empty($no_resi)){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-12">';
                        echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                        echo '          <small class="credit">';
                        echo '              <code class="text-dark">';
                        echo '                  Data Pengiriman Tersebut Belum Memiliki Nomor Resi!';
                        echo '              </code>';
                        echo '          </small>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
?>
                <input type="hidden" name="id" value="<?php echo $kode_transaksi; ?>">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <small>Nomor Resi</small>
                    </div>
                    <div class="col-md-8">
                        <small>
                            <code class="text text-grayish"><?php echo $no_resi; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <small>Kode Transaksi</small>
                    </div>
                    <div class="col-md-8">
                        <small>
                            <code class="text text-grayish"><?php echo $kode_transaksi; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <small>
                            <label for="format">Format Cetak</label>
                        </small>
                    </div>
                    <div class="col-md-8">
                        <select name="format" id="format" class="form-control">
                            <option value="HTML">HTML</option>
                            <option value="PDF">PDF</option>
                        </select>
                    </div>
                </div>
<?php
                    }
                }
            }
        }
    }
?>