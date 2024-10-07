$(document).ready(function() {
    var maxCharsTitle = 20;
    var maxCharsKeyword = 100;
    var maxCharsDesc = 500;
    var maxCharsContact = 20;
    var maxCharsAlamat = 500;
    // Fungsi untuk menghitung dan menampilkan jumlah karakter
    function updateCharCountTitle() {
        var charCount = $('#title_page').val().length;
        $('#title_page_length').text(charCount + '/' + maxCharsTitle);
    }
    function updateCharCountKeyword() {
        var charCount = $('#kata_kunci').val().length;
        $('#keyword_length').text(charCount + '/' + maxCharsKeyword);
    }
    function updateCharCountDesc() {
        var charCount = $('#deskripsi').val().length;
        $('#description_length').text(charCount + '/' + maxCharsDesc);
    }
    function updateCharCountContact() {
        var charCount = $('#telepon_bisnis').val().length;
        $('#contact_length').text(charCount + '/' + maxCharsContact);
    }
    function updateCharCountAlamat() {
        var charCount = $('#alamat_bisnis').val().length;
        $('#alamat_length').text(charCount + '/' + maxCharsAlamat);
    }

    // Hitung jumlah karakter saat pertama kali halaman dimuat
    updateCharCountTitle();
    updateCharCountKeyword();
    updateCharCountDesc();
    updateCharCountContact();
    updateCharCountAlamat();
    // Fungsi untuk mencegah input jika melebihi batas karakter
    $('#title_page').on('input', function() {
        var currentValue = $(this).val();
        var charCount = currentValue.length;
        // Cek apakah jumlah karakter melebihi
        if (charCount > maxCharsTitle) {
            // Jika melebihi, batasi input
            $(this).val(currentValue.substring(0, maxCharsTitle));
        }
        // Update tampilan jumlah karakter
        updateCharCountTitle();
    });
    $('#kata_kunci').on('input', function() {
        var currentValue = $(this).val();
        var charCount = currentValue.length;
        // Cek apakah jumlah karakter melebihi
        if (charCount > maxCharsKeyword) {
            // Jika melebihi, batasi input
            $(this).val(currentValue.substring(0, maxCharsKeyword));
        }
        // Update tampilan jumlah karakter
        updateCharCountKeyword();
    });
    $('#deskripsi').on('input', function() {
        var currentValue = $(this).val();
        var charCount = currentValue.length;
        // Cek apakah jumlah karakter melebihi
        if (charCount > maxCharsDesc) {
            // Jika melebihi, batasi input
            $(this).val(currentValue.substring(0, maxCharsDesc));
        }
        // Update tampilan jumlah karakter
        updateCharCountDesc();
    });
    $('#telepon_bisnis').on('input', function() {
        var currentValue = $(this).val();
        var charCount = currentValue.length;
        // Cek apakah jumlah karakter melebihi
        if (charCount > maxCharsContact) {
            // Jika melebihi, batasi input
            $(this).val(currentValue.substring(0, maxCharsContact));
        }
        // Hanya mengizinkan angka, simbol +, dan menghapus karakter selain itu
        var validValue = $(this).val().replace(/[^0-9+]/g, '');
        $(this).val(validValue);
        // Update tampilan jumlah karakter
        updateCharCountContact();
    });
    $('#alamat_bisnis').on('input', function() {
        var currentValue = $(this).val();
        var charCount = currentValue.length;
        // Cek apakah jumlah karakter melebihi
        if (charCount > maxCharsAlamat) {
            // Jika melebihi, batasi input
            $(this).val(currentValue.substring(0, maxCharsAlamat));
        }
        // Update tampilan jumlah karakter
        updateCharCountAlamat();
    });
    // Fungsi untuk validasi ukuran dan tipe file
    function validateFile(input, maxSize, allowedTypes, errorElementId) {
        var file = input.files[0];  // Mendapatkan file dari input
        var errorMessage = '';
        if (file) {
            // Cek ukuran file
            if (file.size > maxSize) {
                errorMessage = 'Ukuran file tidak boleh lebih dari ' + (maxSize / 1000000) + ' MB';
            }
            // Cek tipe file
            if (!allowedTypes.includes(file.type)) {
                errorMessage = 'Tipe file hanya boleh JPG, JPEG, PNG, dan GIF';
            }
        }
        if (errorMessage) {
            // Jika ada kesalahan, tampilkan pesan error dan return false
            $(errorElementId).html(errorMessage).removeClass('text-grayish').show();
            return false;
        } else {
            // Jika valid
            $(errorElementId).html('File siap diupload').addClass('text-success').show();
            return true;
        }
    }
    // Validasi Favicon
    $('#favicon').on('change', function() {
        var isValid = validateFile(this, 2000000, ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'], '#favicon-error');
        toggleSubmitButton();
    });
    // Validasi Logo
    $('#logo').on('change', function() {
        var isValid = validateFile(this, 2000000, ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'], '#logo-error');
        toggleSubmitButton();
    });
    // Fungsi untuk menonaktifkan/menaktifkan tombol submit
    function toggleSubmitButton() {
        var faviconValid = $('#favicon-error').text() === ''; // Cek apakah tidak ada error pada Favicon
        var logoValid = $('#logo-error').text() === ''; // Cek apakah tidak ada error pada Logo

        // Jika kedua file valid, aktifkan tombol submit, jika tidak, nonaktifkan tombol submit
        if (faviconValid && logoValid) {
            $('#submitButton').prop('disabled', false);
        } else {
            $('#submitButton').prop('disabled', true);
        }
    }
    // Inisialisasi dengan menonaktifkan tombol submit jika error muncul
    toggleSubmitButton();

    //Proses Simpan Setting
    $('#ProsesSettingGeneral').on('submit', function(e) {
        e.preventDefault(); // Mencegah form dari submit secara default
        // Mengambil data dari form
        var formData = new FormData(this);
        // Tombol diubah menjadi "Loading..." saat proses
        var $submitButton = $('#NotifikasiSimpanSettingGeneral');
        $submitButton.html('Loading...').prop('disabled', true);
        // Mengirimkan data melalui AJAX
        $.ajax({
            url: '_Page/SettingGeneral/ProsesSettingGeneral.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Jika proses berhasil, reload halaman
                    window.location.reload();
                } else {
                    // Tampilkan notifikasi error jika gagal
                    Swal.fire(
                        'Gagal!',
                        response.message,
                        'error'
                    )
                }
            },
            error: function() {
                // Tampilkan pesan jika terjadi kesalahan pada server
                Swal.fire(
                    'Gagal!',
                    'Terjadi kesalahan pada server, coba lagi nanti.',
                    'error'
                )
            },
            complete: function() {
                // Kembalikan tombol ke keadaan semula
                $submitButton.html('<i class="bi bi-save"></i> Simpan Pengaturan').prop('disabled', false);
            }
        });
    });
});

