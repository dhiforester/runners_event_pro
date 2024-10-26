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
        //Validasi id_event_kategori tidak boleh kosong
        if(empty($_POST['id_event_kategori'])){
            $errors[] = 'ID Kategori Event tidak boleh kosong!.';
        }else{
            //Variabel Lainnya
            $id_event_kategori=$_POST['id_event_kategori'];
            //Bersihkan Variabel
            $id_event_kategori=validateAndSanitizeInput($id_event_kategori);
            $JumlahPeserta = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_peserta FROM event_peserta WHERE id_event_kategori='$id_event_kategori' AND status='Lunas'"));
            if(!empty($JumlahPeserta)){
                $errors[] = 'Kategori event ini sudah memiliki peserta!.';
            }else{
                //Proses hapus data Kategori Event
                $HapusKategoriEvent = mysqli_query($Conn, "DELETE FROM event_kategori WHERE id_event_kategori='$id_event_kategori'") or die(mysqli_error($Conn));
                if ($HapusKategoriEvent) {
                    $kategori_log="Event";
                    $deskripsi_log="Hapus Kategori Event";
                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                    if($InputLog=="Success"){
                        $response['success'] = true;
                    }else{
                        $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                    }
                }else{
                    $errors[] = 'Terjadi kesalahan pada saat menghapus data kategori event pada database!.';
                }
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