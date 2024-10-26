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
        //Validasi id_web_faq tidak boleh kosong
        if(empty($_POST['id_web_faq'])){
            $errors[] = 'ID Web FAQ tidak boleh kosong!.';
        }else{
            //Validasi NaikTurun tidak boleh kosong
            if(empty($_POST['NaikTurun'])){
                $errors[] = 'Status Naik/Turun tidak boleh kosong!.';
            }else{
                //Buat Variabel
                $id_web_faq=$_POST['id_web_faq'];
                $NaikTurun=$_POST['NaikTurun'];
                //Bersihkan Variabel
                $id_web_faq=validateAndSanitizeInput($id_web_faq);
                $NaikTurun=validateAndSanitizeInput($NaikTurun);
                $urutan=GetDetailData($Conn,'web_faq','id_web_faq',$id_web_faq,'urutan');
                if($NaikTurun=="Naik"){
                    $urutan_baru=$urutan-1;
                    $urutan_lawan=$urutan;
                    $id_web_faq_lawan=GetDetailData($Conn,'web_faq','urutan',$urutan_baru,'id_web_faq');
                }else{
                    $urutan_baru=$urutan+1;
                    $urutan_lawan=$urutan;
                    $id_web_faq_lawan=GetDetailData($Conn,'web_faq','urutan',$urutan_baru,'id_web_faq');
                }
                
                //Edit urutan objek
                $sql = "UPDATE web_faq SET 
                        urutan = ?
                WHERE id_web_faq = ?";
                // Menyiapkan statement
                $stmt = $Conn->prepare($sql);
                $stmt->bind_param('ss', 
                    $urutan_baru, 
                    $id_web_faq
                );
                // Eksekusi statement dan cek apakah berhasil
                if ($stmt->execute()) {
                    //Edit urutan lawan
                    $sql_lawan = "UPDATE web_faq SET 
                            urutan = ?
                    WHERE id_web_faq = ?";
                    // Menyiapkan statement
                    $stmt_lawan = $Conn->prepare($sql_lawan);
                    $stmt_lawan->bind_param('ss', 
                        $urutan_lawan, 
                        $id_web_faq_lawan
                    );
                    // Eksekusi statement dan cek apakah berhasil
                    if ($stmt_lawan->execute()) {
                        $kategori_log="Konten Utama";
                        $deskripsi_log="Edit Urutan FAQ";
                        $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                        if($InputLog=="Success"){
                            $response['success'] = true;
                        }else{
                            $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                        }
                    }else{
                        $errors[] = 'Terjadi kesalahan pada saat melakukan update Urutan Lawan.';
                    }
                }else{
                    $errors[] = 'Terjadi kesalahan pada saat melakukan update Urutan Objek.';
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