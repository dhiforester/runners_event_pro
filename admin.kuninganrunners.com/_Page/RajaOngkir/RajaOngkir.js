//Ketika Tombol Cari Pada Form Pencarian Origin ID
$('#button_cari_origin').click(function () {
    // Ubah tombol ke mode loading
    var button = $('#button_cari_origin');
    button.prop('disabled', true).html('Loading...');

    // Ambil nilai dari input
    var origin_keyword = $('#origin_keyword').val();

    // Lakukan AJAX request
    $.ajax({
        type    : 'POST',
        url     : '_Page/RajaOngkir/CariLocation.php',
        data    : { origin_keyword: origin_keyword },
        success: function (response) {
            button.prop('disabled', false).html('<i class="bi bi-search"></i> Cari');
            $('#form_origin').html(response);
        }
    });
});
//Ketika Origin ID Di Add
$('#ProsesAddOriginId').submit(function(event) {
    event.preventDefault(); // Mencegah reload halaman
    $('#ButtonAddOriginId').html('Loading..'); // Tampilkan status loading
    var formData = $(this).serialize(); // Ambil semua konten form
    $.ajax({
        type        : 'POST', // Metode pengiriman
        url         : '_Page/RajaOngkir/AddOrigin.php', // URL tujuan
        data        : formData, // Data dari form
        dataType    : 'json', // Format respons yang diharapkan
        success: function(response) {
            if (response.success === true) {
                var OriginId=response.OriginId;
                var OriginLabel=response.OriginLabel;
                //Tempelkan Ke form
                $('#origin_id').val(OriginId);
                $('#origin_label').val(OriginLabel);
                //Reset Button
                $('#ButtonAddOriginId').html('<i class="bi bi-plus"></i> Tambahkan');
                //tutup modal
                $('#ModalCariOriginId').modal('hide');
            } else {
                $('#NotifikasiAddOriginId').html('<div class="alert alert-danger">'+response.message+'</div>');
                $('#ButtonAddOriginId').html('<i class="bi bi-plus"></i> Tambahkan');
            }
        },
        error: function(xhr, status, error) {
            //Tampilkan Notifikasi
            $('#NotifikasiAddOriginId').html('<div class="alert alert-danger">'+error+'</div>');
            //Reset
            $('#ButtonAddOriginId').html('<i class="bi bi-plus"></i> Tambahkan');
        }
    });
});
//Proses Simpan Pengaturan
$('#ProsesSettingRajaOngkir').submit(function(){
    $('#NotifikasiSettingRajaOngkir').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesSettingRajaOngkir')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RajaOngkir/ProsesSettingRajaOngkir.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiSettingRajaOngkir').html(data);
            var NotifikasiSettingRajaOngkirBerhasil=$('#NotifikasiSettingRajaOngkirBerhasil').html();
            if(NotifikasiSettingRajaOngkirBerhasil=="Success"){
                $('#NotifikasiSettingRajaOngkir').html('');
                Swal.fire(
                    'Success!',
                    'Pengaturan Berhasil Disimpan!',
                    'success'
                )
            }
        }
    });
});
//Ketika Pencarian Tujuan Pengiriman
$('#ProsesCariDestinationContent').submit(function () {
    // Ubah tombol ke mode loading
    var button = $('#button_cari_destinatiion');
    button.prop('disabled', true).html('Loading...');

    // Ambil nilai dari input
    var destinatiion_keyword = $('#destinatiion_keyword').val();

    // Lakukan AJAX request
    $.ajax({
        type    : 'POST',
        url     : '_Page/RajaOngkir/CariDestination.php',
        data    : { destination_keyword: destinatiion_keyword },
        success: function (response) {
            button.prop('disabled', false).html('<i class="bi bi-search"></i> Cari');
            $('#form_destinatiion').html(response);
        }
    });
});

//Ketika Pencarian Tujuan Pengiriman
$('#ProsesTestCariOngkir').submit(function () {
    // Ubah tombol ke mode loading
    var ProsesTestCariOngkir = $('#ProsesTestCariOngkir').serialize();
    $('#FormHasilPencarianOngkir').html('Loading...');
    //Proses Dengan AJAX
    $.ajax({
        type    : 'POST',
        url     : '_Page/RajaOngkir/ProsesTestCariOngkir.php',
        data    : ProsesTestCariOngkir,
        success: function (response) {
            $('#FormHasilPencarianOngkir').html(response);
        }
    });
});
