<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Detail Merchandise";

    // Setting default response
    $code = 201;
    $keterangan = "Terjadi kesalahan";
    $metadata = [];

    // Validasi Metode Pengiriman Data
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        $keterangan = "Metode Pengiriman Data Hanya Boleh Menggunakan GET";
    } else {
        try {
            // Tangkap Header
            $headers = getallheaders();
            
            // Validasi x-token tidak boleh kosong
            if (!isset($headers['x-token'])) {
                $keterangan = "x-token Tidak Boleh Kosong";
            } else {
                // Buat Dalam Bentukk Variabel
                $xtoken = validateAndSanitizeInput($headers['x-token']);
                
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
                        if(empty($_GET['id'])){
                            $keterangan = "ID Merchandise Tidak Boleh Kosong!";
                        }else{
                            $id_barang = validateAndSanitizeInput($_GET['id']);
                            // Validasi ID Event
                            $id_barang_validasi=GetDetailData($Conn,'barang','id_barang',$id_barang,'id_barang');
                            if(empty($id_barang_validasi)){
                                $keterangan = "ID Merchandise Tidak Valid";
                            }else{
                                //Buka Detail Merchandise
                                $nama_barang=GetDetailData($Conn,'barang','id_barang',$id_barang,'nama_barang');
                                $kategori=GetDetailData($Conn,'barang','id_barang',$id_barang,'kategori');
                                $satuan=GetDetailData($Conn,'barang','id_barang',$id_barang,'satuan');
                                $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                                $stok=GetDetailData($Conn,'barang','id_barang',$id_barang,'stok');
                                $dimensi=GetDetailData($Conn,'barang','id_barang',$id_barang,'dimensi');
                                $deskripsi=GetDetailData($Conn,'barang','id_barang',$id_barang,'deskripsi');
                                $foto=GetDetailData($Conn,'barang','id_barang',$id_barang,'foto');
                                $varian=GetDetailData($Conn,'barang','id_barang',$id_barang,'varian');
                                $marketplace=GetDetailData($Conn,'barang','id_barang',$id_barang,'marketplace');
                                $datetime=GetDetailData($Conn,'barang','id_barang',$id_barang,'datetime');
                                $updatetime=GetDetailData($Conn,'barang','id_barang',$id_barang,'updatetime');
                                if(!empty($foto)){
                                    $image_path="$base_url/_Api/Merchandise/ImageProxy.php?foto=$foto";
                                }else{
                                    $image_path="$base_url/assets/img/no_image.jpg";
                                }
                                
                                 //Ubah Data Json Ke Array
                                $dimensi=json_decode($dimensi,true);
                                $varian_arry=json_decode($varian,true);
                                //Buka Data Varian
                                $varian_data= [];
                                foreach($varian_arry as $varian_list){
                                    if(!empty($varian_list['foto_varian'])){
                                        $path_foto_varian=''.$base_url.'/_Api/Merchandise/ImageProxy.php?foto='.$varian_list['foto_varian'].'';
                                    }else{
                                        $path_foto_varian="$base_url/assets/img/no_image.jpg";
                                    }
                                    if(!empty($varian_list['id_varian'])){
                                        $id_varian=$varian_list['id_varian'];
                                    }else{
                                        $id_varian="";
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
                                        "id_varian" => $id_varian,
                                        "foto_varian" => $path_foto_varian,
                                        "nama_varian" => $nama_varian,
                                        "stok_varian" => $stok_varian,
                                        "harga_varian" => $harga_varian,
                                        "keterangan_varian" => $keterangan_varian,
                                    ];
                                }
                                //Buka Data Marketplace
                                if(!empty($marketplace)){
                                    $marketplace=json_decode($marketplace, true);
                                }else{
                                    $marketplace="";
                                }
                                $metadata= [
                                    "id_barang" => $id_barang,
                                    "nama_barang" => $nama_barang,
                                    "kategori" => $kategori,
                                    "deskripsi" => $deskripsi,
                                    "satuan" => $satuan,
                                    "harga" => $harga,
                                    "stok" => $stok,
                                    "dimensi" => $dimensi,
                                    "datetime" => $datetime,
                                    "updatetime" => $updatetime,
                                    "varian" => $varian_data,
                                    "marketplace" => $marketplace,
                                    "image" => $image_path,
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
                    } else {
                        $keterangan = "X-Token Yang Digunakan Sudah Tidak Berlaku";
                    }
                } else {
                    $keterangan = "X-Token Yang Digunakan Tidak Valid";
                }
                
                $stmt->close();
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
