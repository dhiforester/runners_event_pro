<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    // Inisialisasi pesan error
    $response = ['success' => false, 'message' => ''];
    $errors = []; 
    if(empty($SessionIdAkses)){
        $errors[] = 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang';
    }else{
        //Validasi kode_transaksi tidak boleh kosong
        if(empty($_POST['kode_transaksi'])){
            $errors[] = 'Kode Transaksi tidak boleh kosong';
        }else{
            //Variabel Lainnya
            $kode_transaksi=$_POST['kode_transaksi'];
            
            //Proses hapus data
            $HapusTransaksi = mysqli_query($Conn, "DELETE FROM transaksi WHERE kode_transaksi='$kode_transaksi'") or die(mysqli_error($Conn));
            if ($HapusTransaksi) {
                //Menyimpan Log
                $kategori_log="Transaksi";
                $deskripsi_log="Hapus Transaksi";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    $response['success'] = true;
                    $response['message'] = 'Hapus Transaksi Berhasil';
                }else{
                    $errors[] = 'Terjadi Kesalahan Pada Saat Menyimpan Log';
                }
            }else{
                $errors[] = 'Terjadi Kesalahan Pada Saat Menghapus Data Dari Database';
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