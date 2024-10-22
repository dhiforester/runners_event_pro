<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');
    // Time Now Tmp
    $now = date('Y-m-d H:i:s');

    // Validasi id_setting_api_key tidak boleh kosong
    if (empty($_POST['id_setting_api_key'])) {
        echo '<code class="text-danger">ID API Key Tidak Boleh Kosong</code>';
        exit; // Menghentikan eksekusi jika ada kesalahan
    }

    // Validasi password_server tidak boleh kosong
    if (empty($_POST['password_server'])) {
        echo '<code class="text-danger">Password Server Tidak Boleh Kosong</code>';
        exit; // Menghentikan eksekusi jika ada kesalahan
    }

    // Mengambil dan membersihkan input
    $id_setting_api_key = validateAndSanitizeInput($_POST['id_setting_api_key']);
    $password_server = validateAndSanitizeInput($_POST['password_server']);

    // Mengubah Password Menjadi password_hash
    $password_server = password_hash($password_server, PASSWORD_DEFAULT);

    // Siapkan dan Jalankan Update dengan Prepared Statement
    $stmt = $Conn->prepare("UPDATE setting_api_key SET datetime_update = ?, password_server = ? WHERE id_setting_api_key = ?");
    $stmt->bind_param("ssi", $now, $password_server, $id_setting_api_key);

    if ($stmt->execute()) {
        // Log ke database
        $kategori_log = "API Key";
        $deskripsi_log = "Edit Password API Key"; // Perbarui deskripsi log
        $inputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);
        
        if ($inputLog == "Success") {
            echo '<small class="text-success" id="NotifikasiEditPasswordApiKeyBerhasil">Success</small>';
        } else {
            echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan log</small>';
        }
    } else {
        echo '<small class="text-danger">Terjadi kesalahan pada saat update Password API Key</small>';
    }

    $stmt->close(); // Menutup statement
?>
