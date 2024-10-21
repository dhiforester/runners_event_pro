<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    $now=date('Y-m-d H:i:s');
    if(empty($SessionIdAkses)){
        echo '<code class="text-danger">Sesi Akses Sudah Berakhir. Silahkan Login Ulang Terlebih Dulu</code>';
    }else{
        //Menghitung Data Yang Ditangkap Dati Tabel
        if(!empty($_POST['id_log'])){
            $CheckLogItem=$_POST['id_log'];
            $JumlahDipilih=count($CheckLogItem);
            $JumlahBerhasil=0;
            foreach($CheckLogItem as $List){
                $HapusLog = mysqli_query($Conn, "DELETE FROM log WHERE id_log='$List'") or die(mysqli_error($Conn));
                if($HapusLog){
                    $JumlahBerhasil=$JumlahBerhasil+1;
                }else{
                    $JumlahBerhasil=$JumlahBerhasil+0;
                }
            }
            if($JumlahDipilih==$JumlahBerhasil){
                //Apabila Berhasil, Simpan Log
                $kategori_log="Aktivitas";
                $deskripsi_log="Hapus Log Aktivitas";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    echo '<code class="text-success" id="NotifikasiHapusItemLogBerhasil">Success</code>';
                }else{
                    echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan Log</small>';
                }
            }else{
                echo '<small class="credit text-danger">';
                echo '  Terjadi kesalahan pada saat menghapus data!';
                echo '</small>';
            }
        }else{
            echo '<small>Tidak ada data yang dipilih untuk dihapus</small>';
        }
    }
?>