<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');
    //Id Akses
    if (empty($SessionIdAkses)) {
        echo '<code class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang Terlebih Dulu</code>';
    } else {
        $id_akses=$SessionIdAkses;
        //Buka data askes
        $QryDetailAkses = mysqli_query($Conn,"SELECT * FROM akses WHERE id_akses='$id_akses'")or die(mysqli_error($Conn));
        $DataDetailAkses = mysqli_fetch_array($QryDetailAkses);
        $kontak_akses_lama= $DataDetailAkses['kontak_akses'];
        $email_akses_lama = $DataDetailAkses['email_akses'];
        //Validasi nama tidak boleh kosong
        if (empty($_POST['nama_akses'])) {
            echo '<code class="text-danger">Nama tidak boleh kosong</code>';
        } else {
            //Validasi kontak tidak boleh kosong
            if (empty($_POST['kontak_akses'])) {
                echo '<code class="text-danger">Kontak tidak boleh kosong</code>';
            } else {
                //Validasi kontak tidak boleh lebih dari 20 karakter
                $JumlahKarakterKontak = strlen($_POST['kontak_akses']);
                if ($JumlahKarakterKontak > 20 || $JumlahKarakterKontak < 6 || !preg_match("/^[0-9]*$/", $_POST['kontak_akses'])) {
                    echo '<code class="text-danger">Kontak hanya boleh terdiri dari 6-20 karakter numerik</code>';
                } else {
                    //Validasi kontak tidak boleh duplikat
                    $kontak_akses = $_POST['kontak_akses'];
                    if ($kontak_akses_lama == $kontak_akses) {
                        $ValidasiKontakDuplikat = 0;
                    } else {
                        $ValidasiKontakDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses WHERE kontak_akses='$kontak_akses'"));
                    }
                    if (!empty($ValidasiKontakDuplikat)) {
                        echo '<code class="text-danger">Nomor kontak sudah terdaftar</code>';
                    } else {
                        //Validasi email tidak boleh kosong
                        if (empty($_POST['email'])) {
                            echo '<code class="text-danger">Email tidak boleh kosong</code>';
                        } else {
                            $email_akses = $_POST['email'];
                            if ($email_akses_lama == $email_akses) {
                                $ValidasiEmailDuplikat = 0;
                            } else {
                                $ValidasiEmailDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses WHERE email_akses='$email_akses'"));
                            }
                            if (!empty($ValidasiEmailDuplikat)) {
                                echo '<code class="text-danger">Email yang anda gunakan sudah terdaftar</code>';
                            } else {
                                //Variabel Lainnya
                                $nama_akses = $_POST['nama_akses'];
                                $kontak_akses = $_POST['kontak_akses'];
                                $email_akses = $_POST['email'];
                                $UpdateAkses = mysqli_query($Conn, "UPDATE akses SET 
                                    nama_akses='$nama_akses',
                                    kontak_akses='$kontak_akses',
                                    email_akses='$email_akses',
                                    datetime_update='$now'
                                WHERE id_akses='$id_akses'") or die(mysqli_error($Conn));
                                if ($UpdateAkses) {
                                    $_SESSION ["NotifikasiSwal"]="Ubah Profil Berhasil";
                                    echo '<code class="text-success" id="NotifikasiUbahInformasiProfilBerhasil">Success</code>';
                                } else {
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