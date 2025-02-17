<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'cQUcLK1QksH9t5rbClc');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        //Buka Data Transaksi
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
                    echo '          Berikut ini adalah halaman untuk menambahkan data transaksi penjualan secara manual.';
                    echo '          Pada halaman ini diasumsikan member melakukan pemesanan secara langsung atau melalui platform lain.';
                    echo '          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '      </code>';
                    echo '  </small>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form action="javascript:void(0);" id="ProsesTambahTransaksi">
                    <input type="hidden" name="put_id_member" id="put_id_member" value="">
                    <div class="card">
                        <div class="card-header">
                            <div class="row mb-3">
                                <div class="col-md-8 mb-3">
                                    <span class="card-title">Form Tambah Transaksi</span>
                                </div>
                                <div class="col col-md-2 mb-3">
                                    <a href="index.php?Page=TransaksiPenjualan" class="btn btn-md btn-dark btn-rounded btn-block">
                                        <i class="bi bi-chevron-left"></i> Kembali
                                    </a>
                                </div>
                                <div class="col col-md-2 mb-3">
                                    <button type="button" class="btn btn-md btn-outline-dark btn-rounded btn-block" data-bs-toggle="modal" data-bs-target="#ModalMember">
                                        <i class="bi bi-search"></i> Pilih Member
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3 border-1 border-bottom">
                                <div class="col-md-12 mb-3">
                                    <b>A. Keranjang Transaksi</b>
                                </div>
                                <div class="col-md-12 mb-3" id="ListKeranjang"></div>
                            </div>
                            <div class="row mb-3 border-1 border-bottom">
                                <div class="col-md-12 mb-3">
                                    <b>B. Identitias Member</b>
                                </div>
                                <div class="col-md-12" id="MenampilkanMember"></div>
                            </div>
                            <div class="row mb-3 border-1 border-bottom">
                                <div class="col-md-12 mb-3">
                                    <b>C. Informasi Pengiriman</b>
                                </div>
                                <div class="col-md-12">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="metode_pengiriman">
                                                <small>Metode Pengiriman</small>
                                            </label>
                                        </div>
                                        <div class="col-md-8">
                                            <select name="metode_pengiriman" id="metode_pengiriman" class="form-control">
                                                <option value="Dikirim">Dikirim</option>
                                                <option value="Diambil">Diambil</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="form_uraian_pengiriman">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="no_resi">
                                                    <small>No.Resi</small>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="no_resi"  id="no_resi">
                                                <small>
                                                    <code class="text-dark">
                                                        <i class="bi bi-info-circle"></i> Isi Form berikut ini apabila transaksi penjualan sudah dikirim
                                                    </code>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="tanggal_pengiriman">
                                                    <small>Tanggal/Jam Pengiriman</small>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span class="input-group-text text-grayish">
                                                        <i class="bi bi-calendar-date"></i>
                                                    </span>
                                                    <input type="date" class="form-control" name="tanggal_pengiriman"  id="tanggal_pengiriman">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span class="input-group-text text-grayish">
                                                        <i class="bi bi-clock"></i>
                                                    </span>
                                                    <input type="time" class="form-control" name="jam_pengiriman"  id="jam_pengiriman">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="link_pengiriman">
                                                    <small>Link Pelacakan</small>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="link_pengiriman"  id="link_pengiriman" placeholder="https://">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="tujuan_pengiriman_nama">
                                                    <small>Nama Penerima</small>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="tujuan_pengiriman_nama" id="tujuan_pengiriman_nama" class="form-control" placeholder="Nama Penerima">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="tujuan_pengiriman_kontak">
                                                    <small>Kontak/HP</small>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="tujuan_pengiriman_kontak" id="tujuan_pengiriman_kontak" class="form-control" placeholder="Nomor Kontak (62)">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="alamat_pengiriman">
                                                    <small>Alamat Pengiriman</small>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-text text-primary" onclick="handleClick()" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#ModalCariAlamat">
                                                        <i class="bi bi-search"></i>
                                                    </span>
                                                    <input type="text" class="form-control" name="alamat_pengiriman"  id="alamat_pengiriman">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="tujuan_pengiriman_rt_rw">
                                                    <small>Alamat Selengkapnya</small>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="tujuan_pengiriman_rt_rw" id="tujuan_pengiriman_rt_rw" class="form-control" placeholder="Jalan, Nomor, RT/RW">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="kurir">
                                                    <small>Nama Kurir</small>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <select name="kurir" id="kurir" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <option value="jne">JNE</option>
                                                    <option value="sicepat">Sicepat</option>
                                                    <option value="jnt">JNT</option>
                                                    <option value="ninja">Ninja</option>
                                                    <option value="tiki">Tiki</option>
                                                    <option value="lion">Lion</option>
                                                    <option value="wahana">Wahana</option>
                                                    <option value="pos">POS</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="berat">
                                                    <small>Berat (Kg)</small>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" min="0.00" step="0.01" name="berat" id="berat" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="ongkir">
                                                    <small>Ongkir (Rp)</small>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-text text-primary" onclick="handleClick()" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#ModalCariOngkir">
                                                        <i class="bi bi-calculator"></i>
                                                    </span>
                                                    <input type="number" min="0" class="form-control" name="ongkir"  id="ongkir" placeholder="Rp">
                                                    <input type="text" class="form-control" name="paket"  id="paket" placeholder="Paket Pengiriman">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="status_pengiriman">
                                                    <small>Status Pengiriman</small>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <select name="status_pengiriman" id="status_pengiriman" class="form-control">
                                                    <option value="Pending">Pending (Dalam proses pengemasan)</option>
                                                    <option value="Batal">Batal/Dikembalikan</option>
                                                    <option value="Proses">Proses/Sedang Dikirim</option>
                                                    <option value="Selesai">Sampai Tujuan (Selesai)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 border-1 border-bottom">
                                <div class="col-md-12 mb-3">
                                    <b>D. Rincian Pembayaran</b>
                                </div>
                                <div class="col-md-12">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="link_pembayaran">
                                                <small>Link Pembayaran</small>
                                            </label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="link_pembayaran" name="link_pembayaran" value="Ya">
                                                <label class="form-check-label" for="link_pembayaran">
                                                    <small class="credit">
                                                        <code class="text text-grayish">Buat Link Pembayaran</code>
                                                    </small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="ppn_pph">
                                                <small>Pajak PPN (%)</small>
                                            </label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="number" min="0.00" step="0.01" class="form-control" name="ppn_pph"  id="ppn_pph" value="<?php echo $ppn_pph_penjualan; ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="biaya_layanan">
                                                <small>Biaya Layanan (Rp)</small>
                                            </label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="number" min="0" step="1" class="form-control" name="biaya_layanan"  id="biaya_layanan" value="<?php echo $biaya_layanan_penjualan; ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="biaya_lainnya">
                                                <small>Biaya Lain-lain (Rp)</small>
                                            </label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-outline-info" id="tambah_biaya_lainnya_penjualan">
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
                                            <label for="potongan_lainnya">
                                                <small>Potongan Penjualan (Rp)</small>
                                            </label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-outline-info" id="tambah_potongan_lainnya_penjualan">
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
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12 mb-3">
                                    <b>E. Ringkasan Transaksi</b>
                                </div>
                                <div class="col-md-12 mb-3" id="RingkasanTransaksi"></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12 mb-3" id="NotifikasiTambahTransaksi">
                                    <!-- Notifikasi Tambah Transaksi Akan Muncul Disini -->
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-md btn-primary" id="ButtonTambahTransaksi">
                                <i class="bi bi-save"></i> Simpan Transaksi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
<?php
    }
?>