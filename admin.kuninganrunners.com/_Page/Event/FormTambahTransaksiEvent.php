<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Uang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_event_peserta'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Peserta Event Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_event_peserta=$_POST['id_event_peserta'];
            //Bersihkan Data
            $id_event_peserta=validateAndSanitizeInput($id_event_peserta);
            //Buka Data
            $id_event_peserta_validasi=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event_peserta');
            if(empty($id_event_peserta_validasi)){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                echo '          <small class="credit">';
                echo '              <code class="text-dark">';
                echo '                  Data Yang Anda Pilih Tidak Ditemukan Pada Database!';
                echo '              </code>';
                echo '          </small>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $id_event=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event');
                $id_event_kategori=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event_kategori');
                $id_member=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_member');
                $nama=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'nama');
                $email=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'email');
                $biaya_pendaftaran=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'biaya_pendaftaran');
                if(empty($biaya_pendaftaran)){
                    $biaya_pendaftaran=0;
                }
                $datetime=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'datetime');
                $status=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'status');
                $kategori=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'kategori');
                //Pecah Nama
                $explode=explode(' ',$nama);
                $first_name=$explode[0];
                $last_name=$explode[1];
                //Kontak
                $kontak=GetDetailData($Conn,'member','id_member',$id_member,'kontak');
                //Order ID
                $order_id=GenerateToken('36');
                //Buka Pengaturan Transaksi
                $ppn_pph_pendaftaran=GetDetailData($Conn,'setting_transaksi','kategori ','Pendaftaran','ppn_pph');
                $biaya_layanan_pendaftaran=GetDetailData($Conn,'setting_transaksi','kategori ','Pendaftaran','biaya_layanan');
                $biaya_lainnya_pendaftaran=GetDetailData($Conn,'setting_transaksi','kategori ','Pendaftaran','biaya_lainnya');
                $potongan_lainnya_pendaftaran=GetDetailData($Conn,'setting_transaksi','kategori ','Pendaftaran','potongan_lainnya');
