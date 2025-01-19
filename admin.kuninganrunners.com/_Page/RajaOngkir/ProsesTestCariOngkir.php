<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    $now=date('Y-m-d H:i:s');
    if(empty($SessionIdAkses)){
        echo '<div class="alert alert-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</div>';
    }else{
        $base_url_raja_ongkir=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'base_url');
        $api_key=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'api_key');
        $password=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'password');
        $origin_id=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'origin_id');
        $origin_label=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'origin_label');
        //Validasi Eksistensi variabel
        if(empty($_POST['destination_content'])){
            $destination_content="";
        }else{
            $destination_content=$_POST['destination_content'];
        }
        if(empty($_POST['berat'])){
            $berat="0";
        }else{
            $berat=$_POST['berat'];
        }
        if(empty($_POST['courier'])){
            $courier="0";
        }else{
            $courier=$_POST['courier'];
        }
        if(empty($_POST['price'])){
            $price="lowest";
        }else{
            $price=$_POST['price'];
        }
        //Bersihkan Karakter
        $destination_content=validateAndSanitizeInput($destination_content);
        $berat=validateAndSanitizeInput($berat);
        $courier=validateAndSanitizeInput($courier);
        $price=validateAndSanitizeInput($price);
        //Pecah 'destination_content'
        $explode=explode('-',$destination_content);
        $destination_id=$explode[0];
        //Konversi Berat
        $berat=$berat*1000;
        //Kirim Data Ongkir
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$base_url_raja_ongkir.'/calculate/domestic-cost',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'origin='.$origin_id.'&destination='.$destination_id.'&weight='.$berat.'&courier='.$courier.'&price='.$price.'',
            CURLOPT_HTTPHEADER => array(
                'key: '.$api_key.'',
                'Content-Type: application/x-www-form-urlencoded'
            ),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        if(empty($response)){
            echo '<div class="alert alert-danger">Tidak Ada Response Dari Raja Ongkir</div>';
        }else{
            $response_arry=json_decode($response,true);
            if($response_arry['meta']['code']!==200){
                echo '<div class="alert alert-danger">'.$response_arry['meta']['message'].'</div>';
            }else{
                if(empty(count($response_arry['data']))){
                    echo '<div class="alert alert-danger">'.$response_arry['meta']['message'].'/div>';
                }else{
                    echo '<table class="table table-responsive table-bordered table-hover">';
                    echo '  
                            <thead>
                                <tr>
                                    <td class="text-center"><b>No</b></td>
                                    <td class="text-center"><b>Name</b></td>
                                    <td class="text-center"><b>Service</b></td>
                                    <td class="text-center"><b>Description</b></td>
                                    <td class="text-center"><b>Ongkir</b></td>
                                    <td class="text-center"><b>ETD</b></td>
                                </tr>
                            </thead>
                    ';
                    echo '<tbody>';
                    $no=1;
                    $data=$response_arry['data'];
                    foreach($data as $list){
                        $ongkir=$list['cost'];
                        $ongkir_format='Rp ' . number_format($ongkir, 0, ',', '.');
                        echo '
                            <tr>
                                <td class="text-center">'.$no.'</td>
                                <td class="text-center">'.$list['name'].'</td>
                                <td class="text-center">'.$list['service'].'</td>
                                <td class="text-center">'.$list['description'].'</td>
                                <td class="text-center">'.$ongkir_format.'</td>
                                <td class="text-center">'.$list['etd'].'</td>
                            </tr>
                        ';
                        $no++;
                    }
                    echo '      </tbody>';
                    echo '  </table>';
                    echo '</div>';
                }
                
            }
        }
    }
?>