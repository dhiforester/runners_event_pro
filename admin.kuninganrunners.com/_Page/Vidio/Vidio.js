//Fungsi Menampilkan Data Event
function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/Vidio/TabelVidio.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanTabelVidio').html(data);
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
            url 	    : '_Page/Vidio/FormFilter.php',
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
    $('#judul').on('input', function() {
        var value = $(this).val();
        var maxLength = 100;
        // Jika panjang melebihi batas, potong sesuai maxLength
        if (value.length > maxLength) {
            value = value.substring(0, maxLength);
        }
        // Update nilai input
        $(this).val(value); 
        // Tampilkan jumlah karakter saat ini
        $('#judul_length').text(value.length + '/' + maxLength);
    });
    $('#deskripsi').on('input', function() {
        var value = $(this).val();
        var maxLength = 250;
        // Jika panjang melebihi batas, potong sesuai maxLength
        if (value.length > maxLength) {
            value = value.substring(0, maxLength);
        }
        // Update nilai input
        $(this).val(value); 
        // Tampilkan jumlah karakter saat ini
        $('#deskripsi_length').text(value.length + '/' + maxLength);
    });
    //Ketika Sumber Vidio Diubah
    var sumber_vidio=$('#sumber_vidio').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Vidio/vidio_form.php',
        data        : {sumber_vidio: sumber_vidio},
        success     : function(data){
            $('#vidio_form').html(data);
        }
    });
    $('#sumber_vidio').on('change', function() {
        var sumber_vidio=$('#sumber_vidio').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Vidio/vidio_form.php',
            data        : {sumber_vidio: sumber_vidio},
            success     : function(data){
                $('#vidio_form').html(data);
            }
        });
    });
    // Validasi file Cuplikan
    $('#thumbnail').on('change', function() {
        var file = this.files[0];
        var validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        var maxSize = 1 * 1024 * 1024; // 2MB
        var validasiMessage = $('#ValidasiFileThumbnail');

        if (file) {
            if ($.inArray(file.type, validTypes) == -1) {
                $('#ValidasiFileThumbnail').html('<code class="text text-danger">Tipe file tidak valid. Hanya diperbolehkan JPEG, JPG, PNG dan GIF</code>');
                this.value = '';
            } else if (file.size > maxSize) {
                $('#ValidasiFileThumbnail').html('<code class="text text-danger">Ukuran file maksimal 1 MB.</code>');
                this.value = '';
            } else {
                $('#ValidasiFileThumbnail').html('<code class="text text-success">File sudah valid dan sesuai persyaratan.</code>');
            }
        }
    });
    // Proses Tambah Vidio
    $('#ProsesTambahVidio').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonTambahVidio').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Vidio/ProsesTambahVidio.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    $('#ProsesFilter')[0].reset();
                    $('#page').val('1');
                    $('#ProsesTambahVidio')[0].reset();
                    $('#ModalTambahVidio').modal('hide');
                    $('#ButtonTambahVidio').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#NotifikasiTambahVidio').html('');
                    $('#ValidasiFileThumbnail').html('<code class="text text-grayish">File yang digunakan maksimal 1 MB (JPEG, JPG, PNG, GIF)</code>');
                    $('#judul_length').html('0/100');
                    $('#deskripsi_length').html('0/250');

                    //Kembalikan Form Vidio
                    var sumber_vidio=$('#sumber_vidio').val();
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/Vidio/vidio_form.php',
                        data        : {sumber_vidio: sumber_vidio},
                        success     : function(data){
                            $('#vidio_form').html(data);
                        }
                    });
                    //Tampilkan Swal
                    Swal.fire('Berhasil!', 'Tambah Vidio Berhasil', 'success');
                    //Buka Ulang Data
                    filterAndLoadTable();
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiTambahVidio').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonTambahVidio').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiTambahVidio').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonTambahVidio').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    //Ketika Modal Detail
    $('#ModalDetail').on('show.bs.modal', function (e) {
        var id_web_vidio = $(e.relatedTarget).data('id');
        $('#FormDetail').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Vidio/FormDetail.php',
            data        : {id_web_vidio: id_web_vidio},
            success     : function(data){
                $('#FormDetail').html(data);
            }
        });
    });
    $('#ModalDetail').on('hidden.bs.modal', function (e) {
        // Kosongkan konten form detail
        $('#FormDetail').html(""); 
    });
    //Ketika Modal Edit
    $('#ModalEdit').on('show.bs.modal', function (e) {
        var id_web_vidio = $(e.relatedTarget).data('id');
        $('#FormEdit').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Vidio/FormEdit.php',
            data        : {id_web_vidio: id_web_vidio},
            success     : function(data){
                $('#FormEdit').html(data);
            }
        });
    });
    // Proses Edit
    $('#ProsesEdit').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonEdit').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Vidio/ProsesEdit.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    filterAndLoadTable();
                    $('#ProsesEdit')[0].reset();
                    $('#ModalEdit').modal('hide');
                    $('#ButtonEdit').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#NotifikasiEdit').html('');
                    Swal.fire('Berhasil!', 'Edit Vidio Berhasil', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiEdit').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonEdit').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiEdit').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonEdit').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    //Ketika Modal Hapus
    $('#ModalHapus').on('show.bs.modal', function (e) {
        var id_web_vidio = $(e.relatedTarget).data('id');
        $('#FormHapus').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Vidio/FormHapus.php',
            data        : {id_web_vidio: id_web_vidio},
            success     : function(data){
                $('#FormHapus').html(data);
                $('#NotifikasiHapus').html('');
            }
        });
    });
    // Proses Hapus
    $('#ProsesHapus').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonHapus').html('<i class="bi bi-check"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Vidio/ProsesHapus.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    filterAndLoadTable();
                    $('#ProsesHapus')[0].reset();
                    $('#ModalHapus').modal('hide');
                    $('#ButtonHapus').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                    $('#NotifikasiHapus').html('');
                    Swal.fire('Berhasil!', 'Hapus Data Berhasil', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiHapus').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonHapus').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiHapus').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonHapus').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
            }
        });
    });
});

