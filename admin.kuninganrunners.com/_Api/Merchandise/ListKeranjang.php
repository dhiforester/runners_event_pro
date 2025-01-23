<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "List Keranjang";

    // Setting default response
    $code = 201;
    $keterangan = "Terjadi kesalahan";
    $metadata = [];

    // Validasi Metode Pengiriman Data
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $keterangan = "Metode Pengiriman Data Hanya Boleh Menggunakan POST";
    } else {
        try {
            // Tangkap Header
            $headers = getallheaders();
            
            // Validasi x-token tidak boleh kosong
            if (!isset($headers['x-token'])) {
                $keterangan = "x-token Tidak Boleh Kosong";
            } else {
                // Tangkap data dan decode
                $raw = file_get_contents('php://input');
                $Tangkap = json_decode($raw, true);
                // Validasi email tidak boleh kosong
                if (!isset($Tangkap['email'])) {
                    $keterangan = "Email Tidak Boleh Kosong";
                } else {
                    // Validasi id_member_login tidak boleh kosong
                    if (!isset($Tangkap['id_member_login'])) {
                        $keterangan = "ID Member Login Tidak Boleh Kosong";
                    } else {
                        // Buat Dalam Bentukk Variabel
                        $xtoken = validateAndSanitizeInput($headers['x-token']);
                        $email = validateAndSanitizeInput($Tangkap['email']);
                        $id_member_login = validateAndSanitizeInput($Tangkap['id_member_login']);
                        // Validasi x-token menggunakan prepared statements
                        $stmt = $Conn->prepare("SELECT * FROM api_session WHERE xtoken = ?");
                        $stmt->bind_param("s", $xtoken);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $DataValidasiToken = $result->fetch_assoc();
                        
                        if ($DataValidasiToken) {
                            $datetime_creat = $DataValidasiToken['datetime_creat'];
                            $datetime_expired = $DataValidasiToken['datetime_expired'];
                            
                            // Cek Token Apakah Masih Berlaku
                            if ($now >= $datetime_creat && $now <= $datetime_expired) {
                                // Validasi berhasil, lanjutkan dengan logika
                                $id_api_session = $DataValidasiToken['id_api_session'];
                                $id_setting_api_key = $DataValidasiToken['id_setting_api_key'];
                                $title_api_key = GetDetailData($Conn, 'setting_api_key', 'id_setting_api_key', $id_setting_api_key, 'title_api_key');
                                
                                //Validasi email Dan id_member_login
                                $stmt = $Conn->prepare("SELECT * FROM member_login WHERE id_member_login = ?");
                                $stmt->bind_param("s", $id_member_login);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $DataMember = $result->fetch_assoc();
                                if (!empty($DataMember['id_member'])) {
                                    $id_member=$DataMember['id_member'];
                                    $datetime_expired=$DataMember['datetime_expired'];
                                    //Cek Apakah Sessi Login Sudah Berakhir?
                                    if($datetime_expired<$now){
                                        $keterangan = "Sessi Login Sudah Berakhir";
                                    }else{
                                        //Buka Email Di Database
                                        $email_member=GetDetailData($Conn, 'member', 'id_member', $id_member, 'email');
                                        //Cek Apakah Email Sesuai
                                        if($email_member!==$email){
                                            $keterangan = "Email dengan ID Login Tidak Sesuai ($email_member | $email)";
                                        }else{
                                            // Cek Apakah Ada Item Keranjang Untuk Member Ini
                                            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_keranjang FROM transaksi_keranjang WHERE id_member='$id_member'"));
                                            if(empty($jml_data)){
                                                $list_keranjang="";
                                            }else{
                                                $list_keranjang=[];
                                                $QryKeranjang = $Conn->prepare("SELECT * FROM transaksi_keranjang WHERE id_member='$id_member' ORDER BY id_transaksi_keranjang DESC");
                                                $QryKeranjang->execute();
                                                $ResultKeranjang = $QryKeranjang->get_result();
                                                while ($DataKeranjang = $ResultKeranjang->fetch_assoc()) {
                                                    $id_transaksi_keranjang=$DataKeranjang['id_transaksi_keranjang'];
                                                    $id_barang =$DataKeranjang['id_barang'];
                                                    $id_varian =$DataKeranjang['id_varian'];
                                                    $qty =$DataKeranjang['qty'];
                                                    //Buka Detail Barang
                                                    $nama_barang=GetDetailData($Conn,'barang','id_barang',$id_barang,'nama_barang');
                                                    $kategori=GetDetailData($Conn,'barang','id_barang',$id_barang,'kategori');
                                                    $satuan=GetDetailData($Conn,'barang','id_barang',$id_barang,'satuan');
                                                    $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                                                    $stok=GetDetailData($Conn,'barang','id_barang',$id_barang,'stok');
                                                    $varian=GetDetailData($Conn,'barang','id_barang',$id_barang,'varian');
                                                    $dimensi=GetDetailData($Conn,'barang','id_barang',$id_barang,'dimensi');
                                                    $harga_varian_fix=$harga;
                                                    $nama_varian_fix="";
                                                    //Ubah Data Json Ke Array
                                                    $varian_arry=json_decode($varian,true);
                                                    $dimensi_arry=json_decode($dimensi,true);
                                                    //Buka Berat
                                                    $berat=$dimensi_arry['berat'];
                                                    //Buka Data Varian
                                                    $varian_data= [];
                                                    foreach($varian_arry as $varian_list){
                                                        if(!empty($varian_list['foto_varian'])){
                                                            $path_foto_varian=''.$base_url.'/_Api/Merchandise/ImageProxy.php?foto='.$varian_list['foto_varian'].'';
                                                        }else{
                                                            $path_foto_varian="$base_url/assets/img/No-Image.png";
                                                        }
                                                        if(!empty($varian_list['id_varian'])){
                                                            $id_varian_list=$varian_list['id_varian'];
                                                        }else{
                                                            $id_varian_list="";
                                                        }
                                                        if(!empty($varian_list['nama_varian'])){
                                                            $nama_varian=$varian_list['nama_varian'];
                                                        }else{
                                                            $nama_varian="";
                                                        }
                                                        if(!empty($varian_list['stok_varian'])){
                                                            $stok_varian=$varian_list['stok_varian'];
                                                        }else{
                                                            $stok_varian="";
                                                        }
                                                        if(!empty($varian_list['harga_varian'])){
                                                            $harga_varian=$varian_list['harga_varian'];
                                                        }else{
                                                            $harga_varian="";
                                                        }
                                                        if(!empty($varian_list['keterangan_varian'])){
                                                            $keterangan_varian=$varian_list['keterangan_varian'];
                                                        }else{
                                                            $keterangan_varian="";
                                                        }
                                                        $varian_data[]= [
                                                            "id_varian" => $id_varian_list,
                                                            "foto_varian" => $path_foto_varian,
                                                            "nama_varian" => $nama_varian,
                                                            "stok_varian" => $stok_varian,
                                                            "harga_varian" => $harga_varian,
                                                            "keterangan_varian" => $keterangan_varian,
                                                        ];
                                                        //Menentukan Harga Jika Ada Varian
                                                        if($id_varian_list==$id_varian){
                                                            $harga_varian_fix=$harga_varian;
                                                            $nama_varian_fix=$nama_varian;
                                                        }
                                                    }
                                                    $detail_barang= [
                                                        "nama_barang" => $nama_barang,
                                                        "kategori" => $kategori,
                                                        "satuan" => $satuan,
                                                        "harga" => $harga,
                                                        "stok" => $stok,
                                                        "berat" => $berat,
                                                        "varian" => $varian_data
                                                    ];
                                                    $list_keranjang[] = [
                                                        "id_transaksi_keranjang" => $id_transaksi_keranjang,
                                                        "id_barang" => $id_barang,
                                                        "detail_barang" => $detail_barang,
                                                        "id_varian_checked" => $id_varian,
                                                        "nama_varian_display" => $nama_varian_fix,
                                                        "harga_fix" => $harga_varian_fix,
                                                        "qty" => $qty
                                                    ];
                                                }
                                            }
                                            $metadata = [
                                                "id_member" => $id_member,
                                                "keranjang" => $jml_data,
                                                "list_keranjang" => $list_keranjang
                                            ];
                                            
                                            //menyimpan Log
                                            $SimpanLog = insertLogApi($Conn, $id_setting_api_key, $title_api_key, $service_name, 200, "success", $now);
                                            if ($SimpanLog !== "Success") {
                                                $keterangan = "Gagal Menyimpan Log Service";
                                                $code = 201;
                                            } else {
                                                $keterangan = "success";
                                                $code = 200;
                                            }
                                        }
                                    }
                                }else{
                                    $keterangan = "Sessi Login Tidak Ditemukan";
                                }
                            } else {
                                $keterangan = "X-Token Yang Digunakan Sudah Tidak Berlaku";
                            }
                        } else {
                            $keterangan = "X-Token Yang Digunakan Tidak Valid";
                        }
                        $stmt->close();
                    }
                }
            }
        } catch (Exception $e) {
            $keterangan = "Terjadi kesalahan sistem: " . $e->getMessage();
            $code = 500;
        }
    }
    // Menyiapkan respons
    $response = [
        "message" => $keterangan,
        "code" => $code,
    ];

    $Array = [
        "response" => $response,
        "metadata" => $metadata ?? []
    ];

    // Kirim JSON response
    header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + (10 * 60)));
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header('Content-Type: application/json');
    header('Pragma: no-cache');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, x-token, token");
    echo json_encode($Array, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit();
?>
