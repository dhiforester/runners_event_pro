<?php
    if(empty($_GET['Page'])){
        include "_Page/Dashboard/Dashboard.php";
    }else{
        $Page=$_GET['Page'];
        if($Page=="Modal"){
            include "_Page/Modal/Modal.php";
        }
        if($Page=="AksesFitur"){
            include "_Page/AksesFitur/AksesFitur.php";
        }
        if($Page=="AksesEntitas"){
            include "_Page/AksesEntitas/AksesEntitas.php";
        }
        if($Page=="Akses"){
            include "_Page/Akses/Akses.php";
        }
        if($Page=="Member"){
            include "_Page/Member/Member.php";
        }
        if($Page=="Event"){
            include "_Page/Event/Event.php";
        }
        if($Page=="Transaksi"){
            include "_Page/Transaksi/Transaksi.php";
        }
        if($Page=="RekapTransaksi"){
            include "_Page/RekapTransaksi/RekapTransaksi.php";
        }
        if($Page=="Version"){
            include "_Page/Version/Version.php";
        }
        if($Page=="EntitasAkses"){
            include "_Page/EntitasAkses/EntitasAkses.php";
        }
        if($Page=="ApiDoc"){
            include "_Page/ApiDoc/ApiDoc.php";
        }
        if($Page=="MyProfile"){
            include "_Page/MyProfile/MyProfile.php";
        }
        if($Page=="SettingGeneral"){
            include "_Page/SettingGeneral/SettingGeneral.php";
        }
        if($Page=="SettingPayment"){
            include "_Page/SettingPayment/SettingPayment.php";
        }
        if($Page=="SettingEmail"){
            include "_Page/SettingEmail/SettingEmail.php";
        }
        if($Page=="ApiKey"){
            include "_Page/ApiKey/ApiKey.php";
        }
        if($Page=="RegionalData"){
            include "_Page/RegionalData/RegionalData.php";
        }
        if($Page=="Help"){
            include "_Page/Help/Help.php";
        }
        if($Page=="RiwayatAnggota"){
            include "_Page/RiwayatAnggota/RiwayatAnggota.php";
        }
        if($Page=="Aktivitas"){
            include "_Page/Aktivitas/Aktivitas.php";
        }
        if($Page=="AkunPerkiraan"){
            include "_Page/AkunPerkiraan/AkunPerkiraan.php";
        }
        if($Page=="RekapitulasiTransaksi"){
            include "_Page/RekapitulasiTransaksi/RekapitulasiTransaksi.php";
        }
        if($Page=="Error"){
            include "_Page/Error/Error.php";
        }
    }
?>