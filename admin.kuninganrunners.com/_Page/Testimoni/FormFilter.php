<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="web_testimoni.datetime"){
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="web_testimoni.sumber"){
                echo '<select type="text" name="keyword" id="keyword" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                    echo '  <option value="Manual">Manual</option>';
                    echo '  <option value="Website">Website</option>';
                    echo '</select>';
            }else{
                if($keyword_by=="web_testimoni.status"){
                    echo '<select type="text" name="keyword" id="keyword" class="form-control">';
                        echo '  <option value="">Pilih</option>';
                        echo '  <option value="Publish">Publish</option>';
                        echo '  <option value="Draft">Draft</option>';
                        echo '</select>';
                }else{
                    if($keyword_by=="web_testimoni.penilaian"){
                        echo '<select type="text" name="keyword" id="keyword" class="form-control">';
                            echo '  <option value="">Pilih</option>';
                            echo '  <option value="5">Sangat Baik</option>';
                            echo '  <option value="4">Baik</option>';
                            echo '  <option value="3">Sedang</option>';
                            echo '  <option value="2">Kurang</option>';
                            echo '  <option value="1">Buruk</option>';
                            echo '</select>';
                    }else{
                        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
                    }
                }
            }
        }
    }
?>