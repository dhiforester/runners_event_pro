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
        //Validasi judul tidak boleh kosong
        if(empty($_POST['judul'])){
            $errors[] = 'Judul Vidio tidak boleh kosong!.';
        }else{
            //Validasi deskripsi tidak boleh kosong
            if(empty($_POST['deskripsi'])){
                $errors[] = 'Setidaknya anda harus menambahkan penjelasan mengenai vidio tersebut.';
            }else{
                //Validasi sumber_vidio tidak boleh kosong
                if(empty($_POST['sumber_vidio'])){
                    $errors[] = 'Sumber Vidio Tidak Boleh Kosong!.';
                }else{
                    //Buat Variabel
                    $judul=$_POST['judul'];
                    $deskripsi=$_POST['deskripsi'];
                    $sumber_vidio=$_POST['sumber_vidio'];
                    //Bersihkan Variabel
                    $judul=validateAndSanitizeInput($judul);
                    $deskripsi=validateAndSanitizeInput($deskripsi);
                    $sumber_vidio=validateAndSanitizeInput($sumber_vidio);
                    if(strlen($judul)>100){
                        $errors[] = 'Judul vidio tidak boleh lebih dari 100 karakter!.';
                    }else{
                        if(strlen($deskripsi)>250){
                            $errors[] = 'Deskripsi vidio tidak boleh lebih dari 250 karakter!.';
                        }else{
                            //Validasi Berdasarkan Sumber Vidio
                            if($sumber_vidio=="Local"){
                                // Validasi File Video
                                $allowedExtensions = ['mp4', 'webm', 'ogg', 'avi', 'mov', 'mpeg', '3gp', 'flv', 'wmv'];
                                $allowedMimeTypes = [
                                    'video/mp4',
                                    'video/webm',
                                    'video/ogg',
                                    'video/x-msvideo',
                                    'video/quicktime',
                                    'video/mpeg',
                                    'video/3gpp',
                                    'video/x-flv',
                                    'video/x-ms-wmv'
                                ];

                                if (isset($_FILES['vidio']) && $_FILES['vidio']['error'] === UPLOAD_ERR_OK) {
                                    $fileExtension = pathinfo($_FILES['vidio']['name'], PATHINFO_EXTENSION);
                                    $fileType = mime_content_type($_FILES['vidio']['tmp_name']);

                                    if (!in_array(strtolower($fileExtension), $allowedExtensions) || !in_array($fileType, $allowedMimeTypes)) {
                                        $ValidasiVidio = 'Tipe file yang Anda upload tidak valid!';
                                    } else {
                                        $file_video = bin2hex(random_bytes(16)) . '.' . strtolower($fileExtension);
                                        $file_video_path = '../../assets/img/Vidio/' . $file_video;

                                        if (!move_uploaded_file($_FILES['vidio']['tmp_name'], $file_video_path)) {
                                            $ValidasiVidio = 'Gagal mengunggah file, silakan coba lagi.';
                                        } else {
                                            $ValidasiVidio = 'Valid';
                                            $vidio=$file_video;
                                        }
                                    }
                                } else {
                                    $error = $_FILES['vidio']['error'];
                                    switch ($error) {
                                        case UPLOAD_ERR_INI_SIZE:
                                        case UPLOAD_ERR_FORM_SIZE:
                                            $ValidasiVidio = 'Ukuran file terlalu besar!';
                                            break;
                                        case UPLOAD_ERR_PARTIAL:
                                            $ValidasiVidio = 'File hanya terunggah sebagian!';
                                            break;
                                        case UPLOAD_ERR_NO_FILE:
                                            $ValidasiVidio = 'Tidak ada file yang diunggah!';
                                            break;
                                        default:
                                            $ValidasiVidio = 'Terjadi kesalahan, silakan coba lagi.';
                                            break;
                                    }
                                }
                            }else{
                                if(empty($_POST['vidio'])){
                                    $ValidasiVidio = 'Form isi konten vidio tidak boleh kosong!';
                                }else{
                                    $ValidasiVidio = 'Valid';
                                    $vidio=$_POST['vidio'];
                                }
                            }
                            if($ValidasiVidio!=="Valid"){
                                $errors[] = $ValidasiVidio;
                            }else{
                                //Validasi Gambar Cuplikan
                                if(!empty($_FILES['thumbnail']['name'])){
                                    // Validasi File Gambar
                                    $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif'];
                                    $allowedMimeTypes = [
                                        'image/jpeg',
                                        'image/jpg',
                                        'image/png',
                                        'image/gif'
                                    ];

                                    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
                                        $fileExtension = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
                                        $fileType = mime_content_type($_FILES['thumbnail']['tmp_name']);

                                        if (!in_array(strtolower($fileExtension), $allowedExtensions) || !in_array($fileType, $allowedMimeTypes)) {
                                            $ValidasiCuplikan = 'Tipe file yang Anda upload tidak valid!';
                                        } else {
                                            $FileCuplikan = bin2hex(random_bytes(16)) . '.' . strtolower($fileExtension);
                                            $FileCuplikanPath = '../../assets/img/Vidio/' . $FileCuplikan;

                                            if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $FileCuplikanPath)) {
                                                $ValidasiCuplikan = 'Gagal mengunggah file, silakan coba lagi.';
                                            } else {
                                                $ValidasiCuplikan = 'Valid';
                                            }
                                        }
                                    } else {
                                        $error = $_FILES['thumbnail']['error'];
                                        switch ($error) {
                                            case UPLOAD_ERR_INI_SIZE:
                                            case UPLOAD_ERR_FORM_SIZE:
                                                $ValidasiCuplikan = 'Ukuran file terlalu besar!';
                                                break;
                                            case UPLOAD_ERR_PARTIAL:
                                                $ValidasiCuplikan = 'File hanya terunggah sebagian!';
                                                break;
                                            case UPLOAD_ERR_NO_FILE:
                                                $ValidasiCuplikan = 'Tidak ada file yang diunggah!';
                                                break;
                                            default:
                                                $ValidasiCuplikan = 'Terjadi kesalahan, silakan coba lagi.';
                                                break;
                                        }
                                    }
                                }else{
                                    $FileCuplikan="";
                                    $ValidasiCuplikan="Valid";
                                }
                                //Buat ID Vidio
                                $id_web_vidio=generateUuidV1();
                                // Insert data ke database
                                $query = "INSERT INTO web_vidio (id_web_vidio, sumber_vidio, title_vidio, deskripsi, vidio, datetime,thumbnail) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)";
                                $stmt = $Conn->prepare($query);
                                $stmt->bind_param("sssssss", $id_web_vidio, $sumber_vidio, $judul, $deskripsi, $vidio, $now, $FileCuplikan);
                                if ($stmt->execute()) {
                                    $kategori_log="Vidio";
                                    $deskripsi_log="Tambah Vidio";
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
    }
    if (!empty($errors)) {
        $response['message'] = implode('<br>', $errors);
        echo json_encode($response);
        exit;
    }else{
        echo json_encode($response);
    }
?>