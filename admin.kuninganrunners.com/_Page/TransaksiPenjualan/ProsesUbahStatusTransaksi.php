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
        if (empty($_POST['status_transaksi'])) {
            $ValidasiKelengkapanData="Status Transaksi tidak boleh kosong! Anda wajib mengisi form tersebut.";
        }else{
            if (empty($_POST['kode_transaksi'])) {
                $ValidasiKelengkapanData="Kode Transaksi tidak boleh kosong! Anda wajib mengisi form tersebut.";
            }else{
                $ValidasiKelengkapanData="Valid";
            }
        }
    }
    if($ValidasiKelengkapanData!=="Valid"){
        $errors[] = $ValidasiKelengkapanData;
    }else{
        //Membuat Variabel
        $kode_transaksi=$_POST['kode_transaksi'];
        $status_transaksi=$_POST['status_transaksi'];
        $UpdateTransaksi = "UPDATE transaksi SET status = ? WHERE kode_transaksi = ?";
        $stmtUpdate = $Conn->prepare($UpdateTransaksi);
        $stmtUpdate->bind_param('ss', $status_transaksi, $kode_transaksi);
        if ($stmtUpdate->execute()) {
            $ValidasiProses="Valid";
        }else{
            $ValidasiProses= 'Terjadi kesalahan pada saat update status transaksi';
        }
        if($ValidasiProses=="Valid"){
            //Apabila Proses Berhasil Simpan Log
            $kategori_log="Transaksi Penjualan";
            $deskripsi_log="Edit Status Transaksi";
            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
            if($InputLog=="Success"){
                $response['success'] = true;
                $response['message'] = 'Edit Status Transaksi Berhasil';
            }else{
                $errors[] = 'Terjadi Kesalahan Pada Saat Menyimpan Log';
            }
        }else{
            $errors[] = "$ValidasiProses";
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