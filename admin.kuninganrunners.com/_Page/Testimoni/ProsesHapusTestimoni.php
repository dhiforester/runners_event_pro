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
        //Validasi id_web_testimoni tidak boleh kosong
        if(empty($_POST['id_web_testimoni'])){
            $errors[] = 'ID Testimoni tidak boleh kosong!.';
        }else{
            //Variabel Lainnya
            $id_web_testimoni=$_POST['id_web_testimoni'];
            //Bersihkan Variabel
            $id_web_testimoni=validateAndSanitizeInput($id_web_testimoni);
            //Proses hapus data Testimoni
            $HapusTestimoni = mysqli_query($Conn, "DELETE FROM web_testimoni WHERE id_web_testimoni='$id_web_testimoni'") or die(mysqli_error($Conn));
            if ($HapusTestimoni) {
                $kategori_log="Testimoni";
                $deskripsi_log="Hapus Testimoni";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    $response['success'] = true;
                }else{
                    $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                }
            }else{
                $errors[] = 'Terjadi kesalahan pada saat menghapus data Testimoni pada database!.';
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