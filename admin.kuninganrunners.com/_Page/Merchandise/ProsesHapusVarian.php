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
            $ValidasiKelengkapanData="ID Barang tidak boleh kosong! Anda wajib mengisi form tersebut.";
        }else{
            if (empty($_POST['id_varian'])) {
                $ValidasiKelengkapanData="ID Varian tidak boleh kosong! Anda wajib mengisi form tersebut.";
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
        $id_varian=$_POST['id_varian'];
        //Membuka Data Varian
        $varian = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'varian');
        $VarianArray=json_decode($varian, true);
        //Buka Data Array
        foreach($VarianArray as $VarianList){
            if($VarianList['id_varian']==$id_varian){
                $foto_varian=$VarianList['foto_varian'];
                if(!empty($foto_varian)){
                    $foto_path = '../../assets/img/Marchandise/' . $foto_varian;
                    if (file_exists($foto_path)) {
                        unlink($foto_path);
                    }
                }
            }
        }
        $varian_list = json_decode($varian, true);
        // Jika $varian_list kosong atau tidak valid, inisialisasi sebagai array kosong
        if (!is_array($varian_list)) {
            $varian_list = [];
        }

        // Cari dan hapus varian berdasarkan id_varian
        foreach ($varian_list as $key => $item) {
            if ($item['id_varian'] === $id_varian) {
                // Hapus data varian yang ditemukan
                unset($varian_list[$key]);
                break;
            }
        }

        // Reindex array setelah penghapusan
        $varian_list = array_values($varian_list);

        // Encode kembali array menjadi JSON string
        $varian = json_encode($varian_list, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // Query untuk mengupdate data event
        $sql = "UPDATE barang SET 
            varian = ? ,
            updatetime = ? 
        WHERE id_barang = ?";
        // Menyiapkan statement
        $stmt = $Conn->prepare($sql);
        $stmt->bind_param('sss', $varian, $now, $id_barang);
        // Eksekusi statement dan cek apakah berhasil
        if ($stmt->execute()) {
            //Menyimpan Log
            $kategori_log="Merchandise";
            $deskripsi_log="Edit Merchandise";
            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
            if($InputLog=="Success"){
                $response['success'] = true;
                $response['message'] = 'Hapus Varian Berhasil';
            }else{
                $errors[] = 'Terjadi Kesalahan Pada Saat Menyimpan Log';
            }
        }else{
            $errors[]= 'Gagal menyimpan data, coba lagi.';
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