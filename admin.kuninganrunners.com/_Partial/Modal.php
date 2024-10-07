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
        if($Page=="Anggota"){
            include "_Page/Anggota/ModalAnggota.php";
        }
        if($Page=="AnggotaKeluarMasuk"){
            include "_Page/AnggotaKeluarMasuk/ModalAnggotaKeluarMasuk.php";
        }
        if($Page=="RekapAnggota"){
            include "_Page/RekapAnggota/ModalRekapAnggota.php";
        }
        if($Page=="JenisSimpanan"){
            include "_Page/JenisSimpanan/ModalJenisSimpanan.php";
        }
        if($Page=="SimpananWajib"){
            include "_Page/SimpananWajib/ModalSimpananWajib.php";
        }
        if($Page=="Tagihan"){
            include "_Page/Tagihan/ModalTagihan.php";
        }
        if($Page=="RekapSimpanan"){
            include "_Page/RekapSimpanan/ModalRekapSimpanan.php";
        }
        if($Page=="RekapPinjaman"){
            include "_Page/RekapPinjaman/ModalRekapPinjaman.php";
        }
        if($Page=="JenisTransaksi"){
            include "_Page/JenisTransaksi/ModalJenisTransaksi.php";
        }
        if($Page=="Transaksi"){
            include "_Page/Transaksi/ModalTransaksi.php";
        }
        if($Page=="RekapTransaksi"){
            include "_Page/RekapTransaksi/ModalRekapTransaksi.php";
        }
        if($Page=="EntitasAkses"){
            include "_Page/EntitasAkses/ModalEntitasAkses.php";
        }
        if($Page=="Tabungan"){
            include "_Page/Tabungan/ModalTabungan.php";
        }
        if($Page=="Pinjaman"){
            include "_Page/Pinjaman/ModalPinjaman.php";
        }
        if($Page=="AutoJurnal"){
            include "_Page/AutoJurnal/ModalAutoJurnal.php";
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
        if($Page=="Supplier"){
            include "_Page/Supplier/ModalSupplier.php";
        }
        
        if($Page=="Pembayaran"){
            include "_Page/Pembayaran/ModalPembayaran.php";
        }
        if($Page=="Aktivitas"){
            include "_Page/Aktivitas/ModalAktivitas.php";
        }
        if($Page=="AkunPerkiraan"){
            include "_Page/AkunPerkiraan/ModalAkunPerkiraan.php";
        }
        if($Page=="Jurnal"){
            include "_Page/Jurnal/ModalJurnal.php";
        }
        if($Page=="BukuBesar"){
            include "_Page/BukuBesar/ModalBukuBesar.php";
        }
        if($Page=="NeracaSaldo"){
            include "_Page/NeracaSaldo/ModalNeracaSaldo.php";
        }
        if($Page=="LabaRugi"){
            include "_Page/LabaRugi/ModalLabaRugi.php";
        }
        if($Page=="RekapitulasiTransaksi"){
            include "_Page/RekapitulasiTransaksi/ModalRekapitulasiTransaksi.php";
        }
        if($Page=="BagiHasil"){
            include "_Page/BagiHasil/ModalBagiHasil.php";
        }
    }
?>