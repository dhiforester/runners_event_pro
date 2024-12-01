<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($_POST['KeywordBy'])){
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $KeywordBy=$_POST['KeywordBy'];
        if($KeywordBy=="kategori"){
            echo '<select name="keyword" id="keyword" class="form-control">';
            echo '  <option value="">Pilih</option>';
            $query = mysqli_query($Conn, "SELECT DISTINCT kategori FROM akses_fitur ORDER BY kategori ASC");
            while ($data = mysqli_fetch_array($query)) {
                $kategori= $data['kategori'];
                //Hitung Jumlah Data 
                $jumlah_data=mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses_fitur FROM akses_fitur WHERE kategori='$kategori'"));
                echo '<option value="'.$kategori.'">'.$kategori.' ('.$jumlah_data.')</option>';
            }
            echo '</select>';
        }else{
            echo '<input type="text" name="keyword" id="keyword" class="form-control">';
        }
    }
?>