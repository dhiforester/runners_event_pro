$(document).ready(function() {
    // Tambah baris form untuk potongan_lainnya_pendaftaran
    $('#tambah_potongan_lainnya_pendaftaran').click(function() {
        var newRow = `
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="nama_potongan[]" placeholder="Nama Potongan">
                <input type="number" min="0" class="form-control" name="nominal_potongan[]" placeholder="Rp">
                <button type="button" class="btn btn-danger hapus_potongan_lainnya_pendaftaran">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        `;
        $('#list_form_potongan_lainnya_pendaftaran').append(newRow);
    });

    // Hapus baris form untuk potongan_lainnya_pendaftaran
    $(document).on('click', '.hapus_potongan_lainnya_pendaftaran', function() {
        $(this).closest('.input-group').remove();
    });

    // Tambah baris form untuk biaya_lainnya_pendaftaran
    $('#tambah_biaya_lainnya_pendaftaran').click(function() {
        var newRow = `
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="nama_biaya[]" placeholder="Nama Biaya">
                <input type="number" min="0" class="form-control" name="nominal_biaya[]" placeholder="Rp">
                <button type="button" class="btn btn-danger hapus_biaya_lainnya_pendaftaran">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        `;
        $('#list_form_biaya_lainnya_pendaftaran').append(newRow);
    });

    // Hapus baris form untuk biaya_lainnya_pendaftaran
    $(document).on('click', '.hapus_biaya_lainnya_pendaftaran', function() {
        $(this).closest('.input-group').remove();
    });

    
    // -----------------------------------------------------------------------------------------------
    // Tambah baris form untuk potongan_lainnya_penjualan
    $('#tambah_potongan_lainnya_penjualan').click(function() {
        var newRow = `
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="nama_potongan[]" placeholder="Nama Potongan">
                <input type="number" min="0" class="form-control" name="nominal_potongan[]" placeholder="Rp">
                <button type="button" class="btn btn-danger hapus_potongan_lainnya_penjualan">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        `;
        $('#list_form_potongan_lainnya_penjualan').append(newRow);
    });

    // Hapus baris form untuk potongan_lainnya_penjualan
    $(document).on('click', '.hapus_potongan_lainnya_penjualan', function() {
        $(this).closest('.input-group').remove();
    });

    // Tambah baris form untuk biaya_lainnya_penjualan
    $('#tambah_biaya_lainnya_penjualan').click(function() {
        var newRow = `
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="nama_biaya[]" placeholder="Nama Biaya">
                <input type="number" min="0" class="form-control" name="nominal_biaya[]" placeholder="Rp">
                <button type="button" class="btn btn-danger hapus_biaya_lainnya_penjualan">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        `;
        $('#list_form_biaya_lainnya_penjualan').append(newRow);
    });

    // Hapus baris form untuk biaya_lainnya_penjualan
    $(document).on('click', '.hapus_biaya_lainnya_penjualan', function() {
        $(this).closest('.input-group').remove();
    });
    //Apabila provinsi diubah maka tampilkan kabupaten (asal pengiriman)
    $(document).on('input', '#asal_pengiriman_provinsi', function() {
        var asal_pengiriman_provinsi = $('#asal_pengiriman_provinsi').val();
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/ListWilayahKabupaten.php',
            data        : { propinsi: asal_pengiriman_provinsi },
            success     : function(data) {
                $('#asal_pengiriman_kabupaten').html(data);
            }
        });
        $('#asal_pengiriman_kecamatan').html('<option>-Kecamatan-</option>');
        $('#asal_pengiriman_desa').html('<option>-Desa/Kelurahan-</option>');
    });
    //Apabila kabupaten diubah maka tampilkan kabupaten (asal pengiriman)
    $(document).on('input', '#asal_pengiriman_kabupaten', function() {
        var asal_pengiriman_provinsi = $('#asal_pengiriman_provinsi').val();
        var asal_pengiriman_kabupaten = $('#asal_pengiriman_kabupaten').val();
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/ListWilayahKecamatan.php',
            data        : { propinsi: asal_pengiriman_provinsi, kabupaten: asal_pengiriman_kabupaten },
            success     : function(data) {
                $('#asal_pengiriman_kecamatan').html(data);
            }
        });
        $('#asal_pengiriman_desa').html('<option>-Desa/Kelurahan-</option>');
    });
    //Apabila kecamatan diubah maka tampilkan kabupaten (asal pengiriman)
    $(document).on('input', '#asal_pengiriman_kecamatan', function() {
        var asal_pengiriman_provinsi = $('#asal_pengiriman_provinsi').val();
        var asal_pengiriman_kabupaten = $('#asal_pengiriman_kabupaten').val();
        var asal_pengiriman_kecamatan = $('#asal_pengiriman_kecamatan').val();
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/ListWilayahDesa.php',
            data        : { propinsi: asal_pengiriman_provinsi, kabupaten: asal_pengiriman_kabupaten, kecamatan: asal_pengiriman_kecamatan },
            success     : function(data) {
                $('#asal_pengiriman_desa').html(data);
            }
        });
    });
    // -----------------------------------------------------------------------------------------------

    //Proses Simpan Pengaturan Pendaftaran
    $('#ProsesTransaksiPendaftaran').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonTransaksiPendaftaran').html('Loading...').prop('disabled', true);
        $.ajax({
            url             : '_Page/SettingTransaksi/ProsesSettingTransaksi.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            success: function (response) {
                $('#ButtonTransaksiPendaftaran').html('<i class="bi bi-save"></i> Simpan Pengaturan').prop('disabled', false);
                var result;
                try {
                    // Mencoba untuk parse JSON
                    result = JSON.parse(response); 
                } catch (e) {
                    $('#NotifikasiTransaksiPendaftaran').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    // Keluar dari fungsi jika JSON tidak valid
                    return; 
                }
                if (result.success) {
                    $('#NotifikasiTransaksiPendaftaran').html('');
                    Swal.fire('Berhasil!', 'Pengaturan Transaksi Berhasil Disimpan', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiTransaksiPendaftaran').html('<div class="alert alert-danger">' + result.message + '</div>');
                }
            },
            error: function () {
                $('#ButtonTransaksiPendaftaran').html('<i class="bi bi-save"></i> Simpan Pengaturan').prop('disabled', false);
                $('#NotifikasiTransaksiPendaftaran').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Proses Simpan Pengaturan Penjualan
    $('#ProsesTransaksiPenjualan').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonTransaksiPenjualan').html('Loading...').prop('disabled', true);
        $.ajax({
            url             : '_Page/SettingTransaksi/ProsesSettingTransaksi.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            success: function (response) {
                $('#ButtonTransaksiPenjualan').html('<i class="bi bi-save"></i> Simpan Pengaturan').prop('disabled', false);
                var result;
                try {
                    // Mencoba untuk parse JSON
                    result = JSON.parse(response); 
                } catch (e) {
                    $('#NotifikasiTransaksiPenjualan').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    // Keluar dari fungsi jika JSON tidak valid
                    return; 
                }
                if (result.success) {
                    $('#NotifikasiTransaksiPenjualan').html('');
                    Swal.fire('Berhasil!', 'Pengaturan Transaksi Berhasil Disimpan', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiTransaksiPenjualan').html('<div class="alert alert-danger">' + result.message + '</div>');
                }
            },
            error: function () {
                $('#ButtonTransaksiPenjualan').html('<i class="bi bi-save"></i> Simpan Pengaturan').prop('disabled', false);
                $('#NotifikasiTransaksiPenjualan').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
});
