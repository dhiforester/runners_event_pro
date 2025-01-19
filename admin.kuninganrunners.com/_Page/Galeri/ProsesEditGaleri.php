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
        //Validasi id_web_galeri tidak boleh kosong
        if(empty($_POST['id_web_galeri'])){
            $errors[] = 'ID Galeri tidak boleh kosong!.';
        }else{
            //Validasi album tidak boleh kosong
            if(empty($_POST['album'])){
                $errors[] = 'Nama Album tidak boleh kosong!.';
            }else{
                //Validasi nama_galeri tidak boleh kosong
                if(empty($_POST['nama_galeri'])){
                    $errors[] = 'Nama/Judul Foto tidak boleh kosong!.';
                }else{
                    //Buat Variabel
                    $id_web_galeri=$_POST['id_web_galeri'];
                    $album=$_POST['album'];
                    $nama_galeri=$_POST['nama_galeri'];
                    if (!preg_match('/^[a-zA-Z0-9\s-]+$/', $album)) {
                        $errors[] = 'Nama album hanya boleh huruf dan angka serta spasi.';
                    }else{
                        //Bersihkan Variabel
                        $id_web_galeri=validateAndSanitizeInput($id_web_galeri);
                        $album=validateAndSanitizeInput($album);
                        $nama_galeri=validateAndSanitizeInput($nama_galeri);
                        if(strlen($album)>50){
                            $errors[] = 'Nama album tidak boleh lebih dari 50 karakter!.';
                        }else{
                            if(strlen($nama_galeri)>100){
                                $errors[] = 'Nama/Judul Foto tidak boleh lebih dari 100 karakter!.';
                            }else{
                                if (empty($_FILES['file_galeri']['name'])) {
                                    $ValidasiFoto='Valid';
                                    //Buka File Lama
                                    $file_galeri=GetDetailData($Conn,'web_galeri','id_web_galeri',$id_web_galeri,'file_galeri');
                                }else{
                                    //Validasi File
                                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                                    $fileExtension = pathinfo($_FILES['file_galeri']['name'], PATHINFO_EXTENSION);
                                    if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                                        $ValidasiFoto= 'Tipe file yang anda upload tidak valid!.';
                                    }else{
                                        // Tentukan jenis file yang diperbolehkan
                                        $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                                        $fileType = mime_content_type($_FILES['file_galeri']['tmp_name']);
                                        if (!in_array($fileType, $allowedTypes)) {
                                            $ValidasiFoto= 'Format file yang anda upload tidak valid!.';
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
                                            $file_galeri = bin2hex(random_bytes(16)) . '.' . $ext;
                                            $file_galeri_path = '../../assets/img/Galeri/' . $file_galeri;
                                            if (!move_uploaded_file($_FILES['file_galeri']['tmp_name'], $file_galeri_path)) {
                                                $ValidasiFoto= 'Gagal mengunggah foto, silakan coba lagi.';
                                            }else{
                                                //Hapus File Lama
                                                $file_galeri_lama=GetDetailData($Conn,'web_galeri','id_web_galeri',$id_web_galeri,'file_galeri');
                                                $FileLamaPath='../../assets/img/Galeri/' . $file_galeri_lama;
                                                if (unlink($FileLamaPath)) {
                                                    $ValidasiFoto="Valid";
                                                }else{
                                                    $ValidasiFoto= 'Terjadi kesalahan pada saat menghapus file lama';
                                                }
                                            }
                                        }
                                    }
                                }
                                if($ValidasiFoto!=="Valid"){
                                    $errors[] = ''.$ValidasiLogo.'';
                                }else{
                                    //Membuka nama album lama
                                    $album_lama=GetDetailData($Conn,'web_galeri','id_web_galeri',$id_web_galeri,'album');
                                    //Apakah Nama Album Sudah Ada
                                    $id_web_galeri_album=GetDetailData($Conn,'web_galeri_album','album',$album,'id_web_galeri_album');
                                    if(empty($id_web_galeri_album)){
                                        $id_web_galeri_album_uid=generateUuidV1();
                                        //Insert Ke web_galeri_album
                                        $query = "INSERT INTO web_galeri_album (id_web_galeri_album, album) 
                                            VALUES (?, ?)";
                                        $stmt = $Conn->prepare($query);
                                        $stmt->bind_param("ss", $id_web_galeri_album_uid, $album);
                                        if ($stmt->execute()) {
                                            $id_web_galeri_album=$id_web_galeri_album_uid;
                                        }else{
                                            $id_web_galeri_album=0;
                                        }
                                    }
                                    if(empty($id_web_galeri_album)){
                                        $errors[] = 'Terjadi kesalahan pada saat membuat data album';
                                    }else{
                                        //Update Database
                                        $sql = "UPDATE web_galeri SET 
                                            id_web_galeri_album = ?, 
                                            album = ?, 
                                            nama_galeri = ?,
                                            datetime = ?,
                                            file_galeri = ?
                                        WHERE id_web_galeri = ?";
                                        // Menyiapkan statement
                                        $stmt = $Conn->prepare($sql);
                                        $stmt->bind_param('ssssss', 
                                            $id_web_galeri_album, 
                                            $album, 
                                            $nama_galeri, 
                                            $now, 
                                            $file_galeri,
                                            $id_web_galeri
                                        );
                                        // Eksekusi statement dan cek apakah berhasil
                                        if ($stmt->execute()) {
                                            //Cek Apakah Nama Album Lama Masih Ada Yang tersisa
                                            $jumlah_data_album_lama = mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_galeri FROM web_galeri WHERE album='$album_lama'"));
                                            //Jika Tidak Ada Hapus Albumnya
                                            if(empty($jumlah_data_album_lama)){
                                                $HapusAlbum = mysqli_query($Conn, "DELETE FROM web_galeri_album WHERE album='$album_lama'") or die(mysqli_error($Conn));
                                            }
                                            $kategori_log="Galeri";
                                            $deskripsi_log="Edit Galeri";
                                            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                            if($InputLog=="Success"){
                                                $response['success'] = true;
                                            }else{
                                                $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                                            }
                                        }else{
                                            $errors[] = 'Terjadi kesalahan pada saat menyimpan data pada database!.';
                                        }
                                    }
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