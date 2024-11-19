<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "List Merchandise";

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
                        //Hitung Jumlah Data Merchandise Dan Properti Paging
                        $jumlah_data=mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang FROM barang"));
                        if(empty($_GET['limit'])){
                            $limit=0;
                        }else{
                            $limit=$_GET['limit'];
                        }
                        if(empty($_GET['page'])){
                            $page=1;
                            $posisi = 0;
                        }else{
                            $page=$_GET['page'];
                            $posisi = ( $page - 1 ) * $limit;
                        }
                        if(empty($_GET['OrderBy'])){
                            $OrderBy="id_barang";
                        }else{
                            $OrderBy=$_GET['OrderBy'];
                        }
                        if(empty($_GET['ShortBy'])){
                            $ShortBy="DESC";
                        }else{
                            $ShortBy=$_GET['ShortBy'];
                        }
                        if(!empty($limit)){
                            $jumlah_halaman = ceil($jumlah_data/$limit); 
                        }else{
                            $jumlah_halaman =1; 
                        }
                        
                        // Persiapkan Query untuk Mengambil Data Album
                        if(empty($limit)){
                            $QryBarang = $Conn->prepare("SELECT * FROM barang ORDER BY $OrderBy $ShortBy");
                        }else{
                            $QryBarang = $Conn->prepare("SELECT * FROM barang ORDER BY $OrderBy $ShortBy LIMIT $posisi, $limit");
                        }
                        $QryBarang->execute();
                        $ResultBarang = $QryBarang->get_result();

                        $list_barang=[];
                        while ($DataBarang = $ResultBarang->fetch_assoc()) {
                            $id_barang=$DataBarang['id_barang'];
                            $nama_barang=$DataBarang['nama_barang'];
                            $kategori=$DataBarang['kategori'];
                            $satuan=$DataBarang['satuan'];
                            $harga=$DataBarang['harga'];
                            $stok=$DataBarang['stok'];
                            $dimensi=$DataBarang['dimensi'];
                            $deskripsi=$DataBarang['deskripsi'];
                            $varian=$DataBarang['varian'];
                            $datetime=$DataBarang['datetime'];
                            $updatetime=$DataBarang['updatetime'];
                            $foto=$DataBarang['foto'];
                            if(!empty($foto)){
                                $image_path="$base_url/assets/img/Marchandise/$foto";
                            }else{
                                $image_path="$base_url/assets/img/No-Image.png";
                            }
                            
                            //Ubah Data Json Ke Array
                            $dimensi=json_decode($dimensi,true);
                            $varian_arry=json_decode($varian,true);
                            //Buka Data Varian
                            $varian_data= [];
                            foreach($varian_arry as $varian_list){
                                if(!empty($varian_list['foto_varian'])){
                                    $path_foto_varian=''.$base_url.'/assets/img/Marchandise/'.$varian_list['foto_varian'].'';
                                }else{
                                    $path_foto_varian="$base_url/assets/img/No-Image.png";
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
                            // Add to array
                            $list_barang[] = [
                                "id_barang" => $id_barang,
                                "nama_barang" => $nama_barang,
                                "kategori" => $kategori,
                                "satuan" => $satuan,
                                "harga" => $harga,
                                "stok" => $stok,
                                "dimensi" => $dimensi,
                                "varian" => $varian_data,
                                "datetime" => $datetime,
                                "updatetime" => $updatetime,
                                "image" => $image_path
                            ];
                        }
                        // Add to array
                        $metadata= [
                            "jumlah_data" => $jumlah_data,
                            "jumlah_halaman" => $jumlah_halaman,
                            "page" => $page,
                            "limit" => $limit,
                            "list_barang" => $list_barang
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
