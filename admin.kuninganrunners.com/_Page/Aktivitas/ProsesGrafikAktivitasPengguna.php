<?php
    // Sertakan file koneksi
    include "../../_Config/Connection.php";

    // Ambil data log bulanan untuk tahun ini
    $query = "
        SELECT 
            MONTH(datetime_log) AS month,
            COUNT(*) AS jumlah
        FROM 
            log
        WHERE 
            YEAR(datetime_log) = YEAR(CURDATE())
        GROUP BY 
            MONTH(datetime_log)
        ORDER BY 
            MONTH(datetime_log) ASC
    ";

    $stmt = $Conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result(); // Ambil hasil query

    $results = [];
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }

    // Siapkan data untuk JSON
    $months = [];
    $jumlah_aktivitas = [];

    // Inisialisasi semua bulan dengan nilai 0 untuk bulan yang tidak memiliki data
    for ($i = 1; $i <= 12; $i++) {
        $months[] = date('F', mktime(0, 0, 0, $i, 10)); // Nama bulan
        $jumlah_aktivitas[$i] = 0; // Inisialisasi jumlah ke 0
    }

    // Isi data dari query
    foreach ($results as $row) {
        $jumlah_aktivitas[(int)$row['month']] = (int)$row['jumlah'];
    }

    // Hasilkan JSON
    echo json_encode([
        'months' => $months,
        'amounts' => array_values($jumlah_aktivitas)
    ]);
?>
