<?php
    // Koneksi
    include "../../_Config/Connection.php";

    // Query untuk mencari album yang sesuai
    $sql = "SELECT DISTINCT album FROM web_galeri";
    $result = mysqli_query($Conn, $sql);

    // Periksa apakah query berhasil
    if ($result) {
        // Membuat array untuk hasil pencarian
        while ($row = mysqli_fetch_assoc($result)) {
            $nama_album= $row['album'];
            echo '<option value="'.$nama_album.'">';
        }
    }
?>
