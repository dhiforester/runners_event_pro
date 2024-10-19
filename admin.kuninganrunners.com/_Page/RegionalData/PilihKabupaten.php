<?php
    //Connection
    include "../../_Config/Connection.php";
    //Menangkap Provinsi
    if(!empty($_POST['Propinsi'])){
        $propinsi=$_POST['Propinsi'];
        echo '<option value="">Pilih</option>';
        $QryKabupaten = mysqli_query($Conn, "SELECT DISTINCT kabupaten FROM wilayah WHERE propinsi='$propinsi' ORDER BY desa ASC");
        while ($DataKabupaten = mysqli_fetch_array($QryKabupaten)) {
            $kabupaten= $DataKabupaten['kabupaten'];
            if(!empty($kabupaten)){
                echo '<option value="'.$kabupaten.'">'.$kabupaten.'</option>';
            }
        }
    }else{
        echo '<option value="">Pilih</option>';
    }
?>