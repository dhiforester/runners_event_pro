//Fungsi Untuk Menampilkan Cart Rekapitulasi Aktivitas Fitur
function GrafikViewer() {
    // Ambil data dari server menggunakan AJAX
    $.ajax({
        url     : '_Page/Viewer/ProsesMembuatGrafikViewer.php',
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
                    name: 'Pengunjung Web',
                    data: amounts
                }],
                xaxis: {
                    categories: months // Kategori sumbu x
                }
            };

            // Inisialisasi dan render grafik
            const chart = new ApexCharts(document.querySelector("#GrafikViewer"), options);
            chart.render();
        },
        error: function(error) {
            console.error("Error fetching data", error);
        }
    });
}
//Fungsi Untuk Menampilkan Data Tabel
function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Viewer/TabelViewer.php',
        data 	    :  ProsesFilter,
        success     : function(data){
            $('#MenampilkanTabelViewer').html(data);
        }
    });
}
//Menampilkan Data Pertama Kali
$(document).ready(function() {
    //Load Pertama Kali
    GrafikViewer();
    filterAndLoadTable();
    //Kondisi Ketika Keyword By Diubah
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Viewer/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });
    //Kondisi Ketika Modal Filter Muncul
    $('#ProsesFilter').submit(function(){
        filterAndLoadTable();
        $('#ModalFilter').modal('toggle');
    });
    //Apabila Tombol Hapus Di Konfirmasi
    $('#ProsesHapusItemLog').submit(function() {
        var ProsesHapusItemLog = $('#ProsesHapusItemLog').serialize();
        $('#NotifikasiHapusItemLog').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Viewer/ProsesHapusItemLog.php',
            data 	    :  ProsesHapusItemLog,
            success     : function(data){
                $('#NotifikasiHapusItemLog').html(data);
                var NotifikasiHapusItemLogBerhasil=$('#NotifikasiHapusItemLogBerhasil').html();
                if(NotifikasiHapusItemLogBerhasil=="Success"){
                    filterAndLoadTable();
                    $('#ModalHapusItemLog').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Hapus Log Viewer Berhasil!',
                        'success'
                    )
                }
            }
        });
    });
    //Kondisi Ketika Modal Stat Muncul
    $('#ModalStat').on('show.bs.modal', function (e) {
        var GetData = $(e.relatedTarget).data('id');
        // Memisahkan data berdasarkan tanda strip (-)
        var dataParts = GetData.split('-'); // Hasil: ["123", "Keyword"]

        // Mengakses masing-masing bagian
        var keyword_by = dataParts[0];
        var keyword = dataParts[1];
        //Memasukan Kedalam Form
        $('#SearchBy').val(keyword_by);
        $('#SearchKeyword').val(keyword);
        //Menampilkan Form Periode
        var Rekapitulasi =$('#Rekapitulasi').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Viewer/PeriodeStatForm.php',
            data 	    :  {Rekapitulasi: Rekapitulasi},
            success     : function(data){
                $('#PeriodeStatForm').html(data);
                $('#TabelStatViewer').html("");
            }
        });
    });
    //Kondisi Jika Rekapitulasi Diubah
    $('#Rekapitulasi').change(function(){
        var Rekapitulasi =$('#Rekapitulasi').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Viewer/PeriodeStatForm.php',
            data        : {Rekapitulasi: Rekapitulasi},
            success     : function(data){
                $('#PeriodeStatForm').html(data);
            }
        });
    });
    //Proses Data Ditampilkan
    $('#FormFilterStat').on('submit', function (e) {
        var FormFilterStat = $('#FormFilterStat').serialize();
        $.ajax({
            type    : 'POST',
            url     : '_Page/Viewer/TabelStatViewer.php',
            data    : FormFilterStat,
            success: function(data) {
                $('#TabelStatViewer').html(data);
            }
        });
    });
});