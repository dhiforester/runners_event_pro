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
        //Validasi kode_transaksi tidak boleh kosong
        if(empty($_POST['kode_transaksi'])){
            $errors[] = 'ID Transaksi tidak boleh kosong!.';
        }else{
            //Validasi kode_transaksi tidak boleh kosong
            if(empty($_POST['kode_transaksi'])){
                $errors[] = 'Kode transaksi tidak boleh kosong!.';
            }else{
                //Validasi first_name tidak boleh kosong
                if(empty($_POST['first_name'])){
                    $errors[] = 'Nama Depan tidak boleh kosong!.';
                }else{
                    //Validasi email tidak boleh kosong
                    if(empty($_POST['email'])){
                        $errors[] = 'Email tidak boleh kosong!.';
                    }else{
                        //Validasi id_member tidak boleh kosong
                        if(empty($_POST['id_member'])){
                            $errors[] = 'ID Member tidak boleh kosong!.';
                        }else{
                            //Buat Variabel
                            $kode_transaksi=$_POST['kode_transaksi'];
                            $id_member=$_POST['id_member'];
                            $kode_transaksi=$_POST['kode_transaksi'];
                            $first_name=$_POST['first_name'];
                            $email=$_POST['email'];
                            if(empty($_POST['kontak'])){
                                $kontak="";
                            }else{
                                $kontak=$_POST['kontak'];
                            }
                            if(empty($_POST['last_name'])){
                                $last_name="";
                                $nama_member="$first_name";
                            }else{
                                $last_name=$_POST['last_name'];
                                $nama_member="$first_name $last_name";
                            }
                            if(empty($_POST['biaya_pendaftaran'])){
                                $biaya_pendaftaran="0";
                            }else{
                                $biaya_pendaftaran=$_POST['biaya_pendaftaran'];
                            }
                            if(!empty($_POST['ppn'])){
                                $ppn=$_POST['ppn'];
                            }else{
                                $ppn=0;
                            }
                            if(!empty($_POST['biaya_layanan'])){
                                $biaya_layanan=$_POST['biaya_layanan'];
                            }else{
                                $biaya_layanan=0;
                            }
                            //Membuat Raw biaya dan potongan lain-lain
                            $nama_biaya = $_POST['nama_biaya'] ?? []; // Array nama_biaya
                            $nominal_biaya = $_POST['nominal_biaya'] ?? []; // Array nominal_biaya
                            $nama_potongan = $_POST['nama_potongan'] ?? []; // Array nama_potongan
                            $nominal_potongan = $_POST['nominal_potongan'] ?? []; // Array nominal_potongan
    
                            // Inisialisasi total dan JSON list
                            $total_biaya = 0;
                            $total_potongan = 0;
                            $json_biaya = [];
                            $json_potongan = [];
    
                            // Proses data biaya
                            foreach ($nama_biaya as $index => $nama) {
                                $nominal = isset($nominal_biaya[$index]) ? (int)$nominal_biaya[$index] : 0;
                                $total_biaya += $nominal;
                                $json_biaya[] = [
                                    'nama_biaya' => $nama,
                                    'nominal_biaya' => $nominal,
                                ];
                            }
    
                            // Proses data potongan
                            foreach ($nama_potongan as $index => $nama) {
                                $nominal = isset($nominal_potongan[$index]) ? (int)$nominal_potongan[$index] : 0;
                                $total_potongan += $nominal;
                                $json_potongan[] = [
                                    'nama_potongan' => $nama,
                                    'nominal_potongan' => $nominal,
                                ];
                            }
                            // Konversi ke JSON
                            $json_biaya = json_encode($json_biaya);
                            $json_potongan = json_encode($json_potongan);
                            //Bersihkan Variabel
                            $kode_transaksi=validateAndSanitizeInput($kode_transaksi);
                            $nama_member=validateAndSanitizeInput($nama_member);
                            $email=validateAndSanitizeInput($email);
                            $kontak=validateAndSanitizeInput($kontak);
                            $biaya_pendaftaran=validateAndSanitizeInput($biaya_pendaftaran);
                            $kategori="Pendaftaran";
                            //Membuat Raw Member
                            $raw_member = [
                                "id_member" => $id_member,
                                "nama" => $nama_member,
                                "first_name" => $first_name,
                                "last_name" => $last_name,
                                "email" => $email,
                                "kontak" => $kontak
                            ];
                            $raw_member=json_encode($raw_member, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                            $jumlah_total_transaksi=($biaya_pendaftaran+$ppn+$biaya_layanan+$total_biaya)-$total_potongan;
                            //Proses Update
                            $sql = "UPDATE transaksi SET 
                                    raw_member = ?, 
                                    tagihan = ?, 
                                    ppn_pph = ?, 
                                    biaya_layanan = ?, 
                                    biaya_lainnya = ?, 
                                    potongan_lainnya = ?, 
                                    jumlah = ?
                            WHERE kode_transaksi = ?";
                            // Menyiapkan statement
                            $stmt = $Conn->prepare($sql);
                            $stmt->bind_param('ssssssss', 
                                $raw_member, 
                                $biaya_pendaftaran,
                                $ppn,
                                $biaya_layanan,
                                $json_biaya,
                                $json_potongan,
                                $jumlah_total_transaksi,
                                $kode_transaksi
                            );
                            // Eksekusi statement dan cek apakah berhasil
                            if ($stmt->execute()) {
                                $kategori_log="Event";
                                $deskripsi_log="Edit Transaksi Peserta Event";
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