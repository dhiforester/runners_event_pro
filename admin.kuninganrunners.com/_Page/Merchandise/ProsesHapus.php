<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    // Inisialisasi pesan error
    $response = ['success' => false, 'message' => ''];
    $errors = []; 
    if(empty($SessionIdAkses)){
        $errors[] = 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang';
    }else{
        //Validasi id_barang tidak boleh kosong
        if(empty($_POST['id_barang'])){
            $errors[] = 'ID Barang tidak boleh kosong';
        }else{
            //Variabel Lainnya
            $id_barang=$_POST['id_barang'];
            //Bersihkan Variabel
            $id_barang=validateAndSanitizeInput($id_barang);
            $foto=GetDetailData($Conn,'barang','id_barang',$id_barang,'foto');
            //Membuka Varian
            $varian = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'varian');
            $VarianArray=json_decode($varian, true);
            //Buka Data Array
            foreach($VarianArray as $VarianList){
                $foto_varian=$VarianList['foto_varian'];
                $foto_path = '../../assets/img/Marchandise/' . $foto_varian;
                if (file_exists($foto_path)) {
                    //Menghapus Foto Varian
                    unlink($foto_path);
                }
            }
            //Proses hapus data
            $HapusBarang = mysqli_query($Conn, "DELETE FROM barang WHERE id_barang='$id_barang'") or die(mysqli_error($Conn));
            if ($HapusBarang) {
                $foto_path= '../../assets/img/Marchandise/'.$foto.'';
                if(!mepty($foto)){
                    if (file_exists($foto_path)) {
                        $HapusBarang=unlink($foto_path);
                    }
                }
                if (!file_exists($foto_path)) {
                    //Menyimpan Log
                    $kategori_log="Merchandise";
                    $deskripsi_log="Hapus Merchandise";
                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                    if($InputLog=="Success"){
                        $response['success'] = true;
                        $response['message'] = 'Hapus Merchandise Berhasil';
                    }else{
                        $errors[] = 'Terjadi Kesalahan Pada Saat Menyimpan Log';
                    }
                }else{
                    $errors[] = 'Terjadi Kesalahan Pada Saat Menghapus File Foto';
                }
            }else{
                $errors[] = 'Terjadi Kesalahan Pada Saat Menghapus Data Dari Database';
            }
        }
    }
    // Jika ada error, kirim respons dengan daftar pesan error
    if (!empty($errors)) {
        $response['message'] = implode('<br>', $errors);
        echo json_encode($response);
        exit;
    }else{
        echo json_encode($response);
    }
?>