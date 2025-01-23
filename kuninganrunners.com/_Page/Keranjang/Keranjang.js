function calculateSubtotal() {
    var ProsesTambahTransaksi=$('#ProsesTambahTransaksi').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Keranjang/ProsesHitungSubtotal.php',
        data    : ProsesTambahTransaksi,
        success: function(data) {
            $('#Subtotal').html(data);
        }
    });
}
function ProsesHitungOngkir() {
    var ProsesTambahTransaksi=$('#ProsesTambahTransaksi').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Keranjang/ProsesHitungOngkir.php',
        data    : ProsesTambahTransaksi,
        success: function(data) {
            $('#list_paket').html(data);
        }
    });
}
function ShowAlamatFirstTime(id_propinsi,kabupaten_member,kecamatan_member,desa_member) {
    $.ajax({
        type    : 'POST',
        url     : '_Page/Keranjang/ListKabupaten.php',
        data    : {id_propinsi: id_propinsi, kabupaten_member: kabupaten_member},
        success: function(data) {
            $('#kabupaten_pengiriman').html(data);
            //Setelah Kabupaten Muncul tangkap id_kabupaten nya
            var id_kabupaten=$('#kabupaten_pengiriman').val();
            $.ajax({
                type    : 'POST',
                url     : '_Page/Keranjang/ListKecamatan.php',
                data    : {id_kabupaten: id_kabupaten, kecamatan_member: kecamatan_member},
                success: function(data) {
                    $('#kecamatan_pengiriman').html(data);
                    //Setelah Kecamatan Muncul tangkap id_kecamatan nya
                    var id_kecamatan=$('#kecamatan_pengiriman').val();
                    $.ajax({
                        type    : 'POST',
                        url     : '_Page/Keranjang/ListDesa.php',
                        data    : {id_kecamatan: id_kecamatan, desa_member: desa_member},
                        success: function(data) {
                            $('#desa_pengiriman').html(data);
                            //Selesai
                        }
                    });
                }
            });
        }
    });
}
$(document).ready(function () {
    //Ketika Item Keranjang Dipilih
    $('input[name="item_keranjang[]"]').on('change', function () {
        calculateSubtotal();
        ProsesHitungOngkir();
    });

    // Event listener untuk perubahan pada select metode_pengiriman
    $('#metode_pengiriman').change(function() {
        var metode = $(this).val(); // Ambil nilai dari select
        if (metode === 'Dikirim') {
            // Tampilkan alamat_pengiriman jika metode adalah "Dikirim"
            $('#form_alamat_pengiriman').slideDown();
        } else {
            // Sembunyikan alamat_pengiriman jika metode adalah "Diambil"
            $('#form_alamat_pengiriman').slideUp();
        }
    });

    //Ketika Kurir Di Pilih
    $('#kurir').change(function() {
        ProsesHitungOngkir();
    });
    
    //Ketika Pencarian alamat dimulai
    $('#ProsesCariAlamat').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#list_alamat').html('Loading...');
        $.ajax({
            url             : '_Page/Keranjang/ProsesCariAlamat.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            success: function (response) {
                $('#list_alamat').html(response);
            }
        });
    });
    //Menampilkan kabupaten_pengiriman Pertama kali
    var id_propinsi=$('#provinsi_pengiriman').val();
    var kabupaten_member=$('#PutKabupatenMember').val();
    var kecamatan_member=$('#PutKecamatanMember').val();
    var desa_member=$('#PutDesaMember').val();
    ShowAlamatFirstTime(id_propinsi,kabupaten_member,kecamatan_member,desa_member);
    //Apabila Provinsi Diubah Maka Reset Form Kabupaten, Kecamatan, dan Desa
    $('#provinsi_pengiriman').on('change', function() {
        var id_propinsi = $(this).val();
        var id_kabupaten=$('#kabupaten_pengiriman').val();
        $.ajax({
            type    : 'POST',
            url     : '_Page/Keranjang/ListKabupaten.php',
            data    : {id_propinsi: id_propinsi},
            success: function(data) {
                $('#kabupaten_pengiriman').html(data);
            }
        });
        $('#kecamatan_pengiriman').html('<option value="">Pilih</option>');
        $('#desa_pengiriman').html('<option value="">Pilih</option>');
    });
    //Apabila kabupaten Diubah Maka Reset Form Kecamatan, dan Desa
    $('#kabupaten_pengiriman').on('change', function() {
        var id_kabupaten = $(this).val();
        $.ajax({
            type    : 'POST',
            url     : '_Page/Keranjang/ListKecamatan.php',
            data    : {id_propinsi: id_propinsi, id_kabupaten: id_kabupaten},
            success: function(data) {
                $('#kecamatan_pengiriman').html(data);
            }
        });
        $('#desa_pengiriman').html('<option value="">Pilih</option>');
    });
    //Apabila kecamatan Diubah Maka Reset Form Desa
    $('#kecamatan_pengiriman').on('change', function() {
        var id_kecamatan = $(this).val();
        $.ajax({
            type    : 'POST',
            url     : '_Page/Keranjang/ListDesa.php',
            data    : {id_kecamatan: id_kecamatan},
            success: function(data) {
                $('#desa_pengiriman').html(data);
            }
        });
    });
});

