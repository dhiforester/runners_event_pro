<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "List Event";

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
                        // Validasi berhasil, Buka informasi token
                        $id_api_session = $DataValidasiToken['id_api_session'];
                        $id_setting_api_key = $DataValidasiToken['id_setting_api_key'];
                        $title_api_key = GetDetailData($Conn, 'setting_api_key', 'id_setting_api_key', $id_setting_api_key, 'title_api_key');
                        
                        // Tangkap data dan decode
                        $raw = file_get_contents('php://input');
                        $Tangkap = json_decode($raw, true);

                        //Validasi id_event
                        if (!isset($Tangkap['id_event'])) {
                            $keterangan = "ID Event Tidak Boleh Kosong";
                        }else{
                            
                            $id_event=validateAndSanitizeInput($Tangkap['id_event']);
                            //Variabel Lain

                            //Secara default limit=100
                            if (!isset($Tangkap['limit'])) {
                                $batas = "100";
                            }else{
                                $batas = validateAndSanitizeInput($Tangkap['limit']);
                            }
                            
                            //Secara default page=1
                            if (!isset($Tangkap['page'])) {
                                $page = "100";
                            }else{
                                $page = validateAndSanitizeInput($Tangkap['page']);
                            }

                            //Secara default keyword_by=null
                            if (!isset($Tangkap['keyword_by'])) {
                                $keyword_by = "";
                            }else{
                                $keyword_by = validateAndSanitizeInput($Tangkap['keyword_by']);
                                $valid_keywords = ['nama', 'status'];
                                $keyword_by = in_array($keyword_by, $valid_keywords) ? $keyword_by : '';
                            }

                            //Secara default keyword=null
                            if (!isset($Tangkap['keyword'])) {
                                $keyword = "";
                            }else{
                                $keyword = validateAndSanitizeInput($Tangkap['keyword']);
                            }

                            //Parameter Shorting
                            $ShortBy="DESC";
                            $OrderBy="datetime";
                            $posisi = ( $page - 1 ) * $batas;
                            
                            // Mencari jumlah data
                            // Mencari jumlah data
                            // Mencari jumlah data
                            $whereClauses = ["ep.id_event='$id_event'"];
                            if (!empty($keyword)) {
                                if (empty($keyword_by)) {
                                    $whereClauses[] = "(ep.nama LIKE '%$keyword%' OR ep.email LIKE '%$keyword%' OR ep.datetime LIKE '%$keyword%' OR ep.status LIKE '%$keyword%')";
                                } else {
                                    $whereClauses[] = "ep.$keyword_by LIKE '%$keyword%'";
                                }
                            }

                            $whereCondition = implode(' AND ', $whereClauses);

                            // Query untuk menghitung jumlah data
                            $countQuery = "SELECT COUNT(ep.id_event_peserta) AS total FROM event_peserta ep WHERE $whereCondition";
                            $countResult = mysqli_query($Conn, $countQuery);
                            if (!$countResult) {
                                die("Error executing count query: " . mysqli_error($Conn));
                            }

                            $jml_data = ($countRow = mysqli_fetch_assoc($countResult)) ? (int)$countRow['total'] : 0;

                            // Hitung jumlah halaman
                            $JmlHalaman = ceil($jml_data / $batas);

                            // Buat Data 'list_peserta'
                            $list_peserta = [];
                            if ($jml_data > 0) {
                                $query = "SELECT ep.*, ek.kategori FROM event_peserta ep 
                                        LEFT JOIN event_kategori ek ON ep.id_event_kategori = ek.id_event_kategori
                                        WHERE $whereCondition 
                                        ORDER BY $OrderBy $ShortBy 
                                        LIMIT $posisi, $batas";

                                $result = mysqli_query($Conn, $query);
                                if (!$result) {
                                    die("Error executing data query: " . mysqli_error($Conn));
                                }

                                while ($DataEvent = mysqli_fetch_assoc($result)) {
                                    $list_peserta[] = [
                                        "id_event_peserta" => $DataEvent['id_event_peserta'] ?? null,
                                        "nama" => $DataEvent['nama'] ?? null,
                                        "kategori" => $DataEvent['kategori'] ?? null,
                                    ];
                                }
                            }

                            // Metadata output
                            $metadata = [
                                "curent_page" => $page,
                                "total_page" => $JmlHalaman,
                                "total_data" => $jml_data,
                                "list_peserta" => $list_peserta,
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
