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
                if (empty($_POST['nama_varian'])) {
                    $ValidasiKelengkapanData="Nama varian tidak boleh kosong! Anda wajib mengisi form tersebut.";
                }else{
                    $ValidasiKelengkapanData="Valid";
                }
            }
        }
    }
    if($ValidasiKelengkapanData!=="Valid"){
        $errors[] = $ValidasiKelengkapanData;
    }else{
        //Membuat Variabel
        $id_barang=$_POST['id_barang'];
        $id_varian=$_POST['id_varian'];
        $nama_varian=$_POST['nama_varian'];
        if(empty($_POST['harga_varian'])){
            $harga_varian=0;
        }else{
            $harga_varian=$_POST['harga_varian'];
        }
        if(empty($_POST['stok_varian'])){
            $stok_varian=0;
        }else{
            $stok_varian=$_POST['stok_varian'];
        }
        if(empty($_POST['keterangan_varian'])){
            $keterangan_varian="";
        }else{
            $keterangan_varian=$_POST['keterangan_varian'];
        }
        // Validasi panjang karakter
        if (strlen($nama_varian) > 50) { 
            $ValidasiJumlahKarakter= 'Nama Varian tidak boleh lebih dari 50 karakter.'; 
        }else{
            if (strlen($harga_varian) > 10) { 
                $ValidasiJumlahKarakter= 'Harga tidak boleh lebih dari 20 karakter.'; 
            }else{
                if (strlen($stok_varian) > 10) { 
                    $ValidasiJumlahKarakter= 'Stok tidak boleh lebih dari 10 karakter.'; 
                }else{
                    if (strlen($keterangan_varian) > 200) { 
                        $ValidasiJumlahKarakter='Harga tidak boleh lebih dari 10 karakter.'; 
                    }else{
                        $ValidasiJumlahKarakter="Valid";
                    }
                }
            }
        }
        if($ValidasiJumlahKarakter!=="Valid"){
            $errors[] = $ValidasiJumlahKarakter;
        }else{
            //Validasi Tipe Data
            if(!ctype_alnum($harga_varian)){
                $ValidasiTipeData='Harga hanya boleh diisi angka.';
            }else{
                if(!ctype_alnum($stok_varian)){
                    $ValidasiTipeData='Stok hanya boleh diisi angka.';
                }else{
                    $ValidasiTipeData='Valid';
                }
            }
            if($ValidasiTipeData!=="Valid"){
                $errors[] = $ValidasiTipeData;
            }else{
                //Validasi Foto Barang
                if (empty($_FILES['foto_varian']['name'])) {
                    $ValidasiFoto="Valid";
                    $foto_varian="";
                    $varian = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'varian');
                    $VarianArray=json_decode($varian, true);
                    //Buka Data Array
                    foreach($VarianArray as $VarianList){
                        if($VarianList['id_varian']==$id_varian){
                            $foto_varian=$VarianList['foto_varian'];
                        }
                    }
                }else{
                    $foto_ext = strtolower(pathinfo($_FILES['foto_varian']['name'], PATHINFO_EXTENSION));
                    $allowed_foto_types = ['png', 'jpg', 'jpeg', 'gif'];
                    if (!in_array($foto_ext, $allowed_foto_types)) {
                        $ValidasiFoto= 'Format file foto harus PNG, JPG, JPEG, atau GIF.';
                    } else {
                        $foto_varian = bin2hex(random_bytes(16)) . '.' . $foto_ext;
                        $foto_path = '../../assets/img/Marchandise/' . $foto_varian;
                        if (!move_uploaded_file($_FILES['foto_varian']['tmp_name'], $foto_path)) {
                            $ValidasiFoto== 'Gagal mengunggah foto, silakan coba lagi.';
                        }else{
                            $ValidasiFoto="Valid";
                        }
                    }
                }
                if($ValidasiFoto!=="Valid"){
                    $errors[] = $ValidasiFoto;
                }else{
                    // Mendapatkan data varian dari database
                    $varian = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'varian');
                    $varian_list = json_decode($varian, true);
                    // Membuat array data varian yang baru
                    $varian_arry = [
                        'id_varian' => $id_varian,
                        'nama_varian' => $nama_varian,
                        'harga_varian' => $harga_varian,
                        'stok_varian' => $stok_varian, 
                        'keterangan_varian' => $keterangan_varian, 
                        'foto_varian' => $foto_varian 
                    ];

                    // Jika $varian_list kosong atau tidak valid, inisialisasi sebagai array kosong
                    if (!is_array($varian_list)) {
                        $varian_list = [];
                    }
                    // Cari dan perbarui varian berdasarkan id_varian
                    $found = false;
                    foreach ($varian_list as &$item) {
                        if ($item['id_varian'] === $id_varian) {
                            // Perbarui data varian yang ditemukan
                            $item = $varian_arry;
                            $found = true;
                            break;
                        }
                    }

                    // Jika id_varian tidak ditemukan, tambahkan sebagai varian baru
                    if (!$found) {
                        $varian_list[] = $varian_arry;
                    }

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
                            $response['message'] = 'Update Varian Berhasil';
                        }else{
                            $errors[] = 'Terjadi Kesalahan Pada Saat Menyimpan Log';
                        }
                    }else{
                        $errors[]= 'Gagal menyimpan data, coba lagi.';
                    }
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