<!-- Page Title -->
<div class="sub-page-title dark-background">
</div>
<section id="service-details" class="service-details section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-3">
                <h4>
                    <i class="bi bi-calendar"></i> Detail Event
                </h4>
                <small>
                    Berikut ini adalah halaman detail event yang menampilkan secara lengkap informasi event yang anda pilih.
                </small>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <div class="btn-group">
                    <a href="index.php" class="btn btn-sm btn-outline-dark">
                        <i class="bi bi-house"></i> Beranda
                    </a>
                    <?php if(!empty($_SESSION['id_member_login'])){ ?>
                        <a href="index.php?Page=Profil" class="btn btn-sm btn-outline-dark">
                            <i class="bi bi-person-circle"></i> Profil
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php
    //Apabila ID Tidak Ada
    if(empty($_GET['id'])){
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
    }else{
        //Buat Variabel
        $id_event=$_GET['id'];
        $id_event=validateAndSanitizeInput($id_event);
        $GetDetailEvent=DetailEvent($url_server,$xtoken,$id_event);
        $response=json_decode($GetDetailEvent,true);
        //Apabila Terjadi Kesalahan Pada Saat Memperpanjang Session
        if($response['response']['code']!==200){
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
            $tanggal_mulai_format=date('d F Y (H:i T)',$strtotime1);
            $tanggal_selesai_format=date('d/m/Y H:i',$strtotime2);
            $mulai_pendaftaran_format=date('d/m/Y (H:i T)',$strtotime3);
            $selesai_pendaftaran_format=date('d/m/Y( H:i T)',$strtotime4);
            //Mengubah Image Ke base 64
            $image_data = base64_encode(file_get_contents($poster));
            $base64_image = "data:image/png;base64,$image_data";
?>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box_custome">
                            <div class="box_custome_header">
                                <h4>
                                    <?php echo "$nama_event"; ?>
                                </h4>
                            </div>
                            <div class="box_custome_content">
                                <div class="row mb-3">
                                    <div class="col-md-3 mb-3">
                                        <img src="<?php echo $base64_image; ?>" alt="" class="img-fluid" width="100%">
                                    </div>
                                    <div class="col-md-9 mb-3">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <small>Keterangan/Deskripsi</small>
                                            </div>
                                            <div class="col-md-8">
                                                <small>
                                                    <code class="text text-grayish"><?php echo "$keterangan"; ?></code>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <small>Pelaksanaan</small>
                                            </div>
                                            <div class="col-md-8">
                                                <small>
                                                    <code class="text-grayish"><?php echo "$tanggal_mulai_format"; ?></code>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <small>Pendaftaran</small>
                                            </div>
                                            <div class="col-md-8">
                                                <small>
                                                    <code class="text-grayish"><?php echo "$mulai_pendaftaran_format - $selesai_pendaftaran_format"; ?></code>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <small>Kategori Event</small>
                                            </div>
                                            <div class="col-md-8">
                                                <small class="credit">
                                                    <code class="text-grayish">
                                                        <ol>
                                                            <?php
                                                                foreach($kategori as $list_kategori){
                                                                    $nama_kategori=$list_kategori['kategori'];
                                                                    $deskripsi=$list_kategori['deskripsi'];
                                                                    $biaya_pendaftaran=$list_kategori['biaya_pendaftaran'];
                                                                    if(empty($biaya_pendaftaran)){
                                                                        $biaya_pendaftaran=0;
                                                                    }
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
                                                    </code>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php
                                            //Apabila Belum Login
                                            if(empty($_SESSION['id_member_login'])){
                                                echo '<div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
                                                echo '  <small class="credit">';
                                                echo '      Untuk dapat mengikuti event ini, anda harus';
                                                echo '      <a href="index.php?Page=Login">Login/Daftar</a> ';
                                                echo '      terlebih dulu.';
                                                echo '  </small>';
                                                echo '</div>';
                                                //Buatkan Session url_back untuk kembali ke halaman ini
                                                $_SESSION['url_back']="index.php?Page=DetailEvent&id=$id_event";
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
                                                }else{
                                                    $ada=0;
                                                    $id_event_peserta="";
                                                    foreach($RiwayatEventArry['metadata'] as $ListRiwayatEvent){
                                                        $id_event_peserta=$ListRiwayatEvent['id_event_peserta'];
                                                        $event=$ListRiwayatEvent['event'];
                                                        $id_event_list=$event['id_event'];
                                                        if($id_event_list==$id_event){
                                                            $ada=$ada+1;
                                                            $id_event_peserta=$ListRiwayatEvent['id_event_peserta'];
                                                        }
                                                    }
                                                    if(empty($ada)){
                                                        echo '  <a href="javascript:void(0);" class="button_pendaftaran" data-bs-toggle="modal" data-bs-target="#ModalPendaftaranEvent">';
                                                        echo '      <i class="bi bi-pencil"></i> Form Pendaftaran';
                                                        echo '  </a>';
                                                    }else{
                                                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                                                        echo '  <small>Anda sudah terdaftar untuk event ini!</small>';
                                                        echo '  <small>Lihat detail status pendaftaran anda pada <a href="index.php?Page=DetailPendaftaranEvent&id='.$id_event_peserta.'">tautan ini</a></small>';
                                                        echo '</div>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
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
                        <div class="box_custome">
                            <div class="box_custome_header">
                                <h4>
                                    <i class="bi bi-person"></i> Peserta Event
                                </h4>
                            </div>
                            <div class="box_custome_content">
                                <div class="row mb-4">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-4">
                                        <form action="javascript:void(0);" id="FormPencarianPeserta">
                                            <input type="hidden" id="curent_page" value="1">
                                            <input type="hidden" id="put_id_event" value="<?php echo "$id_event"; ?>">
                                            <div class="input-group">
                                                <input type="text" name="keyword" id="keyword_peserta" class="form-control" placeholder="Cari">
                                                <button typpe="submit" class="btn btn-md btn-dark">
                                                    <i class="bi bi-search"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="table table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left"><b>ID</b></th>
                                                        <th class="text-left"><b>Nama Peserta</b></th>
                                                        <th class="text-left"><b>Kategori Event</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="TabelPesertaEvent">
                                                    <tr>
                                                        <td colspan="3" class="text-center">Belum Ada Proses</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-md btn-primary" id="PrevButton">
                                                <i class="bi bi-chevron-left"></i>
                                            </button>
                                            <button type="button" disabled class="btn btn-md btn-outline-primary" id="PageButton">
                                                0/100
                                            </button>
                                            <button type="button" class="btn btn-md btn-primary" id="NextButton">
                                                <i class="bi bi-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="ModalPendaftaranEvent" tabindex="-1">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <form action="javascript:void(0);" id="ProsesPendaftaranEvent">
                            <input type="hidden" name="id_event" value="<?php echo $id_event; ?>">
                            <div class="modal-header border-0">
                                <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Pendaftaran Event</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="email">Email Member</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="inputGroupPrepend">
                                                <small>
                                                    <i class="bi bi-envelope"></i>
                                                </small>
                                            </span>
                                            <input type="email" class="form-control" readonly name="email" id="email" value="<?php echo $_SESSION['email']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        Pilih Kategori Event
                                        <?php
                                            foreach($kategori as $list_kategori){
                                                $id_event_kategori=$list_kategori['id_event_kategori'];
                                                $nama_kategori=$list_kategori['kategori'];
                                                $deskripsi=$list_kategori['deskripsi'];
                                                $biaya_pendaftaran=$list_kategori['biaya_pendaftaran'];
                                                if(empty($biaya_pendaftaran)){
                                                    $biaya_pendaftaran=0;
                                                }
                                                //Format Rupiah
                                                $BiayaPendaftaran="Rp " . number_format($biaya_pendaftaran, 0, ',', '.');
                                                echo '<div class="form-check mb-3">';
                                                echo '  <input class="form-check-input" type="radio" name="id_event_kategori" id="id_event_kategori'.$id_event_kategori.'" value="'.$id_event_kategori.'">';
                                                echo '  <label class="form-check-label" for="id_event_kategori'.$id_event_kategori.'">';
                                                echo '      <small>'.$nama_kategori.' ('.$BiayaPendaftaran.')</small><br>';
                                                echo '      <small><code class="text text-grayish">'.$deskripsi.'</code></small>';
                                                echo '  </label>';
                                                echo '</div>';
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12" id="NotifikasiPendaftaranEvent">
                                        <!-- Notifikasi Pendaftaran Akan Muncul Disini -->
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="submit" class="css-button-fully-rounded--green" id="ButtonPendaftaranEvent">
                                    <i class="bi bi-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
<?php
        }
    }
?>
</section>

