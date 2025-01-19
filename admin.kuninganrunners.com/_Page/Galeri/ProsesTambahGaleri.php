<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');
    $date = date('Y-m-d');
    $time = date('H:i:s');

    // Inisialisasi pesan error pertama kali
    $response = ['success' => false, 'message' => ''];
    $errors = []; 

    if (empty($SessionIdAkses)) {
        $errors[] = 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang!.';
    } else {
        // Validasi album tidak boleh kosong
        if (empty($_POST['album'])) {
            $errors[] = 'Nama Album tidak boleh kosong!.';
        } else {
            // Validasi nama_galeri tidak boleh kosong
            if (empty($_POST['nama_galeri'])) {
                $errors[] = 'Nama/Judul Foto tidak boleh kosong!.';
            } else {
                // Validasi file
                if (empty($_FILES['file_galeri']['name'][0])) {
                    $errors[] = 'File foto tidak boleh kosong!.';
                } else {
                    // Buat Variabel
                    $album = $_POST['album'];
                    $nama_galeri = $_POST['nama_galeri'];

                    // Bersihkan Variabel
                    $album = validateAndSanitizeInput($album);
                    $nama_galeri = validateAndSanitizeInput($nama_galeri);

                    if (strlen($album) > 50) {
                        $errors[] = 'Nama album tidak boleh lebih dari 50 karakter!.';
                    } else {
                        if (strlen($nama_galeri) > 100) {
                            $errors[] = 'Nama/Judul Foto tidak boleh lebih dari 100 karakter!.';
                        } else {
                            if (!preg_match('/^[a-zA-Z0-9\s-]+$/', $album)) {
                                $errors[] = 'Nama album hanya boleh huruf, angka, dan spasi.';
                            } else {
                                // Validasi dan proses file satu per satu
                                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                                $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                                $uploadedFiles = $_FILES['file_galeri'];
                                $uploadedCount = count($uploadedFiles['name']);

                                // Apakah Nama Album Sudah Ada
                                $id_web_galeri_album = GetDetailData($Conn, 'web_galeri_album', 'album', $album, 'id_web_galeri_album');
                                if (empty($id_web_galeri_album)) {
                                    $id_web_galeri_album_uid = generateUuidV1();
                                    // Insert Ke web_galeri_album
                                    $query = "INSERT INTO web_galeri_album (id_web_galeri_album, album) VALUES (?, ?)";
                                    $stmt = $Conn->prepare($query);
                                    $stmt->bind_param("ss", $id_web_galeri_album_uid, $album);
                                    if ($stmt->execute()) {
                                        $id_web_galeri_album = $id_web_galeri_album_uid;
                                    } else {
                                        $id_web_galeri_album = 0;
                                    }
                                }

                                if (empty($id_web_galeri_album)) {
                                    $errors[] = 'Terjadi kesalahan pada saat membuat data album.';
                                } else {
                                    // Iterasi melalui semua file
                                    for ($i = 0; $i < $uploadedCount; $i++) {
                                        $fileName = $uploadedFiles['name'][$i];
                                        $fileTmp = $uploadedFiles['tmp_name'][$i];
                                        $fileSize = $uploadedFiles['size'][$i];
                                        $fileError = $uploadedFiles['error'][$i];
                                        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                                        $fileType = mime_content_type($fileTmp);

                                        if (!in_array($fileExtension, $allowedExtensions) || !in_array($fileType, $allowedTypes)) {
                                            $errors[] = "File \"$fileName\" tidak valid (format file tidak diizinkan).";
                                            continue;
                                        }
                                        if ($fileSize > (5 * 1024 * 1024)) {
                                            $errors[] = "File \"$fileName\" terlalu besar. Maksimal 5 MB.";
                                            continue;
                                        }

                                        // Generate nama file unik
                                        $file_galeri = bin2hex(random_bytes(16)) . '.' . $fileExtension;
                                        $file_galeri_path = '../../assets/img/Galeri/' . $file_galeri;

                                        if (!move_uploaded_file($fileTmp, $file_galeri_path)) {
                                            $errors[] = "Gagal mengunggah file \"$fileName\".";
                                            continue;
                                        }

                                        // Insert data ke database
                                        $query_galeri = "INSERT INTO web_galeri (id_web_galeri_album, album, nama_galeri, datetime, file_galeri) 
                                                        VALUES (?, ?, ?, ?, ?)";
                                        $stmt_galeri = $Conn->prepare($query_galeri);
                                        $stmt_galeri->bind_param("sssss", $id_web_galeri_album, $album, $nama_galeri, $now, $file_galeri);

                                        if (!$stmt_galeri->execute()) {
                                            $errors[] = "Terjadi kesalahan pada saat menambahkan file \"$fileName\" ke database.";
                                        }
                                    }

                                    // Log Aktivitas
                                    if (empty($errors)) {
                                        $kategori_log = "Galeri";
                                        $deskripsi_log = "Tambah Galeri (Multi Upload)";
                                        $InputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);

                                        if ($InputLog == "Success") {
                                            $response['success'] = true;
                                        } else {
                                            $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
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
    } else {
        echo json_encode($response);
    }
?>
