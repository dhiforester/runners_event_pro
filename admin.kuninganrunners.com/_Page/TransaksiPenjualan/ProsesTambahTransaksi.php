<?php
    // Koneksi Dan Pengaturan lainnya
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    
    //Setting Waktu
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    
    // Inisialisasi pesan error
    $response = ['success' => false, 'message' => ''];
    $errors = []; 
    
    // Validasi Kelengkapan Data
    if (empty($SessionIdAkses)) {
        $ValidasiKelengkapanData='Sesi akses sudah berakhir, silahkan login ulang!.';
    }else{
        if (empty($_POST['put_id_member'])) {
            $ValidasiKelengkapanData="ID member tidak boleh kosong! Anda wajib mengisi form tersebut.";
        }else{
            if (empty($_POST['status_transaksi'])) {
                $ValidasiKelengkapanData="Status Transaksi tidak boleh kosong! Anda wajib mengisi form tersebut.";
            }else{
                $ValidasiKelengkapanData="Valid";
            }
        }
    }
    if($ValidasiKelengkapanData!=="Valid"){
        $errors[] = $ValidasiKelengkapanData;
    }else{
        //Membuat Variabel
        $put_id_member=$_POST['put_id_member'];
        $status_transaksi=$_POST['status_transaksi'];
        $kategori_transaksi="Pembelian";
        //Pengiriman
        if(!empty($_POST['no_resi'])){
            $no_resi=$_POST['no_resi'];
        }else{
            $no_resi="";
        }
        if(!empty($_POST['kurir'])){
            $kurir=$_POST['kurir'];
        }else{
            $kurir="";
        }
        if(!empty($_POST['datetime_pengiriman'])){
            $datetime_pengiriman=$_POST['datetime_pengiriman'];
        }else{
            $datetime_pengiriman=$now;
        }
        if(!empty($_POST['link_pengiriman'])){
            $link_pengiriman=$_POST['link_pengiriman'];
        }else{
            $link_pengiriman="";
        }
        //Membuat Data Asal Pengiriman
        $fields = [
            'asal_pengiriman_nama', 
            'asal_pengiriman_provinsi', 
            'asal_pengiriman_kabupaten', 
            'asal_pengiriman_kecamatan', 
            'asal_pengiriman_desa', 
            'asal_pengiriman_rt_rw', 
            'asal_pengiriman_kode_pos', 
            'asal_pengiriman_kontak'
        ];
        foreach ($fields as $field) {
            $$field = !empty($_POST[$field]) ? $_POST[$field] : "";
        }
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
        //Membuat Tujuan Pengiriman
        $fields = [
            'tujuan_pengiriman_nama', 
            'tujuan_pengiriman_provinsi', 
            'tujuan_pengiriman_kabupaten', 
            'tujuan_pengiriman_kecamatan', 
            'tujuan_pengiriman_desa', 
            'tujuan_pengiriman_rt_rw', 
            'tujuan_pengiriman_kode_pos', 
            'tujuan_pengiriman_kontak'
        ];
        foreach ($fields as $field) {
            $$field = !empty($_POST[$field]) ? $_POST[$field] : "";
        }
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
        //Menentukan Ongkir
        if(!empty($_POST['ongkir'])){
            $ongkir=$_POST['ongkir'];
        }else{
            $ongkir=0;
        }
        if(!empty($_POST['status_pengiriman'])){
            $status_pengiriman=$_POST['status_pengiriman'];
        }else{
            $status_pengiriman="Pending";
        }
        //Rincian Pembayaran
        if(!empty($_POST['biaya_layanan'])){
            $biaya_layanan=$_POST['biaya_layanan'];
        }else{
            $biaya_layanan=0;
        }

        //Buat kode transaksi
        $kode_transaksi=GenerateToken(36);

        //Validasi Data Member
        $id_member=GetDetailData($Conn,'member','id_member',$put_id_member,'id_member');
        if(empty($id_member)){
            $errors[] = "ID Member Tidak Valid, Atau Tidak Ditemukan Pada Database";
        }else{
            //Buka Informasi Member
            $nama=GetDetailData($Conn, 'member', 'id_member', $id_member, 'nama');
            $email=GetDetailData($Conn, 'member', 'id_member', $id_member, 'email');
            $kontak=GetDetailData($Conn, 'member', 'id_member', $id_member, 'kontak');
            //Buka Alamat
            $provinsi=GetDetailData($Conn, 'member', 'id_member', $id_member, 'provinsi');
            $kabupaten=GetDetailData($Conn, 'member', 'id_member', $id_member, 'kabupaten');
            $kecamatan=GetDetailData($Conn, 'member', 'id_member', $id_member, 'kecamatan');
            $desa=GetDetailData($Conn, 'member', 'id_member', $id_member, 'desa');
            $kode_pos=GetDetailData($Conn, 'member', 'id_member', $id_member, 'kode_pos');
            $rt_rw=GetDetailData($Conn, 'member', 'id_member', $id_member, 'rt_rw');
            //Pisahkan Nama
            $parts = explode(" ", $nama);
            $first_name = $parts[0];
            $last_name = isset($parts[1]) ? $parts[1] : '';
            //Buat Raw Member
            $raw_member = [
                "nama" => $nama,
                "email" => $email,
                "kontak" => $kontak,
                "id_member" => $id_member,
                "last_name" => $last_name,
                "first_name" => $first_name,
                "provinsi" => $provinsi,
                "kabupaten" => $kabupaten,
                "kecamatan" => $kecamatan,
                "desa" => $desa,
                "kode_pos" => $kode_pos,
                "rt_rw" => $rt_rw,
            ];
            $raw_member=json_encode($raw_member);

            //Menghitung Keranjang
            $jumlah_keranjang=mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_keranjang FROM transaksi_keranjang WHERE id_member='$id_member'"));
            if(empty($jumlah_keranjang)){
                $errors[] = "Belum Ada Item Barang pada Keranjang";
            }else{
                $subtotal=0;
                //Membuka Keranjang Berdasarkan id_member
                $query = mysqli_query($Conn, "SELECT*FROM transaksi_keranjang WHERE id_member='$id_member'");
                while ($data = mysqli_fetch_array($query)) {
                    $id_transaksi_keranjang= $data['id_transaksi_keranjang'];
                    $id_barang= $data['id_barang'];
                    $id_varian= $data['id_varian'];
                    $qty= $data['qty'];
                    //Buka Data Barang
                    $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                    $varian=GetDetailData($Conn,'barang','id_barang',$id_barang,'varian');
                    if(!empty($varian)){
                        $varian_arry=json_decode($varian,true);
                        foreach($varian_arry as $varian_list){
                            $id_varian_list=$varian_list['id_varian'];
                            if($id_varian_list==$id_varian){
                                $harga=$varian_list['harga_varian'];
                            }
                        }
                    }
                    //Menghitung Jumlah
                    $jumlah=$qty*$harga;
                    $subtotal=$subtotal+$jumlah;
                }

                //ppn_pph
                if(!empty($_POST['ppn_pph'])){
                    $ppn_pph=$_POST['ppn_pph'];
                    if(!empty($subtotal)){
                        $ppn_pph=$subtotal*($ppn_pph/100);
                        $ppn_pph=round($ppn_pph);
                    }else{
                        $ppn_pph=0;
                    }
                }else{
                    $ppn_pph=0;
                }
                //Biaya Lain-lain
                if(!empty($_POST['nominal_biaya'])){
                    $nominal_biaya=$_POST['nominal_biaya'];
                    $biaya_lainnya=0;
                    foreach ($nominal_biaya as $index => $nominal) {
                        if(!empty($nominal)){
                            $biaya_lainnya=$biaya_lainnya+$nominal;
                        }
                    }
                }else{
                    $biaya_lainnya=0;
                }
                //Potongan Lain-lain
                if(!empty($_POST['nominal_potongan'])){
                    $nominal_potongan=$_POST['nominal_potongan'];
                    $potongan_lainnya=0;
                    foreach ($nominal_potongan as $index => $potongan) {
                        if(!empty($potongan)){
                            $potongan_lainnya=$potongan_lainnya+$potongan;
                        }
                    }
                }else{
                    $potongan_lainnya=0;
                }
                $jumlah_total=($subtotal+$ongkir+$ppn_pph+$biaya_lainnya)-$potongan_lainnya;

                //Membuat Raw Biaya Lainnya
                $biaya_lainnya=[];
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
                    }
                    $biaya_lainnya=json_encode($data_biaya);
                    
                    //Buat RAW Data Potongan
                    $potongan_lainnya=[];
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
                        }
                        $potongan_lainnya=json_encode($data_potongan);
                        $ValidasiStabilitasRaw= "Valid";
                    } else {
                        $ValidasiStabilitasRaw= "Lengkapi Form Potongan Lain-lain dengan benar!";
                    }
                } else {
                    $ValidasiStabilitasRaw= "Lengkapi Form Biaya Lain-lain dengan benar!";
                }

                if($ValidasiStabilitasRaw!=="Valid"){
                    $errors[] = $ValidasiStabilitasRaw;
                }else{
                    //Simpan Transaksi
                    $query = "INSERT INTO transaksi (
                        kode_transaksi, 
                        id_member, 
                        raw_member, 
                        kategori, 
                        datetime,
                        tagihan, 
                        ongkir, 
                        ppn_pph, 
                        biaya_layanan, 
                        biaya_lainnya, 
                        potongan_lainnya, 
                        jumlah,
                        status
                    ) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $Conn->prepare($query);
                    $stmt->bind_param(
                        "sssssssssssss", 
                        $kode_transaksi, 
                        $id_member, 
                        $raw_member, 
                        $kategori_transaksi, 
                        $now, 
                        $subtotal, 
                        $ongkir, 
                        $ppn_pph, 
                        $biaya_layanan, 
                        $biaya_lainnya, 
                        $potongan_lainnya, 
                        $jumlah_total, 
                        $status_transaksi
                    );
                    if ($stmt->execute()) {
                        
                        //Insert Transaksi Pengiriman
                        $query_pengiriman = "INSERT INTO transaksi_pengiriman (
                            kode_transaksi, 
                            no_resi, 
                            kurir, 
                            asal_pengiriman, 
                            tujuan_pengiriman,
                            status_pengiriman, 
                            datetime_pengiriman, 
                            ongkir, 
                            link_pengiriman
                        ) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $Conn->prepare($query_pengiriman);
                        $stmt->bind_param(
                            "sssssssss", 
                            $kode_transaksi, 
                            $no_resi, 
                            $kurir, 
                            $asal_pengiriman, 
                            $tujuan_pengiriman, 
                            $status_pengiriman, 
                            $datetime_pengiriman, 
                            $ongkir, 
                            $link_pengiriman
                        );
                        if ($stmt->execute()) {

                            //Insert Transaksi Payment
                            if(!empty($_POST['link_pembayaran'])){
                                $order_id=GenerateToken(32);
                                $snap_token="";
                                $datetime_pembayaran=$now;
                                if($status_transaksi=="Menunggu"||$status_transaksi=="Pending"){
                                    $status_pembayaran="Pending";
                                }else{
                                    $status_pembayaran="Lunas";
                                }
                                $qry_payment = "INSERT INTO transaksi_payment (
                                    kode_transaksi, 
                                    order_id, 
                                    snap_token, 
                                    datetime, 
                                    status
                                ) 
                                VALUES (?, ?, ?, ?, ?)";
                                $stmt = $Conn->prepare($qry_payment);
                                $stmt->bind_param(
                                    "sssss", 
                                    $kode_transaksi, 
                                    $order_id, 
                                    $snap_token, 
                                    $datetime_pembayaran, 
                                    $status_pembayaran
                                );
                                if ($stmt->execute()) {
                                    $validasi_tambah_pembayaran="Valid";
                                }else{
                                    $validasi_tambah_pembayaran="Terjadi Kesalahan Pada Saat Menyimpan Data Pembayaran";
                                }
                            }else{
                                $validasi_tambah_pembayaran="Valid";
                            }
                            if($validasi_tambah_pembayaran!=="Valid"){
                                $errors[] = $validasi_tambah_pembayaran;
                            }else{
                                
                                //Pindahkan Keranjang ke transaksi_rincian
                                $validasi_proses_keranjang=0;
                                //Membuka Keranjang Berdasarkan id_member
                                $query_keranjang_list = mysqli_query($Conn, "SELECT*FROM transaksi_keranjang WHERE id_member='$id_member'");
                                while ($data_keranjang_lis = mysqli_fetch_array($query_keranjang_list)) {
                                    $id_transaksi_keranjang= $data_keranjang_lis['id_transaksi_keranjang'];
                                    $id_barang= $data_keranjang_lis['id_barang'];
                                    $id_varian= $data_keranjang_lis['id_varian'];
                                    $qty= $data_keranjang_lis['qty'];
                                    //Buka Data Barang
                                    $nama_barang=GetDetailData($Conn,'barang','id_barang',$id_barang,'nama_barang');
                                    $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                                    $varian=GetDetailData($Conn,'barang','id_barang',$id_barang,'varian');
                                    $varian_raw=[];
                                    if(!empty($varian)){
                                        $varian_arry=json_decode($varian,true);
                                        foreach($varian_arry as $varian_list){
                                            $id_varian_list=$varian_list['id_varian'];
                                            if($id_varian_list==$id_varian){
                                                $harga=$varian_list['harga_varian'];
                                                $nama_varian=$varian_list['nama_varian'];
                                            }
                                        }
                                    }
                                    //Buat Json
                                    $varian_raw = [
                                        "id_varian" => $id_varian,
                                        "nama_varian" => $nama_varian
                                    ];
                                    $varian_json=json_encode($varian_raw);
                                    $jumlah=$qty*$harga;
                                    $query = "INSERT INTO transaksi_rincian (
                                        kode_transaksi, 
                                        id_member, 
                                        id_barang, 
                                        nama_barang, 
                                        varian, 
                                        harga,
                                        qty,
                                        jumlah
                                    ) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                                    $stmt = $Conn->prepare($query);
                                    $stmt->bind_param(
                                        "ssssssss", 
                                        $kode_transaksi, 
                                        $id_member, 
                                        $id_barang, 
                                        $nama_barang, 
                                        $varian_json, 
                                        $harga, 
                                        $qty, 
                                        $jumlah
                                    );
                                    if ($stmt->execute()) {
                                        // echo "Transaksi Rincian Berhasil";
                                        $validasi_proses_keranjang=$validasi_proses_keranjang+1;
                                    }else{
                                        echo "Tambah Rincian Gagal<br>";
                                        // echo "Transaksi Rincian Gagal";
                                        $validasi_proses_keranjang=$validasi_proses_keranjang+0;
                                    }
                                }
                                if($validasi_proses_keranjang==$jumlah_keranjang){
                                    //Apabila Berhasil Hapus Keranjang
                                    $HapusKeranjang = mysqli_query($Conn, "DELETE FROM transaksi_keranjang WHERE id_member='$id_member'") or die(mysqli_error($Conn));
                                    if($HapusKeranjang){
                                        //Apabila Proses Berhasil Simpan Log
                                        $kategori_log="Transaksi Penjualan";
                                        $deskripsi_log="Tambah Transaksi Penjualan";
                                        $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                        if($InputLog=="Success"){
                                            $response['kode_transaksi'] = $kode_transaksi;
                                            $response['success'] = true;
                                            $response['message'] = 'Tambah Transaksi Berhasil';
                                        }else{
                                            $errors[] = 'Terjadi Kesalahan Pada Saat Menyimpan Log';
                                        }
                                    }else{
                                        $errors[] = "Terjadi Kesalahan Pada Saat Menyimpan Data Ke Rincian";
                                    }
                                }else{
                                    $errors[] = "Terjadi Kesalahan Pada Saat Menyimpan Data Ke Rincian";
                                }
                            }
                        }else{
                            $errors[] = "Terjadi Kesalahan Pada Saat Menyimpan Data Pengiriman";
                        }
                    }else{
                        $errors[] = "Terjadi Kesalahan Pada Saat Menyimpan Data Transaksi";
                    }
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