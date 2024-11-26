<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'5ZT1VZZU1KxLFkDFU4m');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        //Buka Data Pengaturan Transaksi Pendaftaran
        $expired_time_pendaftaran=GetDetailData($Conn,'setting_transaksi','kategori ','Pendaftaran','expired_time');
        $ppn_pph_pendaftaran=GetDetailData($Conn,'setting_transaksi','kategori ','Pendaftaran','ppn_pph');
        $biaya_layanan_pendaftaran=GetDetailData($Conn,'setting_transaksi','kategori ','Pendaftaran','biaya_layanan');
        $potongan_lainnya_pendaftaran=GetDetailData($Conn,'setting_transaksi','kategori ','Pendaftaran','potongan_lainnya');
        $biaya_lainnya_pendaftaran=GetDetailData($Conn,'setting_transaksi','kategori ','Pendaftaran','biaya_lainnya');
        //Buka Data Pengaturan Transaksi Penjualan
        $expired_time_penjualan=GetDetailData($Conn,'setting_transaksi','kategori ','Penjualan','expired_time');
        $ppn_pph_penjualan=GetDetailData($Conn,'setting_transaksi','kategori ','Penjualan','ppn_pph');
        $biaya_layanan_penjualan=GetDetailData($Conn,'setting_transaksi','kategori ','Penjualan','biaya_layanan');
        $potongan_lainnya_penjualan=GetDetailData($Conn,'setting_transaksi','kategori ','Penjualan','potongan_lainnya');
        $biaya_lainnya_penjualan=GetDetailData($Conn,'setting_transaksi','kategori ','Penjualan','biaya_lainnya');
        $pengiriman=GetDetailData($Conn,'setting_transaksi','kategori ','Penjualan','pengiriman');
        if(!empty($pengiriman)){
            $pengiriman_arry=json_decode($pengiriman,true);
            $nama_pengirim=$pengiriman_arry['nama_pengirim'];
            $provinsi_pengirim=$pengiriman_arry['provinsi'];
            $kabupaten_pengirim=$pengiriman_arry['kabupaten'];
            $kecamatan_pengirim=$pengiriman_arry['kecamatan'];
            $desa_pengirim=$pengiriman_arry['desa'];
            $rt_rw_pengirim=$pengiriman_arry['rt_rw'];
            $kode_pos_pengirim=$pengiriman_arry['kode_pos'];
            $kontak_pengirim=$pengiriman_arry['kontak'];
        }else{
            $nama_pengirim="";
            $provinsi_pengirim="";
            $kabupaten_pengirim="";
            $kecamatan_pengirim="";
            $desa_pengirim="";
            $rt_rw_pengirim="";
            $kode_pos_pengirim="";
            $kontak_pengirim="";
        }
