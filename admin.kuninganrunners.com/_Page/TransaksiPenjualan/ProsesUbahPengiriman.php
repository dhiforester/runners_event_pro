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
            // Validasi data input tidak boleh kosong
            if (empty($_POST['status_pengiriman'])) {
                $ValidasiKelengkapanData="Status Pengiriman tidak boleh kosong! Anda wajib mengisi form tersebut.";
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
        $status_pengiriman=$_POST['status_pengiriman'];
        //Buat Variabel Lainnya
        $no_resi = !empty($_POST['no_resi']) ? $_POST['no_resi'] : "";
        $kurir = !empty($_POST['kurir']) ? $_POST['kurir'] : "";
        //Asal Pengiriman
        $asal_pengiriman_nama = !empty($_POST['asal_pengiriman_nama']) ? $_POST['asal_pengiriman_nama'] : "";
        $asal_pengiriman_provinsi = !empty($_POST['asal_pengiriman_provinsi']) ? $_POST['asal_pengiriman_provinsi'] : "";
        $asal_pengiriman_kabupaten = !empty($_POST['asal_pengiriman_kabupaten']) ? $_POST['asal_pengiriman_kabupaten'] : "";
        $asal_pengiriman_kecamatan = !empty($_POST['asal_pengiriman_kecamatan']) ? $_POST['asal_pengiriman_kecamatan'] : "";
        $asal_pengiriman_desa = !empty($_POST['asal_pengiriman_desa']) ? $_POST['asal_pengiriman_desa'] : "";
        $asal_pengiriman_rt_rw = !empty($_POST['asal_pengiriman_desa']) ? $_POST['asal_pengiriman_rt_rw'] : "";
        $asal_pengiriman_kode_pos = !empty($_POST['asal_pengiriman_kode_pos']) ? $_POST['asal_pengiriman_kode_pos'] : "";
        $asal_pengiriman_kontak = !empty($_POST['asal_pengiriman_kontak']) ? $_POST['asal_pengiriman_kontak'] : "";
        $asal_pengiriman=[
            "nama"=>$asal_pengiriman_nama,
            "provinsi"=>$asal_pengiriman_provinsi,
            "kabupaten"=>$asal_pengiriman_kabupaten,
            "kecamatan"=>$asal_pengiriman_kecamatan,
            "desa"=>$asal_pengiriman_desa,
            "rt_rw"=>$asal_pengiriman_rt_rw,
            "kode_pos"=>$asal_pengiriman_kode_pos,
            "kontak"=>$asal_pengiriman_kontak,
        ];
        $asal_pengiriman=json_encode($asal_pengiriman);
        //Tujuan Pengiriman
        $tujuan_pengiriman_nama = !empty($_POST['tujuan_pengiriman_nama']) ? $_POST['tujuan_pengiriman_nama'] : "";
        $tujuan_pengiriman_provinsi = !empty($_POST['tujuan_pengiriman_provinsi']) ? $_POST['tujuan_pengiriman_provinsi'] : "";
        $tujuan_pengiriman_kabupaten = !empty($_POST['tujuan_pengiriman_kabupaten']) ? $_POST['tujuan_pengiriman_kabupaten'] : "";
        $tujuan_pengiriman_kecamatan = !empty($_POST['tujuan_pengiriman_kecamatan']) ? $_POST['tujuan_pengiriman_kecamatan'] : "";
        $tujuan_pengiriman_desa = !empty($_POST['tujuan_pengiriman_desa']) ? $_POST['tujuan_pengiriman_desa'] : "";
        $tujuan_pengiriman_rt_rw = !empty($_POST['tujuan_pengiriman_rt_rw']) ? $_POST['tujuan_pengiriman_rt_rw'] : "";
        $tujuan_pengiriman_kode_pos = !empty($_POST['tujuan_pengiriman_kode_pos']) ? $_POST['tujuan_pengiriman_kode_pos'] : "";
        $tujuan_pengiriman_kontak = !empty($_POST['tujuan_pengiriman_kontak']) ? $_POST['tujuan_pengiriman_kontak'] : "";
        $tujuan_pengiriman=[
            "nama"=>$tujuan_pengiriman_nama,
            "provinsi"=>$tujuan_pengiriman_provinsi,
            "kabupaten"=>$tujuan_pengiriman_kabupaten,
            "kecamatan"=>$tujuan_pengiriman_kecamatan,
            "desa"=>$tujuan_pengiriman_desa,
            "rt_rw"=>$tujuan_pengiriman_rt_rw,
            "kode_pos"=>$tujuan_pengiriman_kode_pos,
            "kontak"=>$tujuan_pengiriman_kontak,
        ];
        $tujuan_pengiriman=json_encode($tujuan_pengiriman);
        //Tanggal Jam Pengiriman
        if(!empty($_POST['tanggal_pengiriman'])){
            $tanggal_pengiriman=$_POST['tanggal_pengiriman'];
        }else{
            $tanggal_pengiriman=date('Y-m-d');
        }
        if(!empty($_POST['jam_pengiriman'])){
            $jam_pengiriman=$_POST['jam_pengiriman'];
        }else{
            $jam_pengiriman=date('H:i:s');
        }
        $datetime_pengiriman="$tanggal_pengiriman $jam_pengiriman";
        //Ongkir
        if(!empty($_POST['ongkir'])){
            $ongkir=$_POST['ongkir'];
        }else{
            $ongkir=0;
        }
        //Ongkir
        if(!empty($_POST['link_pengiriman'])){
            $link_pengiriman=$_POST['link_pengiriman'];
        }else{
            $link_pengiriman=0;
        }
        //Buka Data Transaksi Berdasarkan kode_transaksi
        $tagihan=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'tagihan');
        $ppn_pph=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'ppn_pph');
        $biaya_layanan=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'biaya_layanan');
        $biaya_lainnya=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'biaya_lainnya');
        $potongan_lainnya=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'potongan_lainnya');
        //Hitung Jumlah Biaya Lain-lain
        $jumlah_biaya_lainnya=0;
        $biaya_lainnya_arry=json_decode($biaya_lainnya,true);
        foreach ($biaya_lainnya_arry as $biaya_lainnya_list) {
            $jumlah_biaya_lainnya=$jumlah_biaya_lainnya+$biaya_lainnya_list['nominal_biaya'];
        }
        //Hitung Jumlah Potongan Lain-lain
        $jumlah_potongan_lainnya=0;
        $potongan_lainnya_arry=json_decode($potongan_lainnya,true);
        foreach ($potongan_lainnya_arry as $potongan_lainnya_list) {
            $jumlah_potongan_lainnya=$jumlah_potongan_lainnya+$potongan_lainnya_list['nominal_potongan'];
        }
        //Hitung Ulang Jumlah Transaksi
        $jumlah=($tagihan+$ongkir+$ppn_pph+$biaya_layanan+$jumlah_biaya_lainnya)-$jumlah_potongan_lainnya;
        //Update Transaksi Pengiriman
        $update_transaksi_pengiriman = "UPDATE transaksi_pengiriman SET 
        no_resi = ?, 
        kurir = ?, 
        asal_pengiriman = ?, 
        tujuan_pengiriman = ?, 
        status_pengiriman = ?, 
        datetime_pengiriman = ?, 
        ongkir = ?, 
        link_pengiriman = ? 
        WHERE kode_transaksi = ?";
        $stmtUpdate = $Conn->prepare($update_transaksi_pengiriman);
        $stmtUpdate->bind_param('sssssssss', 
            $no_resi, 
            $kurir, 
            $asal_pengiriman, 
            $tujuan_pengiriman, 
            $status_pengiriman, 
            $datetime_pengiriman, 
            $ongkir, 
            $link_pengiriman,
            $kode_transaksi
        );
        if ($stmtUpdate->execute()) {
            //Apabila Update Pengiriman Berhasil, Lanjutkan Update Jumlah Transaksi dan Nilai Ongkir
            $update_transaksi = "UPDATE transaksi SET 
            ongkir = ?, 
            jumlah = ?
            WHERE kode_transaksi = ?";
            $stmtUpdate2 = $Conn->prepare($update_transaksi);
            $stmtUpdate2->bind_param('sss', 
                $ongkir, 
                $jumlah,
                $kode_transaksi
            );
            if ($stmtUpdate2->execute()) {
                //Apabila Proses Berhasil Simpan Log
                $kategori_log="Transaksi Penjualan";
                $deskripsi_log="Edit Pengiriman";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    $response['success'] = true;
                    $response['message'] = 'Edit Pengiriman Berhasil';
                }else{
                    $errors[] = 'Terjadi Kesalahan Pada Saat Menyimpan Log';
                }
            }else{
                $errors[] ="Terjadi kesalahan pada saat melakukan update transaksi";
            }
        }else{
            $errors[] ="Terjadi kesalahan pada saat melakukan update transaksi pengiriman";
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