?>
        <input type="hidden" name="id_member" value="<?php echo $id_member; ?>">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="kode_transaksi">
                    <small>Kode Transaksi</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" readonly name="kode_transaksi" id="kode_transaksi" class="form-control" value="<?php echo "$id_event_peserta"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="first_name">
                    <small>Nama Depan</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo "$first_name"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="last_name">
                    <small>Nama Belakang</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo "$last_name"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="email">
                    <small>Email</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="email" id="email" class="form-control" value="<?php echo "$email"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="kontak">
                    <small>Kontak</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="kontak" id="kontak" class="form-control" value="<?php echo "$kontak"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="biaya_pendaftaran">
                    <small>Biaya Pendaftaran</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="number" min="0" name="biaya_pendaftaran" id="biaya_pendaftaran" class="form-control" value="<?php echo "$biaya_pendaftaran"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="ppn">
                    <small>
                        PPN
                        <?php
                            if(empty($ppn_pph_pendaftaran)){
                                echo "(0 %)";
                                $rp_ppn=0;
                            }else{
                                echo "($ppn_pph_pendaftaran %)";
                                if(!empty($biaya_pendaftaran)){
                                    $rp_ppn=($ppn_pph_pendaftaran/100)*$biaya_pendaftaran;
                                    $rp_ppn=round($rp_ppn);
                                }else{
                                    $rp_ppn=0;
                                }
                            }
                        ?>
                    </small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="number" min="0" name="ppn" id="ppn" class="form-control" value="<?php echo "$rp_ppn"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="biaya_layanan">
                    <small>Biaya Layanan</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="number" min="0" name="biaya_layanan" id="biaya_layanan" class="form-control" value="<?php echo "$biaya_layanan_pendaftaran"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="biaya_lain_lain">
                    <small>Biaya Lain-Lain</small>
                </label>
            </div>
            <div class="col-md-8">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-info btn-block" id="tambah_biaya_lainnya">
                            <i class="bi bi-plus"></i> Tambah
                        </button>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-12" id="list_form_biaya_lainnya">
                        <?php
                            if(!empty($biaya_lainnya_pendaftaran)){
                            $biaya_lainnya_pendaftaran_arry=json_decode($biaya_lainnya_pendaftaran, true);
                            if(!empty(count($biaya_lainnya_pendaftaran_arry))){
                                foreach ($biaya_lainnya_pendaftaran_arry as $biaya_lainnya_pendaftaran_list) {
                                    $nama_biaya=$biaya_lainnya_pendaftaran_list['nama_biaya'];
                                    $nominal_biaya=$biaya_lainnya_pendaftaran_list['nominal_biaya'];
                        ?>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="nama_biaya[]" placeholder="Nama Biaya" value="<?php echo $nama_biaya; ?>">
                                <input type="number" min="0" class="form-control nominal_biaya_class" name="nominal_biaya[]" placeholder="Rp" value="<?php echo $nominal_biaya; ?>">
                                <button type="button" class="btn btn-danger hapus_biaya_lainnya">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        <?php }}} ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="potongan_lain_lain">
                    <small>Potongan Lain-Lain</small>
                </label>
            </div>
            <div class="col-md-8">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-info btn-block" id="tambah_potongan_lainnya">
                            <i class="bi bi-plus"></i> Tambah
                        </button>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-12" id="list_form_potongan_lainnya">
                        <?php
                            if(!empty($potongan_lainnya_pendaftaran)){
                            $potongan_lainnya_pendaftaran_arry=json_decode($potongan_lainnya_pendaftaran, true);
                            if(!empty(count($potongan_lainnya_pendaftaran_arry))){
                                foreach ($potongan_lainnya_pendaftaran_arry as $potongan_lainnya_pendaftaran_list) {
                                    $nama_potongan=$potongan_lainnya_pendaftaran_list['nama_potongan'];
                                    $nominal_potongan=$potongan_lainnya_pendaftaran_list['nominal_potongan'];
                        ?>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="nama_potongan[]" placeholder="Nama Potongan" value="<?php echo $nama_potongan; ?>">
                                <input type="number" min="0" class="form-control nominal_potongan_class" name="nominal_potongan[]" placeholder="Rp" value="<?php echo $nominal_potongan; ?>">
                                <button type="button" class="btn btn-danger hapus_potongan_lainnya">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        <?php }}} ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="jumlah">
                    <small>Jumlah Total</small>
                </label>
            </div>
            <div class="col-md-8">
                <?php
                    $jumlah=$biaya_pendaftaran+$rp_ppn+$biaya_layanan_pendaftaran;
                ?>
                <input type="number" min="0" readonly name="jumlah" id="jumlah_transaksi" class="form-control" value="<?php echo "$jumlah"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"></div>
            <div class="col-md-8">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="kirim_email" id="KirimEmailPemberitahuan" checked="" value="Ya">
                        <label class="form-check-label" for="KirimEmailPemberitahuan">
                            Kirim email pemberitahuan kepada member
                        </label>
                </div>
            </div>
        </div>
        <script>
            // Tambah baris form untuk biaya_lainnya_penjualan
            $('#tambah_biaya_lainnya').click(function() {
                var newRow = `
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="nama_biaya[]" placeholder="Nama Biaya">
                        <input type="number" min="0" class="form-control nominal_biaya_class" name="nominal_biaya[]" placeholder="Rp">
                        <button type="button" class="btn btn-danger hapus_biaya_lainnya">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                `;
                $('#list_form_biaya_lainnya').append(newRow);
                hitung_jumlah_transaksi();
            });
            // Tambah baris form untuk potongan_lainnya_penjualan2
            $('#tambah_potongan_lainnya').click(function() {
                var newRow = `
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="nama_potongan[]" placeholder="Nama Potongan">
                        <input type="number" min="0" class="form-control nominal_potongan_class" name="nominal_potongan[]" placeholder="Rp">
                        <button type="button" class="btn btn-danger hapus_potongan_lainnya">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                `;
                $('#list_form_potongan_lainnya').append(newRow);
                hitung_jumlah_transaksi();
            });

            // Hapus baris form untuk hapus_biaya_lainnya
            $(document).on('click', '.hapus_biaya_lainnya', function() {
                $(this).closest('.input-group').remove();
                hitung_jumlah_transaksi();
            });
            // Hapus baris form untuk hapus_potongan_lainnya
            $(document).on('click', '.hapus_potongan_lainnya', function() {
                $(this).closest('.input-group').remove();
                hitung_jumlah_transaksi();
            });

            //Apabila ada pengetikan pada biaya_pendaftaran
            $('#biaya_pendaftaran').on('input', function() {
                hitung_jumlah_transaksi();
            });
            //Apabila ada pengetikan pada ppn
            $('#ppn').on('input', function() {
                hitung_jumlah_transaksi();
            });
            //Apabila ada pengetikan pada biaya_layanan
            $('#biaya_layanan').on('input', function() {
                hitung_jumlah_transaksi();
            });
            //Apabila ada pengetikan pada class nominal_biaya_class
            $(document).on('input', '.nominal_biaya_class', function() {
                hitung_jumlah_transaksi();
            });
            //Apabila ada pengetikan pada class nominal_potongan_class
            $(document).on('input', '.nominal_potongan_class', function() {
                hitung_jumlah_transaksi();
            });
        </script>
<?php
            }
        }
    }
?>
