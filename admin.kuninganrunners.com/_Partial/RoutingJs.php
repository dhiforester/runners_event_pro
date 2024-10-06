<script type="text/javascript">
    //Detail Akses
    $('#scrollingModal2').on('show.bs.modal', function (e) {
        $('#IsiModalBody').html("<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>");
    });
</script>
<?php 
    echo '<script type="text/javascript" src="_Partial/Universal.js"></script>';
    if(empty($_GET['Page'])){
        echo '<script type="text/javascript" src="_Page/Dashboard/Dashboard.js"></script>';
    }else{
        $Page=$_GET['Page'];
        if($Page=="MyProfile"){
            echo '<script type="text/javascript" src="_Page/MyProfile/MyProfile.js"></script>';
        }
        if($Page=="AksesFitur"){
            echo '<script type="text/javascript" src="_Page/AksesFitur/AksesFitur.js"></script>';
        }
        if($Page=="AksesEntitas"){
            echo '<script type="text/javascript" src="_Page/AksesEntitas/AksesEntitas.js"></script>';
        }
        if($Page=="Akses"){
            echo '<script type="text/javascript" src="_Page/Akses/Akses.js"></script>';
        }
        if($Page=="Anggota"){
            echo '<script type="text/javascript" src="_Page/Anggota/Anggota.js"></script>';
        }
        if($Page=="AnggotaKeluarMasuk"){
            echo '<script type="text/javascript" src="_Page/AnggotaKeluarMasuk/AnggotaKeluarMasuk.js"></script>';
        }
        if($Page=="RekapAnggota"){
            echo '<script type="text/javascript" src="_Page/RekapAnggota/RekapAnggota.js"></script>';
        }
        if($Page=="JenisSimpanan"){
            echo '<script type="text/javascript" src="_Page/JenisSimpanan/JenisSimpanan.js"></script>';
        }
        if($Page=="SimpananWajib"){
            echo '<script type="text/javascript" src="_Page/SimpananWajib/SimpananWajib.js"></script>';
        }
        if($Page=="Tabungan"){
            echo '<script type="text/javascript" src="_Page/Tabungan/Tabungan.js"></script>';
        }
        if($Page=="RekapSimpanan"){
            echo '<script type="text/javascript" src="_Page/RekapSimpanan/RekapSimpanan.js"></script>';
        }
        if($Page=="Pinjaman"){
            echo '<script type="text/javascript" src="_Page/Pinjaman/Pinjaman.js"></script>';
        }
        if($Page=="Tagihan"){
            echo '<script type="text/javascript" src="_Page/Tagihan/Tagihan.js"></script>';
        }
        if($Page=="RekapPinjaman"){
            echo '<script type="text/javascript" src="_Page/RekapPinjaman/RekapPinjaman.js"></script>';
        }
        if($Page=="JenisTransaksi"){
            echo '<script type="text/javascript" src="_Page/JenisTransaksi/JenisTransaksi.js"></script>';
        }
        if($Page=="Transaksi"){
            echo '<script type="text/javascript" src="_Page/Transaksi/Transaksi.js"></script>';
        }
        if($Page=="RekapTransaksi"){
            echo '<script type="text/javascript" src="_Page/RekapTransaksi/RekapTransaksi.js"></script>';
        }
        if($Page=="AkunPerkiraan"){
            echo '<script type="text/javascript" src="_Page/AkunPerkiraan/AkunPerkiraan.js"></script>';
        }
        if($Page=="Jurnal"){
            echo '<script type="text/javascript" src="_Page/Jurnal/Jurnal.js"></script>';
        }
        if($Page=="BagiHasil"){
            echo '<script type="text/javascript" src="_Page/BagiHasil/BagiHasil.js"></script>';
        }
        if($Page=="SettingGeneral"){
            echo '<script type="text/javascript" src="_Page/SettingGeneral/SettingGeneral.js"></script>';
        }
        if($Page=="EntitasAkses"){
            echo '<script type="text/javascript" src="_Page/EntitasAkses/EntitasAkses.js"></script>';
        }
        if($Page=="ApiDoc"){
            echo '<script type="text/javascript" src="_Page/ApiDoc/ApiDoc.js"></script>';
        }
        if($Page=="AutoJurnal"){
            echo '<script type="text/javascript" src="_Page/AutoJurnal/AutoJurnal.js"></script>';
        }
        if($Page=="SettingPayment"){
            echo '<script type="text/javascript" src="_Page/SettingPayment/SettingPayment.js"></script>';
        }
        if($Page=="SettingEmail"){
            echo '<script type="text/javascript" src="_Page/SettingService/SettingService.js"></script>';
        }
        if($Page=="ApiKey"){
            echo '<script type="text/javascript" src="_Page/ApiKey/ApiKey.js"></script>';
        }
        if($Page=="Pendaftaran"){
            echo '<script type="text/javascript" src="_Page/Pendaftaran/Pendaftaran.js"></script>';
        }
        if($Page=="Pembayaran"){
            echo '<script type="text/javascript" src="_Page/Pembayaran/Pembayaran.js"></script>';
        }
        if($Page=="Aktivitas"){
            echo '<script type="text/javascript" src="_Page/Aktivitas/Aktivitas.js"></script>';
        }
        if($Page=="SimpanPinjam"){
            echo '<script type="text/javascript" src="_Page/SimpanPinjam/SimpanPinjam.js"></script>';
        }
        if($Page=="BukuBesar"){
            echo '<script type="text/javascript" src="_Page/BukuBesar/BukuBesar.js"></script>';
        }
        if($Page=="NeracaSaldo"){
            echo '<script type="text/javascript" src="_Page/NeracaSaldo/NeracaSaldo.js"></script>';
        }
        if($Page=="LabaRugi"){
            echo '<script type="text/javascript" src="_Page/LabaRugi/LabaRugi.js"></script>';
        }
        if($Page=="RekapitulasiTransaksi"){
            echo '<script type="text/javascript" src="_Page/RekapitulasiTransaksi/RekapitulasiTransaksi.js"></script>';
        }
        if($Page=="RiwayatAnggota"){
            echo '<script type="text/javascript" src="_Page/RiwayatAnggota/RiwayatAnggota.js"></script>';
        }
        if($Page=="Help"){
            echo '<script type="text/javascript" src="_Page/Help/Help.js"></script>';
        }
    }
    //default Login
    echo '<script type="text/javascript" src="_Page/Pendaftaran/Pendaftaran.js"></script>';
    echo '<script type="text/javascript" src="_Page/Login/Login.js"></script>';
    echo '<script type="text/javascript" src="_Page/ResetPassword/ResetPassword.js"></script>';
?>