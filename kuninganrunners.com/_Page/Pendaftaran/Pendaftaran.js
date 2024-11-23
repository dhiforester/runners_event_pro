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
    updateCharacterLength('#password', '#password_length', 20);
    updateCharacterLength('#kode_pos', '#kode_pos_length', 10);
    updateCharacterLength('#rt_rw', '#rt_rw_length', 50);
    $('#ReloadCaptcha').click(function() {
        var $captchaImg = $('img[src*="Captcha.php"]');
        if ($captchaImg.length) {
            var src = $captchaImg.attr('src');
            $captchaImg.attr('src', src.split('?')[0] + '?' + new Date().getTime());
        }
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
    // Proses Pendaftaran
    $('#ProsesPendaftaran').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonPendaftaran').html('Loading...').prop('disabled', true);

        $.ajax({
            url: '_Page/Pendaftaran/ProsesPendaftaran.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonPendaftaran').html('<i class="bi bi-send"></i> Kirim Pendaftaran').prop('disabled', false);
                var result;
                try {
                    // Mencoba untuk parse JSON
                    result = JSON.parse(response);
                } catch (e) {
                    $('#NotifikasiPendaftaran').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    // Keluar dari fungsi jika JSON tidak valid
                    return;
                }

                if (result.code === 200) {
                    // Apabila berhasil, lakukan redirect
                    var email=result.email;
                    window.location.href = "index.php?Page=Pendaftaran-Berhasil&email="+ encodeURIComponent(email);
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiPendaftaran').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonPendaftaran').html('<i class="bi bi-send"></i> Kirim Pendaftaran').prop('disabled', false);
                $('#NotifikasiPendaftaran').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    // Proses Verifikasi Akun
    $('#ProsesVerifikasiAkun').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonVerifikasiAkun').html('Loading...').prop('disabled', true);

        $.ajax({
            url             : '_Page/Pendaftaran/ProsesVerifikasiAkun.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            success: function (response) {
                $('#ButtonVerifikasiAkun').html('<i class="bi bi-check-circle"></i> Konfirmasi Kode').prop('disabled', false);
                var result;
                try {
                    // Mencoba untuk parse JSON
                    result = JSON.parse(response);
                } catch (e) {
                    $('#NotifikasiVerifikasiAkun').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    // Keluar dari fungsi jika JSON tidak valid
                    return;
                }
                if (result.code === 200) {
                    // Apabila berhasil, lakukan redirect
                    window.location.href = "index.php?Page=Selesai";
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiVerifikasiAkun').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonVerifikasiAkun').html('<i class="bi bi-check-circle"></i> Konfirmasi Kode').prop('disabled', false);
                $('#NotifikasiVerifikasiAkun').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    // Proses Kirim Ulang Kode Verifikasi
    $('#ButtonKirimUlangKode').on('click', function (e) {
        e.preventDefault();
        var formData = new FormData($('#ProsesVerifikasiAkun')[0]); // Pastikan ID form benar
        $('#ButtonKirimUlangKode').html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...').prop('disabled', true);
    
        $.ajax({
            url: '_Page/Pendaftaran/ProsesKirimUlangKode.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonKirimUlangKode').html('<i class="bi bi-send"></i> Kirim Ulang Kode').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response);
                    if (!result || typeof result.code === 'undefined' || typeof result.message === 'undefined') {
                        throw new Error('Respons tidak valid');
                    }
                } catch (e) {
                    $('#NotifikasiVerifikasiAkun').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return;
                }
    
                if (result.code === 200) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Kode verifikasi berhasil dikirim ulang.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                } else {
                    $('#NotifikasiVerifikasiAkun').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function (xhr, status, error) {
                $('#ButtonKirimUlangKode').html('<i class="bi bi-send"></i> Kirim Ulang Kode').prop('disabled', false);
                $('#NotifikasiVerifikasiAkun').html('<div class="alert alert-danger">Terjadi kesalahan: ' + xhr.status + ' ' + xhr.statusText + '</div>');
            }
        });
    });
});