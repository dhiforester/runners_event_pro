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
        //Validasi id_event_peserta tidak boleh kosong
        if(empty($_POST['id_event_peserta'])){
            $errors[] = 'ID Event Peserta tidak boleh kosong!.';
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
                    $id_event_peserta=$_POST['id_event_peserta'];
                    $id_event_kategori=$_POST['kategori_event'];
                    $status=$_POST['status_pembayaran'];
                    //Bersihkan Variabel
                    $id_event_peserta=validateAndSanitizeInput($id_event_peserta);
                    $id_event_kategori=validateAndSanitizeInput($id_event_kategori);
                    $status=validateAndSanitizeInput($status);
                    //Cari id_event
                    $ValidasiEventKategori=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'id_event_kategori');
                    $ValidasiEventPeserta=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event_peserta');
                    //Validasi id_event
                    if(empty($ValidasiEventKategori)){
                        $errors[] = 'Kategori event yang anda pilih tidak valid, atau tidak ada pada database';
                    }else{
                        if(empty($ValidasiEventPeserta)){
                            $errors[] = 'Peserta event yang anda pilih tidak valid, atau tidak ada pada database';
                        }else{
                            $biaya_pendaftaran=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'biaya_pendaftaran');
                            // Query untuk mengupdate data event
                            $sql = "UPDATE event_peserta SET 
                                    id_event_kategori = ?, 
                                    biaya_pendaftaran = ?, 
                                    status = ?
                            WHERE id_event_peserta = ?";
                            // Menyiapkan statement
                            $stmt = $Conn->prepare($sql);
                            $stmt->bind_param('ssss', 
                                $id_event_kategori, 
                                $biaya_pendaftaran, 
                                $status,
                                $id_event_peserta
                            );
                            // Eksekusi statement dan cek apakah berhasil
                            if ($stmt->execute()) {
                                $kategori_log="Event";
                                $deskripsi_log="Edit Peserta Event";
                                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                if($InputLog=="Success"){
                                    $response['success'] = true;
                                }else{
                                    $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                                }
                            }else{
                                $errors[] = 'Terjadi kesalahan pada saat memperbaharui data peserta.';
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