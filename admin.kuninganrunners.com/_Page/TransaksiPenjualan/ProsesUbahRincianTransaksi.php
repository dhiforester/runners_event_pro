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
        if (empty($_POST['id_transaksi_rincian'])) {
            $ValidasiKelengkapanData="ID Rincian Transaksi tidak boleh kosong! Anda wajib mengisi form tersebut.";
        }else{
            $ValidasiKelengkapanData="Valid";
        }
    }
    if($ValidasiKelengkapanData!=="Valid"){
        $errors[] = $ValidasiKelengkapanData;
    }else{
        //Membuat Variabel
        $id_transaksi_rincian=$_POST['id_transaksi_rincian'];
        if(empty($_POST['qty'])){
            $qty=0;
        }else{
            $qty=$_POST['qty'];
        }
        if(empty($_POST['id_varian'])){
            $id_varian="";
        }else{
            $id_varian=$_POST['id_varian'];
        }
        $id_barang=GetDetailData($Conn,'transaksi_rincian','id_transaksi_rincian',$id_transaksi_rincian,'id_barang');
        $kode_transaksi=GetDetailData($Conn,'transaksi_rincian','id_transaksi_rincian',$id_transaksi_rincian,'kode_transaksi');
        $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
        $stok=GetDetailData($Conn,'barang','id_barang',$id_barang,'stok');
        $varian=GetDetailData($Conn,'barang','id_barang',$id_barang,'varian');
        $varian_json=[];
        if(!empty($varian)){
            $varian_array=json_decode($varian, true);
            if(!empty(count($varian_array))){
                //Apabila Item Barang Memiliki Varian Maka id_varian menjadi wajib
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
                                $nama_varian = $item['nama_varian'];
                                $harga = $item['harga_varian'];
                                $varian_json=[
                                    "id_varian"=>$id_varian,
                                    "nama_varian"=>$nama_varian
                                ];
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
        $varian_json=json_encode($varian_json);
        if( $validasi_varian!=="Valid"){
            $errors[] = "$validasi_varian";
        }else{
            //Buka Member
            $jumlah=$qty*$harga;
            //Apabila QTY Dikosongkan Maka Hapus Rinccian
            if(empty($qty)){
                $HapusRincianTransaksi = mysqli_query($Conn, "DELETE FROM transaksi_rincian WHERE id_transaksi_rincian='$id_transaksi_rincian'") or die(mysqli_error($Conn));
                if ($HapusRincianTransaksi) {
                    $validasi_proses_rincian="Valid";
                }else{
                    $validasi_proses_rincian= 'Terjadi kesalahan pada saat menghapus rincian transaksi';
                }
            }else{
                //Apabila Ada Maka Update Tambah QTY
                $updateQuery = "UPDATE transaksi_rincian SET qty = ?, harga = ?, jumlah = ? WHERE id_transaksi_rincian = ?";
                $stmtUpdate = $Conn->prepare($updateQuery);
                $stmtUpdate->bind_param('ssss', $qty, $harga, $jumlah, $id_transaksi_rincian);
                if ($stmtUpdate->execute()) {
                    $validasi_proses_rincian="Valid";
                }else{
                    $validasi_proses_rincian= "Terjadi kesalahan saat update ke rincian transaksi";
                }
            }
            if($validasi_proses_rincian!=="Valid"){
                $errors[] = $validasi_proses_rincian;
            }else{
                //Apabila Proses Insert/Update database transaksi_rincian berhasil maka lakukan perhitungan ulang transaksi
                $tagihan_lama=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'tagihan');
                $jumlah_transaksi=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'jumlah');
                $ongkir=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'ongkir');
                $ppn_pph=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'ppn_pph');
                $biaya_layanan=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'biaya_layanan');
                $biaya_lainnya=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'biaya_lainnya');
                $potongan_lainnya=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'potongan_lainnya');
                
                //Jumlah Rincian
                $sql = "SELECT SUM(jumlah) AS total_jumlah FROM transaksi_rincian WHERE kode_transaksi = ?";
                $stmt = $Conn->prepare($sql);
                $stmt->bind_param("s", $kode_transaksi); // Bind parameter kode_transaksi
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $tagihan_baru = $row['total_jumlah'] ?? 0;
                } else {
                    $tagihan_baru=0;
                }
                //hitung persentase ppn
                if(!empty($ppn_pph)){
                    if(!empty($tagihan_lama)){
                        $persen_ppn=($ppn_pph/$tagihan_lama)*100;
                        $persen_ppn=round($persen_ppn);
                    }else{
                        $persen_ppn=0;
                    }
                }else{
                    $persen_ppn=0;
                }
                //Hitung ppn baru
                if(!empty($persen_ppn)){
                    $ppn_pph_baru=$tagihan_baru*($persen_ppn/100);
                }else{
                    $ppn_pph_baru=0;
                }
                //menghitung biaya lain-lain
                if(!empty($biaya_lainnya)){
                    $biaya_lainnya_arry=json_decode($biaya_lainnya,true);
                    if(!empty(count($biaya_lainnya_arry))){
                        $biaya_lainnya_baru=0;
                        foreach($biaya_lainnya_arry as $biaya_lainnya_list){
                            $nominal_biaya=$biaya_lainnya_list['nominal_biaya'];
                            $biaya_lainnya_baru=$biaya_lainnya_baru+$nominal_biaya;
                        }
                    }else{
                        $biaya_lainnya_baru=0;
                    }
                }else{
                    $biaya_lainnya_baru=0;
                }
                //Menghiutng Potongan lain-lain
                if(!empty($potongan_lainnya)){
                    $potongan_lainnya_arry=json_decode($potongan_lainnya,true);
                    if(!empty(count($potongan_lainnya_arry))){
                        $potongan_lainnya_baru=0;
                        foreach($potongan_lainnya_arry as $potongan_lainnya_list){
                            $nominal_potongan=$potongan_lainnya_list['nominal_potongan'];
                            $potongan_lainnya_baru=$potongan_lainnya_baru+$nominal_potongan;
                        }
                    }else{
                        $potongan_lainnya_baru=0;
                    }
                }else{
                    $potongan_lainnya_baru=0;
                }
                //Akumulasikan
                if(empty($ongkir)){
                    $ongkir=0;
                }else{
                    $ongkir=$ongkir;
                }
                $jumlah=($tagihan_baru+$ongkir+$ppn_pph_baru+$biaya_lainnya_baru)-$potongan_lainnya_baru;
                //Update Transaksi
                $updateQuery = "UPDATE transaksi SET tagihan = ?, ppn_pph = ?, jumlah = ? WHERE kode_transaksi = ?";
                $stmtUpdate = $Conn->prepare($updateQuery);
                $stmtUpdate->bind_param('ssss', $tagihan_baru, $ppn_pph_baru, $jumlah, $kode_transaksi);
                if ($stmtUpdate->execute()) {
                    //Menyimpan Log
                    $kategori_log="Transaksi Penjualan";
                    $deskripsi_log="Ubah Rincian Transaksi";
                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                    if($InputLog=="Success"){
                        $response['success'] = true;
                        $response['message'] = 'Ubah Rincian Berhasil';
                    }else{
                        $errors[] = 'Terjadi Kesalahan Pada Saat Menyimpan Log';
                    }
                }else{
                    $errors[]= "Terjadi kesalahan saat update data transaksi";
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