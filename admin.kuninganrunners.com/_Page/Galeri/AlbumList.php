<?php
    // Koneksi
    include "../../_Config/Connection.php";

    // Cek jika album ada dan tidak kosong
    if (!empty($_POST['album'])) {
        $album = $_POST['album'];
        // Escape input untuk keamanan
        $value = mysqli_real_escape_string($Conn, $album);

        // Query untuk mencari album yang sesuai
        $sql = "SELECT DISTINCT album FROM web_galeri WHERE album LIKE '%$value%' LIMIT 10";
        $result = mysqli_query($Conn, $sql);

        // Periksa apakah query berhasil
        if ($result) {
            // Membuat array untuk hasil pencarian
            while ($row = mysqli_fetch_assoc($result)) {
                $nama_album= $row['album'];
                echo '<option value="'.$nama_album.'">';
            }
        }
    } 
?>
