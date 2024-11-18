//Grafik Pendaftaran Member
$(document).ready(function () {
    // URL PHP yang menyediakan data JSON
    const dataUrl = '_Page/Dashboard/GrafikPendaftaranMember.php';

    // Ambil data dari PHP
    $.ajax({
        url: dataUrl,
        method: 'GET',
        success: function (response) {
            // Inisialisasi chart
            var options = {
                chart: {
                    type: 'area',
                    height: 370,
                    toolbar: {
                        show: false // Menyembunyikan toolbar
                    }
                },
                series: [{
                    name: 'Pendaftaran Member',
                    data: response // Data diambil langsung dari JSON
                }],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    title: {
                        text: 'Bulan'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Pendaftaran'
                    }
                },
                title: {
                    text: 'Pendaftaran Member Baru',
                    align: 'center'
                }
            };

            // Render chart ke elemen HTML
            var chart = new ApexCharts(document.querySelector("#GrafikPendaftaranMember"), options);
            chart.render();
        },
        error: function (error) {
            console.error('Gagal mengambil data:', error);
        }
    });
});
