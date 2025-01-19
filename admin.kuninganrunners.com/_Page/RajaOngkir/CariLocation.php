<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Inisiasi response baru
    $response = array('status' => 'error', 'message' => '');
    //Buka Pengaturan
    $base_url_raja_ongkir=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'base_url');
    $api_key=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'api_key');
    $password=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'password');
    if(empty($base_url_raja_ongkir)){
        $response= 'Base URL Pengaturan Belum Diatur';
    }else{
        if(empty($api_key)){
            $response= 'API Key Belum Diatur';
        }else{
            if(empty($password)){
                $response= 'Password API Belum Diatur';
            }else{
                if(empty($_POST['origin_keyword'])){
                    $response= 'Kata Kunci Pencarian Belum Diisi';
                }else{
                    $response='Success';
                }
            }
        }
    }
    if($response!=="Success"){
        echo '
            <div class="alert alert-danger">'.$response.'</div>
        ';
    }else{
        $origin_keyword=$_POST['origin_keyword'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$base_url_raja_ongkir.'/destination/domestic-destination?search='.$origin_keyword.'&limit=100&offset=0',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'key: '.$api_key.''
            ),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response_arry=json_decode($response,true);
        if($response_arry['meta']['code']!==200){
            echo '
                <div class="alert alert-danger">'.$response_arry['meta']['message'].'</div>
            ';
        }else{
            if(!empty(count($response_arry['data']))){
                echo 'Hasil Pencarian :<br>';
                foreach($response_arry['data'] as $list){
                    echo '
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="origin" id="origin'.$list['id'].'" value="'.$list['id'].'|'.$list['label'].'">
                            <label class="form-check-label" for="origin'.$list['id'].'">
                                <small>'.$list['label'].'</small>
                            </label>
                        </div>
                    ';
                }
            }else{
                echo '
                    <div class="alert alert-danger">Pencarian Tidak Ditemukan</div>
                ';
            }
        }
    }
?>