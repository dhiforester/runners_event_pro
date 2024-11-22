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
            $ValidasiKelengkapanData="Valid";
        }
    }
    if($ValidasiKelengkapanData!=="Valid"){
        $errors[] = $ValidasiKelengkapanData;
    }else{
        //Membuat Variabel
        $id_barang=$_POST['id_barang'];
        $id_barang = validateAndSanitizeInput($id_barang);
        if(empty($_POST['nama_marketplace'])){
            $nama_marketplace="";
        }else{
            $nama_marketplace=$_POST['nama_marketplace'];
        }
        if(empty($_POST['url_marketplace'])){
            $url_marketplace="";
        }else{
            $url_marketplace=$_POST['url_marketplace'];
        }
        // Pastikan jumlah elemen kedua array sama
        if (count($nama_marketplace) !== count($url_marketplace)) {
            $errors[] = "Form Marketplace Harus Terisi Dengan Benar!";
        }else{
            if(empty($nama_marketplace)){
                $marketplace="";
            }else{
                $jumlah_tidak_valid=0;
                $marketplace=[];
                foreach ($nama_marketplace as $index => $nama) {
                    $nama = $nama_marketplace[$index];
                    $url = $url_marketplace[$index];
                    $nama = validateAndSanitizeInput($nama);
                    $url = validateAndSanitizeInput($url);
                   //Validasi Nama Marketplace
                    if(strlen($nama)>100){
                        $jumlah_tidak_valid=$jumlah_tidak_valid+1;
                    }
                    if(!empty($nama)){
                        $marketplace[]=[
                            "nama_marketplace" => $nama,
                            "url_marketplace" => $url
                        ];
                    }
                }
                $marketplace = json_encode($marketplace, JSON_PRETTY_PRINT);
            }
            //Validasi Tipe Data
            if (!empty($jumlah_tidak_valid)) {
                $errors[] = "Nama Marketplace Tidak Boleh Terlalu Panjang. Maksimal 100 Karakter!";
            }else{
                //Update Ke Database Barang
                $sql = "UPDATE barang SET 
                    marketplace = ? ,
                    updatetime = ? 
                WHERE id_barang = ?";
                // Menyiapkan statement
                $stmt = $Conn->prepare($sql);
                $stmt->bind_param('sss', $marketplace, $now, $id_barang);
                // Eksekusi statement dan cek apakah berhasil
                if ($stmt->execute()) {
                    //Menyimpan Log
                    $kategori_log="Merchandise";
                    $deskripsi_log="Edit Marketplace";
                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                    if($InputLog=="Success"){
                        $response['success'] = true;
                        $response['message'] = 'Update Marketplace Berhasil';
                    }else{
                        $errors[] = 'Terjadi Kesalahan Pada Saat Menyimpan Log';
                    }
                }else{
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