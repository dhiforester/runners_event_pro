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
        //Buka Pengaturan Raja Ongkir
        $base_url_raja_ongkir=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'base_url');
        $api_key=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'api_key');
        $password=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'password');
        $origin_id=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'origin_id');
        $origin_label=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'origin_label');
        //Validasi Eksistensi variabel
        if(empty($_POST['alamat_pengiriman'])){
            $destination_content="";
        }else{
            $destination_content=$_POST['alamat_pengiriman'];
        }
        if(empty($_POST['berat'])){
            $berat="0";
        }else{
            $berat=$_POST['berat'];
        }
        if(empty($_POST['kurir'])){
            $courier="0";
        }else{
            $courier=$_POST['kurir'];
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
                    $no=1;
                    $data=$response_arry['data'];
                    foreach($data as $list){
                        $ongkir=$list['cost'];
                        $ongkir_format='Rp ' . number_format($ongkir, 0, ',', '.');
                        echo '
                            <div class="row mb-3 border-1 border-bottom">
                                <div class="col-md-12">
                                    <a href="javascript:void(0);" class="pilih-ongkir" data-cost="'.$list['cost'].'" data-service="'.$list['service'].'">
                                        <i class="bi bi-check-circle"></i> '.$list['service'].'
                                    </a>
                                    <ol>
                                        <li>
                                            <small>
                                                Cost : <code class="text text-grayish">'.$ongkir_format.'</code>
                                            </small>
                                        </li>
                                        <li>
                                            <small>
                                                Deskripsi : <code class="text text-grayish">'.$list['description'].'</code>
                                            </small>
                                        </li>
                                        <li>
                                            <small>
                                                ETD : <code class="text text-grayish">'.$list['etd'].'</code>
                                            </small>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        ';
                        $no++;
                    }
                }
                
            }
        }
    }
?>
<script>
    //Ketika class 'pilih-lokasi' di click
    $(document).on('click', '.pilih-ongkir', function() {
        // Mengambil nilai data-id
        var cost = $(this).data('cost');
        var service = $(this).data('service');

        //Tempelkan kedua variabel ke form
        $('#ongkir').val(cost);
        $('#paket').val(service);
        
        //tutup modal
        $('#ModalCariOngkir').modal('hide');
    });
</script>