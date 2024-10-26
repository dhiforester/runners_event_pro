<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['id_event'])){
        echo '<input type="text" name="keyword_peserta" id="keyword_peserta" class="form-control">';
    }else{
        $id_event=$_POST['id_event'];
        if(empty($_POST['KeywordByPeserta'])){
            echo '<input type="text" name="keyword_peserta" id="keyword_peserta" class="form-control">';
        }else{
            $KeywordByPeserta=$_POST['KeywordByPeserta'];
            if($KeywordByPeserta=="datetime"){
                echo '<input type="date" name="keyword_peserta" id="keyword_peserta" class="form-control">';
            }else{
                if($KeywordByPeserta=="id_event_kategori"){
                    echo '<select type="text" name="keyword_peserta" id="keyword_peserta" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                    $QryKategori = mysqli_query($Conn, "SELECT * FROM event_kategori WHERE id_event='$id_event' ORDER BY kategori ASC");
                    while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                        $id_event_kategori= $DataKategori['id_event_kategori'];
                        $ListKategori= $DataKategori['kategori'];
                        echo '<option value="'.$id_event_kategori.'">'.$ListKategori.'</option>';
                    }
                    echo '</select>';
                }else{
                    if($KeywordByPeserta=="status"){
                        echo '<select type="text" name="keyword_peserta" id="keyword_peserta" class="form-control">';
                        echo '  <option value="">Pilih</option>';
                        echo '  <option value="Lunas">Lunas</option>';
                        echo '  <option value="Pending">Pending</option>';
                        echo '</select>';
                    }else{
                        echo '<input type="text" name="keyword_peserta" id="keyword_peserta" class="form-control">';
                    }
                }
            }
        }
    }
    
?>