<?php
    if(empty($_GET['Page'])){
        $PageMenu="";
    }else{
        $PageMenu=$_GET['Page'];
    }
    if(empty($_GET['Sub'])){
        $SubMenu="";
    }else{
        $SubMenu=$_GET['Sub'];
    }
?>
<aside id="sidebar" class="sidebar menu_background">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu==""){echo "";}else{echo "collapsed";} ?>" href="index.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu=="AksesFitur"||$PageMenu=="AksesEntitas"||$PageMenu=="Akses"){echo "";}else{echo "collapsed";} ?>" data-bs-target="#akses-nav" data-bs-toggle="collapse" href="javascript:void(0);">
                <i class="bi bi-person"></i>
                <span>Akses</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="akses-nav" class="nav-content collapse <?php if($PageMenu=="AksesFitur"||$PageMenu=="AksesEntitas"||$PageMenu=="Akses"){echo "show";} ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="index.php?Page=AksesFitur" class="<?php if($PageMenu=="AksesFitur"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Fitur Aplikasi</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?Page=AksesEntitas" class="<?php if($PageMenu=="AksesEntitas"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Entitas/Level</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?Page=Akses" class="<?php if($PageMenu=="Akses"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Akun Akses</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu!=="Member"){echo "collapsed";} ?>" href="index.php?Page=Member">
                <i class="bi bi-people"></i>
                <span>Member</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu!=="Event"){echo "collapsed";} ?>" href="index.php?Page=Event">
                <i class="bi bi-calendar"></i>
                <span>Event</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu!=="Merchandise"){echo "collapsed";} ?>" href="index.php?Page=Merchandise">
                <i class="bi bi-tag"></i>
                <span>Merchandise</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu=="RegistrasiEvent"||$PageMenu=="TransaksiPenjualan"||$PageMenu=="LogPayment"){echo "";}else{echo "collapsed";} ?>" data-bs-target="#transaksi-nav" data-bs-toggle="collapse" href="javascript:void(0);">
                <i class="bi bi-cash-coin"></i>
                <span>Transaksi</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="transaksi-nav" class="nav-content collapse <?php if($PageMenu=="RegistrasiEvent"||$PageMenu=="TransaksiPenjualan"||$PageMenu=="LogPayment"){echo "show";} ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="index.php?Page=RegistrasiEvent" class="<?php if($PageMenu=="RegistrasiEvent"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Registrasi Event</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?Page=TransaksiPenjualan" class="<?php if($PageMenu=="TransaksiPenjualan"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Penjualan Merch</span>
                    </a>
                </li>
                <!-- <li>
                    <a href="index.php?Page=LogPayment" class="<?php if($PageMenu=="LogPayment"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Log Payment</span>
                    </a>
                </li> -->
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu=="KontenUtama"||$PageMenu=="Galeri"||$PageMenu=="Testimoni"||$PageMenu=="Vidio"||$PageMenu=="RekapitulasiTransaksi"){echo "";}else{echo "collapsed";} ?>" data-bs-target="#web-nav" data-bs-toggle="collapse" href="javascript:void(0);">
                <i class="bi bi-globe"></i>
                <span>Konten Web</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="web-nav" class="nav-content collapse <?php if($PageMenu=="KontenUtama"||$PageMenu=="Galeri"||$PageMenu=="Testimoni"||$PageMenu=="Vidio"||$PageMenu=="RekapitulasiTransaksi"){echo "show";} ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="index.php?Page=KontenUtama" class="<?php if($PageMenu=="KontenUtama"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Konten Utama</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?Page=Galeri" class="<?php if($PageMenu=="Galeri"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Galeri/Album</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?Page=Vidio" class="<?php if($PageMenu=="Vidio"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Konten Vidio</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?Page=Testimoni" class="<?php if($PageMenu=="Testimoni"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Testimoni</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu=="Aktivitas"||$PageMenu=="Viewer"||$PageMenu=="LaporanTransaksi"||$PageMenu=="LabaRugi"||$PageMenu=="RekapitulasiTransaksi"){echo "";}else{echo "collapsed";} ?>" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="javascript:void(0);">
                <i class="bi bi-bar-chart"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="charts-nav" class="nav-content collapse <?php if($PageMenu=="Aktivitas"||$PageMenu=="Viewer"||$PageMenu=="LaporanTransaksi"||$PageMenu=="LabaRugi"||$PageMenu=="RekapitulasiTransaksi"){echo "show";} ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="index.php?Page=LaporanTransaksi" class="<?php if($PageMenu=="LaporanTransaksi"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Transaksi</span>
                    </a>
                    <a href="index.php?Page=Aktivitas" class="<?php if($PageMenu=="Aktivitas"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Log Sistem</span>
                    </a>
                    <a href="index.php?Page=Viewer" class="<?php if($PageMenu=="Viewer"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Web Viewer</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu=="SettingGeneral"||$PageMenu=="SettingEmail"||$PageMenu=="SettingPayment"||$PageMenu=="ApiKey"||$PageMenu=="RegionalData"||$PageMenu=="SettingTransaksi"){echo "";}else{echo "collapsed";} ?>" data-bs-target="#components-nav" data-bs-toggle="collapse" href="javascript:void(0);">
                <i class="bi bi-gear"></i>
                    <span>Pengaturan</span><i class="bi bi-chevron-down ms-auto">
                </i>
            </a>
            <ul id="components-nav" class="nav-content collapse <?php if($PageMenu=="SettingGeneral"||$PageMenu=="SettingEmail"||$PageMenu=="SettingPayment"||$PageMenu=="ApiKey"||$PageMenu=="RegionalData"||$PageMenu=="SettingTransaksi"){echo "show";} ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="index.php?Page=SettingGeneral" class="<?php if($PageMenu=="SettingGeneral"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Pengaturan Umum</span>
                    </a>
                </li> 
                <li>
                    <a href="index.php?Page=SettingPayment" class="<?php if($PageMenu=="SettingPayment"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Payment Gateway</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?Page=SettingEmail" class="<?php if($PageMenu=="SettingEmail"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Email Gateway</span>
                    </a>
                </li> 
                <li>
                    <a href="index.php?Page=RajaOngkir" class="<?php if($PageMenu=="RajaOngkir"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Raja Ongkir</span>
                    </a>
                </li> 
                <li>
                    <a href="index.php?Page=ApiKey" class="<?php if($PageMenu=="ApiKey"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>API Key</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?Page=RegionalData" class="<?php if($PageMenu=="RegionalData"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Wilayah</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?Page=SettingTransaksi" class="<?php if($PageMenu=="SettingTransaksi"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Transaksi</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-heading">Fitur Lainnya</li>
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu!=="Help"){echo "collapsed";} ?>" href="index.php?Page=Help&Sub=HelpData">
                <i class="bi bi-question"></i>
                <span>Bantuan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalLogout">
                <i class="bi bi-box-arrow-in-left"></i>
                <span>Keluar</span>
            </a>
        </li>
    </ul>
</aside> 