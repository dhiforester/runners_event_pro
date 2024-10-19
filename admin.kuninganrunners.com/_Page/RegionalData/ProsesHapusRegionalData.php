<?php
    //Koneksi
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
        if(empty($_POST['id_wilayah'])){
            $response = [
                'success' => false,
                'message' => 'ID Wilayah Tidak Boleh Kosong!'
            ];
        }else{
            $id_wilayah=$_POST['id_wilayah'];
            $kategori=GetDetailData($Conn,'wilayah','id_wilayah',$id_wilayah,'kategori');
            //Membuat Variabel Data Value Lama
            if($kategori=="Propinsi"){
                $NilaiLama=GetDetailData($Conn,'wilayah','id_wilayah',$id_wilayah,'propinsi');
                $kolom="propinsi";
            }else{
                if($kategori=="Kabupaten"){
                    $NilaiLama=GetDetailData($Conn,'wilayah','id_wilayah',$id_wilayah,'kabupaten');
                    $kolom="kabupaten";
                }else{
                    if($kategori=="Kecamatan"){
                        $NilaiLama=GetDetailData($Conn,'wilayah','id_wilayah',$id_wilayah,'kecamatan');
                        $kolom="kecamatan";
                    }else{
                        if($kategori=="desa"){
                            $NilaiLama=GetDetailData($Conn,'wilayah','id_wilayah',$id_wilayah,'desa');
                            $kolom="desa";
                        }else{
                            $NilaiLama="";
                            $kolom="";
                        }
                    }
                }
            }
            //Proses hapus data
            $query = mysqli_query($Conn, "DELETE FROM wilayah WHERE $kolom='$NilaiLama'") or die(mysqli_error($Conn));
            if ($query) {
                addLog($Conn, $SessionIdAkses, $now, "Wilayah", "Hapus Wilayah");
                $response = [
                    'success' => true,
                    'message' =>  'Berhasil menghapus data'
                ];
            }else{
                $response = [
                    'success' => false,
                    'message' =>  'Gagal menghapus data'
                ];
            }
        }
    }
    $Conn->close();
    echo json_encode($response);
?>