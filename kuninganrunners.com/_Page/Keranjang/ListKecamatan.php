<?php
    session_start();
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    //Apabila id_kabupaten tidak ada
    if(empty($_POST['id_kabupaten'])){
        echo '<option value="">Pilih</option>';
    }else{
        $id_kabupaten=$_POST['id_kabupaten'];
        //Apabila Session Datetime expired tidak ada
        if(empty($_SESSION['datetime_expired'])){
            // Apabila Session X token tidak ada
            $response=GenerateXtoken($url_server,$user_key_server,$password_server);
            $arry_res = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $xtoken ="";
                $datetime_expired ="";
            }else{
                if($arry_res['response']['code']!==200) {
                    $xtoken ="";
                    $datetime_expired ="";
                }else{
                    $metadata = $arry_res['metadata'];
                    $datetime_expired = $metadata['datetime_expired'];
                    $xtoken = $metadata['x-token'];
                }
            }
        }else{
            //Cek Apakah xtoken expired
            if(date('Y-m-d H:i:s')<$_SESSION['datetime_expired']){
                //Apabila Masih Aktif Maka Buka Dari Session
                $xtoken=$_SESSION['xtoken'];
                $datetime_expired=$_SESSION['datetime_expired'];
            }else{
                //Apabila sudah Expired
                $response=GenerateXtoken($url_server,$user_key_server,$password_server);
                $arry_res = json_decode($response, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $xtoken ="";
                    $datetime_expired ="";
                }else{
                    if($arry_res['response']['code']!==200) {
                        $xtoken ="";
                        $datetime_expired ="";
                    }else{
                        $metadata = $arry_res['metadata'];
                        $datetime_expired = $metadata['datetime_expired'];
                        $xtoken = $metadata['x-token'];
                    }
                }
            }
        }
        if(empty($xtoken)){
            echo '<option value="">Pilih</option>';
        }else{
            if(empty($_POST['kecamatan_member'])){
                $kecamatan_member="";
            }else{
                $kecamatan_member=$_POST['kecamatan_member'];
            }
            //Buat Sessi
            $_SESSION['datetime_expired'] = $datetime_expired;
            $_SESSION['xtoken'] = $xtoken;
            //Buka Data
            $ListKecamatan=ListKecamatan($url_server,$xtoken,$id_kabupaten);
            $array_list_kecamatan= json_decode($ListKecamatan, true);
            if($array_list_kecamatan['response']['code']!==200) {
                echo '<option value="">Pilih</option>';
            }else{
                echo '<option value="">Pilih</option>';
                $kecamatan = $array_list_kecamatan['metadata'];
                foreach($kecamatan as $list_kecamatan){
                    $id_kecamatan=$list_kecamatan['id_kecamatan'];
                    $kecamatan=$list_kecamatan['kecamatan'];
                    if($kecamatan_member==$kecamatan){
                        echo '<option selected value="'.$id_kecamatan.'">'.$kecamatan.'</option>';
                    }else{
                        echo '<option value="'.$id_kecamatan.'">'.$kecamatan.'</option>';
                    }
                }
            }
        }
    }
?>