//Fungsi Menampilkan Data Event
function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/Event/TabelEvent.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanTabelEvent').html(data);
        }
    });
}
//Fungsi Menampilkan Poster Event
function ShowPosterEvent() {
    var id_event = $('#GetIdEvent').val();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Event/ShowPosterEvent.php',
        data    : {id_event: id_event},
        success: function(data) {
            $('#ShowPosterEvent').html(data);
        }
    });
}
function ShowDetailEvent() {
    var id_event = $('#GetIdEvent').val();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Event/FormDetailEvent.php',
        data    : {id_event: id_event},
        success: function(data) {
            $('#ShowDetailEvent').html(data);
        }
    });
}
function ShowRuteEvent() {
    var id_event = $('#GetIdEvent').val();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Event/ShowRuteEvent.php',
        data    : {id_event: id_event},
        success: function(data) {
            $('#ShowRuteEvent').html(data);
        }
    });
}
//Menampilkan Data Pertama Kali
$(document).ready(function() {
    //Menampilkan Data Pertama kali
    filterAndLoadTable();
    //Menampilkan Properti Detail Event
    ShowPosterEvent();
    ShowDetailEvent();
    ShowRuteEvent();
    //Filter Data
    $('#ProsesFilter').submit(function(){
        $('#page').val("1");
        filterAndLoadTable();
        $('#ModalFilter').modal('hide');
    });
    // Fungsi untuk mengecek panjang input nama_event
    $('#nama_event').on('input', function () {
        var maxLength = 100;
        var currentLength = $(this).val().length;
        $('#nama_event_length').text(currentLength + '/' + maxLength);

        if (currentLength > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
            $('#nama_event_length').text(maxLength + '/' + maxLength);
            Swal.fire('Perhatian', 'Nama event tidak boleh lebih dari 100 karakter.', 'warning');
        }
    });

    // Fungsi untuk mengecek panjang input keterangan
    $('#keterangan').on('input', function () {
        var maxLength = 500;
        var currentLength = $(this).val().length;
        $('#keterangan_length').text(currentLength + '/' + maxLength);

        if (currentLength > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
            $('#keterangan_length').text(maxLength + '/' + maxLength);
            Swal.fire('Perhatian', 'Keterangan tidak boleh lebih dari 500 karakter.', 'warning');
        }
    });
    //Proses Tambah Event
    $('#ProsesTambahEvent').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonTambahEvent').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/Event/ProsesTambahEvent.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonTambahEvent').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;

                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiTambahEvent').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }

                if (result.success) {
                    $('#ProsesTambahEvent')[0].reset();
                    $('#ProsesFilter')[0].reset();
                    $('#ModalTambahEvent').modal('hide');
                    filterAndLoadTable();
                    Swal.fire('Berhasil!', 'Event Berhasil Ditambahkan', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiTambahEvent').html('<div class="alert alert-danger">' + result.message + '</div>');
                }
            },
            error: function () {
                $('#ButtonTambahEvent').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiTambahEvent').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });

    //Ketika Modal Detail Entitias Akses
    $('#ModalDetailEvent').on('show.bs.modal', function (e) {
        var id_event = $(e.relatedTarget).data('id');
        $('#FormDetailEvent').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Event/FormDetailEvent.php',
            data        : {id_event: id_event},
            success     : function(data){
                $('#FormDetailEvent').html(data);
            }
        });
    });
    //Ketika Modal Edit Event Muncul
    $('#ModalEditEvent').on('show.bs.modal', function (e) {
        var id_event = $(e.relatedTarget).data('id');
        $('#FormEditEvent').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Event/FormEditEvent.php',
            data        : {id_event: id_event},
            success     : function(data){
                $('#FormEditEvent').html(data);
                $('#NotifikasiEditEvent').html('');
            }
        });
    });
    //Proses Edit Event
    $('#ProsesEditEvent').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonEditEvent').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/Event/ProsesEditEvent.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonEditEvent').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;

                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiEditEvent').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }

                if (result.success) {
                    $('#ProsesEditEvent')[0].reset();
                    $('#ModalEditEvent').modal('hide');
                    filterAndLoadTable();
                    //Menampilkan Properti Detail Event
                    ShowPosterEvent();
                    ShowDetailEvent();
                    ShowRuteEvent();
                    Swal.fire('Berhasil!', 'Event Berhasil Diupdate', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiEditEvent').html('<div class="alert alert-danger">' + result.message + '</div>');
                }
            },
            error: function () {
                $('#ButtonTambahEvent').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiEditEvent').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Ketika Modal Ubah Poster Muncul
    $('#ModalUbahPoster').on('show.bs.modal', function (e) {
        var id_event = $(e.relatedTarget).data('id');
        $('#FormUbahPoster').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Event/FormUbahPoster.php',
            data        : {id_event: id_event},
            success     : function(data){
                $('#FormUbahPoster').html(data);
                $('#NotifikasiUbahPoster').html('');
            }
        });
    });
    //Proses Update Poster
    $('#ProsesUbahPoster').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonUbahPoster').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);

        // Membuat objek FormData
        var formData = new FormData(this);

        // Mengirim data melalui AJAX
        $.ajax({
            url: '_Page/Event/ProsesUbahPoster.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    filterAndLoadTable();
                    //Menampilkan (reload) properti lain pada detail event
                    ShowPosterEvent();
                    ShowDetailEvent();
                    ShowRuteEvent();
                    $('#ModalUbahPoster').modal('hide');
                    $('#ButtonUbahPoster').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Poster Event Berhasil Diupdate', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiUbahPoster').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonUbahPoster').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiUbahPoster').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonUbahPoster').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    //Ketika Modal Ganti Rute Muncul
    $('#ModalGantiRute').on('show.bs.modal', function (e) {
        var id_event = $(e.relatedTarget).data('id');
        $('#FormGantiRute').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Event/FormGantiRute.php',
            data        : {id_event: id_event},
            success     : function(data){
                $('#FormGantiRute').html(data);
                $('#NotifikasiGantiRute').html('');
            }
        });
    });
    //Proses Update Rute
    $('#ProsesGantiRute').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonGantiRute').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);

        // Membuat objek FormData
        var formData = new FormData(this);

        // Mengirim data melalui AJAX
        $.ajax({
            url: '_Page/Event/ProsesGantiRute.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    filterAndLoadTable();
                    //Menampilkan (reload) properti lain pada detail event
                    ShowPosterEvent();
                    ShowDetailEvent();
                    ShowRuteEvent();
                    $('#ModalGantiRute').modal('hide');
                    $('#ButtonGantiRute').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Rute Event Berhasil Diupdate', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiGantiRute').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonGantiRute').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiGantiRute').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonGantiRute').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    //Ketika Modal Hapus Event Muncul
    $('#ModalHapusEvent').on('show.bs.modal', function (e) {
        var id_event = $(e.relatedTarget).data('id');
        $('#FormHapusEvent').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Event/FormHapusEvent.php',
            data        : {id_event: id_event},
            success     : function(data){
                $('#FormHapusEvent').html(data);
                $('#NotifikasiHapusEvent').html('');
            }
        });
    });
    //Proses Hapus Event
    $('#ProsesHapusEvent').submit(function(){
        $('#NotifikasiHapusEvent').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var ProsesHapusEvent = $('#ProsesHapusEvent').serialize();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Event/ProsesHapusEvent.php',
            data 	    :  ProsesHapusEvent,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiHapusEvent').html(data);
                var NotifikasiHapusEventBerhasil=$('#NotifikasiHapusEventBerhasil').html();
                if(NotifikasiHapusEventBerhasil=="Success"){
                    $("#ProsesHapusEvent")[0].reset();
                    $('#ModalHapusEvent').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Hapus Event Berhasil!',
                        'success'
                    )
                    //Menampilkan Data
                    filterAndLoadTable();
                }
            }
        });
    });
});