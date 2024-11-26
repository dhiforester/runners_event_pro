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
                //Cek Keberadaan Data
                $KeberadaanData=GetDetailData($Conn,'transaksi_payment','id_transaksi_payment',$id_transaksi_payment,'order_id');
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
                    $pesan_eror="";
                    $order_id=GetDetailData($Conn,'transaksi_payment','id_transaksi_payment',$id_transaksi_payment,'order_id');
                    $kode_transaksi=GetDetailData($Conn,'transaksi_payment','id_transaksi_payment',$id_transaksi_payment,'kode_transaksi');
                    $snap_token=GetDetailData($Conn,'transaksi_payment','id_transaksi_payment',$id_transaksi_payment,'snap_token');
                    $datetime=GetDetailData($Conn,'transaksi_payment','id_transaksi_payment',$id_transaksi_payment,'datetime');
                    $status=GetDetailData($Conn,'transaksi_payment','id_transaksi_payment',$id_transaksi_payment,'status');
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
                            if($data['response']['status_code']!=="407"){
                                $pesan_eror=$data['response']['status_message'];
                            }else{
                                $transaction_id = $data['response']['transaction_id'];
                                $gross_amount = $data['response']['gross_amount'];
                                $currency = $data['response']['currency'];
                                $payment_type = $data['response']['payment_type'];
                                $transaction_status = $data['response']['transaction_status'];
                                $transaction_time = $data['response']['transaction_time'];
                            }
                        }else{
                            $transaction_id = $data['response']['transaction_id'];
                            $gross_amount = $data['response']['gross_amount'];
                            $currency = $data['response']['currency'];
                            $payment_type = $data['response']['payment_type'];
                            $transaction_status = $data['response']['transaction_status'];
                            $transaction_time = $data['response']['transaction_time'];
                        }
                    }
                    curl_close($curl);

?>
                    <div class="row mb-3 border-1 border-bottom">
                        <div class="col-md-12 mb-2">
                            A. Data Transaksi Pembayaran
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <small>Kode Transaksi</small>
                                </div>
                                <div class="col-md-8">
                                    <small>
                                        <code class="text text-grayish"><?php echo $kode_transaksi; ?></code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <small>Order ID</small>
                                </div>
                                <div class="col-md-8">
                                    <small>
                                        <code class="text text-grayish"><?php echo $order_id; ?></code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <small>Snap Token</small>
                                </div>
                                <div class="col-md-8">
                                    <small>
                                        <code class="text text-grayish"><?php echo $snap_token; ?></code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <small>Tgl/Jam</small>
                                </div>
                                <div class="col-md-8">
                                    <small>
                                        <code class="text text-grayish"><?php echo $datetime; ?></code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <small>Status</small>
                                </div>
                                <div class="col-md-8">
                                    <small>
                                        <code class="text text-grayish"><?php echo $status; ?></code>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-2">
                            B. Payment Gateway
                        </div>
                        <div class="col-md-12 mb-2">
                            <?php 
                                if($pesan_eror!==""){
                                    echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                                    echo '          <small class="credit">';
                                    echo '              <code class="text-dark">';
                                    echo '                  <span class="text-danger">'.$pesan_eror.'</span><br>';
                                    // echo '                  <span class="text-danger">'.$response.'</span>';
                                    echo '              </code>';
                                    echo '          </small>';
                                    echo '      </div>';
                                }else{
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col-md-4">';
                                    echo '      <small>Transaction ID</small>';
                                    echo '  </div>';
                                    echo '  <div class="col-md-8">';
                                    echo '      <small>';
                                    echo '          <code class="text text-grayish">'.$transaction_id.'</code>';
                                    echo '      </small>';
                                    echo '  </div>';
                                    echo '</div>';
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col-md-4">';
                                    echo '      <small>Gross Amount</small>';
                                    echo '  </div>';
                                    echo '  <div class="col-md-8">';
                                    echo '      <small>';
                                    echo '          <code class="text text-grayish">'.$gross_amount.'</code>';
                                    echo '      </small>';
                                    echo '  </div>';
                                    echo '</div>';
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col-md-4">';
                                    echo '      <small>Currency</small>';
                                    echo '  </div>';
                                    echo '  <div class="col-md-8">';
                                    echo '      <small>';
                                    echo '          <code class="text text-grayish">'.$currency.'</code>';
                                    echo '      </small>';
                                    echo '  </div>';
                                    echo '</div>';
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col-md-4">';
                                    echo '      <small>Payment Type</small>';
                                    echo '  </div>';
                                    echo '  <div class="col-md-8">';
                                    echo '      <small>';
                                    echo '          <code class="text text-grayish">'.$payment_type.'</code>';
                                    echo '      </small>';
                                    echo '  </div>';
                                    echo '</div>';
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col-md-4">';
                                    echo '      <small>Transaction Status</small>';
                                    echo '  </div>';
                                    echo '  <div class="col-md-8">';
                                    echo '      <small>';
                                    echo '          <code class="text text-grayish">'.$transaction_status.'</code>';
                                    echo '      </small>';
                                    echo '  </div>';
                                    echo '</div>';
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col-md-4">';
                                    echo '      <small>Transaction Time</small>';
                                    echo '  </div>';
                                    echo '  <div class="col-md-8">';
                                    echo '      <small>';
                                    echo '          <code class="text text-grayish">'.$transaction_time.'</code>';
                                    echo '      </small>';
                                    echo '  </div>';
                                    echo '</div>';
                                }
                            ?>
                        </div>
                    </div>
<?php
                }
            }
        }
    }
?>