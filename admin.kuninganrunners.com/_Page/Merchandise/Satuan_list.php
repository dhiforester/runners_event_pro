<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    $query = mysqli_query($Conn, "SELECT DISTINCT satuan FROM barang ORDER BY satuan ASC");
    while ($data = mysqli_fetch_array($query)) {
        $satuan= $data['satuan'];
        echo '  <option value="'.$satuan.'"></option>';
    }
?>