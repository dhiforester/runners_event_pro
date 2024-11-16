// Proses Pendaftaran Event
$('#ProsesPendaftaranEvent').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $('#ButtonPendaftaranEvent').html('Loading...').prop('disabled', true);

    $.ajax({
        url             : '_Page/Event/ProsesPendaftaranEvent.php',
        type            : 'POST',
        data            : formData,
        contentType     : false,
        processData     : false,
        success: function (response) {
            $('#ButtonPendaftaranEvent').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            var result;
            try {
                // Mencoba untuk parse JSON
                result = JSON.parse(response);
            } catch (e) {
                $('#NotifikasiPendaftaranEvent').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                // Keluar dari fungsi jika JSON tidak valid
                return;
            }
            if (result.code === 200) {
                var id_event_peserta=result.id_event_peserta;
                // Apabila berhasil, lakukan redirect
                window.location.href = "index.php?Page=DetailPendaftaranEvent&id="+ encodeURIComponent(id_event_peserta);
            } else {
                // Menampilkan pesan kesalahan dari server
                $('#NotifikasiPendaftaranEvent').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
            }
        },
        error: function () {
            $('#ButtonPendaftaranEvent').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            $('#NotifikasiPendaftaranEvent').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
        }
    });
});
// Ketika form dengan class ProsesAssesment dikirim
$('.ProsesAssesment').on('submit', function(e) {
    e.preventDefault(); // Mencegah form submit secara default

    // Ambil ID dari elemen form
    const form = $(this);
    const idForm = form.find('[name="id_event_assesment_form"]').val();
    
    // Ambil elemen notifikasi berdasarkan ID form
    const notificationElement = $('#NotifikasiAssesment' + idForm);

    // Dapatkan data form
    const formData = new FormData(this);

    // AJAX request
    $.ajax({
        url: '_Page/Event/ProsesAssesment.php', // Ganti dengan URL proses backend
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json', // Menentukan format response sebagai JSON
        beforeSend: function() {
            // Kosongkan dan tampilkan loading di notifikasi
            notificationElement.html('<div class="alert alert-info">Sedang memproses...</div>');
        },
        success: function(response) {
            // Cek kode status dari response JSON
            if (response.code === 200) {
                // Tampilkan pesan sukses
                notificationElement.html('<div class="alert alert-success">' + response.message + '</div>');
                location.reload();
            } else {
                // Tampilkan pesan error dari server
                notificationElement.html('<div class="alert alert-warning">' + response.message + '</div>');
            }
        },
        error: function(xhr, status, error) {
            // Tampilkan pesan error jika AJAX gagal
            notificationElement.html('<div class="alert alert-danger">Terjadi kesalahan: ' + error + '</div>');
        }
    });
});
// Menampilkan Form Pembayaran
$('#ModalBayarEvent').on('show.bs.modal', function (e) {
    var kode_transaksi = $(e.relatedTarget).data('id');
    $('#FormBayarEvent').html("Loading...");
    $.ajax({
        type        : 'POST',
        url         : '_Page/Event/FormBayarEvent.php',
        data        : { kode_transaksi: kode_transaksi },
        success     : function(data) {
            $('#FormBayarEvent').html(data);
        }
    });
});