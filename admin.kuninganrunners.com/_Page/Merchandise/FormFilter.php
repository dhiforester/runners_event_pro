<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="kategori"){
            echo '<select type="text" name="keyword" id="keyword" class="form-control">';
            echo '  <option value="">Pilih</option>';
            $Qry = mysqli_query($Conn, "SELECT DISTINCT kategori FROM barang ORDER BY kategori ASC");
            while ($Data = mysqli_fetch_array($Qry)) {
                $List= $Data['kategori'];
                echo '<option value="'.$List.'">'.$List.'</option>';
            }
            echo '</select>';
        }else{
            if($keyword_by=="satuan"){
                echo '<select type="text" name="keyword" id="keyword" class="form-control">';
                echo '  <option value="">Pilih</option>';
                $Qry = mysqli_query($Conn, "SELECT DISTINCT satuan FROM barang ORDER BY satuan ASC");
                while ($Data = mysqli_fetch_array($Qry)) {
                    $List= $Data['satuan'];
                    echo '<option value="'.$List.'">'.$List.'</option>';
                }
                echo '</select>';
            }else{
                if($keyword_by=="datetime"){
                    echo '<input type="date" name="keyword" id="keyword" class="form-control">';
                }else{
                    if($keyword_by=="updatetime"){
                        echo '<input type="date" name="keyword" id="keyword" class="form-control">';
                    }else{
                        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
                    }
                }
            }
        }
    }
?>