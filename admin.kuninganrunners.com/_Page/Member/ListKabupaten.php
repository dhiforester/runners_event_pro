<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    if(empty($SessionIdAkses)){
        echo '<option value="">No Access</option>';
    }else{
        if(empty($_POST['provinsi'])){
            echo '<option value="">Pilih</option>';
        }else{
            $provinsi=$_POST['provinsi'];
            echo '<option value="">Pilih</option>';
            $Qry = mysqli_query($Conn, "SELECT DISTINCT kabupaten FROM wilayah WHERE propinsi='$provinsi' ORDER BY kabupaten ASC");
            while ($Data = mysqli_fetch_array($Qry)) {
                if(!empty($Data['kabupaten'])){
                    $ListKabupaten= $Data['kabupaten'];
                    echo '<option value="'.$ListKabupaten.'">'.$ListKabupaten.'</option>';
                }
            }
        }
    }
?>