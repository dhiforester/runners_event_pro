<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

    if (empty($SessionIdAkses)) {
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Ulang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    } else {
        if (empty($_POST['id_event'])) {
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Event Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        } else {
            $id_event = validateAndSanitizeInput($_POST['id_event']);
            // Validasi apakah data event ada di database
            $id_event_validasi = GetDetailData($Conn, 'event', 'id_event', $id_event, 'id_event');

            if (empty($id_event_validasi)) {
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
                echo '          <small class="credit">';
                echo '              <code class="text-dark">';
                echo '                  Data Yang Anda Pilih Tidak Ditemukan Pada Database!';
                echo '              </code>';
                echo '          </small>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            } else {
                $rute = GetDetailData($Conn, 'event', 'id_event', $id_event, 'rute');
                $rute_path = __DIR__ . "/../../assets/img/Rute/" . basename($rute);
                // Pastikan file rute ada dan merupakan file yang aman untuk ditampilkan
                if (!file_exists($rute_path)) {
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12">';
                    echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
                    echo '          <small class="credit">';
                    echo '              <code class="text-dark">';
                    echo '                  Rute tidak ditemukan pada directory yang dimaksud: ' . htmlspecialchars($rute_path) . '';
                    echo '              </code>';
                    echo '          </small>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                } else {
                    if (!in_array(pathinfo($rute_path, PATHINFO_EXTENSION), ['gpx'])) {
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-12">';
                        echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
                        echo '          <small class="credit">';
                        echo '              <code class="text-dark">';
                        echo '                  File Rute memiliki format tidak didukung.';
                        echo '              </code>';
                        echo '          </small>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    } else {
                       // Membaca file GPX dan mengekstrak data elevasi
                        $xml = simplexml_load_file($rute_path);
                        $elevation_data = [];

                        foreach ($xml->trk->trkseg->trkpt as $trkpt) {
                            $lat = (float) $trkpt['lat'];
                            $lon = (float) $trkpt['lon'];
                            $ele = (float) $trkpt->ele;
                            $elevation_data[] = ['lat' => $lat, 'lon' => $lon, 'elevation' => $ele];
                        }

                        // Mengubah data elevasi ke format JSON
                        $elevation_json = json_encode($elevation_data);
?>
                    <script>
                        var elevationData = <?php echo $elevation_json; ?>;
                    </script>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <a href="<?php echo "$base_url/MapRute.php?id=$id_event"; ?>" class="btn btn-md btn-primary btn-rounded">
                                Tampilkan Layar Penuh
                            </a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <iframe src="<?php echo "$base_url/MapRute.php?id=$id_event"; ?>" style="width: 100%; height: 400px; border: none;"></iframe>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="ChartRute">
                            
                        </div>
                    </div>
                    <script>
                       // Inisialisasi data elevasi dan jarak kumulatif
                        var distance = 0;
                        var elevationDataSeries = elevationData.map(function(point, index) {
                            if (index > 0) {
                                var prevPoint = elevationData[index - 1];
                                var lat1 = prevPoint.lat;
                                var lon1 = prevPoint.lon;
                                var lat2 = point.lat;
                                var lon2 = point.lon;

                                // Menghitung jarak menggunakan Haversine formula
                                var R = 6371e3; // Radius Bumi dalam meter
                                var φ1 = lat1 * Math.PI / 180;
                                var φ2 = lat2 * Math.PI / 180;
                                var Δφ = (lat2 - lat1) * Math.PI / 180;
                                var Δλ = (lon2 - lon1) * Math.PI / 180;

                                var a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                                        Math.cos(φ1) * Math.cos(φ2) *
                                        Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
                                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

                                var d = R * c; // Jarak antara dua titik
                                distance += d;
                            }
                            return [distance, point.elevation];
                        });

                       // Konfigurasi ApexCharts dengan warna yang lebih jelas
                        var options = {
                            chart: {
                                type: 'line',
                                height: 400,
                                toolbar: {
                                    show: false
                                }
                            },
                            series: [{
                                name: 'Elevasi',
                                data: elevationDataSeries
                            }],
                            xaxis: {
                                type: 'numeric',
                                title: {
                                    text: 'Jarak (m)'
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Elevasi (m)'
                                }
                            },
                            tooltip: {
                                x: {
                                    formatter: function(value) {
                                        return value.toFixed(2) + ' m';
                                    }
                                },
                                y: {
                                    formatter: function(value) {
                                        return value.toFixed(2) + ' m';
                                    }
                                }
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 3, // Menambah ketebalan garis agar lebih jelas
                                colors: ['#FF5733'] // Warna garis yang lebih mencolok
                            },
                            markers: {
                                size: 0 // Menyembunyikan titik pada garis
                            },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.9, // Mengatur transparansi untuk membuat garis tetap terlihat
                                    opacityTo: 0.8,
                                    stops: [0, 90, 100]
                                }
                            }
                        };

                        // Menampilkan grafik dengan ApexCharts
                        var chart = new ApexCharts(document.querySelector("#ChartRute"), options);
                        chart.render();

                    </script>
<?php
                    }
                }
            }
        }
    }
?>
