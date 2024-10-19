//Fungsi Menampilkan Data
function filterAndLoadTable() {
    var FilterRegionalData = $('#FilterRegionalData').serialize();
    $('#MenampilkanTabelRegionalData').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RegionalData/TabelRegionalData.php',
        data 	    :  FilterRegionalData,
        success     : function(data){
            $('#MenampilkanTabelRegionalData').html(data);
        }
    });
}
function prosesBatch() {
    $.ajax({
        url: '_Page/RegionalData/ProsesMaintenanceData.php',
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#NotifikasiMaintenanceRegionalData').text(response.message);

                // Jika masih ada data yang perlu diproses, lanjutkan proses batch berikutnya
                if (response.more_data) {
                    prosesBatch(); // Panggil lagi untuk batch berikutnya
                } else {
                    $('#NotifikasiMaintenanceRegionalData').text('Proses selesai.');
                    $('#ButtonMulaiProses').prop('disabled', false);
                }
            } else {
                $('#NotifikasiMaintenanceRegionalData').text(response.message);
                $('#ButtonMulaiProses').prop('disabled', false);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#NotifikasiMaintenanceRegionalData').text('Terjadi kesalahan saat mengirim data: ' + textStatus + ' - ' + errorThrown);
            $('#ButtonMulaiProses').prop('disabled', false);
        }
    });
}
function OptionListProvinsi() {
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RegionalData/PilihProvinsi.php',
        success     : function(data){
            $('#Propinsi').html(data);
        }
    });
}
function OptionListKabupaten() {
    $('#Propinsi').change(function(){
        var Propinsi = $('#Propinsi').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RegionalData/PilihKabupaten.php',
            data 	    :  {Propinsi: Propinsi},
            success     : function(data){
                $('#Kabupaten').html(data);
            }
        });
        $('#Kecamatan').html('<option value="">Pilih</option>');
    });
}
function OptionListKecamatan() {
    $('#Kabupaten').change(function(){
        var Kabupaten = $('#Kabupaten').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RegionalData/PilihKecamatan.php',
            data 	    :  {Kabupaten: Kabupaten},
            success     : function(data){
                $('#Kecamatan').html(data);
            }
        });
    });
}
//Menampilkan Data Pertama Kali
$(document).ready(function() {
    //Menampilkan Data Pertama Kali
    filterAndLoadTable();
    //Ketika Mulai Dilakukan Pencarian
    $('#FilterRegionalData').submit(function(){
        $('#page').val('1');
        filterAndLoadTable();
        $('#ModalFilterRegionalData').modal('hide');
    });
    //Ketika KeywordBy Diubah
    $('#KeywordBy').change(function(){
        var KeywordBy = $('#KeywordBy').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RegionalData/FormFilter.php',
            data 	    :  {KeywordBy: KeywordBy},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });
    //Ketika Proses Perbaikan Data
    $('#ButtonMulaiProses').on('click', function() {
        $('#ButtonMulaiProses').prop('disabled', true);
        $('#NotifikasiMaintenanceRegionalData').text('Proses dimulai...');
        prosesBatch();
    });
    //Ketika Form Tambah Data Wilayah Muncul dan mulai mengisi kategori
    $('#kategori').on('change', function() {
        var kategori = $(this).val();
        
        // Aktifkan input berdasarkan kategori yang dipilih
        switch (kategori) {
            case 'Propinsi':
                $('#FormProvinsi').html('<input type="text" name="Propinsi" id="Propinsi" class="form-control">');
                $('#FormKabupaten').html('<input type="text" readonly name="Kabupaten" id="Kabupaten" class="form-control">');
                $('#FormKecamatan').html('<input type="text" readonly name="Kecamatan" id="Kecamatan" class="form-control">');
                $('#FormDesa').html('<input type="text" readonly name="desa" id="desa" class="form-control">');
                break;
            case 'Kabupaten':
                $('#FormProvinsi').html('<select id="Propinsi" name="Propinsi" class="form-control"><option value="">Pilih</option></select>');
                $('#FormKabupaten').html('<input type="text" name="Kabupaten" id="Kabupaten" class="form-control">');
                $('#FormKecamatan').html('<input type="text" readonly name="Kecamatan" id="Kecamatan" class="form-control">');
                $('#FormDesa').html('<input type="text" readonly name="desa" id="desa" class="form-control">');
                //Menampilkan List Provinsi Pertama Kali
                OptionListProvinsi();
                break;
            case 'Kecamatan':
                $('#FormProvinsi').html('<select id="Propinsi" name="Propinsi" class="form-control"><option value="">Pilih</option></select>');
                $('#FormKabupaten').html('<select id="Kabupaten" name="Kabupaten" class="form-control"><option value="">Pilih</option></select>');
                $('#FormKecamatan').html('<input type="text" name="Kecamatan" id="Kecamatan" class="form-control">');
                $('#FormDesa').html('<input type="text" readonly name="desa" id="desa" class="form-control">');
                //Menampilkan List Provinsi Pertama Kali
                OptionListProvinsi();
                //Ketika Provinsi Diubah
                OptionListKabupaten();
                break;
            case 'desa':
                $('#FormProvinsi').html('<select id="Propinsi" name="Propinsi" class="form-control"><option value="">Pilih</option></select>');
                $('#FormKabupaten').html('<select id="Kabupaten" name="Kabupaten" class="form-control"><option value="">Pilih</option></select>');
                $('#FormKecamatan').html('<select id="Kecamatan" name="Kecamatan" class="form-control"><option value="">Pilih</option></select>');
                $('#FormDesa').html('<input type="text" name="desa" id="desa" class="form-control">');
                //Menampilkan List Provinsi Pertama Kali
                OptionListProvinsi();
                //Ketika Provinsi Diubah
                OptionListKabupaten();
                //Ketika Kabupaten Diubah
                OptionListKecamatan();
                break;
            default:
                // Jika tidak ada kategori yang dipilih, semua tetap readonly
                $('#FormProvinsi').html('<input type="text" readonly name="Propinsi" id="Propinsi" class="form-control">');
                $('#FormKabupaten').html('<input type="text" readonly name="Kabupaten" id="Kabupaten" class="form-control">');
                $('#FormKecamatan').html('<input type="text" readonly name="Kecamatan" id="Kecamatan" class="form-control">');
                $('#FormDesa').html('<input type="text" readonly name="desa" id="desa" class="form-control">');
                break;
        }
        
        // Aktifkan tombol Simpan jika ada kategori yang dipilih, selain default
        if (kategori) {
            $('#ButtonTambahRegionalData').prop('disabled', false);
        } else {
            $('#ButtonTambahRegionalData').prop('disabled', true);
        }
    });

    //Ketika Proses Simpan/Tambah Wilayah
    $('#ProsesTambahRegionalData').on('submit', function(e) {
        e.preventDefault(); // Mencegah pengiriman form secara default

        // Ubah teks tombol menjadi 'Loading...' dan nonaktifkan tombol
        $('#ButtonTambahRegionalData').text('Loading...').prop('disabled', true);

        // Ambil data form
        var formData = $(this).serialize();

        // Kirim data form menggunakan AJAX
        $.ajax({
            url: '_Page/RegionalData/ProsesTambahRegionalData.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                // Cek apakah respons sukses
                if (response.success) {
                    //Apabila Proses Berhasil
                    $('#ButtonTambahRegionalData').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#ProsesTambahRegionalData').trigger('reset');
                    $('#FilterRegionalData').trigger('reset');
                    $('#ModalTambahRegionalData').modal('hide');
                    $('#NotifikasiTambahRegionalData').html('');
                    //Reset Form
                    $('#FormProvinsi').html('<input type="text" readonly name="propinsi" id="propinsi" class="form-control">');
                    $('#FormKabupaten').html('<input type="text" readonly name="Kabupaten" id="Kabupaten" class="form-control">');
                    $('#FormKecamatan').html('<input type="text" readonly name="Kecamatan" id="Kecamatan" class="form-control">');
                    $('#FormDesa').html('<input type="text" readonly name="desa" id="desa" class="form-control">');
                    //Menampilkan Data
                    filterAndLoadTable();
                    // Menampilkan Swal
                    Swal.fire('Berhasil!', 'Wilayah Berhasil Ditambahkan', 'success');
                } else {
                    // Tampilkan pesan error
                    $('#NotifikasiTambahRegionalData').html('<div class="alert alert-danger"><small><code>' + response.message + '</code></small></div>');
                }

                // Kembalikan tombol ke teks awal dan aktifkan kembali tombol
                $('#ButtonTambahRegionalData').text('Simpan').prop('disabled', false);
            },
            error: function() {
                // Tampilkan pesan error jika ada kesalahan dalam pengiriman data
                $('#NotifikasiTambahRegionalData').html('<div class="alert alert-danger">><small><code>Terjadi kesalahan saat mengirim data.</code></small></div>');
                // Kembalikan tombol ke teks awal dan aktifkan kembali tombol
                $('#ButtonTambahRegionalData').text('Simpan').prop('disabled', false);
            }
        });
    });
    //Edit RegionalData
    $('#ModalEditRegionalData').on('show.bs.modal', function (e) {
        var id_wilayah = $(e.relatedTarget).data('id');
        $('#FormEditRegionalData').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RegionalData/FormEditRegionalData.php',
            data        : {id_wilayah: id_wilayah},
            success     : function(data){
                $('#FormEditRegionalData').html(data);
                $('#NotifikasiEditRegionalData').html('');
            }
        });
    });
    //Proses Edit RegionalData
    $('#ProsesEditRegionalData').submit(function(e){
        e.preventDefault(); // Mencegah pengiriman form secara default

        // Ubah teks tombol menjadi 'Loading...' dan nonaktifkan tombol
        $('#ButtonEditRegionalData').text('Loading...').prop('disabled', true);

        // Ambil data form
        var formData = $(this).serialize();

        // Kirim data form menggunakan AJAX
        $.ajax({
            url     : '_Page/RegionalData/ProsesEditRegionalData.php',
            type    : 'POST',
            data    : formData,
            dataType: 'json',
            success: function(response) {
                // Cek apakah respons sukses
                if (response.success) {
                    //Apabila Proses Berhasil
                    $('#ButtonEditRegionalData').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#ModalEditRegionalData').modal('hide');
                    $('#NotifikasiEditRegionalData').html('');
                    //Menampilkan Data
                    filterAndLoadTable();
                    // Menampilkan Swal
                    Swal.fire('Berhasil!', 'Wilayah Berhasil Diubah', 'success');
                } else {
                    // Tampilkan pesan error
                    $('#NotifikasiEditRegionalData').html('<div class="alert alert-danger"><small><code>' + response.message + '</code></small></div>');
                }

                // Kembalikan tombol ke teks awal dan aktifkan kembali tombol
                $('#ButtonEditRegionalData').text('Simpan').prop('disabled', false);
            },
            error: function() {
                // Tampilkan pesan error jika ada kesalahan dalam pengiriman data
                $('#NotifikasiEditRegionalData').html('<div class="alert alert-danger"><small><code>Terjadi kesalahan saat mengirim data.</code></small></div>');
                // Kembalikan tombol ke teks awal dan aktifkan kembali tombol
                $('#ButtonEditRegionalData').text('Simpan').prop('disabled', false);
            }
        });
    });
    //Hapus RegionalData
    $('#ModalDeleteRegionalData').on('show.bs.modal', function (e) {
        var id_wilayah = $(e.relatedTarget).data('id');
        $('#FormDeleteRegionalData').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RegionalData/FormDeleteRegionalData.php',
            data        : {id_wilayah: id_wilayah},
            success     : function(data){
                $('#FormDeleteRegionalData').html(data);
                $('#NotifikasiHapusRegionalData').html('');
            }
        });
    });
    //Proses Hapus RegionalData
    $('#ProsesHapusRegionalData').submit(function(e){
        e.preventDefault(); // Mencegah pengiriman form secara default

        // Ubah teks tombol menjadi 'Loading...' dan nonaktifkan tombol
        $('#ButtonHapusRegionalData').text('Loading...').prop('disabled', true);

        // Ambil data form
        var formData = $(this).serialize();

        // Kirim data form menggunakan AJAX
        $.ajax({
            url     : '_Page/RegionalData/ProsesHapusRegionalData.php',
            type    : 'POST',
            data    : formData,
            dataType: 'json',
            success: function(response) {
                // Cek apakah respons sukses
                if (response.success) {
                    //Apabila Proses Berhasil
                    $('#ButtonHapusRegionalData').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#ModalDeleteRegionalData').modal('hide');
                    $('#NotifikasiHapusRegionalData').html('');
                    //Menampilkan Data
                    filterAndLoadTable();
                    // Menampilkan Swal
                    Swal.fire('Berhasil!', 'Wilayah Berhasil Diubah', 'success');
                } else {
                    // Tampilkan pesan error
                    $('#NotifikasiHapusRegionalData').html('<div class="alert alert-danger"><small><code>' + response.message + '</code></small></div>');
                }

                // Kembalikan tombol ke teks awal dan aktifkan kembali tombol
                $('#ButtonHapusRegionalData').text('Simpan').prop('disabled', false);
            },
            error: function() {
                // Tampilkan pesan error jika ada kesalahan dalam pengiriman data
                $('#NotifikasiHapusRegionalData').html('<div class="alert alert-danger"><small><code>Terjadi kesalahan saat mengirim data.</code></small></div>');
                // Kembalikan tombol ke teks awal dan aktifkan kembali tombol
                $('#ButtonHapusRegionalData').text('Simpan').prop('disabled', false);
            }
        });
    });
    //Menampilkan Data Wilayah Berdasarkan Hirarki
    $('#ModalWilayahByLevel').on('show.bs.modal', function (e) {
        $('#FormListWilayahByLevel').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RegionalData/FormListWilayahByLevel.php',
            success     : function(data){
                $('#FormListWilayahByLevel').html(data);
            }
        });
    });
});




