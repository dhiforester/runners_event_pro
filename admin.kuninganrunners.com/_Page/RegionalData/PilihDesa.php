<?php
    //Connection
    include "../../_Config/Connection.php";
    //Menangkap Provinsi
    if(!empty($_POST['kecamatan'])){
        $kecamatan=$_POST['kecamatan'];
        echo '<option value="">Pilih..</option>';
        $QryDesa= mysqli_query($Conn, "SELECT DISTINCT desa FROM wilayah WHERE kecamatan='$kecamatan' ORDER BY desa ASC");
        while ($DataDesa = mysqli_fetch_array($QryDesa)) {
            $desa= $DataDesa['desa'];
            if(!empty($desa)){
                echo '<option value="'.$desa.'">'.$desa.'</option>';
            }
        }
    }else{
        echo '<option value="">Pilih..</option>';
    }
?>