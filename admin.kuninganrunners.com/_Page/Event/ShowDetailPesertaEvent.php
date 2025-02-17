<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Uang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_event_peserta'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Peserta Event Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_event_peserta=$_POST['id_event_peserta'];
            //Bersihkan Data
            $id_event_peserta=validateAndSanitizeInput($id_event_peserta);
            //Buka Data
            $id_event_peserta_validasi=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event_peserta');
            if(empty($id_event_peserta_validasi)){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                echo '          <small class="credit">';
                echo '              <code class="text-dark">';
                echo '                  Data Yang Anda Pilih Tidak Ditemukan Pada Database!';
                echo '              </code>';
                echo '          </small>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $id_event=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event');
                $id_event_kategori=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event_kategori');
                $id_member=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_member');
                $nama=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'nama');
                $email=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'email');
                $biaya_pendaftaran=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'biaya_pendaftaran');
                if(empty($biaya_pendaftaran)){
                    $biaya_pendaftaran=0;
                }
                $datetime=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'datetime');
                $status=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'status');
                $strtotime=strtotime($datetime);
                $TanggalDaftar=date('d/m/Y H:i', $strtotime);
                //Buka Kategori
                $kategori=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'kategori');
                //Biaya Pendaftaran
                $biaya_pendaftaran_format='Rp ' . number_format($biaya_pendaftaran, 2, ',', '.');
                //Jumlah Riwayat Transaksi
                $JumlahRiwayatTransaksi = mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi WHERE kode_transaksi='$id_event_peserta' AND kategori='Pendaftaran'"));
                //Buka Nama Event
                $NamaEvent=GetDetailData($Conn,'event','id_event',$id_event,'nama_event');
                //Buka Detail Member
                $kontak=GetDetailData($Conn,'member','id_member',$id_member,'kontak');
                //Buka Detail Member
                $provinsi=GetDetailData($Conn,'member','id_member',$id_member,'provinsi');
                $kabupaten=GetDetailData($Conn,'member','id_member',$id_member,'kabupaten');
                $kecamatan=GetDetailData($Conn,'member','id_member',$id_member,'kecamatan');
                $desa=GetDetailData($Conn,'member','id_member',$id_member,'desa');
                $kode_pos=GetDetailData($Conn,'member','id_member',$id_member,'kode_pos');
                $rt_rw=GetDetailData($Conn,'member','id_member',$id_member,'rt_rw');
                $status_member=GetDetailData($Conn,'member','id_member',$id_member,'status');
                $sumber=GetDetailData($Conn,'member','id_member',$id_member,'sumber');
?>
            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Nama Peserta</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish"><?php echo "$nama"; ?></code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Alamat Email</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish"><?php echo "$email"; ?></code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Kontak</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish"><?php echo "$kontak"; ?></code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Provinsi</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish">
                                    <?php echo $provinsi; ?>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Kabupaten/Kota</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish">
                                    <?php echo $kabupaten; ?>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Kecamatan</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish">
                                    <?php echo $kecamatan; ?>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Desa/Kelurahan</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish">
                                    <?php echo $desa; ?>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Kode Pos</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish">
                                    <?php echo $kode_pos; ?>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>RT/RW/Jalan</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish">
                                    <?php echo $rt_rw; ?>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Status Member</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish">
                                    <?php echo $status_member; ?>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Sumber Data</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish">
                                    <?php echo $sumber; ?>
                                </code>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Event</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish"><?php echo "$NamaEvent"; ?></code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Kategori Peserta</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish"><?php echo "$kategori"; ?></code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Biaya Pendaftaran</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish"><?php echo "$biaya_pendaftaran_format"; ?></code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Tanggal Daftar</small>
                        </div>
                        <div class="col col-md-8">
                            <small>
                                <code class="text text-grayish"><?php echo "$TanggalDaftar"; ?></code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <small>Status</small>
                        </div>
                        <div class="col col-md-8">
                            <small class="credit">
                                <?php
                                    if($status=="Lunas"){
                                        echo '<code class="text-success">Lunas</code>';
                                    }else{
                                        echo '<code class="text-danger">Pending</code>';
                                    }
                                ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
<?php
            }
        }
    }
?>