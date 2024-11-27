<?php
    session_start();
    // Koneksi Dan Pengaturan lainnya
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    date_default_timezone_set("Asia/Jakarta");
    $kode_transaksi ="";
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
    // Inisialisasi pesan error
    $message ="";
    $code =201; 
    //Periksa Apakah Token Ada atau Berhasil Dibuat
    if(empty($xtoken)){
        $message ="Terjadi Kesalahan Pada Saat Membuat Token Akses Ke Server";
        $code =201; 
    }else{
        //Buat Session
        $_SESSION['datetime_expired'] = $datetime_expired;
        $_SESSION['xtoken'] = $xtoken;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validasi data input tidak boleh kosong
            if (empty($_POST['item_keranjang'])) {
                $ValidasiKelengkapanData="Item Keranjang tidak boleh kosong! Anda harus memilih item keranjang terlebih dulu.";
            }else{
                if (empty($_POST['desa'])) {
                    $ValidasiKelengkapanData="Silahkan lengkapi alamat pengiriman terlebih dulu";
                }else{
                    if (empty($_POST['rt_rw'])) {
                        $ValidasiKelengkapanData="Detail alamat tidak boleh kosong. Berikan keterangan alamat untuk pengiriman yang valid.";
                    }else{
                        if (empty($_POST['nama_member'])) {
                            $ValidasiKelengkapanData="Nama member tidak boleh kosong";
                        }else{
                            if (empty($_POST['kontak_member'])) {
                                $ValidasiKelengkapanData="Kontak member tidak boleh kosong. Lengkapi profil anda terlebih dulu";
                            }else{
                                $ValidasiKelengkapanData="Valid";
                            }
                        }
                    }
                }
            }
            if($ValidasiKelengkapanData!=="Valid"){
                $message =$ValidasiKelengkapanData;
                $code =201; 
            }else{
                // Validasi panjang karakter
                $ValidasiJumlahKarakter="Valid";
                if($ValidasiJumlahKarakter!=="Valid"){
                    $message =$ValidasiJumlahKarakter;
                    $code =201; 
                }else{
                    //Validasi Tipe Data
                    $ValidasiTipeData='Valid';
                    if($ValidasiTipeData!=="Valid"){
                        $message =$ValidasiTipeData;
                        $code =201; 
                    }else{
                        //Validasi Session
                        if(empty($_SESSION['id_member_login'])){
                            $ValidasiSessionMember="Silahkan login terlebih dulu!";
                        }else{
                            if($_SESSION['login_expired']<date('Y-m-d H:i:s')){
                                $expiredDate=$_SESSION['login_expired'];
                                $ValidasiSessionMember="Sesi Akses Member Sudah Berakhir Pada $expiredDate, Silahkan Login Ulang!";
                            }else{
                                $ValidasiSessionMember="Valid";
                            }
                        }
                        if($ValidasiSessionMember!=="Valid"){
                            $message =$ValidasiSessionMember;
                            $code =201; 
                        }else{
                            $item_keranjang=$_POST['item_keranjang'];
                            $email =$_SESSION['email'];
                            $id_wilayah =$_POST['desa'];
                            $rt_rw =$_POST['rt_rw'];
                            if(empty($_POST['kode_pos'])){
                                $kode_pos="";
                            }else{
                                $kode_pos=$_POST['kode_pos'];
                            }
                            $nama_member=$_POST['nama_member'];
                            $kontak_member=$_POST['kontak_member'];
                            $id_member_login =$_SESSION['id_member_login'];
                            //Buat Aray Item Keranjang
                            $list_keranjang=[];
                            foreach ($item_keranjang as $item_keranjang_list) {
                                $explode=explode('|',$item_keranjang_list);
                                $id_transaksi_keranjang=$explode[0];
                                $list_keranjang[]=$id_transaksi_keranjang;
                            }
                            //Membuat Raw Alamat Pengiriman
                            $pengiriman=[
                                "id_wilayah" => $id_wilayah,
                                "rt_rw" => $rt_rw,
                                "kode_pos" => $kode_pos,
                                "nama" => $nama_member,
                                "kontak" => $kontak_member,
                            ];
                            //Persiapan Mengirim Data Ke Server
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => $url_server . '/_Api/Merchandise/KirimPesanan.php',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode(array(
                                    "email" => $email,
                                    "id_member_login" => $id_member_login,
                                    "list_keranjang" => $list_keranjang,
                                    "pengiriman" => $pengiriman,
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
                                $code =201; 
                            }else{
                                if (empty($response)) {
                                    $message ="Tidak Ada Response Apapun";
                                    $code =201; 
                                }else{
                                    $arry = json_decode($response, true);
                                    if ($arry['response']['code'] !== 200) {
                                        $message =$arry['response']['message'];
                                        $code =201; 
                                    }else{
                                        $kode_transaksi =$arry['metadata']['kode_transaksi'];
                                        $message=$arry['response']['message'];
                                        $code =$arry['response']['code'];
                                    }
                                }
                            }
                            curl_close($curl);
                        }
                    }
                }
            }
        }else{
            $message ="Metode Pengiriman Data Hanya Boleh POST";
            $code =201; 
        }
    }
    //Membuat Array
    $response=[
        "message" => "$message",
        "kode_transaksi" => "$kode_transaksi",
        "code"=> $code
    ];
    echo json_encode($response);
    exit;
?>
