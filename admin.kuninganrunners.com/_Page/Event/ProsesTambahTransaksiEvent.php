<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    $now=date('Y-m-d H:i:s');
    $date=date('Y-m-d');
    $time=date('H:i:s');
    // Inisialisasi pesan error pertama kali
    $response = ['success' => false, 'message' => ''];
    $errors = []; 
    if(empty($SessionIdAkses)){
        $errors[] = 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang!.';
    }else{
        //Validasi id_member tidak boleh kosong
        if(empty($_POST['id_member'])){
            $errors[] = 'ID Member tidak boleh kosong!.';
        }else{
            //Validasi kode_transaksi tidak boleh kosong
            if(empty($_POST['kode_transaksi'])){
                $errors[] = 'Kode transaksi tidak boleh kosong!.';
            }else{
                //Validasi order_id tidak boleh kosong
                if(empty($_POST['order_id'])){
                    $errors[] = 'Order ID tidak boleh kosong!.';
                }else{
                    //Validasi first_name tidak boleh kosong
                    if(empty($_POST['first_name'])){
                        $errors[] = 'Nama Depan tidak boleh kosong!.';
                    }else{
                        //Validasi email tidak boleh kosong
                        if(empty($_POST['email'])){
                            $errors[] = 'Email tidak boleh kosong!.';
                        }else{
                            //Buat Variabel
                            $id_member=$_POST['id_member'];
                            $kode_transaksi=$_POST['kode_transaksi'];
                            $order_id=$_POST['order_id'];
                            $first_name=$_POST['first_name'];
                            $email=$_POST['email'];
                            if(empty($_POST['kontak'])){
                                $kontak="";
                            }else{
                                $kontak=$_POST['kontak'];
                            }
                            if(empty($_POST['last_name'])){
                                $last_name="";
                                $nama="$first_name";
                            }else{
                                $last_name=$_POST['last_name'];
                                $nama="$first_name $last_name";
                            }
                            if(empty($_POST['biaya_pendaftaran'])){
                                $biaya_pendaftaran="0";
                            }else{
                                $biaya_pendaftaran=$_POST['biaya_pendaftaran'];
                            }
                            //Bersihkan Variabel
                            $id_member=validateAndSanitizeInput($id_member);
                            $kode_transaksi=validateAndSanitizeInput($kode_transaksi);
                            $order_id=validateAndSanitizeInput($order_id);
                            $nama=validateAndSanitizeInput($nama);
                            $email=validateAndSanitizeInput($email);
                            $kontak=validateAndSanitizeInput($kontak);
                            $biaya_pendaftaran=validateAndSanitizeInput($biaya_pendaftaran);
                            $kategori="Pendaftaran";
                            $status="Pending";
                            //Membuat Raw Member
                            $raw_member = [
                                "id_member" => $id_member,
                                "nama" => $nama,
                                "first_name" => $first_name,
                                "last_name" => $last_name,
                                "email" => $email,
                                "kontak" => $kontak
                            ];
                            $raw_member=json_encode($raw_member, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                            // Insert data ke database
                            $query = "INSERT INTO transaksi (
                                id_member, 
                                raw_member, 
                                kategori, 
                                kode_transaksi, 
                                order_id, 
                                datetime, 
                                jumlah, 
                                status
                            ) VALUES (
                                ?, 
                                ?, 
                                ?, 
                                ?, 
                                ?, 
                                ?, 
                                ?,  
                                ?
                            )";
                            $stmt = $Conn->prepare($query);
                            $stmt->bind_param(
                                "ssssssss", 
                                $id_member, 
                                $raw_member, 
                                $kategori, 
                                $kode_transaksi, 
                                $order_id, 
                                $now, 
                                $biaya_pendaftaran, 
                                $status
                            );
                            if ($stmt->execute()) {
                                $kategori_log="Event";
                                $deskripsi_log="Tambah Pembayaran Peserta Event";
                                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                if($InputLog=="Success"){
                                    $response['success'] = true;
                                }else{
                                    $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                                }
                            }else{
                                $errors[] = 'Terjadi kesalahan pada saat menambahkan data pada database!.';
                            }
                        }
                    }
                }
            }
        }
    }
    if (!empty($errors)) {
        $response['message'] = implode('<br>', $errors);
        echo json_encode($response);
        exit;
    }else{
        echo json_encode($response);
    }
?>