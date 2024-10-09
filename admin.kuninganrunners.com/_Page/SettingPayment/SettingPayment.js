//Proses Simpan Setting Payment
$('#ProsesSettingPayment').on('submit', function(e) {
    e.preventDefault(); // Mencegah form dari submit secara default

    // Mengambil data dari form
    var formData = new FormData(this);

    // Tombol diubah menjadi "Loading..." saat proses
    var $submitButton = $('#NotifikasiSimpanSettingPayment');
    $submitButton.html('Loading...').prop('disabled', true);

    // Mengirimkan data melalui AJAX
    $.ajax({
        url: '_Page/SettingPayment/ProsesSettingPayment.php',
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
                );
                // Kembalikan tombol ke keadaan semula
                $submitButton.html('<i class="bi bi-save"></i> Simpan Pengaturan').prop('disabled', false);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Tampilkan pesan jika terjadi kesalahan pada server
            Swal.fire(
                'Gagal!',
                'Terjadi kesalahan pada server, coba lagi nanti. (' + textStatus + ': ' + errorThrown + ')',
                'error'
            );
            // Kembalikan tombol ke keadaan semula
            $submitButton.html('<i class="bi bi-save"></i> Simpan Pengaturan').prop('disabled', false);
        },
        complete: function() {
            // Kembalikan tombol ke keadaan semula
            $submitButton.html('<i class="bi bi-save"></i> Simpan Pengaturan').prop('disabled', false);
        }
    });
});

// Fungsi untuk generate kode unik 36 karakter
function generateUniqueCode(length) {
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var result = '';
    var charactersLength = characters.length;

    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}
// Ketika tombol GenerateKodeTransaksi di klik
$('#GenerateKodeTransaksi').on('click', function() {
    var uniqueCode = generateUniqueCode(36); // Generate kode unik 36 karakter
    $('#kode_transaksi').val(uniqueCode); // Mengisi input order_id dengan kode unik
});
// Ketika tombol GenerateOrderId di klik
$('#GenerateOrderId').on('click', function() {
    var uniqueCode = generateUniqueCode(36); // Generate kode unik 36 karakter
    $('#order_id').val(uniqueCode); // Mengisi input order_id dengan kode unik
});
// Fungsi untuk memformat angka dengan tanda titik setiap ribuan
function formatRupiah(angka) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(), // Hapus karakter selain angka dan koma
        split = number_string.split(','), 
        sisa = split[0].length % 3, 
        rupiah = split[0].substr(0, sisa), 
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    
    // Tambahkan titik jika ada ribuan
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    return rupiah;
}
// Event untuk mencegah karakter selain angka
$('#gross_amount').on('input', function(e) {
    var input = $(this).val();
    $(this).val(formatRupiah(input)); // Format nilai input menjadi format rupiah
});

// Mencegah karakter selain angka yang diinput
$('#gross_amount').on('keypress', function(e) {
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) { // Hanya izinkan angka (0-9)
        e.preventDefault();
    }
});
// Mencegah karakter selain angka yang diinput
$('#phone').on('keypress', function(e) {
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) { // Hanya izinkan angka (0-9)
        e.preventDefault();
    }
});
//Proses Generate Snap Token
$('#GenerateSnapToken').on('click', function(e) {
    e.preventDefault();
    
    // Pastikan elemen form diambil dengan benar
    var formData = new FormData($('#ProsesTestSnapToken')[0]); 
    var $GenerateSnapToken = $('#GenerateSnapToken');
    
    // Ubah text dan disable tombol saat proses berjalan
    $GenerateSnapToken.html('<code class="text text-success">Loading...</code>').prop('disabled', true);
    
    // Mengirimkan data melalui AJAX
    $.ajax({
        url: '_Page/SettingPayment/GenerateSnapToken.php',
        method: 'POST',
        data: formData,
        contentType: false, // Biarkan browser menentukan tipe konten
        processData: false, // Jangan memproses data sebagai string query
        dataType: 'json',   // Harapkan respons JSON
        success: function(response) {
            if (response.status === 'success') {
                // Jika berhasil, masukkan snap token ke input
                var snap_token = response.token;
                $('#snap_token').val(snap_token);
            } else {
                // Tampilkan notifikasi error jika gagal
                Swal.fire(
                    'Gagal!',
                    response.message,
                    'error'
                );
            }
        },
        error: function(xhr, status, error) {
            // Tampilkan pesan jika terjadi kesalahan pada server
            Swal.fire(
                'Gagal!',
                'Terjadi kesalahan pada server, coba lagi nanti.',
                'error'
            );
            console.error("Error details:", status, error);
        },
        complete: function() {
            // Kembalikan tombol ke keadaan semula
            $GenerateSnapToken.html('<code class="text text-success">Generate</code>').prop('disabled', false);
        }
    });
});

//Snap Token Test
$('#ModalTestSnapToken').on('show.bs.modal', function (e) {
    var ServerKey=$('#server_key').val();
    var production=$('#production').val();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12 text-center"><div class="spinner-border text-secondary" role="status"><span class="sr-only">Loading...</span></div></div></div></div>';
    $('#TestSnapToken').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SettingPayment/TestSnapToken.php',
        data        :  {ServerKey: ServerKey, production: production},
        success     : function(data){
            $('#TestSnapToken').html(data);
            $('#ProsesTestSnapToken').submit(function(){
                $('#NotifikasiSnapToken').html("Loading..");
                var form = $('#ProsesTestSnapToken')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SettingService/ProsesTestSnapToken.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiSnapToken').html(data);
                        var GetDataToken=$('#TokenDiperoleh').html();
                        if(GetDataToken!=""){
                            $('#snap_token').val(GetDataToken);
                        }
                    }
                });
            });
            $('#GenerateSnapButton').click(function(){
                $('#NotifikasiSnapToken').html("Loading..");
                var form = $('#ProsesTestSnapToken')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SettingService/ProsesTestGenerateButton.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiSnapToken').html(data);
                    }
                });
            });
        }
    });
});
//Proses Simpan Setting Payment
$('#ProsesSettingPayment').submit(function(){
    $('#NotifikasiSimpanSettingPayment').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesSettingPayment')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SettingPayment/ProsesSettingPayment.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiSimpanSettingPayment').html(data);
            var NotifikasiSimpanSettingPaymentBerhasil=$('#NotifikasiSimpanSettingPaymentBerhasil').html();
            if(NotifikasiSimpanSettingPaymentBerhasil=="Success"){
                window.location.href = "index.php?Page=SettingPayment";
            }
        }
    });
});