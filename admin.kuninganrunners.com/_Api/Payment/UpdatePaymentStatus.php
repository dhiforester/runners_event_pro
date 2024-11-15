<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Update Payment Status";
    // Setting default response
    $code = 201;
    $keterangan = "Terjadi kesalahan";
    $metadata = [];
    // Validasi Metode Pengiriman Data
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $keterangan = "Metode Pengiriman Data Hanya Boleh Menggunakan POST";
    } else {
        // Tangkap data dan decode
        $raw = file_get_contents('php://input');
        $Tangkap = json_decode($raw, true);
        // Validasi kelengkapan data tidak boleh kosong
        if (!isset($Tangkap['api_key'])) {
            $keterangan = "API Key Tidak Boleh Kosong";
        } else if (!isset($Tangkap['order_id'])) {
            $keterangan = "Order ID Tidak Boleh Kosong";
        } else if (!isset($Tangkap['status'])) {
            $keterangan = "Status Transaksi Tidak Boleh Kosong";
        } else {
            // Buat Variabel
            $api_key = validateAndSanitizeInput($Tangkap['api_key']);
            $order_id = validateAndSanitizeInput($Tangkap['order_id']);
            $status = validateAndSanitizeInput($Tangkap['status']);
            // Validasi api_key menggunakan prepared statements
            $stmt = $Conn->prepare("SELECT api_key FROM setting_payment WHERE api_key = ?");
            $stmt->bind_param("s", $api_key);
            $stmt->execute();
            $result = $stmt->get_result();
            $DataValidasiApiKey = $result->fetch_assoc();
            if ($DataValidasiApiKey) {
                //Validasi Apakah Order ID Ada
                $order_id_validasi=GetDetailData($Conn, 'transaksi_payment', 'order_id', $order_id, 'order_id');
                if(empty($order_id_validasi)){
                    $keterangan="Order ID Tidak Ditemukan";
                }else{
                    //Buka Kode Transaksi
                    $kode_transaksi=GetDetailData($Conn, 'transaksi_payment', 'order_id', $order_id, 'kode_transaksi');
                    //Buka Status Transaksi
                    $status_transaksi=GetDetailData($Conn, 'transaksi', 'kode_transaksi', $kode_transaksi, 'status');
                    //Jika Status Transaksi Lunas
                    if($status_transaksi=="Lunas"){
                        $keterangan="Transaksi Sudah Lunas, Data Tidak Bis Di Update";
                    }else{
                        //Jika Belum Lunas, Udate transaksi_payment
                        $UpdatePayment = "UPDATE transaksi_payment SET status = ? WHERE order_id = ?";
                        $stmtUpdate = $Conn->prepare($UpdatePayment);
                        $stmtUpdate->bind_param('ss', $status, $order_id);
                        if ($stmtUpdate->execute()) {
                            //Update Transaksi
                            $UpdateTransaksi = "UPDATE transaksi SET status = ? WHERE kode_transaksi = ?";
                            $stmtUpdateTransaksi = $Conn->prepare($UpdateTransaksi);
                            $stmtUpdateTransaksi->bind_param('ss', $status, $kode_transaksi);
                            if ($stmtUpdateTransaksi->execute()) {
                                //Apabila Statusnya Lunas maka Update Juga Data Peserta Eventnnya
                                if($status=="Lunas"){
                                    $UpdateEventPeserta = "UPDATE event_peserta SET status = ? WHERE id_event_peserta = ?";
                                    $stmtUpdatePeserta = $Conn->prepare($UpdateEventPeserta);
                                    $stmtUpdatePeserta->bind_param('ss', $status, $kode_transaksi);
                                    if ($stmtUpdatePeserta->execute()) {
                                         //Jika Berhasil
                                        $keterangan = "success";
                                        $code = 200;
                                    }else{
                                        $keterangan = "Terjadi kesalahan pada saat update Data Peserta";
                                    }
                                }else{
                                    //Jika Berhasil
                                    $keterangan = "success";
                                    $code = 200;
                                }
                            } else {
                                $keterangan = "Terjadi kesalahan pada saat update Data Transaksi";
                            }
                        } else {
                            $keterangan = "Terjadi Kesalahan Pada Saat Update Data Payment";
                        }
                        
                        $stmt->close();
                    }
                }
            }else{
                $keterangan = "API Key Yang Digunakan Tidak Valid";
            }
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
