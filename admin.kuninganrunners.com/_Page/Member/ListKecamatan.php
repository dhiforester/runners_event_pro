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
            if(empty($_POST['kabupaten'])){
                echo '<option value="">Pilih</option>';
            }else{
                $provinsi=$_POST['provinsi'];
                $kabupaten=$_POST['kabupaten'];
                echo '<option value="">Pilih</option>';
                $Qry = mysqli_query($Conn, "SELECT DISTINCT kecamatan FROM wilayah WHERE propinsi='$provinsi' AND kabupaten='$kabupaten' ORDER BY kecamatan ASC");
                while ($Data = mysqli_fetch_array($Qry)) {
                    if(!empty($Data['kecamatan'])){
                        $ListKecamatan= $Data['kecamatan'];
                        echo '<option value="'.$ListKecamatan.'">'.$ListKecamatan.'</option>';
                    }
                }
            }
        }
    }
?>