<?php
    // Koneksi Dan Pengaturan lainnya
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    //Apakah Keyword Diisi
    if(empty($_POST['keyword_alamat'])){
        echo '
            <div class="alert alert-danger text-center">
                Isi Keyword Terlebih Dulu
            </div>
        ';
    }else{
        //Membuka Setting Raja Ongkir
        $base_url_raja_ongkir=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'base_url');
        $api_key=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'api_key');
        $password=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'password');
        $origin_id=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'origin_id');
        $origin_label=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'origin_label');
        //Variabel keyword
        $keyword_alamat=$_POST['keyword_alamat'];
        //Persiapan Pencarian
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$base_url_raja_ongkir.'/destination/domestic-destination?search='.$keyword_alamat.'&limit=100&offset=0',
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
                echo '<div class="table table-responsive">';
                echo '  <table class="table table-hover">';
                echo '      
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Wilayah</th>
                            </tr>
                        </thead>
                ';
                echo '  <tbody>';
                $no=1;
                foreach($response_arry['data'] as $list){
                    echo '
                        <tr>
                            <td class="text-center">
                                <small>'.$no.'</small>
                            </td>
                            <td class="text-left">
                                <small>
                                    <a href="javascript:void(0);" class="pilih-lokasi" data-id="'.$list['id'].'">'.$list['label'].'</a>
                                </small>
                            </td>
                        </tr>
                    ';
                    $no++;
                }
                echo '      </tbody>';
                echo '  </table>';
                echo '</div>';
            }else{
                echo '
                    <div class="alert alert-danger">Pencarian Tidak Ditemukan</div>
                ';
            }
        }
    }
?>
<script>
    //Ketika class 'pilih-lokasi' di click
    $(document).on('click', '.pilih-lokasi', function() {
        // Mengambil nilai data-id
        var dataId = $(this).data('id');

        // Mengambil konten HTML (teks dari elemen)
        var contentHtml = $(this).html();

        //Tempelkan kedua variabel ke form
        $('#alamat_pengiriman').val(''+dataId+'-'+contentHtml+'');
        
        //tutup modal
        $('#ModalCariAlamat').modal('hide');
    });
</script>