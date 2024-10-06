<?php
    //Connection
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    $now=date('Y-m-d H:i:s');
    $KategoriLog="API Key";
    $KeteranganLog="Hapus API Key Berhasil";
    if(empty($_POST['id_setting_api_key'])){
        echo '<code class="text-danger">ID API Key Tidak Boleh Kosong!</code>';
    }else{
        if(empty($_POST['hapus_log'])){
            $hapus_log="No";
        }else{
            $hapus_log=$_POST['hapus_log'];
        }
        $id_setting_api_key=$_POST['id_setting_api_key'];
        //Bersihkan Variabel
        $id_setting_api_key=validateAndSanitizeInput($id_setting_api_key);
        $hapus_log=validateAndSanitizeInput($hapus_log);
        //Proses hapus data
        $HapusApiKey = mysqli_query($Conn, "DELETE FROM setting_api_key WHERE id_setting_api_key='$id_setting_api_key'") or die(mysqli_error($Conn));
        if($HapusApiKey) {
            $HapusSessionApiKey = mysqli_query($Conn, "DELETE FROM api_session WHERE id_setting_api_key='$id_setting_api_key'") or die(mysqli_error($Conn));
            if($HapusSessionApiKey) {
                if($hapus_log=="Ya"){
                    $HapusLog = mysqli_query($Conn, "DELETE FROM log_api WHERE id_setting_api_key='$id_setting_api_key'") or die(mysqli_error($Conn));
                    if($HapusLog){
                        include "../../_Config/InputLog.php";
                        echo '<code class="text-success" id="NotifikasiHapusApiKeyBerhasil">Success</code>';
                    }else{
                        echo '<code class="text-danger">Terjadi kesalahan pada saat menghapus Log API Key</code>';
                    }
                }else{
                    include "../../_Config/InputLog.php";
                    echo '<code class="text-success" id="NotifikasiHapusApiKeyBerhasil">Success</code>';
                }
            }else{
                echo '<code class="text-danger">Terjadi kesalahan pada saat menghapus Session API Key</code>';
            }
        }else{
            echo '<code class="text-danger">Terjadi kesalahan pada saat menghapus API Key</code>';
        }
    }
?>