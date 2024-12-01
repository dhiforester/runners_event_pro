<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="akses"){
            echo '<select type="text" name="keyword" id="keyword" class="form-control">';
            echo '  <option value="">Pilih</option>';
            $query = mysqli_query($Conn, "SELECT DISTINCT akses FROM akses ORDER BY akses DESC");
            while ($data = mysqli_fetch_array($query)) {
                $akses= $data['akses'];
                $jumlah_data=mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses FROM akses WHERE akses='$akses'"));
                echo '  <option value="'.$akses.'">'.$akses.' ('.$jumlah_data.')</option>';
            }
            echo '</select>';
        }else{
            echo '<input type="text" name="keyword" id="keyword" class="form-control">';
        }
    }
?>