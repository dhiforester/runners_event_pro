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
        if(empty($_POST['id_transaksi'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Transaksi Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_transaksi=$_POST['id_transaksi'];
            //Bersihkan Data
            $id_transaksi=validateAndSanitizeInput($id_transaksi);
            //Buka Data
            $id_transaksi_validasi=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'id_transaksi');
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
                $id_member=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'id_member');
                $raw_member=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'raw_member');
                $kategori=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'kategori');
                $kode_transaksi=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'kode_transaksi');
                $order_id=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'order_id');
                $datetime=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'datetime');
                $jumlah=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'jumlah');
                $status=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'status');
                //format Data
                $strtotime=strtotime($datetime);
                $datetime_format=date('d M Y H:i',$strtotime);
                //Format Jumlah
                $jumlah_format='Rp ' . number_format($jumlah, 2, ',', '.');
                //Buka Raw Member
                $array=json_decode($raw_member, true);
                $nama=$array['nama'];
                $email=$array['email'];
                $kontak=$array['kontak'];
                $id_member=$array['id_member'];
                $last_name=$array['last_name'];
                $first_name=$array['first_name'];
                // Ambil Server Key dan Production dari database
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
                // Set header
                $headers = array(
                    'Content-Type: Application/x-www-form-urlencoded',
                );
                // Array data untuk dikirim via CURL
                $order = array(
                    "order_id" => $order_id,
                    "gross_amount" => $jumlah,
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "email" => $email,
                    "phone" => $kontak,
                    "kode_transaksi" => $kode_transaksi,
                );
                $arr = array(
                    "api_key" => $api_key,
                    "order" => $order
                );
                $json = json_encode($arr);

                // CURL init
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, "$api_payment_url/GenerateSnapToken.php");
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
                        $snap_token = $data["token"];
                        if ($code == "200") {
                            $response= 'success';
                            $message= $status;
                            $snap_token= $snap_token;
                        } else {
                            $response= 'Snap Token Gagal Dibuat! Kode: ' . $code;
                        }
                    } else {
                        $response= 'Error pada decoding JSON: '.$response_curl.' ' . json_last_error_msg();
                    }
                }
                // Tutup CURL
                curl_close($curl);
                if($response!=="success"){
                    echo '<div class="row mb-3">';
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
?>
        <html>
            <head>
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
                <script type="text/javascript" src="<?php echo "$snap_url";?>" data-client-key="<?php echo "$client_key";?>"></script>
                <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
            </head>
            <body>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <small>Nama Depan</small>
                    </div>
                    <div class="col-md-8">
                        <small>
                            <code class="text text-grayish">
                                <?php echo "$first_name"; ?>
                            </code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <small>Nama Belakang</small>
                    </div>
                    <div class="col-md-8">
                        <small>
                            <code class="text text-grayish">
                                <?php echo "$last_name"; ?>
                            </code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <small>Email</small>
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
                        <small>Kontak</small>
                    </div>
                    <div class="col-md-8">
                        <small>
                            <code class="text text-grayish">
                                <?php echo "$kontak"; ?>
                            </code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <small>Gross Amount</small>
                    </div>
                    <div class="col-md-8">
                        <small>
                            <code class="text text-grayish">
                                <?php echo "$jumlah_format"; ?>
                            </code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <small>Snap Token</small>
                    </div>
                    <div class="col-md-8">
                        <small>
                            <code class="text text-grayish">
                                <?php echo "$snap_token"; ?>
                            </code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <button id="pay-button" class="btn btn-md btn-block btn-success btn-rounded">
                            <i class="bi bi-arrow-right-circle"></i> Bayar Sekarang
                        </button>
                    </div>
                </div>
                
                <script type="text/javascript">
                    // For example trigger on button clicked, or any time you need
                    var payButton = document.getElementById('pay-button');
                    payButton.addEventListener('click', function () {
                        $('#pay-button').html('Loading..');
                        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
                        window.snap.pay('<?php echo $snap_token;?>', {
                            onSuccess: function(result){
                                /* You may add your own implementation here */
                                window.location.reload();
                                $('#pay-button').html('<i class="bi bi-arrow-right-circle"></i> Lanjutkan');
                            },
                            onPending: function(result){
                                /* You may add your own implementation here */
                                window.location.href = 'index.php?page=Transaksi';
                                $('#pay-button').html('<i class="bi bi-arrow-right-circle"></i> Lanjutkan');
                            },
                            onError: function(result){
                                /* You may add your own implementation here */
                                swal("Pembayaran Gagal", "Terjadi Kesalahan Pada Saat Melakukan Pembayaran", "error"); console.log(result);
                                $('#pay-button').html('<i class="bi bi-arrow-right-circle"></i> Lanjutkan');
                            },
                            onClose: function(){
                                /* You may add your own implementation here */
                                swal("Pembayaran Batal", "Anda tidak jadi meneruskan proses pembayaran", "error");
                                $('#pay-button').html('<i class="bi bi-arrow-right-circle"></i> Lanjutkan');
                            }
                        })
                    });
                </script>
            </body>
        </html>
<?php
                }
            }
        }
    }
?>