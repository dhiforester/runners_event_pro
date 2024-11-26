<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Kirim Pesanan";

    // Setting default response
    $code = 201;
    $keterangan = "Terjadi kesalahan";
    $metadata = [];

    // Validasi Metode Pengiriman Data
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $keterangan = "Metode Pengiriman Data Hanya Boleh Menggunakan POST";
    } else {
        try {
            // Tangkap Header
            $headers = getallheaders();
            
            // Validasi x-token tidak boleh kosong
            if (!isset($headers['x-token'])) {
                $keterangan = "x-token Tidak Boleh Kosong";
            } else {
                // Tangkap data dan decode
                $raw = file_get_contents('php://input');
                $Tangkap = json_decode($raw, true);
                // Validasi email tidak boleh kosong
                if (!isset($Tangkap['email'])) {
                    $keterangan = "Email Tidak Boleh Kosong";
                } else {
                    // Validasi id_member_login tidak boleh kosong
                    if (!isset($Tangkap['id_member_login'])) {
                        $keterangan = "ID Member Login Tidak Boleh Kosong";
                    } else {
                        // Validasi list_keranjang tidak boleh kosong
                        if (!isset($Tangkap['list_keranjang'])) {
                            $keterangan = "ID Barang Tidak Boleh Kosong";
                        } else {
                            // Buat Dalam Bentukk Variabel
                            $xtoken = validateAndSanitizeInput($headers['x-token']);
                            $email = validateAndSanitizeInput($Tangkap['email']);
                            $id_member_login = validateAndSanitizeInput($Tangkap['id_member_login']);
                            $list_keranjang = $Tangkap['list_keranjang'];

                            // Validasi x-token menggunakan prepared statements
                            $stmt = $Conn->prepare("SELECT * FROM api_session WHERE xtoken = ?");
                            $stmt->bind_param("s", $xtoken);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $DataValidasiToken = $result->fetch_assoc();
                            
                            if ($DataValidasiToken) {
                                $datetime_creat = $DataValidasiToken['datetime_creat'];
                                $datetime_expired = $DataValidasiToken['datetime_expired'];
                                
                                // Cek Token Apakah Masih Berlaku
                                if ($now >= $datetime_creat && $now <= $datetime_expired) {
                                    // Validasi berhasil, lanjutkan dengan logika
                                    $id_api_session = $DataValidasiToken['id_api_session'];
                                    $id_setting_api_key = $DataValidasiToken['id_setting_api_key'];
                                    $title_api_key = GetDetailData($Conn, 'setting_api_key', 'id_setting_api_key', $id_setting_api_key, 'title_api_key');
                                    
                                    //Validasi email Dan id_member_login
                                    $stmt = $Conn->prepare("SELECT * FROM member_login WHERE id_member_login = ?");
                                    $stmt->bind_param("s", $id_member_login);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $DataMember = $result->fetch_assoc();
                                    if (!empty($DataMember['id_member'])) {
                                        $id_member=$DataMember['id_member'];
                                        $datetime_expired=$DataMember['datetime_expired'];
                                        //Cek Apakah Sessi Login Sudah Berakhir?
                                        if($datetime_expired<$now){
                                            $keterangan = "Sessi Login Sudah Berakhir";
                                        }else{
                                            //Buka Email Di Database
                                            $email_member=GetDetailData($Conn, 'member', 'id_member', $id_member, 'email');
                                            //Cek Apakah Email Sesuai
                                            if($email_member!==$email){
                                                $keterangan = "Email dengan ID Login Tidak Sesuai ($email_member | $email)";
                                            }else{
                                                //Jumlah Item Keranjang Tidak Boleh Kosong
                                                if(empty(count($list_keranjang))){
                                                    $keterangan = "Tidak Ada Item Keranjang Yang Dipilih";
                                                }else{
                                                    //Validasi ID Keranjang Apakah Sesuai Dengan Id Member
                                                    $validasi_member_keranjang=0;
                                                    foreach ($list_keranjang as $list_keranjang_row) {
                                                        $id_transaksi_keranjang=$list_keranjang_row;
                                                        $id_member_keranjang=GetDetailData($Conn,'transaksi_keranjang','id_transaksi_keranjang',$id_transaksi_keranjang,'id_member');
                                                        if($id_member_keranjang!==$id_member){
                                                            $validasi_member_keranjang=$validasi_member_keranjang+1;
                                                        }
                                                    }
                                                    //Apabila Ada Yang Tidak Sesuai
                                                    if(!empty($validasi_member_keranjang)){
                                                        $keterangan = "Terdapat kesalahan pada salah satu ID Keranjang anda";
                                                    }else{
                                                        //Buat kode transaksi
                                                        $kode_transaksi=GenerateToken(36);
                                                        //Hitung Total Transaksi
                                                        $total=0;
                                                        foreach ($list_keranjang as $list_keranjang_row) {
                                                            //Buka Keranjang
                                                            $id_barang=GetDetailData($Conn,'transaksi_keranjang','id_transaksi_keranjang',$list_keranjang_row,'id_barang');
                                                            $id_varian=GetDetailData($Conn,'transaksi_keranjang','id_transaksi_keranjang',$list_keranjang_row,'id_varian');
                                                            $qty=GetDetailData($Conn,'transaksi_keranjang','id_transaksi_keranjang',$list_keranjang_row,'qty');
                                                            //Buka Varian
                                                            $varian=GetDetailData($Conn,'barang','id_barang',$id_barang,'varian');
                                                            //Jika Ada Varian, Buka Variannya
                                                            if(!empty($id_varian)){
                                                                if(!empty($varian)){
                                                                    $varian_array=json_decode($varian, true);
                                                                    if(!empty(count($varian_array))){
                                                                        //Cek Apakah id_varian yang dipilih terdaftar
                                                                        $varian_array = json_decode($varian, true);
                                                                        $id_varian_list = array_column($varian_array, 'id_varian');
                                                                        // Periksa apakah id_varian_cek ada dalam daftar id_varian
                                                                        if (in_array($id_varian, $id_varian_list)) {
                                                                            //Buka Harga Varian
                                                                            $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                                                                            foreach ($varian_array as $item) {
                                                                                if ($item['id_varian'] === $id_varian) {
                                                                                    $harga = $item['harga_varian'];
                                                                                    break;
                                                                                }
                                                                            }
                                                                        } else {
                                                                            $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                                                                        }
                                                                    }else{
                                                                        $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                                                                    }
                                                                }else{
                                                                    $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                                                                }
                                                            }else{
                                                                $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                                                            }
                                                            $jumlah=$harga*$qty;
                                                            $total=$total+$jumlah;
                                                        }
                                                        //Buka Informasi Member
                                                        $nama=GetDetailData($Conn, 'member', 'id_member', $id_member, 'nama');
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
                                                        $status_transaksi="Menunggu";
                                                        $kategori_transaksi="Pembelian";
                                                        $ongkir=0;
                                                        //Buka Pengaturan transaksi
                                                        $ppn_pph_penjualan=GetDetailData($Conn,'setting_transaksi','kategori ','Penjualan','ppn_pph');
                                                        $biaya_layanan_penjualan=GetDetailData($Conn,'setting_transaksi','kategori ','Penjualan','biaya_layanan');
                                                        $potongan_lainnya_penjualan=GetDetailData($Conn,'setting_transaksi','kategori ','Penjualan','potongan_lainnya');
                                                        $biaya_lainnya_penjualan=GetDetailData($Conn,'setting_transaksi','kategori ','Penjualan','biaya_lainnya');
                                                        //Hitung PPN
                                                        if(!empty($ppn_pph_penjualan)){
                                                            $ppn_pph_rp=$total*($ppn_pph_penjualan/100);
                                                            $ppn_pph_rp=round($ppn_pph_rp);
                                                        }else{
                                                            $ppn_pph_rp=0;
                                                        }
                                                        
                                                        //Menghitung Potongan Lainnya
                                                        if(!empty($potongan_lainnya_penjualan)){
                                                            $potongan_lainnya_rp=0;
                                                            $potongan_lainnya_penjualan_arry=json_decode($potongan_lainnya_penjualan, true);
                                                            foreach ($potongan_lainnya_penjualan_arry as $potongan_lainnya_penjualan_list) {
                                                                $nominal_potongan=$potongan_lainnya_penjualan_list['nominal_potongan'];
                                                                $potongan_lainnya_rp=$potongan_lainnya_rp+$nominal_potongan;
                                                            }
                                                        }else{
                                                            $potongan_lainnya_rp=0;
                                                        }
                                                        //Menghitung Biaya Lainnya
                                                        if(!empty($biaya_lainnya_penjualan)){
                                                            $biaya_lainnya_rp=0;
                                                            $biaya_lainnya_penjualan_arry=json_decode($biaya_lainnya_penjualan, true);
                                                            foreach ($biaya_lainnya_penjualan_arry as $biaya_lainnya_penjualan_list) {
                                                                $nominal_biaya=$biaya_lainnya_penjualan_list['nominal_biaya'];
                                                                $biaya_lainnya_rp=$biaya_lainnya_rp+$nominal_biaya;
                                                            }
                                                        }else{
                                                            $biaya_lainnya_rp=0;
                                                        }
                                                        $subtotal=($total+$ppn_pph_rp+$biaya_layanan_penjualan+$biaya_lainnya_rp)-$potongan_lainnya_rp;
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
                                                            $total, 
                                                            $ongkir, 
                                                            $ppn_pph_rp, 
                                                            $biaya_layanan_penjualan, 
                                                            $biaya_lainnya_penjualan, 
                                                            $potongan_lainnya_penjualan, 
                                                            $subtotal, 
                                                            $status_transaksi
                                                        );
                                                        if ($stmt->execute()) {
                                                            //Apabila Transaksi Berhasil Disimpan, Lanjutkan Proses Simpan Rincian
                                                            $validasi_proses_keranjang=0;
                                                            foreach ($list_keranjang as $list_keranjang_row) {
                                                                //Buka Keranjang
                                                                $id_barang=GetDetailData($Conn,'transaksi_keranjang','id_transaksi_keranjang',$list_keranjang_row,'id_barang');
                                                                $id_varian=GetDetailData($Conn,'transaksi_keranjang','id_transaksi_keranjang',$list_keranjang_row,'id_varian');
                                                                $qty=GetDetailData($Conn,'transaksi_keranjang','id_transaksi_keranjang',$list_keranjang_row,'qty');
                                                                //Buka Item Barang
                                                                $nama_barang=GetDetailData($Conn,'barang','id_barang',$id_barang,'nama_barang');
                                                                $satuan=GetDetailData($Conn,'barang','id_barang',$id_barang,'satuan');
                                                                $stok=GetDetailData($Conn,'barang','id_barang',$id_barang,'stok');
                                                                $dimensi=GetDetailData($Conn,'barang','id_barang',$id_barang,'dimensi');
                                                                $deskripsi=GetDetailData($Conn,'barang','id_barang',$id_barang,'deskripsi');
                                                                $foto=GetDetailData($Conn,'barang','id_barang',$id_barang,'foto');
                                                                $varian=GetDetailData($Conn,'barang','id_barang',$id_barang,'varian');
                                                                //Inisiasi nama_varian
                                                                $nama_varian="";
                                                                //Jika Ada Varian, Buka Variannya
                                                                if(!empty($id_varian)){
                                                                    if(!empty($varian)){
                                                                        $varian_array=json_decode($varian, true);
                                                                        if(!empty(count($varian_array))){
                                                                            //Cek Apakah id_varian yang dipilih terdaftar
                                                                            $varian_array = json_decode($varian, true);
                                                                            $id_varian_list = array_column($varian_array, 'id_varian');
                                                                            // Periksa apakah id_varian_cek ada dalam daftar id_varian
                                                                            if (in_array($id_varian, $id_varian_list)) {
                                                                                //Buka Harga Varian
                                                                                $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                                                                                $nama_varian="";
                                                                                foreach ($varian_array as $item) {
                                                                                    if ($item['id_varian'] === $id_varian) {
                                                                                        $harga = $item['harga_varian'];
                                                                                        $nama_varian=$item['nama_varian'];
                                                                                        break;
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                                                                                $nama_varian="";
                                                                            }
                                                                        }else{
                                                                            $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                                                                            $nama_varian="";
                                                                        }
                                                                    }else{
                                                                        $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                                                                        $nama_varian="";
                                                                    }
                                                                }else{
                                                                    $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                                                                    $nama_varian="";
                                                                }
                                                                //Buat Json
                                                                $uraian_transaksi = [
                                                                    "id_varian" => $id_varian,
                                                                    "nama_varian" => $nama_varian
                                                                ];
                                                                $uraian_transaksi=json_encode($uraian_transaksi);
                                                                //Inser Ke Transaksi Rincian
                                                                $jumlah=$harga*$qty;
                                                                $kategori_transaksi="Pembelian";
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
                                                                    $uraian_transaksi, 
                                                                    $harga, 
                                                                    $qty, 
                                                                    $jumlah
                                                                );
                                                                if ($stmt->execute()) {
                                                                    // echo "Transaksi Rincian Berhasil";
                                                                    $validasi_proses_keranjang=$validasi_proses_keranjang+1;
                                                                }else{
                                                                    // echo "Transaksi Rincian Gagal";
                                                                    $validasi_proses_keranjang=$validasi_proses_keranjang+0;
                                                                }
                                                            }
                                                            //Validasi Apakah Semua Item Keranjang Berhasil Diinput
                                                            if($validasi_proses_keranjang!==count($list_keranjang)){
                                                                $keterangan = "Terjadi kesalahan pada saat memasukan data uraian transaksi";
                                                            }else{
                                                                //Apabila Berhasil Hapus Keranjang 
                                                                foreach ($list_keranjang as $list_keranjang_row) {
                                                                    $HapusKeranjang = mysqli_query($Conn, "DELETE FROM transaksi_keranjang WHERE id_transaksi_keranjang='$list_keranjang_row'") or die(mysqli_error($Conn));
                                                                }
                                                                $metadata = [
                                                                    "id_member" => $id_member,
                                                                    "kode_transaksi" => $kode_transaksi,
                                                                    "status" => $status_transaksi
                                                                ];
                                                                //menyimpan Log
                                                                $SimpanLog = insertLogApi($Conn, $id_setting_api_key, $title_api_key, $service_name, 200, "success", $now);
                                                                if ($SimpanLog !== "Success") {
                                                                    $keterangan = "Gagal Menyimpan Log Service";
                                                                    $code = 201;
                                                                } else {
                                                                    $keterangan = "success";
                                                                    $code = 200;
                                                                }
                                                            }
                                                        }else{
                                                            $keterangan = "Terjadi kesalahan pada saat menyimpan transaksi";
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }else{
                                        $keterangan = "Sessi Login Tidak Ditemukan";
                                    }
                                } else {
                                    $keterangan = "X-Token Yang Digunakan Sudah Tidak Berlaku";
                                }
                            } else {
                                $keterangan = "X-Token Yang Digunakan Tidak Valid";
                            }
                            $stmt->close();
                        }
                    }
                }
            }
        } catch (Exception $e) {
            $keterangan = "Terjadi kesalahan sistem: " . $e->getMessage();
            $code = 500;
        }
    }
    // Menyiapkan respons
    $response = [
        "message" => $keterangan,
        "code" => $code,
    ];

    $Array = [
        "response" => $response,
        "metadata" => $metadata ?? []
    ];

    // Kirim JSON response
    header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + (10 * 60)));
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header('Content-Type: application/json');
    header('Pragma: no-cache');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, x-token, token");
    echo json_encode($Array, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit();
?>
