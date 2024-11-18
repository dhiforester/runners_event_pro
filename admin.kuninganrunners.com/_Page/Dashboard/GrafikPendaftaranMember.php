<?php
    // Connection.php assumed to be in _Config folder
    require_once '../../_Config/Connection.php';

    // Set timezone
    date_default_timezone_set('Asia/Jakarta');

    // Inisialisasi variabel
    $currentYear = date('Y');
    $data = [];

    // Query untuk menghitung jumlah pendaftaran per bulan
    $query = "SELECT 
                MONTH(datetime) AS month, 
                COUNT(*) AS count 
            FROM member 
            WHERE YEAR(datetime) = ?
            GROUP BY MONTH(datetime)";

    $stmt = $Conn->prepare($query);
    $stmt->bind_param('i', $currentYear);
    $stmt->execute();
    $result = $stmt->get_result();

    // Inisialisasi array bulan (1-12)
    for ($i = 1; $i <= 12; $i++) {
        $data[$i] = 0;
    }

    // Masukkan data hasil query ke dalam array
    while ($row = $result->fetch_assoc()) {
        $data[(int)$row['month']] = (int)$row['count'];
    }

    $stmt->close();

    // Kirimkan data dalam format JSON
    header('Content-Type: application/json');
    echo json_encode(array_values($data));
?>
