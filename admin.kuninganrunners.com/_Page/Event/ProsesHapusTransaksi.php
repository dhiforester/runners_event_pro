<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    $now=date('Y-m-d H:i:s');
    // Inisialisasi pesan error pertama kali
    $response = ['success' => false, 'message' => ''];
    $errors = []; 
    if(empty($SessionIdAkses)){
        $errors[] = 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang!.';
    }else{
        //Validasi kode_transaksi tidak boleh kosong
        if(empty($_POST['kode_transaksi'])){
            $errors[] = 'ID Transaksi tidak boleh kosong!.';
        }else{
            //Variabel Lainnya
            $kode_transaksi=$_POST['kode_transaksi'];
            //Bersihkan Variabel
            $kode_transaksi=validateAndSanitizeInput($kode_transaksi);
            //Proses hapus data Transaksi
            $HapusTransaksi = mysqli_query($Conn, "DELETE FROM transaksi WHERE kode_transaksi='$kode_transaksi'") or die(mysqli_error($Conn));
            if ($HapusTransaksi) {
                $kategori_log="Event";
                $deskripsi_log="Hapus Transaksi Event";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    $response['success'] = true;
                }else{
                    $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                }
            }else{
                $errors[] = 'Terjadi kesalahan pada saat menghapus data transaksi pada database!.';
            }
        }
    }
    if (!empty($errors)) {
        $response['message'] = implode('<br>', $errors);
        echo json_encode($response);
        exit;
    }else{
        echo json_encode($response);
    }
?>