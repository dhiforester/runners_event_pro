
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
        if(empty($_POST['id_wilayah'])){
            $response = [
                'success' => false,
                'message' => 'ID Wilayah Tidak Boleh Kosong!'
            ];
        }else{
            if(empty($_POST['editValue'])){
                $response = [
                    'success' => false,
                    'message' => 'Nama Wilayah Yang Diinput Tidak Boleh Kosong!'
                ];
            }else{
                // Ambil data dari form
                $id_wilayah = trim($_POST['id_wilayah']);
                $editValue = trim($_POST['editValue']);
                //Buka Kategori Wilayah
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
                //Apabila nilai lama tidak dikethaui
                if(empty($NilaiLama)){
                    $response = [
                        'success' => false,
                        'message' => 'Nilai lama untuk data yang ingin anda ubah tidak diketahui'
                    ];
                }else{
                    // Validasi panjang karakter dan format input
                    if(strlen($editValue) > 50){
                        $response = [
                            'success' => false,
                            'message' => 'Nama wilayah yang anda masukan tidak boleh lebih dari 50 karakter'
                        ];
                    }else{
                        //Validasi Karakter Hanya Boleh Huruf dan spasi
                        if(!validateInput($editValue)){
                            $response = [
                                'success' => false,
                                'message' => 'Nama wilayah yang anda masukan hanya boleh diisi dengan huruf dan spasi'
                            ];
                        }else{
                            //Validasi Duplikasi Data
                            if($editValue==$NilaiLama){
                                $ValidasiDuplikat =0;
                            }else{
                                $ValidasiDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT id_wilayah FROM wilayah WHERE kategori='$kategori' AND $kolom='$editValue'"));
                            }
                            if(!empty($ValidasiDuplikat)){
                                $response = [
                                    'success' => false,
                                    'message' => 'Data wilayah yang anda input sudah ada'
                                ];
                            }else{
                                $UpdateWilayah = mysqli_query($Conn,"UPDATE wilayah SET 
                                    $kolom='$editValue'
                                WHERE $kolom='$NilaiLama'") or die(mysqli_error($Conn)); 
                                if($UpdateWilayah){
                                    addLog($Conn, $SessionIdAkses, $now, "Wilayah", "Update Wilayah");
                                    $response = [
                                        'success' => true,
                                        'message' => 'Data wilayah berhasil diupdate'
                                    ];
                                } else {
                                    $response = [
                                        'success' => false,
                                        'message' =>  'Gagal menambahkan data'
                                    ];
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    $Conn->close();
    echo json_encode($response);
?>