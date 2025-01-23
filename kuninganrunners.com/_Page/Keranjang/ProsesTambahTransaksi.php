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
                if (empty($_POST['metode_pengiriman'])) {
                    $ValidasiKelengkapanData="Metode Pengriman Tidak Boleh Kosong";
                }else{
                    $metode_pengiriman=$_POST['metode_pengiriman'];
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
                            
                            //Buat Variabel
                            $item_keranjang=$_POST['item_keranjang'];
                            $metode_pengiriman =$_POST['metode_pengiriman'];
                            $nama_member =$_POST['nama_member'];
                            $kontak_member =$_POST['kontak_member'];
                            
                            //Email dan id_member_login Dari 'Session'
                            $email =$_SESSION['email'];
                            $id_member_login =$_SESSION['id_member_login'];
                            
                            //Validasi Form Lanjutan Berdasarkan metode pengiriman
                            if($metode_pengiriman=="Dikirim"){
                                if(empty($_POST['alamt_pengiriman'])){
                                    $validasi_fase2="Alamat Pengiriman Tidak Boleh Kosong!";
                                }else{
                                    if(empty($_POST['kurir'])){
                                        $validasi_fase2="Nama Kurir/Expedisi Tidak Boleh Kosong!";
                                    }else{
                                        if(empty($_POST['rt_rw'])){
                                            $validasi_fase2="Keterangan Alamat Lainnya Tidak Boleh Kosong!";
                                        }else{
                                            if(empty($_POST['cost_ongkir_item'])){
                                                $validasi_fase2="Paket Tarif Kurir/Expedisi Tidak Boleh Kosong!";
                                            }else{
                                                $validasi_fase2="Valid";
                                            }
                                        }
                                    }
                                }
                            }else{
                                $validasi_fase2="Valid";
                            }
                            //Buat Aray Item Keranjang
                            $list_keranjang=[];
                            foreach ($item_keranjang as $item_keranjang_list) {
                                $explode=explode('|',$item_keranjang_list);
                                $id_transaksi_keranjang=$explode[0];
                                $list_keranjang[]=$id_transaksi_keranjang;
                            }

                            //Membuat Data 'pengiriman' berdasarkan metode
                            if($metode_pengiriman=="Dikirim"){
                                $alamt_pengiriman=$_POST['alamt_pengiriman'];
                                $kurir=$_POST['kurir'];
                                $rt_rw=$_POST['rt_rw'];
                                $cost_ongkir_item=$_POST['cost_ongkir_item'];
                                $pengiriman=[
                                    "metode" => $metode_pengiriman,
                                    "alamt_pengiriman" => $alamt_pengiriman,
                                    "kurir" => $kurir,
                                    "rt_rw" => $rt_rw,
                                    "nama" => $nama_member,
                                    "kontak" => $kontak_member,
                                    "cost_ongkir_item" => $cost_ongkir_item,
                                ];
                            }else{
                                $pengiriman=[
                                    "metode" => $metode_pengiriman
                                ];
                            }
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
                                    "pengiriman" => $pengiriman
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
