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
        //Validasi id_event_assesment_form tidak boleh kosong
        if(empty($_POST['id_event_assesment_form'])){
            $errors[] = 'ID Form tidak boleh kosong!.';
        }else{
            //Validasi id_event_peserta tidak boleh kosong
            if(empty($_POST['id_event_peserta'])){
                $errors[] = 'ID Peserta tidak boleh kosong!.';
            }else{
                //Buat Variabel
                $id_event_assesment_form=$_POST['id_event_assesment_form'];
                $id_event_peserta=$_POST['id_event_peserta'];
                //Bersihkan Variabel
                $id_event_assesment_form=validateAndSanitizeInput($id_event_assesment_form);
                $id_event_peserta=validateAndSanitizeInput($id_event_peserta);
                //Buka Event
                $id_event=GetDetailData($Conn,'event','id_event_peserta',$id_event_peserta,'id_event');
                //Buka Detail Form
                $form_type=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'form_type');
                $mandatori=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'mandatori');
                //Buka Apakah Sebelumnya Sudah ADa Data
                $Qry = $Conn->prepare("SELECT id_event_assesment FROM event_assesment WHERE id_event_assesment_form = ? AND id_event_peserta = ?");
                if ($Qry === false) {
                    $id_event_assesment="";
                }
                // Bind parameter
                $Qry->bind_param("ss", $id_event_assesment_form, $id_event_peserta);
                // Eksekusi query
                if (!$Qry->execute()) {
                    $id_event_assesment="";
                }
                // Mengambil hasil
                $Result = $Qry->get_result();
                $Data = $Result->fetch_assoc();
                // Menutup statement
                $Qry->close();
                // Mengembalikan hasil
                if (empty($Data['id_event_assesment'])) {
                    $id_event_assesment="";
                } else {
                    $id_event_assesment=$Data['id_event_assesment'];
                }
                //Buat Nama Form
                if($form_type=="text"||$form_type=="textarea"||$form_type=="radio"||$form_type=="select_option"){
                    if(empty($_POST[$id_event_assesment_form])){
                        $form_value="";
                    }else{
                        $form_value=$_POST[$id_event_assesment_form];
                    }
                    if($form_type=="text"){
                        if(strlen($form_value)>100){
                            $ValidasiFormValue="Data Yang Anda Input Tidak Boleh Lebih Dari 100 Karakter";
                        }else{
                            $ValidasiFormValue="Valid";
                        }
                    }else{
                        if($form_type=="textarea"){
                            if(strlen($form_value)>500){
                                $ValidasiFormValue="Data Yang Anda Input Tidak Boleh Lebih Dari 500 Karakter";
                            }else{
                                $ValidasiFormValue="Valid";
                            }
                        }else{
                            $ValidasiFormValue="Valid";
                        }
                    }
                }else{
                    if($form_type=="file_foto"){
                        $file_ext = strtolower(pathinfo($_FILES[$id_event_assesment_form]['name'], PATHINFO_EXTENSION));
                        $allowed_file_types = ['png', 'jpg', 'jpeg', 'gif'];
                        if (!in_array($file_ext, $allowed_file_types)) {
                            $ValidasiFormValue= 'Format file harus boleh PNG, JPG, JPEG, atau GIF.';
                        }else{
                            if ($_FILES[$id_event_assesment_form]['size'] > 5 * 1024 * 1024) { // 5 MB
                                $ValidasiFormValue= 'Ukuran file tidak boleh lebih dari 5 MB.';
                            }else{
                                $form_value = bin2hex(random_bytes(16)) . '.' . $file_ext;
                                $form_value_path = '../../assets/img/Assesment/' . $form_value;
                                if (!move_uploaded_file($_FILES[$id_event_assesment_form]['tmp_name'], $form_value_path)) {
                                    $ValidasiFormValue="Gagal Melakukan Upload File";
                                }else{
                                    //Apabila Sebelumnya Sudah Ada File
                                    if(!empty($id_event_assesment)){
                                        $assesment_value=GetDetailData($Conn,'event_assesment','id_event_assesment',$id_event_assesment,'assesment_value');
                                        $assesment_value_path = '../../assets/img/Assesment/' . $assesment_value;
                                        //Hapus
                                        unlink($poster_upload_path);
                                    }
                                    $ValidasiFormValue="Valid";
                                }
                            }
                        }
                        
                    }else{
                        if($form_type=="file_pdf"){
                            $file_ext = strtolower(pathinfo($_FILES[$id_event_assesment_form]['name'], PATHINFO_EXTENSION));
                            $allowed_file_types = ['pdf'];
                            if (!in_array($file_ext, $allowed_file_types)) {
                                $ValidasiFormValue= 'Format file hanya boleh PDF.';
                            }else{
                                if ($_FILES[$id_event_assesment_form]['size'] > 5 * 1024 * 1024) { // 5 MB
                                    $ValidasiFormValue= 'Ukuran file poster tidak boleh lebih dari 5 MB.';
                                }else{
                                    $form_value = bin2hex(random_bytes(16)) . '.' . $file_ext;
                                    $form_value_path = '../../assets/img/Assesment/' . $form_value;
                                    if (!move_uploaded_file($_FILES[$id_event_assesment_form]['tmp_name'], $form_value_path)) {
                                        $ValidasiFormValue="Gagal Melakukan Upload File";
                                    }else{
                                        //Apabila Sebelumnya Sudah Ada File
                                        if(!empty($id_event_assesment)){
                                            $assesment_value=GetDetailData($Conn,'event_assesment','id_event_assesment',$id_event_assesment,'assesment_value');
                                            $assesment_value_path = '../../assets/img/Assesment/' . $assesment_value;
                                            //Hapus
                                            unlink($poster_upload_path);
                                        }
                                        $ValidasiFormValue="Valid";
                                    }
                                }
                            }
                            
                        }else{
                            if($form_type=="checkbox"){
                                if(empty($_POST[$id_event_assesment_form])){
                                    $form_value="";
                                }else{
                                    $value_checkbox=$_POST[$id_event_assesment_form];
                                    $form_value = json_encode($value_checkbox);
                                }
                                $ValidasiFormValue="Valid";
                            }else{
                                $ValidasiFormValue="Tipe File Tidak Valid";
                            }
                        }
                    }
                }
                if($ValidasiFormValue!=="Valid"){
                    $errors[] = $ValidasiFormValue;
                }else{
                    //Apabila Data Baru Maka Insert
                    if(empty($id_event_assesment)){
                        $status_assesment_array=[
                            "status_assesment" => "Pending",
                            "komentar" => "",
                        ];
                        $status_assesment = json_encode($status_assesment_array);
                        // Query untuk insert data
                        $query = "INSERT INTO event_assesment (
                            id_event_assesment_form,
                            id_event_peserta,
                            assesment_value, 
                            status_assesment
                        ) VALUES (?, ?, ?, ?)";

                        // Mempersiapkan statement
                        $stmt = $Conn->prepare($query);

                        // Mengecek apakah prepare berhasil
                        if ($stmt) {
                            // Mengikat parameter ke statement
                            $stmt->bind_param(
                            "ssss", 
                            $id_event_assesment_form, 
                            $id_event_peserta, 
                            $form_value, 
                            $status_assesment
                            );
                            // Eksekusi statement dan cek hasilnya
                            if ($stmt->execute()) {
                                $ValidasiProses = "Berhasil";
                            } else {
                                $ValidasiProses = 'Terjadi kesalahan pada saat insert data ke database!';
                            }
                            // Menutup statement setelah digunakan
                            $stmt->close();
                        } else {
                            $ValidasiProses = 'Gagal mempersiapkan statement!';
                        }
                    }else{
                        //Update
                        $sql = "UPDATE event_assesment SET 
                            assesment_value = ?
                        WHERE id_event_assesment = ?";
                        // Menyiapkan statement
                        $stmt = $Conn->prepare($sql);
                        $stmt->bind_param('ss', $form_value, $id_event_assesment);
                        // Eksekusi statement dan cek apakah berhasil
                        if ($stmt->execute()) {
                            $ValidasiProses="Berhasil";
                        }else{
                            $ValidasiProses= 'Terjadi kesalahan pada saat update data pada database!.';
                        }
                    }
                    if($ValidasiProses=="Berhasil"){
                        $kategori_log="Event";
                        $deskripsi_log="Insert/Update Assesment Peserta";
                        $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                        if($InputLog=="Success"){
                            $response['success'] = true;
                        }else{
                            $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                        }
                    }else{
                        $errors[] = $ValidasiProses;
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