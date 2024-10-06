<?php
    //Karena Ini Di running Dengan JS maka Panggil Ulang Koneksi
    include "../_Config/Connection.php";
    $JumlahPesertaBaru=0;
    $JumlahPembayaranBaru=0;
    $JumlahNotifikasi=$JumlahPesertaBaru+$JumlahPembayaranBaru;
    //Apabila ada notifgikasi
    if(!empty($JumlahNotifikasi)){
        echo '<i class="bi bi-bell"></i>';
        echo '<span class="badge bg-danger rounded-pill badge-number">'.$JumlahNotifikasi.'</span>';
    }else{
        //Apabila Tidak Ada
        echo '<i class="bi bi-bell"></i>';
    }
?>