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
        if($_GET['Page']=="Transaksi"){
            if(empty($_GET['Sub'])){
                echo '<h1><a href=""><i class="bi bi-cart-check"></i> Transaksi</a></h1>';
                echo '<nav>';
                echo '  <ol class="breadcrumb">';
                echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                echo '      <li class="breadcrumb-item active">Transaksi</li>';
                echo '  </ol>';
                echo '</nav>';
            }else{
                $Sub=$_GET['Sub'];
                if($Sub=="TambahTransaksi"){
                    echo '<h1><a href=""><i class="bi bi-cart-check"></i> Transaksi</a></h1>';
                    echo '<nav>';
                    echo '  <ol class="breadcrumb">';
                    echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                    echo '      <li class="breadcrumb-item"><a href="index.php?Page=Transaksi">Transaksi</a></li>';
                    echo '      <li class="breadcrumb-item active">Tambah Transaksi</li>';
                    echo '  </ol>';
                    echo '</nav>';
                }else{
                    if($Sub=="DetailTransaksi"){
                        echo '<h1><a href=""><i class="bi bi-cart-check"></i> Transaksi</a></h1>';
                        echo '<nav>';
                        echo '  <ol class="breadcrumb">';
                        echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                        echo '      <li class="breadcrumb-item"><a href="index.php?Page=Transaksi">Transaksi</a></li>';
                        echo '      <li class="breadcrumb-item active">Detail Transaksi</li>';
                        echo '  </ol>';
                        echo '</nav>';
                    }else{
                        if($Sub=="EditTransaksi"){
                            echo '<h1><a href=""><i class="bi bi-cart-check"></i> Transaksi</a></h1>';
                            echo '<nav>';
                            echo '  <ol class="breadcrumb">';
                            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                            echo '      <li class="breadcrumb-item"><a href="index.php?Page=Transaksi">Transaksi</a></li>';
                            echo '      <li class="breadcrumb-item active">Edit Transaksi</li>';
                            echo '  </ol>';
                            echo '</nav>';
                        }
                    }
                }
            }
        }
        if($_GET['Page']=="RekapTransaksi"){
            echo '<h1><a href=""><i class="bi bi-cart-check"></i> Rekap Transaksi</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Rekap Transaksi</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="Version"){
            echo '<h1><i class="bi bi-person"></i> Tentang Aplikasi</h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Tentang Aplikasi</li>';
            echo '  </ol>';
            echo '</nav>';
        }else{
            if($_GET['Page']=="EntitasAkses"){
                if(empty($_GET['Sub'])){
                    echo '<h1><a href=""><i class="bi bi-key"></i> Entitas Ases</a></h1>';
                    echo '<nav>';
                    echo '  <ol class="breadcrumb">';
                    echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                    echo '      <li class="breadcrumb-item active">Entitas Akses</li>';
                    echo '  </ol>';
                    echo '</nav>';
                }else{
                    if($_GET['Sub']=="BuatEntitas"){
                        echo '<h1><i class="bi bi-key"></i> Entitas Ases</h1>';
                        echo '<nav>';
                        echo '  <ol class="breadcrumb">';
                        echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                        echo '      <li class="breadcrumb-item"><a href="index.php?Page=EntitasAkses">Entitas Akses</a></li>';
                        echo '      <li class="breadcrumb-item active">Buat Entitas</li>';
                        echo '  </ol>';
                        echo '</nav>';
                    }
                }
                
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
            if($_GET['Page']=="ApiKey"){
                echo '<h1><a href=""><i class="bi bi-key"></i> API Key</a></h1>';
                echo '<nav>';
                echo '  <ol class="breadcrumb">';
                echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                echo '      <li class="breadcrumb-item active">API Key</li>';
                echo '  </ol>';
                echo '</nav>';
            }
            if($_GET['Page']=="Aktivitas"){
                if($_GET['Sub']=="AktivitasUmum"||$_GET['Sub']==""){
                    echo '<h1><i class="bi bi-record-btn"></i> Aktivitas Umum</h1>';
                    echo '<nav>';
                    echo '  <ol class="breadcrumb">';
                    echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                    echo '      <li class="breadcrumb-item active">Aktivitas</li>';
                    echo '  </ol>';
                    echo '</nav>';
                }
                if($_GET['Sub']=="Email"){
                    echo '<h1><i class="bi bi-record-btn"></i> Aktivitas Email</h1>';
                    echo '<nav>';
                    echo '  <ol class="breadcrumb">';
                    echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                    echo '      <li class="breadcrumb-item active">Aktivitas</li>';
                    echo '  </ol>';
                    echo '</nav>';
                }
                if($_GET['Sub']=="APIs"){
                    echo '<h1><i class="bi bi-record-btn"></i> Aktivitas APIs</h1>';
                    echo '<nav>';
                    echo '  <ol class="breadcrumb">';
                    echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                    echo '      <li class="breadcrumb-item active">Aktivitas</li>';
                    echo '  </ol>';
                    echo '</nav>';
                }
            }
            if($_GET['Page']=="AkunPerkiraan"){
                echo '<h1><a href=""><i class="bi bi-list-nested"></i> Akun Perkiraan</a></h1>';
                echo '<nav>';
                echo '  <ol class="breadcrumb">';
                echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                echo '      <li class="breadcrumb-item active">Akun Perkiraan</li>';
                echo '  </ol>';
                echo '</nav>';
            }
            
            if($_GET['Page']=="Jurnal"){
                echo '<h1><a href=""><i class="bi bi-file-ruled"></i> Jurnal</a></h1>';
                echo '<nav>';
                echo '  <ol class="breadcrumb">';
                echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                echo '      <li class="breadcrumb-item active">Jurnal</li>';
                echo '  </ol>';
                echo '</nav>';
            }
            if($_GET['Page']=="BarangExpired"){
                if(empty($_GET['Sub'])){
                    echo '<h1><i class="bi bi-calendar-check"></i> Batch & Expired</h1>';
                    echo '<nav>';
                    echo '  <ol class="breadcrumb">';
                    echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                    echo '      <li class="breadcrumb-item active">Batch & Expired</li>';
                    echo '  </ol>';
                    echo '</nav>';
                }else{
                    if($_GET['Sub']=="Import"){
                        echo '<h1><i class="bi bi-calendar-check"></i> Batch & Expired</h1>';
                        echo '<nav>';
                        echo '  <ol class="breadcrumb">';
                        echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                        echo '      <li class="breadcrumb-item"><a href="index.php?Page=BarangExpired">Batch & Expired</a></li>';
                        echo '      <li class="breadcrumb-item active">Import Batch & Expired</li>';
                        echo '  </ol>';
                        echo '</nav>';
                    }else{
                        echo '<h1><i class="bi bi-calendar-check"></i> Batch & Expired</h1>';
                        echo '<nav>';
                        echo '  <ol class="breadcrumb">';
                        echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                        echo '      <li class="breadcrumb-item active">Batch & Expired</li>';
                        echo '  </ol>';
                        echo '</nav>';
                    }
                }
            }
            if($_GET['Page']=="SimpanPinjam"){
                echo '<h1><a href=""><i class="bi bi-graph-down-arrow"></i> Simpan-Pinjam</a></h1>';
                echo '<nav>';
                echo '  <ol class="breadcrumb">';
                echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                echo '      <li class="breadcrumb-item active">Simpan Pinjam</li>';
                echo '  </ol>';
                echo '</nav>';
            }
            if($_GET['Page']=="BukuBesar"){
                echo '<h1><a href=""><i class="bi bi-file-ruled"></i> Buku Besar</a></h1>';
                echo '<nav>';
                echo '  <ol class="breadcrumb">';
                echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                echo '      <li class="breadcrumb-item active">Buku Besar</li>';
                echo '  </ol>';
                echo '</nav>';
            }
            if($_GET['Page']=="NeracaSaldo"){
                echo '<h1><a href=""><i class="bi bi-list"></i> Neraca Saldo</a></h1>';
                echo '<nav>';
                echo '  <ol class="breadcrumb">';
                echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                echo '      <li class="breadcrumb-item active">Neraca Saldo</li>';
                echo '  </ol>';
                echo '</nav>';
            }
            if($_GET['Page']=="LabaRugi"){
                echo '<h1><a href=""><i class="bi bi-graph-down-arrow"></i> Laba-Rugi</a></h1>';
                echo '<nav>';
                echo '  <ol class="breadcrumb">';
                echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                echo '      <li class="breadcrumb-item active">Laba Rugi</li>';
                echo '  </ol>';
                echo '</nav>';
            }
            if($_GET['Page']=="RekapitulasiTransaksi"){
                echo '<h1><i class="bi bi-coin"></i> Rekapitulasi Transaksi</h1>';
                echo '<nav>';
                echo '  <ol class="breadcrumb">';
                echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                echo '      <li class="breadcrumb-item active">Rekapitulasi Transaksi</li>';
                echo '  </ol>';
                echo '</nav>';
            }
            if($_GET['Page']=="BagiHasil"){
                if(empty($_GET['Sub'])){
                    echo '<h1><a href=""><i class="bi bi-coin"></i> Bagi Hasil (SHU)</a></h1>';
                    echo '<nav>';
                    echo '  <ol class="breadcrumb">';
                    echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                    echo '      <li class="breadcrumb-item active">Bagi Hasil</li>';
                    echo '  </ol>';
                    echo '</nav>';
                }else{
                    $Sub=$_GET['Sub'];
                    if($Sub=="DetailBagiHasil"){
                        echo '<h1><a href=""><i class="bi bi-coin"></i> Bagi Hasil (SHU)</a></h1>';
                        echo '<nav>';
                        echo '  <ol class="breadcrumb">';
                        echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                        echo '      <li class="breadcrumb-item"><a href="index.php?Page=BagiHasil">Bagi Hasil</a></li>';
                        echo '      <li class="breadcrumb-item active">Detail Bagi Hasil</li>';
                        echo '  </ol>';
                        echo '</nav>';
                    }
                }
                
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
    }
    echo '</div>';
?>
