<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Ulang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    } else {
        if (empty($_POST['id_order_transaksi'])) {
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Order Transaksi Tidak Bisa Ditangkap Oleh Sistem!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        } else {
            $id_order_transaksi = $_POST['id_order_transaksi'];
            // Membuka Pengaturan Payment Gateway
            $api_key = GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'api_key');
            $api_payment_url = GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'api_payment_url');

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $api_payment_url . '/detail_order_transaksi.php',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode(array(
                    "api_key" => $api_key,
                    "id_order_transaksi" => $id_order_transaksi
                )),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            // Tambahkan opsi ini jika Anda ingin menonaktifkan verifikasi SSL
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

            $response = curl_exec($curl);

            // Cek apakah terjadi kesalahan pada CURL
            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
                echo '<div class="alert alert-danger">CURL Error: ' . $error_msg . '</div>';
                file_put_contents('curl_error_log.txt', date('Y-m-d H:i:s') . " - CURL Error: " . $error_msg . PHP_EOL, FILE_APPEND);
            }

            if (empty($response)) {
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                echo '          <small class="credit">';
                echo '              <code class="text-dark">';
                echo '                  Terjadi kesalahan pada saat mengirim request ke server API payment!';
                echo '              </code>';
                echo '          </small>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            } else {
                // Decode Response
                $arry = json_decode($response, true);
                if ($arry['code'] !== 200) {
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12">';
                    echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                    echo '          <small class="credit">';
                    echo '              <code class="text-dark">';
                    echo '                  ' . $arry['status'] . '';
                    echo '              </code>';
                    echo '          </small>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                } else {
                    if(empty($arry['detail']['kode_transaksi'])){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-12">';
                        echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                        echo '          <small class="credit">';
                        echo '              <code class="text-dark">';
                        echo '                  ' . $response. '';
                        echo '              </code>';
                        echo '          </small>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        $kode_transaksi = $arry['detail']['kode_transaksi'];
                        $order_id = $arry['detail']['order_id'];
                        $datetime = $arry['detail']['datetime'];
                        $ServerKey = $arry['detail']['ServerKey'];
                        $Production = $arry['detail']['Production'];
                        $gross_amount = $arry['detail']['gross_amount'];
                        $name = $arry['detail']['name'];
                        $email = $arry['detail']['email'];
                        $phone = $arry['detail']['phone'];
                        $snapToken = $arry['detail']['snapToken'];
                        //Format Tanggal
                        $strtotime=strtotime($datetime);
                        $datetime_format=date('d M Y H:i:s',$strtotime);
                        //Format Rupiah
                        $gross_amount_rupiah = 'Rp ' . number_format($gross_amount, 0, ',', '.');
                        //Jumlah Riwayat Pembayaran
                        $JumlahLLogPayment=count($arry['log_payment']);
?>
                        <div class="accordion accordion-flush" id="accordionFlushExample2">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse1" aria-expanded="true" aria-controls="flush-collapse1">
                                        1. Detail Order ID
                                    </button>
                                </h2>
                                <div id="flush-collapse1" class="accordion-collapse collapse show" aria-labelledby="flush-heading1" data-bs-parent="#accordionFlushExample2" style="">
                                    <div class="accordion-body">
                                        <div class="row mt-3 mb-3">
                                            <div class="col-md-4">
                                                <small class="credit">Kode Transaksi</small>
                                            </div>
                                            <div class="col-md-8">
                                                <small>
                                                    <code class="text text-grayish">
                                                        <?php echo "$kode_transaksi"; ?>
                                                    </code>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <small class="credit">Order ID</small>
                                            </div>
                                            <div class="col-md-8">
                                                <small>
                                                    <code class="text text-grayish">
                                                        <?php echo "$order_id"; ?>
                                                    </code>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <small class="credit">Datetime</small>
                                            </div>
                                            <div class="col-md-8">
                                                <small>
                                                    <code class="text text-grayish">
                                                        <?php echo "$datetime_format"; ?>
                                                    </code>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <small class="credit">Server Key</small>
                                            </div>
                                            <div class="col-md-8">
                                                <small>
                                                    <code class="text text-grayish">
                                                        <?php echo "$ServerKey"; ?>
                                                    </code>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <small class="credit">Production</small>
                                            </div>
                                            <div class="col-md-8">
                                                <small>
                                                    <code class="text text-grayish">
                                                        <?php echo "$Production"; ?>
                                                    </code>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <small class="credit">Gross Amount</small>
                                            </div>
                                            <div class="col-md-8">
                                                <small>
                                                    <code class="text text-grayish">
                                                        <?php echo "$gross_amount_rupiah"; ?>
                                                    </code>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <small class="credit">Full Name</small>
                                            </div>
                                            <div class="col-md-8">
                                                <small>
                                                    <code class="text text-grayish">
                                                        <?php echo "$name"; ?>
                                                    </code>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <small class="credit">Email</small>
                                            </div>
                                            <div class="col-md-8">
                                                <small>
                                                    <code class="text text-grayish">
                                                        <?php echo "$email"; ?>
                                                    </code>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <small class="credit">Phone</small>
                                            </div>
                                            <div class="col-md-8">
                                                <small>
                                                    <code class="text text-grayish">
                                                        <?php echo "$phone"; ?>
                                                    </code>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <small class="credit">Snap Token</small>
                                            </div>
                                            <div class="col-md-8">
                                                <small>
                                                    <code class="text text-grayish">
                                                        <?php echo "$snapToken"; ?>
                                                    </code>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse2" aria-expanded="false" aria-controls="flush-collapse2">
                                        2. Riwayat Pembayaran
                                    </button>
                                </h2>
                                <div id="flush-collapse2" class="accordion-collapse collapse" aria-labelledby="flush-heading2" data-bs-parent="#accordionFlushExample2">
                                    <div class="accordion-body">
                                        <?php
                                            if(empty($JumlahLLogPayment)){
                                                echo '<div class="row">';
                                                echo '  <div class="col-md-12 text-center">';
                                                echo '      <small class="credit">';
                                                echo '          <code class="text-danger">';
                                                echo '              Tidak Ada Riwayat Pembayaran Untuk Order Transaksi Ini';
                                                echo '          </code>';
                                                echo '      </small>';
                                                echo '  </div>';
                                                echo '</div>';
                                            }else{
                                                echo '<div class="row mt-4">';
                                                $log_payment=$arry['log_payment'];
                                                $no=1;
                                                foreach($log_payment as $list_log_payment){
                                                    $id_log_payment=$list_log_payment['id_log_payment'];
                                                    $transaction_time=$list_log_payment['transaction_time'];
                                                    $status_code=$list_log_payment['status_code'];
                                                    $payment_type=$list_log_payment['payment_type'];
                                                    $gross_amount2=$list_log_payment['gross_amount'];
                                                    $fraud_status=$list_log_payment['fraud_status'];
                                                    $transaction_status=$list_log_payment['transaction_status'];
                                                    //Format Tanggal
                                                    $strtotime2=strtotime($transaction_time);
                                                    $transaction_time_format=date('d M Y H:i:s',$strtotime2);
                                                    //Format Rupiah
                                                    $gross_amount_rupiah2 = 'Rp ' . number_format($gross_amount2, 0, ',', '.');
                                                    echo '<div class="col-md-12 border-1 border-bottom mb-3">';
                                                    echo '  <div class="row">';
                                                    echo '      <div class="col col-md-4"><small>ID Payment</small></div>';
                                                    echo '      <div class="col col-md-8"><small><code class="text text-grayish">'.$id_log_payment.'</code></small></div>';
                                                    echo '  </div>';
                                                    echo '  <div class="row">';
                                                    echo '      <div class="col col-md-4"><small>Datetime</small></div>';
                                                    echo '      <div class="col col-md-8"><small><code class="text text-grayish">'.$transaction_time_format.'</code></small></div>';
                                                    echo '  </div>';
                                                    echo '  <div class="row">';
                                                    echo '      <div class="col col-md-4"><small>Status Code</small></div>';
                                                    echo '      <div class="col col-md-8"><small><code class="text text-grayish">'.$status_code.'</code></small></div>';
                                                    echo '  </div>';
                                                    echo '  <div class="row">';
                                                    echo '      <div class="col col-md-4"><small>Payment Type</small></div>';
                                                    echo '      <div class="col col-md-8"><small><code class="text text-grayish">'.$payment_type.'</code></small></div>';
                                                    echo '  </div>';
                                                    echo '  <div class="row">';
                                                    echo '      <div class="col col-md-4"><small>Gross Amount</small></div>';
                                                    echo '      <div class="col col-md-8"><small><code class="text text-grayish">'.$gross_amount_rupiah2.'</code></small></div>';
                                                    echo '  </div>';
                                                    echo '  <div class="row">';
                                                    echo '      <div class="col col-md-4"><small>Fraud</small></div>';
                                                    echo '      <div class="col col-md-8"><small><code class="text text-grayish">'.$fraud_status.'</code></small></div>';
                                                    echo '  </div>';
                                                    echo '  <div class="row">';
                                                    echo '      <div class="col col-md-4"><small>Status Transaksi</small></div>';
                                                    echo '      <div class="col col-md-8"><small><code class="text text-grayish">'.$transaction_status.'</code></small></div>';
                                                    echo '  </div>';
                                                    echo '</div>';
                                                    $no++;
                                                }
                                                echo '</div>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
<?php
                        curl_close($curl);
                    }
                }
            }
        }
    }
?>
