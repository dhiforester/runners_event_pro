<?php
    //Karena Ini Di running Dengan JS maka Panggil Ulang Koneksi
    include "../_Config/Connection.php";
    include "../_Config/GlobalFunction.php";
    //Menghitung Testimoni Pending
    $JumlahTestimoniPending = mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_testimoni FROM web_testimoni WHERE status='Draft'"));
    $JumlahNotifikasi=$JumlahTestimoniPending;
    //Apabila ada notifgikasi
    if(!empty($JumlahNotifikasi)){
        echo '<i class="bi bi-chat-left-text text-light"></i>';
        echo '<span class="badge bg-success badge-number">'.$JumlahNotifikasi.'</span>';
    }else{
        echo '<i class="bi bi-chat-left-text text-light"></i>';
    }
?>