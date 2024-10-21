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
        if (empty($_POST['id_barang'])) {
            $ValidasiKelengkapanData="ID barang tidak boleh kosong! Anda wajib mengisi form tersebut.";
        }else{
            // Validasi data input tidak boleh kosong
            if (empty($_FILES['foto']['name'])) {
                $ValidasiKelengkapanData="File Foto Tidak Bleh Kosong!.";
            }else{
                $ValidasiKelengkapanData="Valid";
            }
        }
    }
    if($ValidasiKelengkapanData!=="Valid"){
        $errors[] = $ValidasiKelengkapanData;
    }else{
        //Membuat Variabel
        $id_barang=$_POST['id_barang'];
        //Buka Foto Lama
        $FotoLama=GetDetailData($Conn,'barang','id_barang',$id_barang,'foto');
        if(!empty($FotoLama)){
            $PathFoto="../../assets/img/Marchandise/$FotoLama";
            //Hapus Foto Lama
            unlink($PathFoto);
        }
        //Upload Foto Baru
        $foto_ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $allowed_foto_types = ['png', 'jpg', 'jpeg', 'gif'];
        if (!in_array($foto_ext, $allowed_foto_types)) {
            $ValidasiFoto= 'Format file foto harus PNG, JPG, JPEG, atau GIF.';
        } else {
            $foto = bin2hex(random_bytes(16)) . '.' . $foto_ext;
            $foto_path = '../../assets/img/Marchandise/' . $foto;
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path)) {
                $ValidasiFoto== 'Gagal mengunggah foto, silakan coba lagi.';
            }else{
                $ValidasiFoto="Valid";
            }
        }
        if($ValidasiFoto!=="Valid"){
            $errors[] = $ValidasiFoto;
        }else{
            $updatetime = date('Y-m-d H:i:s');
            // Update data ke database
            $query = "UPDATE barang SET foto = ? WHERE id_barang = ?";
            $stmt = $Conn->prepare($query);
            $stmt->bind_param("si", $foto, $id_barang);

            if ($stmt->execute()) {
                //Menyimpan Log
                $kategori_log="Merchandise";
                $deskripsi_log="Update Foto Merchandise";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    $response['success'] = true;
                    $response['message'] = 'Update Foto Merchandise Berhasil';
                }else{
                    $errors[] = 'Terjadi Kesalahan Pada Saat Menyimpan Log';
                }
            } else {
                $errors[] = 'Gagal mengupdate data, coba lagi.';
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