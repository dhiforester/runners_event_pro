<?php
    session_start();
    // Koneksi Dan Pengaturan lainnya
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    date_default_timezone_set("Asia/Jakarta");
    
    $id_event ="";
    $curent_page="";
    $total_page="";
    $total_data="";
    $keyword="";
    //Apabila Session Datetime expired tidak ada
    if(empty($_SESSION['datetime_expired'])){
        $xtoken="";
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
            <tr><td colspan="3" class="text-center">Terjadi Kesalahan Pada Saat Membuat Token Akses Ke Server</td></tr>
        ';
    }else{
        
        //Buat Session
        $_SESSION['datetime_expired'] = $datetime_expired;
        $_SESSION['xtoken'] = $xtoken;

        // Validasi data input tidak boleh kosong
        if (empty($_POST['id_event'])) {
            $ValidasiKelengkapanData="ID Event tidak boleh kosong! Anda wajib mengisi form tersebut.";
            echo '
                <tr><td colspan="3" class="text-center">'.$ValidasiKelengkapanData.'</td></tr>
            ';
        }else{
            if(empty($_POST['page'])){
                $page=1;
            }else{
                $page=$_POST['page'];
            }
            if(empty($_POST['keyword'])){
                $keyword="";
            }else{
                $keyword=$_POST['keyword'];
            }
            // Bersihkan Variabel Sebelum Dikirim
            $id_event = validateAndSanitizeInput($_POST['id_event']);
            $page = validateAndSanitizeInput($_POST['page']);
            //Persiapan Mengirim Data Ke Server
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url_server . '/_Api/Event/PesertaEvent.php',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode(array(
                    "id_event" => $id_event,
                    "limit" => "10",
                    "page" => $page,
                    "keyword_by" => "",
                    "keyword" => $keyword,
                )),
                CURLOPT_HTTPHEADER => array(
                    'x-token: ' . $xtoken,
                    'Content-Type: application/json'
                ),
            ));

            // Tambahkan opsi ini jika Anda ingin menonaktifkan verifikasi SSL
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            $response = curl_exec($curl);
            //Konmdisi Response Error
            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
                $message =$error_msg;
                $code =205; 
                echo '
                    <tr><td colspan="3" class="text-center">'.$message.'</td></tr>
                ';
            }else{
                if (empty($response)) {
                    $message ="Tidak Ada Response Apapun";
                    echo '
                        <tr><td colspan="3" class="text-center">'.$message.'</td></tr>
                    ';
                }else{
                    $arry = json_decode($response, true);
                    if ($arry['response']['code'] !== 200) {
                        $message =$arry['response']['message'];
                        echo '
                            <tr><td colspan="3" class="text-center">'.$message.'</td></tr>
                        '; 
                    }else{
                        $curent_page=$arry['metadata']['curent_page'];
                        $total_page=$arry['metadata']['total_page'];
                        $total_data=$arry['metadata']['total_data'];
                        $list_peserta=$arry['metadata']['list_peserta'];
                        if(empty(count($list_peserta))){
                            echo '
                                <tr><td colspan="3" class="text-center">Tidak Ada Data Peserta Yang Ditampilkan</td></tr>
                            '; 
                        }else{
                            foreach($list_peserta as $data_peserta){
                                $id_event_peserta=$data_peserta['id_event_peserta'];
                                $nama=$data_peserta['nama'];
                                $kategori=$data_peserta['kategori'];
                                $shortened_id = '***' . substr($id_event_peserta, 0, 5);
                                echo '
                                    <tr>
                                        <td class="text-left"><small>'.$shortened_id.'</small></td>
                                        <td class="text-left"><small>'.$nama.'</small></td>
                                        <td class="text-left"><small>'.$kategori.'</small></td>
                                    </tr>
                                ';
                            }
                        }
                    }
                }
            }
            curl_close($curl);
        }
    }
?>
<script>
    var curent_page = <?php echo $curent_page; ?>;
    var jumlah_halaman = <?php echo $total_page; ?>;

    // Tempel data ke tombol paging
    $('#PageButton').html('' + curent_page + '/' + jumlah_halaman + '');

    // Disable prev button if on the first page
    if (curent_page == 1) {
        $('#PrevButton').prop('disabled', true);
    }else{
        $('#PrevButton').prop('disabled', false);
    }

    // Disable next button if on the last page
    if (curent_page == jumlah_halaman) {
        $('#NextButton').prop('disabled', true);
    }else{
        $('#NextButton').prop('disabled', false);
    }
</script>
