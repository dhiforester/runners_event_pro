<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    // Time Zone
    date_default_timezone_set('Asia/Jakarta');
    // Time Now Tmp
    $now = date('Y-m-d H:i:s');
    //Validasi Session Login
    if(empty($SessionIdAkses)){
        echo '<code class="text-danger">Sesi akses sudah berakhir, silahkan login ulang!</code>';
    }else{
        // Validasi title_api_key tidak boleh kosong
        if (empty($_POST['title_api_key'])) {
            echo '<code class="text-danger">Judul/Nama API Key Tidak Boleh Kosong!</code>';
        } else {
            // Validasi description_api_key tidak boleh kosong
            if (empty($_POST['description_api_key'])) {
                echo '<code class="text-danger">Setidaknya anda memberitahu kami tujuan/keterangan dibuatnya API key tersebut.</code>';
            } else {
                // Validasi user_key_server tidak boleh kosong
                if (empty($_POST['user_key_server'])) {
                    echo '<code class="text-danger">User Key Tidak Boleh Kosong</code>';
                } else {
                    // Validasi password_server tidak boleh kosong
                    if (empty($_POST['password_server'])) {
                        echo '<code class="text-danger">Password Server Tidak Boleh Kosong</code>';
                    } else {
                        // Validasi status_api_key tidak boleh kosong
                        if (empty($_POST['status_api_key'])) {
                            echo '<code class="text-danger">Status Tidak Boleh Kosong</code>';
                        } else {
                            // Validasi limit_session tidak boleh kosong
                            if (empty($_POST['limit_session'])) {
                                echo '<code class="text-danger">Limit Session Tidak Boleh Kosong</code>';
                            } else {
                                // Ambil nilai input
                                $title_api_key = $_POST['title_api_key'];
                                $description_api_key = $_POST['description_api_key'];
                                $user_key_server = $_POST['user_key_server'];
                                $password_server = $_POST['password_server'];
                                $status_api_key = $_POST['status_api_key'];
                                $limit_session = $_POST['limit_session'];

                                // Menghitung Jumlah Karakter
                                $title_api_key_length = strlen($title_api_key);
                                $description_api_key_length = strlen($description_api_key);
                                $user_key_server_length = strlen($user_key_server);
                                $password_server_length = strlen($password_server);

                                // Validasi Jumlah karakter
                                if ($title_api_key_length > 50) {
                                    echo '<code class="text-danger">Judul/Nama API Key yang anda input tidak boleh lebih dari 50 karakter termasuk spasi</code>';
                                } else if ($description_api_key_length > 200) {
                                    echo '<code class="text-danger">Deskripsi/Keterangan yang anda input tidak boleh lebih dari 200 karakter termasuk spasi</code>';
                                } else if ($user_key_server_length > 36) {
                                    echo '<code class="text-danger">User Key yang anda input tidak boleh lebih dari 36 karakter termasuk spasi</code>';
                                } else if ($password_server_length > 20) {
                                    echo '<code class="text-danger">Password server yang anda input tidak boleh lebih dari 20 karakter termasuk spasi</code>';
                                } else {
                                    // Validasi API key Sama
                                    $stmt = $Conn->prepare("SELECT * FROM setting_api_key WHERE title_api_key = ?");
                                    $stmt->bind_param("s", $title_api_key);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        echo '<code class="text-danger">Judul/Nama API Key yang anda input sudah digunakan!</code>';
                                    } else {
                                        // Membersihkan Data
                                        $title_api_key = validateAndSanitizeInput($title_api_key);
                                        $description_api_key = validateAndSanitizeInput($description_api_key);
                                        $user_key_server = validateAndSanitizeInput($user_key_server);
                                        $password_server = validateAndSanitizeInput($password_server);
                                        $status_api_key = validateAndSanitizeInput($status_api_key);
                                        $limit_session = validateAndSanitizeInput($limit_session);

                                        // Validasi karakter
                                        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $title_api_key)) {
                                            echo '<code class="text-danger">Judul/Nama API Key hanya boleh huruf, angka, dan spasi.</code>';
                                            return;
                                        }
                                        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $description_api_key)) {
                                            echo '<code class="text-danger">Deskripsi/Keterangan hanya boleh huruf, angka, dan spasi.</code>';
                                            return;
                                        }
                                        if (!preg_match("/^[a-zA-Z0-9]*$/", $user_key_server)) {
                                            echo '<code class="text-danger">User Key hanya boleh huruf dan angka.</code>';
                                            return;
                                        }
                                        if (!preg_match("/^[a-zA-Z0-9]*$/", $password_server)) {
                                            echo '<code class="text-danger">Password hanya boleh huruf dan angka.</code>';
                                            return;
                                        }

                                        // Mengubah Password Menjadi password_hash
                                        $password_server = password_hash($password_server, PASSWORD_DEFAULT);

                                        // Simpan Ke database
                                        $stmt = $Conn->prepare("INSERT INTO setting_api_key (
                                            datetime_creat,
                                            datetime_update,
                                            title_api_key,
                                            description_api_key,
                                            user_key_server,
                                            password_server,
                                            limit_session,
                                            status
                                        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                                        $stmt->bind_param("ssssssss", $now, $now, $title_api_key, $description_api_key, $user_key_server, $password_server, $limit_session, $status_api_key);

                                        if ($stmt->execute()) {
                                            $kategori_log = "API Key";
                                            $deskripsi_log = "Tambah API Key";
                                            $InputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);
                                            if ($InputLog == "Success") {
                                                echo '<small class="text-success" id="NotifikasiTambahApiKeyBerhasil">Success</small>';
                                            }else{
                                                echo '<small class="text-danger">Terjadi kesalahan pada saat input log</small>';
                                            }
                                        } else {
                                            echo '<small class="text-danger">Terjadi kesalahan pada saat input API key pada database</small>';
                                        }
                                    }
                                    $stmt->close();
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>