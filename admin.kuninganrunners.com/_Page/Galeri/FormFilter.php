<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="id_web_galeri_album"){
            echo '<select type="text" name="keyword" id="keyword" class="form-control">';
            echo '  <option value="">Pilih</option>';
            $Qry = mysqli_query($Conn, "SELECT DISTINCT id_web_galeri_album, album FROM web_galeri_album ORDER BY album ASC");
            while ($Data = mysqli_fetch_array($Qry)) {
                $id_web_galeri_album= $Data['id_web_galeri_album'];
                $album= $Data['album'];
                $jumlah_data=mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_galeri FROM web_galeri WHERE album='$album'"));
                echo '<option value="'.$id_web_galeri_album.'">'.$album.' ('.$jumlah_data.')</option>';
            }
            echo '</select>';
        }else{
            if($keyword_by=="datetime"){
                echo '<input type="date" name="keyword" id="keyword" class="form-control">';
            }else{
                echo '<input type="text" name="keyword" id="keyword" class="form-control">';
            }
        }
    }
?>