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
$(document).ready(function() {
    // Panggil fungsi updateCharacterLength untuk masing-masing input
    updateCharacterLength('#nama', '#nama_length', 100);
    updateCharacterLength('#kontak', '#kontak_length', 20);
    updateCharacterLength('#email', '#email_length', 100);
    updateCharacterLength('#kode_pos', '#kode_pos_length', 10);
    updateCharacterLength('#rt_rw', '#rt_rw_length', 50);
    updateCharacterLength('#password', '#password_length', 20);
    //Kondisi Awal
    var GetProvinsi = $('#GetProvinsi').html();
    var GetKabupaten = $('#GetKabupaten').html();
    var GetKecamatan = $('#GetKecamatan').html();
    var GetDesa = $('#GetDesa').html();
    var id_propinsi = $('#provinsi').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Profil/ListKabupaten.php',
        data        : {id_propinsi: id_propinsi, GetKabupaten: GetKabupaten},
        success     : function(data){
            $('#kabupaten').html(data);
            var id_kabupaten = $('#kabupaten').val();
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Profil/ListKecamatan.php',
                data        : {id_kabupaten: id_kabupaten, GetKecamatan: GetKecamatan},
                success     : function(data){
                    $('#kecamatan').html(data);
                    var id_kecamatan = $('#kecamatan').val();
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/Profil/ListDesa.php',
                        data        : {id_kecamatan: id_kecamatan, GetDesa: GetDesa},
                        success     : function(data){
                            $('#desa').html(data);
                        }
                    });
                }
            });
        }
    });
    // Reload Kabupaten, Kecamatan, dan Desa
    $('#provinsi').on('change', function() {
        var id_propinsi = $(this).val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Pendaftaran/ListKabupaten.php',
            data        : {id_propinsi: id_propinsi},
            success     : function(data){
                $('#kabupaten').html(data);
            }
        });
        $('#kecamatan').html('<option value="">Pilih</option>');
        $('#desa').html('<option value="">Pilih</option>');
    });

    $('#kabupaten').on('change', function() {
        var id_kabupaten = $(this).val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Pendaftaran/ListKecamatan.php',
            data        : {id_kabupaten: id_kabupaten},
            success     : function(data){
                $('#kecamatan').html(data);
            }
        });
        $('#desa').html('<option value="">Pilih</option>');
    });

    $('#kecamatan').on('change', function() {
        var id_kecamatan = $(this).val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Pendaftaran/ListDesa.php',
            data        : {id_kecamatan: id_kecamatan},
            success     : function(data){
                $('#desa').html(data);
            }
        });
    });
    // Proses Ubah Foto Profil
    $('#ProsesUbahFotoProfil').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonUbahFotoProfil').html('Loading...').prop('disabled', true);

        $.ajax({
            url             : '_Page/Profil/ProsesUbahFotoProfil.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            success: function (response) {
                $('#ButtonUbahFotoProfil').html('<i class="bi bi-upload"></i> Upload').prop('disabled', false);
                var result;
                try {
                    // Mencoba untuk parse JSON
                    result = JSON.parse(response);
                } catch (e) {
                    $('#NotifikasiUbahFotoProfil').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    // Keluar dari fungsi jika JSON tidak valid
                    return;
                }
                if (result.code === 200) {
                    // Apabila berhasil, lakukan redirect
                    window.location.href = "index.php?Page=Profil";
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiUbahFotoProfil').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonUbahFotoProfil').html('<i class="bi bi-upload"></i> Upload').prop('disabled', false);
                $('#NotifikasiUbahFotoProfil').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    // Proses Ubah Profil
    $('#ProsesUbahProfil').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonUbahProfil').html('Loading...').prop('disabled', true);

        $.ajax({
            url             : '_Page/Profil/ProsesUbahProfil.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            success: function (response) {
                $('#ButtonUbahProfil').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;
                try {
                    // Mencoba untuk parse JSON
                    result = JSON.parse(response);
                } catch (e) {
                    $('#NotifikasiUbahProfil').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    // Keluar dari fungsi jika JSON tidak valid
                    return;
                }
                if (result.code === 200) {
                    // Apabila berhasil, lakukan redirect
                    window.location.href = "index.php?Page=Profil";
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiUbahProfil').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonUbahProfil').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiUbahProfil').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Kondisi saat tampilkan password
    $('#tampilkan_password').click(function(){
        if($(this).is(':checked')){
            $('#password').attr('type','text');
            $('#ulangi_password').attr('type','text');
        }else{
            $('#password').attr('type','password');
            $('#ulangi_password').attr('type','password');
        }
    });
    // Proses Ubah Password
    $('#ProsesUbahPassword').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonUbahPassword').html('Loading...').prop('disabled', true);

        $.ajax({
            url             : '_Page/Profil/ProsesUbahPassword.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            success: function (response) {
                $('#ButtonUbahPassword').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;
                try {
                    // Mencoba untuk parse JSON
                    result = JSON.parse(response);
                } catch (e) {
                    $('#NotifikasiUbahPassword').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    // Keluar dari fungsi jika JSON tidak valid
                    return;
                }
                if (result.code === 200) {
                    // Apabila berhasil, lakukan redirect
                    window.location.href = "_Page/Profil/Logout.php";
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiUbahPassword').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonUbahPassword').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiUbahPassword').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    $('#testimoni').on('input', function () {
        const maxLength = 500; // Batas maksimum karakter
        const textLength = $(this).val().length; // Panjang teks saat ini
        const textRemaining = maxLength - textLength; // Sisa karakter yang diizinkan
        // Perbarui elemen id="testimoni_length"
        $('#testimoni_length').text(`${textLength}/${maxLength}`);

        // Jika panjang teks melebihi batas, potong ke maksimum karakter
        if (textLength > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
            $('#testimoni_length').text(`${maxLength}/${maxLength}`);
        }
    });
    // Proses Kirim Testimoni
    $('#ProsesKirimTestimoni').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonKirimTestimoni').html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...').prop('disabled', true);
    
        $.ajax({
            url: '_Page/Profil/ProsesKirimTestimoni.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonKirimTestimoni').html('<i class="bi bi-send"></i> Kirim').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response);
                    if (!result || typeof result.code === 'undefined' || typeof result.message === 'undefined') {
                        throw new Error('Respons tidak valid');
                    }
                } catch (e) {
                    $('#NotifikasiKirimTestimoni').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return;
                }
                if (result.code === 200) {
                    //Tutup Modal
                    $('#ModalKirimTestimoni').modal('hide');
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Testimoni berhasil dikirim.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Reload halaman setelah SweetAlert ditutup
                        location.reload();
                    });
                } else {
                    $('#NotifikasiKirimTestimoni').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function (xhr, status, error) {
                $('#ButtonKirimTestimoni').html('<i class="bi bi-send"></i> Kirim').prop('disabled', false);
                $('#NotifikasiKirimTestimoni').html('<div class="alert alert-danger">Terjadi kesalahan: ' + xhr.status + ' ' + xhr.statusText + '</div>');
            }
        });
    });
});
