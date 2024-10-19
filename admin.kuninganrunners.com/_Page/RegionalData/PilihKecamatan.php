<?php
    //Connection
    include "../../_Config/Connection.php";
    //Menangkap Provinsi
    if(!empty($_POST['Kabupaten'])){
        $kabupaten=$_POST['Kabupaten'];
        echo '<option value="">Pilih</option>';
        $QryKecamatan = mysqli_query($Conn, "SELECT DISTINCT kecamatan FROM wilayah WHERE kabupaten='$kabupaten' ORDER BY kecamatan ASC");
        while ($DataKecamatan = mysqli_fetch_array($QryKecamatan)) {
            $kecamatan= $DataKecamatan['kecamatan'];
            if(!empty($kecamatan)){
                echo '<option value="'.$kecamatan.'">'.$kecamatan.'</option>';
            }
        }
    }else{
        echo '<option value="">Pilih..</option>';
    }
?>