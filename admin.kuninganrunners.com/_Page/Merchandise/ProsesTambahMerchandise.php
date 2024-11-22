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
        if (empty($_POST['nama_barang'])) {
            $ValidasiKelengkapanData="Nama barang tidak boleh kosong! Anda wajib mengisi form tersebut.";
        }else{
            if (empty($_POST['kategori'])) {
                $ValidasiKelengkapanData="Kategori barang tidak boleh kosong! Anda wajib mengisi form tersebut.";
            }else{
                if (empty($_POST['satuan'])) {
                    $ValidasiKelengkapanData="Satuan tidak boleh kosong! Anda wajib mengisi form tersebut.";
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
        $nama_barang=$_POST['nama_barang'];
        $kategori=$_POST['kategori'];
        $satuan=$_POST['satuan'];
        if(empty($_POST['harga'])){
            $harga="0";
        }else{
            $harga=$_POST['harga'];
        }
        if(empty($_POST['stok'])){
            $stok="0";
        }else{
            $stok=$_POST['stok'];
        }
        if(empty($_POST['berat'])){
            $berat="0";
        }else{
            $berat=$_POST['berat'];
        }
        if(empty($_POST['panjang'])){
            $panjang="0";
        }else{
            $panjang=$_POST['panjang'];
        }
        if(empty($_POST['lebar'])){
            $lebar="0";
        }else{
            $lebar=$_POST['lebar'];
        }
        if(empty($_POST['tinggi'])){
            $tinggi="0";
        }else{
            $tinggi=$_POST['tinggi'];
        }
        if(empty($_POST['deskripsi'])){
            $deskripsi="";
        }else{
            $deskripsi=$_POST['deskripsi'];
        }
        // Validasi panjang karakter
        if (strlen($_POST['nama_barang']) > 50) { 
            $ValidasiJumlahKarakter= 'Nama barang tidak boleh lebih dari 50 karakter.'; 
        }else{
            if (strlen($_POST['kategori']) > 20) { 
                $ValidasiJumlahKarakter= 'Kategori tidak boleh lebih dari 20 karakter.'; 
            }else{
                if (strlen($_POST['satuan']) > 10) { 
                    $ValidasiJumlahKarakter= 'Satuan tidak boleh lebih dari 10 karakter.'; 
                }else{
                    if (strlen($harga) > 10) { 
                        $ValidasiJumlahKarakter='Harga tidak boleh lebih dari 10 karakter.'; 
                    }else{
                        if (strlen($stok) > 10) { 
                            $ValidasiJumlahKarakter='Stok tidak boleh lebih dari 10 karakter.'; 
                        }else{
                            if (strlen($berat) > 10) { 
                                $ValidasiJumlahKarakter='Berat tidak boleh lebih dari 10 karakter.'; 
                            }else{
                                if (strlen($panjang) > 10) { 
                                    $ValidasiJumlahKarakter='Panjang tidak boleh lebih dari 10 karakter.'; 
                                }else{
                                    if (strlen($lebar) > 10) { 
                                        $ValidasiJumlahKarakter='Lebar tidak boleh lebih dari 10 karakter.'; 
                                    }else{
                                        if (strlen($tinggi) > 10) { 
                                            $ValidasiJumlahKarakter='Tinggi tidak boleh lebih dari 10 karakter.'; 
                                        }else{
                                            if (strlen($deskripsi) > 500) { 
                                                $ValidasiJumlahKarakter='Deskripsi tidak boleh lebih dari 500 karakter.'; 
                                            }else{
                                                $ValidasiJumlahKarakter="Valid";
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
        if($ValidasiJumlahKarakter!=="Valid"){
            $errors[] = $ValidasiJumlahKarakter;
        }else{
            //Validasi Tipe Data
            if (!preg_match("/^[a-zA-Z\s]+$/", $_POST['kategori'])) {
                $ValidasiTipeData= 'Kategori hanya boleh huruf dan spasi.';
            }else{
                if (!preg_match("/^[a-zA-Z\s]+$/", $_POST['satuan'])) {
                    $ValidasiTipeData='Satuan hanya boleh huruf dan spasi.';
                }else{
                    if(!ctype_alnum($harga)){
                        $ValidasiTipeData='Harga hanya boleh diisi angka.';
                    }else{
                        if(!ctype_alnum($stok)){
                            $ValidasiTipeData='Stok hanya boleh diisi angka.';
                        }else{
                            if (!preg_match('/^(0|[1-9]\d*)(\.\d+)?$/', $berat)) {
                                $ValidasiTipeData='Berat hanya boleh diisi angka desimal';
                            }else{
                                if (!preg_match('/^(0|[1-9]\d*)(\.\d+)?$/', $panjang)) {
                                    $ValidasiTipeData='Panjang hanya boleh diisi angka desimal';
                                }else{
                                    if (!preg_match('/^(0|[1-9]\d*)(\.\d+)?$/', $lebar)) {
                                        $ValidasiTipeData='Lebar hanya boleh diisi angka desimal';
                                    }else{
                                        if (!preg_match('/^(0|[1-9]\d*)(\.\d+)?$/', $tinggi)) {
                                            $ValidasiTipeData='Tinggi hanya boleh diisi angka desimal';
                                        }else{
                                            $ValidasiTipeData='Valid';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if($ValidasiTipeData!=="Valid"){
                $errors[] = $ValidasiTipeData;
            }else{
                //Validasi Foto Barang
                if (empty($_FILES['foto']['name'])) {
                    $ValidasiFoto="File Foto Tidak Boleh Kosong! Setidaknya anda harus menambahkan foto produk untuk kelengkapan data.";
                }else{
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
                }
                if($ValidasiFoto!=="Valid"){
                    $errors[] = $ValidasiFoto;
                }else{
                    $datetime = date('Y-m-d H:i:s');
                    $updatetime = date('Y-m-d H:i:s');
                    //Membuat json dimensi
                    $dimensi_arry = [
                        'berat' => $berat,
                        'panjang' => $panjang,
                        'lebar' => $lebar, 
                        'tinggi' => $tinggi 
                    ];
                    $varian_arry=[];
                    // Mengonversi array menjadi JSON
                    $dimensi = json_encode($dimensi_arry, JSON_PRETTY_PRINT);
                    $varian = json_encode($varian_arry, JSON_PRETTY_PRINT);
                    $marketplace="";
                    // Insert data ke database
                    $query = "INSERT INTO barang (nama_barang, kategori, satuan, harga, stok, dimensi, deskripsi, foto, varian, marketplace, datetime, updatetime) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $Conn->prepare($query);
                    $stmt->bind_param("ssssssssssss", $nama_barang, $kategori, $satuan, $harga, $stok, $dimensi, $deskripsi, $foto, $varian, $marketplace, $datetime, $updatetime);
                    if ($stmt->execute()) {
                        //Menyimpan Log
                        $kategori_log="Merchandise";
                        $deskripsi_log="Tambah Merchandise";
                        $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                        if($InputLog=="Success"){
                            $response['success'] = true;
                            $response['message'] = 'Tambah Merchandise Berhasil';
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