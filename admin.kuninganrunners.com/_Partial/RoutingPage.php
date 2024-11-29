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
        if($Page=="Merchandise"){
            include "_Page/Merchandise/Merchandise.php";
        }
        if($Page=="RegistrasiEvent"){
            include "_Page/RegistrasiEvent/RegistrasiEvent.php";
        }
        if($Page=="TransaksiPenjualan"){
            include "_Page/TransaksiPenjualan/TransaksiPenjualan.php";
        }
        if($Page=="KontenUtama"){
            include "_Page/KontenUtama/KontenUtama.php";
        }
        if($Page=="Galeri"){
            include "_Page/Galeri/Galeri.php";
        }
        if($Page=="Vidio"){
            include "_Page/Vidio/Vidio.php";
        }
        if($Page=="Testimoni"){
            include "_Page/Testimoni/Testimoni.php";
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
        if($Page=="SettingTransaksi"){
            include "_Page/SettingTransaksi/SettingTransaksi.php";
        }
        if($Page=="Help"){
            include "_Page/Help/Help.php";
        }
        if($Page=="LaporanTransaksi"){
            include "_Page/LaporanTransaksi/LaporanTransaksi.php";
        }
        if($Page=="Aktivitas"){
            include "_Page/Aktivitas/Aktivitas.php";
        }
        if($Page=="Viewer"){
            include "_Page/Viewer/Viewer.php";
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