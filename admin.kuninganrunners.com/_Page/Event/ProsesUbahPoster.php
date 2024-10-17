<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $response = [
        'success' => false,
        'message' => ''
    ];

    // Memeriksa apakah request yang diterima adalah POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_event = $_POST['id_event'] ?? '';

        // Validasi id_event
        if (empty($id_event)) {
            $response['message'] = 'ID event tidak ditemukan.';
            echo json_encode($response);
            exit;
        }

        // Validasi file
        if (!isset($_FILES['poster']) || $_FILES['poster']['error'] !== UPLOAD_ERR_OK) {
            $response['message'] = 'File poster belum dipilih atau terjadi kesalahan saat upload.';
            echo json_encode($response);
            exit;
        }

        $file = $_FILES['poster'];
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileTmp = $file['tmp_name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif'];
        $maxFileSize = 5 * 1024 * 1024; // 5 MB

        // Validasi ekstensi dan ukuran file
        if (!in_array($fileExt, $allowedExtensions)) {
            $response['message'] = 'Format file tidak valid. Hanya JPEG, JPG, PNG, dan GIF yang diperbolehkan.';
            echo json_encode($response);
            exit;
        }
        if ($fileSize > $maxFileSize) {
            $response['message'] = 'Ukuran file melebihi batas maksimal 5 MB.';
            echo json_encode($response);
            exit;
        }

        // Menentukan nama file baru
        $newFileName = bin2hex(random_bytes(16)) . '.' . $fileExt;
        $uploadDir = '../../assets/img/Poster/'; // Folder tujuan upload
        $uploadPath = $uploadDir . $newFileName;

        // Upload file baru
        if (!move_uploaded_file($fileTmp, $uploadPath)) {
            $response['message'] = 'Gagal mengunggah file poster.';
            echo json_encode($response);
            exit;
        }

        // Mengambil data file lama (jika ada) untuk dihapus
        $queryOldFile = "SELECT poster FROM event WHERE id_event = ?";
        $stmtOldFile = $Conn->prepare($queryOldFile);
        $stmtOldFile->bind_param('s', $id_event);
        $stmtOldFile->execute();
        $stmtOldFile->bind_result($oldFile);
        $stmtOldFile->fetch();
        $stmtOldFile->close();

        // Menghapus file lama (jika ada)
        if (!empty($oldFile) && file_exists($uploadDir . $oldFile)) {
            unlink($uploadDir . $oldFile);
        }

        // Update data di database
        $updateQuery = "UPDATE event SET poster = ? WHERE id_event = ?";
        $stmtUpdate = $Conn->prepare($updateQuery);
        $stmtUpdate->bind_param('ss', $newFileName, $id_event);

        if ($stmtUpdate->execute()) {
            $kategori_log = "Event";
            $deskripsi_log = "Ubah Poster";
            $InputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);
            if ($InputLog == "Success") {
                $response['success'] = true;
                $response['message'] = 'Poster berhasil diperbarui.';
            } else {
                $response['success'] = false;
                $response['message'] = 'Terjadi kesalahan pada saat menyimpan log.';
            }
            
        } else {
            $response['message'] = 'Gagal memperbarui poster di database.';
        }

        // Menutup statement
        $stmtUpdate->close();
    } else {
        $response['message'] = 'Metode request tidak valid.';
    }

    // Menutup koneksi dan mengirim response dalam format JSON
    $Conn->close();
    echo json_encode($response);
?>
