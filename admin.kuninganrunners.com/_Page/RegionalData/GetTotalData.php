<?php
    include "../../_Config/Connection.php";
    $response = [
        'success' => false,
        'total' => 0
    ];
    $sql = "SELECT COUNT(*) as total FROM wilayah";
    $result = mysqli_query($Conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $response['success'] = true;
        $response['total'] = (int)$row['total'];
    } else {
        $response['message'] = 'Gagal menghitung jumlah data';
    }
    echo json_encode($response);
?>