?>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      <code class="text-dark">';
                    echo '          Berikut ini adalah halaman pengaturan transaksi yang digunakan untuk mengatur nilai PPN/PPH, Potongan dan biaya lain yang mungkin ada pada transaksi pendaftaran ataupun penjualan barang';
                    echo '          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '      </code>';
                    echo '  </small>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <b>A. Pengaturan Transaksi Pendaftaran Event</b>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body mb-4">
                                        <div class="row">
                                            <div class="col-md-12 mb-3"></div>
                                        </div>
                                        <form action="javascript:void(0);" id="ProsesTransaksiPendaftaran" class="mt-4">
                                            <input type="hidden" name="kategori" value="Pendaftaran">
                                            <div class="row mb-3 mt-4">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="expired_time_pendaftaran">Durasi Expired (Jam)</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="number" min="0" step="1" class="form-control" name="expired_time" id="expired_time_pendaftaran" value="<?php echo "$expired_time_pendaftaran"; ?>">
                                                    <small>
                                                        <code class="text text-grayish">
                                                            Durasi waktu transaksi expired jika tidak diselesaikan oleh member.
                                                        </code>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-3 mt-4">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="ppn_pph_pendaftaran">PPN (%)</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="number" min="0.00" step="0.01" class="form-control" name="ppn_pph" id="ppn_pph_pendaftaran" value="<?php echo "$ppn_pph_pendaftaran"; ?>">
                                                    <small>
                                                        <code class="text text-grayish">
                                                            Nilai persentase yang akan muncul pada saat transaksi pembayaran biaya pendaftaran event.
                                                        </code>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="biaya_layanan_pendaftaran">Biaya Layanan (Rp)</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="number" min="0" step="1" class="form-control" name="biaya_layanan" id="biaya_layanan_pendaftaran" value="<?php echo "$biaya_layanan_pendaftaran"; ?>">
                                                    <small>
                                                        <code class="text text-grayish">
                                                            Nilai biaya layanan yang akan muncul ssecara konsisten pada saat transaksi pembayaran biaya pendaftaran event.
                                                        </code>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="potongan_lainnya_pendaftaran">Potongan Lain-lain (Rp)</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-info" id="tambah_potongan_lainnya_pendaftaran">
                                                                <i class="bi bi-plus"></i> Tambah
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-12" id="list_form_potongan_lainnya_pendaftaran">
                                                            <?php
                                                                if(!empty($potongan_lainnya_pendaftaran)){
                                                                $potongan_lainnya_pendaftaran_arrs=json_decode($potongan_lainnya_pendaftaran, true);
                                                                foreach ($potongan_lainnya_pendaftaran_arrs as $potongan_lainnya_pendaftaran_list) {
                                                                    $nama_potongan=$potongan_lainnya_pendaftaran_list['nama_potongan'];
                                                                    $nominal_potongan=$potongan_lainnya_pendaftaran_list['nominal_potongan'];
                                                            ?>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control" name="nama_potongan[]" placeholder="Nama Potongan" value="<?php echo $nama_potongan; ?>">
                                                                    <input type="number" min="0" class="form-control" name="nominal_potongan[]" placeholder="Rp" value="<?php echo $nominal_potongan; ?>">
                                                                    <button type="button" class="btn btn-danger hapus_potongan_lainnya_pendaftaran">
                                                                        <i class="bi bi-x"></i>
                                                                    </button>
                                                                </div>
                                                            <?php }} ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="biaya_lainnya_pendaftaran">Biaya Lain-lain (Rp)</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-info" id="tambah_biaya_lainnya_pendaftaran">
                                                                <i class="bi bi-plus"></i> Tambah
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-12" id="list_form_biaya_lainnya_pendaftaran">
                                                            <?php
                                                                if(!empty($biaya_lainnya_pendaftaran)){
                                                                $biaya_lainnya_pendaftaran_arrs=json_decode($biaya_lainnya_pendaftaran, true);
                                                                foreach ($biaya_lainnya_pendaftaran_arrs as $biaya_lainnya_pendaftaran_list) {
                                                                    $nama_biaya=$biaya_lainnya_pendaftaran_list['nama_biaya'];
                                                                    $nominal_biaya=$biaya_lainnya_pendaftaran_list['nominal_biaya'];
                                                            ?>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control" name="nama_biaya[]" placeholder="Nama Biaya" value="<?php echo $nama_biaya; ?>">
                                                                    <input type="number" min="0" class="form-control" name="nominal_biaya[]" placeholder="Rp" value="<?php echo $nominal_biaya; ?>">
                                                                    <button type="button" class="btn btn-danger hapus_biaya_lainnya_pendaftaran">
                                                                        <i class="bi bi-x"></i>
                                                                    </button>
                                                                </div>
                                                            <?php }} ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" id="NotifikasiTransaksiPendaftaran">
                                                    <!-- Notifikasi Transaksi Pendaftaran -->
                                                </div>
                                            </div>
                                            <div class="row mt-4 mb-3">
                                                <div class="col-md-12 text-end">
                                                    <button type="submit" class="btn btn-md btn-primary btn-rounded" id="ButtonTransaksiPendaftaran">
                                                        <i class="bi bi-save"></i> Simpan Pengaturan
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <b>B. Pengaturan Transaksi Penjualan</b>
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3"></div>
                                        </div>
                                        <form action="javascript:void(0);" id="ProsesTransaksiPenjualan" class="mt-4">
                                            <input type="hidden" name="kategori" value="Penjualan">
                                            <div class="row mb-3 mt-4">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="expired_time_penjualan">Durasi Expired (Jam)</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="number" min="0" step="1" class="form-control" name="expired_time" id="expired_time_penjualan" value="<?php echo "$expired_time_penjualan"; ?>">
                                                    <small>
                                                        <code class="text text-grayish">
                                                            Durasi waktu transaksi expired jika tidak diselesaikan oleh member.
                                                        </code>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-3 mt-4">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="ppn_pph_penjualan">PPN (%)</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="number" min="0.00" step="0.01" class="form-control" name="ppn_pph" id="ppn_pph_penjualan" value="<?php echo "$ppn_pph_penjualan"; ?>">
                                                    <small>
                                                        <code class="text text-grayish">
                                                            Nilai persentase yang akan muncul pada saat transaksi penjualan.
                                                        </code>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="biaya_layanan_penjualan">Biaya Layanan (Rp)</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="number" min="0" step="1" class="form-control" name="biaya_layanan" id="biaya_layanan_penjualan" value="<?php echo "$biaya_layanan_penjualan"; ?>">
                                                    <small>
                                                        <code class="text text-grayish">
                                                            Nilai biaya layanan yang akan muncul ssecara konsisten pada saat transaksi penjualan.
                                                        </code>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="potongan_lainnya_penjualan">Potongan Lain-lain (Rp)</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-info" id="tambah_potongan_lainnya_penjualan">
                                                                <i class="bi bi-plus"></i> Tambah
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-12" id="list_form_potongan_lainnya_penjualan">
                                                            <?php
                                                                if(!empty($potongan_lainnya_penjualan)){
                                                                $potongan_lainnya_penjualan_arry=json_decode($potongan_lainnya_penjualan, true);
                                                                foreach ($potongan_lainnya_penjualan_arry as $potongan_lainnya_penjualan_list) {
                                                                    $nama_potongan=$potongan_lainnya_penjualan_list['nama_potongan'];
                                                                    $nominal_potongan=$potongan_lainnya_penjualan_list['nominal_potongan'];
                                                            ?>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control" name="nama_potongan[]" placeholder="Nama Potongan" value="<?php echo $nama_potongan; ?>">
                                                                    <input type="number" min="0" class="form-control" name="nominal_potongan[]" placeholder="Rp" value="<?php echo $nominal_potongan; ?>">
                                                                    <button type="button" class="btn btn-danger hapus_potongan_lainnya_penjualan">
                                                                        <i class="bi bi-x"></i>
                                                                    </button>
                                                                </div>
                                                            <?php }} ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="biaya_lainnya_penjualan">Biaya Lain-lain (Rp)</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-info" id="tambah_biaya_lainnya_penjualan">
                                                                <i class="bi bi-plus"></i> Tambah
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-12" id="list_form_biaya_lainnya_penjualan">
                                                            <?php
                                                                if(!empty($biaya_lainnya_penjualan)){
                                                                $biaya_lainnya_penjualan_arry=json_decode($biaya_lainnya_penjualan, true);
                                                                foreach ($biaya_lainnya_penjualan_arry as $biaya_lainnya_penjualan_list) {
                                                                    $nama_biaya=$biaya_lainnya_penjualan_list['nama_biaya'];
                                                                    $nominal_biaya=$biaya_lainnya_penjualan_list['nominal_biaya'];
                                                            ?>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control" name="nama_biaya[]" placeholder="Nama Biaya" value="<?php echo $nama_biaya; ?>">
                                                                    <input type="number" min="0" class="form-control" name="nominal_biaya[]" placeholder="Rp" value="<?php echo $nominal_biaya; ?>">
                                                                    <button type="button" class="btn btn-danger hapus_biaya_lainnya_penjualan">
                                                                        <i class="bi bi-x"></i>
                                                                    </button>
                                                                </div>
                                                            <?php }} ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="pengiriman">Informasi Pengiriman</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">
                                                                    <i class="bi bi-person-add"></i>
                                                                </span>
                                                                <input type="text" name="asal_pengiriman_nama" id="asal_pengiriman_nama" class="form-control" placeholder="Nama Pengirim" value="<?php echo $nama_pengirim; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">
                                                                    <i class="bi bi-pin-map"></i>
                                                                </span>
                                                                <select name="asal_pengiriman_provinsi" id="asal_pengiriman_provinsi" class="form-control">
                                                                    <option value="">-Provinsi-</option>
                                                                    <?php
                                                                        $query = mysqli_query($Conn, "SELECT id_wilayah, propinsi FROM wilayah WHERE kategori='Propinsi'");
                                                                        while ($data = mysqli_fetch_array($query)) {
                                                                            $id_wilayah= $data['id_wilayah'];
                                                                            $propinsi= $data['propinsi'];
                                                                            if($provinsi_pengirim==$propinsi){
                                                                                echo '<option selected value="'.$propinsi.'">'.$propinsi.'</option>';
                                                                            }else{
                                                                                echo '<option value="'.$propinsi.'">'.$propinsi.'</option>';
                                                                            }
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">
                                                                    <i class="bi bi-pin-map"></i>
                                                                </span>
                                                                <select name="asal_pengiriman_kabupaten" id="asal_pengiriman_kabupaten" class="form-control">
                                                                    <option value="">-Kab/Kota-</option>
                                                                    <?php
                                                                        if(!empty($provinsi_pengirim)){
                                                                            $query = mysqli_query($Conn, "SELECT id_wilayah, kabupaten FROM wilayah WHERE kategori='Kabupaten' AND propinsi='$provinsi_pengirim'");
                                                                                while ($data = mysqli_fetch_array($query)) {
                                                                                    $id_wilayah= $data['id_wilayah'];
                                                                                    $kabupaten= $data['kabupaten'];
                                                                                    if($kabupaten_pengirim==$kabupaten){
                                                                                        echo '<option selected value="'.$kabupaten.'">'.$kabupaten.'</option>';
                                                                                    }else{
                                                                                        echo '<option value="'.$kabupaten.'">'.$kabupaten.'</option>';
                                                                                    }
                                                                                }
                                                                        }
                                                                        
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">
                                                                    <i class="bi bi-pin-map"></i>
                                                                </span>
                                                                <select name="asal_pengiriman_kecamatan" id="asal_pengiriman_kecamatan" class="form-control">
                                                                    <option value="">-Kecamatan-</option>
                                                                    <?php
                                                                        if(!empty($kabupaten_pengirim)){
                                                                            $query = mysqli_query($Conn, "SELECT id_wilayah, kecamatan FROM wilayah WHERE kategori='Kecamatan' AND propinsi='$provinsi_pengirim' AND kabupaten='$kabupaten_pengirim'");
                                                                            while ($data = mysqli_fetch_array($query)) {
                                                                                $id_wilayah= $data['id_wilayah'];
                                                                                $kecamatan= $data['kecamatan'];
                                                                                if($kecamatan_pengirim==$kecamatan){
                                                                                    echo '<option selected value="'.$kecamatan.'">'.$kecamatan.'</option>';
                                                                                }else{
                                                                                    echo '<option value="'.$kecamatan.'">'.$kecamatan.'</option>';
                                                                                }
                                                                            }
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">
                                                                    <i class="bi bi-pin-map"></i>
                                                                </span>
                                                                <select name="asal_pengiriman_desa" id="asal_pengiriman_desa" class="form-control">
                                                                    <option value="">-Desa/Kelurahan-</option>
                                                                    <?php
                                                                        if(!empty($kecamatan_pengirim)){
                                                                            $query = mysqli_query($Conn, "SELECT id_wilayah, desa FROM wilayah WHERE kategori='desa' AND propinsi='$provinsi_pengirim' AND kabupaten='$kabupaten_pengirim' AND kecamatan='$kecamatan_pengirim'");
                                                                            while ($data = mysqli_fetch_array($query)) {
                                                                                $id_wilayah= $data['id_wilayah'];
                                                                                $desa= $data['desa'];
                                                                                if($desa_pengirim==$desa){
                                                                                    echo '<option selected value="'.$desa.'">'.$desa.'</option>';
                                                                                }else{
                                                                                    echo '<option value="'.$desa.'">'.$desa.'</option>';
                                                                                }
                                                                            }
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">
                                                                    <i class="bi bi-map"></i>
                                                                </span>
                                                                <input type="text" name="asal_pengiriman_rt_rw" id="asal_pengiriman_rt_rw" class="form-control" placeholder="Jalan, Nomor, RT/RW" value="<?php echo $rt_rw_pengirim; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">
                                                                    <small class="credit">
                                                                        <i class="bi bi-signpost"></i>
                                                                    </small>
                                                                </span>
                                                                <input type="text" name="asal_pengiriman_kode_pos" id="asal_pengiriman_kode_pos" class="form-control" placeholder="Kode Pos" value="<?php echo $kode_pos_pengirim; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">
                                                                    <i class="bi bi-phone"></i>
                                                                </span>
                                                                <input type="text" name="asal_pengiriman_kontak" id="asal_pengiriman_kontak" class="form-control" placeholder="Nomor Kontak (62)" value="<?php echo $kontak_pengirim; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" id="NotifikasiTransaksiPenjualan">
                                                    <!-- Notifikasi Transaksi Penjualan -->
                                                </div>
                                            </div>
                                            <div class="row mt-4 mb-3">
                                                <div class="col-md-12 text-end">
                                                    <button type="submit" class="btn btn-md btn-primary btn-rounded" id="ButtonTransaksiPenjualan">
                                                        <i class="bi bi-save"></i> Simpan Pengaturan
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>