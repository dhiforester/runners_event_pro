<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi title_api_key tidak boleh kosong
    if(empty($_POST['title_api_key'])){
        echo '<code class="text-danger">Judul/Nama API Key Tidak Boleh Kosong!</code>';
    }else{
        //Validasi description_api_key tidak boleh kosong
        if(empty($_POST['description_api_key'])){
            echo '<code class="text-danger">Setidaknya anda memberitahu kami tujuan/keterangan dibuatnya API key tersebut.</code>';
        }else{
            //Validasi user_key_server tidak boleh kosong
            if(empty($_POST['user_key_server'])){
                echo '<code class="text-danger">User Key Tidak Boleh Kosong</code>';
            }else{
                //Validasi password_server tidak boleh kosong
                if(empty($_POST['password_server'])){
                    echo '<code class="text-danger">Password Server Tidak Boleh Kosong</code>';
                }else{
                    //Validasi status_api_key tidak boleh kosong
                    if(empty($_POST['status_api_key'])){
                        echo '<code class="text-danger">Status Tidak Boleh Kosong</code>';
                    }else{
                        //Validasi limit_session tidak boleh kosong
                        if(empty($_POST['limit_session'])){
                            echo '<code class="text-danger">Limit Session Tidak Boleh Kosong</code>';
                        }else{
                            $title_api_key=$_POST['title_api_key'];
                            $description_api_key=$_POST['description_api_key'];
                            $user_key_server=$_POST['user_key_server'];
                            $password_server=$_POST['password_server'];
                            $status_api_key=$_POST['status_api_key'];
                            $limit_session=$_POST['limit_session'];
                            //Validasi Jumlah Karakter
                            $JumlahKarakterTitle=strlen($title_api_key);
                            if($JumlahKarakterTitle>20){
                                echo '<code class="text-danger">Judul/Nama API Key yang anda input tidak boleh lebih dari 20 karakter termasuk spasi</code>';
                            }else{
                                //Validasi API key Sama
                                $ValidasiTitleDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_api_key WHERE title_api_key='$title_api_key'"));
                                if(!empty($ValidasiTitleDuplikat)){
                                    echo '<code class="text-danger">Judul/Nama API Key yang anda input sudah digunakan!</code>';
                                }else{
                                    //Membersihkan Data
                                    $title_api_key=validateAndSanitizeInput($title_api_key);
                                    $description_api_key=validateAndSanitizeInput($description_api_key);
                                    $user_key_server=validateAndSanitizeInput($user_key_server);
                                    $password_server=validateAndSanitizeInput($password_server);
                                    $status_api_key=validateAndSanitizeInput($status_api_key);
                                    $limit_session=validateAndSanitizeInput($limit_session);
                                    //Mengubah Password Menjadi MD5
                                    $password_server=md5($password_server);
                                    //Simpan Ke database
                                    $entry="INSERT INTO setting_api_key (
                                        datetime_creat,
                                        datetime_update,
                                        title_api_key,
                                        description_api_key,
                                        user_key_server,
                                        password_server,
                                        limit_session,
                                        status
                                    ) VALUES (
                                        '$now',
                                        '$now',
                                        '$title_api_key',
                                        '$description_api_key',
                                        '$user_key_server',
                                        '$password_server',
                                        '$limit_session',
                                        '$status_api_key'
                                    )";
                                    $Input=mysqli_query($Conn, $entry);
                                    if($Input){
                                        $KategoriLog="API Key";
                                        $KeteranganLog="Tambah API Key Berhasil";
                                        include "../../_Config/InputLog.php";
                                        echo '<small class="text-success" id="NotifikasiTambahApiKeyBerhasil">Success</small>';
                                    }else{
                                        echo '<small class="text-danger">An error occurred while inputting data</small>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>