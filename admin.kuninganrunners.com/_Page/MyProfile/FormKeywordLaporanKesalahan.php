<?php
    if(empty($_POST['keyword_by_laporan_kesalahan'])){
        echo '<label for="keyword_laporan_kesalahan">Kata Kunci</label>';
        echo '<input type="text" name="keyword" id="keyword_laporan_kesalahan" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by_laporan_kesalahan'];
        if($keyword_by=="tanggal_report"){
            echo '<label for="keyword_laporan_kesalahan">Kata Kunci</label>';
            echo '<input type="date" name="keyword" id="keyword_laporan_kesalahan" class="form-control">';
        }else{
            if($keyword_by=="tanggal_selesai"){
                echo '<label for="keyword_laporan_kesalahan">Kata Kunci</label>';
                echo '<input type="date" name="keyword" id="keyword_laporan_kesalahan" class="form-control">';
            }else{
                if($keyword_by=="status"){
                    echo '<label for="keyword_laporan_kesalahan">Kata Kunci</label>';
                    echo '<select name="keyword" id="keyword_laporan_kesalahan" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                    echo '  <option value="Terkirim">Terkirim</option>';
                    echo '  <option value="Dibaca">Dibaca</option>';
                    echo '  <option value="Selesai">Selesai</option>';
                    echo '</select>';
                }else{
                    echo '<label for="keyword_laporan_kesalahan">Kata Kunci</label>';
                    echo '<input type="text" name="keyword" id="keyword_laporan_kesalahan" class="form-control">';
                }
            }
        }
    }
?>