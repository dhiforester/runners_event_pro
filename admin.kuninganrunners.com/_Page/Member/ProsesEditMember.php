<?php
    // Koneksi Dan Pengaturan lainnya
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingEmail.php";
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    // Inisialisasi pesan error
    $response = ['success' => false, 'message' => ''];
    $errors = []; 
    // Harus Login Terlebih Dulu
    if (empty($SessionIdAkses)) {
        $ValidasiKelengkapanData='Sesi akses sudah berakhir, silahkan login ulang!.';
    }else{
        // Validasi data input tidak boleh kosong
        if (empty($_POST['nama'])) {
            $ValidasiKelengkapanData="Nama tidak boleh kosong! Anda wajib mengisi form tersebut.";
        }else{
            if (empty($_POST['kontak'])) {
                $ValidasiKelengkapanData="Kontak tidak boleh kosong! Anda wajib mengisi form tersebut.";
            }else{
                if (empty($_POST['email'])) {
                    $ValidasiKelengkapanData="Email tidak boleh kosong! Anda wajib mengisi form tersebut.";
                }else{
                    if (empty($_POST['id_member'])) {
                        $ValidasiKelengkapanData="ID Member tidak boleh kosong!";
                    }else{
                        if (empty($_POST['provinsi'])) {
                            $ValidasiKelengkapanData="Provinsi tidak boleh kosong! Anda wajib mengisi form tersebut.";
                        }else{
                            if (empty($_POST['kabupaten'])) {
                                $ValidasiKelengkapanData="Kabupaten tidak boleh kosong! Anda wajib mengisi form tersebut.";
                            }else{
                                if (empty($_POST['kecamatan'])) {
                                    $ValidasiKelengkapanData="Kecamatan tidak boleh kosong! Anda wajib mengisi form tersebut.";
                                }else{
                                    if (empty($_POST['desa'])) {
                                        $ValidasiKelengkapanData="Desa tidak boleh kosong! Anda wajib mengisi form tersebut.";
                                    }else{
                                        if (empty($_POST['status'])) {
                                            $ValidasiKelengkapanData="Status tidak boleh kosong! Anda wajib mengisi form tersebut.";
                                        }else{
                                            if (empty($_POST['email_validation'])) {
                                                $ValidasiKelengkapanData="Kode Validasi Email tidak boleh kosong! Anda wajib mengisi form tersebut.";
                                            }else{
                                                $ValidasiKelengkapanData="Valid";
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
    }
    if($ValidasiKelengkapanData!=="Valid"){
        $errors[] = $ValidasiKelengkapanData;
    }else{
        // Validasi panjang karakter
        if (strlen($_POST['nama']) > 100) { 
            $ValidasiJumlahKarakter= 'Nama tidak boleh lebih dari 100 karakter.'; 
        }else{
            if (strlen($_POST['kontak']) > 20) { 
                $ValidasiJumlahKarakter= 'Kontak tidak boleh lebih dari 20 karakter.'; 
            }else{
                if (strlen($_POST['email']) > 100) { 
                    $ValidasiJumlahKarakter= 'Email tidak boleh lebih dari 100 karakter.'; 
                }else{
                    if (strlen($_POST['id_member']) > 36) { 
                        $ValidasiJumlahKarakter='ID member tidak boleh lebih dari 36 karakter.'; 
                    }else{
                        if (isset($_POST['kode_pos']) && strlen($_POST['kode_pos']) > 10) { 
                            $ValidasiJumlahKarakter='Kode pos tidak boleh lebih dari 10 karakter.'; 
                        }else{
                            if (isset($_POST['rt_rw']) && strlen($_POST['rt_rw']) > 50) { 
                                $ValidasiJumlahKarakter='RT/RW tidak boleh lebih dari 50 karakter.'; 
                            }else{
                                if (isset($_POST['email_validation']) && strlen($_POST['email_validation']) > 9) { 
                                    $ValidasiJumlahKarakter='Kode validasi email tidak boleh lebih dari 9 karakter.'; 
                                }else{
                                    $ValidasiJumlahKarakter="Valid";
                                }
                            }
                        }
                    }
                }
            }
        }
        if($ValidasiJumlahKarakter!=="Valid"){
            $errors[] = $ValidasiJumlahKarakter;
        }else{
            //Validasi Tipe Data
            if (!preg_match("/^[a-zA-Z\s]+$/", $_POST['nama'])) {
                $ValidasiTipeData= 'Nama hanya boleh huruf dan spasi.';
            }else{
                if (!ctype_digit($_POST['kontak'])) {
                    $ValidasiTipeData='Kontak hanya boleh angka.';
                }else{
                    if (!ctype_alnum($_POST['id_member'])) {
                        $ValidasiTipeData='ID member hanya boleh huruf dan angka.';
                    }else{
                        if(!ctype_alnum($_POST['email_validation'])){
                            $ValidasiTipeData='Kode validasi email hanya boleh huruf dan angka.';
                        }else{
                            if (!empty($_POST['kode_pos'])) {
                                if(!ctype_alnum($_POST['kode_pos'])){
                                    $ValidasiTipeData='Kode pos hanya boleh angka.';
                                }else{
                                    $ValidasiTipeData='Valid';
                                }
                            }else{
                                $ValidasiTipeData='Valid';
                            }
                        }
                    }
                }
            }
            if($ValidasiTipeData!=="Valid"){
                $errors[] = $ValidasiTipeData;
            }else{
                // Buatkan variabel atau siapkan data untuk dimasukkan
                $id_member = $_POST['id_member'];
                $nama = validateAndSanitizeInput($_POST['nama']);
                $kontak = validateAndSanitizeInput($_POST['kontak']);
                $email = validateAndSanitizeInput($_POST['email']);
                $provinsi = validateAndSanitizeInput($_POST['provinsi']);
                $kabupaten = validateAndSanitizeInput($_POST['kabupaten']);
                $kecamatan = validateAndSanitizeInput($_POST['kecamatan']);
                $desa = validateAndSanitizeInput($_POST['desa']);
                $status = validateAndSanitizeInput($_POST['status']);
                $rt_rw = isset($_POST['rt_rw']) ? validateAndSanitizeInput($_POST['rt_rw']) : '';
                $kode_pos = isset($_POST['kode_pos']) ? validateAndSanitizeInput($_POST['kode_pos']) : '';
                $email_validation = isset($_POST['email_validation']) ? validateAndSanitizeInput($_POST['email_validation']) : '';

                // Update data ke database
                $updateQuery = "UPDATE member SET nama = ?, kontak = ?, email = ?, email_validation = ?, provinsi = ?, kabupaten = ?, kecamatan = ?, desa = ?, kode_pos = ?, rt_rw = ?, status = ? WHERE id_member = ?";
                $stmtUpdate = $Conn->prepare($updateQuery);
                $stmtUpdate->bind_param('ssssssssssss', $nama, $kontak, $email, $email_validation, $provinsi, $kabupaten, $kecamatan, $desa, $kode_pos, $rt_rw, $status, $id_member);
                if ($stmtUpdate->execute()) {
                    //Menyimpan Log
                    addLog($Conn, $SessionIdAkses, $now, "Member", "Update Member");
                    $response['success'] = true;
                    $response['message'] = 'Update Member Berhasil';
                } else {
                    $errors[]= 'Gagal menyimpan data, coba lagi.';
                }
            }
        }
    }
    // Jika ada error, kirim respons dengan daftar pesan error
    if (!empty($errors)) {
        $response['message'] = implode('<br>', $errors);
        echo json_encode($response);
        exit;
    }else{
        echo json_encode($response);
    }
?>
