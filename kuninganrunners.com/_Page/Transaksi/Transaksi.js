// Menampilkan Form Pembayaran
$('#ModalPembayaran').on('show.bs.modal', function (e) {
    var kode_transaksi = $(e.relatedTarget).data('id');
    $('#FormPembayaran').html("Loading...");
    $.ajax({
        type        : 'POST',
        url         : '_Page/Transaksi/FormPembayaran.php',
        data        : { kode_transaksi: kode_transaksi },
        success     : function(data) {
            $('#FormPembayaran').html(data);
        }
    });
});
// Menampilkan Form Pembatalan Transaksi
$('#ModalBatalkanTransaksi').on('show.bs.modal', function (e) {
    var kode_transaksi = $(e.relatedTarget).data('id');
    $('#FormBatalkanTransaksi').html("Loading...");
    $.ajax({
        type        : 'POST',
        url         : '_Page/Transaksi/FormBatalkanTransaksi.php',
        data        : { kode_transaksi: kode_transaksi },
        success     : function(data) {
            $('#FormBatalkanTransaksi').html(data);
        }
    });
});
// Proses Batalkan Transaksi
$('#ProsesBatalkanTransaksi').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $('#ButtonBatalkanTransaksi').html('Loading...').prop('disabled', true);

    $.ajax({
        url             : '_Page/Transaksi/ProsesBatalkanTransaksi.php',
        type            : 'POST',
        data            : formData,
        contentType     : false,
        processData     : false,
        success: function (response) {
            $('#ButtonBatalkanTransaksi').html('<i class="bi bi-check-circle"></i> Ya, Batalkan').prop('disabled', false);
            var result;
            try {
                // Mencoba untuk parse JSON
                result = JSON.parse(response);
            } catch (e) {
                $('#NotifikasiBatalkanTransaksi').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                // Keluar dari fungsi jika JSON tidak valid
                return;
            }
            if (result.code === 200) {
                //Apabila Berhasil
                //1.Tutup Modal
                $('#ModalBatalkanTransaksi').modal('hide');
                //2. Tampilkan Swal
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Transaksi Berhasil Dibatalkan',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        //3. Reload halaman setelah swal ditutup
                        window.location.href = "index.php?Page=RiwayatTransaksi";
                    }
                });
                $('#ButtonBatalkanTransaksi').html('<i class="bi bi-check-circle"></i> Ya, Batalkan').prop('disabled', false);
            } else {
                // Menampilkan pesan kesalahan dari server
                $('#NotifikasiBatalkanTransaksi').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
            }
        },
        error: function () {
            $('#ButtonBatalkanTransaksi').html('<i class="bi bi-check-circle"></i> Ya, Batalkan').prop('disabled', false);
            $('#NotifikasiBatalkanTransaksi').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
        }
    });
});