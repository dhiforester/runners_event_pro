<?php
    echo '<div class="pagetitle">';
    //Routing Page Title
    if(empty($_GET['Page'])){
        echo '<h1><a href=""><i class="bi bi-grid"></i> Dashboard</a></h1>';
        echo '<nav>';
        echo '  <ol class="breadcrumb">';
        echo '      <li class="breadcrumb-item active">Dashboard</li>';
        echo '  </ol>';
        echo '</nav>';
    }else{
        if($_GET['Page']=="MyProfile"){
            echo '<h1><a href=""><i class="bi bi-person-circle"></i> Profil Saya</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Profil Saya</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="AksesFitur"){
            echo '<h1><a href=""><i class="bi bi-app"></i> Fitur Aplikasi</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Fitur Aplikasi</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="AksesEntitas"){
            echo '<h1><a href=""><i class="bi bi-stars"></i> Entitas Akses</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Entitas Akses</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="Akses"){
            if(empty($_GET['Sub'])){
                echo '<h1><a href=""><i class="bi bi-person"></i> Akses</a></h1>';
                echo '<nav>';
                echo '  <ol class="breadcrumb">';
                echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                echo '      <li class="breadcrumb-item active">Akses</li>';
                echo '  </ol>';
                echo '</nav>';
            }else{
                if($_GET['Sub']=="AturIjinAkses"){
                    echo '<h1><i class="bi bi-person-badge"></i> Atur ijin Akses</h1>';
                    echo '<nav>';
                    echo '  <ol class="breadcrumb">';
                    echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                    echo '      <li class="breadcrumb-item"><a href="index.php?Page=Akses">Akses</a></li>';
                    echo '      <li class="breadcrumb-item active">Atur ijin Akses</li>';
                    echo '  </ol>';
                    echo '</nav>';
                }else{
                    if($_GET['Sub']=="DetailAkses"){
                        echo '<h1><i class="bi bi-person-badge"></i> Detail Akses</h1>';
                        echo '<nav>';
                        echo '  <ol class="breadcrumb">';
                        echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                        echo '      <li class="breadcrumb-item"><a href="index.php?Page=Akses">Akses</a></li>';
                        echo '      <li class="breadcrumb-item active">Detail Akses</li>';
                        echo '  </ol>';
                        echo '</nav>';
                    }
                }
            }
        }
        if($_GET['Page']=="Member"){
            echo '<h1><a href=""><i class="bi bi-people"></i> Member</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Member</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="Event"){
            echo '<h1><a href=""><i class="bi bi-calendar"></i> Event</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Event</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="Merchandise"){
            echo '<h1><a href=""><i class="bi bi-tag"></i> Merchandise</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Merchandise</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="RegistrasiEvent"){
            echo '<h1><a href=""><i class="bi bi-pencil"></i> Registrasi Event</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Registrasi Event</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        
        if($_GET['Page']=="TransaksiPenjualan"){
            echo '<h1><a href=""><i class="bi bi-cart-check"></i> Transaksi Penjualan</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Transaksi Penjualan</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="KontenUtama"){
            echo '<h1><a href=""><i class="bi bi-globe"></i> Web Konten</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Web Konten</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="Galeri"){
            echo '<h1><a href=""><i class="bi bi-image"></i> Galeri</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Galeri</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="Vidio"){
            echo '<h1><a href=""><i class="bi bi-youtube"></i> Konten Vidio</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Vidio</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="Testimoni"){
            echo '<h1><a href=""><i class="bi bi-chat-dots"></i> Testimoni</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Testimoni</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="SettingGeneral"){
            echo '<h1><a href=""><i class="bi bi-gear"></i> Pengaturan Umum</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Pengaturan Umum</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="SettingPayment"){
            echo '<h1><a href=""><i class="bi bi-coin"></i> Payment Gateway</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Payment Gateway</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="SettingEmail"){
            echo '<h1><a href=""><i class="bi bi-envelope"></i> Pengaturan Email</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Pengaturan Email</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="RajaOngkir"){
            echo '<h1><a href=""><i class="bi bi-envelope"></i> Raja Ongkir</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Raja Ongkir</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="ApiKey"){
            echo '<h1><a href=""><i class="bi bi-key"></i> API Key</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">API Key</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="RegionalData"){
            echo '<h1><a href=""><i class="bi bi-map"></i> Referensi Wilayah</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Referensi Wilayah</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="SettingTransaksi"){
            echo '<h1><a href=""><i class="bi bi-gear"></i> Setting Transaksi</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Setting Transaksi</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="LaporanTransaksi"){
            echo '<h1><a href=""><i class="bi bi-cart-check"></i> Laporan Transaksi</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Laporan Transaksi</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="Aktivitas"){
            echo '<h1><a href=""><i class="bi bi-record-btn"></i> Log Aktivitas</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Log Aktivitas</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="Viewer"){
            echo '<h1><a href=""><i class="bi bi-eye"></i> Web Viewer</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Web Viewer</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="Help"){
            echo '<h1><a href=""><i class="bi bi-question"></i> Bantuan</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Bantuan</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="Error"){
            echo '<h1><i class="bi bi-emoji-angry"></i> Error</h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Error</li>';
            echo '  </ol>';
            echo '</nav>';
        }
    }
    echo '</div>';
?>
