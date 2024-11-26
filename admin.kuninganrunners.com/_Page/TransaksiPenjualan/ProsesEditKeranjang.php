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
        if (empty($_POST['id_transaksi_keranjang'])) {
            $ValidasiKelengkapanData="ID Keranjang tidak boleh kosong! Anda wajib mengisi form tersebut.";
        }else{
            $ValidasiKelengkapanData="Valid";
        }
    }
    if($ValidasiKelengkapanData!=="Valid"){
        $errors[] = $ValidasiKelengkapanData;
    }else{
        //Membuat Variabel
        $id_transaksi_keranjang=$_POST['id_transaksi_keranjang'];
        if(empty($_POST['qty'])){
            $qty="";
        }else{
            $qty=$_POST['qty'];
        }
        if(empty($_POST['id_varian'])){
            $id_varian="";
        }else{
            $id_varian=$_POST['id_varian'];
        }
        $id_barang=GetDetailData($Conn,'transaksi_keranjang','id_transaksi_keranjang',$id_transaksi_keranjang,'id_barang');
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
            //Apabila QTY Ada Maka Update
            if(!empty($qty)){
                $updateQuery = "UPDATE transaksi_keranjang SET id_varian = ?, qty = ? WHERE id_transaksi_keranjang = ?";
                $stmtUpdate = $Conn->prepare($updateQuery);
                $stmtUpdate->bind_param('sss', $id_varian, $qty, $id_transaksi_keranjang);
                if ($stmtUpdate->execute()) {
                    $ValidasiProses="Valid";
                }else{
                    $ValidasiProses= 'Terjadi kesalahan pada saat update keranjang';
                }
            }else{
                //Apabila Qty Kosong Maka Hapus
                $HapusKeranjang = mysqli_query($Conn, "DELETE FROM transaksi_keranjang WHERE id_transaksi_keranjang='$id_transaksi_keranjang'") or die(mysqli_error($Conn));
                if ($HapusKeranjang) {
                    $ValidasiProses="Valid";
                }else{
                    $ValidasiProses= 'Terjadi Kesalahan Pada Saat Menghapus Item Keranjang';
                }
            }
            if($ValidasiProses=="Valid"){
                //Apabila Proses Berhasil Simpan Log
                $kategori_log="Transaksi Penjualan";
                $deskripsi_log="Edit Keranjang";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    $response['success'] = true;
                    $response['message'] = 'Edit Keranjang Berhasil';
                }else{
                    $errors[] = 'Terjadi Kesalahan Pada Saat Menyimpan Log';
                }
            }else{
                $errors[] = "$ValidasiProses";
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