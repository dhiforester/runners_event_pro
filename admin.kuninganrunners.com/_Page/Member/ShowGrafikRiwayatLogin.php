<?php
// Header untuk JSON
header('Content-Type: application/json');

// Sertakan koneksi
date_default_timezone_set('Asia/Jakarta');
include "../../_Config/Connection.php";
include "../../_Config/GlobalFunction.php";

// Ambil data dari POST
$id_member = $_POST['id_member'] ?? null;
$periode = $_POST['periode'] ?? 'Bulanan';
$periode_tahun = $_POST['periode_tahun'] ?? date('Y');
$periode_bulan = $_POST['periode_bulan'] ?? null;

// Validasi ID Member
if (!$id_member) {
    echo json_encode(['error' => 'ID Member tidak ditemukan.']);
    exit;
}

// Validasi koneksi
if (!$Conn) {
    echo json_encode(['error' => 'Gagal terhubung ke database.']);
    exit;
}

// Logika untuk harian
if ($periode === 'Harian' && $periode_bulan) {
    // Dapatkan jumlah hari dalam bulan
    $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $periode_bulan, $periode_tahun);
    
    // Siapkan array default untuk semua tanggal
    $labels = [];
    $values = [];
    for ($i = 1; $i <= $jumlah_hari; $i++) {
        $labels[] = $i; // Tanggal 1 hingga jumlah hari
        $values[$i] = 0; // Default nilai 0
    }

    // Query data login berdasarkan tanggal
    $query = "
        SELECT DAY(datetime_login) AS hari, COUNT(*) AS jumlah
        FROM member_login
        WHERE id_member = ? AND YEAR(datetime_login) = ? AND MONTH(datetime_login) = ?
        GROUP BY hari
        ORDER BY hari ASC
    ";
    $stmt = $Conn->prepare($query);
    $stmt->bind_param('sii', $id_member, $periode_tahun, $periode_bulan);

    if (!$stmt->execute()) {
        echo json_encode(['error' => 'Query gagal dieksekusi.', 'detail' => $stmt->error]);
        exit;
    }

    $result = $stmt->get_result();

    // Isi data ke array berdasarkan hasil query
    while ($row = $result->fetch_assoc()) {
        $hari = (int) $row['hari'];
        $values[$hari] = (int) $row['jumlah'];
    }

    // Pastikan values dalam urutan tanggal
    $values = array_values($values);

    // Return data JSON
    echo json_encode([
        'labels' => $labels, // Semua tanggal dalam bulan
        'values' => $values, // Data login sesuai tanggal
    ]);

    $stmt->close();
    $Conn->close();
    exit;
}

// Logika untuk bulanan
if ($periode === 'Bulanan') {
    $query = "
        SELECT MONTH(datetime_login) AS bulan, COUNT(*) AS jumlah
        FROM member_login
        WHERE id_member = ? AND YEAR(datetime_login) = ?
        GROUP BY bulan
        ORDER BY bulan ASC
    ";
    $stmt = $Conn->prepare($query);
    $stmt->bind_param('si', $id_member, $periode_tahun);

    if (!$stmt->execute()) {
        echo json_encode(['error' => 'Query gagal dieksekusi.', 'detail' => $stmt->error]);
        exit;
    }

    $result = $stmt->get_result();

    // Array default untuk semua bulan
    $labels = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
    $values = array_fill(0, 12, 0); // Nilai default nol untuk setiap bulan

    // Isi array hasil query
    while ($row = $result->fetch_assoc()) {
        $index = $row['bulan'] - 1; // Index dimulai dari 0
        $values[$index] = (int) $row['jumlah'];
    }

    // Return data JSON
    echo json_encode([
        'labels' => $labels,
        'values' => $values,
    ]);

    $stmt->close();
    $Conn->close();
    exit;
}

// Jika data tidak valid
echo json_encode(['error' => 'Data tidak valid untuk periode.']);
exit;
?>
