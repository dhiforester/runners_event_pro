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
                //Buat Variabel
                $pertanyaan=$_POST['pertanyaan'];
                $jawaban=$_POST['jawaban'];
                //Bersihkan Variabel
                $pertanyaan=validateAndSanitizeInput($pertanyaan);
                $jawaban=validateAndSanitizeInput($jawaban);
                //Mencari nilai terbesar
                $query = "SELECT MAX(urutan) AS max_urutan FROM web_faq";
                $result = mysqli_query($Conn, $query);
                if (!$result) {
                    $errors[] = 'Terjadi kesalahan pada saat mencari urutan paling besar!.';
                }else{
                    $row = mysqli_fetch_assoc($result);
                    $maxUrutan = $row['max_urutan'];
                    $urutan=$maxUrutan+1;
                    // Insert data ke database
                    $query = "INSERT INTO web_faq (id_web_faq, urutan, pertanyaan, jawaban) 
                        VALUES (?, ?, ?, ?)";
                    $stmt = $Conn->prepare($query);
                    $stmt->bind_param("ssss", $id_web_faq, $urutan, $pertanyaan, $jawaban);
                    if ($stmt->execute()) {
                        $kategori_log="Konten Utama";
                        $deskripsi_log="Tambah FAQ";
                        $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                        if($InputLog=="Success"){
                            $response['success'] = true;
                        }else{
                            $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                        }
                    }else{
                        $errors[] = 'Terjadi kesalahan pada saat menambahkan FAQ pada database!.';
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