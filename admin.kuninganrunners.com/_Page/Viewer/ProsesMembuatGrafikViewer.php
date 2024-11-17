<?php
    // Sertakan file koneksi
    include "../../_Config/Connection.php";

    // Ambil data web_log bulanan untuk tahun ini
    $query = "
        SELECT 
            MONTH(tanggal) AS month,
            COUNT(*) AS jumlah
        FROM 
            web_log
        WHERE 
            YEAR(tanggal) = YEAR(CURDATE())
        GROUP BY 
            MONTH(tanggal)
        ORDER BY 
            MONTH(tanggal) ASC
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