//Ketika Modal Edit Keranjang Muncul
$('#ModalEditKeranjang').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    $('#FormEditKeranjang').html("Loading...");
    $.ajax({
        type        : 'POST',
        url         : '_Page/Keranjang/FormEditKeranjang.php',
        data        : { GetData: GetData },
        success     : function(data) {
            $('#FormEditKeranjang').html(data);
            $('#NotifikasiEditKeranjang').html('');
        }
    });
});
// Proses Edit Keranjang
$('#ProsesEditKeranjang').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $('#ButtonEditKeranjang').html('Loading...').prop('disabled', true);

    $.ajax({
        url             : '_Page/Keranjang/ProsesEditKeranjang.php',
        type            : 'POST',
        data            : formData,
        contentType     : false,
        processData     : false,
        success: function (response) {
            $('#ButtonEditKeranjang').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            var result;
            try {
                // Mencoba untuk parse JSON
                result = JSON.parse(response);
            } catch (e) {
                $('#NotifikasiEditKeranjang').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                // Keluar dari fungsi jika JSON tidak valid
                return;
            }
            if (result.code === 200) {
                //Reset Form
                $('#ProsesEditKeranjang')[0].reset();
                //Tutup Modal
                $('#ModalEditKeranjang').modal('hide');
                // Menampilkan swal pemberitahuan
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Keranjang Berhasil Diubah.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Reload halaman setelah swal ditutup
                        location.reload();
                    }
                });
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
// Proses Tambah Transaksi
$('#ProsesTambahTransaksi').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $('#ButtonTambahTransaksi').html('Loading...').prop('disabled', true);

    $.ajax({
        url             : '_Page/Keranjang/ProsesTambahTransaksi.php',
        type            : 'POST',
        data            : formData,
        contentType     : false,
        processData     : false,
        success: function (response) {
            $('#ButtonTambahTransaksi').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            var result;
            try {
                // Mencoba untuk parse JSON
                result = JSON.parse(response);
            } catch (e) {
                $('#NotifikasiTambahTransaksi').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                // Keluar dari fungsi jika JSON tidak valid
                return;
            }
            if (result.code === 200) {
                // Menangkap Kode Transaksi
                var kode_transaksi = result.kode_transaksi;

                if (kode_transaksi && kode_transaksi.trim() !== "") {
                    // Redirect ke URL dengan kode transaksi
                    location.href = "index.php?Page=DetailTransaksi&kode=" + encodeURIComponent(kode_transaksi);
                } else {
                    // Menampilkan pesan error jika kode_transaksi kosong
                    $('#NotifikasiTambahTransaksi').html('<div class="alert alert-danger"><small><code class="text-dark">Kode transaksi tidak valid.</code></small></div>');
                }
            } else {
                // Menampilkan pesan kesalahan dari server
                $('#NotifikasiTambahTransaksi').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
            }
        },
        error: function () {
            $('#ButtonTambahTransaksi').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            $('#NotifikasiTambahTransaksi').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
        }
    });
});