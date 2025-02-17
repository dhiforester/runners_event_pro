//Fungsi Menampilkan Data Member
function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/Member/TabelMember.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanTabelMember').html(data);
        }
    });
}
function loadMemberData(endpoint, targetElement) {
    var id_member = $('#GetIdMember').val();
    if (id_member) { // Cek apakah id_member tidak kosong
        $.ajax({
            type: 'POST',
            url: '_Page/Member/' + endpoint + '.php',
            data: { id_member: id_member },
            success: function(data) {
                $(targetElement).html(data);
            },
            error: function(xhr, status, error) {
                // Menangani error jika permintaan AJAX gagal
                console.error('Error: ' + status + ' - ' + error);
                $(targetElement).html('<p>Terjadi kesalahan dalam memuat data.</p>');
            }
        });
    } else {
        // Jika id_member kosong, beri notifikasi atau kosongkan elemen target
        $(targetElement).html('<p>ID Member tidak tersedia.</p>');
    }
}

// Fungsi untuk memuat data yang berbeda
function ShowFotoMember() {
    loadMemberData('ShowFotoMember', '#ShowFotoMember');
}

function ShowDetailMember() {
    loadMemberData('ShowDetailMember', '#ShowDetailMember');
}
function ShowRiwayatEvent() {
    loadMemberData('ShowRiwayatEvent', '#ShowRiwayatEvent');
}
function ShowRiwayatPembelian() {
    loadMemberData('ShowRiwayatPembelian', '#ShowRiwayatPembelian');
}
function ShowRiwayatLogin() {
    var ProsesFilterRiwayatLogin = $('#ProsesFilterRiwayatLogin').serialize();

    // Ajax untuk menampilkan grafik dengan ApexCharts
    $.ajax({
        type: 'POST',
        url: '_Page/Member/ShowGrafikRiwayatLogin.php',
        data: ProsesFilterRiwayatLogin,
        dataType: 'json', // Pastikan server mengirimkan data dalam format JSON
        success: function(data) {
            // Konfigurasi grafik ApexCharts
            var options = {
                chart: {
                    type: 'line', // Tipe grafik: line, bar, area, dll.
                    height: 350
                },
                title: {
                    text: 'Grafik Riwayat Login',
                    align: 'center'
                },
                xaxis: {
                    categories: data.labels // Label kategori dari server
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Login'
                    }
                },
                series: [{
                    name: 'Login',
                    data: data.values // Data nilai dari server
                }]
            };

            // Render grafik
            var chart = new ApexCharts(document.querySelector("#ShowGrafikRiwayatLogin"), options);
            chart.render();
        },
        error: function(xhr, status, error) {
            console.error('Error loading chart data:', error);
        }
    });

    // Ajax untuk menampilkan riwayat login
    $.ajax({
        type: 'POST',
        url: '_Page/Member/ShowRiwayatLogin.php',
        data: ProsesFilterRiwayatLogin,
        success: function(data) {
            $('#ShowRiwayatLogin').html(data);
        }
    });
}


