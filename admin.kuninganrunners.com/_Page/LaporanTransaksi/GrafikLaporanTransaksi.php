<?php
    // Include file koneksi ke database
    include_once '../../_Config/Connection.php';

    // Ambil data filter dari form
    $periode = $_POST['periode'] ?? 'Bulanan';
    $tahun = (int)($_POST['periode_tahun'] ?? date('Y'));
    $bulan = (int)($_POST['periode_bulan'] ?? date('m'));

    // Set timezone untuk memastikan fungsi date() dan mktime() bekerja dengan benar
    date_default_timezone_set('Asia/Jakarta');

    // Inisialisasi response
    $response = [
        'labels' => [],
        'values' => [
            'Pembelian' => [],
            'Pendaftaran' => []
        ]
    ];

    try {
        // Tentukan query berdasarkan periode
        if ($periode === 'Bulanan') {
            // Query untuk periode bulanan
            $query = "
                SELECT 
                    MONTH(datetime) AS bulan,
                    kategori,
                    SUM(jumlah) AS total
                FROM 
                    transaksi
                WHERE 
                    YEAR(datetime) = ? 
                    AND status = 'Lunas'
                    AND kategori IN ('Pembelian', 'Pendaftaran')
                GROUP BY 
                    bulan, kategori
                ORDER BY 
                    bulan ASC
            ";
            $stmt = $Conn->prepare($query);
            $stmt->bind_param('i', $tahun);
        } else {
            // Query untuk periode harian
            $query = "
                SELECT 
                    DAY(datetime) AS hari,
                    kategori,
                    SUM(jumlah) AS total
                FROM 
                    transaksi
                WHERE 
                    YEAR(datetime) = ? 
                    AND MONTH(datetime) = ?
                    AND status = 'Lunas'
                    AND kategori IN ('Pembelian', 'Pendaftaran')
                GROUP BY 
                    hari, kategori
                ORDER BY 
                    hari ASC
            ";
            $stmt = $Conn->prepare($query);
            $stmt->bind_param('ii', $tahun, $bulan);
        }

        // Eksekusi query
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            // Data grafik
            $data = [
                'Pembelian' => [],
                'Pendaftaran' => []
            ];
            $labels = [];

            while ($row = $result->fetch_assoc()) {
                $label = $periode === 'Bulanan' ? (int)$row['bulan'] : (int)$row['hari'];
                $kategori = $row['kategori'];
                $total = (int)$row['total'];

                if (!in_array($label, $labels)) {
                    $labels[] = $label;
                }

                $data[$kategori][$label] = $total;
            }

            // Tambahkan nilai 0 untuk label yang kosong
            $range = $periode === 'Bulanan' ? range(1, 12) : range(1, cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun));
            foreach ($range as $key) {
                $response['values']['Pembelian'][] = $data['Pembelian'][$key] ?? 0;
                $response['values']['Pendaftaran'][] = $data['Pendaftaran'][$key] ?? 0;
            }

            // Format label sesuai periode
            $response['labels'] = $periode === 'Bulanan' 
                ? array_map(function($m) {
                    return date('F', mktime(0, 0, 0, $m, 1));
                }, $range)
                : $range;
        }
    } catch (Exception $e) {
        // Log error jika terjadi
        error_log("Error: " . $e->getMessage());
    }

    // Set header JSON dan kirimkan response
    header('Content-Type: application/json');
    echo json_encode($response);
?>