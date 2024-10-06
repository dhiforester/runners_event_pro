<?php
    //Karena Ini Di running Dengan JS maka Panggil Ulang Koneksi
    include "../_Config/Connection.php";
    include "../_Config/GlobalFunction.php";
    include "../_Config/Session.php";
    //Menghitung Notifikasi
    $JumlahPesertaBaru=0;
    $JumlahPembayaranBaru=0;
    $JumlahNotifikasi=$JumlahPesertaBaru+$JumlahPembayaranBaru;
    //Apabila Tidak ada notifgikasi
    if(empty($JumlahNotifikasi)){
        echo '<li class="dropdown-header">';
        echo '  Tidak Ada Pemberitahuan Yang Tersedia';
        echo '</li>';
    }else{
        //Apabila Ada
        echo '<li class="dropdown-header">';
        echo '  Anda Mempunyai '.$JumlahNotifikasi.' pemberitahuan';
        echo '</li>';
        if(!empty($JumlahPesertaBaru)){
            echo '<li><hr class="dropdown-divider"></li>';
            echo '<li class="notification-item">';
            echo '  <i class="bi bi-exclamation-circle text-danger"></i>';
            echo '  <div>';
            echo '      <h4><a href="index.php?Page=Peserta">Peserta Baru</a></h4>';
            echo '      <p>Ada '.$JumlahPesertaBaru.' peserta yang belum anda respon</p>';
            echo '  </div>';
            echo '</li>';
        }
    }
?>