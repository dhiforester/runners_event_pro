<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    //Tangkap keyword_wialayah
    echo '<option>-Desa/Kelurahan-</option>';
    if(!empty($_POST['propinsi'])){
        if(!empty($_POST['kabupaten'])){
            if(!empty($_POST['kecamatan'])){
                $propinsi=$_POST['propinsi'];
                $kabupaten=$_POST['kabupaten'];
                $kecamatan=$_POST['kecamatan'];
                $query = mysqli_query($Conn, "SELECT id_wilayah, desa FROM wilayah WHERE propinsi='$propinsi' AND kabupaten='$kabupaten' AND kecamatan='$kecamatan' AND kategori='desa' ORDER BY desa ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_wilayah= $data['id_wilayah'];
                    $desa= $data['desa'];
                    echo '<option value="'.$desa.'">'.$desa.'</option>';
                }
            }
        }
    }
?>