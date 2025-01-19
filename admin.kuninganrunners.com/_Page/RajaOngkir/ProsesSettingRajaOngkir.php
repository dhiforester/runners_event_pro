<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    $now=date('Y-m-d H:i:s');
    if(empty($SessionIdAkses)){
        echo '<span class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</span>';
    }else{
        //Validasi Eksistensi variabel
        if(empty($_POST['base_url_raja_ongkir'])){
            $base_url_raja_ongkir="";
        }else{
            $base_url_raja_ongkir=$_POST['base_url_raja_ongkir'];
        }
        if(empty($_POST['api_key'])){
            $api_key="";
        }else{
            $api_key=$_POST['api_key'];
        }
        if(empty($_POST['password'])){
            $password="";
        }else{
            $password=$_POST['password'];
        }
        if(empty($_POST['origin_id'])){
            $origin_id="0";
        }else{
            $origin_id=$_POST['origin_id'];
        }
        if(empty($_POST['origin_label'])){
            $origin_label="";
        }else{
            $origin_label=$_POST['origin_label'];
        }
        //Bersihkan Karakter
        $base_url_raja_ongkir=validateAndSanitizeInput($base_url_raja_ongkir);
        $api_key=validateAndSanitizeInput($api_key);
        $password=validateAndSanitizeInput($password);
        $origin_id=validateAndSanitizeInput($origin_id);
        $origin_label=validateAndSanitizeInput($origin_label);
        //Update Pengaturan
        $Update= mysqli_query($Conn,"UPDATE api_raja_ongkir SET 
            base_url='$base_url_raja_ongkir',
            api_key='$api_key',
            password='$password',
            origin_id='$origin_id',
            origin_label='$origin_label'
        WHERE id_api_raja_ongkir='1'") or die(mysqli_error($Conn)); 
        if($Update){
            $kategori_log="Setting";
            $deskripsi_log="Setting Raja Ongkir";
            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
            if($InputLog=="Success"){
                echo '<span class="text-success" id="NotifikasiSettingRajaOngkirBerhasil">Success</span>';
            }else{
                echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan Log</small>';
            }
        }else{
            echo '<span class="text-danger">Pengaturan Raja Ongkir Berhasil Disimpan</span>';
        }
    }
?>