<?php
    if(empty($_POST['mode_data'])){
        echo '<input type="date" readonly name="form_date" id="form_date" class="form-control">';
        echo '<small class="credit">';
        echo '  <label for="form_date">Tanggal</label>';
        echo '</small>';
    }else{
        $mode_data=$_POST['mode_data'];
        if($mode_data=="harian"){
            echo '<input type="date" name="form_date" id="form_date" class="form-control" value="'.date('d-m-Y').'">';
            echo '<small class="credit">';
            echo '  <label for="form_date">Tanggal</label>';
            echo '</small>';
        }else{
            if($mode_data=="tahunan"){
                echo '<input type="number" name="form_year" id="form_year" class="form-control" value="'.date('Y').'">';
                echo '<small class="credit">';
                echo '  <label for="form_year">Tahun</label>';
                echo '</small>';
            }else{
                if($mode_data=="bulanan"){
                    echo '<div class="row">';
                    echo '<div class="col-md-6 mb-3">';
                    echo '  <input type="number" id="form_year" name="form_year" class="form-control" value="'.date('Y').'">';
                    echo '  <small class="credit">';
                    echo '      <label for="form_year">Tahun</label>';
                    echo '  </small>';
                    echo '</div>';
                    echo '<div class="col-md-6 mb-3">';
                    echo '  <select name="form_month" id="form_month" class="form-control">';
                    $months = [
                        "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
                        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                    ];
                    
                    for ($i = 0; $i < 12; $i++) {
                        // Menambahkan leading zero pada bulan yang nomornya kurang dari 10
                        $monthNumber = str_pad($i + 1, 2, "0", STR_PAD_LEFT);
                        echo '<option value="'.$monthNumber.'">'. $months[$i] .'</option>';
                    }
                    echo '  </select>';
                    echo '  <small class="credit">';
                    echo '      <label for="form_month">Bulan</label>';
                    echo '  </small>';
                    echo '</div>';
                    echo '</div>';
                }else{
                    echo '<input type="date" readonly name="tanggal" id="tanggal" class="form-control" value="'.date('d-m-Y').'">';
                    echo '<small class="credit">';
                    echo '  <label for="tanggal">Tanggal</label>';
                    echo '</small>';
                }
            }
        }
    }
?>