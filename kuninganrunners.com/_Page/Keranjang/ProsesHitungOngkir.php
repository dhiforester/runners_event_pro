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
    //Periksa Apakah Token Ada atau Berhasil Dibuat
    if(empty($xtoken)){
        $message ="Terjadi Kesalahan Pada Saat Membuat Token Akses Ke Server";
        echo '
            <div class="row">
                <div col-md-12>
                    <div class="alert alert-danger">'.$message.'</div>
                </div>
            </div>
        ';
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
        //Apabila Session Tidak Valid
        if($ValidasiSessionMember!=="Valid"){
            echo '
                <div class="row">
                    <div col-md-12>
                        <div class="alert alert-danger">'.$ValidasiSessionMember.'</div>
                    </div>
                </div>
            ';
        }else{

            //Validasi Parameter Yang Dibutuhan
            if(empty($_POST['alamt_pengiriman'])){
                echo '
                    <div class="row">
                        <div col-md-12>
                            <div class="alert alert-danger">Alamat pengiriman belum dipilih</div>
                        </div>
                    </div>
                ';
            }else{
                if(empty($_POST['kurir'])){
                    echo '
                        <div class="row">
                            <div col-md-12>
                                <div class="alert alert-danger">Kurir pengiriman belum dipilih</div>
                            </div>
                        </div>
                    ';
                }else{
                    if(empty($_POST['item_keranjang'])){
                        echo '
                            <div class="row">
                                <div col-md-12>
                                    <div class="alert alert-danger">Belum ada item barang yang dipilih</div>
                                </div>
                            </div>
                        ';
                    }else{
                        $alamat=$_POST['alamt_pengiriman'];
                        $kurir=$_POST['kurir'];
                        $item_keranjang=$_POST['item_keranjang'];
                        //Hitung Berat
                        $berat_total = 0;
                        $item_keranjang =$_POST['item_keranjang'];
                        //Looping semua jumlah
                        foreach ($item_keranjang as $item_keranjang_list) {
                            $explode=explode('|',$item_keranjang_list);
                            $berat_list=$explode[5];
                            $berat_total = $berat_total+$berat_list;
                        }
                        //Pecah alamat pengiriman
                        $explode=explode('-',$alamat);
                        $id_destination=$explode[0];
                        if(empty($id_destination)){
                            echo '
                                <div class="row">
                                    <div col-md-12>
                                        <div class="alert alert-danger">ID Tujuan Pengiriman Tidak Ditemukan!</div>
                                    </div>
                                </div>
                            ';
                        }else{
                            $id_member_login =$_SESSION['id_member_login'];
                            //Kiriim Service
                            $response=HitungOngkiir($url_server,$xtoken,$id_member_login,$id_destination,$kurir,$berat_total);
                            if(empty($response)){
                                echo '
                                    <div class="row">
                                        <div col-md-12>
                                            <div class="alert alert-danger">Tidak ada response dari service API server!</div>
                                        </div>
                                    </div>
                                ';
                            }else{
                                $response_arry=json_decode($response,true);
                                if(empty($response_arry['response']['code'])){
                                    echo '
                                        <div class="row">
                                            <div col-md-12>
                                                <div class="alert alert-danger">Tidak ada response dari service API server!</div>
                                            </div>
                                        </div>
                                    ';
                                }else{
                                    if(empty(count($response_arry['metadata']))){
                                        echo '
                                            <div class="row">
                                                <div col-md-12>
                                                    <div class="alert alert-danger">Item Ongkir Tidak Ditemukan!</div>
                                                </div>
                                            </div>
                                        ';
                                    }else{
                                        echo '
                                            <div class="row mb-3">
                                                <div class="col-md-3"><small>Berat</small></div>
                                                <div class="col-md-9"><small class="text text-secondary">'.$berat_total.' Kg</small></div>
                                            </div>
                                        ';
                                        echo '
                                            <div class="row mb-3">
                                                <div class="col-md-3"><small>Pilh Ongkir/Paket</small></div>
                                                <div class="col-md-9">
                                        ';
                                                $no=1;
                                                foreach ($response_arry['metadata'] as $list) {
                                                    $name=$list['name'];
                                                    $service=$list['service'];
                                                    $description=$list['description'];
                                                    $cost=$list['cost'];
                                                    $etd=$list['etd'];
                                                    //Foirmat Rupiah
                                                    $cost_format = 'Rp ' . number_format($cost, 0, ',', '.');
                                                    echo '
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="radio" name="cost_ongkir_item" id="ongkir_item_'.$no.'" value="'.$cost.'|'.$service.'">
                                                            <label class="form-check-label" for="ongkir_item_'.$no.'">
                                                                <small class="text-dark">'.$service.' ('.$cost_format.')</small><br>
                                                                <small>
                                                                    <code class="text-secondary">'.$description.' (Estimasi '.$etd.')</code>
                                                                </small>
                                                            </label>
                                                        </div>
                                                    ';
                                                    $no++;
                                                }
                                        echo '
                                                </div>
                                            </div>
                                        ';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>