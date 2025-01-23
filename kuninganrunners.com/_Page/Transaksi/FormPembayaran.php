<?php
    //Zona Waktu
    date_default_timezone_set("Asia/Jakarta");
    session_start();
    include "../../_Config/Connection.php";
    //Tangkap Kode Transaksi
    if(empty($_POST['kode_transaksi'])){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '  <small>Kode Transaksi Tidak Boleh Kosong!</small>';
        echo '</div>';
    }else{
        //Memanggil xtoken pertama kali
        $xtoken ="";
        $datetime_expired ="";
        $keterangan ="Tidak Ada Proses Yang Berlangsung";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_server.'/_Api/GenerateToken/GenerateToken.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "user_key_server" : "'.$user_key_server.'",
                "password_server" : "'.$password_server.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        $curl_error = curl_error($curl);
        //Apabila Terjadi kesalahan Pada CURL
        if ($curl_error) {
            $xtoken ="";
            $datetime_expired ="";
            $keterangan='Curl error: ' . $curl_error;
        }else{
            //Apabila Response Bukan JSON
            $arry_res = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $xtoken ="";
                $datetime_expired ="";
                $keterangan='Invalid JSON response: ' . $response;
            }else{
                //Apabila Otentifikasi token tidak valid
                if($arry_res['response']['code']!==200) {
                    $xtoken ="";
                    $datetime_expired ="";
                    $keterangan=$arry_res['response']['message'];
                }else{
                    $metadata = $arry_res['metadata'];
                    //Apabila Berhasil
                    $xtoken = $metadata['x-token'];
                    $datetime_expired = $metadata['datetime_expired'];
                    $keterangan="";
                }
            }
        }
        //Tutup Curl
        curl_close($curl);
        //Routing Apabila Ctoken Berhasil Dibuat
        if(empty($xtoken)){
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '  '.$keterangan.'';
            echo '</div>';
        }else{
            //Apabila X-token berhasil dibuat simpan dalam session
            $_SESSION['datetime_expired'] = $datetime_expired;
            $_SESSION['xtoken'] = $xtoken;
            //Rekam Log Halaman
            include "../../_Config/SendLogViewer.php";
            if($ValidasiSimpanLog!=="Valid"){
                //Apabila Gagal Menyimpan Log
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo '  '.$ValidasiSimpanLog.'';
                echo '</div>';
            }else{
                //Buka Function
                include "../../_Config/GlobalFunction.php";
                //Membuka Web Setting Dari Server
                $WebSetting=WebSetting($url_server,$xtoken);
                //Decode Response Setting
                $WebSetting = json_decode($WebSetting, true);
                //Buka Setting Dalam Variabel
                $web_url=$WebSetting['metadata']['base_url'];
                $title_web=ShowTrueContent($WebSetting['metadata']['title']);
                $description_web=ShowTrueContent($WebSetting['metadata']['description']);
                $keyword_web=ShowTrueContent($WebSetting['metadata']['keyword']);
                $author_web=ShowTrueContent($WebSetting['metadata']['x-author']);
                $icon_web=ShowTrueContent($WebSetting['metadata']['icon']);
                $pavicon_web=ShowTrueContent($WebSetting['metadata']['pavicon']);
                $tentang_judul=ShowTrueContent($WebSetting['metadata']['tentang']['judul']);
                $tentang_preview=$WebSetting['metadata']['tentang']['preview'];
                //Kontak Website
                $kontak_alamat=ShowTrueContent($WebSetting['metadata']['kontak']['alamat']);
                $kontak_email=ShowTrueContent($WebSetting['metadata']['kontak']['email']);
                $kontak_telepon=ShowTrueContent($WebSetting['metadata']['kontak']['telepon']);
                //Buka Pengaturan Pembayaran
                $api_key=ShowTrueContent($WebSetting['metadata']['payment_setting']['api_key']);
                $production=ShowTrueContent($WebSetting['metadata']['payment_setting']['production']);
                $api_payment_url=ShowTrueContent($WebSetting['metadata']['payment_setting']['api_payment_url']);
                $client_key=ShowTrueContent($WebSetting['metadata']['payment_setting']['client_key']);
                $snap_url=ShowTrueContent($WebSetting['metadata']['payment_setting']['snap_url']);
                $aktif_payment_gateway=ShowTrueContent($WebSetting['metadata']['payment_setting']['aktif_payment_gateway']);
                //Buka Session Login
                if($_SESSION['login_expired']<date('Y-m-d H:i:s')){
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      Sessi Login Akses Anda Sudah Berakhir! Silahkan Login Ulang Terlebih Dulu!';
                    echo '  </small>';
                    echo '</div>';
                }else{
                    //Perpanjang Session Akses Member
                    $email_member=$_SESSION['email'];
                    $id_member_login=$_SESSION['id_member_login'];
                    $UpdateSessionMemberLogin=UpdateSessionMemberLogin($url_server,$xtoken,$email_member,$id_member_login);
                    //Cek Data Transaksi Peserta
                    $kode_transaksi=$_POST['kode_transaksi'];
                    //Buat Snap Token
                    $snap_token=GenerateSnapTokenTransaksi($url_server,$xtoken,$email_member,$id_member_login,$kode_transaksi);
                    //Decode Response
                    $snap_token_arry=json_decode($snap_token, true);
                    if($snap_token_arry['response']['code']!==200){
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        echo '  <small>';
                        echo '      '.$snap_token_arry['response']['message'].'';
                        echo '  </small>';
                        echo '</div>';
                    }else{
                        //Apabila Berhasil Buka Metadata
                        $snap_token_metadata=$snap_token_arry['metadata'];
                        //Buka Snap Token
                        $kode_transaksi=$snap_token_metadata['kode_transaksi'];
                        $order_id=$snap_token_metadata['order_id'];
                        $snap_token=$snap_token_metadata['snap_token'];
                        $datetime=$snap_token_metadata['datetime'];
                        $status=$snap_token_metadata['status'];

                        //Buka Transaksi
                        $DetailTransaksi=DetailTransaksi($url_server,$xtoken,$email_member,$id_member_login,$kode_transaksi);
                        $detail_transaksi_arry=json_decode($DetailTransaksi, true);
                        if($detail_transaksi_arry['response']['code']!==200){
                            echo '<div class="row">';
                            echo '  <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">';
                            echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                            echo '          <small>';
                            echo '              '.$detail_transaksi_arry['response']['message'].'';
                            echo '          </small>';
                            echo '      </div>';
                            echo '  </div>';
                            echo '</div>';
                        }else{
                            //Buka Data Transaksi
                            $metadata=$detail_transaksi_arry['metadata'];
                            $jumlah_total=$metadata['jumlah'];
                            $jumlah_total_format='Rp ' . number_format($jumlah_total, 0, ',', '.');

                            //Redirect URL
                            $url_redirect_back="$web_url/index.php?Page=DetailTransaksi&kode=$kode_transaksi";
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
                                <div class="col-md-12 text-center mb-3">
                                    <small>Jumlah Pembayaran</small>
                                </div>
                                <div class="col-md-12 text-center">
                                    <h1>
                                        <?php echo "$jumlah_total_format"; ?>
                                    </h1>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12 text-center">
                                    <button id="pay-button" class="button_more">
                                        <i class="bi bi-arrow-right-circle"></i> Pilih Metode Pembayaran
                                    </button>
                                </div>
                            </div>
                            
                            <script type="text/javascript">
                               // Pastikan script selalu diambil terbaru (cache buster)
                                const scriptVersion = Date.now(); // Gunakan timestamp untuk cache buster
                                var payButton = document.getElementById('pay-button');
                                payButton.addEventListener('click', function () {
                                    $('#pay-button').html('Loading...');
                                    window.snap.pay('<?php echo $snap_token; ?>', {
                                        onSuccess: function (result) {
                                            Swal.fire({
                                                title: 'Berhasil!',
                                                text: 'Transaksi Pembayaran Berhasil',
                                                icon: 'success',
                                                confirmButtonText: 'OK',
                                                willClose: () => {
                                                    redirectToUrl();
                                                }
                                            });
                                        },
                                        onPending: function (result) {
                                            Swal.fire({
                                                title: 'Pembayaran Pending!',
                                                text: 'Silahkan Tunggu Beberapa Saat',
                                                icon: 'warning',
                                                confirmButtonText: 'OK',
                                                willClose: () => {
                                                    redirectToUrl();
                                                }
                                            });
                                        },
                                        onError: function (result) {
                                            Swal.fire({
                                                title: 'Pembayaran Gagal',
                                                text: 'Terjadi Kesalahan Pada Saat Melakukan Pembayaran',
                                                icon: 'error',
                                                confirmButtonText: 'OK',
                                                willClose: () => {
                                                    redirectToUrl();
                                                }
                                            });
                                        },
                                        onClose: function () {
                                            Swal.fire({
                                                title: 'Pembayaran Batal',
                                                text: 'Anda tidak jadi meneruskan proses pembayaran',
                                                icon: 'error',
                                                confirmButtonText: 'OK',
                                                willClose: () => {
                                                    redirectToUrl();
                                                }
                                            });
                                        }
                                    });
                                });

                                // Fungsi untuk melakukan redirect dengan loading terlebih dahulu
                                function redirectToUrl() {
                                    Swal.fire({
                                        title: 'Memuat ulang halaman...',
                                        text: 'Mohon tunggu.',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });

                                    setTimeout(() => {
                                        window.location.replace('<?php echo $url_redirect_back; ?>&v=' + scriptVersion);
                                    }, 5000); // Delay 5 detik
                                }
                            </script>
                        </body>
                    </html>

<?php
                        }
                    }
                }
            }
        }
    }
?>