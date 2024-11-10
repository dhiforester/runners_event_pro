//Kondisi saat tampilkan password
$('#tampilkan_password').click(function(){
    if($(this).is(':checked')){
        $('#password').attr('type','text');
    }else{
        $('#password').attr('type','password');
    }
});
// Proses Login
$('#ProsesLogin').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $('#ButtonLogin').html('Loading...').prop('disabled', true);

    $.ajax({
        url             : '_Page/Login/ProsesLogin.php',
        type            : 'POST',
        data            : formData,
        contentType     : false,
        processData     : false,
        success: function (response) {
            $('#ButtonLogin').html('<i class="bi bi-key"></i> Login').prop('disabled', false);
            var result;
            try {
                // Mencoba untuk parse JSON
                result = JSON.parse(response);
            } catch (e) {
                $('#NotifikasiLogin').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                // Keluar dari fungsi jika JSON tidak valid
                return;
            }
            if (result.code === 200) {
                // Apabila berhasil, lakukan redirect
                window.location.href = "index.php?Page=LoginBerhasil";
            } else {
                // Menampilkan pesan kesalahan dari server
                $('#NotifikasiLogin').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
            }
        },
        error: function () {
            $('#ButtonLogin').html('<i class="bi bi-key"></i> Login').prop('disabled', false);
            $('#NotifikasiLogin').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
        }
    });
});