<?php
    session_start();
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    //Apabila id_kecamatan tidak ada
    if(empty($_POST['id_kecamatan'])){
        echo '<option value="">Pilih</option>';
    }else{
        if(empty($_POST['GetDesa'])){
            echo '<option value="">Pilih</option>';
        }else{
            $GetDesa=$_POST['GetDesa'];
            $id_kecamatan=$_POST['id_kecamatan'];
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
                //Buat Session
                $_SESSION['datetime_expired'] = $datetime_expired;
                $_SESSION['xtoken'] = $xtoken;
                //Buka Data
                $ListDesa=ListDesa($url_server,$xtoken,$id_kecamatan);
                $array_list_desa= json_decode($ListDesa, true);
                if($array_list_desa['response']['code']!==200) {
                    echo '<option value="">Pilih</option>';
                }else{
                    echo '<option value="">Pilih</option>';
                    $desa = $array_list_desa['metadata'];
                    foreach($desa as $list_desa){
                        $id_desa=$list_desa['id_desa'];
                        $desa=$list_desa['desa'];
                        if($GetDesa==$desa){
                            echo '<option selected value="'.$id_desa.'">'.$desa.'</option>';
                        }else{
                            echo '<option value="'.$id_desa.'">'.$desa.'</option>';
                        }
                    }
                }
            }
        }
    }
?>