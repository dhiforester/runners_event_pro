<?php
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    // Menangkap Data
    $id_setting_api_key = empty($_POST['id']) ? "0" : $_POST['id'];
    $periode = empty($_POST['Periode']) ? "Tahunan" : $_POST['Periode'];
    $tahun = empty($_POST['Tahun']) ? date('Y') : $_POST['Tahun'];
    $bulan = empty($_POST['Bulan']) ? date('m') : $_POST['Bulan'];
    // Membentuk Kata Kunci Waktu
    if ($periode == "Tahunan") {
        $keyword_time = "$tahun";
    } else {
        $keyword_time = "$tahun-$bulan";
    }
?>
<div class="row mb-3">
    <div class="col-md-12 text-center">
        <b class="card-title text-dark">Rekapitulasi Log Api Key</b>
    </div>
</div>
<div class="row">
    <div class="col-md-12 table table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <td align="center"><b>No</b></td>
                    <td align="center"><b>Periode</b></td>
                    <td align="center"><b>Log</b></td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no=1;
                    if ($periode == "Bulanan") {
                        $NamaBulan=getNamaBulan($bulan);
                        $PeriodeName="Periode Bulan $NamaBulan Tahun $tahun";
                        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                        for ($day = 1; $day <= $days_in_month; $day++) {
                            $formatted_day = str_pad($day, 2, '0', STR_PAD_LEFT);
                            $Keyword = "$tahun-$bulan-$formatted_day";
                            // Query untuk jumlah Token
                            $QueryTotal = "SELECT id_log_api FROM log_api WHERE (id_setting_api_key='$id_setting_api_key') AND (datetime_log LIKE '%$Keyword%')";
                            $ResultTotal = mysqli_query($Conn, $QueryTotal);
                            $JumlahToken = ($ResultTotal) ? mysqli_num_rows($ResultTotal) : 0;
                            echo '<tr>';
                            echo '  <td align="center">'.$no.'</td>';
                            echo '  <td align="left">';
                            echo '      <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalListLogApiKey" data-id="'.$id_setting_api_key.','.$periode.','.$Keyword.'">';
                            echo '          '.$formatted_day.' '.$NamaBulan.' '.$tahun.'';
                            echo '      </a>';
                            echo '  </td>';
                            echo '  <td align="left">'.$JumlahToken.' Record</td>';
                            echo '</tr>';
                            $no++;
                        }
                    } else {
                        $PeriodeName="Periode Tahun $tahun";
                        for ($BulanList = 1; $BulanList <= 12; $BulanList++) {
                            $format_bulan = str_pad($BulanList, 2, '0', STR_PAD_LEFT);
                            $Keyword = "$tahun-$format_bulan";
                            $NamaBulan=getNamaBulan($format_bulan); 
                            // Query untuk jumlah total
                            $QueryTotal = "SELECT id_log_api FROM log_api WHERE (id_setting_api_key='$id_setting_api_key') AND (datetime_log LIKE '%$Keyword%')";
                            $ResultTotal = mysqli_query($Conn, $QueryTotal);
                            $JumlahToken = ($ResultTotal) ? mysqli_num_rows($ResultTotal) : 0;
                            echo '<tr>';
                            echo '  <td align="center">'.$no.'</td>';
                            echo '  <td align="left">';
                            echo '      <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalListLogApiKey" data-id="'.$id_setting_api_key.','.$periode.','.$Keyword.'">';
                            echo '          '.$NamaBulan.' '.$tahun.'';
                            echo '      </a>';
                            echo '  </td>';
                            echo '  <td align="left">'.$JumlahToken.' Record</td>';
                            echo '</tr>';
                            $no++;
                        }
                    }
                    $Conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>