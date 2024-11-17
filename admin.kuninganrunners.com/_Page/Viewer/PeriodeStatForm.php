<?php
    include "../../_Config/GlobalFunction.php";
    if(empty($_POST['Rekapitulasi'])){
        $Rekapitulasi="Tahunan";
    }else{
        $Rekapitulasi=$_POST['Rekapitulasi'];
    }
    if($Rekapitulasi=="Tahunan"){
        echo '<input type="number" step="1" min="2000" name="PeriodeStat" id="PeriodeStat" class="form-control" value="'.date('Y').'">';
    }else{
        echo '<div class="input-group">';
        echo '  <input type="number" step="1" min="2000" name="PeriodeStat" id="PeriodeStat" class="form-control" value="'.date('Y').'">';
        echo '  <select  class="form-control" name="BulanStat" id="BulanStat">';
        for ($i=1; $i <= 12; $i++) { 
            $formatted_i = str_pad($i, 2, '0', STR_PAD_LEFT);
            $nama_bulan=getNamaBulan($formatted_i);
            if($formatted_i==date('m')){
                echo '<option selected value="'.$formatted_i.'">'.$nama_bulan.'</option>';
            }else{
                echo '<option value="'.$formatted_i.'">'.$nama_bulan.'</option>';
            }
        }
        echo '  </select>';
        echo '</div>';
    }
?>