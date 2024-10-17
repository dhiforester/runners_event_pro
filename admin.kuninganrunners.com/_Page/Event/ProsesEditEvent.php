<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');

    // Memeriksa apakah request yang diterima adalah POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = [
            'success' => false,
            'message' => ''
        ];

        // Mendapatkan data dari form
        $id_event = $_POST['id_event'] ?? '';
        $nama_event = $_POST['nama_event'] ?? '';
        $keterangan = $_POST['keterangan'] ?? '';

        // Menggabungkan tanggal dan waktu mulai event
        $tanggal_mulai = $_POST['tanggal_mulai'] ?? '';
        $jam_mulai = $_POST['jam_mulai'] ?? '';
        $datetime_mulai = !empty($tanggal_mulai) && !empty($jam_mulai) ? $tanggal_mulai . ' ' . $jam_mulai : '';

        // Menggabungkan tanggal dan waktu selesai event
        $tanggal_selesai = $_POST['tanggal_selesai'] ?? '';
        $jam_selesai = $_POST['jam_selesai'] ?? '';
        $datetime_selesai = !empty($tanggal_selesai) && !empty($jam_selesai) ? $tanggal_selesai . ' ' . $jam_selesai : '';

        // Menggabungkan tanggal dan waktu mulai pendaftaran
        $tanggal_mulai_pendaftaran = $_POST['tanggal_mulai_pendaftaran'] ?? '';
        $jam_mulai_pendaftaran = $_POST['jam_mulai_pendaftaran'] ?? '';
        $datetime_mulai_pendaftaran = !empty($tanggal_mulai_pendaftaran) && !empty($jam_mulai_pendaftaran) ? $tanggal_mulai_pendaftaran . ' ' . $jam_mulai_pendaftaran : '';

        // Menggabungkan tanggal dan waktu selesai pendaftaran
        $tanggal_selesai_pendaftaran = $_POST['tanggal_selesai_pendaftaran'] ?? '';
        $jam_selesai_pendaftaran = $_POST['jam_selesai_pendaftaran'] ?? '';
        $datetime_selesai_pendaftaran = !empty($tanggal_selesai_pendaftaran) && !empty($jam_selesai_pendaftaran) ? $tanggal_selesai_pendaftaran . ' ' . $jam_selesai_pendaftaran : '';

        // Validasi data
        if (empty($id_event) || empty($nama_event) || empty($datetime_mulai) || empty($datetime_selesai)) {
            $response['message'] = 'Semua field wajib diisi.';
            echo json_encode($response);
            exit;
        }

        // Validasi jumlah karakter
        if (strlen($nama_event) > 100) {
            $response['message'] = 'Nama event tidak boleh lebih dari 100 karakter.';
            echo json_encode($response);
            exit;
        }

        if (strlen($keterangan) > 500) {
            $response['message'] = 'Keterangan tidak boleh lebih dari 500 karakter.';
            echo json_encode($response);
            exit;
        }

        // Validasi waktu
        if ($datetime_mulai >= $datetime_selesai) {
            $response['message'] = 'Tanggal & waktu mulai event harus lebih awal dari tanggal & waktu selesai event.';
            echo json_encode($response);
            exit;
        }

        if (!empty($datetime_mulai_pendaftaran) && !empty($datetime_selesai_pendaftaran) && $datetime_mulai_pendaftaran >= $datetime_selesai_pendaftaran) {
            $response['message'] = 'Tanggal & waktu mulai pendaftaran harus lebih awal dari tanggal & waktu selesai pendaftaran.';
            echo json_encode($response);
            exit;
        }

        if (!empty($datetime_mulai_pendaftaran) && $datetime_mulai_pendaftaran >= $datetime_mulai) {
            $response['message'] = 'Tanggal & waktu mulai pendaftaran harus lebih awal dari tanggal & waktu mulai event.';
            echo json_encode($response);
            exit;
        }

        if (!empty($datetime_selesai_pendaftaran) && $datetime_selesai_pendaftaran >= $datetime_mulai) {
            $response['message'] = 'Tanggal & waktu selesai pendaftaran harus lebih awal dari tanggal & waktu mulai event.';
            echo json_encode($response);
            exit;
        }

        // Sanitasi input
        $nama_event = validateAndSanitizeInput($nama_event);
        $keterangan = validateAndSanitizeInput($keterangan);

        // Query untuk mengupdate data event
        $sql = "UPDATE event SET 
                    nama_event = ?, 
                    tanggal_mulai = ?, 
                    tanggal_selesai = ?, 
                    mulai_pendaftaran = ?, 
                    selesai_pendaftaran = ?, 
                    keterangan = ?
                WHERE id_event = ?";

        // Menyiapkan statement
        $stmt = $Conn->prepare($sql);
        $stmt->bind_param('sssssss', $nama_event, $datetime_mulai, $datetime_selesai, $datetime_mulai_pendaftaran, $datetime_selesai_pendaftaran, $keterangan, $id_event);

        // Eksekusi statement dan cek apakah berhasil
        if ($stmt->execute()) {
            $kategori_log = "Event";
            $deskripsi_log = "Update Event";
            $InputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);
            if ($InputLog == "Success") {
                $response['success'] = true;
                $response['message'] = 'Event berhasil diperbarui.';
            } else {
                $response['message'] = 'Terjadi kesalahan saat menyimpan log.';
            }
        } else {
            $response['message'] = 'Gagal memperbarui event. ' . $stmt->error;
        }

        // Menutup statement dan koneksi
        $stmt->close();
        $Conn->close();

        // Mengirim response dalam format JSON
        echo json_encode($response);
    } else {
        echo json_encode(['success' => false, 'message' => 'Metode request tidak valid.']);
    }
?>
