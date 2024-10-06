<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi id_setting_api_key tidak boleh kosong
    if(empty($_POST['id_setting_api_key'])){
        echo '<code class="text-danger">ID API Key Tidak Boleh Kosong</code>';
    }else{
        //Validasi password_server tidak boleh kosong
        if(empty($_POST['password_server'])){
            echo '<code class="text-danger">Passworrd Server Tidak Boleh Kosong</code>';
        }else{
            $id_setting_api_key=$_POST['id_setting_api_key'];
            $password_server=$_POST['password_server'];
            //Membersihkan Data
            $id_setting_api_key=validateAndSanitizeInput($id_setting_api_key);
            $password_server=validateAndSanitizeInput($password_server);
            //Mengubah Password Menjadi MD5
            $password_server=md5($password_server);
            //Simpan Ke database
            $UpdateApiKey = mysqli_query($Conn,"UPDATE setting_api_key SET 
                datetime_update='$now',
                password_server='$password_server'
            WHERE id_setting_api_key='$id_setting_api_key'") or die(mysqli_error($Conn)); 
            if($UpdateApiKey){
                $KategoriLog="API Key";
                $KeteranganLog="Edit Password API Key Berhasil";
                include "../../_Config/InputLog.php";
                echo '<small class="text-success" id="NotifikasiEditPasswordApiKeyBerhasil">Success</small>';
            }else{
                echo '<small class="text-danger">Terjadi kesalahan pada saat update Password API Key</small>';
            }
        }
    }
?>