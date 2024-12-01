<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="datetime"){
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="sumber_vidio"){
                $JumlahVidioLokal=mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_vidio FROM web_vidio WHERE sumber_vidio='Local'"));
                $JumlahVidioUrl=mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_vidio FROM web_vidio WHERE sumber_vidio='Url'"));
                $JumlahVidioEmbed=mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_vidio FROM web_vidio WHERE sumber_vidio='Embed'"));
                echo '<select type="text" name="keyword" id="keyword" class="form-control">';
                echo '  <option value="">Pilih</option>';
                echo '  <option value="Local">Local ('.$JumlahVidioLokal.')</option>';
                echo '  <option value="Url">Url ('.$JumlahVidioUrl.')</option>';
                echo '  <option value="Embed">Embed ('.$JumlahVidioEmbed.')</option>';
                echo '</select>';
            }else{
                echo '<input type="text" name="keyword" id="keyword" class="form-control">';
            }
        }
    }
?>