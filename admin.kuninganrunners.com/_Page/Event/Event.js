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
//Menampilkan Data Pertama Kali
$(document).ready(function() {
    //Menampilkan Data Pertama kali
    filterAndLoadTable();
    //Menampilkan Properti Detail Event
    ShowPosterEvent();
    ShowDetailEvent();
    ShowRuteEvent();
    ShowKategoriEvent();
    ShowPesertaEvent();

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
    
});