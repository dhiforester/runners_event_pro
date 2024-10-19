<?php
    include "../../_Config/Connection.php";

    $response = [
        'success' => false,
        'message' => '',
        'more_data' => false // Tambahkan indikator apakah ada data yang tersisa
    ];

    // Ambil 50 data yang belum diproses
    $sql = "SELECT id_wilayah, propinsi, kabupaten, kecamatan, desa 
            FROM wilayah 
            WHERE propinsi LIKE ' %' OR propinsi LIKE '% ' 
            OR kabupaten LIKE ' %' OR kabupaten LIKE '% ' 
            OR kecamatan LIKE ' %' OR kecamatan LIKE '% ' 
            OR desa LIKE ' %' OR desa LIKE '% ' 
            LIMIT 50";
    $result = mysqli_query($Conn, $sql);

    if ($result === false) {
        $response['message'] = 'Kesalahan query: ' . mysqli_error($Conn);
        echo json_encode($response);
        exit;
    }

    $updated_count = 0;

    if (mysqli_num_rows($result) > 0) {
        // Memulai transaksi
        mysqli_begin_transaction($Conn);

        while ($row = mysqli_fetch_assoc($result)) {
            $id_wilayah = $row['id_wilayah'];
            $propinsi_baru = trim($row['propinsi']);
            $kabupaten_baru = trim($row['kabupaten']);
            $kecamatan_baru = trim($row['kecamatan']);
            $desa_baru = trim($row['desa']);

            // Update data
            $update_sql = "UPDATE wilayah 
                        SET propinsi = ?, kabupaten = ?, kecamatan = ?, desa = ? 
                        WHERE id_wilayah = ?";
            $stmt = $Conn->prepare($update_sql);

            if ($stmt === false) {
                $response['message'] = 'Kesalahan prepare statement: ' . $Conn->error;
                echo json_encode($response);
                exit;
            }

            $stmt->bind_param('ssssi', $propinsi_baru, $kabupaten_baru, $kecamatan_baru, $desa_baru, $id_wilayah);

            if ($stmt->execute()) {
                $updated_count++;
            } else {
                $response['message'] = 'Kesalahan eksekusi statement: ' . $stmt->error;
                echo json_encode($response);
                $stmt->close();
                mysqli_rollback($Conn);
                exit;
            }

            $stmt->close();
        }

        if ($updated_count > 0) {
            mysqli_commit($Conn);
            $response['success'] = true;
            $response['message'] = "$updated_count data berhasil diperbarui.";

            // Cek jika masih ada data yang perlu diproses
            $check_sql = "SELECT 1 FROM wilayah 
                        WHERE propinsi LIKE ' %' OR propinsi LIKE '% ' 
                            OR kabupaten LIKE ' %' OR kabupaten LIKE '% ' 
                            OR kecamatan LIKE ' %' OR kecamatan LIKE '% ' 
                            OR desa LIKE ' %' OR desa LIKE '% ' 
                        LIMIT 1";
            $check_result = mysqli_query($Conn, $check_sql);
            $response['more_data'] = mysqli_num_rows($check_result) > 0;
        } else {
            mysqli_rollback($Conn);
            $response['message'] = 'Gagal memperbarui data.';
        }
    } else {
        $response['message'] = 'Tidak ada data yang perlu diperbaiki.';
    }

    echo json_encode($response);
?>
