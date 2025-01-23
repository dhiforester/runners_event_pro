<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Pendafataran Event";
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

                // Validasi kelengkapan data tidak boleh kosong
                if (!isset($Tangkap['email'])) {
                    $keterangan = "Email Tidak Boleh Kosong";
                } else if (!isset($Tangkap['id_member_login'])) {
                    $keterangan = "ID Member Login Tidak Boleh Kosong";
                } else if (!isset($Tangkap['id_event'])) {
                    $keterangan = "ID Event Tidak Boleh Kosong";
                } else if (!isset($Tangkap['id_event_kategori'])) {
                    $keterangan = "Kategori Event Tidak Boleh Kosong";
                } else {
                    // Buat Variabel
                    $xtoken = validateAndSanitizeInput($headers['x-token']);
                    $email = validateAndSanitizeInput($Tangkap['email']);
                    $id_member_login = validateAndSanitizeInput($Tangkap['id_member_login']);
                    $id_event = validateAndSanitizeInput($Tangkap['id_event']);
                    $id_event_kategori = validateAndSanitizeInput($Tangkap['id_event_kategori']);
                    //Validasi Tipe Dan Karakter Data
                    if (strlen($Tangkap['id_event']) > 36) { 
                        $ValidasiJumlahKarakter= 'ID Event Tidak Valid Karena Terlalu Panjang'; 
                    }else{
                        $ValidasiJumlahKarakter='Valid'; 
                    }
                    if($ValidasiJumlahKarakter!=="Valid"){
                        $keterangan = $ValidasiJumlahKarakter;
                    }else{
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
                                $id_api_session = $DataValidasiToken['id_api_session'];
                                $id_setting_api_key = $DataValidasiToken['id_setting_api_key'];
                                $title_api_key = GetDetailData($Conn, 'setting_api_key', 'id_setting_api_key', $id_setting_api_key, 'title_api_key');
                                
                                // Validasi Email dan Password
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
                                        //Validasi id_event
                                        $ValidasiEvent=GetDetailData($Conn, 'event', 'id_event', $id_event, 'id_event');
                                        if(empty($ValidasiEvent)){
                                            $keterangan="ID Event Tidak Valid";
                                        }else{
                                            //Validasi Kategori Event
                                            $ValidasiKategoriEvent=GetDetailData($Conn, 'event_kategori', 'id_event_kategori', $id_event_kategori, 'id_event');
                                            if(empty($ValidasiKategoriEvent)){
                                                $keterangan="ID Kategori Event Tidak Valid";
                                            }else{
                                                //Validasi Event Dan Kesesuain dengan kategori
                                                if($ValidasiKategoriEvent!==$ValidasiEvent){
                                                    $keterangan="Kategori Event Tidak Sesuai Dengan Event";
                                                }else{
                                                    //Validasi Waktu Pendaftaran Event
                                                    $mulai_pendaftaran=GetDetailData($Conn, 'event', 'id_event', $id_event, 'mulai_pendaftaran');
                                                    $selesai_pendaftaran=GetDetailData($Conn, 'event', 'id_event', $id_event, 'selesai_pendaftaran');
                                                    if($now<$mulai_pendaftaran){
                                                        $keterangan="Pendaftaran Event Tersebut Belum Dimulai";
                                                    }else{
                                                        if($now>$selesai_pendaftaran){
                                                            $keterangan="Pendaftaran Event Tersebut Sudah Berakhir";
                                                        }else{
                                                            $id_member=$DataMember['id_member'];
                                                            $nama=GetDetailData($Conn, 'member', 'id_member', $id_member, 'nama');
                                                            $email=GetDetailData($Conn, 'member', 'id_member', $id_member, 'email');
                                                            $biaya_pendaftaran=GetDetailData($Conn, 'event_kategori', 'id_event_kategori', $id_event_kategori, 'biaya_pendaftaran');
                                                            if(empty($biaya_pendaftaran)){
                                                                $biaya_pendaftaran=0;
                                                            }
                                                            if($biaya_pendaftaran=="0"){
                                                                $status="Lunas";
                                                            }else{
                                                                $status="Pending";
                                                            } 
                                                            $id_event_peserta=GenerateToken(36);
                                                            
                                                            //Validasi Duplikat Data
                                                            $ValidasiDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_peserta FROM event_peserta WHERE id_event='$id_event' AND id_member='$id_member'"));
                                                            if(!empty($ValidasiDuplikat)){
                                                                $keterangan="Member Tersebut Sudah Terdaftar Sebelumnya Pada Event Yang Sama";
                                                            }else{
                                                                $keterangan="Proses Tambah event_peserta";
                                                                // Insert data ke database 'event_peserta'
                                                                $query = "INSERT INTO event_peserta (
                                                                    id_event_peserta, 
                                                                    id_event, 
                                                                    id_event_kategori, 
                                                                    id_member, 
                                                                    nama, 
                                                                    email, 
                                                                    biaya_pendaftaran, 
                                                                    datetime, 
                                                                    status
                                                                ) 
                                                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                                                $stmt = $Conn->prepare($query);
                                                                $stmt->bind_param(
                                                                    "sssssssss", 
                                                                    $id_event_peserta, 
                                                                    $id_event, 
                                                                    $id_event_kategori, 
                                                                    $id_member, 
                                                                    $nama, 
                                                                    $email, 
                                                                    $biaya_pendaftaran, 
                                                                    $now, 
                                                                    $status
                                                                );
                                                                if ($stmt->execute()) {
                                                                    
                                                                    //Persiapan Untuk Input Data Transaksi
                                                                    $kategori_transaksi="Pendaftaran";
                                                                    $kontak=GetDetailData($Conn, 'member', 'id_member', $id_member, 'kontak');
                                                                    $kode_transaksi=GenerateToken(36);
                                                                     //Pisahkan Nama
                                                                    $parts = explode(" ", $nama);
                                                                    $first_name = $parts[0];
                                                                    $last_name = isset($parts[1]) ? $parts[1] : '';
                                                                     //Buka Alamat
                                                                    $provinsi=GetDetailData($Conn, 'member', 'id_member', $id_member, 'provinsi');
                                                                    $kabupaten=GetDetailData($Conn, 'member', 'id_member', $id_member, 'kabupaten');
                                                                    $kecamatan=GetDetailData($Conn, 'member', 'id_member', $id_member, 'kecamatan');
                                                                    $desa=GetDetailData($Conn, 'member', 'id_member', $id_member, 'desa');
                                                                    $kode_pos=GetDetailData($Conn, 'member', 'id_member', $id_member, 'kode_pos');
                                                                    $rt_rw=GetDetailData($Conn, 'member', 'id_member', $id_member, 'rt_rw');
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
                                                                    
                                                                    //Atur Ongkir PPN dan Biaya lain-lain
                                                                    $ongkir=0;
                                                                    
                                                                    //Buka Pengaturan transaksi
                                                                    $ppn_pph_pendaftaran=GetDetailData($Conn,'setting_transaksi','kategori ','Pendaftaran','ppn_pph');
                                                                    $biaya_layanan_pendaftaran=GetDetailData($Conn,'setting_transaksi','kategori ','Pendaftaran','biaya_layanan');
                                                                    $potongan_lainnya_pendaftaran=GetDetailData($Conn,'setting_transaksi','kategori ','Pendaftaran','potongan_lainnya');
                                                                    $biaya_lainnya_pendaftaran=GetDetailData($Conn,'setting_transaksi','kategori ','Pendaftaran','biaya_lainnya');
                                                                    if(empty($biaya_layanan_pendaftaran)){
                                                                        $biaya_layanan_pendaftaran=0;
                                                                    }
                                                                    //Hitung PPN dari 'biaya_pendaftaran'
                                                                    if(!empty($ppn_pph_pendaftaran)){
                                                                        if(empty($biaya_pendaftaran)){
                                                                            $ppn_pph_rp=0;
                                                                        }else{
                                                                            $ppn_pph_rp=$biaya_pendaftaran*($ppn_pph_pendaftaran/100);
                                                                            $ppn_pph_rp=round($ppn_pph_rp);
                                                                        }
                                                                    }else{
                                                                        $ppn_pph_rp=0;
                                                                    }
                                                                
                                                                    //Menghitung Potongan Lainnya
                                                                    if(!empty($potongan_lainnya_pendaftaran)){
                                                                        $potongan_lainnya_rp=0;
                                                                        $potongan_lainnya_pendaftaran_arry=json_decode($potongan_lainnya_pendaftaran, true);
                                                                        if(empty(count( $potongan_lainnya_pendaftaran_arry))){
                                                                            $potongan_lainnya_rp=0;
                                                                        }else{
                                                                            foreach ($potongan_lainnya_pendaftaran_arry as $potongan_lainnya_pendaftaran_list) {
                                                                                $nominal_potongan=$potongan_lainnya_pendaftaran_list['nominal_potongan'];
                                                                                $potongan_lainnya_rp=$potongan_lainnya_rp+$nominal_potongan;
                                                                            }
                                                                        }
                                                                    }else{
                                                                        $potongan_lainnya_rp=0;
                                                                    }
                                                                    //Menghitung Biaya Lainnya
                                                                    if(!empty($biaya_lainnya_pendaftaran)){
                                                                        $biaya_lainnya_rp=0;
                                                                        $biaya_lainnya_pendaftaran_arry=json_decode($biaya_lainnya_pendaftaran, true);
                                                                        if(empty(count($biaya_lainnya_pendaftaran_arry))){
                                                                            $biaya_lainnya_rp=0;
                                                                        }else{
                                                                            foreach ($biaya_lainnya_pendaftaran_arry as $biaya_lainnya_pendaftaran_list) {
                                                                                $nominal_biaya=$biaya_lainnya_pendaftaran_list['nominal_biaya'];
                                                                                $biaya_lainnya_rp=$biaya_lainnya_rp+$nominal_biaya;
                                                                            }
                                                                        }
                                                                        
                                                                    }else{
                                                                        $biaya_lainnya_rp=0;
                                                                    }

                                                                    //Menghitung Subtotal
                                                                    $subtotal=($biaya_pendaftaran+$ppn_pph_rp+$biaya_layanan_pendaftaran+$biaya_lainnya_rp)-$potongan_lainnya_rp;
                                                                    $pengiriman="";
                                                                    
                                                                    //Simpan Transaksi
                                                                    $query_transaksi = "INSERT INTO transaksi (
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
                                                                        pengiriman,
                                                                        status
                                                                    ) 
                                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                                                    $stmt_transaksi = $Conn->prepare($query_transaksi);
                                                                    $stmt_transaksi->bind_param(
                                                                        "ssssssssssssss", 
                                                                        $id_event_peserta, 
                                                                        $id_member, 
                                                                        $raw_member, 
                                                                        $kategori_transaksi, 
                                                                        $now, 
                                                                        $biaya_pendaftaran, 
                                                                        $ongkir, 
                                                                        $ppn_pph_rp, 
                                                                        $biaya_layanan_pendaftaran, 
                                                                        $biaya_lainnya_pendaftaran, 
                                                                        $potongan_lainnya_pendaftaran, 
                                                                        $subtotal, 
                                                                        $pengiriman, 
                                                                        $status
                                                                    );
                                                                    if ($stmt_transaksi->execute()) {
                                                                        $metadata= [
                                                                            "id_event_peserta" => $id_event_peserta,
                                                                            "id_event" => $id_event,
                                                                            "id_event_kategori" => $id_event_kategori,
                                                                            "id_member" => $id_member,
                                                                            "nama" => $nama,
                                                                            "email" => $email,
                                                                            "biaya_pendaftaran" => $biaya_pendaftaran,
                                                                            "datetime" => $now,
                                                                            "status" => $status
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
                                                                    }else{
                                                                        //Apabila gagal menyimpan transaksi maka hapus juga data 'event_peserta'
                                                                        $HapusPendaftaran = mysqli_query($Conn, "DELETE FROM event_peserta WHERE id_event_peserta='$id_event_peserta'") or die(mysqli_error($Conn));
                                                                        $keterangan = "Terjadi kesalahan saat menyimpan data pembayaran ke database";
                                                                    }
                                                                } else {
                                                                    $keterangan = "Terjadi kesalahan saat menyimpan ke database";
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $keterangan = "Kombinasi Password Dan Email Tidak Valid";
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
