<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    $now=date('Y-m-d H:i:s');
    $date=date('Y-m-d');
    $time=date('H:i:s');
    // Inisialisasi pesan error pertama kali
    $response = ['success' => false, 'message' => ''];
    $errors = []; 
    if(empty($SessionIdAkses)){
        $errors[] = 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang!.';
    }else{
        //Validasi kategori tidak boleh kosong
        if(empty($_POST['kategori'])){
            $errors[] = 'Kategori Transaksi tidak boleh kosong!.';
        }else{
            if(empty($_POST['expired_time'])){
                $errors[] = 'Durasi Transaksi Expired tidak boleh kosong!.';
            }else{
                //Buat Variabel
                $kategori=$_POST['kategori'];
                $expired_time=$_POST['expired_time'];
                if(empty($_POST['ppn_pph'])){
                    $ppn_pph=0.00;
                }else{
                    $ppn_pph=$_POST['ppn_pph'];
                }
                if(empty($_POST['biaya_layanan'])){
                    $biaya_layanan=0;
                }else{
                    $biaya_layanan=$_POST['biaya_layanan'];
                }
                //Inisiasi Potongan
                if(empty($_POST['nama_potongan'])){
                    $potongan_lainnya="";
                }else{
                    $potongan_lainnya=[];
                    $nama_potongan=$_POST['nama_potongan'];
                    $nominal_potongan=$_POST['nominal_potongan'];
                    foreach ($nama_potongan as $index => $nama) {
                        $nominal = $nominal_potongan[$index];
                        $potongan_lainnya[]=[
                            "nama_potongan"=>$nama,
                            "nominal_potongan"=>$nominal,
                        ];
                    }
                    $potongan_lainnya=json_encode($potongan_lainnya);
                }
                //Inisiasi biaya_lainnya
                if(empty($_POST['nama_biaya'])){
                    $biaya_lainnya="";
                }else{
                    $biaya_lainnya=[];
                    $nama_biaya=$_POST['nama_biaya'];
                    $nominal_biaya=$_POST['nominal_biaya'];
                    foreach ($nama_biaya as $index => $nama) {
                        $nominal = $nominal_biaya[$index];
                        $biaya_lainnya[]=[
                            "nama_biaya"=>$nama,
                            "nominal_biaya"=>$nominal,
                        ];
                    }
                    $biaya_lainnya=json_encode($biaya_lainnya);
                }
                //Bersihkan Variabel
                $kategori=validateAndSanitizeInput($kategori);
                $expired_time=validateAndSanitizeInput($expired_time);
                // Query untuk mengupdate data testimoni
                $sql = "UPDATE setting_transaksi SET 
                        ppn_pph = ?, 
                        biaya_layanan = ?, 
                        potongan_lainnya = ?, 
                        biaya_lainnya = ?,
                        expired_time = ?
                WHERE kategori = ?";
                // Menyiapkan statement
                $stmt = $Conn->prepare($sql);
                $stmt->bind_param('ssssss', 
                    $ppn_pph, 
                    $biaya_layanan, 
                    $potongan_lainnya, 
                    $biaya_lainnya,
                    $expired_time,
                    $kategori
                );
                // Eksekusi statement dan cek apakah berhasil
                if ($stmt->execute()) {
                    $kategori_log="Setting Transaksi";
                    $deskripsi_log="Edit Setting Transaksi";
                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                    if($InputLog=="Success"){
                        $response['success'] = true;
                    }else{
                        $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                    }
                }else{
                    $errors[] = 'Terjadi kesalahan pada saat menambahkan data pada database!.';
                }
            }
        }
    }
    if (!empty($errors)) {
        $response['message'] = implode('<br>', $errors);
        echo json_encode($response);
        exit;
    }else{
        echo json_encode($response);
    }
?>