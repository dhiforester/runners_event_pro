<?php
    // Sertakan koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    // Ambil data dari POST
    $id_member = $_POST['id_member'] ?? null;
    $periode = $_POST['periode'] ?? 'Bulanan';
    $periode_tahun = $_POST['periode_tahun'] ?? date('Y');
    $periode_bulan = $_POST['periode_bulan'] ?? null;
    if ($periode == 'Bulanan') {
        $keyword="$periode_tahun";
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_member_login FROM member_login WHERE id_member='$id_member'"));
    }else{
        $keyword="$periode_tahun-$periode_bulan";
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_member_login FROM member_login WHERE id_member ='$id_member'"));
    }
    echo "ID Member : $id_member<br>";
    echo "Jumlah Data : $jml_data<br>";
    echo "Keyword : $keyword<br>";
?>
