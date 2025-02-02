<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "List Event";

    // Default response
    $code = 201;
    $keterangan = "Terjadi kesalahan";
    $metadata = [];

    // Validasi Metode Pengiriman Data
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $keterangan = "Metode Pengiriman Data Hanya Boleh Menggunakan POST";
        $code = 405; // Method Not Allowed
    } else {
        try {
            // Tangkap Header
            $headers = getallheaders();
            
            // Validasi x-token tidak boleh kosong
            if (!isset($headers['x-token'])) {
                $keterangan = "x-token Tidak Boleh Kosong";
                $code = 400; // Bad Request
            } else {
                $xtoken = validateAndSanitizeInput($headers['x-token']);
                
                // Prepared Statement untuk Validasi x-token
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
                        $id_api_session = $DataValidasiToken['id_api_session'];
                        $id_setting_api_key = $DataValidasiToken['id_setting_api_key'];
                        $title_api_key = GetDetailData($Conn, 'setting_api_key', 'id_setting_api_key', $id_setting_api_key, 'title_api_key');
                        
                        // Tangkap dan decode data
                        $raw = file_get_contents('php://input');
                        $Tangkap = json_decode($raw, true);

                        // Validasi id_event
                        if (empty($Tangkap['id_event'])) {
                            $keterangan = "ID Event Tidak Boleh Kosong";
                            $code = 400; // Bad Request
                        } else {
                            $id_event = validateAndSanitizeInput($Tangkap['id_event']);
                            // Variabel lainnya
                            $batas = !empty($Tangkap['limit']) ? validateAndSanitizeInput($Tangkap['limit']) : 100;
                            $page = !empty($Tangkap['page']) ? validateAndSanitizeInput($Tangkap['page']) : 1;
                            $keyword_by = !empty($Tangkap['keyword_by']) ? validateAndSanitizeInput($Tangkap['keyword_by']) : "";
                            $keyword = !empty($Tangkap['keyword']) ? validateAndSanitizeInput($Tangkap['keyword']) : "";

                            // Parameter Shorting
                            $ShortBy = "DESC";
                            $OrderBy = "datetime";
                            $posisi = ($page - 1) * $batas;
                            
                            // Menghitung jumlah data
                            $query = "SELECT COUNT(id_event_peserta) as jml_data FROM event_peserta ep
                                    WHERE ep.id_event = ? AND ep.status = 'Lunas'";

                            if (!empty($keyword)) {
                                $query .= " AND ep.nama LIKE ?";
                                $keyword = "%" . $keyword . "%";
                            }

                            if (!empty($keyword_by)) {
                                $query .= " AND ep.$keyword_by LIKE ?";
                                $keyword = "%" . $keyword . "%";
                            }

                            $stmt = $Conn->prepare($query);
                            if (!empty($keyword)) {
                                $stmt->bind_param("ss", $id_event, $keyword);
                            } else {
                                $stmt->bind_param("s", $id_event);
                            }
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            $jml_data = $row['jml_data'];

                            // Hitung jumlah halaman
                            $JmlHalaman = ceil($jml_data / $batas);

                            // Buat Data 'list_peserta'
                            $list_peserta = [];
                            if ($jml_data > 0) {
                                $query = "SELECT ep.*, ek.kategori FROM event_peserta ep 
                                          LEFT JOIN event_kategori ek ON ep.id_event_kategori = ek.id_event_kategori
                                          WHERE ep.id_event = ? AND ep.status = 'Lunas'";

                                if (!empty($keyword)) {
                                    $query .= " AND ep.nama LIKE ?";
                                }

                                if (!empty($keyword_by)) {
                                    $query .= " AND ep.$keyword_by LIKE ?";
                                }

                                $query .= " ORDER BY $OrderBy $ShortBy LIMIT ?, ?";
                                $stmt = $Conn->prepare($query);

                                if (!empty($keyword)) {
                                    $stmt->bind_param("ssii", $id_event, $keyword, $posisi, $batas);
                                } else {
                                    $stmt->bind_param("sii", $id_event, $posisi, $batas);
                                }

                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($DataEvent = $result->fetch_assoc()) {
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

                            // Menyimpan Log
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
                        $code = 401; // Unauthorized
                    }
                } else {
                    $keterangan = "X-Token Yang Digunakan Tidak Valid";
                    $code = 401; // Unauthorized
                }
                
                $stmt->close();
            }
        } catch (Exception $e) {
            $keterangan = "Terjadi kesalahan sistem: " . $e->getMessage();
            $code = 500; // Internal Server Error
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
