<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Generate X-Token";
    $metadata = [];
    // Validasi Metode Pengiriman Data
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $id_setting_api_key = 0;
        $title_api_key = "";
        $keterangan = "Metode Pengiriman Data Hanya Boleh Menggunakan POST";
        $code = 201;
        $metadata = [];
    } else {
        // Tangkap data dan decode
        $raw = file_get_contents('php://input');
        $Tangkap = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $keterangan = "Data JSON yang diterima tidak valid: " . json_last_error_msg();
            $code = 400;
            $metadata = [];
        } else {
            // Validasi user_key_server tidak boleh kosong
            if (empty($Tangkap['user_key_server'])) {
                $keterangan = "User Key Server Tidak Boleh Kosong";
                $code = 201;
                $metadata = [];
            } elseif (empty($Tangkap['password_server'])) {
                // Validasi password_server tidak boleh kosong
                $keterangan = "Password Server Tidak Boleh Kosong";
                $code = 201;
                $metadata = [];
            } else {
                // Buat Dalam Bentukk Variabel
                $user_key_server = validateAndSanitizeInput($Tangkap['user_key_server']);
                $password_server = validateAndSanitizeInput($Tangkap['password_server']);
                
                // Validasi Data menggunakan prepared statements
                $stmt = $Conn->prepare("SELECT * FROM setting_api_key WHERE user_key_server = ?");
                $stmt->bind_param("s", $user_key_server);
                $stmt->execute();
                $result = $stmt->get_result();
                $DataValidasiApi = $result->fetch_assoc();

                // Cek password
                if ($DataValidasiApi) {
                    if (password_verify($password_server, $DataValidasiApi['password_server'])) {
                        // Validasi berhasil, lanjutkan dengan logika
                        $id_setting_api_key = $DataValidasiApi['id_setting_api_key'];
                        $title_api_key = $DataValidasiApi['title_api_key'];
                        $status = $DataValidasiApi['status'];
                        $limit_session = $DataValidasiApi['limit_session'];

                        if ($status !== "Aktif") {
                            $keterangan = "API Key Tidak Aktif";
                            $code = 201;
                            $metadata = [];
                        } else {
                            // Membuat Token
                            $x_token = GenerateToken(36);
                            // Menghitung Expired Time
                            $expired = calculateExpirationTimeFromDateTime($now, $limit_session);

                            // Menyimpan X Token menggunakan prepared statements
                            $stmtInsert = $Conn->prepare("INSERT INTO api_session (id_setting_api_key, datetime_creat, datetime_expired, xtoken) VALUES (?, ?, ?, ?)");
                            $stmtInsert->bind_param("isss", $id_setting_api_key, $now, $expired, $x_token);

                            if (!$stmtInsert->execute()) {
                                $keterangan = "Kesalahan Pada Saat Menambahkan X-Token Ke Database Session: $id_setting_api_key";
                                $code = 201;
                                $metadata = [];
                            } else {

                                $keterangan = "success";
                                $code = 200;
                                $metadata = [
                                    "id_setting_api_key" => $id_setting_api_key,
                                    "title_api_key" => $title_api_key,
                                    "datetime_creat" => $now,
                                    "datetime_expired" => $expired,
                                    "user_key_server" => $user_key_server,
                                    "x-token" => $x_token
                                ];
                            }

                            $stmtInsert->close();
                        }
                    } else {
                        // Password salah
                        $keterangan = "User Key dan Password Server Tidak Valid";
                        $code = 201;
                        $metadata = [];
                    }
                } else {
                    // User key tidak ditemukan
                    $keterangan = "User Key dan Password Server Tidak Valid";
                    $code = 201;
                    $metadata = [];
                }
                $stmt->close();
            }
        }
    }
    $response = [
        "message" => "$keterangan",
        "code" => $code,
    ];

    $Array = [
        "response" => $response,
        "metadata" => $metadata ?? []
    ];

    $json = json_encode($Array, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + (10 * 60)));
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header('Content-Type: application/json');
    header('Pragma: no-cache');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, x-token, token");
    echo $json;
    exit();
?>
