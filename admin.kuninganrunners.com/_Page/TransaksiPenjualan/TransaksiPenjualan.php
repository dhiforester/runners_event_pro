<?php
    if(empty($_GET['Sub'])){
        include "_Page/TransaksiPenjualan/TransaksiPenjualanHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="Detail"){
            include "_Page/TransaksiPenjualan/DetailTransaksiPenjualan.php";
        }else{
            if($Sub=="Tambah"){
                include "_Page/TransaksiPenjualan/TambahTransaksiPenjualan.php";
            }else{
                include "_Page/TransaksiPenjualan/TransaksiPenjualanHome.php";
            }
        }
    }
?>