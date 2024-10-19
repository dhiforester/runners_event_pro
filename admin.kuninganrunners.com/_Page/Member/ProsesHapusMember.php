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
        //Validasi id_member tidak boleh kosong
        if(empty($_POST['id_member'])){
            echo '<small class="text-danger">ID Member tidak boleh kosong</small>';
        }else{
            //Variabel Lainnya
            $id_member=$_POST['id_member'];
            //Bersihkan Variabel
            $id_member=validateAndSanitizeInput($id_member);
            $foto=GetDetailData($Conn,'member','id_member',$id_member,'foto');
            //Proses hapus data
            $Hapus = mysqli_query($Conn, "DELETE FROM member WHERE id_member='$id_member'") or die(mysqli_error($Conn));
            if ($Hapus) {
                $foto_path= '../../assets/img/Member/'.$foto.'';
                if (!empty($foto)) {
                    $HapusFoto=unlink($foto_path);
                }
                $kategori_log="Member";
                $deskripsi_log="Hapus Member";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    echo '<span class="text-success" id="NotifikasiHapusMemberBerhasil">Success</span>';
                }else{
                    echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan log aktivitas</small>';
                }
            }else{
                echo '<span class="text-danger">Hapus Data Gagal</span>';
            }
        }
    }
?>