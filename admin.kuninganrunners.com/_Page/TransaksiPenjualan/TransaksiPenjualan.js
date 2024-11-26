//Fungsi Menampilkan Data Testimoni
function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/TransaksiPenjualan/TabelTransaksiPenjualan.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanTabel').html(data);
        }
    });
}
function ShowListMember() {
    var ProsesCariMember =$('#ProsesCariMember').serialize();
    $('#FormListMember').html("Loading...");
    $.ajax({
        type        : 'POST',
        url         : '_Page/TransaksiPenjualan/FormListMember.php',
        data        : ProsesCariMember,
        success     : function(data) {
            $('#FormListMember').html(data);
        }
    });
}
function ListKeranjang() {
    var id_member =$('#put_id_member').val();
    $('#ListKeranjang').html("Loading...");
    $.ajax({
        type        : 'POST',
        url         : '_Page/TransaksiPenjualan/ListKeranjang.php',
        data        : {id_member: id_member},
        success     : function(data) {
            $('#ListKeranjang').html(data);
        }
    });
}
function MenampilkanMember() {
    var id_member=$('#put_id_member').val();
    $('#MenampilkanMember').html("Loading...");
    $.ajax({
        type        : 'POST',
        url         : '_Page/TransaksiPenjualan/MenampilkanMember.php',
        data        : {id_member: id_member},
        success     : function(data) {
            $('#MenampilkanMember').html(data);
        }
    });
}
function MenampilkanFormTujuanPengiriman() {
    var id_member=$('#put_id_member').val();
    $('#FormTujuanPengiriman').html("Loading...");
    $.ajax({
        type        : 'POST',
        url         : '_Page/TransaksiPenjualan/FormTujuanPengiriman.php',
        data        : {id_member: id_member},
        success     : function(data) {
            $('#FormTujuanPengiriman').html(data);
        }
    });
}
function ListBarang() {
    var ProsesCariBarang =$('#ProsesCariBarang').serialize();
    $('#FormListBarang').html("Loading...");
    $.ajax({
        type        : 'POST',
        url         : '_Page/TransaksiPenjualan/ListBarang.php',
        data        : ProsesCariBarang,
        success     : function(data) {
            $('#FormListBarang').html(data);
        }
    });
}
function ListBarang2() {
    var ProsesCariBarang2 =$('#ProsesCariBarang2').serialize();
    $('#FormListBarang2').html("Loading...");
    $.ajax({
        type        : 'POST',
        url         : '_Page/TransaksiPenjualan/ListBarang2.php',
        data        : ProsesCariBarang2,
        success     : function(data) {
            $('#FormListBarang2').html(data);
        }
    });
}
function RingkasanTransaksi() {
    var ProsesTambahTransaksi =$('#ProsesTambahTransaksi').serialize();
    $.ajax({
        type        : 'POST',
        url         : '_Page/TransaksiPenjualan/RingkasanTransaksi.php',
        data        : ProsesTambahTransaksi,
        success     : function(data) {
            $('#RingkasanTransaksi').html(data);
        }
    });
}
function ShowInformasiTransaksi(kode_transaksi) {
    $.ajax({
        type        : 'POST',
        url         : '_Page/TransaksiPenjualan/ShowInformasiTransaksi.php',
        data        : { kode_transaksi: kode_transaksi },
        success     : function(data) {
            $('#ShowInformasiTransaksi').html(data);
        }
    });
}
function ShowInformasiMember(kode_transaksi) {
    $.ajax({
        type        : 'POST',
        url         : '_Page/TransaksiPenjualan/ShowInformasiMember.php',
        data        : { kode_transaksi: kode_transaksi },
        success     : function(data) {
            $('#ShowInformasiMember').html(data);
        }
    });
}
function ShowPembayaran(kode_transaksi) {
    $.ajax({
        type        : 'POST',
        url         : '_Page/TransaksiPenjualan/ShowPembayaran.php',
        data        : { kode_transaksi: kode_transaksi },
        success     : function(data) {
            $('#ShowPembayaran').html(data);
        }
    });
}
function ShowPengiriman(kode_transaksi) {
    $.ajax({
        type        : 'POST',
        url         : '_Page/TransaksiPenjualan/ShowPengiriman.php',
        data        : { kode_transaksi: kode_transaksi },
        success     : function(data) {
            $('#ShowPengiriman').html(data);
        }
    });
}
//Menampilkan Data Pertama Kali
$(document).ready(function() {
    //Menampilkan Data Pertama kali
    filterAndLoadTable();
    ListKeranjang();
    MenampilkanMember();
    RingkasanTransaksi();
    MenampilkanFormTujuanPengiriman();
    //Ketika keyword_by Diubah
    $('#keyword_by').change(function(){
        var keyword_by =$('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/TransaksiPenjualan/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    //Filter Data
    $('#ProsesFilter').submit(function(){
        $('#page').val("1");
        filterAndLoadTable();
        $('#ModalFilter').modal('hide');
    });

    // ---------- List Member ---------------
    //Ketika Modal Member Muncul
    $('#ModalMember').on('show.bs.modal', function (e) {
        ShowListMember();
    });
    //Cari Data Member
    $('#ProsesCariMember').submit(function(){
        ShowListMember();
    });

    // ---------- List Barang ---------------
    //Ketika Modal Barang Muncul
    $('#ModalBarang').on('show.bs.modal', function (e) {
        ListBarang();
    });
    $('#ModalBarang2').on('show.bs.modal', function (e) {
        ListBarang2();
    });
    //Cari Data Barang
    $('#ProsesCariBarang').submit(function(){
        ListBarang();
    });
    //Cari Data Barang2
    $('#ProsesCariBarang2').submit(function(){
        ListBarang2();
    });
    //Ketika Modal Pilih Barang Muncul
    $('#ModalPilihBarang').on('show.bs.modal', function (e) {
        var id_barang = $(e.relatedTarget).data('id');
        var id_member = $('#put_id_member').val();
        $('#FormPilihBarang').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/FormPilihBarang.php',
            data        : { id_barang: id_barang, id_member: id_member },
            success     : function(data) {
                $('#FormPilihBarang').html(data);
            }
        });
    });
    //Ketika Modal Pilih Barang Muncul2
    $('#ModalPilihBarang2').on('show.bs.modal', function (e) {
        var id_barang = $(e.relatedTarget).data('id');
        var GetKodeTransaksi = $('#GetKodeTransaksi').val();
        $('#FormPilihBarang2').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/FormPilihBarang2.php',
            data        : { id_barang: id_barang, kode_transaksi: GetKodeTransaksi },
            success     : function(data) {
                $('#FormPilihBarang2').html(data);
            }
        });
    });
    //Proses Tambah Rincian Barang Ke Keranjang
    $('#ProsesTambahItemBarangKeKeranjang').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtinTambahItemBarangKeKeranjang').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/TransaksiPenjualan/ProsesTambahKeranjang.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtinTambahItemBarangKeKeranjang').html('<i class="bi bi-plus"></i> Tambahkan').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiTambahItemBarangKeKeranjang').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    $('#ButtinTambahItemBarangKeKeranjang').html('<i class="bi bi-plus"></i> Tambahkan').prop('disabled', false);
                    $('#ProsesTambahItemBarangKeKeranjang').trigger('reset');
                    $('#ModalPilihBarang').modal('hide');
                    $('#NotifikasiTambahItemBarangKeKeranjang').html('');
                    ListKeranjang();
                    RingkasanTransaksi();
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiTambahItemBarangKeKeranjang').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtinTambahItemBarangKeKeranjang').html('<i class="bi bi-plus"></i> Tambahkan').prop('disabled', false);
                $('#NotifikasiTambahItemBarangKeKeranjang').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Proses Tambah Rincian Transaksi
    $('#ProsesTambahRincianTransaksi').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonTambahRincianTransaksi').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/TransaksiPenjualan/ProsesTambahRincianTransaksi.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonTambahRincianTransaksi').html('<i class="bi bi-plus"></i> Tambahkan').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiTambahRincianTransaksi').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    $('#ButtonTambahRincianTransaksi').html('<i class="bi bi-plus"></i> Tambahkan').prop('disabled', false);
                    $('#ProsesTambahRincianTransaksi').trigger('reset');
                    $('#ModalPilihBarang2').modal('hide');
                    $('#NotifikasiTambahRincianTransaksi').html('');
                    var GetKodeTransaksi=$('#GetKodeTransaksi').val();
                    ShowInformasiTransaksi(GetKodeTransaksi);
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiTambahRincianTransaksi').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonTambahRincianTransaksi').html('<i class="bi bi-plus"></i> Tambahkan').prop('disabled', false);
                $('#NotifikasiTambahRincianTransaksi').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Ketika Modal Edit Keranjang Muncul
    $('#ModalEditKeranjang').on('show.bs.modal', function (e) {
        var id_transaksi_keranjang = $(e.relatedTarget).data('id');
        $('#FormEditKeranjang').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/FormEditKeranjang.php',
            data        : { id_transaksi_keranjang: id_transaksi_keranjang },
            success     : function(data) {
                $('#FormEditKeranjang').html(data);
                $('#NotifikasiEditKeranjang').html('');
            }
        });
    });
    //Proses Edit Keranjang
    $('#ProsesEditKeranjang').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonEditKeranjang').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/TransaksiPenjualan/ProsesEditKeranjang.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonEditKeranjang').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiEditKeranjang').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    $('#ButtonEditKeranjang').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#ProsesEditKeranjang').trigger('reset');
                    $('#ModalEditKeranjang').modal('hide');
                    $('#NotifikasiEditKeranjang').html('');
                    ListKeranjang();
                    RingkasanTransaksi();
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiEditKeranjang').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonEditKeranjang').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiEditKeranjang').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });

    // ---------------Form Pengiriman ------------
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
    
    
    //Apabila provinsi diubah maka tampilkan kabupaten (tujuan pengiriman)
    $(document).on('input', '#tujuan_pengiriman_provinsi', function() {
        var tujuan_pengiriman_provinsi = $('#tujuan_pengiriman_provinsi').val();
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/ListWilayahKabupaten.php',
            data        : { propinsi: tujuan_pengiriman_provinsi },
            success     : function(data) {
                $('#tujuan_pengiriman_kabupaten').html(data);
            }
        });
        $('#tujuan_pengiriman_kecamatan').html('<option>-Kecamatan-</option>');
        $('#tujuan_pengiriman_desa').html('<option>-Desa/Kelurahan-</option>');
    });
    //Apabila kabupaten diubah maka tampilkan kabupaten (tujuan pengiriman)
    $(document).on('input', '#tujuan_pengiriman_kabupaten', function() {
        var tujuan_pengiriman_provinsi = $('#tujuan_pengiriman_provinsi').val();
        var tujuan_pengiriman_kabupaten = $('#tujuan_pengiriman_kabupaten').val();
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/ListWilayahKecamatan.php',
            data        : { propinsi: tujuan_pengiriman_provinsi, kabupaten: tujuan_pengiriman_kabupaten },
            success     : function(data) {
                $('#tujuan_pengiriman_kecamatan').html(data);
            }
        });
        $('#tujuan_pengiriman_desa').html('<option>-Desa/Kelurahan-</option>');
    });
    //Apabila kecamatan diubah maka tampilkan kabupaten (tujuan pengiriman)
    $(document).on('input', '#tujuan_pengiriman_kecamatan', function() {
        var tujuan_pengiriman_provinsi = $('#tujuan_pengiriman_provinsi').val();
        var tujuan_pengiriman_kabupaten = $('#tujuan_pengiriman_kabupaten').val();
        var tujuan_pengiriman_kecamatan = $('#tujuan_pengiriman_kecamatan').val();
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/ListWilayahDesa.php',
            data        : { propinsi: tujuan_pengiriman_provinsi, kabupaten: tujuan_pengiriman_kabupaten, kecamatan: tujuan_pengiriman_kecamatan },
            success     : function(data) {
                $('#tujuan_pengiriman_desa').html(data);
            }
        });
    });
    //Apabila Ongkir Diketik
    $(document).on('input', '#ongkir', function() {
        RingkasanTransaksi();
    });

    // --------- Form Rincian Pembayaran -----------------
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
        RingkasanTransaksi();
    });

    //Nominal Potongan Diketik
    $(document).on('input', 'input[name="nominal_potongan[]"]', function() {
        RingkasanTransaksi();
    });

    // Hapus baris form untuk potongan_lainnya_penjualan
    $(document).on('click', '.hapus_potongan_lainnya_penjualan', function() {
        $(this).closest('.input-group').remove();
        RingkasanTransaksi();
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
        RingkasanTransaksi();
    });

    //Nominal Biaya Diketik
    $(document).on('input', 'input[name="nominal_biaya[]"]', function() {
        RingkasanTransaksi();
    });

    // Hapus baris form untuk biaya_lainnya_penjualan
    $(document).on('click', '.hapus_biaya_lainnya_penjualan', function() {
        $(this).closest('.input-group').remove();
        RingkasanTransaksi();
    });

    
    $(document).on('input', '#ppn_pph', function() {
        RingkasanTransaksi();
    });
    $(document).on('input', '#biaya_layanan', function() {
        RingkasanTransaksi();
    });

    // ------------ Proses Tambah Transaksi -------------
    $('#ProsesTambahTransaksi').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonTambahTransaksi').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/TransaksiPenjualan/ProsesTambahTransaksi.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonTambahTransaksi').html('<i class="bi bi-save"></i> Simpan Transaksi').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiTambahTransaksi').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    var kode_transaksi=result.kode_transaksi;
                    window.location.href = 'index.php?Page=TransaksiPenjualan&Sub=Detail&id=' + kode_transaksi;
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiTambahTransaksi').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonTambahTransaksi').html('<i class="bi bi-save"></i> Simpan Transaksi').prop('disabled', false);
                $('#NotifikasiTambahTransaksi').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });

    // -------------- DETAIL TRANSAKSI ----------------
    var GetKodeTransaksi=$('#GetKodeTransaksi').val();
    if(GetKodeTransaksi!==""){
        ShowInformasiTransaksi(GetKodeTransaksi);
        ShowInformasiMember(GetKodeTransaksi);
        ShowPembayaran(GetKodeTransaksi);
        ShowPengiriman(GetKodeTransaksi);
    }

    //Ketika Modal Detail Muncul
    $('#ModalDetail').on('show.bs.modal', function (e) {
        var kode_transaksi = $(e.relatedTarget).data('id');
        $('#FormDetail').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/FormDetail.php',
            data        : { kode_transaksi: kode_transaksi },
            success     : function(data) {
                $('#FormDetail').html(data);
            }
        });
    });

    //Ketika Modal Ubah Tanggal Transaksi Muncul
    $('#ModalUbahTanggalTransaksi').on('show.bs.modal', function (e) {
        var kode_transaksi = $(e.relatedTarget).data('id');
        $('#FormUbahTanggalTransaksi').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/FormUbahTanggalTransaksi.php',
            data        : { kode_transaksi: kode_transaksi },
            success     : function(data) {
                $('#FormUbahTanggalTransaksi').html(data);
                $('#NotifikasiUbahTanggalTransaksi').html('');
                $('#ButtonUbahTanggalTransaksi').html('<i class="bi bi-save"></i> Simpan');
            }
        });
    });
    //Proses Ubah Tanggal Transaksi
    $('#ProsesUbahTanggalTransaksi').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonUbahTanggalTransaksi').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/TransaksiPenjualan/ProsesUbahTanggalTransaksi.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonUbahTanggalTransaksi').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiUbahTanggalTransaksi').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    $('#ButtonUbahTanggalTransaksi').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#ModalUbahTanggalTransaksi').modal('hide');
                    $('#NotifikasiUbahTanggalTransaksi').html('');
                    ShowInformasiTransaksi(GetKodeTransaksi);
                    Swal.fire('Berhasil!', 'Tanggal Transaksi Berhasil Diubah', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiUbahTanggalTransaksi').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonUbahTanggalTransaksi').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiUbahTanggalTransaksi').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Ketika Modal Ubah Status Transaksi Muncul
    $('#ModalUbahStatusTransaksi').on('show.bs.modal', function (e) {
        var kode_transaksi = $(e.relatedTarget).data('id');
        $('#FormUbahStatusTransaksi').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/FormUbahStatusTransaksi.php',
            data        : { kode_transaksi: kode_transaksi },
            success     : function(data) {
                $('#FormUbahStatusTransaksi').html(data);
                $('#NotifikasiUbahStatusTransaksi').html('');
                $('#ButtonUbahStatusTransaksi').html('<i class="bi bi-save"></i> Simpan');
            }
        });
    });
    //Proses Ubah Status Transaksi
    $('#ProsesUbahStatusTransaksi').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonUbahStatusTransaksi').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/TransaksiPenjualan/ProsesUbahStatusTransaksi.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonUbahStatusTransaksi').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiUbahStatusTransaksi').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    $('#ButtonUbahStatusTransaksi').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#ModalUbahStatusTransaksi').modal('hide');
                    $('#NotifikasiUbahStatusTransaksi').html('');
                    ShowInformasiTransaksi(GetKodeTransaksi);
                    Swal.fire('Berhasil!', 'Status Transaksi Berhasil Diubah', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiUbahStatusTransaksi').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonUbahStatusTransaksi').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiUbahStatusTransaksi').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Ketika Modal Ubah Rincian Transaksi Muncul
    $('#ModalUbahRincianTransaksi').on('show.bs.modal', function (e) {
        var id_transaksi_rincian = $(e.relatedTarget).data('id');
        $('#FormUbahRincianTransaksi').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/FormUbahRincianTransaksi.php',
            data        : { id_transaksi_rincian: id_transaksi_rincian },
            success     : function(data) {
                $('#FormUbahRincianTransaksi').html(data);
                $('#NotifikasiUbahRincianTransaksi').html('');
                $('#ButtonUbahRincianTransaksi').html('<i class="bi bi-save"></i> Simpan');
            }
        });
    });
    //Proses Ubah Rincian Transaksi
    $('#ProsesUbahRincianTransaksi').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonUbahRincianTransaksi').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/TransaksiPenjualan/ProsesUbahRincianTransaksi.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonUbahRincianTransaksi').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiUbahRincianTransaksi').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    $('#ButtonUbahRincianTransaksi').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#ModalUbahRincianTransaksi').modal('hide');
                    $('#NotifikasiUbahRincianTransaksi').html('');
                    ShowInformasiTransaksi(GetKodeTransaksi);
                    Swal.fire('Berhasil!', 'Rincian Transaksi Berhasil Diubah', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiUbahRincianTransaksi').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonUbahRincianTransaksi').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiUbahRincianTransaksi').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Ketika Modal Ubah Rincian Lainnya Muncul
    $('#ModalUbahRincianLainnya').on('show.bs.modal', function (e) {
        var kode_transaksi = $(e.relatedTarget).data('id');
        $('#FormUbahRincianLainnya').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/FormUbahRincianLainnya.php',
            data        : { kode_transaksi: kode_transaksi },
            success     : function(data) {
                $('#FormUbahRincianLainnya').html(data);
                $('#NotifikasiUbahRincianLainnya').html('');
                $('#ButtonUbahRincianLainnya').html('<i class="bi bi-save"></i> Simpan');
            }
        });
    });
    //Proses Ubah Rincian Lainnya
    $('#ProsesUbahRincianLainnya').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonUbahRincianLainnya').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/TransaksiPenjualan/ProsesUbahRincianLainnya.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonUbahRincianLainnya').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiUbahRincianLainnya').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    $('#ButtonUbahRincianLainnya').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#ModalUbahRincianLainnya').modal('hide');
                    $('#NotifikasiUbahRincianLainnya').html('');
                    ShowInformasiTransaksi(GetKodeTransaksi);
                    Swal.fire('Berhasil!', 'Rincian Lainnya Berhasil Diubah', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiUbahRincianLainnya').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonUbahRincianLainnya').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiUbahRincianLainnya').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Ketika Modal Tambah Pembayaran Muncul
    $('#ModalTambahPembayaran').on('show.bs.modal', function (e) {
        var kode_transaksi = $(e.relatedTarget).data('id');
        $('#FormTambahPembayaran').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/FormTambahPembayaran.php',
            data        : { kode_transaksi: kode_transaksi },
            success     : function(data) {
                $('#FormTambahPembayaran').html(data);
                ShowPembayaran(GetKodeTransaksi);
            }
        });
    });
    //Ketika Modal Detail Pembayaran Muncul
    $('#ModalDetailPembayaran').on('show.bs.modal', function (e) {
        var id_transaksi_payment = $(e.relatedTarget).data('id');
        $('#FormDetailPembayaran').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/FormDetailPembayaran.php',
            data        : { id_transaksi_payment: id_transaksi_payment },
            success     : function(data) {
                $('#FormDetailPembayaran').html(data);
            }
        });
    });
    //Ketika Modal Hapus Pembayaran Muncul
    $('#ModalHapusPembayaran').on('show.bs.modal', function (e) {
        var id_transaksi_payment = $(e.relatedTarget).data('id');
        $('#FormHapusPembayaran').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/FormHapusPembayaran.php',
            data        : { id_transaksi_payment: id_transaksi_payment },
            success     : function(data) {
                $('#FormHapusPembayaran').html(data);
            }
        });
    });
    //Proses Hapus Pembayaran
    $('#ProsesHapusPembayaran').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonHapusPembayaran').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/TransaksiPenjualan/ProsesHapusPembayaran.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonHapusPembayaran').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiHapusPembayaran').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    $('#ButtonHapusPembayaran').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                    $('#ModalHapusPembayaran').modal('hide');
                    $('#NotifikasiHapusPembayaran').html('');
                    ShowPembayaran(GetKodeTransaksi);
                    Swal.fire('Berhasil!', 'Data Pembayaran Berhasil Dihapus', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiHapusPembayaran').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonHapusPembayaran').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                $('#NotifikasiHapusPembayaran').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Ketika Modal Ubah Pengiriman Muncul
    $('#ModalUbahPengiriman').on('show.bs.modal', function (e) {
        var kode_transaksi = $(e.relatedTarget).data('id');
        $('#FormUbahPengiriman').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/FormUbahPengiriman.php',
            data        : { kode_transaksi: kode_transaksi },
            success     : function(data) {
                $('#FormUbahPengiriman').html(data);
                $('#NotifikasiUbahPengiriman').html('');
                $('#ButtonUbahPengiriman').html('<i class="bi bi-save"></i> Simpan');
            }
        });
    });
    //Proses Ubah Pengiriman
    $('#ProsesUbahPengiriman').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonUbahPengiriman').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/TransaksiPenjualan/ProsesUbahPengiriman.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonUbahPengiriman').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiUbahPengiriman').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    $('#ButtonUbahPengiriman').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#ModalUbahPengiriman').modal('hide');
                    $('#NotifikasiUbahPengiriman').html('');
                    ShowInformasiTransaksi(GetKodeTransaksi);
                    ShowPembayaran(GetKodeTransaksi);
                    ShowPengiriman(GetKodeTransaksi);
                    Swal.fire('Berhasil!', 'Data Pengiriman Berhasil Diperbaharui', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiUbahPengiriman').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonUbahPengiriman').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiUbahPengiriman').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Ketika Modal Cetak Nota Muncul
    $('#ModalCetakNota').on('show.bs.modal', function (e) {
        var kode_transaksi = $(e.relatedTarget).data('id');
        $('#FormCetakNota').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/FormCetakNota.php',
            data        : { kode_transaksi: kode_transaksi },
            success     : function(data) {
                $('#FormCetakNota').html(data);
            }
        });
    });
    //Ketika Modal Cetak Resi Muncul
    $('#ModalCetakResi').on('show.bs.modal', function (e) {
        var kode_transaksi = $(e.relatedTarget).data('id');
        $('#FormCetakResi').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/FormCetakResi.php',
            data        : { kode_transaksi: kode_transaksi },
            success     : function(data) {
                $('#FormCetakResi').html(data);
                $('#NotifikasiCetakResi').html('');
                $('#ButtonCetakResi').html('<i class="bi bi-printer"></i> Cetak');
            }
        });
    });
    //Ketika Modal Hapus Muncul
    $('#ModalHapus').on('show.bs.modal', function (e) {
        var kode_transaksi = $(e.relatedTarget).data('id');
        $('#FormHapus').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/TransaksiPenjualan/FormHapus.php',
            data        : { kode_transaksi: kode_transaksi },
            success     : function(data) {
                $('#FormHapus').html(data);
            }
        });
    });

    //Proses Hapus
    $('#ProsesHapus').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonHapus').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/TransaksiPenjualan/ProsesHapus.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonHapus').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiHapus').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    $('#ButtonHapus').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                    $('#ModalHapus').modal('hide');
                    $('#NotifikasiHapus').html('');
                    filterAndLoadTable();
                    Swal.fire('Berhasil!', 'Data Transaksi Berhasil Dihapus', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiHapus').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonHapus').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                $('#NotifikasiHapus').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
});