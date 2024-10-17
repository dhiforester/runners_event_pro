<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');

    $response = ['success' => false, 'message' => ''];
    $errors = []; // Inisialisasi pesan error

    // Harus Login Terlebih Dulu
    if (empty($SessionIdAkses)) {
        $errors[] = 'Sesi akses sudah berakhir, silahkan login ulang!.';
    }

    // Validasi data input
    if (empty($_POST['tanggal_mulai'])) { $errors[] = 'Tanggal mulai harus diisi.'; }
    if (empty($_POST['tanggal_selesai'])) { $errors[] = 'Tanggal selesai harus diisi.'; }
    if (empty($_POST['tanggal_mulai_pendaftaran'])) { $errors[] = 'Tanggal mulai pendaftaran harus diisi.'; }
    if (empty($_POST['tanggal_selesai_pendaftaran'])) { $errors[] = 'Tanggal selesai pendaftaran harus diisi.'; }
    if (empty($_POST['nama_event'])) { $errors[] = 'Nama event harus diisi.'; }
    if (strlen($_POST['nama_event']) > 100) { $errors[] = 'Nama event tidak boleh lebih dari 100 karakter.'; }
    if (empty($_POST['keterangan'])) { $errors[] = 'Keterangan harus diisi.'; }
    if (strlen($_POST['keterangan']) > 500) { $errors[] = 'Keterangan tidak boleh lebih dari 500 karakter.'; }
    if (empty($_FILES['poster']['name'])) { $errors[] = 'Poster harus diunggah.'; }
    if (empty($_FILES['rute']['name'])) { $errors[] = 'File rute harus diunggah.'; }

    // Jika ada error, kirim respons dengan daftar pesan error
    if (!empty($errors)) {
        $response['message'] = implode('<br>', $errors);
        echo json_encode($response);
        exit;
    }

    // Validasi tanggal
    $tanggal_mulai = $_POST['tanggal_mulai'] . ' ' . $_POST['jam_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'] . ' ' . $_POST['jam_selesai'];
    $tanggal_mulai_pendaftaran = $_POST['tanggal_mulai_pendaftaran'] . ' ' . $_POST['jam_mulai_pendaftaran'];
    $tanggal_selesai_pendaftaran = $_POST['tanggal_selesai_pendaftaran'] . ' ' . $_POST['jam_selesai_pendaftaran'];

    if (strtotime($tanggal_mulai) > strtotime($tanggal_selesai)) {
        $response['message'] = 'Tanggal mulai tidak boleh melebihi tanggal selesai.';
        echo json_encode($response);
        exit;
    }
    if (strtotime($tanggal_mulai_pendaftaran) > strtotime($tanggal_selesai_pendaftaran)) {
        $response['message'] = 'Tanggal mulai pendaftaran tidak boleh melebihi tanggal selesai pendaftaran.';
        echo json_encode($response);
        exit;
    }
    if (strtotime($tanggal_mulai_pendaftaran) > strtotime($tanggal_mulai)) {
        $response['message'] = 'Tanggal mulai pendaftaran tidak boleh melebihi tanggal mulai event.';
        echo json_encode($response);
        exit;
    }
    if (strtotime($tanggal_selesai_pendaftaran) > strtotime($tanggal_mulai)) {
        $response['message'] = 'Tanggal selesai pendaftaran tidak boleh melebihi tanggal mulai event.';
        echo json_encode($response);
        exit;
    }

    // Validasi file poster
    $poster_ext = strtolower(pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION));
    $allowed_poster_types = ['png', 'jpg', 'jpeg', 'gif'];
    if (!in_array($poster_ext, $allowed_poster_types)) {
        $errors[] = 'Format file poster harus PNG, JPG, JPEG, atau GIF.';
    }
    if ($_FILES['poster']['size'] > 5 * 1024 * 1024) { // 5 MB
        $errors[] = 'Ukuran file poster tidak boleh lebih dari 5 MB.';
    }

    // Validasi file rute
    $rute_ext = strtolower(pathinfo($_FILES['rute']['name'], PATHINFO_EXTENSION));
    if ($rute_ext !== 'gpx') {
        $errors[] = 'Format file rute harus GPX.';
    }
    if ($_FILES['rute']['size'] > 5 * 1024 * 1024) { // 5 MB
        $errors[] = 'Ukuran file rute tidak boleh lebih dari 5 MB.';
    }

    // Jika ada error pada validasi file, kirim respons dengan daftar pesan error
    if (!empty($errors)) {
        $response['message'] = implode('<br>', $errors);
        echo json_encode($response);
        exit;
    }

    // Generate UUID
    $id_event = bin2hex(random_bytes(16));

    // Upload poster
    $poster_name = bin2hex(random_bytes(16)) . '.' . $poster_ext;
    $poster_upload_path = '../../assets/img/Poster/' . $poster_name;
    if (!move_uploaded_file($_FILES['poster']['tmp_name'], $poster_upload_path)) {
        $response['message'] = 'Gagal mengunggah poster, coba lagi.';
        echo json_encode($response);
        exit;
    }

    // Upload rute
    $rute_name = bin2hex(random_bytes(16)) . '.' . $rute_ext;
    $rute_upload_path = '../../assets/img/Rute/' . $rute_name;
    if (!move_uploaded_file($_FILES['rute']['tmp_name'], $rute_upload_path)) {
        $response['message'] = 'Gagal mengunggah file rute, coba lagi.';
        // Hapus file poster jika upload rute gagal
        unlink($poster_upload_path);
        echo json_encode($response);
        exit;
    }

    // Lengkapi Variabel
    $nama_event = validateAndSanitizeInput($_POST['nama_event']);
    $keterangan = validateAndSanitizeInput($_POST['keterangan']);
    $tanggal_mulai = validateAndSanitizeInput($tanggal_mulai);
    $tanggal_selesai = validateAndSanitizeInput($tanggal_selesai);
    $tanggal_mulai_pendaftaran = validateAndSanitizeInput($tanggal_mulai_pendaftaran);
    $tanggal_selesai_pendaftaran = validateAndSanitizeInput($tanggal_selesai_pendaftaran);

    // Insert data ke database
    $query = "INSERT INTO event (id_event, tanggal_mulai, tanggal_selesai, mulai_pendaftaran, selesai_pendaftaran, 
            nama_event, keterangan, poster, rute) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $Conn->prepare($query);
    $stmt->bind_param("sssssssss", $id_event, $tanggal_mulai, $tanggal_selesai, $tanggal_mulai_pendaftaran, 
                        $tanggal_selesai_pendaftaran, $nama_event, $keterangan, $poster_name, $rute_name);

    if ($stmt->execute()) {
        $kategori_log = "Event";
        $deskripsi_log = "Input Event";
        $InputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);
        if ($InputLog == "Success") {
            $response['success'] = true;
        } else {
            $response['message'] = 'Terjadi kesalahan pada saat input log.';
        }
    } else {
        $response['message'] = 'Gagal menyimpan data, coba lagi.';
    }

    echo json_encode($response);
?>
