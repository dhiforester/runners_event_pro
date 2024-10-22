<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');
    // Time Now Tmp
    $now = date('Y-m-d H:i:s');

    // Validasi Sesi Login
    if (empty($SessionIdAkses)) {
        echo '<code class="text-danger">Sesi akses sudah berakhir, silahkan login ulang!</code>';
        exit;
    }

    // Mengambil dan membersihkan input
    $id_setting_api_key = isset($_POST['id_setting_api_key']) ? validateAndSanitizeInput($_POST['id_setting_api_key']) : '';
    $title_api_key = isset($_POST['title_api_key']) ? validateAndSanitizeInput($_POST['title_api_key']) : '';
    $description_api_key = isset($_POST['description_api_key']) ? validateAndSanitizeInput($_POST['description_api_key']) : '';
    $user_key_server = isset($_POST['user_key_server']) ? validateAndSanitizeInput($_POST['user_key_server']) : '';
    $status_api_key = isset($_POST['status_api_key']) ? validateAndSanitizeInput($_POST['status_api_key']) : '';
    $limit_session = isset($_POST['limit_session']) ? validateAndSanitizeInput($_POST['limit_session']) : '';

    // Validasi Input
    $errors = [];
    if (empty($title_api_key)) {
        $errors[] = 'Judul/Nama API Key Tidak Boleh Kosong!';
    }
    if (empty($description_api_key)) {
        $errors[] = 'Setidaknya anda memberitahu kami tujuan/keterangan dibuatnya API key tersebut.';
    }
    if (empty($user_key_server)) {
        $errors[] = 'User Key Tidak Boleh Kosong';
    }
    if (empty($id_setting_api_key)) {
        $errors[] = 'ID API Key Tidak Boleh Kosong';
    }
    if (empty($status_api_key)) {
        $errors[] = 'Status Tidak Boleh Kosong';
    }
    if (empty($limit_session)) {
        $errors[] = 'Limit Session Tidak Boleh Kosong';
    }

    // Validasi Jumlah Karakter dan Karakter Ilegal
    if (strlen($title_api_key) > 50) {
        $errors[] = 'Judul/Nama API Key yang anda input tidak boleh lebih dari 50 karakter termasuk spasi';
    }
    if (strlen($description_api_key) > 200) {
        $errors[] = 'Deskripsi/Keterangan yang anda input tidak boleh lebih dari 200 karakter termasuk spasi';
    }
    if (strlen($user_key_server) > 36) {
        $errors[] = 'User Key yang anda input tidak boleh lebih dari 36 karakter termasuk spasi';
    }
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $title_api_key)) {
        $errors[] = 'Judul/Nama API Key hanya boleh huruf, angka, dan spasi.';
    }
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $description_api_key)) {
        $errors[] = 'Deskripsi/Keterangan hanya boleh huruf, angka, dan spasi.';
    }
    if (!preg_match("/^[a-zA-Z0-9]*$/", $user_key_server)) {
        $errors[] = 'User Key hanya boleh huruf dan angka.';
    }

    // Tampilkan Error Jika Ada
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<code class="text-danger">' . htmlspecialchars($error) . '</code>';
        }
        exit;
    }

    // Buka Data Lama
    $title_api_key_lama = GetDetailData($Conn, 'setting_api_key', 'id_setting_api_key', $id_setting_api_key, 'title_api_key');

    // Validasi API key Sama
    $validasiTitleDuplikat = 0;
    if ($title_api_key_lama !== $title_api_key) {
        // Gunakan Prepared Statement untuk menghindari SQL injection
        $stmt = $Conn->prepare("SELECT COUNT(*) FROM setting_api_key WHERE title_api_key = ?");
        $stmt->bind_param("s", $title_api_key);
        $stmt->execute();
        $stmt->bind_result($validasiTitleDuplikat);
        $stmt->fetch();
        $stmt->close();
    }

    if ($validasiTitleDuplikat > 0) {
        echo '<code class="text-danger">Judul/Nama API Key yang anda input sudah digunakan!</code>';
        exit;
    }

    // Siapkan dan Jalankan Update
    $stmt = $Conn->prepare("UPDATE setting_api_key SET datetime_update = ?, title_api_key = ?, description_api_key = ?, user_key_server = ?, limit_session = ?, status = ? WHERE id_setting_api_key = ?");
    $stmt->bind_param("ssssssi", $now, $title_api_key, $description_api_key, $user_key_server, $limit_session, $status_api_key, $id_setting_api_key);

    if ($stmt->execute()) {
        // Log ke database
        $kategori_log = "API Key";
        $deskripsi_log = "Edit API Key";
        $inputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);
        
        if ($inputLog == "Success") {
            echo '<small class="text-success" id="NotifikasiEditInformasiApiKeyBerhasil">Success</small>';
        } else {
            echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan log</small>';
        }
    } else {
        echo '<small class="text-danger">Terjadi kesalahan pada saat update API Key</small>';
    }
    $stmt->close();
?>
