<!-- Page Title -->
<div class="sub-page-title dark-background">
</div>
<!-- End Page Title -->
<?php
    //Apabila ID Tidak Ada
    if(empty($_GET['id'])){
        echo '<section id="service-details mt-5" class="service-details section">';
        echo '  <div class="container">';
        echo '      <div class="row gy-5">';
        echo '          <div class="col-md-4"></div>';
        echo '              <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">';
        echo '                  <div class="service-box">';
        echo '                      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '                          <small>';
        echo '                              ID Event Tidak Boleh Kosong!';
        echo '                          </small>';
        echo '                      </div>';
        echo '                  </div>';
        echo '              </div>';
        echo '          <div class="col-md-4"></div>';
        echo '      </div>';
        echo '  </div>';
        echo '</section>';
    }else{
        //Buat Variabel
        $id_event=$_GET['id'];
        $id_event=validateAndSanitizeInput($id_event);
        $GetDetailEvent=DetailEvent($url_server,$xtoken,$id_event);
        $response=json_decode($GetDetailEvent,true);
        //Apabila Terjadi Kesalahan Pada Saat Memperpanjang Session
        if($response['response']['code']!==200){
            echo '<section id="service-details mt-5" class="service-details section">';
            echo '  <div class="container">';
            echo '      <div class="row gy-5">';
            echo '          <div class="col-md-4"></div>';
            echo '              <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">';
            echo '                  <div class="service-box">';
            echo '                      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '                          <small>';
            echo '                              '.$response['response']['message'].'';
            echo '                          </small>';
            echo '                      </div>';
            echo '                  </div>';
            echo '              </div>';
            echo '          <div class="col-md-4"></div>';
            echo '      </div>';
            echo '  </div>';
            echo '</section>';
        }else{
            $metadata=$response['metadata'];
            $tanggal_mulai=$metadata['tanggal_mulai'];
            $tanggal_selesai=$metadata['tanggal_selesai'];
            $mulai_pendaftaran=$metadata['mulai_pendaftaran'];
            $selesai_pendaftaran=$metadata['selesai_pendaftaran'];
            $nama_event=$metadata['nama_event'];
            $keterangan=$metadata['keterangan'];
            $poster=$metadata['poster'];
            $rute=$metadata['rute'];
            $kategori=$metadata['kategori'];
            $strtotime1=strtotime($tanggal_mulai);
            $strtotime2=strtotime($tanggal_selesai);
            $strtotime3=strtotime($mulai_pendaftaran);
            $strtotime4=strtotime($selesai_pendaftaran);
            $tanggal_mulai_format=date('d/m/Y H:i',$strtotime1);
            $tanggal_selesai_format=date('d/m/Y H:i',$strtotime2);
            $mulai_pendaftaran_format=date('d/m/Y H:i',$strtotime3);
            $selesai_pendaftaran_format=date('d/m/Y H:i',$strtotime4);
            //Mengubah Image Ke base 64
            $image_data = base64_encode(file_get_contents($poster));
            $base64_image = "data:image/png;base64,$image_data";
?>
            <section id="service-details" class="service-details section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="box_custome">
                                <div class="box_custome_header">
                                    <h4>
                                        <i class="bi bi-image"></i> Poster Event
                                    </h4>
                                </div>
                                <div class="box_custome_content">
                                    <img src="<?php echo $base64_image; ?>" alt="" class="img-fluid" width="100%">
                                </div>
                            </div>
                            <?php
                                //Apabila Belum Login
                                if(empty($_SESSION['id_member_login'])){
                                    echo '<div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
                                    echo '  <small class="credit">';
                                    echo '      Untuk mengikuti event ini, anda harus';
                                    echo '      <a href="index.php?Page=Login">Login/Daftar</a> ';
                                    echo '      terlebih dulu.';
                                    echo '  </small>';
                                    echo '</div>';
                                }else{
                                    //Cek Apakah Member Sudah mendaftar Untuk Event Ini
                                    $id_member_login=$_SESSION['id_member_login'];
                                    $email=$_SESSION['email'];
                                    $RiwayatEvent=RiwayatEventMember($url_server,$xtoken,$email,$id_member_login);
                                    $RiwayatEventArry=json_decode($RiwayatEvent, true);
                                    if(empty(count($RiwayatEventArry['metadata']))){
                                        echo '  <a href="javascript:void(0);" class="button_pendaftaran" data-bs-toggle="modal" data-bs-target="#ModalPendaftaranEvent">';
                                        echo '      <i class="bi bi-pencil"></i> Form Pendaftaran';
                                        echo '  </a>';
                                    }
                                }
                            ?>
                        </div>
                        <div class="col-md-8">
                            <div class="box_custome">
                                <div class="box_custome_header">
                                    <h4>
                                        <i class="bi bi-info-circle"></i> Detail Event
                                    </h4>
                                </div>
                                <div class="box_custome_content">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <small>Nama/Judul Event</small>
                                        </div>
                                        <div class="col-md-8">
                                            <small>
                                                <code class="text-dark"><?php echo "$nama_event"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <small>Keterangan/Deskripsi</small>
                                        </div>
                                        <div class="col-md-8">
                                            <small>
                                                <code class="text-dark"><?php echo "$keterangan"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <small>Pendaftaran (Mulai)</small>
                                        </div>
                                        <div class="col-md-8">
                                            <small>
                                                <code class="text-dark"><?php echo "$tanggal_mulai_format"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <small>Pendaftaran (Selesai)</small>
                                        </div>
                                        <div class="col-md-8">
                                            <small>
                                                <code class="text-dark"><?php echo "$tanggal_selesai_format"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <small>Pelaksanaan (Mulai)</small>
                                        </div>
                                        <div class="col-md-8">
                                            <small>
                                                <code class="text-dark"><?php echo "$mulai_pendaftaran_format"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <small>Pelaksanaan (Selesai)</small>
                                        </div>
                                        <div class="col-md-8">
                                            <small>
                                                <code class="text-dark"><?php echo "$selesai_pendaftaran_format"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box_custome">
                                <div class="box_custome_header">
                                    <h4>
                                        <i class="bi bi-tag"></i> Kategori Event
                                    </h4>
                                </div>
                                <div class="box_custome_content">
                                    <ol>
                                        <?php
                                            foreach($kategori as $list_kategori){
                                                $nama_kategori=$list_kategori['kategori'];
                                                $deskripsi=$list_kategori['deskripsi'];
                                                $biaya_pendaftaran=$list_kategori['biaya_pendaftaran'];
                                                //Format Rupiah
                                                $BiayaPendaftaran="Rp " . number_format($biaya_pendaftaran, 0, ',', '.');
                                                echo '<li class="mb-3">';
                                                echo '  '.$nama_kategori.'<br>';
                                                echo '  <small>'.$deskripsi.'</small><br>';
                                                echo '  <small>Baiaya Pendafataran : <span class="text-info">'.$BiayaPendaftaran.'</span></small><br>';
                                                echo '';
                                                echo '</li>';
                                            }
                                        ?>
                                    </ol>
                                </div>
                            </div>
                            <div class="box_custome">
                                <div class="box_custome_header">
                                    <h4>
                                        <i class="bi bi-map"></i> Map & Elevation
                                    </h4>
                                </div>
                                <div class="box_custome_content" id="ShowRuteEvent">
                                    <?php
                                        if (!in_array(pathinfo($rute, PATHINFO_EXTENSION), ['gpx'])) {
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
                                            $xml = simplexml_load_file($rute);
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
                                            <iframe src="<?php echo "$url_server/MapRute.php?id=$id_event"; ?>" style="width: 100%; height: 400px; border: none;"></iframe>
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
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
<?php
        }
    }
?>

