<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['KeywordBy'])){
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $KeywordBy=$_POST['KeywordBy'];
        if($KeywordBy=="kategori"){
            echo '<select name="keyword" id="keyword" class="form-control">';
            echo '  <option value="">Pilih</option>';
            $query = mysqli_query($Conn, "SELECT DISTINCT kategori FROM wilayah ORDER BY kategori DESC");
            while ($data = mysqli_fetch_array($query)) {
                $kategori= $data['kategori'];
                if($kategori=="desa"){
                    echo '<option value="desa">Desa/Kelurahan</option>';
                }else{
                    if($kategori=="Kabupaten"){
                        echo '<option value="Kabupaten">Kabupaten/Kota</option>';
                    }else{
                        echo '<option value="'.$kategori.'">'.$kategori.'</option>';
                    }
                }
            }
            echo '</select>';
        }else{
            echo '<input type="text" name="keyword" id="keyword" class="form-control">';
        }
    }
?>