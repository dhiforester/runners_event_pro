<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    $service_name = "Tambah Keranjang";

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
                        // Validasi id_barang tidak boleh kosong
                        if (!isset($Tangkap['id_barang'])) {
                            $keterangan = "ID Barang Tidak Boleh Kosong";
                        } else {
                            // Validasi qty tidak boleh kosong
                            if (!isset($Tangkap['qty'])) {
                                $keterangan = "Jumlah Item Tidak Boleh Kosong";
                            } else {
                                if (!isset($Tangkap['id_varian'])) {
                                    $id_varian = "";
                                } else {
                                    $id_varian =$Tangkap['id_varian'];
                                }
                                // Buat Dalam Bentukk Variabel
                                $xtoken = validateAndSanitizeInput($headers['x-token']);
                                $email = validateAndSanitizeInput($Tangkap['email']);
                                $id_member_login = validateAndSanitizeInput($Tangkap['id_member_login']);
                                $id_barang = validateAndSanitizeInput($Tangkap['id_barang']);
                                $qty = validateAndSanitizeInput($Tangkap['qty']);
                                $id_varian = validateAndSanitizeInput($id_varian);
                                
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
                                                    //Buka Item Barang
                                                    $satuan=GetDetailData($Conn,'barang','id_barang',$id_barang,'satuan');
                                                    $harga=GetDetailData($Conn,'barang','id_barang',$id_barang,'harga');
                                                    $stok=GetDetailData($Conn,'barang','id_barang',$id_barang,'stok');
                                                    $dimensi=GetDetailData($Conn,'barang','id_barang',$id_barang,'dimensi');
                                                    $deskripsi=GetDetailData($Conn,'barang','id_barang',$id_barang,'deskripsi');
                                                    $foto=GetDetailData($Conn,'barang','id_barang',$id_barang,'foto');
                                                    $varian=GetDetailData($Conn,'barang','id_barang',$id_barang,'varian');
                                                    if(!empty($varian)){
                                                        $varian_array=json_decode($varian, true);
                                                        if(!empty(count($varian_array))){
                                                            //Apabila Item Barang Memiliki Varian Maka id_bvarian menjadi wajib
                                                            if(empty($id_varian)){
                                                                $validasi_varian="Anda Harus Memilih Diantara Varian Yang Ada";
                                                            }else{
                                                                //Cek Apakah id_varian yang dipilih terdaftar
                                                                $varian_array = json_decode($varian, true);
                                                                $id_varian_list = array_column($varian_array, 'id_varian');
                                                                // Periksa apakah id_varian_cek ada dalam daftar id_varian
                                                                if (in_array($id_varian, $id_varian_list)) {
                                                                    //Validasi Stok Varian
                                                                    $stok_varian = 0;
                                                                    foreach ($varian_array as $item) {
                                                                        if ($item['id_varian'] === $id_varian) {
                                                                            $stok_varian = $item['stok_varian'];
                                                                            break;
                                                                        }
                                                                    }
                                                                    if($qty>$stok_varian){
                                                                        $validasi_varian="Stok varian yang anda pilih tidak memenuhi";
                                                                    }else{
                                                                        $validasi_varian="Valid";
                                                                    }
                                                                } else {
                                                                    $validasi_varian="ID varian $id_varian tidak ditemukan.";
                                                                }
                                                            }
                                                        }else{
                                                            //Apabila Tidak Ada Varian Cek Stok Barang
                                                            if($qty>$stok){
                                                                $validasi_varian="Stok barang yang anda pilih tidak memenuhi";
                                                            }else{
                                                                $validasi_varian="Valid";
                                                            }
                                                        }
                                                    }else{
                                                        //Apabila Tidak Ada Varian Cek Stok Barang
                                                        if($qty>$stok){
                                                            $validasi_varian="Stok barang yang anda pilih tidak memenuhi";
                                                        }else{
                                                            $validasi_varian="Valid";
                                                        }
                                                    }
                                                    if( $validasi_varian!=="Valid"){
                                                        $keterangan = "$validasi_varian";
                                                    }else{
                                                        // Cek Apakah Ada Item Keranjang Untuk Member Ini dan Barang Ini Sudah Ada
                                                        $QryParam = mysqli_query($Conn,"SELECT id_transaksi_keranjang, qty FROM transaksi_keranjang WHERE id_barang='$id_barang' AND id_member='$id_member' AND id_varian='$id_varian'")or die(mysqli_error($Conn));
                                                        $DataParam = mysqli_fetch_array($QryParam);
                                                        if(empty($DataParam['id_transaksi_keranjang'])){
                                                            //Apabila Tidak Ada Maka Insert
                                                            $query = "INSERT INTO transaksi_keranjang (
                                                                id_barang, 
                                                                id_member, 
                                                                id_varian, 
                                                                qty
                                                            ) 
                                                            VALUES (?, ?, ?, ?)";
                                                            $stmt = $Conn->prepare($query);
                                                            $stmt->bind_param(
                                                                "ssss", 
                                                                $id_barang, 
                                                                $id_member, 
                                                                $id_varian, 
                                                                $qty
                                                            );
                                                            if ($stmt->execute()) {
                                                                $ValidasiProses = "Valid";
                                                            }else{
                                                                $ValidasiProses = "Terjadi kesalahan saat menyimpan ke database";
                                                            }
                                                        }else{
                                                            //Apabila Sudah Ada Maka Update Tambah QTY
                                                            $id_transaksi_keranjang=$DataParam['id_transaksi_keranjang'];
                                                            $qty=$qty+$DataParam['qty'];
                                                            // Update Data
                                                            $updateQuery = "UPDATE transaksi_keranjang SET qty = ? WHERE id_transaksi_keranjang = ?";
                                                            $stmtUpdate = $Conn->prepare($updateQuery);
                                                            $stmtUpdate->bind_param('ss', $qty, $id_transaksi_keranjang);
                                                            if ($stmtUpdate->execute()) {
                                                                $ValidasiProses = "Valid";
                                                            }else{
                                                                $ValidasiProses = "Terjadi kesalahan saat update ke database";
                                                            }
                                                        }
                                                        if($ValidasiProses!=="Valid"){
                                                            $keterangan = "$ValidasiProses";
                                                        }else{
                                                            $metadata = [
                                                                "id_member" => $id_member,
                                                                "id_barang" => $id_barang,
                                                                "qty" => $qty
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
