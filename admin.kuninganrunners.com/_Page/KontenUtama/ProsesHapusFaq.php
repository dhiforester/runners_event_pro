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
        if(empty($_POST['id_web_faq'])){
            $errors[] = 'ID FAQ  tidak boleh kosong!.';
        }else{
            //Variabel Lainnya
            $id_web_faq=$_POST['id_web_faq'];
            //Bersihkan Variabel
            $id_web_faq=validateAndSanitizeInput($id_web_faq);
            //Proses hapus FAQ
            $HapusFaq = mysqli_query($Conn, "DELETE FROM web_faq WHERE id_web_faq='$id_web_faq'") or die(mysqli_error($Conn));
            if ($HapusFaq) {
                //Ketika proses hapus berhasil maka sistem mengurutkan ulang data
                $no = 1;
                $error_count=0;
                $query = mysqli_query($Conn, "SELECT*FROM web_faq ORDER BY urutan ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_web_faq= $data['id_web_faq'];
                    //Melakukan Update
                    $sql = "UPDATE web_faq SET 
                            urutan = ?
                    WHERE id_web_faq = ?";
                    // Menyiapkan statement
                    $stmt = $Conn->prepare($sql);
                    $stmt->bind_param('ss', 
                        $no, 
                        $id_web_faq
                    );
                    // Eksekusi statement dan cek apakah berhasil
                    if ($stmt->execute()) {
                        $error_count=$error_count+0;
                    }else{
                        $error_count=$error_count+1;
                    }
                    $no++;
                }
                if(empty($error_coun)){
                    $kategori_log="Konten Utama";
                    $deskripsi_log="Hapus FAQ";
                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                    if($InputLog=="Success"){
                        $response['success'] = true;
                    }else{
                        $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                    }
                }else{
                    $errors[] = 'Terjadi kesalahan pada saat mengurutkan konten';
                }
                
            }else{
                $errors[] = 'Terjadi kesalahan pada saat menghapus data pada database!.';
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