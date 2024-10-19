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
        if (empty($_POST['password1'])) {
            $ValidasiKelengkapanData="Password tidak boleh kosong! Anda wajib mengisi form tersebut.";
        }else{
            if (empty($_POST['password2'])) {
                $ValidasiKelengkapanData="Password tidak boleh kosong! Anda wajib mengisi form tersebut.";
            }else{
                if (empty($_POST['id_member'])) {
                    $ValidasiKelengkapanData="ID Member tidak boleh kosong! Anda wajib mengisi form tersebut.";
                }else{
                    $ValidasiKelengkapanData="Valid";
                }
            }
        }
    }
    if($ValidasiKelengkapanData!=="Valid"){
        $errors[] = $ValidasiKelengkapanData;
    }else{
        // Validasi panjang karakter
        if (strlen($_POST['password1']) > 20) { 
            $ValidasiJumlahKarakter='Password tidak boleh lebih dari 20 karakter.'; 
        }else{
            if($_POST['password1']!==$_POST['password2']){
                $ValidasiJumlahKarakter='Password tidak boleh lebih dari 20 karakter.'; 
            }else{
                $ValidasiJumlahKarakter="Valid";
            }
        }
        if($ValidasiJumlahKarakter!=="Valid"){
            $errors[] = $ValidasiJumlahKarakter;
        }else{
            //Validasi Tipe Data
            if (!ctype_alnum($_POST['password1'])) {
                $ValidasiTipeData='Password hanya boleh huruf dan angka.';
            }else{
                $ValidasiTipeData='Valid';
            }
            if($ValidasiTipeData!=="Valid"){
                $errors[] = $ValidasiTipeData;
            }else{
                // Generate UUID dan siapkan data untuk dimasukkan
                $id_member=$_POST['id_member'];
                $password = password_hash($_POST['password1'], PASSWORD_DEFAULT);
                // Update data di database
                $updateQuery = "UPDATE member SET password = ? WHERE id_member = ?";
                $stmtUpdate = $Conn->prepare($updateQuery);
                $stmtUpdate->bind_param('ss', $password, $id_member);
                if ($stmtUpdate->execute()) {
                    $kategori_log = "Member";
                    $deskripsi_log = "Ubah Password";
                    $InputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);
                    if ($InputLog == "Success") {
                        $response['success'] = true;
                        $response['message'] = 'Password berhasil diperbarui.';
                    } else {
                        $response['success'] = false;
                        $response['message'] = 'Terjadi kesalahan pada saat menyimpan log.';
                    }
                    
                } else {
                    $response['message'] = 'Gagal memperbarui foto di database.';
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
