<?php
    if(empty($_GET['id'])){
        echo '<section class="section dashboard">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12">';
        echo '          <div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '              <small>';
        echo '                  <code class="text-dark">';
        echo '                      ID Peserta Tidak Boleh Kosong!';
        echo '                  </code>';
        echo '              </small>';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</section>';
    }else{
        $id_event_peserta=$_GET['id'];
        $id_event_peserta=validateAndSanitizeInput($id_event_peserta);
        $id_event_peserta_validasi=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event_peserta');
        //Apabila ID Peserta Event Tidak Ditemukan Pada Database
        if(empty($id_event_peserta_validasi)){
            echo '<section class="section dashboard">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12">';
            echo '          <div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '              <small>';
            echo '                  <code class="text-dark">';
            echo '                      ID Peserta Event Tidak Valid Atau Tidak Ditemukan Pada Database!';
            echo '                  </code>';
            echo '              </small>';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</section>';
        }else{
            $id_event=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event');
            $id_event_kategori=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event_kategori');
            $id_member=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_member');
            $nama=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'nama');
            $email=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'email');
            $biaya_pendaftaran=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'biaya_pendaftaran');
            $datetime=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'datetime');
            $status=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'status');
            $strtotime=strtotime($datetime);
            $TanggalDaftar=date('d/m/Y H:i', $strtotime);
            //Buka Kategori
            $kategori=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'kategori');
            //Biaya Pendaftaran
            $biaya_pendaftaran_format='Rp ' . number_format($biaya_pendaftaran, 2, ',', '.');
            //Jumlah Riwayat Transaksi
            $JumlahRiwayatTransaksi = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi FROM transaksi WHERE kode_transaksi='$id_event_peserta' AND kategori='Pendaftaran'"));
?>
        <input type="hidden" name="id_event_peserta" id="PutIdEventPeserta" value="<?php echo $id_event_peserta; ?>">
        <section class="section dashboard">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                        echo '  <small>';
                        echo '      <code class="text-dark">';
                        echo '          Berikut ini adalah halaman detail peserta yang menampilkan semua informasi detail pendaftaran peserta.';
                        echo '          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '      </code>';
                        echo '  </small>';
                        echo '</div>';
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10 mb-3">
                                    <b class="card-title">
                                        <i class="bi bi-info-circle"></i> Detail Peserta
                                    </b>
                                </div>
                                <div class="col col-md-2 mb-3">
                                    <a href="index.php?Page=Event&Sub=DetailEvent&id=<?php echo $id_event; ?>" class="btn btn-md btn-dark btn-block btn-rounded">
                                        <i class="bi bi-arrow-left-circle"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                                            1. Informasi Peserta
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
                                        <div class="accordion-body mb-4">
                                            <div class="row mt-4 mb-4">
                                                <div class="col-md-12" id="ShowDetailPesertaEvent">
                                                    <!-- Detail Peserta Event -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                            2. Riwayat Pembayaran
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class="row mt-4 mb-3">
                                                <div class="col col-md-10"></div>
                                                <div class="col col-md-2">
                                                    <button type="button" class="btn btn-md btn-rounded btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#ModalTambahTransaksiEvent" data-id="<?php echo $id_event_peserta; ?>">
                                                        <i class="bi bi-plus"></i> Tambah
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-md-12" id="ShowRiwayatPembayaranEvent">
                                                    <!-- Show Riwayat Pembayaran Event -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                            3. Log Pembayaran
                                        </button>
                                    </h2>
                                    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body mb-4">
                                            <div class="row mt-4 mb-3">
                                                <div class="col-md-12"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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