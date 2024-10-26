<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    // Harus Login Terlebih Dulu
    if (empty($SessionIdAkses)) {
        echo '<code id="NotifikasiTambahKategoriBerhasil">Sesi akses sudah berakhir, silahkan login ulang!</code>';
    }else{
        if (empty($_POST['id_event'])) {
            echo '<code id="NotifikasiTambahKategoriBerhasil">ID Event Tidak Boleh Kosong!</code>';
        }else{
            if (empty($_POST['kategori'])) {
                echo '<code id="NotifikasiTambahKategoriBerhasil">Nama Kategori Tidak Boleh Kosong!</code>';
            }else{
                $id_event=$_POST['id_event'];
                $kategori=$_POST['kategori'];
                if(empty($_POST['biaya_pendaftaran'])) {
                    $biaya_pendaftaran=0;
                }else{
                    $biaya_pendaftaran=$_POST['biaya_pendaftaran'];
                }
                if(empty($_POST['deskripsi'])) {
                    $deskripsi="";
                }else{
                    $deskripsi=$_POST['deskripsi'];
                }
                //Validasi Jumlah Karakter
                if (strlen($_POST['kategori']) > 50) { 
                    echo '<code id="NotifikasiTambahKategoriBerhasil">Kategori tidak boleh lebih dari 50 karakter</code>';
                }else{
                    if (strlen($_POST['biaya_pendaftaran']) > 10) { 
                        echo '<code id="NotifikasiTambahKategoriBerhasil">Biaya pendaftaran tidak boleh lebih dari 10 karakter</code>';
                    }else{
                        if (strlen($_POST['deskripsi']) > 500) { 
                            echo '<code id="NotifikasiTambahKategoriBerhasil">Deskripsi tidak boleh lebih dari 500 karakter</code>';
                        }else{
                            if (!ctype_digit($_POST['biaya_pendaftaran'])) {
                                echo '<code id="NotifikasiTambahKategoriBerhasil">Biaya pendaftaran hanya boleh diisi dengan angka!</code>';
                            }else{
                                // Bersihkan Variabel
                                $id_event = validateAndSanitizeInput($id_event);
                                $kategori = validateAndSanitizeInput($kategori);
                                $biaya_pendaftaran = validateAndSanitizeInput($biaya_pendaftaran);
                                $deskripsi = validateAndSanitizeInput($deskripsi);

                                // Insert data ke database
                                $query = "INSERT INTO event_kategori (id_event, kategori, biaya_pendaftaran, deskripsi) 
                                        VALUES (?, ?, ?, ?)";
                                $stmt = $Conn->prepare($query);
                                $stmt->bind_param("ssss", $id_event, $kategori, $biaya_pendaftaran, $deskripsi);
                                if ($stmt->execute()) {
                                    $kategori_log = "Event";
                                    $deskripsi_log = "Input Kategori Event";
                                    $InputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);
                                    if ($InputLog == "Success") {
                                        echo '<code id="NotifikasiTambahKategoriBerhasil">Success</code>';
                                    } else {
                                        echo '<code id="NotifikasiTambahKategoriBerhasil">Terjadi kesalahan pada saat menyimpan log</code>';
                                    }
                                } else {
                                    echo '<code id="NotifikasiTambahKategoriBerhasil">Terjadi kesalahan pada saat menyimpan data</code>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
