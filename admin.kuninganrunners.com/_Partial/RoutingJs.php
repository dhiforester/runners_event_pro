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
        if($Page=="Member"){
            echo '<script type="text/javascript" src="_Page/Member/Member.js"></script>';
        }
        if($Page=="Event"){
            echo '<script type="text/javascript" src="_Page/Event/Event.js"></script>';
        }
        if($Page=="Merchandise"){
            echo '<script type="text/javascript" src="_Page/Merchandise/Merchandise.js"></script>';
        }
        if($Page=="RegistrasiEvent"){
            echo '<script type="text/javascript" src="_Page/RegistrasiEvent/RegistrasiEvent.js"></script>';
        }
        if($Page=="TransaksiPenjualan"){
            echo '<script type="text/javascript" src="_Page/TransaksiPenjualan/TransaksiPenjualan.js?v='.date('YmdHis').'"></script>';
        }
        if($Page=="RekapTransaksi"){
            echo '<script type="text/javascript" src="_Page/RekapTransaksi/RekapTransaksi.js"></script>';
        }
        if($Page=="KontenUtama"){
            echo '<script type="text/javascript" src="_Page/KontenUtama/KontenUtama.js"></script>';
        }
        if($Page=="Galeri"){
            echo '<script type="text/javascript" src="_Page/Galeri/Galeri.js"></script>';
        }
        if($Page=="Vidio"){
            echo '<script type="text/javascript" src="_Page/Vidio/Vidio.js"></script>';
        }
        if($Page=="Testimoni"){
            echo '<script type="text/javascript" src="_Page/Testimoni/Testimoni.js"></script>';
        }
        if($Page=="SettingGeneral"){
            echo '<script type="text/javascript" src="_Page/SettingGeneral/SettingGeneral.js"></script>';
        }
        if($Page=="SettingPayment"){
            echo '<script type="text/javascript" src="_Page/SettingPayment/SettingPayment.js"></script>';
        }
        if($Page=="SettingEmail"){
            echo '<script type="text/javascript" src="_Page/SettingEmail/SettingEmail.js"></script>';
        }
        if($Page=="RajaOngkir"){
            echo '<script type="text/javascript" src="_Page/RajaOngkir/RajaOngkir.js"></script>';
        }
        if($Page=="ApiKey"){
            echo '<script type="text/javascript" src="_Page/ApiKey/ApiKey.js"></script>';
        }
        if($Page=="RegionalData"){
            echo '<script type="text/javascript" src="_Page/RegionalData/RegionalData.js"></script>';
        }
        if($Page=="SettingTransaksi"){
            echo '<script type="text/javascript" src="_Page/SettingTransaksi/SettingTransaksi.js"></script>';
        }
        if($Page=="LaporanTransaksi"){
            echo '<script type="text/javascript" src="_Page/LaporanTransaksi/LaporanTransaksi.js?v='.date('YmdHis').'"></script>';
        }
        if($Page=="Aktivitas"){
            echo '<script type="text/javascript" src="_Page/Aktivitas/Aktivitas.js"></script>';
        }
        if($Page=="Viewer"){
            echo '<script type="text/javascript" src="_Page/Viewer/Viewer.js"></script>';
        }
        if($Page=="Help"){
            echo '<script type="text/javascript" src="_Page/Help/Help.js"></script>';
        }
    }
    //default Login
    // echo '<script type="text/javascript" src="_Page/Pendaftaran/Pendaftaran.js"></script>';
    echo '<script type="text/javascript" src="_Page/Login/Login.js"></script>';
    // echo '<script type="text/javascript" src="_Page/ResetPassword/ResetPassword.js"></script>';
?>