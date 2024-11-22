<?php
    // Pastikan ada data yang dikirimkan
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(empty($_POST['item_keranjang'])){
            $subtotal = 0;
        }else{
            $subtotal = 0;
            $item_keranjang =$_POST['item_keranjang'];
            //Looping semua jumlah
            foreach ($item_keranjang as $item_keranjang_list) {
                $explode=explode('|',$item_keranjang_list);
                $jumlah=$explode[4];
                $subtotal = $subtotal+$jumlah;
            }
        }
        // Format subtotal ke format Rupiah
        $subtotal_format = 'Rp ' . number_format($subtotal, 0, ',', '.');
        // Return subtotal
        echo $subtotal_format;
    } else {
        // Jika request method tidak valid
        echo "Invalid request";
    }
?>