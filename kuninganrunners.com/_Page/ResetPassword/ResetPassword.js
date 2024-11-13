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
updateCharacterLength('#password', '#password_length', 20);
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
// Proses Reset Password
$('#ProsesResetPassword').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $('#ButtonResetPassword').html('Loading...').prop('disabled', true);

    $.ajax({
        url: '_Page/ResetPassword/ProsesResetPassword.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#ButtonResetPassword').html('<i class="bi bi-send"></i> Kirim Permintaan').prop('disabled', false);
            var result;
            try {
                // Mencoba untuk parse JSON
                result = JSON.parse(response);
            } catch (e) {
                $('#NotifikasiResetPassword').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                // Keluar dari fungsi jika JSON tidak valid
                return;
            }

            if (result.code === 200) {
                // Apabila berhasil, lakukan redirect
                var email=result.email;
                window.location.href = "index.php?Page=PermintaanResetPasswordBerhasil";
            } else {
                // Menampilkan pesan kesalahan dari server
                $('#NotifikasiResetPassword').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
            }
        },
        error: function () {
            $('#ButtonResetPassword').html('<i class="bi bi-send"></i> Kirim Permintaan').prop('disabled', false);
            $('#NotifikasiResetPassword').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
        }
    });
});
// Proses Ubah Password
$('#ProsesUbahPassword').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $('#ButtonResetPassword').html('Loading...').prop('disabled', true);

    $.ajax({
        url: '_Page/ResetPassword/ProsesUbahPassword.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
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
                var email=result.email;
                window.location.href = "index.php?Page=UbahPasswordBerhasil";
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