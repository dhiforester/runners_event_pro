<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="datetime_creat"){
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="datetime_update"){
                echo '<input type="date" name="keyword" id="keyword" class="form-control">';
            }else{
                if($keyword_by=="status"){
                    $JumlahAktif=mysqli_num_rows(mysqli_query($Conn, "SELECT id_setting_api_key FROM setting_api_key WHERE status='Aktif'"));
                    $JumlahNone=mysqli_num_rows(mysqli_query($Conn, "SELECT id_setting_api_key FROM setting_api_key WHERE status='None'"));
                    echo '<select name="keyword" id="keyword" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                    echo '  <option value="Aktif">Aktif ('.$JumlahAktif.')</option>';
                    echo '  <option value="None">No Active ('.$JumlahNone.')</option>';
                    echo '</select>';
                }else{
                    echo '<input type="text" name="keyword" id="keyword" class="form-control">';
                }
            }
        }
    }
?>