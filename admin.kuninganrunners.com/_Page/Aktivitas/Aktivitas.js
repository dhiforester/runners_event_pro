//Fungsi Untuk Menampilkan Cart Rekapitulasi Aktivitas Fitur
function LoadRekapitulasiAktivitasUmum() {
    // Ambil data dari server menggunakan AJAX
    $.ajax({
        url     : '_Page/Aktivitas/ProsesGrafikAktivitas.php',
        type    : 'GET',
        dataType: 'json',
        success: function(response) {
            // Dapatkan data dari respons
            const months = response.months;
            const amounts = response.amounts;

            // Konfigurasi untuk grafik
            const options = {
                chart: {
                    type: 'area', // Jenis grafik
                    height: 350
                },
                series: [{
                    name: 'Aktivitas',
                    data: amounts
                }],
                xaxis: {
                    categories: months // Kategori sumbu x
                }
            };

            // Inisialisasi dan render grafik
            const chart = new ApexCharts(document.querySelector("#reportsChart"), options);
            chart.render();
        },
        error: function(error) {
            console.error("Error fetching data", error);
        }
    });
}
//Fungsi Untuk Menampilkan Cart Aktivitas APIS
function GrafikAktivitasBy() {
    var FormGrafikBy = $('#FormGrafikBy').serialize();
    // Ambil data dari server menggunakan AJAX
    $.ajax({
        url     : '_Page/Aktivitas/ProsesGrafikAktivitasBy.php',
        type    : 'POST',
        data    : FormGrafikBy,
        dataType: 'json',
        success: function(response) {
            // Dapatkan data dari respons
            const months = response.months;
            const amounts = response.amounts;

            // Konfigurasi untuk grafik
            const options = {
                chart: {
                    type: 'bar', // Jenis grafik
                    height: 500
                },
                plotOptions: {
                    bar: {
                        horizontal: true
                    }
                },
                series: [{
                    name: 'Aktivitas',
                    data: amounts
                }],
                xaxis: {
                    categories: months // Kategori sumbu x
                }
            };

            // Inisialisasi dan render grafik
            const chart = new ApexCharts(document.querySelector("#GrafikAktivitasBy"), options);
            chart.render();
        },
        error: function(error) {
            console.error("Error fetching data", error);
        }
    });
}
//Fungsi Untuk Menampilkan Data Aktivitas Umum
function filterAndLoadTableLogAktivitas() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Aktivitas/TabelAktivitas.php',
        data 	    :  ProsesFilter,
        success     : function(data){
            $('#MenampilkanTabelAktivitasUmum').html(data);
        }
    });
}

//Menampilkan Data Pertama Kali
$(document).ready(function() {
    //Load Pertama Kali
    filterAndLoadTableLogAktivitas();
    LoadRekapitulasiAktivitasUmum();
    //Ketika keyword_by Diubah
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Aktivitas/FormFilter.php',
            data 	    :  {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });
    //Ketika Dilakukan Pencarian
    $('#ProsesFilter').submit(function(){
        filterAndLoadTableLogAktivitas();
        $('#ModalFilterAktivitasUmum').modal('hide');
    });
    //Kondisi Pertama Kali Modal Grafik Muncul
    $('#ModalGrafik').on('show.bs.modal', function (e) {
        var GetData = $(e.relatedTarget).data('id');
        $('#select_data').val(GetData);
        GrafikAktivitasBy();
    });
    //Kondisi Ketika Mode Data Berubah
    $('#mode_data').change(function(){
        var mode_data = $('#mode_data').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Aktivitas/FormPeriode.php',
            data 	    :  {mode_data: mode_data},
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#FormPeriode').html(data);
            }
        });
    });
    //Kondisi Ketika FormGrafikBy Submit
    $('#FormGrafikBy').submit(function(){
        GrafikAktivitasBy();
    });
    //Apabila Tombol Hapus Di Konfirmasi
    $('#ProsesHapusItemLogAktivitas').submit(function() {
        var ProsesHapusItemLogAktivitas = $('#ProsesHapusItemLogAktivitas').serialize();
        $('#NotifikasiHapusItemLog').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Aktivitas/ProsesHapusItemLog.php',
            data 	    :  ProsesHapusItemLogAktivitas,
            success     : function(data){
                $('#NotifikasiHapusItemLog').html(data);
                var NotifikasiHapusItemLogBerhasil=$('#NotifikasiHapusItemLogBerhasil').html();
                if(NotifikasiHapusItemLogBerhasil=="Success"){
                    filterAndLoadTableLogAktivitas();
                    $('#ModalHapusItemLog').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Hapus Log Aktivitas Berhasil!',
                        'success'
                    )
                }
            }
        });
    });
});