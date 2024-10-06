<?php
    function GenerateToken($length){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited
        
        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max-1)];
        }
        return $token;
    }
    function GetDetailData($Conn,$Tabel,$Param,$Value,$Colom){
        if(empty($Conn)){
            $Response="No Database Connection";
        }else{
            if(empty($Tabel)){
                $Response="No Table Selected";
            }else{
                if(empty($Param)){
                    $Response="No Parameter Selected";
                }else{
                    if(empty($Value)){
                        $Response="No Value Count";
                    }else{
                        if(empty($Colom)){
                            $Response="No Colom Selected";
                        }else{
                            $Qry = mysqli_query($Conn,"SELECT * FROM $Tabel WHERE $Param='$Value'")or die(mysqli_error($Conn));
                            $Data = mysqli_fetch_array($Qry);
                            if(empty($Data[$Colom])){
                                $Response="";
                            }else{
                                $Response=$Data[$Colom];
                            }
                        }
                    }
                }
            }
        }
        return $Response;
    }
    function IjinAksesSaya($Conn,$SessionIdAkses,$KodeFitur){
        $QryParam = mysqli_query($Conn,"SELECT * FROM akses_ijin WHERE id_akses='$SessionIdAkses' AND kode='$KodeFitur'")or die(mysqli_error($Conn));
        $DataParam = mysqli_fetch_array($QryParam);
        if(empty($DataParam['id_akses'])){
            $Response="Tidak Ada";
        }else{
            $Response="Ada";
        }
        return $Response;
    }
    function CekFiturEntitias($Conn,$uuid_akses_entitas,$id_akses_fitur){
        $QryParam = mysqli_query($Conn,"SELECT * FROM akses_referensi WHERE uuid_akses_entitas='$uuid_akses_entitas' AND id_akses_fitur='$id_akses_fitur'")or die(mysqli_error($Conn));
        $DataParam = mysqli_fetch_array($QryParam);
        if(empty($DataParam['id_akses_referensi'])){
            $Response="Tidak Ada";
        }else{
            $Response="Ada";
        }
        return $Response;
    }
    function addLog($Conn,$id_akses,$datetime_log,$kategori_log,$deskripsi_log){
        $entry="INSERT INTO log (
            id_akses,
            datetime_log,
            kategori_log,
            deskripsi_log
        ) VALUES (
            '$id_akses',
            '$datetime_log',
            '$kategori_log',
            '$deskripsi_log'
        )";
        $Input=mysqli_query($Conn, $entry);
        if($Input){
            $Response="Success";
        }else{
            $Response="Input Log Gagal";
        }
        return $Response;
    }
    function CheckParameterOnJson($jsonString,$type,$parameter) {
        // Mengurai string JSON menjadi array PHP
        $data = json_decode($jsonString, true);
    
        // Pengecekan apakah $type ada dalam salah satu elemen array
        foreach ($data as $item) {
            if ($item[$parameter] === $type) {
                return true; // Jika ditemukan, kembalikan true
            }
        }
    
        return false; // Jika tidak ditemukan, kembalikan false
    }
    function ValidasiKutip($string) {
        // Pola untuk mendeteksi tanda kutip tunggal atau ganda
        $pola = "/['\"]/";
    
        // Menggunakan preg_match untuk mengecek apakah string mengandung tanda kutip
        if (preg_match($pola, $string)) {
            return false; // String mengandung tanda kutip
        } else {
            return true; // String tidak mengandung tanda kutip
        }
    }
    function ValidasiHanyaAngka($string) {
        // Pola untuk mendeteksi hanya angka
        $pola = "/^\d+$/";
    
        // Menggunakan preg_match untuk mengecek apakah string hanya mengandung angka
        return preg_match($pola, $string);
    }
    function formatRupiah($angka,$mata_uang,$zero_padding) {
        return ''.$mata_uang.' ' . number_format($angka, $zero_padding, ',', '.');
    }
    // Function to get value by UID
    function getValueByUid($data, $uid) {
        foreach ($data as $item) {
            if ($item['uid'] == $uid) {
                return $item['value'];
            }
        }
        return null;
    }
    // Function to get value by UID
    function SearchStringIntoArray($data, $keyword) {
        foreach ($data as $item) {
            if ($item== $keyword) {
                return true;
            }
        }
        return false;
    }
    function GetSometingByKeyword($DatArray,$keyword_by,$keyword,$value_parameter) {
        foreach ($DatArray as $item) {
            if ($item[$keyword_by] == $keyword) {
                return $item[$value_parameter];
            }
        }
        return null;
    }
    function ValidasiRekening($input) {
        // Cek apakah input hanya berisi angka
        if (!ctype_digit($input)) {
            return "Nomor Rekening harus berisi angka saja.";
        }
    
        // Cek apakah panjang input tidak lebih dari 20 karakter
        if (strlen($input) > 20) {
            return "Nomor Rekening tidak boleh lebih dari 20 karakter.";
        }
    
        return "Valid";
    }
    function ValidasiBank($input) {
        // Cek apakah input hanya berisi huruf dan spasi
        if (!preg_match('/^[a-zA-Z\s]*$/', $input)) {
            return "Nama Bank hanya boleh berisi huruf dan spasi.";
        }
    
        // Cek apakah panjang input tidak lebih dari 20 karakter
        if (strlen($input) > 20) {
            return "Nama Bank tidak boleh lebih dari 20 karakter.";
        }
    
        return "Valid";
    }
    function ValidasiKontak($input) {
        // Cek apakah input hanya berisi huruf dan spasi
        if (!preg_match('/^[0-9]*$/', $input)) {
            return "Kontak hanya boleh berisi huruf dan spasi.";
        }
    
        // Cek apakah panjang input tidak lebih dari 20 karakter
        if (strlen($input) > 20) {
            return "Kontak tidak boleh lebih dari 20 karakter.";
        }
    
        return "Valid";
    }
    function maskAccountNumber($accountNumber) {
        // Hitung panjang nomor rekening
        $length = strlen($accountNumber);
        
        // Ambil 4 digit terakhir
        $lastFourDigits = substr($accountNumber, -4);
        
        // Buat string bintang dengan panjang sesuai
        $maskedPart = str_repeat('*', $length - 4);
        
        // Gabungkan bagian yang di-mask dengan 4 digit terakhir
        return $maskedPart . $lastFourDigits;
    }
    function TokenValidation($input) {
        // Cek apakah input hanya berisi angka dan huruf
        if (!preg_match('/^[a-zA-Z0-9]*$/', $input)) {
            return "Input hanya boleh berisi huruf dan angka.";
        }
    
        // Cek apakah panjang input tidak lebih dari 20 karakter
        if (strlen($input) > 20) {
            return "Input tidak boleh lebih dari 20 karakter.";
        }
    
        return "Valid";
    }
    function validateAndSanitizeInput($input) {
        // Menghapus karakter yang tidak diinginkan
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
    
    //Creat Captcha
    function CreatCaptcha($Conn) {
        date_default_timezone_set("Asia/Jakarta");
        $now=date('Y-m-d H:i:s');
        //hasil kode acak disimpan di $code
        $length=6;
        $Captcha = "";
        $codeAlphabet = "ABCDEFGHJKLMNPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijkmnpqrstuvwxyz";
        $codeAlphabet.= "23456789";
        $max = strlen($codeAlphabet); // edited
        for ($i=0; $i < $length; $i++) {
            $Captcha .= $codeAlphabet[random_int(0, $max-1)];
        }
        //Ubah ke md5
        $CodeMd5=md5($Captcha);
        //Melakukan Pengecekan Kode Captcha Yang expired
        $expired=date('Y-m-d H:i:s', time() - 60);
        $query = mysqli_query($Conn, "SELECT*FROM log_captcha WHERE datetime_creat<'$expired'");
        while ($data = mysqli_fetch_array($query)) {
            $id_log_captcha= $data['id_log_captcha'];
            //Hapus Captcha
            $Hapus = mysqli_query($Conn, "DELETE FROM log_captcha WHERE id_log_captcha='$id_log_captcha'") or die(mysqli_error($Conn));
        }
        //Simpan Ke Database
        $EntryCaptcha="INSERT INTO log_captcha (
            datetime_creat,
            captcha
        ) VALUES (
            '$now',
            '$CodeMd5'
        )";
        $InputCaptcha=mysqli_query($Conn, $EntryCaptcha);
        if($InputCaptcha){
            $CaptchaFix=$Captcha;
        }else{
            $CaptchaFix="";
        }
        return $CaptchaFix;
    }
    function hitung_usia($tanggal_lahir) {
        $birthDate = new DateTime($tanggal_lahir);
        $today = new DateTime("today");
        if ($birthDate > $today) {
            exit("Usia tidak valid");
        }
        $y = $today->diff($birthDate)->y;
        $m = $today->diff($birthDate)->m;
        $d = $today->diff($birthDate)->d;
    
        if ($y > 0) {
            return $y." tahun";
        } else if ($m > 0) {
            return $m." bulan";
        } else {
            return $d." hari";
        }
    }
    function ValidasiTanggal($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
    function CurlGet($url) {
        //Start CURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url.'',
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ));
        $GetResponse = curl_exec($curl);
        curl_close($curl);

        return $GetResponse;
    }
    function calculateExpirationTimeFromDateTime($dateTime, $milliseconds) {
        // Membuat objek DateTime dari string input
        $date = new DateTime($dateTime);
    
        // Mengonversi milidetik ke detik dan mikrodetik
        $seconds = floor($milliseconds / 1000);
        $microseconds = ($milliseconds % 1000) * 1000;
    
        // Menambahkan detik dan mikrodetik ke objek DateTime
        $date->add(new DateInterval("PT{$seconds}S"));
        // Menambahkan mikrodetik menggunakan metode modify
        $date->modify("+{$microseconds} microseconds");
    
        // Mengembalikan waktu kedaluwarsa dalam format YYYY-mm-dd HH:ii:ss.uuu
        return $date->format('Y-m-d H:i:s');
    }
    
    function insertLogApi($Conn, $id_setting_api_key, $title_api_key, $service_name, $response_code, $response_text, $datetime) {
        // Escape strings untuk menghindari SQL injection
        $id_setting_api_key = mysqli_real_escape_string($Conn, $id_setting_api_key);
        $title_api_key = mysqli_real_escape_string($Conn, $title_api_key);
        $service_name = mysqli_real_escape_string($Conn, $service_name);
        $response_code = mysqli_real_escape_string($Conn, $response_code);
        $response_text = mysqli_real_escape_string($Conn, $response_text);
        $datetime = mysqli_real_escape_string($Conn, $datetime);
        $EntryLog="INSERT INTO log_api (
            id_setting_api_key,
            title_api_key,
            service_name,
            response_code,
            response_text,
            datetime_log
        ) VALUES (
            '$id_setting_api_key',
            '$title_api_key',
            '$service_name',
            '$response_code',
            '$response_text',
            '$datetime'
        )";
        $InputLog=mysqli_query($Conn, $EntryLog);
        if($InputLog){
            $response="Success";
        }else{
            $response="Error Insert Data";
        }
        return $response;
    }
    function generateUuidV1() {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $length = 36;
        $uuid = '';
        for ($i = 0; $i < $length; $i++) {
            $uuid .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $uuid;
    }
    function getNamaBulan($angkaBulan) {
        // Array dengan nama-nama bulan
        $namaBulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];
    
        // Mengembalikan nama bulan berdasarkan angka
        return $namaBulan[$angkaBulan] ?? 'Bulan tidak valid';
    }
?>