<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Time Zone
    date_default_timezone_set("Asia/Jakarta");
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Id Akses
    if(empty($SessionIdAkses)){
        echo '<small class="text-danger">ID Akses Tidak Boleh Kosong</small>';
    }else{
        $id_akses=$SessionIdAkses;
        if(empty($_POST['password1'])){
            echo '<small class="text-danger">Password Tidak Boleh Kosong</small>';
        }else{
            //Validasi kontak tidak boleh kosong
            if($_POST['password1']!==$_POST['password2']){
                echo '<small class="text-danger">Passwords Tidak Sama</small>';
            }else{
                //Validasi jumlah dan jenis karakter password
                $JumlahKarakterPassword=strlen($_POST['password1']);
                if($JumlahKarakterPassword>20||$JumlahKarakterPassword<6||!preg_match("/^[a-zA-Z0-9]*$/", $_POST['password1'])){
                    echo '<small class="text-danger">Password Hanya Boleh Terdiri Dari 6-20 karakter</small>';
                }else{
                    $password1=$_POST['password1'];
                    $password1=MD5($password1);
                    $UpdateAkses = mysqli_query($Conn,"UPDATE akses SET 
                        password='$password1',
                        updatetime='$now'
                    WHERE id_akses='$id_akses'") or die(mysqli_error($Conn)); 
                    if($UpdateAkses){
                        $_SESSION ["NotifikasiSwal"]="Edit Password Berhasil";
                        echo '<small class="text-success" id="NotifikasiUbahPasswordBerhasil">Success</small>';
                    }else{
                        echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan dan akses</small>';
                    }
                }
            }
        }
    }
?>