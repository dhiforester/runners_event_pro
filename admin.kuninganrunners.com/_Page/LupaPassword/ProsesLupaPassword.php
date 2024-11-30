<?php
    // Koneksi, Function Dan Pengaturan
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingEmail.php";
    include "../../_Config/SettingGeneral.php";

    // Zona Waktu
    date_default_timezone_set("Asia/Jakarta");

    // Menentukan Waktu
    $now = date('Y-m-d H:i:s');
    $datetime_creat = date('Y-m-d H:i:s');
    $datetime_expired = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($now)));

    // Inisiasi Response Pertama Kali
    $response = ['success' => false, 'message' => ''];
    $errors = []; // Inisialisasi pesan error

    // Validasi Email Tidak Boleh Kosong
    if (empty($_POST['email'])) {
        $errors[] = 'Email tidak boleh kosong!';
    }

    // Bersihkan Variabel
    $email = validateAndSanitizeInput($_POST["email"]);
    
    //Cek Email Apakah Ada Pada Database
    $id_akses=GetDetailData($Conn,'akses','email_akses',$email,'id_akses');
    if(empty($id_akses)){
        $errors[] = 'Email yang anda masukan tidak valid!';
    }

    if (!empty($errors)) {
        $response['message'] = implode('<br>', $errors);
        echo json_encode($response);
        exit;
    }else{
        //Buat Kode Rahasia
        $kode_rahasia=GenerateToken(12);

        //Variabel Default
        $ussed=0;

        //Buka Nama User
        $nama=GetDetailData($Conn,'akses','email_akses',$email,'nama_akses');

        //Buat Tautan
        $kode_rahasia_hash=md5($kode_rahasia);
        $tautan_reset_password="$base_url/ResetPassword.php?email=$email&token=$kode_rahasia_hash";

        //Cek Apakah Sebelumnya Sudah Punya Data Lupa Password
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses_validasi FROM akses_validasi WHERE id_akses='$id_akses' AND ussed='0'"));
        if(!empty($jml_data)){
            //Apabila Ada Hapus Data Yang Lama
            $hapus_akses_validasi = mysqli_query($Conn, "DELETE FROM akses_validasi WHERE id_akses='$id_akses' AND ussed='0'") or die(mysqli_error($Conn));
        }
        // Insert data ke database
        $query = "INSERT INTO akses_validasi (
            id_akses, 
            kode_rahasia, 
            datetime_creat, 
            datetime_expired, 
            ussed
        ) VALUES (?, ?, ?, ?, ?)";
        $stmt = $Conn->prepare($query);
        $stmt->bind_param("sssss", 
            $id_akses, 
            $kode_rahasia, 
            $datetime_creat, 
            $datetime_expired, 
            $ussed
        );

        if ($stmt->execute()) {
            
            //Apabila Proses Berhasil, Kirim Email
            $pesan='
                Kepada Yth '.$nama.'<br>
                Silahkan kunjungi tautan berikut ini untuk mengubah password anda<br>
                <a href="'.$tautan_reset_password.'">Reset Password</a><br>
                Jika tautan tidak tampil, silahkan gunakan tautan manual berikut :<br> 
                '.$tautan_reset_password.'<br>
                <p><b>Catatam : </b>Tautan ini hanya berlaku 1 jam dari saat pesan diterima.</p>
            ';
            $ch = curl_init();
            $headers = array(
                'Content-Type: Application/JSON',          
                'Accept: Application/JSON'     
            );
            $arr = array(
                "subjek" => "Lupa Password",
                "email_asal" => "$email_gateway",
                "password_email_asal" => "$password_gateway",
                "url_provider" => "$url_provider",
                "nama_pengirim" => "$nama_pengirim",
                "email_tujuan" => "$email",
                "nama_tujuan" => "$nama",
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

            //Tanpa Mengetahui Apakah Email Terkirim Atau Tidak, Simpan Log
            $kategori_log = "Lupa Password";
            $deskripsi_log = "Kirim Tautan Lupa Password";
            $InputLog = addLog($Conn, $id_akses, $now, $kategori_log, $deskripsi_log);
            if ($InputLog == "Success") {
                $response['success'] = true;
            } else {
                $response['message'] = 'Terjadi kesalahan pada saat input log.';
            }
        } else {
            $response['message'] = 'Gagal menyimpan data, coba lagi id-akses: '.$id_akses.'. Email: '.$email.' ';
        }
    }
    echo json_encode($response);
?>
