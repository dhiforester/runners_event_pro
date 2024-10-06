//Fungsi Menampilkan Data
function filterAndLoadTable() {
    var ProsesFilter= $('#ProsesFilter').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/ApiKey/TabelApiKey.php',
        data    : ProsesFilter,
        success: function(data) {
            $('#MenampilkanTabelApiKey').html(data);
        }
    });
}
//Fungsi Untuk Menampilkan Cart
function LoadGrafikGrafikTokenApiKey() {
    var ProsesFilterGrafikApiKey = $('#ProsesFilterGrafikApiKey').serialize();
    // Ambil data dari server menggunakan AJAX
    $.ajax({
        url: '_Page/ApiKey/ProsesGrafikGrafikTokenApiKey.php',
        type: 'POST',
        data: ProsesFilterGrafikApiKey,
        dataType: 'json',
        success: function(response) {
            // Dapatkan data dari respons
            const months = response.months;
            const total = response.total;
            const periode_name = response.periode_name;
            // Konfigurasi untuk grafik
            const options = {
                chart: {
                    type: 'bar', // Jenis grafik
                    height: 350
                },
                series: [
                    {
                        name: 'Total',
                        data: total
                    }
                ],
                xaxis: {
                    categories: months // Kategori sumbu x
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                yaxis: {
                    title: {
                        text: 'Jumlah X-Token'
                    }
                },
                fill: {
                    opacity: 1
                },
                title: { // Menambahkan judul grafik
                    text: 'Grafik Session X-Token '+periode_name+'', // Teks judul
                    align: 'center', // Penempatan judul: 'left', 'center', atau 'right'
                    style: {
                        fontSize: '16px', // Ukuran font
                        fontWeight: 'bold', // Tebal font
                        color: '#263238' // Warna font
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " Token";
                        }
                    }
                }
            };

            // Inisialisasi dan render grafik
            const chart = new ApexCharts(document.querySelector("#GrafikTokenApiKey"), options);
            chart.render();
        },
        error: function(error) {
            console.error("Error fetching data", error);
        }
    });
}
function LoadGrafikGrafikLogApiKey() {
    var ProsesFilterGrafikApiKey = $('#ProsesFilterGrafikApiKey').serialize();
    // Ambil data dari server menggunakan AJAX
    $.ajax({
        url: '_Page/ApiKey/ProsesGrafikLogApiKey.php',
        type: 'POST',
        data: ProsesFilterGrafikApiKey,
        dataType: 'json',
        success: function(response) {
            // Dapatkan data dari respons
            const months = response.months;
            const total = response.total;
            const periode_name = response.periode_name;
            // Konfigurasi untuk grafik
            const options = {
                chart: {
                    type: 'bar', // Jenis grafik
                    height: 350
                },
                series: [
                    {
                        name: 'Total',
                        data: total
                    }
                ],
                xaxis: {
                    categories: months // Kategori sumbu x
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Log'
                    }
                },
                fill: {
                    opacity: 1
                },
                title: { // Menambahkan judul grafik
                    text: 'Grafik Log API Key '+periode_name+'', // Teks judul
                    align: 'center', // Penempatan judul: 'left', 'center', atau 'right'
                    style: {
                        fontSize: '16px', // Ukuran font
                        fontWeight: 'bold', // Tebal font
                        color: '#263238' // Warna font
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " Log";
                        }
                    }
                }
            };

            // Inisialisasi dan render grafik
            const chart = new ApexCharts(document.querySelector("#GrafikAktivitasApiKey"), options);
            chart.render();
        },
        error: function(error) {
            console.error("Error fetching data", error);
        }
    });
}
//Fungsi Menampilkan Data
function LoadTabelRekapTokenApiKey() {
    var ProsesFilterGrafikApiKey = $('#ProsesFilterGrafikApiKey').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/ApiKey/TabelRekapTokenApiKey.php',
        data    : ProsesFilterGrafikApiKey,
        success: function(data) {
            $('#TabelRekapTokenApiKey').html(data);
        }
    });
}
function LoadTabelRekapLogApiKey() {
    var ProsesFilterGrafikApiKey = $('#ProsesFilterGrafikApiKey').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/ApiKey/TabelRekapLogApiKey.php',
        data    : ProsesFilterGrafikApiKey,
        success: function(data) {
            $('#TabelRekapLogApiKey').html(data);
        }
    });
}
function toggleBulan() {
    if ($('#Periode').val() === 'Bulanan') {
        $('#Bulan').closest('.row.mb-3').show();
    } else {
        $('#Bulan').closest('.row.mb-3').hide();
    }
}
//Menampilkan Data Pertama Kali
$(document).ready(function() {
    filterAndLoadTable();
    //Mencari nilai id
    var id_setting_api_key = $('#id_setting_api_key').val();
    //Tempelkan kedalam modal
    $('#PutIdSettingApi').val(id_setting_api_key);
    //Menampilkan Grafik
    LoadGrafikGrafikTokenApiKey();
    LoadGrafikGrafikLogApiKey();
    LoadTabelRekapTokenApiKey();
    LoadTabelRekapLogApiKey();
    // Panggil fungsi saat halaman dimuat untuk menyesuaikan tampilan awal
    toggleBulan();
    // Jalankan fungsi setiap kali nilai periode berubah
    $('#Periode').change(function() {
        toggleBulan();
    });
});
//Ketika keyword_by Diubah
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ApiKey/FormFilter.php',
        data        : {keyword_by: keyword_by},
        success     : function(data){
            $('#FormFilter').html(data);
        }
    });
});
//Kondisi Ketika Di Filter
$('#ProsesFilter').submit(function(){
    filterAndLoadTable();
    $('#ModalFilter').modal('toggle');
});
//Generate apikey
$('#GenerateUserKey').click(function(){
    $('#user_key_server').val('...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ApiKey/ProsesGenerateKode.php',
        success     : function(data){
            $('#user_key_server').val(data);
        }
    });
});
//Generate Password Server
$('#GeneratePasswordServer').click(function(){
    $('#password_server').val('...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ApiKey/ProsesGenerateKode.php',
        success     : function(data){
            $('#password_server').val(data);
        }
    });
});
//Proses Tambah ApiKey
$('#ProsesTambahApiKey').submit(function(){
    $('#NotifikasiTambahApiKey').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesTambahApiKey')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ApiKey/ProsesTambahApiKey.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahApiKey').html(data);
            var NotifikasiTambahApiKeyBerhasil=$('#NotifikasiTambahApiKeyBerhasil').html();
            if(NotifikasiTambahApiKeyBerhasil=="Success"){
                $("#ProsesTambahApiKey")[0].reset();
                $('#ModalTambahApiKey').modal('toggle');
                $('#NotifikasiTambahApiKey').html('');
                Swal.fire(
                    'Success!',
                    'Tambah API Key Berhasil!',
                    'success'
                )
                filterAndLoadTable();
            }
        }
    });
});
//Detail ApiKey
$('#ModalDetailInformasiApiKey').on('show.bs.modal', function (e) {
    var id_setting_api_key = $(e.relatedTarget).data('id');
    $('#FormDetailInformasiApiKey').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ApiKey/FormDetailInformasiApiKey.php',
        data        : {id_setting_api_key: id_setting_api_key},
        success     : function(data){
            $('#FormDetailInformasiApiKey').html(data);
        }
    });
});
//Edit Informasi ApiKey
$('#ModalEditInformasiApiKey').on('show.bs.modal', function (e) {
    var id_setting_api_key = $(e.relatedTarget).data('id');
    $('#FormEditInformasiApiKey').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ApiKey/FormEditInformasiApiKey.php',
        data        : {id_setting_api_key: id_setting_api_key},
        success     : function(data){
            $('#FormEditInformasiApiKey').html(data);
            $('#NotifikasiEditInformasiApiKey').html('');
        }
    });
});
//Proses Edit ApiKey
$('#ProsesEditInformasiApiKey').submit(function(){
    $('#NotifikasiEditInformasiApiKey').html('Loading...');
    var form = $('#ProsesEditInformasiApiKey')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ApiKey/ProsesEditInformasiApiKey.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditInformasiApiKey').html(data);
            var NotifikasiEditInformasiApiKeyBerhasil=$('#NotifikasiEditInformasiApiKeyBerhasil').html();
            if(NotifikasiEditInformasiApiKeyBerhasil=="Success"){
                $("#ProsesEditInformasiApiKey")[0].reset();
                $('#ModalEditInformasiApiKey').modal('toggle');
                $('#NotifikasiEditInformasiApiKey').html('');
                Swal.fire(
                    'Success!',
                    'Edit Informasi API Key Berhasil!',
                    'success'
                )
                filterAndLoadTable();
            }
        }
    });
});
//Modal Edit Password ApiKey
$('#ModalEditPasswordApiKey').on('show.bs.modal', function (e) {
    var id_setting_api_key = $(e.relatedTarget).data('id');
    $('#FormEditPasswordApiKey').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ApiKey/FormEditPasswordApiKey.php',
        data        : {id_setting_api_key: id_setting_api_key},
        success     : function(data){
            $('#FormEditPasswordApiKey').html(data);
            $('#NotifikasiEditPasswordApiKey').html('');
        }
    });
});
//Proses Edit ApiKey
$('#ProsesEditPasswordApiKey').submit(function(){
    $('#NotifikasiEditPasswordApiKey').html('Loading...');
    var form = $('#ProsesEditPasswordApiKey')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ApiKey/ProsesEditPasswordApiKey.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditPasswordApiKey').html(data);
            var NotifikasiEditPasswordApiKeyBerhasil=$('#NotifikasiEditPasswordApiKeyBerhasil').html();
            if(NotifikasiEditPasswordApiKeyBerhasil=="Success"){
                $("#ProsesEditPasswordApiKey")[0].reset();
                $('#ModalEditPasswordApiKey').modal('toggle');
                $('#NotifikasiEditPasswordApiKey').html('');
                Swal.fire(
                    'Success!',
                    'Edit Password API Key Berhasil!',
                    'success'
                )
                filterAndLoadTable();
            }
        }
    });
});
//Modal Hapus ApiKey
$('#ModalHapusApiKey').on('show.bs.modal', function (e) {
    var id_setting_api_key = $(e.relatedTarget).data('id');
    $('#FormHapusApiKey').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ApiKey/FormHapusApiKey.php',
        data        : {id_setting_api_key: id_setting_api_key},
        success     : function(data){
            $('#FormHapusApiKey').html(data);
            $('#NotifikasiHapusApiKey').html('');
        }
    });
});
//Proses Edit ApiKey
$('#ProsesHapusApiKey').submit(function(){
    $('#NotifikasiHapusApiKey').html('Loading...');
    var form = $('#ProsesHapusApiKey')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ApiKey/ProsesHapusApiKey.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiHapusApiKey').html(data);
            var NotifikasiHapusApiKeyBerhasil=$('#NotifikasiHapusApiKeyBerhasil').html();
            if(NotifikasiHapusApiKeyBerhasil=="Success"){
                $("#ProsesHapusApiKey")[0].reset();
                $('#ModalHapusApiKey').modal('toggle');
                $('#NotifikasiHapusApiKey').html('');
                Swal.fire(
                    'Success!',
                    'Hapus API Key Berhasil!',
                    'success'
                )
                filterAndLoadTable();
            }
        }
    });
});
//Modal Log Api Key
$('#ModalLogApiKey').on('show.bs.modal', function (e) {
    var id_setting_api_key = $(e.relatedTarget).data('id');
    $('#FormLogApiKey').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ApiKey/FormLogApiKey.php',
        data        : {id_setting_api_key: id_setting_api_key},
        success     : function(data){
            $('#FormLogApiKey').html(data);
        }
    });
});
//List Log X-Token
$('#ModalListLogTokenApiKey').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    $('#ListLogTokenApiKey').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ApiKey/ListLogTokenApiKey.php',
        data        : {GetData: GetData},
        success     : function(data){
            $('#ListLogTokenApiKey').html(data);
        }
    });
});
//List Log API Key
$('#ModalListLogApiKey').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    $('#ListLogApiKey').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ApiKey/ListLogApiKey.php',
        data        : {GetData: GetData},
        success     : function(data){
            $('#ListLogApiKey').html(data);
        }
    });
});