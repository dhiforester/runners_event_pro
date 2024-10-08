<?php
        include "_Config/Connection.php";
        include "_Config/Function.php";
        //Maual Setting
		$urll_call_back = getDataDetail($Conn, 'setting_payment', 'id_setting_payment', '1', 'urll_call_back');
		$id_marchant = getDataDetail($Conn, 'setting_payment', 'id_setting_payment', '1', 'id_marchant');
		$client_key = getDataDetail($Conn, 'setting_payment', 'id_setting_payment', '1', 'client_key');
		$server_key = getDataDetail($Conn, 'setting_payment', 'id_setting_payment', '1', 'server_key');
		$snap_url = getDataDetail($Conn, 'setting_payment', 'id_setting_payment', '1', 'snap_url');
		$production = getDataDetail($Conn, 'setting_payment', 'id_setting_payment', '1', 'production');
        require_once "midtrans-php-master/Midtrans.php";
        \Midtrans\Config::$isProduction = $production;
        \Midtrans\Config::$serverKey = ''.$server_key.'';
        $notif = new \Midtrans\Notification();
        $transaction_time = $notif->transaction_time;
        $transaction_status = $notif->transaction_status;
        $transaction_id = $notif->transaction_id;
        $status_message = $notif->status_message;
        $status_code = $notif->status_code;
        $signature_key = $notif->signature_key;
        $payment_type = $notif->payment_type;
        $order_id = $notif->order_id;
        $merchant_id = $notif->merchant_id;
        $fraud_status = $notif->fraud_status;
        $currency = $notif->currency;
        $gross_amount=$notif->gross_amount;
        //Mencari nilai kode transaksi
        $kode_transaksi=getDataDetail($Conn,'log_payment','order_id',$order_id,'kode_transaksi');
        if(empty($kode_transaksi)){
            $log = Array (
                "ServerKey" => $server_key,
                "Production" => $production,
                "order_id" => $order_id,
                "Notification" => $notif,
                "transaction_time" => $transaction_time,
                "transaction_status" => $transaction_status,
                "gross_amount" => $gross_amount,
                "kode_transaksi" => $kode_transaksi
            );
            $JsonLog = json_encode($log);
            //Simpan Data
            $simpan=InsertKodeTransaksi($Conn,$order_id,$kode_transaksi,$JsonLog);
        }else{
            $log = Array (
                "ServerKey" => $server_key,
                "Production" => $production,
                "order_id" => $order_id,
                "Notification" => $notif,
                "transaction_time" => $transaction_time,
                "transaction_status" => $transaction_status,
                "gross_amount" => $gross_amount,
                "kode_transaksi" => $kode_transaksi
            );
            $JsonLog = json_encode($log);
            //Simpan Data
            $simpan=UpdateKodeTransaksi($Conn,$order_id,$kode_transaksi,$JsonLog);
        }
        $KodeTransaksi2=getDataDetail($Conn,'order_transaksi','order_id',$order_id,'kode_transaksi');
        if(!empty($KodeTransaksi2)){
            if($transaction_status=="pending"){
                $StatusPembayaran="Pending";
            }else{
                if($transaction_status=="settlement"){
                    $StatusPembayaran="Lunas";
                    $UpdateStatusTransaksiAdmin=UpdateStatusTransaksiAdmin($api_key,$urll_call_back,$KodeTransaksi2,$StatusPembayaran);
                }else{
                    $StatusPembayaran="Expired";
                }
            }
        }
        if($transaction_status == 'capture'){
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($payment_type == 'credit_card'){
                if($fraud == 'challenge'){
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    $keterangan="Transaction order_id: " . $order_id ." is challenged by FDS";
                }else {
                    // TODO set payment status in merchant's database to 'Success'
                    $keterangan="Transaction order_id: " . $order_id ." successfully captured using " . $payment_type;
                }
            }else{
                if ($transaction == 'settlement'){
                    // TODO set payment status in merchant's database to 'Settlement'
                    $keterangan= "Transaction order_id: " . $order_id ." successfully transfered using " . $payment_type;
                }else{
                    if($transaction == 'pending'){
                        // TODO set payment status in merchant's database to 'Pending'
                        $keterangan="Waiting customer to finish transaction order_id: " . $order_id . " using " . $payment_type;
                    }else{
                        if ($transaction == 'deny') {
                            // TODO set payment status in merchant's database to 'Denied'
                            $keterangan="Payment using " . $payment_type . " for transaction order_id: " . $order_id . " is denied.";
                        }else{
                            if ($transaction == 'expire') {
                                // TODO set payment status in merchant's database to 'expire'
                                $keterangan="Payment using " . $payment_type . " for transaction order_id: " . $order_id . " is expired.";
                            }else{
                                if ($transaction == 'cancel') {
                                    // TODO set payment status in merchant's database to 'Denied'
                                    $keterangan="Payment using " . $payment_type . " for transaction order_id: " . $order_id . " is canceled.";
                                }else{
                                    $keterangan="Undefine transaction: $transaction Order ID: " . $order_id ." successfully captured using " . $payment_type;
                                }
                            }
                        }
                    }
                }
            }
        }else{
            $keterangan="Error transaction: " . $order_id ." successfully captured using " . $payment_type;
        }
        $entry="INSERT INTO log_payment (
            kode_transaksi,
            transaction_time,
            transaction_status,
            transaction_id,
            status_message,
            status_code,
            signature_key,
            payment_type,
            order_id,
            merchant_id,
            gross_amount,
            fraud_status,
            currency
        ) VALUES (
            '$kode_transaksi',
            '$transaction_time',
            '$transaction_status',
            '$transaction_id',
            '$status_message',
            '$status_code',
            '$signature_key',
            '$payment_type',
            '$order_id',
            '$merchant_id',
            '$gross_amount',
            '$fraud_status',
            '$currency'
        )";
        $Input=mysqli_query($Conn, $entry);
        if($Input){
            echo "$keterangan";
        }else{
            echo "Input Data Gagal";
        }
?>