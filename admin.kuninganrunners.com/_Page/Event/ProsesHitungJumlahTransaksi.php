<?php
    if(!empty($_POST['biaya_pendaftaran'])){
        $biaya_pendaftaran=$_POST['biaya_pendaftaran'];
    }else{
        $biaya_pendaftaran=0;
    }
    if(!empty($_POST['ppn'])){
        $ppn=$_POST['ppn'];
    }else{
        $ppn=0;
    }
    if(!empty($_POST['biaya_layanan'])){
        $biaya_layanan=$_POST['biaya_layanan'];
    }else{
        $biaya_layanan=0;
    }
    if(!empty($_POST['nominal_biaya'])){
        $nominal_biaya_arry=$_POST['nominal_biaya'];
        $nominal_biaya= array_filter($nominal_biaya_arry, function($value) {
            return is_numeric($value) && $value > 0;
        });
        $total_biaya = array_sum($nominal_biaya);
    }else{
        $total_biaya=0;
    }
    
    if(!empty($_POST['nominal_potongan'])){
        $nominal_potongan_arry=$_POST['nominal_potongan'];
        $nominal_potongan = array_filter($nominal_potongan_arry, function($value) {
            return is_numeric($value) && $value > 0;
        });
        $total_potongan = array_sum($nominal_potongan);
    }else{
        $total_potongan=0;
    }
    


    $jumlah_total_transaksi=($biaya_pendaftaran+$ppn+$biaya_layanan+$total_biaya)-$total_potongan;
    $response = ['jumlah' => $jumlah_total_transaksi];
    echo json_encode($response);
    exit;
?>