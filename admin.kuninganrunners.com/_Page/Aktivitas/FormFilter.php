<?php
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="datetime_log"){
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="id_akses"){
                echo '<select name="keyword" id="keyword" class="form-control">';
                echo '  <option value="">Pilih</option>';
                //Arraykan Data Status Akses
                $query = mysqli_query($Conn, "SELECT DISTINCT id_akses FROM log");
                while ($data = mysqli_fetch_array($query)) {
                    if(!empty($data['id_akses'])){
                        $id_akses= $data['id_akses'];
                        $nama=GetDetailData($Conn,'akses','id_akses',$id_akses,'nama_akses');
                        echo '  <option value="'.$id_akses.'">'.$nama.'</option>';
                    }
                }
                echo '</select>';
            }else{
                if($keyword_by=="kategori_log"){
                    echo '<select name="keyword" id="keyword" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                    //Arraykan Data Status Akses
                    $query = mysqli_query($Conn, "SELECT DISTINCT kategori_log FROM log ORDER BY kategori_log ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        if(!empty($data['kategori_log'])){
                            $kategori_log= $data['kategori_log'];
                            echo '  <option value="'.$kategori_log.'">'.$kategori_log.'</option>';
                        }
                    }
                    echo '</select>';
                }else{
                    echo '<input type="text" name="keyword" id="keyword" class="form-control">';
                }
            }
        }
    }
?>