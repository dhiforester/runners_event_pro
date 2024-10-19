<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="provinsi"){
            echo '<select type="text" name="keyword" id="keyword" class="form-control">';
            echo '  <option value="">Pilih</option>';
            $QryProv = mysqli_query($Conn, "SELECT DISTINCT propinsi FROM member ORDER BY propinsi ASC");
            while ($DataProv = mysqli_fetch_array($QryProv)) {
                $ListProvinsi= $DataProv['propinsi'];
                echo '<option value="'.$ListProvinsi.'">'.$ListProvinsi.'</option>';
            }
            echo '</select>';
        }else{
            if($keyword_by=="kabupaten"){
                echo '<select type="text" name="keyword" id="keyword" class="form-control">';
                echo '  <option value="">Pilih</option>';
                $Qry = mysqli_query($Conn, "SELECT DISTINCT kabupaten FROM member ORDER BY kabupaten ASC");
                while ($Data = mysqli_fetch_array($Qry)) {
                    $ListKabupaten= $Data['kabupaten'];
                    echo '<option value="'.$ListKabupaten.'">'.$ListKabupaten.'</option>';
                }
                echo '</select>';
            }else{
                if($keyword_by=="kecamatan"){
                    echo '<select type="text" name="keyword" id="keyword" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                    $Qry = mysqli_query($Conn, "SELECT DISTINCT kecamatan FROM member ORDER BY kecamatan ASC");
                    while ($Data = mysqli_fetch_array($Qry)) {
                        $ListKecamatan= $Data['kecamatan'];
                        echo '<option value="'.$ListKecamatan.'">'.$ListKecamatan.'</option>';
                    }
                    echo '</select>';
                }else{
                    if($keyword_by=="desa"){
                        echo '<select type="text" name="keyword" id="keyword" class="form-control">';
                        echo '  <option value="">Pilih</option>';
                        $Qry = mysqli_query($Conn, "SELECT DISTINCT desa FROM member ORDER BY desa ASC");
                        while ($Data = mysqli_fetch_array($Qry)) {
                            $ListDesa= $Data['desa'];
                            echo '<option value="'.$ListDesa.'">'.$ListDesa.'</option>';
                        }
                        echo '</select>';
                    }else{
                        if($keyword_by=="datetime"){
                            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
                        }else{
                            if($keyword_by=="status"){
                                echo '<select type="text" name="keyword" id="keyword" class="form-control">';
                                echo '  <option value="">Pilih</option>';
                                $Qry = mysqli_query($Conn, "SELECT DISTINCT status FROM member ORDER BY status ASC");
                                while ($Data = mysqli_fetch_array($Qry)) {
                                    $status= $Data['status'];
                                    echo '<option value="'.$status.'">'.$status.'</option>';
                                }
                                echo '</select>';
                            }else{
                                if($keyword_by=="sumber"){
                                    echo '<select type="text" name="keyword" id="keyword" class="form-control">';
                                    echo '  <option value="">Pilih</option>';
                                    $Qry = mysqli_query($Conn, "SELECT DISTINCT sumber FROM member ORDER BY sumber ASC");
                                    while ($Data = mysqli_fetch_array($Qry)) {
                                        $sumber= $Data['sumber'];
                                        echo '<option value="'.$sumber.'">'.$sumber.'</option>';
                                    }
                                    echo '</select>';
                                }else{
                                    echo '<input type="text" name="keyword" id="keyword" class="form-control">';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>