<?php
    session_start();
    include "../_Config/Connection.php";
    include "../_Config/GlobalFunction.php";
?>
<!-- Slide 1 -->
<div class="carousel-item active">
    <div class="carousel-container">
        <h2 class="animate__animated animate__fadeInDown">Selamat Datang</h2>
        <p class="animate__animated animate__fadeInUp">
            Selamat datang di platform komunikasi dan informasi bagi komunitas lari Kabupaten Kuningan, Jawa Barat. 
            Bergabunglah dengan kami untuk mendapatkan informasi terkini dan berinteraksi dengan sesama pelari
        </p>
        <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Selengkapnya</a>
    </div>
</div>
<?php
    //Menangkan xtoken dari session
    if(empty($_SESSION['xtoken'])){
        echo "Sessi Token Tidak Ada!";
    }else{
        $xtoken=$_SESSION['xtoken'];
        //Buka Fungsi List Event
        $WebEvent=WebListEvent($url_server,$xtoken);
        $WebEvent=json_decode($WebEvent, true);
        if($WebEvent['response']['code']!==200){
            echo $WebEvent['response']['message'];
        }else{
            $jumlah_event=count($WebEvent['metadata']);
            if(empty($jumlah_event)){
                echo "Tidak Ada Event Yang Ditampilkan";
            }else{
                $metadata=$WebEvent['metadata'];
                foreach($metadata as $event_list){
                    $id_event=$event_list['id_event'];
                    $tanggal_mulai=$event_list['tanggal_mulai'];
                    $tanggal_selesai=$event_list['tanggal_selesai'];
                    $mulai_pendaftaran=$event_list['mulai_pendaftaran'];
                    $selesai_pendaftaran=$event_list['selesai_pendaftaran'];
                    $nama_event=$event_list['nama_event'];
                    $keterangan=$event_list['keterangan'];
                    //Format Datetime
                    $strtotime1=strtotime($tanggal_mulai);
                    $strtotime2=strtotime($tanggal_selesai);
                    $strtotime3=strtotime($mulai_pendaftaran);
                    $strtotime4=strtotime($selesai_pendaftaran);
                    $tanggal_mulai_format=date('d F Y',$strtotime1);
                    $tanggal_selesai_format=date('d F Y',$strtotime2);
                    $mulai_pendaftaran_format=date('d F Y',$strtotime3);
                    $selesai_pendaftaran_format=date('d F Y',$strtotime4);
?>
                    <div class="carousel-item">
                        <div class="carousel-container">
                            <h2 class="animate__animated animate__fadeInDown">
                                <?php echo $nama_event; ?>
                            </h2>
                            <p class="animate__animated animate__fadeInUp">
                                <?php echo "Pelaksanaan $tanggal_mulai_format<br>"; ?>
                                <?php echo "Pendaftaran $mulai_pendaftaran_format - $selesai_pendaftaran_format<br>"; ?>
                            </p>
                            <a href="index.php?Page=DetailEvent&id=<?php echo $id_event; ?>" class="btn-get-started animate__animated animate__fadeInUp scrollto">Selengkapnya</a>
                        </div>
                    </div>
<?php
                }
            }
        }
    }
?>

<a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
    <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
</a>
<a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
    <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
</a>