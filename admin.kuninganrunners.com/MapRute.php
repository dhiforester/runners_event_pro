<?php
    date_default_timezone_set('Asia/Jakarta');
    include "_Config/Connection.php";
    include "_Config/GlobalFunction.php";
    include "_Config/Session.php";
    include "_Config/SettingGeneral.php";
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
        if (empty($_GET['id'])) {
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
            $id_event = validateAndSanitizeInput($_GET['id']);
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
                $rute_path = "assets/img/Rute/" . basename($rute);
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
?>
                        <!DOCTYPE html>
                        <html lang="id">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>Peta Event</title>
                                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css">
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-gpx/1.3.1/gpx.min.js"></script>
                                <style>
                                    #map {
                                        width: 100%;
                                        height: 100vh; /* Mengatur tinggi peta untuk menggunakan seluruh tinggi layar */
                                    }
                                    .leaflet-container {
                                        height: 100vh;
                                        width: 100%;
                                        display: flex;
                                        justify-content: center;
                                        align-items: center;
                                    }
                                </style>
                            </head>
                            <body>
                                <div id="map"></div>
                                <script>
                                    var map;
                                    function initMap() {
                                        map = L.map('map').setView([-6.9329, 107.6024], 13); // Koordinat default
                                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                            maxZoom: 18,
                                            attribution: '© OpenStreetMap contributors'
                                        }).addTo(map);
                                        var gpxFile = 'assets/img/Rute/<?php echo $rute; ?>'; // Path file GPX
                                        new L.GPX(gpxFile, {
                                            async: true,
                                            marker_options: {
                                                startIconUrl: 'https://leafletjs.com/examples/custom-icons/leaf-green.png',
                                                endIconUrl: 'https://leafletjs.com/examples/custom-icons/leaf-red.png',
                                                shadowUrl: 'https://leafletjs.com/examples/custom-icons/leaf-shadow.png'
                                            }
                                        }).on('loaded', function(e) {
                                            map.fitBounds(e.target.getBounds()); // Menyesuaikan peta dengan batas rute
                                        }).addTo(map);
                                    }
                                    document.addEventListener("DOMContentLoaded", function() {
                                        initMap();
                                    });
                                </script>
                            </body>
                        </html>
<?php
                    }
                }
            }
        }
    }
?>
