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
        if (empty($_POST['privacy_policy'])) {
            echo '<span class="text-danger">Isi Konten Tidak Boleh Kosong</span>';
        } else {
            // Siapkan data yang akan dimasukkan
            $privacy_policy = $_POST['privacy_policy'];  // Jangan gunakan htmlspecialchars di sini jika ingin menyimpan HTML
            
            // Gunakan prepared statement untuk menyimpan data ke database
            $stmt = $Conn->prepare("UPDATE web_tos SET privacy_policy = ? WHERE id_web_tos = '1'");
            $stmt->bind_param("s", $privacy_policy);

            if ($stmt->execute()) {
                // Jika berhasil, simpan log
                $kategori_log = "Konten Utama";
                $deskripsi_log = "Update Privacy Policy";
                $InputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);

                if ($InputLog == "Success") {
                    $_SESSION["NotifikasiSwal"] = "Simpan Privacy Policy Berhasil";
                    echo '<small class="text-success" id="NotifikasiPrivacyPolicyBerhasil">Success</small>';
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
