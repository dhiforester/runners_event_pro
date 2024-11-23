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
        //Validasi id_web_testimoni tidak boleh kosong
        if(empty($_POST['id_web_testimoni'])){
            $errors[] = 'ID Testimoni tidak boleh kosong!.';
        }else{
            //Validasi sumber_foto tidak boleh kosong
            if(empty($_POST['sumber_foto'])){
                $errors[] = 'Sumber foto tidak boleh kosong!.';
            }else{
                //Buat Variabel
                $id_web_testimoni=$_POST['id_web_testimoni'];
                $sumber_foto=$_POST['sumber_foto'];
                //Bersihkan Variabel
                $id_web_testimoni=validateAndSanitizeInput($id_web_testimoni);
                $sumber_foto=validateAndSanitizeInput($sumber_foto);
                //Validasi File Foto
                if($sumber_foto=="upload_file"){
                    if(empty($_FILES['file_foto']['name'])){
                        $validasi_foto="File Foto Tidak Boleh Kosong!";
                    }else{
                        //Atribut File gambar
                        $nama_gambar = $_FILES['file_foto']['name'];
                        $ukuran_gambar = $_FILES['file_foto']['size'];
                        $tipe_gambar = $_FILES['file_foto']['type'];
                        $tmp_gambar = $_FILES['file_foto']['tmp_name'];
                        $timestamp = strval(time() - strtotime('1970-01-01 00:00:00'));
                        if ($tipe_gambar == "image/jpeg" || $tipe_gambar == "image/jpg" || $tipe_gambar == "image/gif" || $tipe_gambar == "image/png") {
                            if ($ukuran_gambar < 2000000) {
                                if ($tipe_gambar == 'image/jpeg' || $tipe_gambar == 'image/jpg') {
                                    $source_image = imagecreatefromjpeg($tmp_gambar);
                                } elseif ($tipe_gambar == 'image/png') {
                                    $source_image = imagecreatefrompng($tmp_gambar);
                                } elseif ($tipe_gambar == 'image/gif') {
                                    $source_image = imagecreatefromgif($tmp_gambar);
                                } else {
                                    $source_image = "";
                                }
                                if(empty($source_image)){
                                    $validasi_foto = "tipe file hanya boleh JPG, JPEG, PNG and GIF";
                                }else{
                                    // Ukuran baru untuk resize
                                    $target_width = 200;
                                    $target_height = 200;
                                    // Dapatkan ukuran asli gambar
                                    list($original_width, $original_height) = getimagesize($tmp_gambar);
                                    // Buat kanvas baru untuk gambar yang diresize
                                    $resized_image = imagecreatetruecolor($target_width, $target_height);
                                    // Resize gambar
                                    imagecopyresampled(
                                        $resized_image, $source_image,
                                        0, 0, 0, 0,
                                        $target_width, $target_height,
                                        $original_width, $original_height
                                    );
                                    // Tangkap gambar ke dalam output buffer dan ubah ke base64
                                    ob_start();
                                    if ($tipe_gambar == 'image/jpeg' || $tipe_gambar == 'image/jpg') {
                                        imagejpeg($resized_image);
                                    } elseif ($tipe_gambar == 'image/png') {
                                        imagepng($resized_image);
                                    } elseif ($tipe_gambar == 'image/gif') {
                                        imagegif($resized_image);
                                    }
                                    $image_data = ob_get_clean();
                                    // Konversi gambar ke string base64
                                    $foto_testimoni = "data:image/jpeg;base64," . base64_encode($image_data);
                                    // Bersihkan memori
                                    imagedestroy($source_image);
                                    imagedestroy($resized_image);
                                    $validasi_foto="Valid";
                                }
                            } else {
                                $validasi_foto = "File gambar tidak boleh lebih dari 2 Mb";
                            }
                        } else {
                            $validasi_foto = "tipe file hanya boleh JPG, JPEG, PNG and GIF";
                        }
                    }
                }else{
                    //Apabila Sumber foto dari foto member
                    $id_member=GetDetailData($Conn,'web_testimoni','id_web_testimoni',$id_web_testimoni,'id_member');
                    $foto_member=GetDetailData($Conn,'member','id_member',$id_member,'foto');
                    if(empty($foto_member)){
                        //Apabila Member Tidak Punya Foto Profil
                        $foto_testimoni="";
                        $validasi_foto="Valid";
                    }else{
                        //Apabila Member Punya Foto Profil
                        $path_foto="../../assets/img/Member/$foto_member";
                        $new_width = 200;
                        $new_height = 200;
                        // Create a new true color image with the desired dimensions
                        $resized_image = imagecreatetruecolor($new_width, $new_height);
                        imagecopyresampled($resized_image, $path_foto, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                        ob_start();
                        imagejpeg($resized_image, null, 85);
                        $image_data = ob_get_clean();
                        $foto_testimoni = "data:image/jpeg;base64," . base64_encode($image_data);
                        // Clean up memory
                        imagedestroy($src_image);
                        imagedestroy($resized_image);
                        $validasi_foto="Valid";
                    }
                }
                if($validasi_foto!=="Valid"){
                    $errors[] = $validasi_foto;
                }else{
                    // Query untuk mengupdate data testimoni
                    $sql = "UPDATE web_testimoni SET 
                            foto_profil = ?
                    WHERE id_web_testimoni = ?";
                    // Menyiapkan statement
                    $stmt = $Conn->prepare($sql);
                    $stmt->bind_param('ss', 
                        $foto_testimoni, 
                        $id_web_testimoni
                    );
                    // Eksekusi statement dan cek apakah berhasil
                    if ($stmt->execute()) {
                        $kategori_log="Testimoni";
                        $deskripsi_log="Ubah Foto Testimoni";
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
    if (!empty($errors)) {
        $response['message'] = implode('<br>', $errors);
        echo json_encode($response);
        exit;
    }else{
        echo json_encode($response);
    }
?>