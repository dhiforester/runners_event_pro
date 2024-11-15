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
function ShowPosterEvent() {
    var id_event = $('#GetIdEvent').val();
    if (id_event) { // Cek apakah id_event tidak kosong atau undefined
        $.ajax({
            type: 'POST',
            url: '_Page/Event/ShowPosterEvent.php',
            data: { id_event: id_event },
            success: function(data) {
                $('#ShowPosterEvent').html(data);
            },
            error: function(xhr, status, error) {
                console.error('Error ShowPosterEvent:', error);
            }
        });
    }
}

function ShowDetailEvent() {
    var id_event = $('#GetIdEvent').val();
    if (id_event) { // Cek apakah id_event tidak kosong atau undefined
        $.ajax({
            type: 'POST',
            url: '_Page/Event/FormDetailEvent.php',
            data: { id_event: id_event },
            success: function(data) {
                $('#ShowDetailEvent').html(data);
            },
            error: function(xhr, status, error) {
                console.error('Error ShowDetailEvent:', error);
            }
        });
    }
}

function ShowRuteEvent() {
    var id_event = $('#GetIdEvent').val();
    if (id_event) { // Cek apakah id_event tidak kosong atau undefined
        $.ajax({
            type: 'POST',
            url: '_Page/Event/ShowRuteEvent.php',
            data: { id_event: id_event },
            success: function(data) {
                $('#ShowRuteEvent').html(data);
            },
            error: function(xhr, status, error) {
                console.error('Error ShowRuteEvent:', error);
            }
        });
    }
}
function ShowKategoriEvent() {
    var id_event = $('#GetIdEvent').val();
    if (id_event) { // Cek apakah id_event tidak kosong atau undefined
        $.ajax({
            type: 'POST',
            url: '_Page/Event/ShowKategoriEvent.php',
            data: { id_event: id_event },
            success: function(data) {
                $('#ShowKategoriEvent').html(data);
            },
            error: function(xhr, status, error) {
                console.error('Error ShowKategoriEvent:', error);
            }
        });
    }
}
function ShowAseesmentFormEvent() {
    var id_event = $('#GetIdEvent').val();
    // Cek apakah id_event tidak kosong atau undefined
    if (id_event) { 
        $.ajax({
            type        : 'POST',
            url         : '_Page/Event/ShowAseesmentFormEvent.php',
            data        : {id_event: id_event},
            success: function(data) {
                $('#ShowAseesmentFormEvent').html(data);
            },
            error: function(xhr, status, error) {
                console.error('Error ShowAseesmentFormEvent:', error);
            }
        });
    }
}
function ShowPesertaEvent() {
    var id_event = $('#GetIdEvent').val();
    // Cek apakah id_event tidak kosong atau undefined
    if (id_event) { 
        $('#id_event_peserta').val(id_event);
        var ProsesFilterPeserta = $('#ProsesFilterPeserta').serialize();
        $.ajax({
            type        : 'POST',
            url         : '_Page/Event/ShowPesertaEvent.php',
            data        : ProsesFilterPeserta,
            success: function(data) {
                $('#ShowPesertaEvent').html(data);
            },
            error: function(xhr, status, error) {
                console.error('Error ShowPesertaEvent:', error);
            }
        });
    }
}
function ShowDetailPesertaEvent() {
    var id_event_peserta = $('#PutIdEventPeserta').val();
    // Cek apakah id_event tidak kosong atau undefined
    if (id_event_peserta) { 
        $.ajax({
            type: 'POST',
            url: '_Page/Event/ShowDetailPesertaEvent.php',
            data: { id_event_peserta: id_event_peserta },
            success: function(data) {
                $('#ShowDetailPesertaEvent').html(data);
            },
            error: function(xhr, status, error) {
                console.error('Error ShowDetailPesertaEvent:', error);
            }
        });
    }
}
function ShowAssesmentPeserta() {
    var id_event_peserta = $('#PutIdEventPeserta').val();
    // Cek apakah id_event tidak kosong atau undefined
    if (id_event_peserta) { 
        $.ajax({
            type: 'POST',
            url: '_Page/Event/ShowAssesmentPeserta.php',
            data: { id_event_peserta: id_event_peserta },
            success: function(data) {
                $('#ShowAssesmentPeserta').html(data);
            },
            error: function(xhr, status, error) {
                console.error('Error ShowAssesmentPeserta:', error);
            }
        });
    }
}
function ShowRiwayatPembayaranEvent() {
    var id_event_peserta = $('#PutIdEventPeserta').val();
    // Cek apakah id_event tidak kosong atau undefined
    if (id_event_peserta) { 
        $.ajax({
            type: 'POST',
            url: '_Page/Event/ShowRiwayatPembayaranEvent.php',
            data: { id_event_peserta: id_event_peserta },
            success: function(data) {
                $('#ShowRiwayatPembayaranEvent').html(data);
            },
            error: function(xhr, status, error) {
                console.error('Error ShowRiwayatPembayaranEvent:', error);
            }
        });
    }
}
//Menampilkan Data Pertama Kali
$(document).ready(function() {
    //Menampilkan Data Pertama kali
    filterAndLoadTable();
    //Menampilkan Properti Detail Event
    ShowPosterEvent();
    ShowDetailEvent();
    ShowRuteEvent();
    ShowKategoriEvent();
    ShowAseesmentFormEvent();
    ShowPesertaEvent();
    ShowDetailPesertaEvent();
    ShowAssesmentPeserta();
    ShowRiwayatPembayaranEvent();

    //Ketika keyword_by Diubah
    $('#keyword_by').change(function(){
        var keyword_by =$('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Event/FormFilter.php',
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

    //Ketika KeywordByPeserta Diubah
    $('#KeywordByPeserta').change(function(){
        var KeywordByPeserta =$('#KeywordByPeserta').val();
        var id_event = $('#GetIdEvent').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Event/FormFilterPeserta.php',
            data        : {KeywordByPeserta: KeywordByPeserta, id_event: id_event},
            success     : function(data){
                $('#FormFilterPeserta').html(data);
            }
        });
    });
    //Filter Data Peserta Event
    $('#ProsesFilterPeserta').submit(function(){
        $('#page_peserta').val("1");
        ShowPesertaEvent();
        $('#ModalFilterPeserta').modal('hide');
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
    //Ketika Modal Tambah Kategori Muncul
    $('#ModalTambahKategori').on('show.bs.modal', function (e) {
        var id_event = $(e.relatedTarget).data('id');
        $('#FormTambahKategori').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Event/FormTambahKategori.php',
            data        : {id_event: id_event},
            success     : function(data){
                $('#FormTambahKategori').html(data);
                $('#NotifikasiTambahKategori').html('');
            }
        });
    });
    // Proses Tambah Kategori
    $('#ProsesTambahKategori').on('submit', function(e) {
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#NotifikasiTambahKategori').html('Loading...');
        var id_event = $('#PutIdEventForAddKategori').val();
        var kategori = $('#kategori').val();
        var biaya_pendaftaran = $('#biaya_pendaftaran').val();
        var deskripsi = $('#deskripsi').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Event/ProsesTambahKategori.php',
            data 	    :  {id_event: id_event, kategori: kategori, biaya_pendaftaran: biaya_pendaftaran, deskripsi: deskripsi},
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiTambahKategori').html(data);
                var NotifikasiTambahKategoriBerhasil=$('#NotifikasiTambahKategoriBerhasil').html();
                if(NotifikasiTambahKategoriBerhasil=="Success"){
                    $('#NotifikasiTambahKategori').html('');
                    $('#ModalTambahKategori').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Simpan Kategori Event Berhasil!',
                        'success'
                    )
                    //Menampilkan Data
                    ShowDetailEvent();
                    ShowKategoriEvent();
                }
            }
        });
        
    });
    //Ketika Modal Detail Kategori Event Muncul
    $('#ModalDetailKategori').on('show.bs.modal', function (e) {
        var id_event_kategori = $(e.relatedTarget).data('id');
        $('#FormDetailKategori').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Event/FormDetailKategori.php',
            data        : {id_event_kategori: id_event_kategori},
            success     : function(data){
                $('#FormDetailKategori').html(data);
            }
        });
    });
    //Ketika Modal Edit Kategori Event Muncul
    $('#ModalEditKategori').on('show.bs.modal', function (e) {
        var id_event_kategori = $(e.relatedTarget).data('id');
        $('#FormEditKategori').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Event/FormEditKategori.php',
            data        : {id_event_kategori: id_event_kategori},
            success     : function(data){
                $('#FormEditKategori').html(data);
            }
        });
    });
    // Proses Edit Kategori
    $('#ProsesEditKategori').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonEditKategori').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Event/ProsesEditKategori.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowKategoriEvent();
                    ShowDetailEvent();
                    $('#ModalEditKategori').modal('hide');
                    $('#ButtonEditKategori').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Kategori Event Berhasil Diupdate', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiEditKategori').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonEditKategori').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiEditKategori').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonEditKategori').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    // Ketika Modal Hapus Kategori Event Muncul
    $('#ModalHapusKategori').on('show.bs.modal', function (e) {
        var id_event_kategori = $(e.relatedTarget).data('id');
        $('#FormHapusKategori').html("Loading...");
        $.ajax({
            type: 'POST',
            url: '_Page/Event/FormHapusKategori.php',
            data: { id_event_kategori: id_event_kategori },
            success: function(data) {
                $('#FormHapusKategori').html(data);
                $('#NotifikasiHapusKategori').html('');
                var JumlahPeserta = $('#JumlahPeserta').val();
                // Pengecekan jika JumlahPeserta tidak kosong
                if (JumlahPeserta !== null && JumlahPeserta !== '') {
                    $('#ButtonHapusKategori').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                } else {
                    $('#ButtonHapusKategori').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', true);
                }
            }
        });
    });

    // Proses Hapus Kategori
    $('#ProsesHapusKategori').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonHapusKategori').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Event/ProsesHapusKategori.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowKategoriEvent();
                    ShowDetailEvent();
                    $('#ModalHapusKategori').modal('hide');
                    $('#ButtonHapusKategori').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Kategori Event Berhasil Dihapus', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiHapusKategori').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonHapusKategori').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiHapusKategori').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonHapusKategori').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
            }
        });
    });
    // Ketika Modal Tambah Peserta Muncul
    $('#ModalTambahPeserta').on('show.bs.modal', function (e) {
        var id_event = $(e.relatedTarget).data('id');
        $('#kategori_event').html('<option value="">Loading..</option>');
        $.ajax({
            type    : 'POST',
            url     : '_Page/Event/ListKategori.php',
            data    : { id_event: id_event },
            success: function(data) {
                $('#kategori_event').html(data);
            }
        });
        //Pencarian Member
        var ProsesPencarianMember = $('#ProsesPencarianMember').serialize();
        $.ajax({
            type    : 'POST',
            url     : '_Page/Event/ListMember.php',
            data    : ProsesPencarianMember,
            success: function(data) {
                $('#FormListMember').html(data);
            }
        });
    });
    //Ketika Proses Pencarian Member Di Submit
    $('#ProsesPencarianMember').submit(function(){
        var ProsesPencarianMember = $('#ProsesPencarianMember').serialize();
        $.ajax({
            type    : 'POST',
            url     : '_Page/Event/ListMember.php',
            data    : ProsesPencarianMember,
            success: function(data) {
                $('#FormListMember').html(data);
            }
        });
    });
    // Proses Tambah Peserta
    $('#ProsesTambahPeserta').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonTambahPeserta').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Event/ProsesTambahPeserta.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    $('#page_peserta').val('1');
                    ShowKategoriEvent();
                    ShowDetailEvent();
                    ShowPesertaEvent();
                    $('#ProsesTambahPeserta')[0].reset();
                    $('#ModalTambahPeserta').modal('hide');
                    $('#ButtonTambahPeserta').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Peserta berhasil ditambahkan', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiTambahPeserta').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonTambahPeserta').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiTambahPeserta').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonTambahPeserta').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    // Ketika Modal Detail Peserta Event Muncul
    $('#ModalDetailPeserta').on('show.bs.modal', function (e) {
        var id_event_peserta = $(e.relatedTarget).data('id');
        $('#FormDetailPeserta').html("Loading...");
        $.ajax({
            type: 'POST',
            url: '_Page/Event/FormDetailPeserta.php',
            data: { id_event_peserta: id_event_peserta },
            success: function(data) {
                $('#FormDetailPeserta').html(data);
            }
        });
    });
    // Ketika Modal Edit Peserta Event Muncul
    $('#ModalEditPeserta').on('show.bs.modal', function (e) {
        var id_event_peserta = $(e.relatedTarget).data('id');
        $('#FormEditPeserta').html("Loading...");
        $.ajax({
            type: 'POST',
            url: '_Page/Event/FormEditPeserta.php',
            data: { id_event_peserta: id_event_peserta },
            success: function(data) {
                $('#FormEditPeserta').html(data);
                $('#NotifikasiEditPeserta').html('');
            }
        });
    });
    // Proses Edit Peserta
    $('#ProsesEditPeserta').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonEditPeserta').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Event/ProsesEditPeserta.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowKategoriEvent();
                    ShowDetailEvent();
                    ShowPesertaEvent();
                    $('#ModalEditPeserta').modal('hide');
                    $('#ButtonEditPeserta').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Edit Peserta Berhasil', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiEditPeserta').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonEditPeserta').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiEditPeserta').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonEditPeserta').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    // Ketika Modal Hapus Peserta Event Muncul
    $('#ModalHapusPeserta').on('show.bs.modal', function (e) {
        var id_event_peserta = $(e.relatedTarget).data('id');
        $('#FormHapusPeserta').html("Loading...");
        $.ajax({
            type: 'POST',
            url: '_Page/Event/FormHapusPeserta.php',
            data: { id_event_peserta: id_event_peserta },
            success: function(data) {
                $('#FormHapusPeserta').html(data);
                $('#NotifikasiHapusPeserta').html('');
                $('#ButtonHapusPeserta').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
            }
        });
    });
    // Proses Hapus Peserta
    $('#ProsesHapusPeserta').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonHapusPeserta').html('<i class="bi bi-check"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Event/ProsesHapusPeserta.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowKategoriEvent();
                    ShowDetailEvent();
                    ShowPesertaEvent();
                    $('#ModalHapusPeserta').modal('hide');
                    $('#ButtonHapusPeserta').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Peserta berhasil dihapus', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiHapusPeserta').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonHapusPeserta').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiHapusPeserta').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonHapusPeserta').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
            }
        });
    });
    // Ketika Modal Tambah Transaksi Event Muncul
    $('#ModalTambahTransaksiEvent').on('show.bs.modal', function (e) {
        var id_event_peserta = $(e.relatedTarget).data('id');
        $('#FormTambahTransaksiEvent').html("Loading...");
        $.ajax({
            type: 'POST',
            url: '_Page/Event/FormTambahTransaksiEvent.php',
            data: { id_event_peserta: id_event_peserta },
            success: function(data) {
                $('#FormTambahTransaksiEvent').html(data);
                $('#NotifikasiTambahTransaksiEvent').html('');
                $('#ButtonHapusPeserta').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    // Proses Tambah Transaksi Event
    $('#ProsesTambahTransaksiEvent').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonTambahTransaksiEvent').html('<i class="bi bi-check"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Event/ProsesTambahTransaksiEvent.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowDetailPesertaEvent();
                    ShowRiwayatPembayaranEvent();
                    $('#ModalTambahTransaksiEvent').modal('hide');
                    $('#ButtonTambahTransaksiEvent').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Peserta berhasil ditambahkan', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiTambahTransaksiEvent').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonTambahTransaksiEvent').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiTambahTransaksiEvent').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonTambahTransaksiEvent').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    // Ketika Modal Bayar Event Muncul
    $('#ModalBayarEvent').on('show.bs.modal', function (e) {
        var kode_transaksi = $(e.relatedTarget).data('id');
        $('#FormBayarEvent').html("Loading...");
        $.ajax({
            type: 'POST',
            url: '_Page/Event/FormBayarEvent.php',
            data: { kode_transaksi: kode_transaksi },
            success: function(data) {
                $('#FormBayarEvent').html(data);
                ShowRiwayatPembayaranEvent();
            }
        });
    });

    //FORM ASSESMENT PESERTA
    // Ketika Modal Tambah Assesment Form Muncul
    $('#ModalTambahAssesmentForm').on('show.bs.modal', function (e) {
        var id_event = $(e.relatedTarget).data('id');
        var form_type = $('#form_type').val();
        $('#PutIdEventOnAssesmentForm').val(id_event);
        //Menampilkan Alternatif
        if(form_type=='checkbox'||form_type=='radio'||form_type=='select_option'){
            $('#AlternatifButton').show();
        }else{
            $('#AlternatifButton').hide();
            $('#AlternatifList').html('');
        }
    });
    // Keterangan Form Type
    $('#form_type').on('change', function (e) {
        var form_type = $('#form_type').val();
        if(form_type=='file_foto'){
            $('#KeteranganTypeForm').html('Memungkinkan peserta mengunggah file foto maksimal 5 mb (JPG, JPEG, PNG dan GIF)');
        }else{
            if(form_type=='file_pdf'){
                $('#KeteranganTypeForm').html('Memungkinkan peserta mengunggah file PDF maksimal 5 mb');
            }else{
                if(form_type=='text'){
                    $('#KeteranganTypeForm').html('Memungkinkan peserta mengisi form tersebut maksimal 100 karakter');
                }else{
                    if(form_type=='textarea'){
                        $('#KeteranganTypeForm').html('Memungkinkan peserta mengisi form tersebut maksimal 500 karakter');
                    }else{
                        if(form_type=='checkbox'||form_type=='radio'||form_type=='select_option'){
                            $('#KeteranganTypeForm').html('Memungkinkan peserta memilih alternatif yang ditetapkan');
                        }else{
                            $('#KeteranganTypeForm').html('');
                        }
                    }
                }
            }
        }
        if(form_type=='checkbox'||form_type=='radio'||form_type=='select_option'){
            $('#AlternatifButton').show();
        }else{
            $('#AlternatifButton').hide();
            $('#AlternatifList').html('');
        }
    });
    // Fungsi untuk mengecek panjang input form_name
    $('#form_name').on('input keyup keydown', function (e) {
        var maxLength = 50;
        var currentLength = $(this).val().length;
        
        // Memperbarui penghitung panjang karakter di tampilan
        $('#form_name_length').text(currentLength + '/' + maxLength);
        
        // Batasi input tepat di 50 karakter dan cegah tambahan input
        if (currentLength >= maxLength && e.key !== 'Backspace' && e.key !== 'Delete') {
            e.preventDefault();
            $(this).val($(this).val().substring(0, maxLength));
        }
    });
    // Fungsi untuk mengecek panjang input form_name
    $('#komentar').on('input keyup keydown', function (e) {
        var maxLength = 500;
        var currentLength = $(this).val().length;
        
        // Memperbarui penghitung panjang karakter di tampilan
        $('#komentar_length').text(currentLength + '/' + maxLength);
        
        // Batasi input tepat di 500 karakter dan cegah tambahan input
        if (currentLength >= maxLength && e.key !== 'Backspace' && e.key !== 'Delete') {
            e.preventDefault();
            $(this).val($(this).val().substring(0, maxLength));
        }
    });
    
    var count = 1; // Untuk melacak nomor alternatif

    // Ketika tombol TambahAlternatif ditekan
    $('#TambahAlternatif').on('click', function (e) {
        e.preventDefault(); // Mencegah halaman reload jika tombol di dalam form

        // HTML untuk form baru yang akan ditambahkan
        var alternatifHTML = `
            <div class="input-group mb-3" id="alternatif_display" data-id="${count}">
                <span class="input-group-text" id="AlternatifNumber">
                    <small><code class="text text-grayish"><i class="bi bi-check"></i></code></small>
                </span>
                <input type="text" name="alternatif_display[]" class="form-control" placeholder="Display">
                <input type="text" name="alternatif_value[]" class="form-control" placeholder="Value">
                <span class="input-group-text" id="AlternatifRemoveButton">
                    <a href="#" class="text-danger remove-alternatif" data-id="${count}">
                        <i class="bi bi-x-circle"></i>
                    </a>
                </span>
            </div>
        `;

        // Menambahkan elemen baru ke #AlternatifList
        $('#AlternatifList').append(alternatifHTML);
        count++; // Menambah nomor untuk alternatif berikutnya
    });

    // Event listener untuk menghapus form alternatif
    $('#AlternatifList').on('click', '.remove-alternatif', function (e) {
        e.preventDefault(); // Mencegah reload halaman
        $(this).closest('.input-group').remove(); // Menghapus elemen terkait
    });

    // Proses Tambah Assesment Form
    $('#ProsesTambahAssesmentForm').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonTambahAssesmentForm').html('<i class="bi bi-check"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Event/ProsesTambahAssesmentForm.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowAseesmentFormEvent();
                    $('#NotifikasiTambahAssesmentForm').html('');
                    $('#ProsesTambahAssesmentForm')[0].reset();
                    $('#ModalTambahAssesmentForm').modal('hide');
                    $('#ButtonTambahAssesmentForm').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Form berhasil ditambahkan', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiTambahAssesmentForm').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonTambahAssesmentForm').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiTambahAssesmentForm').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonTambahAssesmentForm').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    // Menampilkan Detail Assesment Form
    $('#ModalDetailAssesmentForm').on('show.bs.modal', function (e) {
        var id_event_assesment_form = $(e.relatedTarget).data('id');
        $('#FormDetailAssesmentForm').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/Event/FormDetailAssesmentForm.php',
            data        : { id_event_assesment_form: id_event_assesment_form },
            success     : function(data) {
                $('#FormDetailAssesmentForm').html(data);
            }
        });
    });
    // Menampilkan Form Edit Assesment Form
    $('#ModalEditAssesmentForm').on('show.bs.modal', function (e) {
        var id_event_assesment_form = $(e.relatedTarget).data('id');
        $('#FormEditAssesmentForm').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/Event/FormEditAssesmentForm.php',
            data        : { id_event_assesment_form: id_event_assesment_form },
            success     : function(data) {
                $('#FormEditAssesmentForm').html(data);
                $('#NotifikasiEditAssesmentForm').html('');
            }
        });
    });
    // Proses Edit Assesment Form
    $('#ProsesEditAssesmentForm').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonEditAssesmentForm').html('<i class="bi bi-check"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Event/ProsesEditAssesmentForm.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowAseesmentFormEvent();
                    $('#NotifikasiEditAssesmentForm').html('');
                    $('#ModalEditAssesmentForm').modal('hide');
                    $('#ButtonEditAssesmentForm').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Form Edit Assesment Form', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiEditAssesmentForm').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonEditAssesmentForm').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiEditAssesmentForm').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonEditAssesmentForm').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    // Menampilkan Form Hapus Assesment Form
    $('#ModalHapusAssesmentForm').on('show.bs.modal', function (e) {
        var id_event_assesment_form = $(e.relatedTarget).data('id');
        $('#FormHapusAssesmentForm').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/Event/FormHapusAssesmentForm.php',
            data        : { id_event_assesment_form: id_event_assesment_form },
            success     : function(data) {
                $('#FormHapusAssesmentForm').html(data);
                $('#NotifikasiHapusAssesmentForm').html('');
            }
        });
    });
    // Proses Hapus Assesment Form
    $('#ProsesHapusAssesmentForm').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonHapusAssesmentForm').html('<i class="bi bi-check"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Event/ProsesHapusAssesmentForm.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowAseesmentFormEvent();
                    $('#NotifikasiHapusAssesmentForm').html('');
                    $('#ModalHapusAssesmentForm').modal('hide');
                    $('#ButtonHapusAssesmentForm').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Form Assesment Berhasil Dihapus', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiHapusAssesmentForm').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonHapusAssesmentForm').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiHapusAssesmentForm').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonHapusAssesmentForm').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
            }
        });
    });
    // Menampilkan Form Assesment Peserta
    $('#ModalUbahAssesmentPeserta').on('show.bs.modal', function (e) {
        var id_event_peserta = $(e.relatedTarget).data('id');
        $('#FormUbahAssesmentPeserta').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/Event/FormUbahAssesmentPeserta.php',
            data        : { id_event_peserta: id_event_peserta },
            success     : function(data) {
                $('#FormUbahAssesmentPeserta').html(data);
                $('#NotifikasiUbahAssesmentPeserta').html('');
            }
        });
    });
    // Proses Ubah Assesment Peserta
    $('#ProsesUbahAssesmentPeserta').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonUbahAssesmentPeserta').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Event/ProsesUbahAssesmentPeserta.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowAssesmentPeserta();
                    $('#NotifikasiUbahAssesmentPeserta').html('');
                    $('#ModalUbahAssesmentPeserta').modal('hide');
                    $('#ButtonUbahAssesmentPeserta').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Form Assesment Berhasil Dihapus', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiUbahAssesmentPeserta').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonUbahAssesmentPeserta').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiUbahAssesmentPeserta').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonUbahAssesmentPeserta').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    // Menampilkan Modal Detail Assesment Peserta
    $('#ModalDetailAssesmentPeserta').on('show.bs.modal', function (e) {
        var id_event_assesment = $(e.relatedTarget).data('id');
        $('#FormDetailAssesmentPeserta').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/Event/FormDetailAssesmentPeserta.php',
            data        : { id_event_assesment: id_event_assesment },
            success     : function(data) {
                $('#FormDetailAssesmentPeserta').html(data);
            }
        });
    });
    // Menampilkan Status Assesment Peserta
    $('#ModalStatusAssesmentPeserta').on('show.bs.modal', function (e) {
        var id_event_assesment = $(e.relatedTarget).data('id');
        $('#FormStatusAssesmentPeserta').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/Event/FormStatusAssesmentPeserta.php',
            data        : { id_event_assesment: id_event_assesment },
            success     : function(data) {
                $('#FormStatusAssesmentPeserta').html(data);
                $('#NotifikasiStatusAssesmentPeserta').html('');
            }
        });
    });
    // Proses Status Assesment Peserta
    $('#ProsesStatusAssesmentPeserta').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonStatusAssesmentPeserta').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Event/ProsesStatusAssesmentPeserta.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowAssesmentPeserta();
                    $('#NotifikasiStatusAssesmentPeserta').html('');
                    $('#ModalStatusAssesmentPeserta').modal('hide');
                    $('#ButtonStatusAssesmentPeserta').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Form Assesment Berhasil Dihapus', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiStatusAssesmentPeserta').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonStatusAssesmentPeserta').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiStatusAssesmentPeserta').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonStatusAssesmentPeserta').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    // Menampilkan Form Hapus Assesment Peserta
    $('#ModalHapusAssesmentPeserta').on('show.bs.modal', function (e) {
        var id_event_assesment = $(e.relatedTarget).data('id');
        $('#FormHapusAssesmentPeserta').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/Event/FormHapusAssesmentPeserta.php',
            data        : { id_event_assesment: id_event_assesment },
            success     : function(data) {
                $('#FormHapusAssesmentPeserta').html(data);
                $('#NotifikasiHapusAssesmentPeserta').html('');
            }
        });
    });
    // Proses Hapus Assesment Peserta
    $('#ProsesHapusAssesmentPeserta').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonHapusAssesmentPeserta').html('<i class="bi bi-check"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Event/ProsesHapusAssesmentPeserta.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowAssesmentPeserta();
                    $('#NotifikasiHapusAssesmentPeserta').html('');
                    $('#ModalHapusAssesmentPeserta').modal('hide');
                    $('#ButtonHapusAssesmentPeserta').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Data Berhasil Dihapus', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiHapusAssesmentPeserta').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonHapusAssesmentPeserta').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiHapusAssesmentPeserta').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonHapusAssesmentPeserta').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
            }
        });
    });
    // Menampilkan Form Detail Transaksi
    $('#ModalDetailTransaksi').on('show.bs.modal', function (e) {
        var kode_transaksi = $(e.relatedTarget).data('id');
        $('#FormDetailTransaksi').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/Event/FormDetailTransaksi.php',
            data        : { kode_transaksi: kode_transaksi },
            success     : function(data) {
                $('#FormDetailTransaksi').html(data);
            }
        });
    });
    // Menampilkan Form Edit Transaksi
    $('#ModalEditTransaksi').on('show.bs.modal', function (e) {
        var kode_transaksi = $(e.relatedTarget).data('id');
        $('#FormEditTransaksi').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/Event/FormEditTransaksi.php',
            data        : { kode_transaksi: kode_transaksi },
            success     : function(data) {
                $('#FormEditTransaksi').html(data);
                $('#NotifikasiEditTransaksi').html('');
            }
        });
    });
    // Proses Edit Transaksi
    $('#ProsesEditTransaksi').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonEditTransaksi').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Event/ProsesEditTransaksi.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowRiwayatPembayaranEvent();
                    $('#NotifikasiEditTransaksi').html('');
                    $('#ModalEditTransaksi').modal('hide');
                    $('#ButtonEditTransaksi').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Edit Transaksi Peserta Event Berhasil', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiEditTransaksi').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonEditTransaksi').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiEditTransaksi').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonEditTransaksi').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    // Menampilkan Form Hapus Transaksi
    $('#ModalHapusTransaksi').on('show.bs.modal', function (e) {
        var kode_transaksi = $(e.relatedTarget).data('id');
        $('#FormHapusTransaksi').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/Event/FormHapusTransaksi.php',
            data        : { kode_transaksi: kode_transaksi },
            success     : function(data) {
                $('#FormHapusTransaksi').html(data);
                $('#NotifikasiHapusTransaksi').html('');
            }
        });
    });
    // Proses Hapus Transaksi
    $('#ProsesHapusTransaksi').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonHapusTransaksi').html('<i class="bi bi-check"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Event/ProsesHapusTransaksi.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowRiwayatPembayaranEvent();
                    $('#NotifikasiHapusTransaksi').html('');
                    $('#ModalHapusTransaksi').modal('hide');
                    $('#ButtonHapusTransaksi').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Edit Transaksi Peserta Event Berhasil', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiHapusTransaksi').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonHapusTransaksi').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiHapusTransaksi').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonHapusTransaksi').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
            }
        });
    });
    // Menampilkan Log Pembayaran
    $('#ModalLogPembayaran').on('show.bs.modal', function (e) {
        var kode_transaksi = $(e.relatedTarget).data('id');
        $('#FormLogPembayaran').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/Event/FormLogPembayaran.php',
            data        : { kode_transaksi: kode_transaksi },
            success     : function(data) {
                $('#FormLogPembayaran').html(data);
            }
        });
    });
});