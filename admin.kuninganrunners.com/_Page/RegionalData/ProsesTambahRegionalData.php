<?php
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingEmail.php";
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    // Fungsi untuk validasi input
    function validateInput($input) {
        return preg_match("/^[a-zA-Z\s]+$/", $input); // Hanya huruf dan spasi yang diizinkan
    }
    //Response Pertama Kali
    $response = [
        'success' => false,
        'message' => ''
    ];
    if (empty($SessionIdAkses)) {
        $response = [
            'success' => false,
            'message' => 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang!'
        ];
    }else{
        if(empty($_POST['kategori'])){
            $response = [
                'success' => false,
                'message' => 'Kategori Tidak Boleh Kosong!'
            ];
        }else{
            // Ambil data dari form
            $kategori = trim($_POST['kategori']);
            //Validasi Kelengkapan Data Berdasarkan Kategori
            if($kategori=="Propinsi"){
                if(empty($_POST['Propinsi'])){
                    $ValidasiKelengkapanData="Propinsi Tidak Boleh Kosong!";
                }else{
                    $Propinsi = trim($_POST['Propinsi']);
                    $Kabupaten ="";
                    $Kecamatan ="";
                    $desa ="";
                    $ValidasiKelengkapanData="Valid";
                }
            }else{
                if($kategori=="Kabupaten"){
                    if(empty($_POST['Propinsi'])){
                        $ValidasiKelengkapanData="Propinsi Tidak Boleh Kosong!";
                    }else{
                        if(empty($_POST['Kabupaten'])){
                            $ValidasiKelengkapanData="Kabupaten Tidak Boleh Kosong!";
                        }else{
                            $Propinsi = trim($_POST['Propinsi']);
                            $Kabupaten = trim($_POST['Kabupaten']);
                            $Kecamatan ="";
                            $desa ="";
                            $ValidasiKelengkapanData="Valid";
                        }
                    }
                }else{
                    if($kategori=="Kecamatan"){
                        if(empty($_POST['Propinsi'])){
                            $ValidasiKelengkapanData="Propinsi Tidak Boleh Kosong!";
                        }else{
                            if(empty($_POST['Kabupaten'])){
                                $ValidasiKelengkapanData="Kabupaten Tidak Boleh Kosong!";
                            }else{
                                if(empty($_POST['Kecamatan'])){
                                    $ValidasiKelengkapanData="Kecamatan Tidak Boleh Kosong!";
                                }else{
                                    $Propinsi = trim($_POST['Propinsi']);
                                    $Kabupaten = trim($_POST['Kabupaten']);
                                    $Kecamatan = trim($_POST['Kecamatan']);
                                    $desa ="";
                                    $ValidasiKelengkapanData="Valid";
                                }
                            }
                        }
                    }else{
                        if($kategori=="desa"){
                            if(empty($_POST['Propinsi'])){
                                $ValidasiKelengkapanData="Propinsi Tidak Boleh Kosong!";
                            }else{
                                if(empty($_POST['Kabupaten'])){
                                    $ValidasiKelengkapanData="Kabupaten Tidak Boleh Kosong!";
                                }else{
                                    if(empty($_POST['Kecamatan'])){
                                        $ValidasiKelengkapanData="Kecamatan Tidak Boleh Kosong!";
                                    }else{
                                        if(empty($_POST['desa'])){
                                            $ValidasiKelengkapanData="Desa Tidak Boleh Kosong!";
                                        }else{
                                            $Propinsi = trim($_POST['Propinsi']);
                                            $Kabupaten = trim($_POST['Kabupaten']);
                                            $Kecamatan = trim($_POST['Kecamatan']);
                                            $desa = trim($_POST['desa']);
                                            $ValidasiKelengkapanData="Valid";
                                        }
                                    }
                                }
                            }
                        }else{
                            $ValidasiKelengkapanData="Kategori Tidak Teridentifikasi!";
                        }
                    }
                }
            }
            if($ValidasiKelengkapanData!=="Valid"){
                $response = [
                    'success' => false,
                    'message' => $ValidasiKelengkapanData
                ];
            }else{
                // Validasi panjang karakter dan format input
                if($kategori=="Propinsi"){
                    if(strlen($Propinsi) > 50){
                        $ValidasiPanjangKarakter="Propinsi Tidak Boleh Lebih Dari 50 karakter";
                    }else{
                        $ValidasiPanjangKarakter="Valid";
                    }
                }else{
                    if($kategori=="Kabupaten"){
                        if(strlen($Propinsi) > 50){
                            $ValidasiPanjangKarakter="Propinsi Tidak Boleh Lebih Dari 50 karakter";
                        }else{
                            if(strlen($Kabupaten) > 50){
                                $ValidasiPanjangKarakter="Kabupaten Tidak Boleh Lebih Dari 50 karakter";
                            }else{
                                $ValidasiPanjangKarakter="Valid";
                            }
                        }
                    }else{
                        if($kategori=="Kecamatan"){
                            if(strlen($Propinsi) > 50){
                                $ValidasiPanjangKarakter="Propinsi Tidak Boleh Lebih Dari 50 karakter";
                            }else{
                                if(strlen($Kabupaten) > 50){
                                    $ValidasiPanjangKarakter="Kabupaten Tidak Boleh Lebih Dari 50 karakter";
                                }else{
                                    if(strlen($Kecamatan) > 50){
                                        $ValidasiPanjangKarakter="Kecamatan Tidak Boleh Lebih Dari 50 karakter";
                                    }else{
                                        $ValidasiPanjangKarakter="Valid";
                                    }
                                }
                            }
                        }else{
                            if($kategori=="desa"){
                                if(strlen($Propinsi) > 50){
                                    $ValidasiPanjangKarakter="Propinsi Tidak Boleh Lebih Dari 50 karakter";
                                }else{
                                    if(strlen($Kabupaten) > 50){
                                        $ValidasiPanjangKarakter="Kabupaten Tidak Boleh Lebih Dari 50 karakter";
                                    }else{
                                        if(strlen($Kecamatan) > 50){
                                            $ValidasiPanjangKarakter="Kecamatan Tidak Boleh Lebih Dari 50 karakter";
                                        }else{
                                            if(strlen($desa) > 50){
                                                $ValidasiPanjangKarakter="Desa Tidak Boleh Lebih Dari 50 karakter";
                                            }else{
                                                $ValidasiPanjangKarakter="Valid";
                                            }
                                        }
                                    }
                                }
                            }else{
                                $ValidasiKelengkapanData="Kategori Tidak Teridentifikasi Saat Validasi Jumlah Karakter!";
                            }
                        }
                    }
                }
                if($ValidasiKelengkapanData!=="Valid"){
                    $response = [
                        'success' => false,
                        'message' => $ValidasiKelengkapanData
                    ];
                }else{
                    //Validasi Karakter Hanya Boleh Huruf dan spasi
                    if($kategori=="Propinsi"){
                        if(!validateInput($Propinsi)){
                            $ValidasiKarakter="Propinsi hanya boleh diisi dengan huruf dan spasi";
                        }else{
                            $ValidasiKarakter="Valid";
                        }
                    }else{
                        if($kategori=="Kabupaten"){
                            if(!validateInput($Propinsi)){
                                $ValidasiKarakter="Propinsi hanya boleh diisi dengan huruf dan spasi";
                            }else{
                                if(!validateInput($Kabupaten)){
                                    $ValidasiKarakter="Kabupaten hanya boleh diisi dengan huruf dan spasi";
                                }else{
                                    $ValidasiKarakter="Valid";
                                }
                            }
                        }else{
                            if($kategori=="Kecamatan"){
                                if(!validateInput($Propinsi)){
                                    $ValidasiKarakter="Propinsi hanya boleh diisi dengan huruf dan spasi";
                                }else{
                                    if(!validateInput($Kabupaten)){
                                        $ValidasiKarakter="Kabupaten hanya boleh diisi dengan huruf dan spasi";
                                    }else{
                                        if(!validateInput($Kecamatan)){
                                            $ValidasiKarakter="Kecamatan hanya boleh diisi dengan huruf dan spasi";
                                        }else{
                                            $ValidasiKarakter="Valid";
                                        }
                                    }
                                }
                            }else{
                                if($kategori=="desa"){
                                    if(!validateInput($Propinsi)){
                                        $ValidasiKarakter="Propinsi hanya boleh diisi dengan huruf dan spasi";
                                    }else{
                                        if(!validateInput($Kabupaten)){
                                            $ValidasiKarakter="Kabupaten hanya boleh diisi dengan huruf dan spasi";
                                        }else{
                                            if(!validateInput($Kecamatan)){
                                                $ValidasiKarakter="Kecamatan hanya boleh diisi dengan huruf dan spasi";
                                            }else{
                                                if(!validateInput($desa)){
                                                    $ValidasiKarakter="Desa hanya boleh diisi dengan huruf dan spasi";
                                                }else{
                                                    $ValidasiKarakter="Valid";
                                                }
                                            }
                                        }
                                    }
                                }else{
                                    $ValidasiKarakter="Kategori Tidak Teridentifikasi Saat Validasi Tipe Karakter!";
                                }
                            }
                        }
                    }
                    if($ValidasiKarakter!=="Valid"){
                        $response = [
                            'success' => false,
                            'message' => $ValidasiKarakter
                        ];
                    }else{
                        // Cek duplikasi data
                        if($kategori=="Propinsi"){
                            $ValidasiDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT id_wilayah FROM wilayah WHERE kategori='$kategori' AND propinsi='$Propinsi'"));
                        }else{
                            if($kategori=="Kabupaten"){
                                $ValidasiDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT id_wilayah FROM wilayah WHERE kategori='$kategori' AND propinsi='$Propinsi' AND kabupaten='$Kabupaten'"));
                            }else{
                                if($kategori=="Kecamatan"){
                                    $ValidasiDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT id_wilayah FROM wilayah WHERE kategori='$kategori' AND propinsi='$Propinsi' AND kabupaten='$Kabupaten' AND kecamatan='$Kecamatan'"));
                                }else{
                                    if($kategori=="desa"){
                                        $ValidasiDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT id_wilayah FROM wilayah WHERE kategori='$kategori' AND propinsi='$Propinsi' AND kabupaten='$Kabupaten' AND kecamatan='$Kecamatan' AND desa='$desa'"));
                                    }else{
                                        $ValidasiDuplikat="0";
                                    }
                                }
                            }
                        }
                        if(!empty($ValidasiDuplikat)){
                            $response = [
                                'success' => false,
                                'message' => 'Data yang anda input sudah ada'
                            ];
                        }else{
                            // Menyimpan data ke database
                            $insertSql = "INSERT INTO wilayah (kategori, propinsi, kabupaten, kecamatan, desa) VALUES (?, ?, ?, ?, ?)";
                            $stmt = $Conn->prepare($insertSql);
                            $stmt->bind_param('sssss', $kategori, $Propinsi, $Kabupaten, $Kecamatan, $desa);
                            if ($stmt->execute()) {
                                addLog($Conn, $SessionIdAkses, $now, "Wilayah", "Input Wilayah");
                                $response['success'] = true;
                                $response['message'] = 'Data wilayah berhasil ditambahkan.';
                            } else {
                                $response['message'] = 'Gagal menambahkan data: ' . $stmt->error;
                            }
                            $stmt->close();
                        }
                    }
                }
            }
        }
    }
    $Conn->close();
    echo json_encode($response);
?>
