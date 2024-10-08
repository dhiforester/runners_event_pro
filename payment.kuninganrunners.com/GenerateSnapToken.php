<?php
    include "_Config/Connection.php";
    include "_Config/Function.php";
	// Membaca input JSON dan validasi
	$fp = fopen('php://input', 'r');
	$raw = stream_get_contents($fp);
	$Tangkap = json_decode($raw, true);

    // Default response
	$Array = Array (
		"status" => "error",
		"code" => 400
	);

    // Mencegah pengiriman data kosong atau invalid
    if (empty($Tangkap) || !is_array($Tangkap)) {
        $Array['status'] = "Invalid JSON format";
        $Array['code'] = 400;
        sendResponse($Array);
    }

    // Membuka API Key dari database (asli)
    $api_key_database = getDataDetail($Conn, 'setting_payment', 'id_setting_payment', '1', 'api_key');
	
	// Validasi apakah API key disediakan
	if (empty($Tangkap['api_key'])) {
		$Array['status'] = "API Key Tidak Boleh Kosong";
		$Array['code'] = 401;
		sendResponse($Array);
	} else {
        // Ambil API key dari request dan sanitasi input
        $api_key_client = validateAndSanitizeInput($Tangkap['api_key']);

        // Validasi API key menggunakan prepared statement
        $stmt = $Conn->prepare("SELECT * FROM setting_payment WHERE api_key = ?");
        $stmt->bind_param("s", $api_key_client);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // Jika API key tidak valid
            $Array['status'] = "API Key Akses Payment Gateway Tidak Valid!";
            $Array['code'] = 401;
        } else {
			//Order ID Tidak Boleh Kosong
			if(empty($Tangkap['order']['order_id'])){
				$Array['status'] = "Order ID Tidak Boleh Kosong";
				$Array['code'] = 401;
				sendResponse($Array);
			}else{
				if(empty($Tangkap['order']['gross_amount'])){
					$Array['status'] = "Jumlah Tagihan Tidak Boleh Kosong";
					$Array['code'] = 401;
					sendResponse($Array);
				}else{
					if(empty($Tangkap['order']['first_name'])){
						$Array['status'] = "Nama Depan Tidak Boleh Kosong";
						$Array['code'] = 401;
						sendResponse($Array);
					}else{
						if(empty($Tangkap['order']['email'])){
							$Array['status'] = "Email Tidak Boleh Kosong";
							$Array['code'] = 401;
							sendResponse($Array);
						}else{
							if(empty($Tangkap['order']['phone'])){
								$Array['status'] = "Nomor Kontak Tidak Boleh Kosong";
								$Array['code'] = 401;
								sendResponse($Array);
							}else{
								if(empty($Tangkap['order']['kode_transaksi'])){
									$Array['status'] = "Kode Transaksi Tidak Boleh Kosong";
									$Array['code'] = 401;
									sendResponse($Array);
								}else{
									$GetServerKey=getDataDetail($Conn, 'setting_payment', 'id_setting_payment', '1', 'server_key');
									$Production=getDataDetail($Conn, 'setting_payment', 'id_setting_payment', '1', 'production');
									$order_id=$Tangkap['order']['order_id'];
									$gross_amount=$Tangkap['order']['gross_amount'];
									$first_name=$Tangkap['order']['first_name'];
									if(empty($Tangkap['order']['last_name'])){
										$last_name="";
									}else{
										$last_name=$Tangkap['order']['last_name'];
									}
									$email=$Tangkap['order']['email'];
									$phone=$Tangkap['order']['phone'];
									$kode_transaksi=$Tangkap['order']['kode_transaksi'];
									//Bersihkan Variabel
									$GetServerKey = validateAndSanitizeInput($GetServerKey);
									$Production = validateAndSanitizeInput($Production);
									$order_id = validateAndSanitizeInput($order_id);
									$gross_amount = validateAndSanitizeInput($gross_amount);
									$first_name = validateAndSanitizeInput($first_name);
									$last_name = validateAndSanitizeInput($last_name);
									$email = validateAndSanitizeInput($email);
									$phone = validateAndSanitizeInput($phone);
									$kode_transaksi = validateAndSanitizeInput($kode_transaksi);
									//Bungkus Data
									$log = Array (
										"ServerKey" => $GetServerKey,
										"Production" => $Production,
										"order_id" => $order_id,
										"gross_amount" => $gross_amount,
										"first_name" => $first_name,
										"last_name" => $last_name,
										"email" => $email,
										"phone" => $phone,
										"kode_transaksi" => $kode_transaksi
									);
									$JsonLog = json_encode($log);
									//Cek kode_transaksi apakah sudah ada atau belum
									$GetKodeTransaksi=getDataDetail($Conn,'order_transaksi','kode_transaksi',$kode_transaksi,'kode_transaksi');
									if(empty($GetKodeTransaksi)){
										//Simpan Data
										$simpan=InsertKodeTransaksi($Conn,$order_id,$kode_transaksi,$JsonLog);
									}else{
										//Simpan Data
										$simpan=UpdateKodeTransaksi($Conn,$order_id,$kode_transaksi,$JsonLog);
									}
									if($simpan!=="Berhasil"){
										$Array['status'] = "Terjadi kesalahan pada saat menyimpan data transaksi : $simpan";
										$Array['code'] = 401;
										sendResponse($Array);
									}else{
										require_once "midtrans-php-master/Midtrans.php";
										// Set your Merchant Server Key
										\Midtrans\Config::$serverKey = ''.$GetServerKey.'';
										// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
										if($Production=="true"){
											\Midtrans\Config::$isProduction = true;
										}else{
											\Midtrans\Config::$isProduction = false;
										}
										// Set sanitization on (default)
										\Midtrans\Config::$isSanitized = true;
										// Set 3DS transaction for credit card to true
										\Midtrans\Config::$is3ds = true;
										$params = array(
											'transaction_details' => array(
												'order_id' => $order_id,
												'gross_amount' => $gross_amount,
											),
											'customer_details' => array(
												'first_name' => ''.$first_name.'',
												'last_name' => ''.$last_name.'',
												'email' => ''.$email.'',
												'phone' => ''.$phone.'',
											),
										);
										$snapToken = \Midtrans\Snap::getSnapToken($params);
										if(!empty($snapToken)){
											$Array['status'] = "success";
											$Array['code'] = 200;
											$Array['token'] = $snapToken;
											sendResponse($Array);
										}else{
											$Array['status'] = "Token Gagal Dibuat";
											$Array['code'] = 401;
											sendResponse($Array);
										}
									}
								}
							}
						}
					}
				}
			}
		}
		// Tutup statement
		$stmt->close();
	}
	// Fungsi untuk mengirimkan respons JSON
	function sendResponse($response) {
		header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (10 * 60)));
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header('Content-Type: application/json');
		header('Pragma: no-cache');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Credentials: true');
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 
		header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, x-token, token"); 

		// JSON Response
		echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
		exit();
	}
	// Kirim response akhir
	sendResponse($Array);
?>