function updateCharacterLength(inputSelector, lengthSelector, maxLength) {
    $(inputSelector).on('input', function() {
        var value = $(this).val();
        var length = value.length;

        // Validasi berdasarkan inputSelector
        if (inputSelector === "#nama") {
            // Hanya boleh huruf dan spasi
            value = value.replace(/[^a-zA-Z\s]/g, '');
        } else if (inputSelector === "#kontak" || inputSelector === "#kode_pos") {
            // Hanya boleh angka
            value = value.replace(/[^0-9]/g, '');
        } else if (inputSelector === "#password") {
            // Hanya boleh huruf dan angka
            value = value.replace(/[^a-zA-Z0-9]/g, '');
        } else if (inputSelector === "#email_validation") {
            // Hanya boleh huruf dan angka
            value = value.replace(/[^a-zA-Z0-9]/g, '');
        }

        // Jika panjang melebihi batas, potong sesuai maxLength
        if (length > maxLength) {
            value = value.substring(0, maxLength);
            $(this).val(value); // Update nilai input
            length = maxLength; // Pastikan panjang sesuai maxLength
        } else {
            $(this).val(value); // Update nilai input
        }

        // Tampilkan jumlah karakter saat ini
        $(lengthSelector).text(length + '/' + maxLength);
    });
}
//Menampilkan Data Pertama Kali
$(document).ready(function() {
    //Menampilkan Data Pertama kali
    filterAndLoadTable();
    ShowFotoMember();
    ShowDetailMember();
    ShowRiwayatEvent();
    ShowRiwayatPembelian();
    //Ketika Keyword By Di Ubah
    $('#keyword_by').change(function(){
        var keyword_by =$('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Member/FormFilter.php',
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
    // Panggil fungsi updateCharacterLength untuk masing-masing input
    updateCharacterLength('#nama', '#nama_length', 100);
    updateCharacterLength('#kontak', '#kontak_length', 20);
    updateCharacterLength('#email', '#email_length', 100);
    updateCharacterLength('#password', '#password_length', 20);
    updateCharacterLength('#kode_pos', '#kode_pos_length', 10);
    updateCharacterLength('#rt_rw', '#rt_rw_length', 50);
    updateCharacterLength('#email_validation', '#email_validation_length', 9);
    
    // Event untuk klik pada provinsi
    $('#inputGroupPrependProvinsi').click(function() {
        $('#provinsi').focus();
    });

    // Event untuk klik pada kabupaten
    $('#inputGroupPrependKabupaten').click(function() {
        $('#kabupaten').focus();
    });

    // Event untuk klik pada kecamatan
    $('#inputGroupPrependKecamatan').click(function() {
        $('#kecamatan').focus();
    });

    // Event untuk klik pada desa
    $('#inputGroupPrependDesa').click(function() {
        $('#desa').focus();
    });
    // Reload Kabupaten, Kecamatan, dan Desa
    $('#provinsi').on('change', function() {
        var provinsiId = $(this).val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Member/ListKabupaten.php',
            data        : {provinsi: provinsiId},
            success     : function(data){
                $('#kabupaten').html(data);
            }
        });
        $('#kecamatan').html('<option value="">Pilih</option>');
        $('#desa').html('<option value="">Pilih</option>');
    });

    $('#kabupaten').on('change', function() {
        var provinsi =$('#provinsi').val();
        var kabupaten = $(this).val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Member/ListKecamatan.php',
            data        : {provinsi: provinsi, kabupaten: kabupaten},
            success     : function(data){
                $('#kecamatan').html(data);
            }
        });
        $('#desa').html('<option value="">Pilih</option>');
    });

    $('#kecamatan').on('change', function() {
        var provinsi =$('#provinsi').val();
        var kabupaten =$('#kabupaten').val();
        var kecamatan = $(this).val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Member/ListDesa.php',
            data        : {provinsi: provinsi, kabupaten: kabupaten, kecamatan: kecamatan},
            success     : function(data){
                $('#desa').html(data);
            }
        });
    });

    // Generate email validation code
    $('#GenerateEmailValidationCode').on('click', function() {
        var randomCode = Math.random().toString(36).substring(2, 11);
        $('#email_validation').val(randomCode);
    });

    // Tampilkan/hide password
    $('#TampilkanPassword').on('change', function() {
        if ($(this).is(':checked')) {
            $('#password').attr('type', 'text');
        } else {
            $('#password').attr('type', 'password');
        }
    });
    // Validasi file foto
    $('#foto').on('change', function() {
        var file = this.files[0];
        var validTypes = ['image/jpeg', 'image/png', 'image/gif'];
        var maxSize = 5 * 1024 * 1024; // 2MB
        var validasiMessage = $('#ValidasiFileFoto');

        if (file) {
            if ($.inArray(file.type, validTypes) == -1) {
                validasiMessage.text('Tipe file tidak valid. Hanya diperbolehkan jpeg, png, atau gif.').css('color', 'red');
                this.value = '';
            } else if (file.size > maxSize) {
                validasiMessage.text('Ukuran file maksimal 5MB.').css('color', 'red');
                this.value = '';
            } else {
                validasiMessage.text('File valid.').css('color', 'green');
            }
        }
    });

    //Proses Tambah Member
    $('#ProsesTambahMember').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonTambahMember').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/Member/ProsesTambahMember.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonTambahMember').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiTambahMember').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    $('#page').val("1");
                    $("#ProsesFilter")[0].reset();
                    $('#ButtonTambahMember').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#ProsesTambahMember').trigger('reset');
                    $('#ModalTambahMember').modal('hide');
                    $('#NotifikasiTambahMember').html('');
                    filterAndLoadTable();
                    Swal.fire('Berhasil!', 'Event Berhasil Ditambahkan', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiTambahMember').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonTambahEvent').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiTambahMember').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    

    //Ketika Modal Detail Member
    $('#ModalDetailMember').on('show.bs.modal', function (e) {
        var id_member = $(e.relatedTarget).data('id');
        $('#FormDetailMember').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Member/FormDetailMember.php',
            data        : {id_member: id_member},
            success     : function(data){
                $('#FormDetailMember').html(data);
            }
        });
    });
    //Ketika Modal Edit Member Muncul
    $('#ModalEditMember').on('show.bs.modal', function (e) {
        var id_member = $(e.relatedTarget).data('id');
        $('#FormEditMember').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Member/FormEditMember.php',
            data        : {id_member: id_member},
            success     : function(data){
                $('#FormEditMember').html(data);
                $('#NotifikasiEditMember').html('');
            }
        });
    });
    //Proses Edit Member
    $('#ProsesEditMember').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonEditMember').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/Member/ProsesEditMember.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonEditMember').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;

                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiEditMember').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }

                if (result.success) {
                    $('#NotifikasiEditMember').html('');
                    filterAndLoadTable();
                    ShowDetailMember();
                    Swal.fire('Berhasil!', 'Member Berhasil Diupdate', 'success');
                    $('#ModalEditMember').modal('hide');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiEditMember').html('<div class="alert alert-danger">' + result.message + '</div>');
                }
            },
            error: function () {
                $('#ButtonEditMember').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiEditMember').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Ketika Modal Ubah Password Member
    $('#ModalUbahPasswordMember').on('show.bs.modal', function (e) {
        var id_member = $(e.relatedTarget).data('id');
        $('#FormUbahPasswordMember').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Member/FormUbahPasswordMember.php',
            data        : {id_member: id_member},
            success     : function(data){
                $('#FormUbahPasswordMember').html(data);
                $('#NotifikasiUbahPasswordMember').html('');
            }
        });
    });
    //Proses Ubah Password
    $('#ProsesUbahPasswordMember').on('submit', function(e) {
        e.preventDefault(); // Perbaiki di sini
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonUbahPasswordMember').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url: '_Page/Member/ProsesUbahPasswordMember.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    filterAndLoadTable();
                    // Tutup Modal
                    $('#ModalUbahPasswordMember').modal('hide');
                    $('#ButtonUbahPasswordMember').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Password Member Berhasil Diupdate', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiUbahPasswordMember').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonUbahPasswordMember').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiUbahPasswordMember').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonUbahPasswordMember').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    //Ketika Modal Ubah Foto
    $('#ModalUbahFoto').on('show.bs.modal', function (e) {
        var id_member = $(e.relatedTarget).data('id');
        $('#FormUbahFoto').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Member/FormUbahFoto.php',
            data        : {id_member: id_member},
            success     : function(data){
                $('#FormUbahFoto').html(data);
                $('#NotifikasiUbahFoto').html('');
            }
        });
    });
    //Proses Ubah Foto
    $('#ProsesUbahFotoMember').on('submit', function(e) {
        e.preventDefault(); // Perbaiki di sini
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonUbahFoto').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url: '_Page/Member/ProsesUbahFotoMember.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    filterAndLoadTable();
                    ShowFotoMember();
                    // Tutup Modal
                    $('#ModalUbahFoto').modal('hide');
                    $('#ButtonUbahFoto').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Foto Member Berhasil Diupdate', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiUbahFotoMember').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonUbahFoto').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiUbahFotoMember').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonUbahFoto').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    //Ketika Modal Hapus Member Muncul
    $('#ModalHapusMember').on('show.bs.modal', function (e) {
        var id_member = $(e.relatedTarget).data('id');
        $('#FormHapusMember').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Member/FormHapusMember.php',
            data        : {id_member: id_member},
            success     : function(data){
                $('#FormHapusMember').html(data);
                $('#NotifikasiHapusMember').html('');
            }
        });
    });
    //Proses Hapus Member
    $('#ProsesHapusMember').submit(function(){
        $('#NotifikasiHapusMember').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var ProsesHapusMember = $('#ProsesHapusMember').serialize();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Member/ProsesHapusMember.php',
            data 	    :  ProsesHapusMember,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiHapusMember').html(data);
                var NotifikasiHapusMemberBerhasil=$('#NotifikasiHapusMemberBerhasil').html();
                if(NotifikasiHapusMemberBerhasil=="Success"){
                    $("#ProsesHapusMember")[0].reset();
                    $('#ModalHapusMember').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Hapus Member Berhasil!',
                        'success'
                    )
                    //Menampilkan Data
                    filterAndLoadTable();
                }
            }
        });
    });
});
//Ketika Modal Detail Peserta Event
$('#ModalDetailEventPeserta').on('show.bs.modal', function (e) {
    var id_event_peserta = $(e.relatedTarget).data('id');
    $('#FormDetailEventPeserta').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Member/FormDetailEventPeserta.php',
        data        : {id_event_peserta: id_event_peserta},
        success     : function(data){
            $('#FormDetailEventPeserta').html(data);
        }
    });
});
//Ketika Modal Detail Muncul
$('#ModalDetailTransaksi').on('show.bs.modal', function (e) {
    var kode_transaksi = $(e.relatedTarget).data('id');
    $('#FormDetailTransaksi').html("Loading...");
    $.ajax({
        type        : 'POST',
        url         : '_Page/TransaksiPenjualan/FormDetail.php',
        data        : { kode_transaksi: kode_transaksi },
        success     : function(data) {
            $('#FormDetailTransaksi').html(data);
        }
    });
});

