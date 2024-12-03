<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Uang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['kode_transaksi'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Transaksi Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $kode_transaksi=$_POST['kode_transaksi'];
            //Bersihkan Data
            $kode_transaksi=validateAndSanitizeInput($kode_transaksi);
            //Buka Data
            $id_transaksi_validasi=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kode_transaksi');
            if(empty($id_transaksi_validasi)){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
                echo '          <small class="credit">';
                echo '              <code class="text-dark">';
                echo '                  Data Yang Anda Pilih Tidak Ditemukan Pada Database!';
                echo '              </code>';
                echo '          </small>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $status=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'status');
                //Validasi status
                if($status=="Lunas"){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12">';
                    echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
                    echo '          <small class="credit">';
                    echo '              <code class="text-dark">';
                    echo '                  Transaksi Tersebut Sudah Lunas!<br> Anda tidak bisa lagi mengubah data tersebut.';
                    echo '              </code>';
                    echo '          </small>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $kode_transaksi=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kode_transaksi');
                    $id_member=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'id_member');
                    $raw_member=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'raw_member');
                    $kategori=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kategori');
                    $datetime=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'datetime');
                    $tagihan=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'tagihan');
                    $ongkir=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'ongkir');
                    $ppn_pph=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'ppn_pph');
                    $biaya_layanan=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'biaya_layanan');
                    $biaya_lainnya=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'biaya_lainnya');
                    $potongan_lainnya=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'potongan_lainnya');
                    $jumlah=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'jumlah');
                    $status=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'status');
                    //Format Tanggal
                    $strtotime=strtotime($datetime);
                    $TanggalTransaksi=date('d/m/Y H:i', $strtotime);
                    //Biaya Pendaftaran
                    if(empty($jumlah)){
                        $jumlah=0;
                    }
                    $jumlah_format='Rp ' . number_format($jumlah, 2, ',', '.');
                    //Jumlah Riwayat Transaksi
                    $RiwayatPembayaran = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_payment FROM transaksi_payment WHERE kode_transaksi ='$kode_transaksi '"));
                    //Buka Raw Member
                    $raw_member_arry=json_decode($raw_member, true);
                    $NamaDepan=$raw_member_arry['first_name'];
                    $NamaBelakang=$raw_member_arry['last_name'];
                    $NomorKontak=$raw_member_arry['kontak'];
                    $EmailMember=$raw_member_arry['email'];

