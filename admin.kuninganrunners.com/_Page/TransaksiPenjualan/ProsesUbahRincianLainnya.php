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
        if (empty($_POST['kode_transaksi'])) {
            $ValidasiKelengkapanData="Kode Transaksi tidak boleh kosong! Anda wajib mengisi form tersebut.";
        }else{
            $ValidasiKelengkapanData="Valid";
        }
    }
    if($ValidasiKelengkapanData!=="Valid"){
        $errors[] = $ValidasiKelengkapanData;
    }else{
        //Membuat Variabel
        $kode_transaksi=$_POST['kode_transaksi'];
        //Buka Jumlah Tagihan
        $tagihan=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'tagihan');
        if(!empty($_POST['ongkir'])){
            $ongkir=$_POST['ongkir'];
        }else{
            $ongkir=0;
        }
        if(!empty($_POST['ppn_pph_persen'])){
            $ppn_pph_persen=$_POST['ppn_pph_persen'];
            if(!empty($tagihan)){
                $ppn_pph=($ppn_pph_persen/100)*$tagihan;
                $ppn_pph=round($ppn_pph);
            }else{
                $ppn_pph=0;
            }
            
        }else{
            $ppn_pph_persen=0;
            $ppn_pph=0;
        }
        if(!empty($_POST['biaya_layanan'])){
            $biaya_layanan=$_POST['biaya_layanan'];
        }else{
            $biaya_layanan="";
        }

        $jumlah_biaya_lain_lain=0;
        $json_biaya_lain_lain=[];
        $nama_biaya_array = $_POST['nama_biaya'] ?? [];
        $nominal_biaya_array = $_POST['nominal_biaya'] ?? [];
        // Validasi jika kedua array memiliki jumlah elemen yang sama
        if (count($nama_biaya_array) === count($nominal_biaya_array)) {
            $data_biaya = [];
            foreach ($nama_biaya_array as $index => $nama_biaya) {
                $nominal_biaya = $nominal_biaya_array[$index] ?? 0; // Default ke 0 jika tidak ada nilai
                $data_biaya[] = [
                    'nama_biaya' => htmlspecialchars($nama_biaya, ENT_QUOTES, 'UTF-8'),
                    'nominal_biaya' => (float) $nominal_biaya,
                ];
                $jumlah_biaya_lain_lain=$jumlah_biaya_lain_lain+$nominal_biaya;
            }
            $json_biaya_lain_lain=json_encode($data_biaya);
        }else{
            $json_biaya_lain_lain=json_encode($json_biaya_lain_lain);
        }

        $jumlah_potongan_lain_lain=0;
        $json_potongan_lain_lain=[];
        $nama_potongan_array = $_POST['nama_potongan'] ?? [];
        $nominal_potongan_array = $_POST['nominal_potongan'] ?? [];
        // Validasi jika kedua array memiliki jumlah elemen yang sama
        if (count($nama_potongan_array) === count($nominal_potongan_array)) {
            $data_potongan = [];
            foreach ($nama_potongan_array as $index => $nama_potongan) {
                $nominal_potongan = $nominal_potongan_array[$index] ?? 0; // Default ke 0 jika tidak ada nilai
                $data_potongan[] = [
                    'nama_potongan' => htmlspecialchars($nama_potongan, ENT_QUOTES, 'UTF-8'),
                    'nominal_potongan' => (float) $nominal_potongan,
                ];
                $jumlah_potongan_lain_lain=$jumlah_potongan_lain_lain+$nominal_potongan;
            }
            $json_potongan_lain_lain=json_encode($data_potongan);
        } else {
            $json_potongan_lain_lain=json_encode($json_potongan_lain_lain);
        }
        $jumlah_baru=($tagihan+$ongkir+$ppn_pph+$biaya_layanan+$jumlah_biaya_lain_lain)-$jumlah_potongan_lain_lain;
        //Update Transaksi
        $UpdateTransaksi = "UPDATE transaksi SET ongkir = ?, ppn_pph = ?, biaya_layanan = ?, biaya_lainnya = ?, potongan_lainnya = ?, jumlah = ? WHERE kode_transaksi = ?";
        $stmtUpdate = $Conn->prepare($UpdateTransaksi);
        $stmtUpdate->bind_param('sssssss', $ongkir, $ppn_pph, $biaya_layanan, $json_biaya_lain_lain, $json_potongan_lain_lain, $jumlah_baru, $kode_transaksi);
        if ($stmtUpdate->execute()) {
            $ValidasiProses="Valid";
        }else{
            $ValidasiProses= 'Terjadi kesalahan pada saat update status transaksi';
        }
        if($ValidasiProses=="Valid"){
            //Apabila Proses Berhasil Simpan Log
            $kategori_log="Transaksi Penjualan";
            $deskripsi_log="Edit Rincian Lain Transaksi";
            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
            if($InputLog=="Success"){
                $response['success'] = true;
                $response['message'] = 'Edit Rincian Transaksi Berhasil';
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