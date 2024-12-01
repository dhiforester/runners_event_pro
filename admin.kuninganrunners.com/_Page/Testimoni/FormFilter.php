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
                $JumlahTestimoniManual=mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_testimoni FROM web_testimoni WHERE sumber='Manual'"));
                $JumlahTestimoniWebsite=mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_testimoni FROM web_testimoni WHERE sumber='Website'"));
                echo '<select type="text" name="keyword" id="keyword" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                    echo '  <option value="Manual">Manual ('.$JumlahTestimoniManual.')</option>';
                    echo '  <option value="Website">Website ('.$JumlahTestimoniWebsite.')</option>';
                    echo '</select>';
            }else{
                if($keyword_by=="web_testimoni.status"){
                    $JumlahTestimoniPublish=mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_testimoni FROM web_testimoni WHERE status='Publish'"));
                    $JumlahTestimoniDraft=mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_testimoni FROM web_testimoni WHERE status='Draft'"));
                    echo '<select type="text" name="keyword" id="keyword" class="form-control">';
                        echo '  <option value="">Pilih</option>';
                        echo '  <option value="Publish">Publish ('.$JumlahTestimoniPublish.')</option>';
                        echo '  <option value="Draft">Draft ('.$JumlahTestimoniDraft.')</option>';
                        echo '</select>';
                }else{
                    if($keyword_by=="web_testimoni.penilaian"){
                        $JumlahTestimoniPenilaian1=mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_testimoni FROM web_testimoni WHERE penilaian='1'"));
                        $JumlahTestimoniPenilaian2=mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_testimoni FROM web_testimoni WHERE penilaian='2'"));
                        $JumlahTestimoniPenilaian3=mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_testimoni FROM web_testimoni WHERE penilaian='3'"));
                        $JumlahTestimoniPenilaian4=mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_testimoni FROM web_testimoni WHERE penilaian='4'"));
                        $JumlahTestimoniPenilaian5=mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_testimoni FROM web_testimoni WHERE penilaian='5'"));
                        echo '<select type="text" name="keyword" id="keyword" class="form-control">';
                            echo '  <option value="">Pilih</option>';
                            echo '  <option value="5">Sangat Baik ('.$JumlahTestimoniPenilaian1.')</option>';
                            echo '  <option value="4">Baik ('.$JumlahTestimoniPenilaian2.')</option>';
                            echo '  <option value="3">Sedang ('.$JumlahTestimoniPenilaian3.')</option>';
                            echo '  <option value="2">Kurang ('.$JumlahTestimoniPenilaian4.')</option>';
                            echo '  <option value="1">Buruk ('.$JumlahTestimoniPenilaian5.')</option>';
                            echo '</select>';
                    }else{
                        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
                    }
                }
            }
        }
    }
?>