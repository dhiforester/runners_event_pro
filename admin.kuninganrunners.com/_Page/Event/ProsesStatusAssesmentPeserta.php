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
        //Validasi id_event_assesment tidak boleh kosong
        if(empty($_POST['id_event_assesment'])){
            $errors[] = 'ID Assesment tidak boleh kosong!.';
        }else{
            //Validasi status_assesment tidak boleh kosong
            if(empty($_POST['status_assesment'])){
                $errors[] = 'Status Assesment tidak boleh kosong!.';
            }else{
                //Buat Variabel
                $id_event_assesment=$_POST['id_event_assesment'];
                $status_assesment=$_POST['status_assesment'];
                if(empty($_POST['komentar_assesment'])){
                    $komentar_assesment="";
                }else{
                    $komentar_assesment=$_POST['komentar_assesment'];
                }
                //Bersihkan Variabel
                $id_event_assesment=validateAndSanitizeInput($id_event_assesment);
                $status_assesment=validateAndSanitizeInput($status_assesment);
                $komentar_assesment=validateAndSanitizeInput($komentar_assesment);
                //Buatkan Json
                $status_assesment_array=[
                    "status_assesment" => $status_assesment,
                    "komentar" => $komentar_assesment,
                ];
                $status_assesment = json_encode($status_assesment_array);
                //Update Data
                $sql = "UPDATE event_assesment SET 
                    status_assesment = ?
                WHERE id_event_assesment = ?";
                // Menyiapkan statement
                $stmt = $Conn->prepare($sql);
                $stmt->bind_param('ss', $status_assesment, $id_event_assesment);
                // Eksekusi statement dan cek apakah berhasil
                if ($stmt->execute()) {
                    $ValidasiProses="Berhasil";
                }else{
                    $ValidasiProses= 'Terjadi kesalahan pada saat update data pada database!.';
                }
                if($ValidasiProses=="Berhasil"){
                    $kategori_log="Event";
                    $deskripsi_log="Update Status Assesment Peserta";
                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                    if($InputLog=="Success"){
                        $response['success'] = true;
                    }else{
                        $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                    }
                }else{
                    $errors[] = $ValidasiProses;
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