//Menangkap id_member
$(document).ready(function() {
    // Menangkap id_member
    var GetIdMember = $('#GetIdMember').val();

    if (GetIdMember !== "") {
        // Tempelkan id_member ke dalam form
        $('#PutIdMemberFilter').val(GetIdMember);

        // Fungsi untuk mengatur visibilitas form bulan berdasarkan periode
        function toggleFormBulan() {
            var periode_riwayat = $('#periode_riwayat').val();
            if (periode_riwayat === "Bulanan") {
                $('#FormBulan').hide(); // Sembunyikan form bulan
            } else {
                $('#FormBulan').show(); // Tampilkan form bulan
            }
        }

        // Jalankan fungsi saat halaman pertama kali dimuat
        toggleFormBulan();

        // Event listener untuk perubahan pada periode_riwayat
        $('#periode_riwayat').on('change', function() {
            toggleFormBulan();
        });

        // Menampilkan data pertama kali
        ShowRiwayatLogin();
        //Event Submit
        $('#ProsesFilterRiwayatLogin').submit(function(){
            $('#ShowGrafikRiwayatLogin').html('Loading...');
            $('#ShowRiwayatLogin').html('Loading...');
            ShowRiwayatLogin();
            //Tutup Modal
            $('#ModalFilterRiwayatLogin').modal('hide');
        });
    }
});
