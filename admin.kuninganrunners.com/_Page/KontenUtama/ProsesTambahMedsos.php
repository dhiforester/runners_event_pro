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
        //Validasi nama_medsos tidak boleh kosong
        if(empty($_POST['nama_medsos'])){
            $errors[] = 'Nama Medsos tidak boleh kosong!.';
        }else{
            //Validasi url_medsos tidak boleh kosong
            if(empty($_POST['url_medsos'])){
                $errors[] = 'Url Medsos tidak boleh kosong!.';
            }else{
                if (empty($_FILES['logo']['name'])) {
                    $errors[] = 'Logo Medsos tidak boleh kosong!.';
                }else{
                    //Buat Variabel
                    $nama_medsos=$_POST['nama_medsos'];
                    $url_medsos=$_POST['url_medsos'];
                    //Bersihkan Variabel
                    $nama_medsos=validateAndSanitizeInput($nama_medsos);
                    $url_medsos=validateAndSanitizeInput($url_medsos);
                    //Valiasi File
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    $fileExtension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
                    if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                        $errors[] = 'Tipe file yang anda upload tidak valid!.';
                    }else{
                        // Tentukan jenis file yang diperbolehkan
                        $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                        $fileType = mime_content_type($_FILES['logo']['tmp_name']);
                        if (!in_array($fileType, $allowedTypes)) {
                            $errors[] = 'Format file yang anda upload tidak valid!.';
                        }else{
                            if($fileType=="image/jpg"){
                                $ext="jpg";
                            }else{
                                if($fileType=="image/jpeg"){
                                    $ext="jpeg";
                                }else{
                                    if($fileType=="image/png"){
                                        $ext="png";
                                    }else{
                                        if($fileType=="image/gif"){
                                            $ext="gif";
                                        }else{
                                            $ext="";
                                        }
                                    }
                                }
                            }
                            $logo = bin2hex(random_bytes(16)) . '.' . $ext;
                            $logo_path = '../../assets/img/Medsos/' . $logo;
                            if (!move_uploaded_file($_FILES['logo']['tmp_name'], $logo_path)) {
                                $errors[] = 'Gagal mengunggah foto, silakan coba lagi.';
                            }else{
                                // Insert data ke database
                                $query = "INSERT INTO web_medsos (nama_medsos, url_medsos, logo) 
                                    VALUES (?, ?, ?)";
                                $stmt = $Conn->prepare($query);
                                $stmt->bind_param("sss", $nama_medsos, $url_medsos, $logo);
                                if ($stmt->execute()) {
                                    $kategori_log="Konten Utama";
                                    $deskripsi_log="Tambah Medsos";
                                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                    if($InputLog=="Success"){
                                        $response['success'] = true;
                                    }else{
                                        $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                                    }
                                }else{
                                    $errors[] = 'Terjadi kesalahan pada saat menambahkan medsos pada database!.';
                                }
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