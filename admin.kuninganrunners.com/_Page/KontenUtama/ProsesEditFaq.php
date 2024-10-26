<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    $now=date('Y-m-d H:i:s');
    $date=date('Y-m-d');
    $time=date('H:i:s');
    // Inisialisasi pesan error pertama kali
    $response = ['success' => false, 'message' => ''];
    $errors = []; 
    if(empty($SessionIdAkses)){
        $errors[] = 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang!.';
    }else{
        //Validasi pertanyaan tidak boleh kosong
        if(empty($_POST['pertanyaan'])){
            $errors[] = 'Pertanyaan tidak boleh kosong!.';
        }else{
            //Validasi Jawaban tidak boleh kosong
            if(empty($_POST['jawaban'])){
                $errors[] = 'Jawaban tidak boleh kosong!.';
            }else{
                 //Validasi id_web_faq tidak boleh kosong
                if(empty($_POST['id_web_faq'])){
                    $errors[] = 'Id FAQ tidak boleh kosong!.';
                }else{
                    //Buat Variabel
                    $id_web_faq=$_POST['id_web_faq'];
                    $pertanyaan=$_POST['pertanyaan'];
                    $jawaban=$_POST['jawaban'];
                    //Bersihkan Variabel
                    $id_web_faq=validateAndSanitizeInput($id_web_faq);
                    $pertanyaan=validateAndSanitizeInput($pertanyaan);
                    $jawaban=validateAndSanitizeInput($jawaban);
                    // Insert data ke database
                    $sql = "UPDATE web_faq SET 
                            pertanyaan = ?, 
                            jawaban = ?
                    WHERE id_web_faq = ?";
                    // Menyiapkan statement
                    $stmt = $Conn->prepare($sql);
                    $stmt->bind_param('sss', 
                        $pertanyaan, 
                        $jawaban, 
                        $id_web_faq
                    );
                    // Eksekusi statement dan cek apakah berhasil
                    if ($stmt->execute()) {
                        $kategori_log="Konten Utama";
                        $deskripsi_log="Edit FAQ";
                        $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                        if($InputLog=="Success"){
                            $response['success'] = true;
                        }else{
                            $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                        }
                    }else{
                        $errors[] = 'Terjadi kesalahan pada saat melakukan update FAQ pada database!.';
                    }
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