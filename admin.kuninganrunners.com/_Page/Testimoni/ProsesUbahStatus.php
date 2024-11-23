<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
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
        //Validasi id_web_testimoni tidak boleh kosong
        if(empty($_POST['id_web_testimoni'])){
            $errors[] = 'ID Testimoni tidak boleh kosong!.';
        }else{
            //Validasi status tidak boleh kosong
            if(empty($_POST['status'])){
                $errors[] = 'Status tidak boleh kosong!.';
            }else{
                //Buat Variabel
                $id_web_testimoni=$_POST['id_web_testimoni'];
                $status=$_POST['status'];
                //Bersihkan Variabel
                $id_web_testimoni=validateAndSanitizeInput($id_web_testimoni);
                $status=validateAndSanitizeInput($status);
                // Query untuk mengupdate data testimoni
                $sql = "UPDATE web_testimoni SET 
                        status = ?
                WHERE id_web_testimoni = ?";
                // Menyiapkan statement
                $stmt = $Conn->prepare($sql);
                $stmt->bind_param('ss', 
                    $status,
                    $id_web_testimoni
                );
                // Eksekusi statement dan cek apakah berhasil
                if ($stmt->execute()) {
                    //Kirim email Jika Ada
                    if(!empty($_POST['PemberitahuanEmail'])){
                        include "../../_Config/SettingEmail.php";
                        //Buka Member
                        $id_member=GetDetailData($Conn,'web_testimoni','id_web_testimoni',$id_web_testimoni,'id_member');
                        $email=GetDetailData($Conn,'member','id_member',$id_member,'email');
                        $nama = GetDetailData($Conn, 'member', 'email', $email, 'nama');
                        $datetime=GetDetailData($Conn,'web_testimoni','id_web_testimoni',$id_web_testimoni,'datetime');
                        //Kirim Email
$pesan = <<<HTML
<html>
<head>
    <title>Perubahan Status Testimoni</title>
</head>
<body>
    <p>
        Kepada Yth.<br> $nama,
    </p>
    <p>Perubahan status testimoni anda yang dikirim pada $datetime menjadi <strong>$status</strong></p>
    <p>Terima kasih atas kepercayaan dan partisipasi Anda.</p>
</body>
</html>
HTML;
                                    $ch = curl_init();
                                    $headers = array(
                                        'Content-Type: Application/JSON',          
                                        'Accept: Application/JSON'     
                                    );
                                    $arr = array(
                                        "subjek" => "Perubahan Status Testimoni",
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
                    }
                    $kategori_log="Testimoni";
                    $deskripsi_log="Ubah Status Testimoni";
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
    if (!empty($errors)) {
        $response['message'] = implode('<br>', $errors);
        echo json_encode($response);
        exit;
    }else{
        echo json_encode($response);
    }
?>