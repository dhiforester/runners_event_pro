<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Summary";

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
                        
                        // LIST EVENT
                        $event_list=[];
                        $QryEvent = $Conn->prepare("SELECT * FROM event WHERE tanggal_selesai >= ? ORDER BY id_event DESC");
                        $QryEvent->bind_param("s", $now);
                        $QryEvent->execute();
                        $resultEvent = $QryEvent->get_result();
                        while ($DataEvent = $resultEvent->fetch_assoc()) {
                            $id_event=$DataEvent['id_event'];
                            // Add to array
                            $event_list[] = [
                                "id_event" => $DataEvent['id_event'] ?? null,
                                "tanggal_mulai" => $DataEvent['tanggal_mulai'] ?? null,
                                "tanggal_selesai" => $DataEvent['tanggal_selesai'] ?? null,
                                "mulai_pendaftaran" => $DataEvent['mulai_pendaftaran'] ?? null,
                                "selesai_pendaftaran" => $DataEvent['selesai_pendaftaran'] ?? null,
                                "nama_event" => $DataEvent['nama_event'] ?? null,
                                "keterangan" => $DataEvent['keterangan'] ?? null
                            ];
                        }
                        $QryEvent->close();
                        // MEDSOS
                        $medsos=[];
                        $QryMedsos = $Conn->prepare("SELECT * FROM web_medsos ORDER BY id_web_medsos ASC");
                        $QryMedsos->execute();
                        $ResultMedsos = $QryMedsos->get_result();
                        while ($DataMedsos = $ResultMedsos->fetch_assoc()) {
                            $logo=$DataMedsos['logo'];
                            $logo_path = "$base_url/assets/img/Medsos/$logo";
                            $logo_path = "$base_url/_API/Web/image-proxy-medsos.php?file=$logo";
                            // Add to array
                            $medsos[] = [
                                "nama_medsos" => $DataMedsos['nama_medsos'] ?? null,
                                "url_medsos" => $DataMedsos['url_medsos'] ?? null,
                                "logo" => $logo_path
                            ];
                        }
                        $QryMedsos->close();
                        // ALBUM
                        $album_list=[];
                        $QryAlbum = $Conn->prepare("SELECT DISTINCT album FROM web_galeri ORDER BY id_web_galeri DESC LIMIT 4");
                        $QryAlbum->execute();
                        $ResultAlbum = $QryAlbum->get_result();
                        if ($ResultAlbum->num_rows > 0) {
                            while ($DataAlbum = $ResultAlbum->fetch_assoc()) {
                                $Album=$DataAlbum['album'];
                                //Jumlah Galery
                                $JumlahFile=mysqli_num_rows(mysqli_query($Conn, "SELECT id_web_galeri FROM web_galeri WHERE album='$Album'"));
                                $file_galeri = GetDetailData($Conn, 'web_galeri', 'album', $Album, 'file_galeri');
                                $image_path = "$base_url/_API/Web/image-proxy-galeri.php?file=$file_galeri";
                                // Add to array
                                $album_list[] = [
                                    "album" => $Album,
                                    "galeri" => $JumlahFile,
                                    "image" => $image_path
                                ];
                            }
                        }
                        $QryAlbum->close();

                        //TESTIMONI
                        $testimoni_list=[];
                        $QryTestimoni = $Conn->prepare("SELECT id_web_testimoni, id_member, nik_name, penilaian, testimoni, foto_profil, datetime FROM web_testimoni WHERE status='Publish' ORDER BY id_web_testimoni DESC LIMIT 1, 12");
                        $QryTestimoni->execute();
                        $ResultTestimoni = $QryTestimoni->get_result();
                        while ($DataTestimoni = $ResultTestimoni->fetch_assoc()) {
                            $id_web_testimoni=$DataTestimoni['id_web_testimoni'];
                            $id_member=$DataTestimoni['id_member'];
                            if(empty($DataTestimoni['nik_name'])){
                                $nik_name="None";
                            }else{
                                $nik_name=$DataTestimoni['nik_name'];
                            }
                            $penilaian=$DataTestimoni['penilaian'];
                            $testimoni=$DataTestimoni['testimoni'];
                            if(empty($DataTestimoni['foto_profil'])){
                                $foto_profil="";
                            }else{
                                $foto_profil=$DataTestimoni['foto_profil'];
                            }
                            $datetime=$DataTestimoni['datetime'];
                            //Membuka Member
                            $nama = GetDetailData($Conn, 'member', 'id_member', $id_member, 'nama');
                            // Add to array
                            $testimoni_list[] = [
                                "id_web_testimoni" => $id_web_testimoni,
                                "nama" => $nik_name,
                                "penilaian" => $penilaian,
                                "datetime" => $datetime,
                                "foto_profil" => $foto_profil
                            ];
                        }
                        $QryTestimoni->close();

                        // FAQ
                        $faq_list=[];
                        $QryFaq = $Conn->prepare("SELECT * FROM web_faq ORDER BY urutan ASC");
                        $QryFaq->execute();
                        $ResultFaq = $QryFaq->get_result();
                        while ($DataFaq = $ResultFaq->fetch_assoc()) {
                            // Add to array
                            $faq_list[] = [
                                "urutan" => $DataFaq['urutan'] ?? null,
                                "pertanyaan" => $DataFaq['pertanyaan'] ?? null,
                                "jawaban" => $DataFaq['jawaban'] ?? null
                            ];
                        }
                        $QryFaq->close();

                        //Event All
                        $event_list_all=[];
                        $QryEventAll = $Conn->prepare("SELECT id_event, tanggal_mulai, nama_event FROM event ORDER BY tanggal_mulai DESC");
                        $QryEventAll->execute();
                        $ResultEventAll = $QryEventAll->get_result();
                        
                        while ($DataEvent = $ResultEventAll->fetch_assoc()) {
                            // Add to array
                            $event_list_all[] = [
                                "id_event" => $DataEvent['id_event'] ?? null,
                                "tanggal_mulai" => $DataEvent['tanggal_mulai'] ?? null,
                                "nama_event" => $DataEvent['nama_event'] ?? null
                            ];
                        }
                        $QryEventAll->close();

                        //MERCH
                        $list_barang=[];
                        $QryBarang = $Conn->prepare("SELECT id_barang, nama_barang, harga, foto FROM barang ORDER BY id_barang DESC LIMIT 1, 4");
                        $QryBarang->execute();
                        $ResultBarang = $QryBarang->get_result();
                        while ($DataBarang = $ResultBarang->fetch_assoc()) {
                            $id_barang=$DataBarang['id_barang'];
                            $nama_barang=$DataBarang['nama_barang'];
                            $harga=$DataBarang['harga'];
                            $foto=$DataBarang['foto'];
                            if(!empty($foto)){
                                $image_path="$base_url/_Api/Merchandise/ImageProxy.php?foto=$foto";
                            }else{
                                $image_path="$base_url/assets/img/No-Image.png";
                            }
                            // Add to array
                            $list_barang[] = [
                                "id_barang" => $id_barang,
                                "nama_barang" => $nama_barang,
                                "harga" => $harga,
                                "image" => $image_path
                            ];
                        }
                        $QryBarang->close();
                        
                        //MEMBER
                        $list_member=[];
                        $QryMember = $Conn->prepare("SELECT id_member, nama, datetime, foto FROM member WHERE status='Active' ORDER BY datetime DESC LIMIT 1, 4");
                        $QryMember->execute();
                        $ResultMember = $QryMember->get_result();
                        while ($DataMember = $ResultMember->fetch_assoc()) {
                            $id_member=$DataMember['id_member'];
                            $nama=$DataMember['nama'];
                            $datetime=$DataMember['datetime'];
                            $foto=$DataMember['foto'];
                            if(!empty($foto)){
                                $image_path="$base_url/_API/Web/image-proxy-member.php?file=$foto";
                            }else{
                                $image_path="";
                            }
                            // Add to array
                            $list_member[] = [
                                "id_member" => $id_member,
                                "nama" => $nama,
                                "datetime" => $datetime,
                                "foto" => $image_path
                            ];
                        }
                        $QryMember->close();
                        //VIDIO
                        $list_vidio=[];
                        $QryVidio = $Conn->prepare("SELECT id_web_vidio, title_vidio, sumber_vidio, thumbnail FROM web_vidio ORDER BY datetime DESC LIMIT 1, 4");
                        $QryVidio->execute();
                        $ResultVidio = $QryVidio->get_result();
                        while ($DataVidio = $ResultVidio->fetch_assoc()) {
                            $id_web_vidio=$DataVidio['id_web_vidio'];
                            $title_vidio=$DataVidio['title_vidio'];
                            $thumbnail=$DataVidio['thumbnail'];
                            $sumber_vidio=$DataVidio['sumber_vidio'];
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
                                "thumbnail" => $thumbnail_path
                            ];
                        }
                        $QryVidio->close();

                        //METADATA
                        $metadata = [
                            "event_list" => $event_list,
                            "medsos" => $medsos,
                            "album_list" => $album_list,
                            "testimoni_list" => $testimoni_list,
                            "faq_list" => $faq_list,
                            "event_list_all" => $event_list_all,
                            "list_barang" => $list_barang,
                            "list_member" => $list_member,
                            "list_vidio" => $list_vidio,
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
