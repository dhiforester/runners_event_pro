<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    $now=date('Y-m-d H:i:s');
    //Validasi Akses Masih Berlaku
    if(empty($SessionIdAkses)){
        echo '<code class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang!</code>';
    }else{
        if(empty($_POST['id_akses_fitur'])){
            echo '<code class="text-danger">ID Akses fitur tidak dapat ditangkap oleh sistem</code>';
        }else{
            $id_akses_fitur=$_POST['id_akses_fitur'];
            $kode_fitur=GetDetailData($Conn,'akses_fitur','id_akses_fitur',$id_akses_fitur,'kode');
            //Proses hapus data akses_fitur
            $HapusAksesFitur = mysqli_query($Conn, "DELETE FROM akses_fitur WHERE id_akses_fitur='$id_akses_fitur'") or die(mysqli_error($Conn));
            if ($HapusAksesFitur) {
                //Hapus akses ijin
                $HapusAksesIjin = mysqli_query($Conn, "DELETE FROM akses_ijin WHERE id_akses_fitur='$id_akses_fitur'") or die(mysqli_error($Conn));
                if($HapusAksesIjin){
                    //Hapus akses referensi
                    $HapusAksesReferensi = mysqli_query($Conn, "DELETE FROM akses_referensi WHERE id_akses_fitur='$id_akses_fitur'") or die(mysqli_error($Conn));
                    if($HapusAksesReferensi){
                        $kategori_log="Fitur Akses";
                        $deskripsi_log="Hapus Fitur Akses";
                        $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                        if($InputLog=="Success"){
                            echo '<code class="text-success" id="NotifikasiHapusFiturBerhasil">Success</code>';
                        }else{
                            echo '<code class="text-danger">Terjadi kesalahan pada saat menyimpan Log</code>';
                        }
                    }else{
                        echo '<code class="text-danger">Hapus Data Akses Referensi Gagal</code>';
                    }
                    
                }else{
                    echo '<code class="text-danger">Hapus Data Ijin Akses Gagal</code>';
                }
            }else{
                echo '<code class="text-danger">Hapus Data Gagal</code>';
            }
        }
    }
?>