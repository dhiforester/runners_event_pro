<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now = date('Y-m-d H:i:s');
    //Id Akses
    if (empty($SessionIdAkses)) {
        echo '<small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang Terlebih Dulu</small>';
    } else {
        $id_akses=$SessionIdAkses;
        //Buka data askes
        $QryDetailAkses = mysqli_query($Conn,"SELECT * FROM akses WHERE id_akses='$id_akses'")or die(mysqli_error($Conn));
        $DataDetailAkses = mysqli_fetch_array($QryDetailAkses);
        $image_akses = $DataDetailAkses['image_akses'];
        if (empty($_FILES['foto_saya']['name'])) {
            echo '<small class="text-danger">File tidak boleh kosong</small>';
        }else{
            //nama gambar
            $nama_gambar = $_FILES['foto_saya']['name'];
            //ukuran gambar
            $ukuran_gambar = $_FILES['foto_saya']['size'];
            //tipe
            $tipe_gambar = $_FILES['foto_saya']['type'];
            //sumber gambar
            $tmp_gambar = $_FILES['foto_saya']['tmp_name'];
            $timestamp = strval(time() - strtotime('1970-01-01 00:00:00'));
            $key = implode('', str_split(substr(strtolower(md5(microtime() . rand(1000, 9999))), 0, 30), 6));
            $FileNameRand = $key;
            $Pecah = explode(".", $nama_gambar);
            $BiasanyaNama = $Pecah[0];
            $Ext = $Pecah[1];
            $namabaru = "$FileNameRand.$Ext";
            $path = "../../assets/img/User/" . $namabaru;
            if ($tipe_gambar == "image/jpeg" || $tipe_gambar == "image/jpg" || $tipe_gambar == "image/gif" || $tipe_gambar == "image/png") {
                if ($ukuran_gambar < 2000000) {
                    if (move_uploaded_file($tmp_gambar, $path)) {
                        //Hapus file lama
                        $UrlFileLama="../../assets/img/User/$image_akses";
                        if(file_exists("$UrlFileLama")){
                            unlink($UrlFileLama);
                        }
                        $ValidasiGambar = "Valid";
                    } else {
                        $ValidasiGambar = "Upload gambar gagal";
                    }
                } else {
                    $ValidasiGambar = "File gambar tidak boleh lebih dari 2 Mb";
                }
            } else {
                $ValidasiGambar = "tipe file hanya boleh JPG, JPEG, PNG and GIF";
            }
            //Apabila validasi upload valid maka simpan di database
            if ($ValidasiGambar !== "Valid") {
                echo '<small class="text-danger">' . $ValidasiGambar . '</small>';
            } else {
                $UpdateAkses = mysqli_query($Conn, "UPDATE akses SET 
                    image_akses='$namabaru',
                    datetime_update='$now'
                WHERE id_akses='$id_akses'") or die(mysqli_error($Conn));
                if ($UpdateAkses) {
                    $_SESSION ["NotifikasiSwal"]="Ubah Foto Berhasil";
                    echo '<small class="text-success" id="NotifikasiUbahFotoProfilBerhasil">Success</small>';
                } else {
                    echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data</small>';
                }
            }
        }
    }
?>