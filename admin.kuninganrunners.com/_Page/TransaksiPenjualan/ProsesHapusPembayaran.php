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
        //Validasi id_transaksi_payment tidak boleh kosong
        if(empty($_POST['id_transaksi_payment'])){
            $errors[] = 'Kode Pembayaran tidak boleh kosong';
        }else{
            //Variabel Lainnya
            $id_transaksi_payment=$_POST['id_transaksi_payment'];
            
            //Proses hapus data
            $HapusTransaksi = mysqli_query($Conn, "DELETE FROM transaksi_payment WHERE id_transaksi_payment='$id_transaksi_payment'") or die(mysqli_error($Conn));
            if ($HapusTransaksi) {
                //Menyimpan Log
                $kategori_log="Transaksi";
                $deskripsi_log="Hapus Pembayaran";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    $response['success'] = true;
                    $response['message'] = 'Hapus Pembayaran Berhasil';
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