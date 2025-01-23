<?php
    session_start();
    // Koneksi Dan Pengaturan lainnya
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    date_default_timezone_set("Asia/Jakarta");
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
    //Periksa Apakah Token Ada atau Berhasil Dibuat
    if(empty($xtoken)){
        echo '
            <div class="alert alert-danger">Terjadi Kesalahan Pada Saat Membuat Token Akses Ke Server</div>
        ';
    }else{
        //Buat Session
        $_SESSION['datetime_expired'] = $datetime_expired;
        $_SESSION['xtoken'] = $xtoken;
        //Apabila keyword tidak ada
        if(empty($_POST['keyword_alamat'])){
            echo '
                <div class="alert alert-danger">Silahkan Isi Keyword Pencarian Terlebih Dulu</div>
            ';
        }else{
            $keyword=$_POST['keyword_alamat'];
            $response=CariAlamat($url_server,$xtoken,$keyword);
            if(empty($response)){
                echo '
                    <div class="alert alert-danger">Tidak ada response dari server</div>
                ';
            }else{
                $response_arry=json_decode($response,true);
                if($response_arry['response']['code']!==200){
                    echo '
                        <div class="alert alert-danger">'.$response_arry['response']['message'].'</div>
                    ';
                }else{
                    echo '<div class="list-group list-group-numbered">';
                    $no=1;
                    foreach ($response_arry['metadata'] as $list){
                        echo '
                            <button type="button" class="list-group-item d-flex align-items-start pilih_alamat" data-id="'.$list['id'].'-'.$list['label'].'">
                                <div class="ms-2">
                                    <small class="text text-secondary">
                                        <code class="text text-grayish mobile-text">'.$list['label'].'</code>
                                    </small>
                                </div>    
                            </button>
                        ';
                        $no++;
                    }
                    echo '</div>';
                }
            }
        }
    }
?>
<script>
    $(document).on('click', '.pilih_alamat', function() {
        // Ambil nilai dari atribut data-id
        var dataId = $(this).data('id');
        //Tempelkan Ke Form
        $('#alamt_pengiriman').val(dataId);
        //Tutup Modal
        $('#ModalCariAlamat').modal('hide');
        //Tampilkan Ongkir
        ProsesHitungOngkir();
    });
</script>
