<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    $now=date('Y-m-d H:i:s');
    // Inisialisasi pesan error pertama kali
    $response = ['success' => false, 'message' => ''];
    $errors = []; 
    if(empty($SessionIdAkses)){
        $errors[] = 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang!.';
    }else{
        //Validasi id_event_peserta tidak boleh kosong
        if(empty($_POST['id_event_peserta'])){
            $errors[] = 'ID Peserta Event tidak boleh kosong!.';
        }else{
            //Variabel Lainnya
            $id_event_peserta=$_POST['id_event_peserta'];
            //Bersihkan Variabel
            $id_event_peserta=validateAndSanitizeInput($id_event_peserta);
            //Proses hapus data peserta Event
            $HapusPeserta = mysqli_query($Conn, "DELETE FROM event_peserta WHERE id_event_peserta='$id_event_peserta'") or die(mysqli_error($Conn));
            if ($HapusPeserta) {
                $kategori_log="Event";
                $deskripsi_log="Hapus Peserta Event";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    $response['success'] = true;
                }else{
                    $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                }
            }else{
                $errors[] = 'Terjadi kesalahan pada saat menghapus data peserta event pada database!.';
            }
        }
    }
    if (!empty($errors)) {
        $response['message'] = implode('<br>', $errors);
        echo json_encode($response);
        exit;
    }else{
        echo json_encode($response);
    }
?>