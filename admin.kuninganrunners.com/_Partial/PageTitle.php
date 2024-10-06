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
        if($_GET['Page']=="Anggota"){
            echo '<h1><a href=""><i class="bi bi-people"></i> Anggota</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Anggota</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="AnggotaKeluarMasuk"){
            echo '<h1><a href=""><i class="bi bi-arrow-left-right"></i> Keluar-Masuk Anggota</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active"> Keluar Masuk Anggota</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="RekapAnggota"){
            echo '<h1><a href=""><i class="bi bi-table"></i> Rekap Anggota</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active"> Rekap Anggota</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="JenisSimpanan"){
            echo '<h1><a href=""><i class="bi bi-collection"></i> Jenis Simpanan</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active"> Jenis Simpanan</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="SimpananWajib"){
            echo '<h1><a href=""><i class="bi bi-coin"></i> Simpanan Wajib</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active"> Simpanan Wajib</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="Tabungan"){
            if(empty($_GET['Sub'])){
                echo '<h1><a href=""><i class="bi bi-wallet"></i> Log Simpanan</a></h1>';
                echo '<nav>';
                echo '  <ol class="breadcrumb">';
                echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                echo '      <li class="breadcrumb-item active">Log Simpanan</li>';
                echo '  </ol>';
                echo '</nav>';
            }else{
                $Sub=$_GET['Sub'];
                if($Sub=="DetailTabungan"){
                    echo '<h1><a href=""><i class="bi bi-wallet"></i> Detail Simpanan</a></h1>';
                    echo '<nav>';
                    echo '  <ol class="breadcrumb">';
                    echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                    echo '      <li class="breadcrumb-item"><a href="index.php?Page=Tabungan">Log Simpanan</a></li>';
                    echo '      <li class="breadcrumb-item active">Detail Simpanan</li>';
                    echo '  </ol>';
                    echo '</nav>';
                }else{
                    echo '<h1><a href=""><i class="bi bi-wallet"></i> Log Simpanan</a></h1>';
                    echo '<nav>';
                    echo '  <ol class="breadcrumb">';
                    echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                    echo '      <li class="breadcrumb-item active">Log Simpanan</li>';
                    echo '  </ol>';
                    echo '</nav>';
                }
            }
        }
        if($_GET['Page']=="RekapSimpanan"){
            echo '<h1><a href=""><i class="bi bi-table"></i> Rekap Simpanan</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Rekap Simpanan</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="Pinjaman"){
            if(empty($_GET['Sub'])){
                echo '<h1><a href=""><i class="bi bi-bank"></i> Pinjaman</a></h1>';
                echo '<nav>';
                echo '  <ol class="breadcrumb">';
                echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                echo '      <li class="breadcrumb-item active">Pinjaman</li>';
                echo '  </ol>';
                echo '</nav>';
            }else{
                $Sub=$_GET['Sub'];
                if($Sub=="DetailPinjaman"){
                    echo '<h1><a href=""><i class="bi bi-bank"></i> Detail Pinjaman</a></h1>';
                    echo '<nav>';
                    echo '  <ol class="breadcrumb">';
                    echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                    echo '      <li class="breadcrumb-item"><a href="index.php?Page=Pinjaman">Pinjaman</a></li>';
                    echo '      <li class="breadcrumb-item active">Detail Pinjaman</li>';
                    echo '  </ol>';
                    echo '</nav>';
                }else{
                    if($Sub=="DetailAngsuran"){
                        echo '<h1><a href=""><i class="bi bi-bank"></i> Detail Angsuran</a></h1>';
                        echo '<nav>';
                        echo '  <ol class="breadcrumb">';
                        echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                        echo '      <li class="breadcrumb-item"><a href="index.php?Page=Pinjaman">Pinjaman</a></li>';
                        echo '      <li class="breadcrumb-item active">Detail Angsuran</li>';
                        echo '  </ol>';
                        echo '</nav>';
                    }else{
                        
                    }
                }
            }
            
        }
        if($_GET['Page']=="Tagihan"){
            echo '<h1><a href=""><i class="bi bi-collection"></i> Tagihan</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Tagihan</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="RekapPinjaman"){
            echo '<h1><a href=""><i class="bi bi-table"></i> Rekap Pinjaman</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Rekap Pinjaman</li>';
            echo '  </ol>';
            echo '</nav>';
        }
        if($_GET['Page']=="JenisTransaksi"){
            echo '<h1><a href=""><i class="bi bi-cart-check"></i> Jenis Transaksi</a></h1>';
            echo '<nav>';
            echo '  <ol class="breadcrumb">';
            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
            echo '      <li class="breadcrumb-item active">Jenis Transaksi</li>';
            echo '  </ol>';
            echo '</nav>';
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
            if($_GET['Page']=="SettingGeneral"){
                echo '<h1><a href=""><i class="bi bi-gear"></i> Pengaturan Umum</a></h1>';
                echo '<nav>';
                echo '  <ol class="breadcrumb">';
                echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                echo '      <li class="breadcrumb-item active">Pengaturan Umum</li>';
                echo '  </ol>';
                echo '</nav>';
            }
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
            if($_GET['Page']=="ApiDoc"){
                echo '<h1><i class="bi bi-file-code"></i> Dokumentasi API</h1>';
                echo '<nav>';
                echo '  <ol class="breadcrumb">';
                echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                echo '      <li class="breadcrumb-item active">Dokumentasi API</li>';
                echo '  </ol>';
                echo '</nav>';
            }
            if($_GET['Page']=="AutoJurnal"){
                echo '<h1><a href=""><i class="bi bi-journal-medical"></i> Auto Jurnal</a></h1>';
                echo '<nav>';
                echo '  <ol class="breadcrumb">';
                echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                echo '      <li class="breadcrumb-item active">Auto Jurnal</li>';
                echo '  </ol>';
                echo '</nav>';
            }
            if($_GET['Page']=="RiwayatAnggota"){
                echo '<h1><a href=""><i class="bi bi-clock"></i> Riwayat Anggota</a></h1>';
                echo '<nav>';
                echo '  <ol class="breadcrumb">';
                echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                echo '      <li class="breadcrumb-item active">Riwayat Anggota</li>';
                echo '  </ol>';
                echo '</nav>';
            }
            if($_GET['Page']=="StockOpename"){
                echo '<h1><i class="bi bi-truck-flatbed"></i> Stock Opename</h1>';
                echo '<nav>';
                echo '  <ol class="breadcrumb">';
                echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                echo '      <li class="breadcrumb-item active">Stock Opename</li>';
                echo '  </ol>';
                echo '</nav>';
            }
            if($_GET['Page']=="Kunjungan"){
                if(empty($_GET['Sub'])){
                    echo '<h1><i class="bi bi-journal-text"></i> Kunjungan</h1>';
                    echo '<nav>';
                    echo '  <ol class="breadcrumb">';
                    echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                    echo '      <li class="breadcrumb-item active">Kunjungan</li>';
                    echo '  </ol>';
                    echo '</nav>';
                }else{
                    $Sub=$_GET['Sub'];
                    if($Sub=="Pendaftaran"){
                        echo '<h1><i class="bi bi-journal-text"></i> Pendaftaran Kunjungan</h1>';
                        echo '<nav>';
                        echo '  <ol class="breadcrumb">';
                        echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                        echo '      <li class="breadcrumb-item"><a href="index.php?Page=Kunjungan">Kunjungan</a></li>';
                        echo '      <li class="breadcrumb-item active">Pendaftaran Kunjungan</li>';
                        echo '  </ol>';
                        echo '</nav>';
                    }else{
                        if($Sub=="DetailKunjungan"){
                            echo '<h1><i class="bi bi-journal-text"></i> Detail Kunjungan</h1>';
                            echo '<nav>';
                            echo '  <ol class="breadcrumb">';
                            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                            echo '      <li class="breadcrumb-item"><a href="index.php?Page=Kunjungan">Kunjungan</a></li>';
                            echo '      <li class="breadcrumb-item active">Detail Kunjungan</li>';
                            echo '  </ol>';
                            echo '</nav>';
                        }
                    }
                }
            }
            if($_GET['Page']=="Supplier"){
                if(empty($_GET['Sub'])){
                    echo '<h1><i class="bi bi-truck"></i> Supplier</h1>';
                    echo '<nav>';
                    echo '  <ol class="breadcrumb">';
                    echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                    echo '      <li class="breadcrumb-item active">Supplier</li>';
                    echo '  </ol>';
                    echo '</nav>';
                }else{
                    $Sub=$_GET['Sub'];
                    if($Sub=="DetailSupplier"){
                        echo '<h1><i class="bi bi-truck"></i> Supplier</h1>';
                        echo '<nav>';
                        echo '  <ol class="breadcrumb">';
                        echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                        echo '      <li class="breadcrumb-item"><a href="index.php?Page=Supplier">Supplier</a></li>';
                        echo '      <li class="breadcrumb-item active">Detail Supplier</li>';
                        echo '  </ol>';
                        echo '</nav>';
                    }else{
                        if($Sub=="Import"){
                            echo '<h1><i class="bi bi-truck"></i> Supplier</h1>';
                            echo '<nav>';
                            echo '  <ol class="breadcrumb">';
                            echo '      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                            echo '      <li class="breadcrumb-item"><a href="index.php?Page=Supplier">Supplier</a></li>';
                            echo '      <li class="breadcrumb-item active">Import Supplier</li>';
                            echo '  </ol>';
                            echo '</nav>';
                        }
                    }
                }
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
