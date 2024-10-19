<?php
    //Connection
    include "../../_Config/Connection.php";
    //Menampilkan Provinsi
    echo '<option value="">Pilih</option>';
    $Qry = mysqli_query($Conn, "SELECT DISTINCT propinsi FROM wilayah ORDER BY propinsi ASC");
    while ($Data = mysqli_fetch_array($Qry)) {
        $propinsi= $Data['propinsi'];
        if(!empty($propinsi)){
            echo '<option value="'.$propinsi.'">'.$propinsi.'</option>';
        }
    }
?>