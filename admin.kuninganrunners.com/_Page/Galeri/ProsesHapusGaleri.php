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
        //Validasi id_web_galeri tidak boleh kosong
        if(empty($_POST['id_web_galeri'])){
            $errors[] = 'ID Galeri tidak boleh kosong';
        }else{
            //Variabel Lainnya
            $id_web_galeri=$_POST['id_web_galeri'];
            //Bersihkan Variabel
            $id_web_galeri=validateAndSanitizeInput($id_web_galeri);
            $file_galeri=GetDetailData($Conn,'web_galeri','id_web_galeri',$id_web_galeri,'file_galeri');
            if(!empty($file_galeri)){
                $file_galeri_path = '../../assets/img/Galeri/' . $file_galeri;
                if (file_exists($file_galeri_path)) {
                    //Menghapus Logo Medsos
                    unlink($file_galeri_path);
                }
            }
            //Membuka nama album lama
            $album_lama=GetDetailData($Conn,'web_galeri','id_web_galeri',$id_web_galeri,'album');
            //Proses hapus data
            $HapusGaleri = mysqli_query($Conn, "DELETE FROM web_galeri WHERE id_web_galeri='$id_web_galeri'") or die(mysqli_error($Conn));
            if ($HapusGaleri) {
                //Cek Apakah Nama Album Lama Masih Ada Yang tersisa
                $jumlah_data_album_lama = mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_galeri FROM web_galeri WHERE album='$album_lama'"));
                //Jika Tidak Ada Hapus Albumnya
                if(empty($jumlah_data_album_lama)){
                    $HapusAlbum = mysqli_query($Conn, "DELETE FROM web_galeri_album WHERE album='$album_lama'") or die(mysqli_error($Conn));
                }
                //Menyimpan Log
                $kategori_log="Galeri";
                $deskripsi_log="Hapus Galeri";
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