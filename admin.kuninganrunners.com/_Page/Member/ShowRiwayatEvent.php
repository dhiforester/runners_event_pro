<?php
    if(empty($_POST['id_member'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '          ID Member Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Koneksi
        $id_member=$_POST['id_member'];
        date_default_timezone_set('Asia/Jakarta');
        include "../../_Config/Connection.php";
        include "../../_Config/SettingGeneral.php";
        include "../../_Config/GlobalFunction.php";
        include "../../_Config/Session.php";
        //Hitung Jumlah Data
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_peserta FROM event_peserta WHERE id_member='$id_member'"));
        if(empty($jml_data)){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '          Belum ada riwayat pendaftaran pada event manapun';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            echo '<div class="list-group"> ';
            //Tampilkan Data
            $no=1;
            $query = mysqli_query($Conn, "SELECT*FROM event_peserta WHERE id_member='$id_member' ORDER BY datetime DESC");
            while ($data = mysqli_fetch_array($query)) {
                $id_event_peserta= $data['id_event_peserta'];
                $id_event= $data['id_event'];
                $id_event_kategori= $data['id_event_kategori'];
                $biaya_pendaftaran= $data['biaya_pendaftaran'];
                $datetime= $data['datetime'];
                $status= $data['status'];
                //Buka Nama Event
                $nama_event=GetDetailData($Conn,'event','id_event',$id_event,'nama_event');
                //Buka Tanggal Pelaksanssn
                $tanggal_mulai=GetDetailData($Conn,'event','id_event',$id_event,'tanggal_mulai');
                //Buka Nama Kategori
                $nama_kategori=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'kategori');
                //Format Tanggal
                $Pelaksanaan=date('d/m/Y',strtotime($tanggal_mulai));
                $Daftar=date('d/m/Y',strtotime($datetime));
                //Format Biaya Pendaftaran
                $biaya_pendaftaran_format='Rp ' . number_format($biaya_pendaftaran, 0, ',', '.');
                //Buka Kode Transaksi
                $kode_transaksi=GetDetailData($Conn,'transaksi','kode_transaksi',$id_event_peserta,'kode_transaksi');
?>
                <div class="list-group-item list-group-item-action" aria-current="true">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <a href="javascript:void(0);" class="text text-decoration-underline" data-bs-toggle="modal" data-bs-target="#ModalDetailEventPeserta" data-id="<?php echo "$id_event_peserta"; ?>">
                                <?php echo "$nama_event"; ?>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col col-md-4">
                                    <small class="mobile-text">Kategori</small>
                                </div>
                                <div class="col col-md-8">
                                    <small class="mobile-text">
                                        <code class="text text-grayish">
                                            <?php echo $nama_kategori; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-4">
                                    <small class="mobile-text">Tanggal Daftar</small>
                                </div>
                                <div class="col col-md-8">
                                    <small class="mobile-text">
                                        <code class="text text-grayish">
                                            <?php echo $Daftar; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-4">
                                    <small class="mobile-text">Pelaksanaan</small>
                                </div>
                                <div class="col col-md-8">
                                    <small class="mobile-text">
                                        <code class="text text-grayish">
                                            <?php echo $Pelaksanaan; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col col-md-4">
                                    <small class="mobile-text">Biaya Pendaftaran</small>
                                </div>
                                <div class="col col-md-8">
                                    <small class="mobile-text">
                                        <code class="text text-grayish">
                                            <?php echo $biaya_pendaftaran_format; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-4">
                                    <small class="mobile-text">Kode Transaksi</small>
                                </div>
                                <div class="col col-md-8">
                                    <small class="mobile-text">
                                        <?php 
                                            if(empty($kode_transaksi)){
                                                echo '<code>Tidak Ada</code>';
                                            }else{
                                                //Masked Kode Transaksi
                                                $last_five_digits = substr($kode_transaksi, -5);
                                                $formatted_id = '***' . $last_five_digits;
                                                echo '<code class="text text-grayish">'.$formatted_id.'</code>';
                                            }
                                        ?>
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-4">
                                    <small class="mobile-text">Status</small>
                                </div>
                                <div class="col col-md-8">
                                    <small class="mobile-text">
                                        <code class="text text-grayish">
                                            <?php 
                                                if($status=="Lunas"){
                                                    echo '<code class="text text-success">Lunas</code>';
                                                }else{
                                                    echo '<code class="text text-danger">Pending</code>';
                                                }
                                            ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php 
                $no++;
            } 
            echo '</div>';
        } 
    } 
?>