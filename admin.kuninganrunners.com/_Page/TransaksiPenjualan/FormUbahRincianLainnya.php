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
        if(empty($_POST['kode_transaksi'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  Kode transaksi tidak boleh kosong!';
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
            $kode_transaksi_validasi=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kode_transaksi');
            if(empty($kode_transaksi_validasi)){
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
                $id_member=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'id_member');
                $raw_member=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'raw_member');
                $kategori=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kategori');
                $datetime=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'datetime');
                $tagihan=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'tagihan');
                $jumlah=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'jumlah');
                $ongkir=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'ongkir');
                $ppn_pph=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'ppn_pph');
                $biaya_layanan=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'biaya_layanan');
                $biaya_lainnya=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'biaya_lainnya');
                $potongan_lainnya=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'potongan_lainnya');
                $status=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'status');
                //Menghitung persentase ppn
                if(!empty($ppn_pph)){
                    if(!empty($tagihan)){
                        $ppn_pph_persen=($ppn_pph/$tagihan)*100;
                        $ppn_pph_rupiah='' . number_format($ppn_pph, 0, ',', '.');
                    }else{
                        $ppn_pph_persen=0;
                        $ppn_pph_rupiah=0;
                    }
                }else{
                    $ppn_pph_persen=0;
                    $ppn_pph_rupiah=0;
                }
?>
                <input type="hidden" name="kode_transaksi" value="<?php echo $kode_transaksi; ?>">
                <input type="hidden" id="GetTagihan" value="<?php echo $tagihan; ?>">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="ongkir_edit">
                            <small class="credit">Ongkir (Rp)</small>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <input type="number" name="ongkir" id="ongkir_edit" class="form-control" value="<?php echo $ongkir; ?>">
                        <small class="credit">
                            <code class="text text-grayish">Ongkos kirim terhubung dengan data pengiriman barang</code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="ppn_pph_persen">
                            <small class="credit">Pajak PPN (%)</small>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <input type="number" name="ppn_pph_persen" id="ppn_pph_persen" class="form-control" value="<?php echo $ppn_pph_persen; ?>">
                        <small class="credit">
                            <code class="text text-grayish" id="ppn_pph_rupiah"><?php echo "Rp $ppn_pph_rupiah"; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="biaya_layanan">
                            <small class="credit">Biaya Layanan (Rp)</small>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <input type="number" name="biaya_layanan" id="biaya_layanan" class="form-control" value="<?php echo $biaya_layanan; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="biaya_lainnya">
                            <small class="credit">Biaya Lain-lain (Rp)</small>
                        </label>
                    </div>
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-info btn-block" id="tambah_biaya_lainnya_penjualan2">
                            <i class="bi bi-plus"></i> Tambah
                        </button>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-12" id="list_form_biaya_lainnya_penjualan2">
                        <?php
                            if(!empty($biaya_lainnya)){
                            $biaya_lainnya_penjualan_arry=json_decode($biaya_lainnya, true);
                            if(!empty(count($biaya_lainnya_penjualan_arry))){
                                foreach ($biaya_lainnya_penjualan_arry as $biaya_lainnya_penjualan_list) {
                                    $nama_biaya=$biaya_lainnya_penjualan_list['nama_biaya'];
                                    $nominal_biaya=$biaya_lainnya_penjualan_list['nominal_biaya'];
                        ?>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="nama_biaya[]" placeholder="Nama Biaya" value="<?php echo $nama_biaya; ?>">
                                <input type="number" min="0" class="form-control" name="nominal_biaya[]" placeholder="Rp" value="<?php echo $nominal_biaya; ?>">
                                <button type="button" class="btn btn-danger hapus_biaya_lainnya_penjualan2">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        <?php }}} ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="potongan_lainnya">
                            <small class="credit">Potongan Lain-lain (Rp)</small>
                        </label>
                    </div>
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-info btn-block" id="tambah_potongan_lainnya_penjualan2">
                            <i class="bi bi-plus"></i> Tambah
                        </button>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-12" id="list_form_potongan_lainnya_penjualan2">
                        <?php
                            if(!empty($potongan_lainnya)){
                            $potongan_lainnya_penjualan_arry=json_decode($potongan_lainnya, true);
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
<?php
            }
        }
    }
?>
<script>

    // Tambah baris form untuk biaya_lainnya_penjualan
    $('#tambah_biaya_lainnya_penjualan2').click(function() {
        var newRow = `
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="nama_biaya[]" placeholder="Nama Biaya">
                <input type="number" min="0" class="form-control" name="nominal_biaya[]" placeholder="Rp">
                <button type="button" class="btn btn-danger hapus_biaya_lainnya_penjualan2">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        `;
        $('#list_form_biaya_lainnya_penjualan2').append(newRow);
    });
    // Tambah baris form untuk potongan_lainnya_penjualan2
    $('#tambah_potongan_lainnya_penjualan2').click(function() {
        var newRow = `
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="nama_potongan[]" placeholder="Nama Potongan">
                <input type="number" min="0" class="form-control" name="nominal_potongan[]" placeholder="Rp">
                <button type="button" class="btn btn-danger hapus_potongan_lainnya_penjualan2">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        `;
        $('#list_form_potongan_lainnya_penjualan2').append(newRow);
    });

    // Hapus baris form untuk hapus_biaya_lainnya_penjualan2
    $(document).on('click', '.hapus_biaya_lainnya_penjualan2', function() {
        $(this).closest('.input-group').remove();
    });
    // Hapus baris form untuk hapus_potongan_lainnya_penjualan2
    $(document).on('click', '.hapus_potongan_lainnya_penjualan2', function() {
        $(this).closest('.input-group').remove();
    });

    // Ketika input pada ppn_pph_persen berubah
    $('#ppn_pph_persen').on('input', function () {
        // Ambil nilai persentase PPN
        let persenPPN = parseFloat($(this).val()) || 0; // Jika kosong, default 0
        
        // Ambil nilai total tagihan
        let totalTagihan = parseFloat($('#GetTagihan').val()) || 0; // Jika kosong, default 0

        // Hitung jumlah nominal PPN
        let nominalPPN = (persenPPN / 100) * totalTagihan;

        // Format nominal PPN ke dalam Rupiah (opsional)
        let nominalPPNRupiah = nominalPPN.toLocaleString('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        });

        // Tampilkan hasil pada elemen dengan id="ppn_pph_rupiah"
        $('#ppn_pph_rupiah').text(nominalPPNRupiah);
    });
</script>
