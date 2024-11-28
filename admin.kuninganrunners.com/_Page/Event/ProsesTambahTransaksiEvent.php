<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingEmail.php";
    date_default_timezone_set('Asia/Jakarta');
    $now=date('Y-m-d H:i:s');
    $date=date('Y-m-d');
    $time=date('H:i:s');
    // Inisialisasi pesan error pertama kali
    $response = ['success' => false, 'message' => ''];
    $errors = []; 
    if(empty($SessionIdAkses)){
        $errors[] = 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang!.';
    }else{
        //Validasi id_member tidak boleh kosong
        if(empty($_POST['id_member'])){
            $errors[] = 'ID Member tidak boleh kosong!.';
        }else{
            //Validasi kode_transaksi tidak boleh kosong
            if(empty($_POST['kode_transaksi'])){
                $errors[] = 'Kode transaksi tidak boleh kosong!.';
            }else{
                //Validasi first_name tidak boleh kosong
                if(empty($_POST['first_name'])){
                    $errors[] = 'Nama Depan tidak boleh kosong!.';
                }else{
                    //Validasi email tidak boleh kosong
                    if(empty($_POST['email'])){
                        $errors[] = 'Email tidak boleh kosong!.';
                    }else{
                        //Buat Variabel
                        $id_member=$_POST['id_member'];
                        $kode_transaksi=$_POST['kode_transaksi'];
                        $first_name=$_POST['first_name'];
                        $email=$_POST['email'];
                        if(empty($_POST['kontak'])){
                            $kontak="";
                        }else{
                            $kontak=$_POST['kontak'];
                        }
                        if(empty($_POST['last_name'])){
                            $last_name="";
                            $nama_member="$first_name";
                        }else{
                            $last_name=$_POST['last_name'];
                            $nama_member="$first_name $last_name";
                        }
                        if(empty($_POST['biaya_pendaftaran'])){
                            $biaya_pendaftaran="0";
                        }else{
                            $biaya_pendaftaran=$_POST['biaya_pendaftaran'];
                        }
                        if(!empty($_POST['ppn'])){
                            $ppn=$_POST['ppn'];
                        }else{
                            $ppn=0;
                        }
                        if(!empty($_POST['biaya_layanan'])){
                            $biaya_layanan=$_POST['biaya_layanan'];
                        }else{
                            $biaya_layanan=0;
                        }
                        if(!empty($_POST['kirim_email'])){
                            $kirim_email=$_POST['kirim_email'];
                        }else{
                            $kirim_email="";
                        }
                        //Membuat Raw biaya dan potongan lain-lain
                        $nama_biaya = $_POST['nama_biaya'] ?? []; // Array nama_biaya
                        $nominal_biaya = $_POST['nominal_biaya'] ?? []; // Array nominal_biaya
                        $nama_potongan = $_POST['nama_potongan'] ?? []; // Array nama_potongan
                        $nominal_potongan = $_POST['nominal_potongan'] ?? []; // Array nominal_potongan

                        // Inisialisasi total dan JSON list
                        $total_biaya = 0;
                        $total_potongan = 0;
                        $json_biaya = [];
                        $json_potongan = [];

                        // Proses data biaya
                        foreach ($nama_biaya as $index => $nama) {
                            $nominal = isset($nominal_biaya[$index]) ? (int)$nominal_biaya[$index] : 0;
                            $total_biaya += $nominal;
                            $json_biaya[] = [
                                'nama_biaya' => $nama,
                                'nominal_biaya' => $nominal,
                            ];
                        }

                        // Proses data potongan
                        foreach ($nama_potongan as $index => $nama) {
                            $nominal = isset($nominal_potongan[$index]) ? (int)$nominal_potongan[$index] : 0;
                            $total_potongan += $nominal;
                            $json_potongan[] = [
                                'nama_potongan' => $nama,
                                'nominal_potongan' => $nominal,
                            ];
                        }
                        // Konversi ke JSON
                        $json_biaya = json_encode($json_biaya);
                        $json_potongan = json_encode($json_potongan);
                        //Bersihkan Variabel
                        $id_member=validateAndSanitizeInput($id_member);
                        $kode_transaksi=validateAndSanitizeInput($kode_transaksi);
                        $nama_member=validateAndSanitizeInput($nama_member);
                        $email=validateAndSanitizeInput($email);
                        $kontak=validateAndSanitizeInput($kontak);
                        $biaya_pendaftaran=validateAndSanitizeInput($biaya_pendaftaran);
                        $kategori="Pendaftaran";
                        $status="Pending";
                        //Membuat Raw Member
                        $raw_member = [
                            "id_member" => $id_member,
                            "nama" => $nama_member,
                            "first_name" => $first_name,
                            "last_name" => $last_name,
                            "email" => $email,
                            "kontak" => $kontak
                        ];
                        $raw_member=json_encode($raw_member, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                        $jumlah_total_transaksi=($biaya_pendaftaran+$ppn+$biaya_layanan+$total_biaya)-$total_potongan;
                        $ongkir=0;
                        // Insert data ke database
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
                        ) VALUES (
                            ?, 
                            ?, 
                            ?,  
                            ?, 
                            ?, 
                            ?,  
                            ?, 
                            ?, 
                            ?, 
                            ?, 
                            ?, 
                            ?, 
                            ?
                        )";
                        $stmt = $Conn->prepare($query);
                        $stmt->bind_param(
                            "sssssssssssss", 
                            $kode_transaksi, 
                            $id_member, 
                            $raw_member, 
                            $kategori, 
                            $now, 
                            $biaya_pendaftaran, 
                            $ongkir, 
                            $ppn, 
                            $biaya_layanan, 
                            $json_biaya, 
                            $json_potongan, 
                            $jumlah_total_transaksi, 
                            $status
                        );
                        if ($stmt->execute()) {
                            //Apakah Kirim Email
                            if($kirim_email=="Ya"){
                                //Mengirim Email
                                $id_event=GetDetailData($Conn,'event_peserta','id_event_peserta',$kode_transaksi,'id_event');
                                $nama_event=GetDetailData($Conn,'event','id_event',$id_event,'nama_event');
                                //URL Website
                                $base_url_website=GetDetailData($Conn,'web_setting','id_web_setting','1','base_url');
                                $pesan = <<<HTML
<!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Link Pembayaran Pendaftaran Event</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
            }
            p {
                margin: 0 0 15px;
            }
            a {
                color: #007bff;
                text-decoration: none;
            }
            a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <p>Kepada Yth. <strong>$nama_member</strong>,</p>
        <p>Kami telah menyelesaikan peninjauan terhadap pendaftaran yang sudah Anda kirim pada event <em>$nama_event</em>.</p>
        <p>Untuk tahapan selanjutnya, silakan masuk ke akun member Anda pada halaman website, kemudian pilih riwayat pendaftaran event.</p>
        <p>Pilih event yang Anda ikuti, lalu temukan tombol pembayaran pada bagian akhir halaman.</p>
        <p>
            Atau Anda juga bisa langsung mengunjungi tautan berikut ini: <br>
            <a href="$base_url_website/index.php?Page=DetailPendaftaranEvent&id=$kode_transaksi">$base_url_website/index.php?Page=DetailPendaftaranEvent&id=$kode_transaksi</a>
        </p>
        <p>Demikian pemberitahuan dari kami, terima kasih atas kepercayaan Anda.</p>
    </body>
</html>
HTML;
                                    $ch = curl_init();
                                    $headers = array(
                                        'Content-Type: Application/JSON',          
                                        'Accept: Application/JSON'     
                                    );
                                    $arr = array(
                                        "subjek" => "Link Pembayaran Pendaftaran Event",
                                        "email_asal" => "$email_gateway",
                                        "password_email_asal" => "$password_gateway",
                                        "url_provider" => "$url_provider",
                                        "nama_pengirim" => "$nama_pengirim",
                                        "email_tujuan" => "$email",
                                        "nama_tujuan" => "$nama_member",
                                        "pesan" => "$pesan",
                                        "port" => "$port_gateway"
                                    );
                                    $json = json_encode($arr);
                                    curl_setopt($ch, CURLOPT_URL, "$url_service");
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                    curl_setopt($ch, CURLOPT_TIMEOUT, 1000); 
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $content = curl_exec($ch);
                                    $err = curl_error($ch);
                                    curl_close($ch);
                                    $get =json_decode($content, true);
                            }
                            $kategori_log="Event";
                            $deskripsi_log="Tambah Transaksi Peserta Event";
                            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                            if($InputLog=="Success"){
                                $response['success'] = true;
                            }else{
                                $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                            }
                        }else{
                            $errors[] = 'Terjadi kesalahan pada saat menambahkan data pada database!.';
                        }
                    }
                }
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