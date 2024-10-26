<?php
    //Karena Ini Di running Dengan JS maka Panggil Ulang Koneksi
    include "../_Config/Connection.php";
    include "../_Config/GlobalFunction.php";
    include "../_Config/Session.php";
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
        if(!empty($JumlahEventTidakAdaKategori)){
            echo '<li><hr class="dropdown-divider"></li>';
            echo '<li class="notification-item">';
            echo '  <i class="bi bi-exclamation-circle text-danger"></i>';
            echo '  <div>';
            echo '      <h4><a href="index.php?Page=Event">Event Belum Diatur</a></h4>';
            echo '      <p>Ada '.$JumlahEventTidakAdaKategori.' event belum memiliki data kategori</p>';
            echo '  </div>';
            echo '</li>';
        }
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