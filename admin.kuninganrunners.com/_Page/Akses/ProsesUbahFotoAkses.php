<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi Akses
    if(empty($SessionIdAkses)){
        echo '<small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang!</small>';
    }else{
        //Validasi nama tidak boleh kosong
        if(empty($_POST['id_akses'])){
            echo '<small class="text-danger">ID Akses tidak boleh kosong</small>';
        }else{
            $id_akses=$_POST['id_akses'];
            //Bersihkan Variabel
            $id_akses=validateAndSanitizeInput($id_akses);
            $ImageLama=GetDetailData($Conn,'akses','id_akses',$id_akses,'image_akses');
            if(empty($_FILES['image_akses']['name'])){
                echo '<small class="text-danger">File Foto tidak boleh kosong</small>';
            }else{
                //nama gambar
                $nama_gambar=$_FILES['image_akses']['name'];
                $ukuran_gambar = $_FILES['image_akses']['size']; 
                $tipe_gambar = $_FILES['image_akses']['type']; 
                $tmp_gambar = $_FILES['image_akses']['tmp_name'];
                if($tipe_gambar == "image/jpeg"||$tipe_gambar == "image/jpg"||$tipe_gambar == "image/gif"||$tipe_gambar == "image/png"){
                    if($ukuran_gambar<2000000){
                        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                        $key=implode('', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));
                        $FileNameRand=$key;
                        if($tipe_gambar== "image/jpeg"){
                            $Ext="jpeg";
                        }
                        if($tipe_gambar== "image/jpg"){
                            $Ext="jpg";
                        }
                        if($tipe_gambar== "image/gif"){
                            $Ext="gif";
                        }
                        if($tipe_gambar== "image/png"){
                            $Ext="png";
                        }
                        $namabaru = "$FileNameRand.$Ext";
                        $path = "../../assets/img/User/".$namabaru;
                        if(move_uploaded_file($tmp_gambar, $path)){
                            $UpdateAkses = mysqli_query($Conn,"UPDATE akses SET 
                                image_akses='$namabaru',
                                datetime_update='$now'
                            WHERE id_akses='$id_akses'") or die(mysqli_error($Conn)); 
                            if($UpdateAkses){
                                if(!empty($ImageLama)){
                                    $file = '../../assets/img/User/'.$ImageLama.'';
                                    if (file_exists($file)) {
                                        if (unlink($file)) {
                                            $kategori_log="Akses";
                                            $deskripsi_log="Update Foto Akses";
                                            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                            if($InputLog=="Success"){
                                                echo '<small class="text-success" id="NotifikasiUbahFotoAksesBerhasil">Success</small>';
                                            }else{
                                                echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan log aktivitas</small>';
                                            }
                                        } else {
                                            echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus foto lama</span>';
                                        }
                                    }else{
                                        echo '<small class="text-success" id="NotifikasiUbahFotoAksesBerhasil">Success</small>';
                                    }
                                }else{
                                    echo '<small class="text-success" id="NotifikasiUbahFotoAksesBerhasil">Success</small>';
                                }
                            }else{
                                echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data akses</small>';
                            }
                        }else{
                            echo '<small class="text-danger">Upload file gambar gagal</small>';
                        }
                    }else{
                        echo '<small class="text-danger">File gambar tidak boleh lebih dari 2 mb</small>';
                    }
                }else{
                    echo '<small class="text-danger">Tipe file hanya boleh JPG, JPEG, PNG and GIF</small>';
                }
            }
        }
    }
?>