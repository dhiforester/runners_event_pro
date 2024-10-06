<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi nama tidak boleh kosong
    if(empty($_POST['nama'])){
        echo '<code class="text-danger">Nama fitur tidak boleh kosong</code>';
    }else{
        //Validasi kategori tidak boleh kosong
        if(empty($_POST['kategori'])){
            echo '<code class="text-danger">Kategori tidak boleh kosong</code>';
        }else{
            //Validasi kode tidak boleh kosong
            if(empty($_POST['kode'])){
                echo '<code class="text-danger">Kode tidak boleh kosong</code>';
            }else{
                //Validasi keterangan tidak boleh kosong
                if(empty($_POST['keterangan'])){
                    echo '<code class="text-danger">Setidaknya anda harus memberikan keterangan untuk fitur tersebut</code>';
                }else{
                    //Validasi kode tidak boleh lebih dari 20 karakter
                    $JumlahKarakterKode=strlen($_POST['kode']);
                    if($JumlahKarakterKode>20||$JumlahKarakterKode<6){
                        echo '<code class="text-danger">Kode terdiri dari 6-20 karakter</code>';
                    }else{
                        //Validasi kode tidak boleh duplikat
                        $nama=$_POST['nama'];
                        $kategori=$_POST['kategori'];
                        $kode=$_POST['kode'];
                        $keterangan=$_POST['keterangan'];
                        $ValidasiKodeDuplikat=0;
                        //Membersihkan Variabel
                        $nama=validateAndSanitizeInput($nama);
                        $kategori=validateAndSanitizeInput($kategori);
                        $kode=validateAndSanitizeInput($kode);
                        $ValidasiKodeDuplikat=validateAndSanitizeInput($ValidasiKodeDuplikat);
                        $ValidasiNamaDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_fitur WHERE nama='$nama'"));
                        if(!empty($ValidasiKodeDuplikat)){
                            echo '<code class="text-danger">Kode tersebut sudah terdaftar</code>';
                        }else{
                            if(!empty($ValidasiNamaDuplikat)){
                                echo '<code class="text-danger">Nama Fitur tersebut sudah terdaftar</code>';
                            }else{
                                $entry="INSERT INTO akses_fitur (
                                    kategori,
                                    nama,
                                    kode,
                                    keterangan
                                ) VALUES (
                                    '$kategori',
                                    '$nama',
                                    '$kode',
                                    '$keterangan'
                                )";
                                $Input=mysqli_query($Conn, $entry);
                                if($Input){
                                    $kategori_log="Akses";
                                    $deskripsi_log="Input Fitur Akses";
                                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                    if($InputLog=="Success"){
                                        echo '<code class="text-success" id="NotifikasiTambahAksesFiturBerhasil">Success</code>';
                                    }else{
                                        echo '<code class="text-danger">Terjadi kesalahan pada saat menyimpan Log</code>';
                                    }
                                }else{
                                    echo '<code class="text-danger">Terjadi kesalahan pada saat menyimpan data</code>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>