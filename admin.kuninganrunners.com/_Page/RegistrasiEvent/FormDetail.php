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
        if(empty($_POST['kode_transaksi'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  Kode Transaksi Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $kode_transaksi=$_POST['kode_transaksi'];
            //Bersihkan Data
            $kode_transaksi=validateAndSanitizeInput($kode_transaksi);
            //Buka Data
            $kode_transaksi_validasi=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kode_transaksi');
            if(empty($kode_transaksi_validasi)){
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
                $id_member=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'id_member');
                $raw_member=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'raw_member');
                $kategori=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kategori');
                $datetime=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'datetime');
                $jumlah=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'jumlah');
                $status=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'status');
                //Buka Data Event Peserta
                $id_event=GetDetailData($Conn,'event_peserta','id_event_peserta',$kode_transaksi,'id_event');
                $nama=GetDetailData($Conn,'event_peserta','id_event_peserta',$kode_transaksi,'nama');
                $email=GetDetailData($Conn,'event_peserta','id_event_peserta',$kode_transaksi,'email');
                $biaya_pendaftaran=GetDetailData($Conn,'event_peserta','id_event_peserta',$kode_transaksi,'biaya_pendaftaran');
                $status=GetDetailData($Conn,'event_peserta','id_event_peserta',$kode_transaksi,'status');
                //Buka Data Event
                $nama_event=GetDetailData($Conn,'event','id_event',$id_event,'nama_event');
                $tanggal_mulai=GetDetailData($Conn,'event','id_event',$id_event,'tanggal_mulai');
                //format Data Tanggal Transaksi
                $strtotime1=strtotime($datetime);
                $tanggal_transaksi=date('d M Y H:i',$strtotime1);
                //format Data Tanggal Event
                $strtotime2=strtotime($tanggal_mulai);
                $TanggalMulaiFormat=date('d M Y H:i',$strtotime2);
                //Format Rupiah
                $JumlahPembayaran='Rp ' . number_format($jumlah, 2, ',', '.');
                //Routing Label Status
                if($status=="Lunas"){
                    $LabelStatus='<code class="text-success">Lunas</code>';
                }else{
                    $LabelStatus='<code class="text-danger">Pending</code>';
                }
                //Buat Session URL_back
                $_SESSION['urll_back']="index.php?Page=RegistrasiEvent";
?>
                <input type="hidden" name="Page" value="Event">
                <input type="hidden" name="Sub" value="Detail">
                <input type="hidden" name="Sub" value="DetailPeserta">
                <input type="hidden" name="id" value="<?php echo $kode_transaksi; ?>">
                <div class="row mb-3">
                    <div class="col col-md-4"><small class="credit">Nama Event</small></div>
                    <div class="col col-md-8">
                        <small class="credit">
                            <code class="text text-grayish"><?php echo "$nama_event"; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-4 mb-3"><small class="credit">Tgl.Event</small></div>
                    <div class="col col-md-8 mb-3">
                        <small class="credit">
                            <code class="text text-grayish"><?php echo "$TanggalMulaiFormat"; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-4 mb-3"><small class="credit">Kategori</small></div>
                    <div class="col col-md-8 mb-3">
                        <small class="credit">
                            <code class="text text-grayish"><?php echo "$kategori"; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-4 mb-3"><small class="credit">Biaya Pendaftaran</small></div>
                    <div class="col col-md-8 mb-3">
                        <small class="credit">
                            <code class="text text-grayish"><?php echo "$JumlahPembayaran"; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-4 mb-3"><small class="credit">Nama Peserta</small></div>
                    <div class="col col-md-8 mb-3">
                        <small class="credit">
                            <code class="text text-grayish"><?php echo "$nama"; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-4 mb-3"><small class="credit">Email</small></div>
                    <div class="col col-md-8 mb-3">
                        <small class="credit">
                            <code class="text text-grayish"><?php echo "$email"; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-4 mb-3"><small class="credit">Status</small></div>
                    <div class="col col-md-8 mb-3">
                        <small class="credit">
                            <?php echo "$LabelStatus"; ?>
                        </small>
                    </div>
                </div>
<?php
            }
        }
    }
?>