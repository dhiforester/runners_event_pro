<?php
    session_start();
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    //Apabila id_propinsi tidak ada
    if(empty($_POST['id_propinsi'])){
        echo '<option value="">Pilih</option>';
    }else{
        $id_propinsi=$_POST['id_propinsi'];
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
            if(empty($_POST['kabupaten_member'])){
                $kabupaten_member="";
            }else{
                $kabupaten_member=$_POST['kabupaten_member'];
            }
            //Buat Session
            $_SESSION['datetime_expired'] = $datetime_expired;
            $_SESSION['xtoken'] = $xtoken;
            //Buka Data
            $ListKabupaten=ListKabupaten($url_server,$xtoken,$id_propinsi);
            $array_list_kabupaten= json_decode($ListKabupaten, true);
            if($array_list_kabupaten['response']['code']!==200) {
                echo '<option value="">Pilih</option>';
            }else{
                echo '<option value="">Pilih</option>';
                $kabupaten = $array_list_kabupaten['metadata'];
                foreach($kabupaten as $list_kabupaten){
                    $id_kabupaten=$list_kabupaten['id_kabupaten'];
                    $kabupaten=$list_kabupaten['kabupaten'];
                    if($kabupaten_member==$kabupaten){
                        echo '<option selected value="'.$id_kabupaten.'">'.$kabupaten.'</option>';
                    }else{
                        echo '<option value="'.$id_kabupaten.'">'.$kabupaten.'</option>';
                    }
                }
            }
        }
    }
?>