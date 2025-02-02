//Fungsi Menampilkan Peserta Event
function list_peserta_event() {
    var curent_page = $('#curent_page').val();
    var put_id_event = $('#put_id_event').val();
    var keyword = $('#keyword_peserta').val();
    
    // console.log("Current Page: ", curent_page);
    // console.log("ID Event: ", put_id_event);

    $('#TabelPesertaEvent').html('<tr><td colspan="3" class="text-center">Loading...</td></tr>');

    $.ajax({
        type: 'POST',
        url: '_Page/Event/TabelPeserta.php',
        data: {page: curent_page, id_event: put_id_event, keyword: keyword},
        success: function(response) {
            // console.log("Response Received: ", response);
            $('#TabelPesertaEvent').html(response);
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: " + status + " - " + error);
            $('#TabelPesertaEvent').html('<tr><td colspan="3" class="text-center text-danger">Error Loading Data</td></tr>');
        }
    });
}
//Menampilkan List Peserta Event Pertama Kali
$(document).ready(function() {
    list_peserta_event();

    //Ketika Next Di click
    $('#NextButton').on('click', function (e) {
        var current_page = parseInt($('#curent_page').val());  // Ambil nilai halaman saat ini
        var nextpage = current_page + 1;  // Decrement halaman
        $('#curent_page').val(nextpage);  // Update nilai halaman saat in
        list_peserta_event();
    });

    //Ketika Prev Di click
    $('#PrevButton').on('click', function (e) {
        var current_page = parseInt($('#curent_page').val());  // Ambil nilai halaman saat ini
        var prevPage = current_page - 1;  // Decrement halaman
        $('#curent_page').val(prevPage);  // Update nilai halaman saat in
        list_peserta_event();
    });
    
    //Ketika Pencarian Di Submit
    $('#FormPencarianPeserta').on('submit', function (e) {
        list_peserta_event();
    });
});


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
// Proses Batalkan Pendaftaran Event
$('#ProsesPembatalanEvent').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $('#ButtonPembatalanEvent').html('Loading...').prop('disabled', true);

    $.ajax({
        url             : '_Page/Event/ProsesPembatalanEvent.php',
        type            : 'POST',
        data            : formData,
        contentType     : false,
        processData     : false,
        success: function (response) {
            $('#ButtonPembatalanEvent').html('<i class="bi bi-check-circle"></i> Ya, Batalkan').prop('disabled', false);
            var result;
            try {
                // Mencoba untuk parse JSON
                result = JSON.parse(response);
            } catch (e) {
                $('#NotifikasiPembatalanEvent').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                // Keluar dari fungsi jika JSON tidak valid
                return;
            }
            if (result.code === 200) {
                //Apabila Berhasil
                $('#NotifikasiPembatalanEvent').html('');
                //1.Tutup Modal
                $('#ModalPembatalanEvent').modal('hide');
                //2. Tampilkan Swal
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Pendaftaran Anda Berhasil Dibatalkan',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        //3. Reload halaman setelah swal ditutup
                        window.location.href = "index.php?Page=RiwayatEvent";
                    }
                });
                $('#ButtonPembatalanEvent').html('<i class="bi bi-check-circle"></i> Ya, Batalkan').prop('disabled', false);
            } else {
                // Menampilkan pesan kesalahan dari server
                $('#NotifikasiPembatalanEvent').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
            }
        },
        error: function () {
            $('#ButtonPembatalanEvent').html('<i class="bi bi-check-circle"></i> Ya, Batalkan').prop('disabled', false);
            $('#NotifikasiPembatalanEvent').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
        }
    });
});

