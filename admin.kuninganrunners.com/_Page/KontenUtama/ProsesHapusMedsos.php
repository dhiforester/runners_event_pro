<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    // Inisialisasi pesan error
    $response = ['success' => false, 'message' => ''];
    $errors = []; 
    if(empty($SessionIdAkses)){
        $errors[] = 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang';
    }else{
        //Validasi id_web_medsos tidak boleh kosong
        if(empty($_POST['id_web_medsos'])){
            $errors[] = 'ID Medsos tidak boleh kosong';
        }else{
            //Variabel Lainnya
            $id_web_medsos=$_POST['id_web_medsos'];
            //Bersihkan Variabel
            $id_web_medsos=validateAndSanitizeInput($id_web_medsos);
            $logo=GetDetailData($Conn,'web_medsos','id_web_medsos',$id_web_medsos,'logo');
            if(!empty($logo)){
                $logo_path = '../../assets/img/Medsos/' . $logo;
                if (file_exists($logo_path)) {
                    //Menghapus Logo Medsos
                    unlink($logo_path);
                }
            }
            //Proses hapus data
            $HapusMedsos = mysqli_query($Conn, "DELETE FROM web_medsos WHERE id_web_medsos='$id_web_medsos'") or die(mysqli_error($Conn));
            if ($HapusMedsos) {
                //Menyimpan Log
                $kategori_log="Konten Utama";
                $deskripsi_log="Hapus Medsos";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    $response['success'] = true;
                }else{
                    $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                }
            }else{
                $errors[] = 'Terjadi Kesalahan Pada Saat Menghapus Data Dari Database';
            }
        }
    }
    // Jika ada error, kirim respons dengan daftar pesan error
    if (!empty($errors)) {
        $response['message'] = implode('<br>', $errors);
        echo json_encode($response);
        exit;
    }else{
        echo json_encode($response);
    }
?>