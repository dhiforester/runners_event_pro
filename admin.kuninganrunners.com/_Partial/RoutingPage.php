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
        if($Page=="Anggota"){
            include "_Page/Anggota/Anggota.php";
        }
        if($Page=="AnggotaKeluarMasuk"){
            include "_Page/AnggotaKeluarMasuk/AnggotaKeluarMasuk.php";
        }
        if($Page=="RekapAnggota"){
            include "_Page/RekapAnggota/RekapAnggota.php";
        }
        if($Page=="JenisSimpanan"){
            include "_Page/JenisSimpanan/JenisSimpanan.php";
        }
        if($Page=="SimpananWajib"){
            include "_Page/SimpananWajib/SimpananWajib.php";
        }
        if($Page=="RekapSimpanan"){
            include "_Page/RekapSimpanan/RekapSimpanan.php";
        }
        if($Page=="Tagihan"){
            include "_Page/Tagihan/Tagihan.php";
        }
        if($Page=="RekapPinjaman"){
            include "_Page/RekapPinjaman/RekapPinjaman.php";
        }
        if($Page=="JenisTransaksi"){
            include "_Page/JenisTransaksi/JenisTransaksi.php";
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
        if($Page=="Tabungan"){
            include "_Page/Tabungan/Tabungan.php";
        }
        if($Page=="Pinjaman"){
            include "_Page/Pinjaman/Pinjaman.php";
        }
        if($Page=="AutoJurnal"){
            include "_Page/AutoJurnal/AutoJurnal.php";
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
        if($Page=="Jurnal"){
            include "_Page/Jurnal/Jurnal.php";
        }
        if($Page=="SimpanPinjam"){
            include "_Page/SimpanPinjam/SimpanPinjam.php";
        }
        if($Page=="BukuBesar"){
            include "_Page/BukuBesar/BukuBesar.php";
        }
        if($Page=="NeracaSaldo"){
            include "_Page/NeracaSaldo/NeracaSaldo.php";
        }
        if($Page=="LabaRugi"){
            include "_Page/LabaRugi/LabaRugi.php";
        }
        if($Page=="RekapitulasiTransaksi"){
            include "_Page/RekapitulasiTransaksi/RekapitulasiTransaksi.php";
        }
        if($Page=="BagiHasil"){
            include "_Page/BagiHasil/BagiHasil.php";
        }
        if($Page=="CetakInvoice"){
            include "_Page/CetakInvoice/CetakInvoice.php";
        }
        if($Page=="Error"){
            include "_Page/Error/Error.php";
        }
    }
?>