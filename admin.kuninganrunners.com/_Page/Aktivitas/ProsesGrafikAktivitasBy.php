<?php
    include "../../_Config/Connection.php";
    //Menangkap Data
    if(empty($_POST['select_data'])){
        $select_data="title_api_key";
    }else{
        $select_data=$_POST['select_data'];
    }
    if(empty($_POST['mode_data'])){
        $mode_data="semua";
    }else{
        $mode_data=$_POST['mode_data'];
    }
    if(empty($_POST['form_date'])){
        $form_date=date('d');
    }else{
        $form_date=$_POST['form_date'];
    }
    if(empty($_POST['form_month'])){
        $form_month=date('m');
    }else{
        $form_month=$_POST['form_month'];
    }
    if(empty($_POST['form_year'])){
        $form_year=date('Y');
    }else{
        $form_year=$_POST['form_year'];
    }
    //Membentuk Kata Kunci Waktu
    if($mode_data=="semua"){
        $keyword_time="";
    }else{
        if($mode_data=="harian"){
            $keyword_time=$form_date;
        }else{
            if($mode_data=="bulanan"){
                $keyword_time="$form_year-$form_month";
            }else{
                if($mode_data=="tahunan"){
                    $keyword_time=$form_year;
                }else{
                    $keyword_time="";
                }
            }
        }
    }
    $kategori_log = [];
    $jumlah_aktivitas = [];
    //Melakukan Looping Kategori
    $query = mysqli_query($Conn, "SELECT DISTINCT $select_data FROM log WHERE datetime_log like '%$keyword_time%' ORDER BY $select_data ASC");
    while ($data = mysqli_fetch_array($query)) {
        $kategori= $data[$select_data];
        $kategori_log[] =$kategori;
        $jumlah_log = mysqli_num_rows(mysqli_query($Conn, "SELECT id_log FROM log WHERE ($select_data='$kategori') AND (datetime_log like '%$keyword_time%')"));
        $jumlah_aktivitas[] =$jumlah_log;
    }

    $Conn->close();

    // Kirim data dalam format JSON
    echo json_encode(['months' => $kategori_log, 'amounts' => $jumlah_aktivitas]);
?>
