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
        //Validasi id_member tidak boleh kosong
        if(empty($_POST['id_member'])){
            $errors[] = 'ID member tidak boleh kosong!.';
        }else{
            //Validasi penilaian tidak boleh kosong
            if(empty($_POST['penilaian'])){
                $errors[] = 'Penilaian tidak boleh kosong!.';
            }else{
                //Validasi testimoni tidak boleh kosong
                if(empty($_POST['testimoni'])){
                    $errors[] = 'Testimoni tidak boleh kosong!.';
                }else{
                    //Validasi status tidak boleh kosong
                    if(empty($_POST['status'])){
                        $errors[] = 'Status tidak boleh kosong!.';
                    }else{
                        //Buat Variabel
                        $id_member=$_POST['id_member'];
                        $penilaian=$_POST['penilaian'];
                        $testimoni=$_POST['testimoni'];
                        $status=$_POST['status'];
                        //Bersihkan Variabel
                        $id_member=validateAndSanitizeInput($id_member);
                        $penilaian=validateAndSanitizeInput($penilaian);
                        $testimoni=validateAndSanitizeInput($testimoni);
                        $status=validateAndSanitizeInput($status);
                        $sumber='Manual';
                        if(strlen($testimoni)>500){
                            $errors[] = 'Testimoni tidak boleh lebih dari 500 karakter!.';
                        }else{
                            // Insert data ke database
                            $query = "INSERT INTO web_testimoni (id_member, penilaian, testimoni, sumber, datetime, status) 
                                VALUES (?, ?, ?, ?, ?, ?)";
                            $stmt = $Conn->prepare($query);
                            $stmt->bind_param("ssssss", $id_member, $penilaian, $testimoni, $sumber, $now, $status);
                            if ($stmt->execute()) {
                                $kategori_log="Testimoni";
                                $deskripsi_log="Tambah Testimoni";
                                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                if($InputLog=="Success"){
                                    $response['success'] = true;
                                }else{
                                    $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                                }
                            }else{
                                $errors[] = 'Terjadi kesalahan pada saat menambahkan data pada database!.';
                            }
                        }
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