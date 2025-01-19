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
                if(empty($_POST['destination_keyword'])){
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
        $destination_keyword=$_POST['destination_keyword'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$base_url_raja_ongkir.'/destination/domestic-destination?search='.$destination_keyword.'&limit=100&offset=0',
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
                echo '<ul>';
                foreach($response_arry['data'] as $list){
                    echo '
                        <li class="mb-3 border-1 border-bottom">
                            <a href="javascript:void(0);" class="pilih_destination" data-id="'.$list['id'].'-'.$list['label'].'">
                                '.$list['id'].'-'.$list['label'].'
                            </a>
                        </li>
                    ';
                }
                echo '</ul>';
            }else{
                echo '
                    <div class="alert alert-danger">Pencarian Tidak Ditemukan</div>
                ';
            }
        }
    }
?>
<script>
    $(document).on('click', '.pilih_destination', function() {
        // Ambil nilai dari atribut data-id
        var dataId = $(this).data('id');
        //Tempelkan Ke Form
        $('#destination_content').val(dataId);
        //Tutup Modal
        $('#ModalCariDestinationContent').modal('hide');
    });
</script>