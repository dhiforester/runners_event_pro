<?php
    //Karena Ini Di running Dengan JS maka Panggil Ulang Koneksi
    include "../_Config/Connection.php";
    //Menghitung Event Yang Tidak Memiliki Kategori
    $JumlahEventTidakAdaKategori=0;
    $QryEvent = mysqli_query($Conn, "SELECT id_event FROM event");
    while ($DataEvent = mysqli_fetch_array($QryEvent)) {
        $id_event= $DataEvent['id_event'];
        $JumlahKategori = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_kategori FROM event_kategori WHERE id_event='$id_event'"));
        if(empty($JumlahKategori)){
            $JumlahEventTidakAdaKategori=$JumlahEventTidakAdaKategori+1;
        }
    }
    $JumlahPesertaBaru=0;
    $JumlahPembayaranBaru=0;
    $JumlahNotifikasi=$JumlahEventTidakAdaKategori+$JumlahPesertaBaru+$JumlahPembayaranBaru;
    //Apabila ada notifgikasi
    if(!empty($JumlahNotifikasi)){
        echo '<i class="bi bi-bell"></i>';
        echo '<span class="badge bg-danger rounded-pill badge-number">'.$JumlahNotifikasi.'</span>';
    }else{
        //Apabila Tidak Ada
        echo '<i class="bi bi-bell"></i>';
    }
?>