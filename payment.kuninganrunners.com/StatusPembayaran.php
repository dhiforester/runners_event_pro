<?php
    include "Connection.php";
    if(!empty($_GET['order_id'])){
        $order_id=$_GET['order_id'];
        //buka data transaksi
        $QryTransaksi = mysqli_query($Conn,"SELECT * FROM log_payment WHERE order_id='$order_id' ORDER BY id_log_payment DESC")or die(mysqli_error($Conn));
        $DataTransaksi = mysqli_fetch_array($QryTransaksi);
        $transaction_status = $DataTransaksi['transaction_status'];
        $metadata = Array (
            "transaction_status" => "$transaction_status",
            "pesan" => "Berhasil",
            "code" => 200
        );
        $Array = Array (
            "metadata" => $metadata
        );
    }else{
        if(!empty($_GET['kode_transaksi'])){
            $kode_transaksi=$_GET['kode_transaksi'];
            //buka data transaksi
            $QryTransaksi = mysqli_query($Conn,"SELECT * FROM log_payment WHERE kode_transaksi='$kode_transaksi' ORDER BY id_log_payment DESC")or die(mysqli_error($Conn));
            $DataTransaksi = mysqli_fetch_array($QryTransaksi);
            $transaction_status = $DataTransaksi['transaction_status'];
            $metadata = Array (
                "transaction_status" => "$transaction_status",
                "pesan" => "Berhasil",
                "code" => 200
            );
            $Array = Array (
                "metadata" => $metadata
            );
        }else{
            $metadata = Array (
                "pesan" => "order id tidak boleh kosong",
                "code" => 201
            );
            $Array = Array (
                "metadata" => $metadata
            );
        }
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