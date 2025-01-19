<?php
    $response = ['success' => false, 'message' => ''];
    if(empty($_POST['origin'])){
        $response = ['success' => false, 'message' => 'Anda Belum Memilih Lokasii Asal Pengiriman'];
    }else{
        $origin=$_POST['origin'];
        $explode=explode('|',$origin);
        $origin_id=$explode[0];
        $origin_label=$explode[1];
        $response = ['success' => true, 'message' => 'Data Berhasil Di Proses', 'OriginId' => $origin_id, 'OriginLabel' => $origin_label,];
    }
    echo json_encode($response);
?>