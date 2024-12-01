//Fungsi Menampilkan Data Event
function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/Merchandise/TabelMerchandise.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanTabelMerchandise').html(data);
        }
    });
}
function LoadDataProduk(endpoint, targetElement) {
    var id_barang = $('#GetIdBarang').val();
    if (id_barang) { // Cek apakah id_barang tidak kosong
        $.ajax({
            type: 'POST',
            url: '_Page/Merchandise/' + endpoint + '.php',
            data: { id_barang: id_barang },
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
        // Jika id_barang kosong, beri notifikasi atau kosongkan elemen target
        $(targetElement).html('<p>ID Barang tidak tersedia.</p>');
    }
}
//Fungsi Menampilkan Data List Kategori
function ShowKategoriList() {
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Merchandise/kategori_list.php',
        success     : function(data){
            $('#kategori_list').html(data);
        }
    });
}
//Fungsi Menampilkan Data List Satuan
function ShowSatuanList() {
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Merchandise/Satuan_list.php',
        success     : function(data){
            $('#satuan_list').html(data);
        }
    });
}
// Fungsi untuk memuat data yang berbeda
function ShowFotoBarang() {
    LoadDataProduk('ShowFotoBarang', '#ShowFotoBarang');
}

function ShowDetailBarang() {
    LoadDataProduk('ShowDetailBarang', '#ShowDetailBarang');
}
function ShowVarianProduk() {
    LoadDataProduk('ShowVarianProduk', '#ShowVarianProduk');
}
function ShowMarketplace() {
    LoadDataProduk('ShowMarketplace', '#ShowMarketplace');
}
function ShowRiwayatPenjualan() {
    LoadDataProduk('ShowRiwayatPenjualan', '#ShowRiwayatPenjualan');
}
function updateCharacterLength(inputSelector, lengthSelector, maxLength) {
    //Menampilkan Jumlah Karakter Pertama Kali
    var value_start=$(inputSelector).val();
    var length_start = value_start.length;
    $(inputSelector).on('input', function() {
        var value = $(this).val();
        var length = value.length;

        // Validasi berdasarkan inputSelector
        if (inputSelector === "#nama"||inputSelector === "#nama_edit") {
            // Hanya boleh huruf dan spasi
            value = value.replace(/[^a-zA-Z\s]/g, '');
        } else if (inputSelector === "#harga" || inputSelector === "#stok"||inputSelector === "#harga_edit" || inputSelector === "#stok_edit") {
            // Hanya boleh angka
            value = value.replace(/[^0-9]/g, '');
        } else if (inputSelector === "#berat" || inputSelector === "#panjang" || inputSelector === "#lebar"|| inputSelector === "#tinggi") {
            // Hanya boleh angka dan satu titik sebagai desimal
            value = value.replace(/[^0-9.]/g, ''); // Menghapus karakter selain angka dan titik
            // Pastikan hanya ada satu titik desimal
            if ((value.match(/\./g) || []).length > 1) {
                value = value.replace(/\.+$/, ''); // Menghapus titik tambahan di akhir
            }
        }else if (inputSelector === "#berat_edit" || inputSelector === "#panjang_edit" || inputSelector === "#lebar_edit"|| inputSelector === "#tinggi_edit") {
            // Hanya boleh angka dan satu titik sebagai desimal
            value = value.replace(/[^0-9.]/g, ''); // Menghapus karakter selain angka dan titik
            // Pastikan hanya ada satu titik desimal
            if ((value.match(/\./g) || []).length > 1) {
                value = value.replace(/\.+$/, ''); // Menghapus titik tambahan di akhir
            }
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
    $(lengthSelector).text(length_start + '/' + maxLength);
}

//Menampilkan Data Pertama Kali
$(document).ready(function() {
    //Menampilkan Data Pertama kali
    filterAndLoadTable();
    ShowFotoBarang();
    ShowDetailBarang();
    ShowVarianProduk();
    ShowMarketplace();
    ShowRiwayatPenjualan();
    //Ketika Keyword By Diubah
    $('#keyword_by').change(function(){
        var keyword_by =$('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Merchandise/FormFilter.php',
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
    //Validasi Form
    updateCharacterLength('#nama_barang', '#nama_barang_length', 50);
    updateCharacterLength('#kategori', '#kategori_length', 20);
    updateCharacterLength('#satuan', '#satuan_length', 10);
    updateCharacterLength('#harga', '#harga_length', 10);
    updateCharacterLength('#stok', '#stok_length', 10);
    updateCharacterLength('#berat', '#berat_length', 10);
    updateCharacterLength('#panjang', '#panjang_length', 10);
    updateCharacterLength('#lebar', '#lebar_length', 10);
    updateCharacterLength('#tinggi', '#tinggi_length', 10);
    updateCharacterLength('#deskripsi', '#deskripsi_length', 500);
    //Validasi Foto
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
                validasiMessage.text('File sudah valid dan sesuai persyaratan.').css('color', 'green');
            }
        }
    });
    //Ketika Modal Tambah Mach Muncul
    $('#ModalTambahMerchandise').on('show.bs.modal', function (e) {
        ShowKategoriList();
        ShowSatuanList();
    });
    //Proses Tambah Marchandise
    $('#ProsesTambahMerchandise').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonTambahMerchandise').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/Merchandise/ProsesTambahMerchandise.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonTambahMerchandise').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiTambahMerchandise').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    $('#ButtonTambahMerchandise').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#ProsesTambahMerchandise').trigger('reset');
                    $('#ProsesFilter').trigger('reset');
                    $('#ModalTambahMerchandise').modal('hide');
                    $('#NotifikasiTambahMerchandise').html('');
                    filterAndLoadTable();
                    Swal.fire('Berhasil!', 'Item Barang Berhasil Ditambahkan', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiTambahMerchandise').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonTambahMerchandise').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiTambahMerchandise').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Ketika Modal Detail Muncul
    $('#ModalDetail').on('show.bs.modal', function (e) {
        var id_barang = $(e.relatedTarget).data('id');
        $('#FormDetail').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Merchandise/FormDetail.php',
            data        : {id_barang: id_barang},
            success     : function(data){
                $('#FormDetail').html(data);
            }
        });
    });
    //Ketika Modal Edit Muncul 
    $('#ModalEdit').on('show.bs.modal', function (e) {
        var id_barang = $(e.relatedTarget).data('id');
        $('#FormEdit').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Merchandise/FormEdit.php',
            data        : {id_barang: id_barang},
            success     : function(data){
                $('#FormEdit').html(data);
            }
        });
    });
    //Proses Edit Marchandise
    $('#ProsesEdit').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonEdit').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/Merchandise/ProsesEdit.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonEdit').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiEdit').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    $('#ButtonEdit').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#ModalEdit').modal('hide');
                    $('#NotifikasiEdit').html('');
                    filterAndLoadTable();
                    ShowFotoBarang();
                    ShowDetailBarang();
                    Swal.fire('Berhasil!', 'Item Barang Berhasil Diupdate', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiEdit').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonEdit').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiEdit').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Ketika Modal Ubah Foto Muncul 
    $('#ModalUbahFoto').on('show.bs.modal', function (e) {
        var id_barang = $(e.relatedTarget).data('id');
        $('#FormUbahFoto').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Merchandise/FormUbahFoto.php',
            data        : {id_barang: id_barang},
            success     : function(data){
                $('#FormUbahFoto').html(data);
                $('#NotifikasiUbahFoto').html('');
            }
        });
    });
    //Proses Ubah Foto
    $('#ProsesUbahFoto').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonUbahFoto').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/Merchandise/ProsesUbahFoto.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonUbahFoto').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiUbahFoto').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    $('#ButtonUbahFoto').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#ModalUbahFoto').modal('hide');
                    $('#NotifikasiUbahFoto').html('');
                    filterAndLoadTable();
                    ShowFotoBarang();
                    ShowDetailBarang();
                    Swal.fire('Berhasil!', 'Item Barang Berhasil Diupdate', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiUbahFoto').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonUbahFoto').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiUbahFoto').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Ketika Modal Hapus Muncul 
    $('#ModalHapus').on('show.bs.modal', function (e) {
        var id_barang = $(e.relatedTarget).data('id');
        $('#FormHapus').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Merchandise/FormHapus.php',
            data        : {id_barang: id_barang},
            success     : function(data){
                $('#FormHapus').html(data);
                $('#NotifikasiHapus').html('');
            }
        });
    });
    //Proses Hapus
    $('#ProsesHapus').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonHapus').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/Merchandise/ProsesHapus.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonHapus').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiHapus').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    $('#ButtonHapus').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#ModalHapus').modal('hide');
                    $('#NotifikasiHapus').html('');
                    filterAndLoadTable();
                    ShowFotoBarang();
                    ShowDetailBarang();
                    Swal.fire('Berhasil!', 'Item Barang Berhasil Dihapus', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiHapus').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonHapus').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiHapus').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Ketika Modal Tambah Varian Muncul Muncul
    $('#ModalTambahVarian').on('show.bs.modal', function (e) {
        var id_barang = $(e.relatedTarget).data('id');
        $('#FormTambahVarian').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Merchandise/FormTambahVarian.php',
            data        : {id_barang: id_barang},
            success     : function(data){
                $('#FormTambahVarian').html(data);
                $('#NotifikasiTambahVarian').html('');
            }
        });
    });
    //Proses Tambah Varian 
    $('#ProsesTambahVarian').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonTambahVarian').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/Merchandise/ProsesTambahVarian.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonTambahVarian').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiTambahVarian').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    $('#ButtonTambahVarian').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#ModalTambahVarian').modal('hide');
                    $('#NotifikasiTambahVarian').html('');
                    ShowVarianProduk();
                    ShowDetailBarang();
                    Swal.fire('Berhasil!', 'Varian Berhasil Ditambahkan', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiTambahVarian').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonTambahVarian').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiTambahVarian').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Ketika Modal Detail Varian Muncul 
    $('#ModalDetailVarian').on('show.bs.modal', function (e) {
        var GetDataVarian = $(e.relatedTarget).data('id');
        $('#FormDetailVarian').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Merchandise/FormDetailVarian.php',
            data        : {GetDataVarian: GetDataVarian},
            success     : function(data){
                $('#FormDetailVarian').html(data);
            }
        });
    });
    //Ketika Modal Edit Varian Muncul 
    $('#ModalEditVarian').on('show.bs.modal', function (e) {
        var GetDataVarian = $(e.relatedTarget).data('id');
        $('#FormEditVarian').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Merchandise/FormEditVarian.php',
            data        : {GetDataVarian: GetDataVarian},
            success     : function(data){
                $('#FormEditVarian').html(data);
                $('#NotifikasiEditVarian').html('');
            }
        });
    });
    //Proses Edit Varian 
    $('#ProsesEditVarian').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonEditVarian').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/Merchandise/ProsesEditVarian.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonEditVarian').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;
                try {
                    result = JSON.parse(response); // Mencoba untuk parse JSON
                } catch (e) {
                    $('#NotifikasiEditVarian').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    return; // Keluar dari fungsi jika JSON tidak valid
                }
                if (result.success) {
                    $('#ButtonEditVarian').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#ModalEditVarian').modal('hide');
                    $('#NotifikasiEditVarian').html('');
                    ShowVarianProduk();
                    ShowDetailBarang();
                    Swal.fire('Berhasil!', 'Varian Berhasil Diupdate', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiEditVarian').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonEditVarian').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiEditVarian').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
    //Ketika Modal Hapus Varian Muncul 
    $('#ModalHapusVarian').on('show.bs.modal', function (e) {
        var GetDataVarian = $(e.relatedTarget).data('id');
        $('#FormHapusVarian').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Merchandise/FormHapusVarian.php',
            data        : {GetDataVarian: GetDataVarian},
            success     : function(data){
                $('#FormHapusVarian').html(data);
                $('#NotifikasiHapusVarian').html('');
            }
        });
    });
    //Proses Hapus Varian 
    $('#ProsesHapusVarian').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonHapusVarian').html('Loading...').prop('disabled', true);
        
        $.ajax({
            url: '_Page/Merchandise/ProsesHapusVarian.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#ButtonHapusVarian').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;
                try {
                    // Mencoba untuk parse JSON
                    result = JSON.parse(response);
                } catch (e) {
                    $('#NotifikasiHapusVarian').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    // Keluar dari fungsi jika JSON tidak valid
                    return;
                }
                if (result.success) {
                    $('#ButtonHapusVarian').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#ModalHapusVarian').modal('hide');
                    $('#NotifikasiHapusVarian').html('');
                    ShowVarianProduk();
                    ShowDetailBarang();
                    Swal.fire('Berhasil!', 'Varian Berhasil Dihapus', 'success');
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiHapusVarian').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonHapusVarian').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiHapusVarian').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
});