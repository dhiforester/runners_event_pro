<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    //Tangkap keyword_wialayah
    echo '<option>-Kab/Kota-</option>';
    if(!empty($_POST['propinsi'])){
        $propinsi=$_POST['propinsi'];
        $query = mysqli_query($Conn, "SELECT id_wilayah, kabupaten FROM wilayah WHERE propinsi='$propinsi' AND kategori='Kabupaten' ORDER BY kabupaten ASC");
        while ($data = mysqli_fetch_array($query)) {
            $id_wilayah= $data['id_wilayah'];
            $kabupaten= $data['kabupaten'];
            echo '<option value="'.$kabupaten.'">'.$kabupaten.'</option>';
        }
    }
?>