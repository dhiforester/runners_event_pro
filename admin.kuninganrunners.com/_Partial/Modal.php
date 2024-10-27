<?php
    include "_Page/Logout/ModalLogout.php";
    if(empty($_GET['Page'])){
        include "_Page/Dashboard/ModalDashboard.php";
    }else{
        $Page=$_GET['Page'];
        if($Page=="Modal"){
            include "_Page/Modal/ModalModal.php";
        }
        if($Page=="MyProfile"){
            include "_Page/MyProfile/ModalMyProfile.php";
        }
        if($Page=="AksesFitur"){
            include "_Page/AksesFitur/ModalAksesFitur.php";
        }
        if($Page=="AksesEntitas"){
            include "_Page/AksesEntitas/ModalAksesEntitas.php";
        }
        if($Page=="Akses"){
            include "_Page/Akses/ModalAkses.php";
        }
        if($Page=="Member"){
            include "_Page/Member/ModalMember.php";
        }
        if($Page=="Event"){
            include "_Page/Event/ModalEvent.php";
        }
        if($Page=="Merchandise"){
            include "_Page/Merchandise/ModalMerchandise.php";
        }
        if($Page=="Transaksi"){
            include "_Page/Transaksi/ModalTransaksi.php";
        }
        if($Page=="KontenUtama"){
            include "_Page/KontenUtama/ModalKontenUtama.php";
        }
        if($Page=="Galeri"){
            include "_Page/Galeri/ModalGaleri.php";
        }
        if($Page=="Help"){
            include "_Page/Help/ModalHelp.php";
        }
        if($Page=="SettingGeneral"){
            include "_Page/SettingGeneral/ModalSettingGeneral.php";
        }
        if($Page=="SettingPayment"){
            include "_Page/SettingPayment/ModalSettingPayment.php";
        }
        if($Page=="SettingEmail"){
            include "_Page/SettingEmail/ModalSettingEmail.php";
        }
        if($Page=="ApiKey"){
            include "_Page/ApiKey/ModalApiKey.php";
        }
        if($Page=="RegionalData"){
            include "_Page/RegionalData/ModalRegionalData.php";
        }
        if($Page=="Aktivitas"){
            include "_Page/Aktivitas/ModalAktivitas.php";
        }
    }
?>