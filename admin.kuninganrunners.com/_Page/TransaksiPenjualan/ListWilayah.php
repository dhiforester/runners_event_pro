<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    //Tangkap keyword_wialayah
    if(!empty($_POST['keyword_wialayah'])){
        $keyword=$_POST['keyword_wialayah'];
        if(strlen($keyword)>3){
            $query = mysqli_query($Conn, "SELECT*FROM wilayah WHERE (kategori='desa') AND (propinsi like '%$keyword%' OR kabupaten like '%$keyword%' OR kecamatan like '%$keyword%' OR desa like '%$keyword%') ORDER BY propinsi ASC LIMIT 20 ");
            while ($data = mysqli_fetch_array($query)) {
                $id_wilayah= $data['id_wilayah'];
                $propinsi= $data['propinsi'];
                $kabupaten= $data['kabupaten'];
                $kecamatan= $data['kecamatan'];
                $desa= $data['desa'];
                echo '<option value="'.$propinsi.','.$kabupaten.','.$kecamatan.','.$desa.'">';
            }
        }
    }
?>