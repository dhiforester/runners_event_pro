<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    //Tangkap keyword_wialayah
    echo '<option>-Desa/Kelurahan-</option>';
    if(!empty($_POST['propinsi'])){
        if(!empty($_POST['kabupaten'])){
            $propinsi=$_POST['propinsi'];
            $kabupaten=$_POST['kabupaten'];
            $query = mysqli_query($Conn, "SELECT id_wilayah, kecamatan FROM wilayah WHERE propinsi='$propinsi' AND kabupaten='$kabupaten' AND kategori='Kecamatan' ORDER BY kecamatan ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_wilayah= $data['id_wilayah'];
                $kecamatan= $data['kecamatan'];
                echo '<option value="'.$kecamatan.'">'.$kecamatan.'</option>';
            }
        }
    }
?>