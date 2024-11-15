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
            $id_transaksi_validasi=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kode_transaksi');
            if(empty($id_transaksi_validasi)){
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
                //Cek Keberadaan Data
                $KeberadaanData=GetDetailData($Conn,'transaksi_payment','kode_transaksi',$kode_transaksi,'order_id');
                if(empty($KeberadaanData)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12">';
                    echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                    echo '          <small class="credit">';
                    echo '              <code class="text-dark">';
                    echo '                  Tidak ada riwayat pembayaran untuk trsansksi ini';
                    echo '              </code>';
                    echo '          </small>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    //Buka List Log Pembayaran
                    $no=1;
                    $query = mysqli_query($Conn, "SELECT*FROM transaksi_payment WHERE kode_transaksi='$kode_transaksi' ORDER BY datetime DESC");
                    while ($data = mysqli_fetch_array($query)) {
                        $order_id= $data['order_id'];
                        $snap_token= $data['snap_token'];
                        $datetime= $data['datetime'];
                        $status= $data['status'];
                        //Format Tanggal
                        $strtotime=strtotime($datetime);
                        $tanggal_pembayaran=date('d/m/Y H:i:s',$strtotime);

?>
                    <div class="row mb-3 border-1 border-bottom">
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3 ">
                                <div class="col-md-4"><small class="credit">Tgl.Pembayaran</small></div>
                                <div class="col-md-8">
                                    <small class="credit">
                                        <code class="text text-grayish"><?php echo "$tanggal_pembayaran"; ?></code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4"><small class="credit">Order ID</small></div>
                                <div class="col-md-8">
                                    <small class="credit">
                                        <code class="text text-grayish"><?php echo "$order_id"; ?></code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4"><small class="credit">Snap Token</small></div>
                                <div class="col-md-8">
                                    <small class="credit">
                                        <code class="text text-grayish"><?php echo "$snap_token"; ?></code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4"><small class="credit">Status</small></div>
                                <div class="col-md-8">
                                    <small class="credit">
                                        <?php 
                                            if($status=="Lunas"){
                                                echo '<code class="text text-success">Lunas</code>';
                                            }else{
                                                echo '<code class="text text-danger">'.$status.'</code>';
                                            } 
                                        ?>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <small class="credit">
                                        <?php 
                                            //Buka Dari Payment Gateway
                                            $api_key = GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'api_key');
                                            $server_key = GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'server_key');
                                            $production = GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'production');
                                            $api_payment_url =GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'api_payment_url');
                                            //Buka Pengaturan
                                            $urll_call_back=GetDetailData($Conn,'setting_payment','id_setting_payment ','1','urll_call_back');
                                            $id_marchant=GetDetailData($Conn,'setting_payment','id_setting_payment ','1','id_marchant');
                                            $client_key=GetDetailData($Conn,'setting_payment','id_setting_payment ','1','client_key');
                                            $snap_url=GetDetailData($Conn,'setting_payment','id_setting_payment ','1','snap_url');
                                            $production=GetDetailData($Conn,'setting_payment','id_setting_payment ','1','production');
                                            $aktif_payment_gateway=GetDetailData($Conn,'setting_payment','id_setting_payment ','1','aktif_payment_gateway');
                                            //Mulai Curl
                                            $curl = curl_init();
                                            curl_setopt_array($curl, array(
                                                CURLOPT_URL => ''.$api_payment_url.'/transaction_status.php',
                                                CURLOPT_RETURNTRANSFER => true,
                                                CURLOPT_ENCODING => '',
                                                CURLOPT_MAXREDIRS => 10,
                                                CURLOPT_TIMEOUT => 0,
                                                CURLOPT_FOLLOWLOCATION => true,
                                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                CURLOPT_CUSTOMREQUEST => 'POST',
                                                CURLOPT_POSTFIELDS => json_encode(array(
                                                    "api_key" => $api_key,
                                                    "order_id" => $order_id
                                                )),
                                                CURLOPT_HTTPHEADER => array(
                                                    'Content-Type: application/json'
                                                ),
                                            ));
                                            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                                            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                                            $response = curl_exec($curl);
                                            if (curl_errno($curl)) {
                                                echo "cURL Error: " . curl_error($curl);
                                            } else {
                                                $data = json_decode($response, true);
                                                if($data['response']['status_code']!=="200"){
                                                    
                                                    echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                                                    echo '          <small class="credit">';
                                                    echo '              <code class="text-dark">';
                                                    echo '<span class="text-danger">'.$data['response']['status_message'].'</span>';
                                                    echo '              </code>';
                                                    echo '          </small>';
                                                    echo '      </div>';
                                                }else{
                                                    $transaction_id = $data['response']['transaction_id'];
                                                    $gross_amount = $data['response']['gross_amount'];
                                                    $currency = $data['response']['currency'];
                                                    $payment_type = $data['response']['payment_type'];
                                                    $transaction_status = $data['response']['transaction_status'];
                                                    $transaction_time = $data['response']['transaction_time'];
                                                    echo '<ul>';
                                                    echo '  <li>ID Transaksi : <code class="text text-grayish">'.$transaction_id.'</code></li>';
                                                    echo '  <li>Gross Amount : <code class="text text-grayish">'.$gross_amount.'</code></li>';
                                                    echo '  <li>Currency : <code class="text text-grayish">'.$currency.'</code></li>';
                                                    echo '  <li>Payment Type : <code class="text text-grayish">'.$payment_type.'</code></li>';
                                                    echo '  <li>Transaction Status : <code class="text text-grayish">'.$transaction_status.'</code></li>';
                                                    echo '  <li>Transaction Time : <code class="text text-grayish">'.$transaction_time.'</code></li>';
                                                    echo '</ul>';
                                                }
                                                
                                            }
                                            curl_close($curl);
                                        ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
<?php
                        $no++;
                    }
                }
            }
        }
    }
?>