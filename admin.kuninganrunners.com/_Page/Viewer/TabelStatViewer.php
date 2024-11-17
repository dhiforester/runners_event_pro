<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //SearchBy
    if(!empty($_POST['SearchBy'])){
        $SearchBy=$_POST['SearchBy'];
    }else{
        $SearchBy="ip_viewer";
    }
    //SearchKeyword
    if(!empty($_POST['SearchKeyword'])){
        $SearchKeyword=$_POST['SearchKeyword'];
    }else{
        $SearchKeyword="";
    }
    //Rekapitulasi
    if(!empty($_POST['Rekapitulasi'])){
        $Rekapitulasi=$_POST['Rekapitulasi'];
    }else{
        $Rekapitulasi="Tahunan";
    }
    if($Rekapitulasi=="Tahunan"){
        $keyword_waktu=$_POST['PeriodeStat'];
    }else{
        $PeriodeStat=$_POST['PeriodeStat'];
        $BulanStat=$_POST['BulanStat'];
        $keyword_waktu="$PeriodeStat-$BulanStat";
    }
    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_log FROM web_log WHERE $SearchBy like '%$SearchKeyword%' AND tanggal like '%$keyword_waktu%'"));
?>
<div class="row">
    <div class="col-md-12">
        <small>
            Keyword : <code><?php echo "$SearchKeyword"; ?></code>
        </small>
    </div>
</div>
<div class="table">
    <table class="table table-responsive table-hover">
        <thead>
            <tr>
                <td><b>No</b></td>
                <td><b>Periode</b></td>
                <td><b>Record</b></td>
            </tr>
        </thead>
        <tbody>
            <?php
                if(empty($jml_data)){
                    echo '<tr>';
                    echo '  <td class="text-center" colspan="3">';
                    echo '      <small>Tidak Ada Data Yang Ditampilkan</small>';
                    echo '  </td>';
                    echo '</tr>';
                }else{
                    if($Rekapitulasi=="Tahunan"){
                        //Perulanagan Bulan
                        $no=1;
                        for ($i=1; $i <= 12; $i++) { 
                            $formatted_i = str_pad($i, 2, '0', STR_PAD_LEFT);
                            $keyword="$keyword_waktu-$formatted_i";
                            $HitungData = mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_log FROM web_log WHERE $SearchBy like '%$SearchKeyword%' AND tanggal like '%$keyword%'"));
                            $nama_bulan=getNamaBulan($formatted_i);
                            echo '<tr>';
                            echo '  <td class="text-center"><small>'.$no.'</small></td>';
                            echo '  <td class="text-left"><small>'.$nama_bulan.'</small></td>';
                            if(empty($HitungData)){
                                echo '  <td class="text-left"><small class="text text-grayish">'.$HitungData.' Record</small></td>';
                            }else{
                                echo '  <td class="text-left"><small>'.$HitungData.' Record</small></td>';
                            }
                            
                            echo '</tr>';
                            $no++;
                        }
                    }else{
                        $PeriodeStat=$_POST['PeriodeStat'];
                        $BulanStat=$_POST['BulanStat'];
                        $keyword_waktu="$PeriodeStat-$BulanStat";
                        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $BulanStat, $PeriodeStat);
                        $no=1;
                        for ($i=1; $i <= $jumlah_hari; $i++) { 
                            $formatted_i = str_pad($i, 2, '0', STR_PAD_LEFT);
                            $keyword="$keyword_waktu-$formatted_i";
                            $HitungData = mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_log FROM web_log WHERE $SearchBy like '%$SearchKeyword%' AND tanggal like '%$keyword%'"));
                            $strtotime=strtotime($keyword);
                            $PeriodeFormat=date('d F Y', $strtotime);
                            echo '<tr>';
                            echo '  <td class="text-center"><small>'.$no.'</small></td>';
                            echo '  <td class="text-left"><small>'.$PeriodeFormat.'</small></td>';
                            if(empty($HitungData)){
                                echo '  <td class="text-left"><small class="text text-grayish">'.$HitungData.' Record</small></td>';
                            }else{
                                echo '  <td class="text-left"><small>'.$HitungData.' Record</small></td>';
                            }
                            
                            echo '</tr>';
                            $no++;
                        }
                    }
                }
            ?>
        </tbody>
    </table>
</div>