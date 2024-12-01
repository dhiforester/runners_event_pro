<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    $query = mysqli_query($Conn, "SELECT DISTINCT kategori FROM barang ORDER BY kategori ASC");
    while ($data = mysqli_fetch_array($query)) {
        $kategori= $data['kategori'];
        echo '  <option value="'.$kategori.'"></option>';
    }
?>