?>
        <input type="hidden" name="id_member" value="<?php echo $id_member; ?>">
        <input type="hidden" name="kode_transaksi" value="<?php echo $kode_transaksi; ?>">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="kode_transaksi_edit">
                    <small>Kode Transaksi</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" readonly name="kode_transaksi" id="kode_transaksi_edit" class="form-control" value="<?php echo "$kode_transaksi"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="first_name_edit">
                    <small>Nama Depan</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="first_name" id="first_name_edit" class="form-control" value="<?php echo "$NamaDepan"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="last_name_edit">
                    <small>Nama Belakang</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="last_name" id="last_name_edit" class="form-control" value="<?php echo "$NamaBelakang"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="email_edit">
                    <small>Email</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="email" id="email_edit" class="form-control" value="<?php echo "$EmailMember"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="kontak_edit">
                    <small>Kontak</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="kontak" id="kontak_edit" class="form-control" value="<?php echo "$NomorKontak"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="biaya_pendaftaran_edit">
                    <small>Biaya Pendaftaran</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="biaya_pendaftaran" id="biaya_pendaftaran_edit" class="form-control" value="<?php echo "$tagihan"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="ppn_edit">
                    <small>
                        PPN
                        <?php
                            if(empty($ppn_pph)){
                                echo "(0 %)";
                            }else{
                                //Hitung Persen PPN
                                if(!empty($tagihan)){
                                    $persen_ppn=($ppn_pph/$tagihan)*100;
                                    $persen_ppn=round($persen_ppn);
                                }else{
                                    $persen_ppn=0;
                                }
                                echo "($persen_ppn %)";
                            }
                        ?>
                    </small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="number" min="0" name="ppn" id="ppn_edit" class="form-control" value="<?php echo "$ppn_pph"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="biaya_layanan_edit">
                    <small>Biaya Layanan</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="number" min="0" name="biaya_layanan" id="biaya_layanan_edit" class="form-control" value="<?php echo "$biaya_layanan"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="biaya_lain_lain_edit">
                    <small>Biaya Lain-Lain</small>
                </label>
            </div>
            <div class="col-md-8">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-info btn-block" id="tambah_biaya_lainnya_edit">
                            <i class="bi bi-plus"></i> Tambah
                        </button>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-12" id="list_form_biaya_lainnya_edit">
                        <?php
                            if(!empty($biaya_lainnya)){
                                $biaya_lainnya_pendaftaran_arry=json_decode($biaya_lainnya, true);
                                if(!empty(count($biaya_lainnya_pendaftaran_arry))){
                                    foreach ($biaya_lainnya_pendaftaran_arry as $biaya_lainnya_pendaftaran_list) {
                                        $nama_biaya=$biaya_lainnya_pendaftaran_list['nama_biaya'];
                                        $nominal_biaya=$biaya_lainnya_pendaftaran_list['nominal_biaya'];
                        ?>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="nama_biaya[]" placeholder="Nama Biaya" value="<?php echo $nama_biaya; ?>">
                                <input type="number" min="0" class="form-control nominal_biaya_class_edit" name="nominal_biaya[]" placeholder="Rp" value="<?php echo $nominal_biaya; ?>">
                                <button type="button" class="btn btn-danger hapus_biaya_lainnya_edit">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        <?php 
                                    }
                                }
                            } 
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="potongan_lain_lain_edit">
                    <small>Potongan Lain-Lain</small>
                </label>
            </div>
            <div class="col-md-8">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-info btn-block" id="tambah_potongan_lainnya_edit">
                            <i class="bi bi-plus"></i> Tambah
                        </button>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-12" id="list_form_potongan_lainnya_edit">
                        <?php
                            if(!empty($potongan_lainnya)){
                                $potongan_lainnya_pendaftaran_arry=json_decode($potongan_lainnya, true);
                                if(!empty(count($potongan_lainnya_pendaftaran_arry))){
                                    foreach ($potongan_lainnya_pendaftaran_arry as $potongan_lainnya_pendaftaran_list) {
                                        $nama_potongan=$potongan_lainnya_pendaftaran_list['nama_potongan'];
                                        $nominal_potongan=$potongan_lainnya_pendaftaran_list['nominal_potongan'];
                        ?>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="nama_potongan[]" placeholder="Nama Potongan" value="<?php echo $nama_potongan; ?>">
                                <input type="number" min="0" class="form-control nominal_potongan_class_edit" name="nominal_potongan[]" placeholder="Rp" value="<?php echo $nominal_potongan; ?>">
                                <button type="button" class="btn btn-danger hapus_potongan_lainnya_edit">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        <?php 
                                    }
                                }
                            } 
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="jumlah_transaksi_edit">
                    <small>Jumlah Total</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="number" min="0" readonly name="jumlah" id="jumlah_transaksi_edit" class="form-control" value="<?php echo "$jumlah"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <small class="credit">
                        Pastikan sebelum mengubah data transaksi tersebut belum menerima pembayaran untuk menghidarkan dari nominal yang tidak sesuai.
                    </small>
                </div>
            </div>
        </div>
        <script>
            // Tambah baris form untuk biaya_lainnya_penjualan
            $('#tambah_biaya_lainnya_edit').click(function() {
                var newRowEdit = `
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="nama_biaya[]" placeholder="Nama Biaya">
                        <input type="number" min="0" class="form-control nominal_biaya_class_edit" name="nominal_biaya[]" placeholder="Rp">
                        <button type="button" class="btn btn-danger hapus_biaya_lainnya_edit">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                `;
                $('#list_form_biaya_lainnya_edit').append(newRowEdit);
                hitung_jumlah_transaksi_edit();
            });
            // Tambah baris form untuk potongan_lainnya_penjualan2
            $('#tambah_potongan_lainnya_edit').click(function() {
                var newRowEdit = `
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="nama_potongan[]" placeholder="Nama Potongan">
                        <input type="number" min="0" class="form-control nominal_potongan_class_edit" name="nominal_potongan[]" placeholder="Rp">
                        <button type="button" class="btn btn-danger hapus_potongan_lainnya_edit">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                `;
                $('#list_form_potongan_lainnya_edit').append(newRowEdit);
                hitung_jumlah_transaksi_edit();
            });

            // Hapus baris form untuk hapus_biaya_lainnya_edit
            $(document).on('click', '.hapus_biaya_lainnya_edit', function() {
                $(this).closest('.input-group').remove();
                hitung_jumlah_transaksi_edit();
            });
            // Hapus baris form untuk hapus_potongan_lainnya_edit
            $(document).on('click', '.hapus_potongan_lainnya_edit', function() {
                $(this).closest('.input-group').remove();
                hitung_jumlah_transaksi_edit();
            });

            //Apabila ada pengetikan pada biaya_pendaftaran_edit
            $('#biaya_pendaftaran_edit').on('input', function() {
                hitung_jumlah_transaksi_edit();
            });
            //Apabila ada pengetikan pada ppn
            $('#ppn_edit').on('input', function() {
                hitung_jumlah_transaksi_edit();
            });
            //Apabila ada pengetikan pada biaya_layanan
            $('#biaya_layanan_edit').on('input', function() {
                hitung_jumlah_transaksi_edit();
            });
            //Apabila ada pengetikan pada class nominal_biaya_class_edit
            $(document).on('input', '.nominal_biaya_class_edit', function() {
                hitung_jumlah_transaksi_edit();
            });
            //Apabila ada pengetikan pada class nominal_potongan_class_edit
            $(document).on('input', '.nominal_potongan_class_edit', function() {
                hitung_jumlah_transaksi_edit();
            });
        </script>
<?php
                }
            }
        }
    }
?>