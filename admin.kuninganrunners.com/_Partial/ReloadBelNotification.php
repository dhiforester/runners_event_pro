<?php
    //Karena Ini Di running Dengan JS maka Panggil Ulang Koneksi
    include "../_Config/Connection.php";
    include "../_Config/GlobalFunction.php";
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
    $JumlahPembelianMenunggu=mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi WHERE kategori='Pembelian' AND status='Menunggu'"));
    $JumlahNotifikasi=$JumlahEventTidakAdaKategori+$JumlahPesertaBaru+$JumlahPembayaranBaru+$JumlahTinjauanPesertaEvent+$JumlahPembelianMenunggu;
    //Apabila ada notifgikasi
    if(!empty($JumlahNotifikasi)){
        echo '<i class="bi bi-bell"></i>';
        echo '<span class="badge bg-danger rounded-pill badge-number">'.$JumlahNotifikasi.'</span>';
    }else{
        //Apabila Tidak Ada
        echo '<i class="bi bi-bell"></i>';
    }
?>