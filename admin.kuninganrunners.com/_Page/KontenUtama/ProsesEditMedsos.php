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
        //Validasi id_web_medsos tidak boleh kosong
        if(empty($_POST['id_web_medsos'])){
            $errors[] = 'ID Medsos tidak boleh kosong!.';
        }else{
            //Validasi nama_medsos tidak boleh kosong
            if(empty($_POST['nama_medsos'])){
                $errors[] = 'Nama Medsos tidak boleh kosong!.';
            }else{
                //Validasi url_medsos tidak boleh kosong
                if(empty($_POST['url_medsos'])){
                    $errors[] = 'Url Medsos tidak boleh kosong!.';
                }else{
                    //Buat Variabel
                    $id_web_medsos=$_POST['id_web_medsos'];
                    $nama_medsos=$_POST['nama_medsos'];
                    $url_medsos=$_POST['url_medsos'];
                    //Bersihkan Variabel
                    $id_web_medsos=validateAndSanitizeInput($id_web_medsos);
                    $nama_medsos=validateAndSanitizeInput($nama_medsos);
                    $url_medsos=validateAndSanitizeInput($url_medsos);
                    if(strlen($nama_medsos)>100){
                        $errors[] = 'Nama medsos tidak boleh lebih dari 100 karakter!.';
                    }else{
                        if(strlen($url_medsos)>250){
                            $errors[] = 'URL medsos tidak boleh lebih dari 100 karakter!.';
                        }else{
                            //Apabila Tidak Upload Logo Baru
                            if (empty($_FILES['logo']['name'])) {
                                $ValidasiLogo="Valid";
                                $logo=GetDetailData($Conn,'web_medsos','id_web_medsos',$id_web_medsos,'logo');
                            }else{
                                //Apabila Upload Logo Baru Maka Valiasi File
                                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                                $fileExtension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
                                if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                                    $ValidasiLogo="Tipe file yang anda upload tidak valid!.";
                                }else{
                                    // Tentukan jenis file yang diperbolehkan
                                    $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                                    $fileType = mime_content_type($_FILES['logo']['tmp_name']);
                                    if (!in_array($fileType, $allowedTypes)) {
                                        $ValidasiLogo= 'Format file yang anda upload tidak valid!.';
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
                                        //Nama File Logo Baru
                                        $logo = bin2hex(random_bytes(16)) . '.' . $ext;
                                        $logo_path = '../../assets/img/Medsos/' . $logo;
                                        if (!move_uploaded_file($_FILES['logo']['tmp_name'], $logo_path)) {
                                            $ValidasiLogo= 'Gagal mengunggah foto, silakan coba lagi.';
                                        }else{
                                            //Membuka File Logo Lama
                                            $logo_lama=GetDetailData($Conn,'web_medsos','id_web_medsos',$id_web_medsos,'logo');
                                            $logo_lama_path = '../../assets/img/Medsos/' . $logo_lama;
                                            //Hapus File Logo Lama
                                            if (unlink($logo_lama_path)) {
                                                $ValidasiLogo="Valid";
                                            }else{
                                                $ValidasiLogo= 'Terjadi kesalahan pada saat menghapus logo lama';
                                            }
                                        }
                                    }
                                }
                            }
                            if($ValidasiLogo!=="Valid"){
                                $errors[] = ''.$ValidasiLogo.'';
                            }else{
                                //Update Database
                                $sql = "UPDATE web_medsos SET 
                                    nama_medsos = ?, 
                                    url_medsos = ?,
                                    logo = ?
                                WHERE id_web_medsos = ?";
                                // Menyiapkan statement
                                $stmt = $Conn->prepare($sql);
                                $stmt->bind_param('ssss', 
                                    $nama_medsos, 
                                    $url_medsos, 
                                    $logo, 
                                    $id_web_medsos
                                );
                                // Eksekusi statement dan cek apakah berhasil
                                if ($stmt->execute()) {
                                    $kategori_log="Konten Utama";
                                    $deskripsi_log="Edit Medsos";
                                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                    if($InputLog=="Success"){
                                        $response['success'] = true;
                                    }else{
                                        $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                                    }
                                }else{
                                    $errors[] = 'Terjadi kesalahan pada saat melakukan update pada database!.';
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