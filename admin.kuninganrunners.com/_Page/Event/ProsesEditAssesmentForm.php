<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    $now=date('Y-m-d H:i:s');
    // Inisialisasi pesan error pertama kali
    $response = ['success' => false, 'message' => ''];
    $errors = []; 
    if(empty($SessionIdAkses)){
        $errors[] = 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang!.';
    }else{
        //Validasi id id_event_assesment_form boleh kosong
        if(empty($_POST['id_event_assesment_form'])){
            $errors[] = 'ID Assesment Form tidak boleh kosong!.';
        }else{
            //Validasi form_name tidak boleh kosong
            if(empty($_POST['form_name'])){
                $errors[] = 'Nama Form tidak boleh kosong!.';
            }else{
                //Validasi mandatori tidak boleh kosong
                if(empty($_POST['mandatori'])){
                    $errors[] = 'Status Mandatori tidak boleh kosong!.';
                }else{
                    //Buat Variabel
                    if(empty($_POST['komentar'])){
                        $komentar="";
                    }else{
                        $komentar=$_POST['komentar'];
                    }
                    //Bersihkan Variabel
                    $id_event_assesment_form=validateAndSanitizeInput($_POST['id_event_assesment_form']);
                    $form_name=validateAndSanitizeInput($_POST['form_name']);
                    $mandatori=validateAndSanitizeInput($_POST['mandatori']);
                    $komentar=validateAndSanitizeInput($komentar);
                    $form_type=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'form_type');
                    //Penanganan Data list_kategori_assesment
                    if(empty($_POST['list_kategori_assesment_edit'])){
                        $list_kategori_assesment=[];
                    }else{
                        $list_kategori_assesment=$_POST['list_kategori_assesment_edit'];
                    }
                    $json_list_kategori = json_encode($list_kategori_assesment);
                    //Validasi Alternatif berdasarkan form_type
                    if($form_type=="checkbox"||$form_type=="radio"||$form_type=="select_option"){
                        if(empty($_POST['alternatif_value'])){
                            $Alternatif="";
                            $ValidasiAlternatif="Untuk tipe form checkbox dan radio button, alternatif wajib diisi";
                        }else{
                            $alternatif_display = $_POST['alternatif_display'] ?? [];
                            $alternatif_value = $_POST['alternatif_value'] ?? [];
                            // Cek apakah keduanya memiliki jumlah data yang sama
                            if (count($alternatif_display) !== count($alternatif_value)) {
                                $ValidasiAlternatif="Pastikan Display dan Value Alternatif Sudah Terisi Seluruhnya!";
                            }else{
                                $is_valid = true; // Variabel untuk cek validitas
                                $errors = []; // Array untuk menyimpan pesan kesalahan
                                // Loop untuk memvalidasi setiap input
                                foreach ($alternatif_display as $index => $display) {
                                    $value = $alternatif_value[$index];
                                    // Validasi contoh: cek jika ada input kosong
                                    if (empty($display) || empty($value)) {
                                        $is_valid = false;
                                        $errors[] = "Alternatif ke-" . ($index + 1) . " tidak boleh kosong!";
                                    }
                                    // Tambahkan validasi lain yang diinginkan, contoh:
                                    if (strlen($display) > 50) {
                                        $is_valid = false;
                                        $errors[] = "Alternatif Display ke-" . ($index + 1) . " tidak boleh lebih dari 50 karakter!";
                                    }
                                }
                                // Jika validasi gagal, tampilkan pesan kesalahan
                                if (!$is_valid) {
                                    $Alternatif="";
                                    foreach ($errors as $error) {
                                        $ValidasiAlternatif = "<ul><li>" . implode("</li><li>", $errors) . "</li></ul>";
                                    }
                                } else {
                                    // Proses data jika validasi sukses
                                    $ValidasiAlternatif="Valid";
                                    $ListAlternatif=[];
                                    foreach ($alternatif_display as $index => $display) {
                                        $value = $alternatif_value[$index];
                                        $ListAlternatif[]=[
                                            "display" => $display,
                                            "value" => $value
                                        ];
                                    }
                                    $Alternatif=json_encode($ListAlternatif, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                                }
                            }
                        }
                    }else{
                        $Alternatif=null;
                        $ValidasiAlternatif="Valid";
                    }
                    if($ValidasiAlternatif!=="Valid"){
                        $errors[] = $ValidasiAlternatif;
                    }else{
                         // Query untuk mengupdate data event
                        $sql = "UPDATE event_assesment_form SET 
                            form_name = ?, 
                            mandatori = ?, 
                            alternatif = ?, 
                            komentar = ?,
                            kategori_list = ?
                        WHERE id_event_assesment_form = ?";
                        // Menyiapkan statement
                        $stmt = $Conn->prepare($sql);
                        $stmt->bind_param(
                            'ssssss', 
                            $form_name, 
                            $mandatori, 
                            $Alternatif, 
                            $komentar,
                            $json_list_kategori,
                            $id_event_assesment_form
                        );
                        // Eksekusi statement dan cek apakah berhasil
                        if ($stmt->execute()) {
                            $kategori_log="Event";
                            $deskripsi_log="Edit Assesment Form Event";
                            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                            if($InputLog=="Success"){
                                $response['success'] = true;
                            }else{
                                $errors[] = 'Terjadi kesalahan pada saat menyimpan log aktivitas!.';
                            }
                        }else{
                            $errors[] = 'Terjadi kesalahan pada saat update pada database!.';
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