<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Harus Login Terlebih Dulu
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <code>Sesi Login Sudah Berakhir, Silahkan Login Ulang!</code>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_transaksi_payment'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Pembayaran Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_transaksi_payment=$_POST['id_transaksi_payment'];
            //Bersihkan Data
            $id_transaksi_payment=validateAndSanitizeInput($id_transaksi_payment);
            //Buka Data
            $id_transaksi_payment_validasi=GetDetailData($Conn,'transaksi_payment','id_transaksi_payment',$id_transaksi_payment,'id_transaksi_payment');
            if(empty($id_transaksi_payment_validasi)){
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
                $order_id=GetDetailData($Conn,'transaksi_payment','id_transaksi_payment',$id_transaksi_payment,'order_id');
                $kode_transaksi=GetDetailData($Conn,'transaksi_payment','id_transaksi_payment',$id_transaksi_payment,'kode_transaksi');
                $snap_token=GetDetailData($Conn,'transaksi_payment','id_transaksi_payment',$id_transaksi_payment,'snap_token');
                $datetime=GetDetailData($Conn,'transaksi_payment','id_transaksi_payment',$id_transaksi_payment,'datetime');
                $status=GetDetailData($Conn,'transaksi_payment','id_transaksi_payment',$id_transaksi_payment,'status');
                //format Data Tanggal Transaksi
                $strtotime1=strtotime($datetime);
                $tanggal_format=date('d M Y H:i',$strtotime1);
                //Sensor Kode Transaksi
                $last_three_kode_transaksi = substr($kode_transaksi, -5);
                $kode_transaksi = '***' . $last_three_kode_transaksi;
                //Sensor Kode Transaksi
                $last_three_kode = substr($order_id, -5);
                $masked_order_id = '***' . $last_three_kode;
                //Sensor Snap Token
                $last_three_snap = substr($snap_token, -5);
                $masked_snap = '***' . $last_three_snap;
                //Label Status
                if($status=="Lunas"){
                    $LabelStatus='<badge class="badge badge-success">Lunas</badge>';
                }else{
                    $LabelStatus='<badge class="badge badge-warning">Pending</badge>';
                }
?>
            <input type="hidden" name="id_transaksi_payment" value="<?php echo $id_transaksi_payment; ?>">
            <div class="row mb-3">
                <div class="col col-md-4"><small class="credit">Kode Transaksi</small></div>
                <div class="col col-md-8">
                    <small class="credit mobile-text">
                        <code class="text text-grayish"><?php echo "$kode_transaksi"; ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4"><small class="credit">Order ID</small></div>
                <div class="col col-md-8">
                    <small class="credit mobile-text">
                        <code class="text text-grayish"><?php echo "$masked_order_id"; ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4"><small class="credit">Snap Token</small></div>
                <div class="col col-md-8">
                    <small class="credit mobile-text">
                        <code class="text text-grayish"><?php echo "$masked_snap"; ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4"><small class="credit">Tgl/Jam</small></div>
                <div class="col col-md-8">
                    <small class="credit">
                        <code class="text text-grayish"><?php echo "$tanggal_format"; ?></code>
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
            <div class="row mb-3">
                <div class="col col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <small>
                            <b>Apakah Anda Yakin Akan Menghapus Data Ini?</b><br>
                            Menghapus data pembayaran akan menyebabkan payment gateway tidak bisa melakukan pembaharuan status pembayaran berdasarkan Order ID.
                        </small>
                    </div>
                </div>
            </div>
<?php 
            } 
        } 
    } 
?>