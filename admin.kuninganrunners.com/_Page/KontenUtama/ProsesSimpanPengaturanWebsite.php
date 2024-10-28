<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    $now=date('Y-m-d H:i:s');
    // Inisialisasi pesan error pertama kali
    $response = ['success' => false, 'message' => ''];
    $errors = []; 
    if(empty($SessionIdAkses)){
        $errors[] = 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang!.';
    }else{
        //Validasi web_base_url tidak boleh kosong
        if(empty($_POST['web_base_url'])){
            $ValidasiKelengkapan= 'URL Website tidak boleh kosong!.';
        }else{
            //Validasi web_title tidak boleh kosong
            if(empty($_POST['web_title'])){
                $ValidasiKelengkapan= 'Judul/Title halaman web tidak boleh kosong!.';
            }else{
                //Validasi web_description tidak boleh kosong
                if(empty($_POST['web_description'])){
                    $ValidasiKelengkapan= 'Deskripsi halaman web tidak boleh kosong!.';
                }else{
                    //Validasi web_keyword tidak boleh kosong
                    if(empty($_POST['web_keyword'])){
                        $ValidasiKelengkapan= 'Kata Kunci halaman web tidak boleh kosong!.';
                    }else{
                        if(empty($_POST['web_author'])){
                            $ValidasiKelengkapan= 'Nama pembuat/perusahaan pengembang tidak boleh kosong!.';
                        }else{
                            $ValidasiKelengkapan='Valid';
                        }
                    }
                }
            }
        }
        if($ValidasiKelengkapan!=="Valid"){
            $errors[] = $ValidasiKelengkapan;
        }else{
            //Buat Variabel
            $web_base_url=validateAndSanitizeInput($_POST['web_base_url']);
            $web_title=validateAndSanitizeInput($_POST['web_title']);
            $web_description=validateAndSanitizeInput($_POST['web_description']);
            $web_keyword=validateAndSanitizeInput($_POST['web_keyword']);
            $web_author=validateAndSanitizeInput($_POST['web_author']);
            //Validasi Jumlah Karakter
            if(strlen($web_base_url)>250){
                $ValidasiJumlahKarakter="URL Website tidak boleh lebih dari 250 karakter.";
            }else{
                if(strlen($web_title)>50){
                    $ValidasiJumlahKarakter="Judul/Title Website tidak boleh lebih dari 50 karakter.";
                }else{
                    if(strlen($web_description)>250){
                        $ValidasiJumlahKarakter="Deskripsi Website tidak boleh lebih dari 50 karakter.";
                    }else{
                        if(strlen($web_keyword)>100){
                            $ValidasiJumlahKarakter="Kata Kunci Website tidak boleh lebih dari 50 karakter.";
                        }else{
                            if(strlen($web_author)>100){
                                $ValidasiJumlahKarakter="Author Website tidak boleh lebih dari 50 karakter.";
                            }else{
                                $ValidasiJumlahKarakter="Valid";
                            }
                        }
                    }
                }
            }
            if($ValidasiJumlahKarakter!=="Valid"){
                $errors[] = $ValidasiKelengkapan;
            }else{
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                
                //Validasi File web_pavicon
                if (empty($_FILES['web_pavicon']['name'])) {
                    $web_pavicon=GetDetailData($Conn, 'web_setting', 'id_web_setting', '1', 'pavicon');
                    $ValidasiFavicon="Valid";
                }else{
                    $fileExtension = pathinfo($_FILES['web_pavicon']['name'], PATHINFO_EXTENSION);
                    if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                        $ValidasiFavicon= 'Tipe file pavicon yang anda upload tidak valid!.';
                    }else{
                        // Tentukan jenis file yang diperbolehkan
                        $fileType = mime_content_type($_FILES['web_pavicon']['tmp_name']);
                        if (!in_array($fileType, $allowedTypes)) {
                            $ValidasiFavicon= 'Format file pavicon yang anda upload tidak valid!.';
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
                            $web_pavicon = bin2hex(random_bytes(16)) . '.' . $ext;
                            $web_pavicon_path = '../../assets/img/Web/' . $web_pavicon;
                            if (!move_uploaded_file($_FILES['web_pavicon']['tmp_name'], $web_pavicon_path)) {
                                $ValidasiFavicon= 'Gagal mengunggah pavicon, silakan coba lagi.';
                            }else{
                                $ValidasiFavicon= 'Valid';
                            }
                        }
                    }
                }
                if($ValidasiFavicon!=="Valid"){
                    $errors[] = $ValidasiFavicon;
                }else{
                    if (empty($_FILES['web_icon']['name'])) {
                        $web_icon=GetDetailData($Conn, 'web_setting', 'id_web_setting', '1', 'icon');
                        $ValidasiIcon="Valid";
                    }else{
                        $fileExtension = pathinfo($_FILES['web_icon']['name'], PATHINFO_EXTENSION);
                        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                            $ValidasiIcon= 'Tipe file icon yang anda upload tidak valid!.';
                        }else{
                            // Tentukan jenis file yang diperbolehkan
                            $fileType = mime_content_type($_FILES['web_icon']['tmp_name']);
                            if (!in_array($fileType, $allowedTypes)) {
                                $ValidasiIcon= 'Format file icon yang anda upload tidak valid!.';
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
                                $web_icon = bin2hex(random_bytes(16)) . '.' . $ext;
                                $web_icon_path = '../../assets/img/Web/' . $web_icon;
                                if (!move_uploaded_file($_FILES['web_icon']['tmp_name'], $web_icon_path)) {
                                    $ValidasiIcon= 'Gagal mengunggah icon, silakan coba lagi.';
                                }else{
                                    $ValidasiIcon= 'Valid';
                                }
                            }
                        }
                    }
                    if($ValidasiIcon!=="Valid"){
                        $errors[] = $ValidasiIcon;
                    }else{
                        //Update Database
                        $id_web_setting="1";
                        $sql = "UPDATE web_setting SET 
                            base_url = ?, 
                            pavicon = ?,
                            icon = ?,
                            title = ?,
                            description = ?,
                            keyword = ?,
                            author = ?
                        WHERE id_web_setting = ?";
                        // Menyiapkan statement
                        $stmt = $Conn->prepare($sql);
                        $stmt->bind_param('ssssssss', 
                            $web_base_url, 
                            $web_pavicon, 
                            $web_icon, 
                            $web_title, 
                            $web_description, 
                            $web_keyword, 
                            $web_author,
                            $id_web_setting
                        );
                        // Eksekusi statement dan cek apakah berhasil
                        if ($stmt->execute()) {
                            $kategori_log="Konten Utama";
                            $deskripsi_log="Update Pengaturan Web";
                            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                            if($InputLog=="Success"){
                                $response['success'] = true;
                            }else{
                                $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                            }
                        }else{
                            $errors[] = 'Terjadi kesalahan pada saat update data pada database!.';
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