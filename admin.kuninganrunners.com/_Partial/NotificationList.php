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
    //Menghitung Peserta Event Yang Perlu Peninjauan
    $JumlahTinjauanPesertaEvent=0;
    $QryPesertaEventTinjauan = mysqli_query($Conn, "SELECT id_event_peserta FROM event_peserta WHERE status='Pending'");
    while ($DataPesertaEventTinjauan = mysqli_fetch_array($QryPesertaEventTinjauan)) {
        $id_event_peserta= $DataPesertaEventTinjauan['id_event_peserta'];
        //Cek Apakah Sudah Ada Transaksi
        $kode_transaksi=GetDetailData($Conn,'transaksi','kode_transaksi',$id_event_peserta,'kode_transaksi');
        if(empty($kode_transaksi)){
            $JumlahTinjauanPesertaEvent=$JumlahTinjauanPesertaEvent+1;
        }
    }
    $JumlahNotifikasi=$JumlahEventTidakAdaKategori+$JumlahPesertaBaru+$JumlahPembayaranBaru+$JumlahTinjauanPesertaEvent;
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
        if(!empty($JumlahTinjauanPesertaEvent)){
            echo '<li><hr class="dropdown-divider"></li>';
            $QryPesertaEventTinjauan = mysqli_query($Conn, "SELECT * FROM event_peserta WHERE status='Pending'");
            while ($DataPesertaEventTinjauan = mysqli_fetch_array($QryPesertaEventTinjauan)) {
                $id_event_peserta= $DataPesertaEventTinjauan['id_event_peserta'];
                $NamaPeserta= $DataPesertaEventTinjauan['nama'];
                $datetime= $DataPesertaEventTinjauan['datetime'];
                //Cek Apakah Sudah Ada Transaksi
                $kode_transaksi=GetDetailData($Conn,'transaksi','kode_transaksi',$id_event_peserta,'kode_transaksi');
                if(empty($kode_transaksi)){
                    echo '<li class="notification-item">';
                    echo '  <i class="bi bi-exclamation-circle text-danger"></i>';
                    echo '  <div>';
                    echo '      <h4><a href="index.php?Page=Event&Sub=DetailPeserta&id='.$id_event_peserta.'">'.$NamaPeserta.'</a></h4>';
                    echo '      <p>Peserta membutuhkan peninjauan anda.</p>';
                    echo '  </div>';
                    echo '</li>';
                }
            }
            
        }
    }
?>