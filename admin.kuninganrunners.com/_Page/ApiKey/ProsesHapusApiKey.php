<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Set Time Zone
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');

    // Tangkap Data
    if (empty($_POST['id_setting_api_key'])) {
        echo '<code class="text-danger">ID API Key Tidak Boleh Kosong!</code>';
        exit; // Menghentikan eksekusi jika ada kesalahan
    }

    // Buat Variabel dan Bersihkan
    $id_setting_api_key = validateAndSanitizeInput($_POST['id_setting_api_key']);

    // Siapkan dan Jalankan Hapus dengan Prepared Statement
    $stmt = $Conn->prepare("DELETE FROM setting_api_key WHERE id_setting_api_key = ?");
    $stmt->bind_param("s", $id_setting_api_key); // Menggunakan 's' untuk parameter string

    if ($stmt->execute()) {
        // Simpan Log ke database
        $kategori_log = "API Key";
        $deskripsi_log = "Hapus API Key";
        $inputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);
        
        if ($inputLog == "Success") {
            echo '<code class="text-success" id="NotifikasiHapusApiKeyBerhasil">Success</code>';
        } else {
            echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan log</small>';
        }
    } else {
        echo '<code class="text-danger">Terjadi kesalahan pada saat menghapus API Key</code>';
    }

    $stmt->close(); // Menutup statement
?>
