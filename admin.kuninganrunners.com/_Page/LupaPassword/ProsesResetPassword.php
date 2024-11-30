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
    $datetime_now = date('Y-m-d H:i:s');

    // Inisiasi Response Pertama Kali
    $response = ['success' => false, 'message' => ''];
    $errors = []; // Inisialisasi pesan error

    // Validasi email_akses Tidak Boleh Kosong
    if (empty($_POST['email_akses'])) {
        $errors[] = 'Email tidak boleh kosong!';
    }

    //Validasi token tidak boleh kosong
    if (empty($_POST['token'])) {
        $errors[] = 'Token tidak boleh kosong!';
    }

    //Validasi password1 Tidak Boleh Kosong
    if (empty($_POST['password1'])) {
        $errors[] = 'Password tidak boleh kosong!';
    }

    //Validasi password2 Tidak Boleh Kosong
    if (empty($_POST['password2'])) {
        $errors[] = 'Ulangi password dengan benar';
    }
    // Bersihkan Variabel
    $email_akses = validateAndSanitizeInput($_POST["email_akses"]);
    $token = validateAndSanitizeInput($_POST["token"]);
    $password1 = validateAndSanitizeInput($_POST["password1"]);
    $password2 = validateAndSanitizeInput($_POST["password2"]);

    //Validasi password 1 dan 2 harus sama
    if($password1!==$password2){
        $errors[] = 'Password yang anda masukan tidak sama';
    }
    
    //Cek Email Apakah Ada Pada Database
    $id_akses=GetDetailData($Conn,'akses','email_akses',$email_akses,'id_akses');
    if(empty($id_akses)){
        $errors[] = 'Email yang anda masukan tidak valid!';
    }
    
    $ussed=0;
    $stmt = $Conn->prepare("SELECT * FROM akses_validasi WHERE id_akses = ? AND ussed = ?");
    $stmt->bind_param("si", $id_akses, $ussed);
    $stmt->execute();
    $result = $stmt->get_result();
    $DataAkses = $result->fetch_assoc();

    //Validasi Apakah Pengajuan Reset Password Ada
    if(!$DataAkses){
        $errors[] = 'Pengajuan Reset Password Tidak Ditemukan!';
    }else{

        //Validasi Token
        $kode_rahasia=$DataAkses['kode_rahasia'];
        $datetime_expired=$DataAkses['datetime_expired'];
        $kode_rahasia=md5($kode_rahasia);
        if($kode_rahasia!==$token){
            $errors[] = 'Token Yang Anda Gunakan Tidak Valid';
        }else{

            //Validasi Apakah Token Masih Berlaku
            if($datetime_now>$datetime_expired){
                $errors[] = 'Token Sudah Expired';
            }
        }
    }
    
    //Validasi Karakter Password
    $JumlahKarakterPassword=strlen($_POST['password1']);
    if($JumlahKarakterPassword>20||$JumlahKarakterPassword<6||!preg_match("/^[a-zA-Z0-9]*$/", $_POST['password1'])){
        echo '<small class="text-danger">Password can only have 6-20 numeric characters</small>';
        $errors[] = 'Password hanya boleh berisi 6-20 karakter numerik dan huruf';
    }

    //Apabila Error Atau Tidak Valid
    if (!empty($errors)) {
        $response['message'] = implode('<br>', $errors);
        echo json_encode($response);
        exit;
    }else{
        
        //Variabel ussed baru
        $ussed=1;

        //Hasing Password
        $password1=password_hash($password1, PASSWORD_DEFAULT);

        // Update data ke database
        $UpdateAkses = mysqli_query($Conn,"UPDATE akses SET 
            password='$password1'
        WHERE id_akses='$id_akses'") or die(mysqli_error($Conn)); 
        if($UpdateAkses){

            //Apabila Berhasil, Update Data Permintaan Lupa Password Menjadi ussed
            $UpdateAksesValidasi = mysqli_query($Conn,"UPDATE akses_validasi SET 
                ussed='$ussed'
            WHERE id_akses='$id_akses'") or die(mysqli_error($Conn)); 
            if($UpdateAksesValidasi){

                //Apabila Proses Berhasil Simpan Log
                $kategori_log = "Lupa Password";
                $deskripsi_log = "Ubah Password";
                $InputLog = addLog($Conn, $id_akses, $now, $kategori_log, $deskripsi_log);
                if ($InputLog == "Success") {
                    $response['success'] = true;
                } else {
                    $response['message'] = 'Terjadi kesalahan pada saat input log.';
                }
            } else {
                $response['message'] = 'Gagal memperbaharui data permintaan lupa password!';
            }
        } else {
            $response['message'] = 'Gagal memperbaharui password pada database akses!';
        }
        echo json_encode($response);
    }
?>
