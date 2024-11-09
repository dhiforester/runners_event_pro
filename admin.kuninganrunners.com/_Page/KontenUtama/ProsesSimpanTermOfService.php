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
        if (empty($_POST['term_of_service'])) {
            echo '<span class="text-danger">Isi Konten Tidak Boleh Kosong</span>';
        } else {
            // Siapkan data yang akan dimasukkan
            $term_of_service = $_POST['term_of_service'];  // Jangan gunakan htmlspecialchars di sini jika ingin menyimpan HTML
            
            // Gunakan prepared statement untuk menyimpan data ke database
            $stmt = $Conn->prepare("UPDATE web_tos SET term_of_service = ? WHERE id_web_tos = '1'");
            $stmt->bind_param("s", $term_of_service);

            if ($stmt->execute()) {
                // Jika berhasil, simpan log
                $kategori_log = "Konten Utama";
                $deskripsi_log = "Update Term Of Service";
                $InputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);

                if ($InputLog == "Success") {
                    $_SESSION["NotifikasiSwal"] = "Simpan Term Of Service Berhasil";
                    echo '<small class="text-success" id="NotifikasiTermOfServiceBerhasil">Success</small>';
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
