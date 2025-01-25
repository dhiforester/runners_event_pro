function ShowGrafikLaporanTransaksi(initialLoad = false) {
    var chart;
    var formFilter = $('#FormFilterLaporanTransaksi');
    var filterData = initialLoad ? formFilter.serialize() : null;

    // Memuat grafik
    $.ajax({
        type: 'POST',
        url: '_Page/LaporanTransaksi/GrafikLaporanTransaksi.php',
        data: filterData,
        dataType: 'json',
        success: function(data) {
            if (chart) chart.destroy(); // Hapus chart sebelumnya

            var options = {
                chart: {
                    type: 'area',
                    height: 350
                },
                title: {
                    text: '',
                    align: 'center'
                },
                xaxis: {
                    categories: data.labels
                },
                series: [
                    { name: 'Pembelian', data: data.values.Pembelian },
                    { name: 'Pendaftaran', data: data.values.Pendaftaran }
                ]
            };
            chart = new ApexCharts(document.querySelector("#ShowGrafikLaporanTransaksi"), options);
            chart.render();
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            $('#ShowGrafikLaporanTransaksi').html('<p class="text-danger">Gagal memuat grafik. Silakan coba lagi.</p>');
        }
    });

    // Memuat tabel transaksi
    $.ajax({
        type: 'POST',
        url: '_Page/LaporanTransaksi/TabelTransaksi.php',
        data: filterData,
        success: function(data) {
            $('#MenampilkanTabelTransaksi').html(data);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            $('#MenampilkanTabelTransaksi').html('<p class="text-danger">Gagal memuat tabel. Silakan coba lagi.</p>');
        }
    });
}

$(document).ready(function() {
    // Fungsi toggle form bulan
    function toggleFormBulan() {
        $('#periode_riwayat').val() === "Bulanan" ? $('#FormBulan').hide() : $('#FormBulan').show();
    }

    $('#periode_riwayat').on('change', toggleFormBulan);
    toggleFormBulan(); // Panggil saat halaman pertama kali dimuat

    // Panggil fungsi untuk menampilkan grafik dan tabel saat halaman dimuat
    ShowGrafikLaporanTransaksi(true);

    // Event submit form
    $('#FormFilterLaporanTransaksi').submit(function(e) {
        e.preventDefault(); // Mencegah submit default
        ShowGrafikLaporanTransaksi(false); // Submit ulang dengan data form
        $('#ModalFilterGrapik').modal('hide'); // Tutup modal
    });

    //Menampilkan preview tabel export laporan
    $('#ModalExportLaporan').on('show.bs.modal', function (e) {
        var periode = $(e.relatedTarget).data('periode');
        var keyword = $(e.relatedTarget).data('keyword');
        var kategori = $(e.relatedTarget).data('kategori');
        $('#TabelPreviewLaporan').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/LaporanTransaksi/TabelPreviewLaporan.php',
            data        : {periode: periode, keyword: keyword, kategori: kategori},
            success     : function(data){
                $('#TabelPreviewLaporan').html(data);
            }
        });
    });
});
