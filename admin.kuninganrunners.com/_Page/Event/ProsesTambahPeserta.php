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
            //Validasi kategori_event tidak boleh kosong
            if(empty($_POST['kategori_event'])){
                $errors[] = 'Kategori event tidak boleh kosong!.';
            }else{
                //Validasi status_pembayaran tidak boleh kosong
                if(empty($_POST['status_pembayaran'])){
                    $errors[] = 'Status pembayaran tidak boleh kosong!.';
                }else{
                    //Buat Variabel
                    $id_member=$_POST['id_member'];
                    $id_event_kategori=$_POST['kategori_event'];
                    $status=$_POST['status_pembayaran'];
                    //Bersihkan Variabel
                    $id_member=validateAndSanitizeInput($id_member);
                    $id_event_kategori=validateAndSanitizeInput($id_event_kategori);
                    $status=validateAndSanitizeInput($status);
                    //Cari id_event
                    $id_event_kategori=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'id_event_kategori');
                    //Validasi id_event
                    if(empty($id_event_kategori)){
                        $errors[] = 'Kategori event yang anda pilih tidak valid, atau tidak ada pada database';
                    }else{
                        $biaya_pendaftaran=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'biaya_pendaftaran');
                        $id_event=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'id_event');
                        //Validasi Duplikat Data
                        $ValidasiDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_peserta FROM event_peserta WHERE id_member='$id_member' AND id_event='$id_event'"));
                        if(!empty($ValidasiDuplikat)){
                            $errors[] = 'Peserta sudah terdaftar pada event ini.';
                        }else{
                            //Validasi Member
                            $ValidasiIdMember=GetDetailData($Conn,'member','id_member',$id_member,'id_member');
                            if(empty($ValidasiIdMember)){
                                $errors[] = 'Id member '.$id_member.' yang anda pilih tidak valid, atau tidak ada pada database';
                            }else{
                                $nama=GetDetailData($Conn,'member','id_member',$id_member,'nama');
                                $email=GetDetailData($Conn,'member','id_member',$id_member,'email');
                                if(empty($nama)){
                                    $errors[] = 'Member '.$id_member.' yang anda pilih tidak valid, atau tidak ada pada database';
                                }else{
                                    $id_event_peserta=GenerateToken(36);
                                    $kategori='Pendaftaran';
                                    // Insert data ke database
                                    $query = "INSERT INTO event_peserta (id_event_peserta, id_event, id_event_kategori, id_member, nama, email, biaya_pendaftaran, datetime, status) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                    $stmt = $Conn->prepare($query);
                                    $stmt->bind_param("sssssssss", $id_event_peserta, $id_event, $id_event_kategori, $id_member, $nama, $email, $biaya_pendaftaran, $now, $status);
                                    if ($stmt->execute()) {
                                        $kategori_log="Event";
                                        $deskripsi_log="Tambah Peserta Event";
                                        $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                        if($InputLog=="Success"){
                                            $response['success'] = true;
                                        }else{
                                            $HapusTransaksi = mysqli_query($Conn, "DELETE FROM transaksi WHERE id_transaksi='$id_transaksi'") or die(mysqli_error($Conn));
                                            $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                                        }
                                    }else{
                                        $errors[] = 'Terjadi kesalahan pada saat menambahkan peserta event pada database!.';
                                    }
                                }
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