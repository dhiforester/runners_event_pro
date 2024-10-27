//Fungsi Menampilkan Data Testimoni
function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/Testimoni/TabelTestimoni.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanTabelTestimoni').html(data);
        }
    });
}
//Fungsi Pencarian Member
function PencarianMember() {
    var ProsesPencarianMember = $('#ProsesPencarianMember').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Event/ListMember.php',
        data    : ProsesPencarianMember,
        success: function(data) {
            $('#FormListMember').html(data);
        }
    });
}
//Menampilkan Data Pertama Kali
$(document).ready(function() {
    //Menampilkan Data Pertama kali
    filterAndLoadTable();
    PencarianMember();

    //Ketika keyword_by Diubah
    $('#keyword_by').change(function(){
        var keyword_by =$('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Testimoni/FormFilter.php',
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

    //Ketika Pencarian Member
    $('#ProsesPencarianMember').submit(function(){
        PencarianMember();
    });

    //Validasi Jumlah Karakter Testimoni
    $('#testimoni').on('input', function() {
        var value = $(this).val();
        var maxLength = 500;
        // Jika panjang melebihi batas, potong sesuai maxLength
        if (value.length > maxLength) {
            value = value.substring(0, maxLength);
        }
        // Update nilai input
        $(this).val(value); 
        // Tampilkan jumlah karakter saat ini
        $('#testimoni_length').text(value.length + '/' + maxLength);
    });
    // Proses Tambah Testimoni
    $('#ProsesTambahTestimoni').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonTambahTestimoni').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/Testimoni/ProsesTambahTestimoni.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    $('#page').val('1');
                    $('#ProsesFilter')[0].reset();
                    filterAndLoadTable();
                    PencarianMember();
                    $('#ProsesTambahTestimoni')[0].reset();
                    $('#NotifikasiTambahTestimoni').html('');
                    $('#ModalTambahTestimoni').modal('hide');
                    $('#ButtonTambahTestimoni').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    Swal.fire('Berhasil!', 'Testimoni berhasil ditambahkan', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiTambahTestimoni').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonTambahTestimoni').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiTambahTestimoni').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonTambahTestimoni').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });

    //Ketika Modal Detail Testimoni
    $('#ModelDetailTestimoni').on('show.bs.modal', function (e) {
        var id_web_testimoni = $(e.relatedTarget).data('id');
        $('#FormDetailTestimoni').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Testimoni/FormDetailTestimoni.php',
            data        : {id_web_testimoni: id_web_testimoni},
            success     : function(data){
                $('#FormDetailTestimoni').html(data);
            }
        });
    });
    //Ketika Modal Edit Testimoni Muncul
    $('#ModelEditTestimoni').on('show.bs.modal', function (e) {
        var id_web_testimoni = $(e.relatedTarget).data('id');
        $('#FormEditTestimoni').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Testimoni/FormEditTestimoni.php',
            data        : {id_web_testimoni: id_web_testimoni},
            success     : function(data){
                $('#FormEditTestimoni').html(data);
                $('#NotifikasiEditTestimoni').html('');
            }
        });
    });
    //Proses Edit testimoni
    $('#ProsesEditTestimoni').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonEditTestimoni').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/Testimoni/ProsesEditTestimoni.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonEditTestimoni').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiEditTestimoni').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    $('#ProsesEditTestimoni')[0].reset();
                    $('#NotifikasiEditTestimoni').html('');
                    $('#ModelEditTestimoni').modal('hide');
                    filterAndLoadTable();
                    Swal.fire('Berhasil!', 'Testimoni Berhasil Diupdate', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiEditTestimoni').html('<div class="alert alert-danger">' + result.message + '</div>');
                }
            },
            error: function () {
                $('#ButtonEditTestimoni').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiEditTestimoni').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Ketika Modal Hapus Testimoni
    $('#ModelHapusTestimoni').on('show.bs.modal', function (e) {
        var id_web_testimoni = $(e.relatedTarget).data('id');
        $('#FormHapusTestimoni').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Testimoni/FormHapusTestimoni.php',
            data        : {id_web_testimoni: id_web_testimoni},
            success     : function(data){
                $('#FormHapusTestimoni').html(data);
                $('#NotifikasiHapusTestimoni').html('');
            }
        });
    });
    //Proses Hapus Testimoni
    $('#ProsesHapusTestimoni').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonHapusTestimoni').html('Loading...').prop('disabled', true);
        $.ajax({
            url             : '_Page/Testimoni/ProsesHapusTestimoni.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            success: function (response) {
                $('#ButtonHapusTestimoni').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                var result;
                try {
                    // Mencoba untuk parse JSON
                    result = JSON.parse(response); 
                } catch (e) {
                    $('#NotifikasiHapusTestimoni').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    // Keluar dari fungsi jika JSON tidak valid
                    return; 
                }
                if (result.success) {
                    $('#ProsesHapusTestimoni')[0].reset();
                    $('#NotifikasiHapusTestimoni').html('');
                    $('#ModelHapusTestimoni').modal('hide');
                    filterAndLoadTable();
                    Swal.fire('Berhasil!', 'Testimoni Berhasil Dihapus', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiHapusTestimoni').html('<div class="alert alert-danger">' + result.message + '</div>');
                }
            },
            error: function () {
                $('#ButtonHapusTestimoni').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                $('#NotifikasiHapusTestimoni').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
});