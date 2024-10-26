<?php
    // Koneksi dan file konfigurasi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');

    // Validasi Akses Login
    if (empty($SessionIdAkses)) {
        echo '<span class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</span>';
    } else {
        $now = date('Y-m-d H:i:s');
        
        // Validasi data input
        if (empty($_POST['judul'])) {
            echo '<span class="text-danger">Judul Konten Tidak Boleh Kosong!</span>';
        } elseif (empty($_POST['tentang'])) {
            echo '<span class="text-danger">Isi Konten Tidak Boleh Kosong</span>';
        } else {
            // Siapkan data yang akan dimasukkan
            $judul = htmlspecialchars($_POST['judul'], ENT_QUOTES, 'UTF-8');
            $tentang = $_POST['tentang'];  // Jangan gunakan htmlspecialchars di sini jika ingin menyimpan HTML
            
            // Gunakan prepared statement untuk menyimpan data ke database
            $stmt = $Conn->prepare("UPDATE web_tentang SET judul = ?, tentang = ? WHERE id_web_tentang = '1'");
            $stmt->bind_param("ss", $judul, $tentang);

            if ($stmt->execute()) {
                // Jika berhasil, simpan log
                $kategori_log = "Konten Utama";
                $deskripsi_log = "Update Tentang";
                $InputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);

                if ($InputLog == "Success") {
                    $_SESSION["NotifikasiSwal"] = "Simpan Tentang Berhasil";
                    echo '<small class="text-success" id="NotifikasiTentangKamiBerhasil">Success</small>';
                } else {
                    echo '<code class="text-danger">Terjadi kesalahan pada saat menyimpan Log</code>';
                }
            } else {
                echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data pada database</small>';
            }

            // Tutup statement
            $stmt->close();
        }
    }
?>
