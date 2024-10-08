<?php
    if(empty($_POST['keyword_by_aktivitas'])){
        echo '<label for="keyword_aktivitas">Kata Kunci</label>';
        echo '<input type="text" name="keyword" id="keyword_aktivitas" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by_aktivitas'];
        if($keyword_by=="datetime_log"){
            echo '<label for="keyword_aktivitas">Kata Kunci</label>';
            echo '<input type="date" name="keyword" id="keyword_aktivitas" class="form-control">';
        }else{
            echo '<label for="keyword_aktivitas">Kata Kunci</label>';
            echo '<input type="text" name="keyword" id="keyword_aktivitas" class="form-control">';
        }
    }
?>