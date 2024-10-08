<?php
    include "Connection.php";
    include "Setting.php";
    include "Function.php";
	$fp = fopen('php://input', 'r');
	$raw = stream_get_contents($fp);
	$Tangkap = json_decode($raw,true);
	if(empty($Tangkap['kode_transaksi'])){
		$Array = Array (
			"pesan" => "Kode Transaksi Tidak Boleh Kosong",
			"code" =>201
		);
	}else{
        $kode_transaksi=$Tangkap['kode_transaksi'];
	    $QryPayment = "SELECT * FROM log_payment  WHERE kode_transaksi='$kode_transaksi'";
        $DataPayment  =mysqli_query($Conn, $QryPayment);
        $list = array();
        while($x = mysqli_fetch_array($DataPayment)){
            $id_log_payment=$x["id_log_payment"];
            $kode_transaksi=$x["kode_transaksi"];
            $transaction_time=$x["transaction_time"];
            $transaction_status=$x["transaction_status"];
            $transaction_id=$x["transaction_id"];
            $status_message=$x["status_message"];
            $status_code=$x["status_code"];
            $signature_key=$x["signature_key"];
            $payment_type=$x["payment_type"];
            $order_id=$x["order_id"];
            $merchant_id=$x["merchant_id"];
            $gross_amount=$x["gross_amount"];
            $fraud_status=$x["fraud_status"];
            $currency=$x["currency"];
            $h['id_log_payment'] =$id_log_payment ;
            $h['kode_transaksi'] =$kode_transaksi ;
            $h['transaction_time'] =$transaction_time ;
            $h['transaction_status'] =$transaction_status ;
            $h['transaction_id'] =$transaction_id ;
            $h['status_message'] =$status_message ;
            $h['status_code'] =$status_code ;
            $h['signature_key'] =$signature_key ;
            $h['payment_type'] =$payment_type ;
            $h['order_id'] =$order_id ;
            $h['merchant_id'] =$merchant_id ;
            $h['gross_amount'] =$gross_amount ;
            $h['fraud_status'] =$fraud_status ;
            $h['currency'] =$currency ;
            array_push($list, $h);
        }
        $Array = Array (
            "pesan" => "Success",
            "code" =>200,
            "list" =>$list
        );
	}
	$json = json_encode($Array, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
	header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (10 * 60)));
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header('Content-Type: application/json');
	header('Pragma: no-chache');
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Credentials: true');
	header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 
	header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, x-token, token"); 
	echo $json;
	exit();
    
?>