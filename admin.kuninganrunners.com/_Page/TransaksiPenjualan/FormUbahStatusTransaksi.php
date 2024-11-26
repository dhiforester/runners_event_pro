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
            $status=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'status');
?>
                <input type="hidden" name="kode_transaksi" value="<?php echo $kode_transaksi; ?>">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="status_transaksi">
                            <small>Status Transaksi</small>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="status_transaksi" id="status_transaksi_1" value="Menunggu" <?php if($status=="Menunggu"){echo "checked";} ?>>
                            <label class="form-check-label" for="status_transaksi_1">
                                <small>
                                    Menunggu Validasi<br>
                                    <code class="text text-grayish">
                                        Transaksi menunggu konfirmasi hasil validasi dari admin. 
                                        Pada status ini maka member belum bisa melakukan pembayaran dan menyelesaikan transaksi.
                                    </code>
                                </small>
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="status_transaksi" id="status_transaksi_2" value="Pending" <?php if($status=="Pending"){echo "checked";} ?>>
                            <label class="form-check-label" for="status_transaksi_2">
                                <small>
                                    Pending (Menunggu Pembayaran)<br>
                                    <code class="text text-grayish">
                                        Transaksi menunggu konfirmasi hasil validasi dari admin. 
                                        Pada status ini maka member belum bisa melakukan pembayaran dan menyelesaikan transaksi. 
                                        Namun, member masih mungkin melakukan pembatalan.
                                    </code>
                                </small>
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="status_transaksi" id="status_transaksi_3" value="Lunas" <?php if($status=="Lunas"){echo "checked";} ?>>
                            <label class="form-check-label" for="status_transaksi_3">
                                <small>
                                    Lunas<br>
                                    <code class="text text-grayish">
                                        Transaksi telah selesai dan member telah melakukan pembayaran. 
                                        Pada status ini member tidak bisa lagi mengubah atau membatalkan transaksi kecuali oleh admin.
                                    </code>
                                </small>
                            </label>
                        </div>
                    </div>
                </div>
<?php
        }
    }
?>
