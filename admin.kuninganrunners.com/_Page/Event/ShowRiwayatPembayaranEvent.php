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
                //Jumlah Riwayat Transaksi
                $JumlahRiwayatTransaksi = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi FROM transaksi WHERE kode_transaksi='$id_event_peserta' AND kategori='Pendaftaran'"));
                if(empty($JumlahRiwayatTransaksi)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12">';
                    echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                    echo '          <small class="credit">';
                    echo '              <code class="text-dark">';
                    echo '                  Tidak Ada Riwayat Transaksi Pembayaran Untuk Peserta Event Ini';
                    echo '              </code>';
                    echo '          </small>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    echo '<div class="list-group">';
                    $no=1;
                    $QryTransaksi = mysqli_query($Conn, "SELECT*FROM transaksi WHERE kode_transaksi='$id_event_peserta' AND kategori='Pendaftaran' ORDER BY id_transaksi DESC");
                    while ($DataTransaksi = mysqli_fetch_array($QryTransaksi)) {
                        $id_transaksi= $DataTransaksi['id_transaksi'];
                        $id_member= $DataTransaksi['id_member'];
                        $raw_member= $DataTransaksi['raw_member'];
                        $order_id= $DataTransaksi['order_id'];
                        $datetime= $DataTransaksi['datetime'];
                        $jumlah= $DataTransaksi['jumlah'];
                        $status= $DataTransaksi['status'];
                        //Format Tanggal
                        $strtotime=strtotime($datetime);
                        $datetime=date('d M Y H:i',$strtotime);
                        //Format Jumlah
                        $jumlah_format='Rp ' . number_format($jumlah, 2, ',', '.');
                        

?>
                        <div class="list-group-item list-group-item-action" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                                <span class="mb-1 text-dark"><?php echo "$datetime"; ?></span>
                                <small>
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                        <li class="dropdown-header text-start">
                                            <h6>Option</h6>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailPembayaran" data-id="<?php echo "$id_transaksi"; ?>">
                                                <i class="bi bi-info-circle"></i> Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditPembayaran" data-id="<?php echo "$id_transaksi"; ?>">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusPembayaran" data-id="<?php echo "$id_transaksi"; ?>">
                                                <i class="bi bi-trash"></i> Hapus
                                            </a>
                                        </li>
                                        <?php
                                            if($status=="Pending"){
                                                echo '<li>';
                                                echo '  <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalBayarEvent" data-id="'.$id_transaksi.'">';
                                                echo '      <i class="bi bi-coin"></i> Bayar';
                                                echo '  </a>';
                                                echo '</li>';
                                            }
                                        ?>
                                    </ul>
                                </small>
                            </div>
                            <div class="row mb-3 mt-3">
                                <div class="col-md-3">
                                    <small>Order ID</small>
                                </div>
                                <div class="col-md-9">
                                    <small>
                                        <code class="text text-grayish"><?php echo "$order_id"; ?></code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col col-md-3">
                                    <small>Pembayaran</small>
                                </div>
                                <div class="col col-md-9">
                                    <small>
                                        <code class="text text-grayish"><?php echo "$jumlah_format"; ?></code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col col-md-3">
                                    <small>Status</small>
                                </div>
                                <div class="col col-md-9">
                                    <small>
                                        <code class="text text-grayish"><?php echo "$status"; ?></code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12 mt-3">
                                    <?php
                                        //Membuka Riwayat Transaksi Di Payment Gateway
                                        $api_key = GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'api_key');
                                        $server_key = GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'server_key');
                                        $production = GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'production');
                                        $api_payment_url =GetDetailData($Conn, 'setting_payment', 'id_setting_payment', '1', 'api_payment_url');
                                        //Buat Data JSON
                                        $headers = array(
                                            'Content-Type: Application/x-www-form-urlencoded',
                                        );
                                        $filter = array(
                                            "page" => "1",
                                            "limit" => "10",
                                            "ShortBy" => "ASC",
                                            "OrderBy" => "order_id",
                                            "keyword_by" => "order_id",
                                            "keyword" => "$order_id"
                                        );
                                        $arr = array(
                                            "api_key" => $api_key,
                                            "filter" => $filter
                                        );
                                        $json = json_encode($arr);
                        
                                        // CURL init
                                        $curl = curl_init();
                                        curl_setopt($curl, CURLOPT_URL, "$api_payment_url/order_transaksi.php");
                                        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                                        curl_setopt($curl, CURLOPT_TIMEOUT, 10); // Timeout lebih lama
                                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                                        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
                                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                                        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                                        // Eksekusi CURL dan cek error
                                        $response_curl = curl_exec($curl);
                                        if ($response_curl === false) {
                                            $response= 'CURL Error: ' . curl_error($curl);
                                        } else {
                                            $data = json_decode($response_curl, true); // Decode response JSON
                                            if (json_last_error() === JSON_ERROR_NONE) {
                                                $code = $data["code"];
                                                $status = $data["status"];
                                                if ($code == "200") {
                                                    $response= 'success';
                                                    $message= $status;
                                                    $list=$data["list"];
                                                } else {
                                                    $response= 'Pesan : '. $status.'<br>Kode: ' . $code;
                                                }
                                            } else {
                                                $response= 'Error pada decoding JSON: '.$response_curl.' ' . json_last_error_msg();
                                            }
                                        }
                                        // Tutup CURL
                                        curl_close($curl);
                                        if($response!=="success"){
                                            echo ' <div class="row mt-3">';
                                            echo '  <div class="col-md-12">';
                                            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                                            echo '          <small class="credit">';
                                            echo '              <code class="text-dark">';
                                            echo '                  '.$response.'';
                                            echo '              </code>';
                                            echo '          </small>';
                                            echo '      </div>';
                                            echo '  </div>';
                                            echo '</div>';
                                        }else{
                                            foreach($list as $list_riwayat){
                                                $id_order_transaksi=$list_riwayat['id_order_transaksi'];
                                                $datetime_log=$list_riwayat['datetime'];
                                                $snapToken=$list_riwayat['snapToken'];
                                                //Buka Log Pembayaran
                                                $arr2 = array(
                                                    "api_key" => $api_key,
                                                    "id_order_transaksi" => $id_order_transaksi
                                                );
                                                $json2 = json_encode($arr2);
                                                $curl = curl_init();
                                                curl_setopt($curl, CURLOPT_URL, "$api_payment_url/detail_order_transaksi.php");
                                                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                                                curl_setopt($curl, CURLOPT_TIMEOUT, 10); // Timeout lebih lama
                                                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                                                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                                                curl_setopt($curl, CURLOPT_POSTFIELDS, $json2);
                                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                                                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                                                // Eksekusi CURL dan cek error
                                                $response_curl2 = curl_exec($curl);
                                                if ($response_curl2 === false) {
                                                    $response2= 'CURL Error: ' . curl_error($curl);
                                                } else {
                                                    $data2 = json_decode($response_curl2, true); // Decode response JSON
                                                    if (json_last_error() === JSON_ERROR_NONE) {
                                                        $code2 = $data2["code"];
                                                        if ($code2 == "200") {
                                                            $response2= 'success';
                                                            $log_payment=$data2["log_payment"];
                                                        } else {
                                                            $response2= 'Snap Token Gagal Dibuat! Kode: ' . $code;
                                                        }
                                                    } else {
                                                        $response2= 'Error pada decoding JSON: '.$response_curl2.' ' . json_last_error_msg();
                                                    }
                                                }
                                                // Tutup CURL
                                                curl_close($curl);
                                                if($response2!=="success"){
                                                    echo ' <div class="row mt-3">';
                                                    echo '  <div class="col-md-12">';
                                                    echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                                                    echo '          <small class="credit">';
                                                    echo '              <code class="text-dark">';
                                                    echo '                  '.$response2.'';
                                                    echo '              </code>';
                                                    echo '          </small>';
                                                    echo '      </div>';
                                                    echo '  </div>';
                                                    echo '</div>';
                                                }else{
                                                    //List Log
                                                    foreach($log_payment as $log_payment_list){
                                                        $transaction_time=$log_payment_list['transaction_time'];
                                                        $payment_type=$log_payment_list['payment_type'];
                                                        $fraud_status=$log_payment_list['fraud_status'];
                                                        $transaction_status=$log_payment_list['transaction_status'];
                                                        echo '<div class="row mt-3 mb-3">';
                                                        echo '  <div class="col col-md-12"><small>'.$snapToken.'</small></div>';
                                                        echo '</div>';
                                                        echo '<div class="row mt-3 mb-3">';
                                                        echo '  <div class="col col-md-3"><small class="credit">Transaction Time</small></div>';
                                                        echo '  <div class="col col-md-9">';
                                                        echo '      <small class="credit">';
                                                        echo '          <code class="text text-grayish">'.$transaction_time.'</code>';
                                                        echo '      </small>';
                                                        echo '  </div>';
                                                        echo '</div>';
                                                        echo '<div class="row mt-3 mb-3">';
                                                        echo '  <div class="col col-md-3"><small class="credit">Payment Type</small></div>';
                                                        echo '  <div class="col col-md-9">';
                                                        echo '      <small class="credit">';
                                                        echo '          <code class="text text-grayish">'.$payment_type.'</code>';
                                                        echo '      </small>';
                                                        echo '  </div>';
                                                        echo '</div>';
                                                        echo '<div class="row mt-3 mb-3">';
                                                        echo '  <div class="col col-md-3"><small class="credit">Fraud Status</small></div>';
                                                        echo '  <div class="col col-md-9">';
                                                        echo '      <small class="credit">';
                                                        echo '          <code class="text text-grayish">'.$fraud_status.'</code>';
                                                        echo '      </small>';
                                                        echo '  </div>';
                                                        echo '</div>';
                                                        echo '<div class="row mt-3 mb-5">';
                                                        echo '  <div class="col col-md-3"><small class="credit">Transaction Status</small></div>';
                                                        echo '  <div class="col col-md-9">';
                                                        echo '      <small class="credit">';
                                                        echo '          <code class="text text-grayish">'.$transaction_status.'</code>';
                                                        echo '      </small>';
                                                        echo '  </div>';
                                                        echo '</div>';
                                                    }
                                                }
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
<?php
                    $no++;
                    }
                    echo '</div>';
                }
            }
        }
    }
?>