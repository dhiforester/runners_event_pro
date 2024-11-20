<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "List Vidio";

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
                        
                        //Hitung Jumlah Data Vidio
                        $jumlah_data=mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_vidio FROM web_vidio"));
                        if(empty($jumlah_data)){
                            $keterangan = "Tidak Ada Konten Vidio Yang Bisa Ditampilkan";
                        }else{
                            //Apabila Variabel Limit Kosong Maka Secara Default Akan Menampilkan 8 Data Member Terbaru
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
                                $OrderBy="datetime";
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
                            // Persiapkan Query untuk Mengambil Data Vidio
                            $QryVidio = $Conn->prepare("SELECT id_web_vidio, sumber_vidio, title_vidio, deskripsi, datetime, thumbnail FROM web_vidio ORDER BY $OrderBy $ShortBy LIMIT $posisi, $limit");
                            $QryVidio->execute();
                            $ResultVidio = $QryVidio->get_result();
                            //Buat Metadata
                            $list_vidio=[];
                            while ($DataVidio = $ResultVidio->fetch_assoc()) {
                                $id_web_vidio=$DataVidio['id_web_vidio'];
                                $sumber_vidio=$DataVidio['sumber_vidio'];
                                $title_vidio=$DataVidio['title_vidio'];
                                $deskripsi=$DataVidio['deskripsi'];
                                $datetime=$DataVidio['datetime'];
                                $thumbnail=$DataVidio['thumbnail'];
                                if(!empty($thumbnail)){
                                    $thumbnail_path="$base_url/_Api/Vidio/ImageProxy.php?thumbnail=$thumbnail";
                                }else{
                                    if($sumber_vidio=="Url"){
                                        $thumbnail_path="$base_url/_Api/Vidio/ImageProxy.php?thumbnail=Vidio-Url.png";
                                    }else{
                                        if($sumber_vidio=="Embed"){
                                            $thumbnail_path="$base_url/_Api/Vidio/ImageProxy.php?thumbnail=Vidio-Embed.png";
                                        }else{
                                            $thumbnail_path="$base_url/_Api/Vidio/ImageProxy.php?thumbnail=Vidio-File.png";
                                        }
                                    }
                                    
                                }
                                // Add to array
                                $list_vidio[] = [
                                    "id_web_vidio" => $id_web_vidio,
                                    "sumber_vidio" => $sumber_vidio,
                                    "title_vidio" => $title_vidio,
                                    "deskripsi" => $deskripsi,
                                    "datetime" => $datetime,
                                    "thumbnail" => $thumbnail_path
                                ];
                            }
                            $metadata= [
                                "jumlah_data" => $jumlah_data,
                                "limit" => $limit,
                                "page" => $page,
                                "jumlah_halaman" => $jumlah_halaman,
                                "list_vidio" => $list_vidio
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
