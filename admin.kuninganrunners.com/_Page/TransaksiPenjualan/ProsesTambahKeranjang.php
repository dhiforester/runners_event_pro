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
            if (empty($_POST['id_member'])) {
                $ValidasiKelengkapanData="ID Member tidak boleh kosong! Anda wajib mengisi form tersebut.";
            }else{
                if (empty($_POST['qty'])) {
                    $ValidasiKelengkapanData="Banyaknya barang tidak boleh kosong! Anda wajib mengisi form tersebut.";
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
        $id_member=$_POST['id_member'];
        $qty=$_POST['qty'];
        if(empty($_POST['id_varian'])){
            $id_varian="";
        }else{
            $id_varian=$_POST['id_varian'];
        }
        $stok=GetDetailData($Conn,'barang','id_barang',$id_barang,'stok');
        $varian=GetDetailData($Conn,'barang','id_barang',$id_barang,'varian');
        if(!empty($varian)){
            $varian_array=json_decode($varian, true);
            if(!empty(count($varian_array))){
                //Apabila Item Barang Memiliki Varian Maka id_bvarian menjadi wajib
                if(empty($id_varian)){
                    $validasi_varian="Anda Harus Memilih Diantara Varian Yang Ada";
                }else{
                    //Cek Apakah id_varian yang dipilih terdaftar
                    $varian_array = json_decode($varian, true);
                    $id_varian_list = array_column($varian_array, 'id_varian');
                    // Periksa apakah id_varian_cek ada dalam daftar id_varian
                    if (in_array($id_varian, $id_varian_list)) {
                        //Validasi Stok Varian
                        $stok_varian = 0;
                        foreach ($varian_array as $item) {
                            if ($item['id_varian'] === $id_varian) {
                                $stok_varian = $item['stok_varian'];
                                break;
                            }
                        }
                        if($qty>$stok_varian){
                            $validasi_varian="Stok varian yang anda pilih tidak memenuhi";
                        }else{
                            $validasi_varian="Valid";
                        }
                    } else {
                        $validasi_varian="ID varian $id_varian tidak ditemukan.";
                    }
                }
            }else{
                //Apabila Tidak Ada Varian Cek Stok Barang
                if($qty>$stok){
                    $validasi_varian="Stok barang yang anda pilih tidak memenuhi";
                }else{
                    $validasi_varian="Valid";
                }
            }
        }else{
            //Apabila Tidak Ada Varian Cek Stok Barang
            if($qty>$stok){
                $validasi_varian="Stok barang yang anda pilih tidak memenuhi";
            }else{
                $validasi_varian="Valid";
            }
        }
        if( $validasi_varian!=="Valid"){
            $errors[] = "$validasi_varian";
        }else{
            // Cek Apakah Ada Item Keranjang Untuk Member Ini dan Barang Ini Sudah Ada
            $QryParam = mysqli_query($Conn,"SELECT id_transaksi_keranjang, qty FROM transaksi_keranjang WHERE id_barang='$id_barang' AND id_member='$id_member' AND id_varian='$id_varian'")or die(mysqli_error($Conn));
            $DataParam = mysqli_fetch_array($QryParam);
            if(empty($DataParam['id_transaksi_keranjang'])){
                // Insert data ke database
                $query = "INSERT INTO transaksi_keranjang (
                    id_barang, 
                    id_member, 
                    id_varian, 
                    qty
                ) VALUES (?, ?, ?, ?)";
                $stmt = $Conn->prepare($query);
                $stmt->bind_param("ssss", $id_barang, $id_member, $id_varian, $qty);
                if ($stmt->execute()) {
                    //Menyimpan Log
                    $kategori_log="Transaksi Penjualan";
                    $deskripsi_log="Tambah Keranjang";
                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                    if($InputLog=="Success"){
                        $response['success'] = true;
                        $response['message'] = 'Tambah Keranjang Berhasil';
                    }else{
                        $errors[] = 'Terjadi Kesalahan Pada Saat Menyimpan Log';
                    }
                }else{
                    $errors[]= 'Gagal menyimpan data, coba lagi.';
                }
            }else{
                //Apabila Sudah Ada Maka Update Tambah QTY
                $id_transaksi_keranjang=$DataParam['id_transaksi_keranjang'];
                $qty=$qty+$DataParam['qty'];
                // Update Data
                $updateQuery = "UPDATE transaksi_keranjang SET qty = ? WHERE id_transaksi_keranjang = ?";
                $stmtUpdate = $Conn->prepare($updateQuery);
                $stmtUpdate->bind_param('ss', $qty, $id_transaksi_keranjang);
                if ($stmtUpdate->execute()) {
                    $response['success'] = true;
                    $response['message'] = 'Tambah Keranjang Berhasil';
                }else{
                    $errors[] = "Terjadi kesalahan saat update ke database";
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