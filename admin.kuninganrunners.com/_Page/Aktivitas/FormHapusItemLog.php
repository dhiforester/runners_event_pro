<?php
    //Menghitung Data Yang Ditangkap Dati Tabel
    if(!empty($_POST['CheckLogItem'])){
        $CheckLogItem=$_POST['CheckLogItem'];
        //Hitung Count
        $JumlahDipilih=count($CheckLogItem);
        foreach($CheckLogItem as $List){
            echo '<input type="hidden" name="id_log[]" value="'.$List.'">';
        }
        echo "Dipilih $JumlahDipilih Record<br>";
    }else{
        echo "Tidak Ada Data Log Record Yang Dipilih<br>";
    }
?>