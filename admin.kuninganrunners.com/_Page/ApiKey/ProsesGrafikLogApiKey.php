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
    //Start Creat Array
    $x_axis = [];
    $y_axis_total = []; // Untuk jumlah Token
    // Array nama-nama bulan
    $nama_bulan = [
        1 => "Januari", 
        2 => "Februari", 
        3 => "Maret", 
        4 => "April", 
        5 => "Mei", 
        6 => "Juni", 
        7 => "Juli", 
        8 => "Agustus", 
        9 => "September", 
        10 => "Oktober", 
        11 => "November", 
        12 => "Desember"
    ];
    // Melakukan Looping Berdasarkan Periode
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
            //Put On Array
            $x_axis[] = $formatted_day;
            $y_axis_total[] = $JumlahToken;
        }
    } else {
        $PeriodeName="Periode Tahun $tahun";
        for ($BulanList = 1; $BulanList <= 12; $BulanList++) {
            $format_bulan = str_pad($BulanList, 2, '0', STR_PAD_LEFT);
            $Keyword = "$tahun-$format_bulan";
            $NamaBulan=getNamaBulan($format_bulan); 
            // Query untuk jumlah total pelamar
            $QueryTotal = "SELECT id_log_api FROM log_api WHERE (id_setting_api_key='$id_setting_api_key') AND (datetime_log LIKE '%$Keyword%')";
            $ResultTotal = mysqli_query($Conn, $QueryTotal);
            $JumlahToken = ($ResultTotal) ? mysqli_num_rows($ResultTotal) : 0;
             //Put On Array
            $x_axis[] = "$NamaBulan";
            $y_axis_total[] = $JumlahToken;
        }
    }

    $Conn->close();

    // Kirim data dalam format JSON
    echo json_encode([
        'periode_name' => $PeriodeName,
        'months' => $x_axis,
        'total' => $y_axis_total,
    ]);
?>
