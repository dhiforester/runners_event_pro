<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    if(empty($SessionIdAkses)){
        echo '<small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
    }else{
        //Validasi id_event tidak boleh kosong
        if(empty($_POST['id_event'])){
            echo '<small class="text-danger">ID Akses tidak boleh kosong</small>';
        }else{
            //Variabel Lainnya
            $id_event=$_POST['id_event'];
            //Bersihkan Variabel
            $id_event=validateAndSanitizeInput($id_event);
            $poster=GetDetailData($Conn,'event','id_event',$id_event,'poster');
            $rute=GetDetailData($Conn,'event','id_event',$id_event,'rute');
            //Proses hapus data
            $HapusEvent = mysqli_query($Conn, "DELETE FROM event WHERE id_event='$id_event'") or die(mysqli_error($Conn));
            if ($HapusEvent) {
                $path_rute= '../../assets/img/Rute/'.$rute.'';
                $path_poster= '../../assets/img/Poster/'.$poster.'';
                if (file_exists($path_rute)) {
                    $HapusRute=unlink($path_rute);
                }
                if (file_exists($path_poster)) {
                    $HapusPoster=unlink($path_poster);
                }
                if (!file_exists($path_poster)&&!file_exists($path_poster)) {
                    $kategori_log="Event";
                    $deskripsi_log="Hapus Event";
                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                    if($InputLog=="Success"){
                        echo '<span class="text-success" id="NotifikasiHapusEventBerhasil">Success</span>';
                    }else{
                        echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan log aktivitas</small>';
                    }
                }else{
                    echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus lampiran</span>';
                }
            }else{
                echo '<span class="text-danger">Hapus Data Gagal</span>';
            }
        }
    }
?>