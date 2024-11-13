<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/SettingEmail.php";
    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Pemulihan Password Member";

    // Setting default response
    $code = 201;
    $keterangan = "Terjadi kesalahan";
    $metadata = [];

    // Validasi Metode Pengiriman Data
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $keterangan = "Metode Pengiriman Data Hanya Boleh Menggunakan POST";
    } else {
        try {
            // Variabel Header
            $headers = getallheaders();
            // Decode Json Data
            $raw = file_get_contents('php://input');
            $Tangkap = json_decode($raw, true);
            // Validasi x-token tidak boleh kosong
            if (!isset($headers['x-token'])) {
                $ValidasiKelengkapan = "x-token Tidak Boleh Kosong";
            } else {
                // Validasi id_member tidak boleh kosong
                if (!isset($Tangkap['id_member'])) {
                    $ValidasiKelengkapan = "ID Member Tidak Boleh Kosong";
                } else {
                    // Validasi rest tidak boleh kosong
                    if (!isset($Tangkap['rest'])) {
                        $ValidasiKelengkapan = "ID Pemulihan Tidak Boleh Kosong";
                    } else {
                        // Validasi kode tidak boleh kosong
                        if (!isset($Tangkap['kode'])) {
                            $ValidasiKelengkapan = "Kode Pemulihan Tidak Boleh Kosong";
                        } else {
                            // Validasi password_baru tidak boleh kosong
                            if (!isset($Tangkap['password_baru'])) {
                                $ValidasiKelengkapan = "Password Baru Tidak Boleh Kosong";
                            } else {
                                $ValidasiKelengkapan = "Valid";
                            }
                        }
                    }
                }
            }
            if($ValidasiKelengkapan!=="Valid"){
                $keterangan = $ValidasiKelengkapan;
            }else{
                if (strlen($Tangkap['password_baru']) > 20) { 
                    $keterangan='Password baru tidak boleh lebih dari 20 karakter.'; 
                }else{
                    if (!ctype_alnum($Tangkap['password_baru'])) {
                        $keterangan='Password baru hanya boleh huruf dan angka.';
                    }else{
                        //Buat Variabel
                        $xtoken = validateAndSanitizeInput($headers['x-token']);
                        $id_member = validateAndSanitizeInput($Tangkap['id_member']);
                        $id_member_lp_pass = validateAndSanitizeInput($Tangkap['rest']);
                        $kode = validateAndSanitizeInput($Tangkap['kode']);
                        $password_baru = validateAndSanitizeInput($Tangkap['password_baru']);
                        
                        // Validasi x-token menggunakan prepared statements
                        $stmt = $Conn->prepare("SELECT * FROM api_session WHERE xtoken = ?");
                        $stmt->bind_param("s", $xtoken);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $DataValidasiToken = $result->fetch_assoc();
                        //Apakah Token Valid?
                        if ($DataValidasiToken) {
                            $datetime_creat = $DataValidasiToken['datetime_creat'];
                            $datetime_expired = $DataValidasiToken['datetime_expired'];
                                
                            // Cek Token Apakah Masih Berlaku
                            if ($now >= $datetime_creat && $now <= $datetime_expired) {
                                // Validasi berhasil, lanjutkan dengan logika
                                $id_api_session = $DataValidasiToken['id_api_session'];
                                $id_setting_api_key = $DataValidasiToken['id_setting_api_key'];
                                $title_api_key = GetDetailData($Conn, 'setting_api_key', 'id_setting_api_key', $id_setting_api_key, 'title_api_key');
                                
                                // Apakah 3 kode yang dikirim valid?
                                $stmt_pemulihan = $Conn->prepare("SELECT * FROM member_lp_pass WHERE id_member_lp_pass = ? AND id_member = ? AND kode = ?");
                                $stmt_pemulihan->bind_param("sss", $id_member_lp_pass, $id_member, $kode);
                                $stmt_pemulihan->execute();
                                $result_pemulihan = $stmt_pemulihan->get_result();
                                $DataPemulihan = $result_pemulihan->fetch_assoc();
                                //Apabila Kombinasi Kode Pemulihan Valid Update Password Ke Database
                                if($DataPemulihan) {
                                    try {
                                        // Menggunakan password hashing untuk keamanan
                                        $password = password_hash($password_baru, PASSWORD_DEFAULT);
                                        $updateQuery = "UPDATE member SET password = ? WHERE id_member = ?";
                                        
                                        // Siapkan pernyataan dengan pengecekan error
                                        $stmtUpdate = $Conn->prepare($updateQuery);
                                        if (!$stmtUpdate) {
                                            throw new Exception("Gagal menyiapkan statement: " . $Conn->error);
                                        }
                                        
                                        // Bind parameter
                                        $stmtUpdate->bind_param('ss', $password, $id_member);
                                        
                                        // Eksekusi statement dengan pengecekan hasil
                                        if ($stmtUpdate->execute()) {
                                            $ValidasiProses = "Berhasil";
                                        } else {
                                            throw new Exception("Gagal mengupdate data: " . $stmtUpdate->error);
                                        }
                                        
                                        // Tutup statement
                                        $stmtUpdate->close();
                                    } catch (Exception $e) {
                                        $ValidasiProses = "Terjadi Kesalahan: " . $e->getMessage();
                                    }
                                    
                                    if($ValidasiProses!=="Berhasil"){
                                        $keterangan= $ValidasiProses; 
                                    }else{
                                        //Apabila Berhasil Hapus Kode Pemulihan
                                        $HapusKodePemulihan = mysqli_query($Conn, "DELETE FROM member_lp_pass WHERE id_member_lp_pass='$id_member_lp_pass'") or die(mysqli_error($Conn));
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
                                }else{
                                    $keterangan = "Kombinasi kode pemulihan tidak valid";
                                }
                            } else {
                                $keterangan = "X-Token Yang Digunakan Sudah Tidak Berlaku";
                            }
                        }else{
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
