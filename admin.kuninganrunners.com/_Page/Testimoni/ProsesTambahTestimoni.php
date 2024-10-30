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
                            if (!ctype_digit($_POST['penilaian'])) {
                                $errors[] = 'Penilaian hanya boleh diisi dengan angka 1-5';
                            }else{
                                if($penilaian>5){
                                    $errors[] = 'Penilaian hanya boleh diisi dengan angka 1-5';
                                }else{
                                    //Buka Detail Member
                                    $nik_name=GetDetailData($Conn,'member','id_member',$id_member,'nama');
                                    $foto=GetDetailData($Conn,'member','id_member',$id_member,'foto');
                                    if(!empty($foto)){
                                        $image_path="../../assets/img/Member/$foto";
                                        //Proses Mengubah Foto Menjadi base64
                                        
                                        // Desired width and height for the resized image
                                        $new_width = 200;
                                        $new_height = 200;

                                        // Check if file exists
                                        if (file_exists($image_path)) {
                                            // Get the original image dimensions and type
                                            list($width, $height, $type) = getimagesize($image_path);
                                            // Create an image resource from the file based on its type
                                            switch ($type) {
                                                case IMAGETYPE_JPEG:
                                                    $src_image = imagecreatefromjpeg($image_path);
                                                    break;
                                                case IMAGETYPE_PNG:
                                                    $src_image = imagecreatefrompng($image_path);
                                                    break;
                                                case IMAGETYPE_GIF:
                                                    $src_image = imagecreatefromgif($image_path);
                                                    break;
                                                default:
                                                    $foto_profil="";
                                            }
                                            // Create a new true color image with the desired dimensions
                                            $resized_image = imagecreatetruecolor($new_width, $new_height);

                                            // Resize the image
                                            imagecopyresampled($resized_image, $src_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

                                            // Start output buffering to capture the output
                                            ob_start();

                                            // Output the resized image as JPEG to buffer
                                            imagejpeg($resized_image, null, 85); // 85 is the quality level

                                            // Get the contents of the buffer and encode it in Base64
                                            $image_data = ob_get_clean();
                                            $foto_profil = "data:image/jpeg;base64," . base64_encode($image_data);

                                            // Clean up memory
                                            imagedestroy($src_image);
                                            imagedestroy($resized_image);
                                        } else {
                                            $foto_profil="";
                                        }
                                    }else{
                                        $foto_profil="";
                                    }
                                    // Insert data ke database
                                    $query = "INSERT INTO web_testimoni (id_member, nik_name, penilaian, testimoni, foto_profil, sumber, datetime, status) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                                    $stmt = $Conn->prepare($query);
                                    $stmt->bind_param("ssssssss", $id_member, $nik_name, $penilaian, $testimoni, $foto_profil, $sumber, $now, $status);
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