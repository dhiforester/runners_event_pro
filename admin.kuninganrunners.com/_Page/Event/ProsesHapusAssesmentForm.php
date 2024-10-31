<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    $response = ['success' => false, 'message' => ''];
    $errors = []; 
    if(empty($SessionIdAkses)){
        $errors[]='Sesi Akses Sudah Berakhir, Silahkan Login Ulang';
    }else{
        //Validasi id_event_assesment_form tidak boleh kosong
        if(empty($_POST['id_event_assesment_form'])){
            $errors[]='ID Assesment Form tidak boleh kosong';
        }else{
            //Variabel Lainnya
            $id_event_assesment_form=$_POST['id_event_assesment_form'];
            //Bersihkan Variabel
            $id_event_assesment_form=validateAndSanitizeInput($id_event_assesment_form);
            //Proses hapus data
            $HapusAssesmentForm = mysqli_query($Conn, "DELETE FROM event_assesment_form WHERE id_event_assesment_form='$id_event_assesment_form'") or die(mysqli_error($Conn));
            if ($HapusAssesmentForm) {
                $kategori_log="Event";
                $deskripsi_log="Hapus Assesment Form";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    $response['success'] = true;
                }else{
                    $errors[]='Terjadi kesalahan pada saat menyimpan log aktivitas';
                }
            }else{
                $errors[]='Hapus Data Gagal';
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