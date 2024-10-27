//Fungsi Menampilkan Data Event
function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/Galeri/TabelGaleri.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanTabelGaleri').html(data);
        }
    });
}
//Menampilkan Data Pertama Kali
$(document).ready(function() {
    //Menampilkan Data Pertama kali
    filterAndLoadTable();
    //Ketika Keyword By Diubah
    $('#keyword_by').change(function(){
        var keyword_by =$('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Galeri/FormFilter.php',
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
    //Validasi Jumlah Karakter
    $('#album').on('input', function() {
        var value = $(this).val();
        var maxLength = 50;
        // Jika panjang melebihi batas, potong sesuai maxLength
        if (value.length > maxLength) {
            value = value.substring(0, maxLength);
        }
        // Update nilai input
        $(this).val(value); 
        // Tampilkan jumlah karakter saat ini
        $('#album_length').text(value.length + '/' + maxLength);
    });
    $('#nama_galeri').on('input', function() {
        var value = $(this).val();
        var maxLength = 100;
        // Jika panjang melebihi batas, potong sesuai maxLength
        if (value.length > maxLength) {
            value = value.substring(0, maxLength);
        }
        // Update nilai input
        $(this).val(value); 
        // Tampilkan jumlah karakter saat ini
        $('#nama_galeri_length').text(value.length + '/' + maxLength);
    });
    // Validasi file Foto
    $('#file_galeri').on('change', function() {
        var file = this.files[0];
        var validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        var maxSize = 5 * 1024 * 1024; // 2MB
        var validasiMessage = $('#ValidasiFileGaleri');

        if (file) {
            if ($.inArray(file.type, validTypes) == -1) {
                validasiMessage.text('Tipe file tidak valid. Hanya diperbolehkan jpeg, jpg, png, atau gif.').css('color', 'red');
                this.value = '';
            } else if (file.size > maxSize) {
                validasiMessage.text('Ukuran file maksimal 5 MB.').css('color', 'red');
                this.value = '';
            } else {
                validasiMessage.text('File sudah valid dan sesuai persyaratan.').css('color', 'green');
            }
        }
    });
    // Proses Tambah Galeri
    $('#ProsesTambahGaleri').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonTambahMedsos').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Galeri/ProsesTambahGaleri.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    filterAndLoadTable();
                    $('#ProsesTambahGaleri')[0].reset();
                    $('#ModalTambahGaleri').modal('hide');
                    $('#ButtonTambahGaleri').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#NotifikasiTambahGaleri').html('');
                    Swal.fire('Berhasil!', 'Tambah Galeri Berhasil', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiTambahGaleri').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonTambahGaleri').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiTambahGaleri').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonTambahGaleri').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    //Ketika Modal Detail Galeri
    $('#ModalDetailGaleri').on('show.bs.modal', function (e) {
        var id_web_galeri = $(e.relatedTarget).data('id');
        $('#FormDetailGaleri').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Galeri/FormDetailGaleri.php',
            data        : {id_web_galeri: id_web_galeri},
            success     : function(data){
                $('#FormDetailGaleri').html(data);
            }
        });
    });
    //Ketika Modal Edit Galeri
    $('#ModalEditGaleri').on('show.bs.modal', function (e) {
        var id_web_galeri = $(e.relatedTarget).data('id');
        $('#FormEditGaleri').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Galeri/FormEditGaleri.php',
            data        : {id_web_galeri: id_web_galeri},
            success     : function(data){
                $('#FormEditGaleri').html(data);
            }
        });
    });
    // Proses Edit Galeri
    $('#ProsesEditGaleri').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonEditGaleri').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Galeri/ProsesEditGaleri.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    filterAndLoadTable();
                    $('#ProsesEditGaleri')[0].reset();
                    $('#ModalEditGaleri').modal('hide');
                    $('#ButtonEditGaleri').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#NotifikasiEditGaleri').html('');
                    Swal.fire('Berhasil!', 'Edit Galeri Berhasil', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiEditGaleri').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonEditGaleri').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiEditGaleri').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonEditGaleri').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    //Ketika Modal Hapus Galeri
    $('#ModalHapusGaleri').on('show.bs.modal', function (e) {
        var id_web_galeri = $(e.relatedTarget).data('id');
        $('#FormHapusGaleri').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Galeri/FormHapusGaleri.php',
            data        : {id_web_galeri: id_web_galeri},
            success     : function(data){
                $('#FormHapusGaleri').html(data);
                $('#NotifikasiHapusGaleri').html('');
            }
        });
    });
    // Proses Hapus Galeri
    $('#ProsesHapusGaleri').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonHapusGaleri').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Galeri/ProsesHapusGaleri.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    filterAndLoadTable();
                    $('#ProsesHapusGaleri')[0].reset();
                    $('#ModalHapusGaleri').modal('hide');
                    $('#ButtonHapusGaleri').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                    $('#NotifikasiHapusGaleri').html('');
                    Swal.fire('Berhasil!', 'Hapus Data Berhasil', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiHapusGaleri').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonHapusGaleri').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiHapusGaleri').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonHapusGaleri').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
            }
        });
    });
});