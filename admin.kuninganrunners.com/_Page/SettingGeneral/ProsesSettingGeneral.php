<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');

    // Time Now Tmp
    $now = date('Y-m-d H:i:s');
    $response = array('status' => 'error', 'message' => '');

    if(empty($SessionIdAkses)){
        $response['message'] = 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang';
    } else {
        // Validasi upload file terlebih dahulu
        $ValidasiGambarFavicon = 'Valid';
        if(!empty($_FILES['favicon']['name'])){
            $nama_gambar_favicon = $_FILES['favicon']['name'];
            $ukuran_gambar_favicon = $_FILES['favicon']['size'];
            $tipe_gambar_favicon = $_FILES['favicon']['type'];
            $tmp_gambar_favicon = $_FILES['favicon']['tmp_name'];
            $Pecah = explode(".", $nama_gambar_favicon);
            $Ext = $Pecah[1];
            $namabarufavicon = uniqid() . ".$Ext";
            $path_favicon = "../../assets/img/".$namabarufavicon;
            if(in_array($tipe_gambar_favicon, ["image/jpeg", "image/jpg", "image/gif", "image/png"])){
                if($ukuran_gambar_favicon < 2000000){
                    if(!move_uploaded_file($tmp_gambar_favicon, $path_favicon)){
                        $ValidasiGambarFavicon = 'Terjadi kesalahan pada saat upload file Favicon';
                    }
                } else {
                    $ValidasiGambarFavicon = 'Ukuran Favicon maksimal 2 Mb';
                }
            } else {
                $ValidasiGambarFavicon = 'Tipe file Favicon hanya boleh JPG, JPEG, PNG, dan GIF';
            }
        }

        $ValidasiGambarLogo = 'Valid';
        if(!empty($_FILES['logo']['name'])){
            $nama_gambar_logo = $_FILES['logo']['name'];
            $ukuran_gambar_logo = $_FILES['logo']['size'];
            $tipe_gambar_logo = $_FILES['logo']['type'];
            $tmp_gambar_logo = $_FILES['logo']['tmp_name'];
            $Pecah = explode(".", $nama_gambar_logo);
            $Ext = $Pecah[1];
            $namabarulogo = uniqid() . ".$Ext";
            $path_logo = "../../assets/img/".$namabarulogo;
            if(in_array($tipe_gambar_logo, ["image/jpeg", "image/jpg", "image/gif", "image/png"])){
                if($ukuran_gambar_logo < 2000000){
                    if(!move_uploaded_file($tmp_gambar_logo, $path_logo)){
                        $ValidasiGambarLogo = 'Terjadi kesalahan pada saat upload file logo';
                    }
                } else {
                    $ValidasiGambarLogo = 'Ukuran file logo tidak boleh lebih dari 2 Mb';
                }
            } else {
                $ValidasiGambarLogo = 'Tipe file logo hanya boleh JPG, JPEG, PNG, dan GIF';
            }
        }

        // Cek validasi file
        if($ValidasiGambarFavicon != 'Valid'){
            $response['message'] = $ValidasiGambarFavicon;
        } else if($ValidasiGambarLogo != 'Valid'){
            $response['message'] = $ValidasiGambarLogo;
        } else {
            // Validasi input teks setelah validasi file
            if(empty($_POST['title_page'])){
                $response['message'] = 'Judul/Nama Perusahaan Tidak Boleh Kosong';
            } else if(empty($_POST['kata_kunci'])){
                $response['message'] = 'Kata kunci tidak boleh kosong!';
            } else if(empty($_POST['deskripsi'])){
                $response['message'] = 'Setidaknya anda harus mengisi deskripsi aplikasi ini!';
            } else if(empty($_POST['alamat_bisnis'])){
                $response['message'] = 'Alamat perusahaan tidak boleh kosong!';
            } else if(empty($_POST['email_bisnis'])){
                $response['message'] = 'Alamat email perusahaan tidak boleh kosong!';
            } else if(empty($_POST['telepon_bisnis'])){
                $response['message'] = 'Nomor kontak perusahaan tidak boleh kosong!';
            } else if(empty($_POST['base_url'])){
                $response['message'] = 'Base URL tidak boleh kosong!';
            } else {
                // Simpan data
                $title_page = $_POST['title_page'];
                $kata_kunci = $_POST['kata_kunci'];
                $deskripsi = $_POST['deskripsi'];
                $alamat_bisnis = $_POST['alamat_bisnis'];
                $email_bisnis = $_POST['email_bisnis'];
                $telepon_bisnis = $_POST['telepon_bisnis'];
                $base_url = $_POST['base_url'];
                //Bersihkan Variabel
                $title_page = validateAndSanitizeInput($title_page);
                $kata_kunci = validateAndSanitizeInput($kata_kunci);
                $deskripsi = validateAndSanitizeInput($deskripsi);
                $alamat_bisnis = validateAndSanitizeInput($alamat_bisnis);
                $email_bisnis = validateAndSanitizeInput($email_bisnis);
                $telepon_bisnis = validateAndSanitizeInput($telepon_bisnis);
                $base_url = validateAndSanitizeInput($base_url);
                // Update setting_general
                $UpdateSetting = mysqli_query($Conn, "UPDATE setting_general SET 
                    title_page='$title_page',
                    kata_kunci='$kata_kunci',
                    deskripsi='$deskripsi',
                    alamat_bisnis='$alamat_bisnis',
                    email_bisnis='$email_bisnis',
                    telepon_bisnis='$telepon_bisnis',
                    base_url='$base_url'
                WHERE id_setting_general='1'");
                
                if($UpdateSetting){
                    $kategori_log="Setting";
                    $deskripsi_log="Setting General";
                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                    if($InputLog=="Success"){
                        $_SESSION["NotifikasiSwal"] = "Simpan Setting General Berhasil";
                        $response['status'] = 'success';
                        $response['message'] = 'Pengaturan berhasil disimpan';
                    }else{
                        $response['message'] = 'Terjadi kesalahan pada saat menyimpan log aktivitas';
                    }
                } else {
                    $response['message'] = 'Terjadi kesalahan pada saat update data pengaturan';
                }
            }
        }
    }

    // Kirim response dalam format JSON
    header('Content-Type: application/json');
    echo json_encode($response);
?>
