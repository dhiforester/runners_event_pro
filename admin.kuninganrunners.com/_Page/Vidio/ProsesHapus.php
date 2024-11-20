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
        //Validasi id_web_vidio tidak boleh kosong
        if(empty($_POST['id_web_vidio'])){
            $errors[] = 'ID Konten Vidio tidak boleh kosong';
        }else{
            //Variabel Lainnya
            $id_web_vidio=$_POST['id_web_vidio'];
            //Bersihkan Variabel
            $id_web_vidio=validateAndSanitizeInput($id_web_vidio);
            $sumber_vidio=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'sumber_vidio');
            $thumbnail=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'thumbnail');
            $vidio=GetDetailData($Conn,'web_vidio','id_web_vidio',$id_web_vidio,'vidio');
            //Path Cuplikan
            if(!empty($thumbnail)){
                $thumbnail_path = '../../assets/img/Vidio/' . $thumbnail;
                if (file_exists($thumbnail_path)) {
                    unlink($thumbnail_path);
                }
            }
            
            //Apabila Sumber Lokal
            if($sumber_vidio=="Local"){
                $vidio_path = '../../assets/img/Vidio/' . $vidio;
                if (file_exists($vidio_path)) {
                    unlink($vidio_path);
                }
            }
            //Proses hapus data
            $HapusVidio = mysqli_query($Conn, "DELETE FROM web_vidio WHERE id_web_vidio='$id_web_vidio'") or die(mysqli_error($Conn));
            if ($HapusVidio) {
                //Menyimpan Log
                $kategori_log="Vidio";
                $deskripsi_log="Hapus Vidio";
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