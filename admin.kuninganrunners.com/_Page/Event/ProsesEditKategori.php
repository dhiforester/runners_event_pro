<?php
    // Koneksi Dan Keterangan Waktu
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    // Inisialisasi pesan error pertama kali
    $response = ['success' => false, 'message' => ''];
    $errors = []; 
    // Harus Login Terlebih Dulu
    if (empty($SessionIdAkses)) {
        $errors[] = 'Sesi akses sudah berakhir, silahkan login ulang!.';
    }else{
        // Validasi data input yang wajib diisi
        if (empty($_POST['id_event_kategori'])) { 
            $errors[] = 'ID Kategori Event Tidak Boleh Kosong'; 
        }else{
            if (empty($_POST['kategori'])) { 
                $errors[] = 'Kategori Event Tidak Boleh Kosong'; 
            }else{
                $id_event_kategori=$_POST['id_event_kategori'];
                $kategori=$_POST['kategori'];
                if (empty($_POST['biaya_pendaftaran'])) { 
                    $biaya_pendaftaran=0;
                }else{
                    $biaya_pendaftaran=$_POST['biaya_pendaftaran'];
                }
                if (empty($_POST['deskripsi'])) { 
                    $deskripsi=0;
                }else{
                    $deskripsi=$_POST['deskripsi'];
                }
                //Validasi Jumlah Karakter Dan Tipe Karakter
                if (strlen($kategori) > 50) { 
                    $errors[] = 'Kategori tidak boleh lebih dari 50 karakter'; 
                }else{
                    if (strlen($biaya_pendaftaran) > 10) { 
                        $errors[] = 'Biaya pendaftaran tidak boleh lebih dari 10 karakter'; 
                    }else{
                        if (strlen($deskripsi) > 500) { 
                            $errors[] = 'Deskripsi tidak boleh lebih dari 500 karakter'; 
                        }else{
                            if (!is_numeric($biaya_pendaftaran)) {
                                $errors[] = 'Biaya pendaftaran hanya boleh diisi dengan angka!'; 
                            }else{
                                // Bersihkan Variabel
                                $id_event_kategori = validateAndSanitizeInput($id_event_kategori);
                                $kategori = validateAndSanitizeInput($kategori);
                                $biaya_pendaftaran = validateAndSanitizeInput($biaya_pendaftaran);
                                $deskripsi = validateAndSanitizeInput($deskripsi);
                                // Insert data ke database
                                // Query untuk mengupdate data event
                                $sql = "UPDATE event_kategori SET 
                                        kategori = ?, 
                                        biaya_pendaftaran = ?, 
                                        deskripsi = ?
                                WHERE id_event_kategori = ?";
                                // Menyiapkan statement
                                $stmt = $Conn->prepare($sql);
                                $stmt->bind_param('ssss', 
                                    $kategori, 
                                    $biaya_pendaftaran, 
                                    $deskripsi, 
                                    $id_event_kategori
                                );
                                // Eksekusi statement dan cek apakah berhasil
                                if ($stmt->execute()) {
                                    $kategori_log = "Event";
                                    $deskripsi_log = "Update Kategori Event";
                                    $InputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);
                                    if ($InputLog == "Success") {
                                        $response['success'] = true;
                                        $response['message'] = 'Event berhasil diperbarui.';
                                    } else {
                                        $errors[]= 'Terjadi kesalahan saat menyimpan log.';
                                    }
                                } else {
                                    $errors[]= 'Gagal memperbarui kategori event. ' . $stmt->error;
                                }
                                // Menutup statement dan koneksi
                                $stmt->close();
                                $Conn->close();
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
