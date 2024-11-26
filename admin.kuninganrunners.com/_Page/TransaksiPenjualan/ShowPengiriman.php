<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-2">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit mobile-text">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Uang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['kode_transaksi'])){
            echo '<div class="row mb-2">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit mobile-text">';
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
                echo '<div class="row mb-2">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                echo '          <small class="credit mobile-text">';
                echo '              <code class="text-dark">';
                echo '                  Data Yang Anda Pilih Tidak Ditemukan Pada Database!';
                echo '              </code>';
                echo '          </small>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $id_transaksi_pengiriman=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'id_transaksi_pengiriman');
                $no_resi=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'no_resi');
                $kurir=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'kurir');
                $asal_pengiriman=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'asal_pengiriman');
                $tujuan_pengiriman=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'tujuan_pengiriman');
                $status_pengiriman=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'status_pengiriman');
                $datetime_pengiriman=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'datetime_pengiriman');
                $ongkir=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'ongkir');
                $link_pengiriman=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'link_pengiriman');
                
?>
                <div class="row mb-3 mt-3">
                    <div class="col-md-8 mb-3">
                        <small>
                            <b>Keterangan :</b>
                            <code class="text text-grayish">
                                Data Pembayaran (Order ID) hanya berlaku untuk 1 (satu) kali proses.
                            </code>
                        </small>
                    </div>
                    <div class="col col-md-2 mb-3">
                        <button type="button" class="btn btn-md btn-outline-info btn-block" data-bs-toggle="modal" data-bs-target="#ModalUbahPengiriman" data-id="<?php echo "$kode_transaksi"; ?>">
                            <i class="bi bi-pencil"></i> Ubah/Edit
                        </button>
                    </div>
                    <div class="col col-md-2 mb-3">
                        <button type="button" class="btn btn-md btn-outline-success btn-block" data-bs-toggle="modal" data-bs-target="#ModalCetakResi" data-id="<?php echo "$kode_transaksi"; ?>">
                            <i class="bi bi-printer"></i> Cetak
                        </button>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        <small class="credit">No.Resi</small>
                    </div>
                    <div class="col col-md-8">
                        <small>
                            <?php 
                                if(!empty($no_resi)){
                                    echo '<code class="text text-grayish">'.$no_resi.'</code>';
                                }else{
                                    echo '<code class="text text-danger">Tidak Ada</code>';
                                }
                            ?>
                        </small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        <small class="credit">Kurir</small>
                    </div>
                    <div class="col col-md-8">
                        <small>
                            <?php 
                                if(!empty($kurir)){
                                    echo '<code class="text text-grayish">'.$kurir.'</code>';
                                }else{
                                    echo '<code class="text text-danger">Tidak Ada</code>';
                                }
                            ?>
                        </small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        <small class="credit">Tgl.Pengiriman</small>
                    </div>
                    <div class="col col-md-8">
                        <small>
                            <?php 
                                if(!empty($datetime_pengiriman)){
                                    //Format Tanggal
                                    $strtotime1=strtotime($datetime_pengiriman);
                                    $datetime_pengiriman_format=date('d M Y H:i T',$strtotime1);
                                    echo '<code class="text text-grayish">'.$datetime_pengiriman_format.'</code>';
                                }else{
                                    echo '<code class="text text-danger">Tidak Ada</code>';
                                }
                            ?>
                        </small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <small class="credit">Asal Pengiriman</small>
                    </div>
                    <div class="col-md-8">
                        <small class="credit">
                            <?php 
                                if(!empty($asal_pengiriman)){
                                    $asal_pengiriman_arry=json_decode($asal_pengiriman,true);
                                    $nama_pengirim=$asal_pengiriman_arry['nama'];
                                    $provinsi_pengirim=$asal_pengiriman_arry['provinsi'];
                                    $kabupaten_pengirim=$asal_pengiriman_arry['kabupaten'];
                                    $kecamatan_pengirim=$asal_pengiriman_arry['kecamatan'];
                                    $desa_pengirim=$asal_pengiriman_arry['desa'];
                                    $rt_rw_pengirim=$asal_pengiriman_arry['rt_rw'];
                                    $kode_pos_pengirim=$asal_pengiriman_arry['kode_pos'];
                                    $kontak_pengirim=$asal_pengiriman_arry['kontak'];
                                    echo '<ul>';
                                    echo '  <li>Nama : <code class="text text-grayish">'.$nama_pengirim.'</code></li>';
                                    echo '  <li>Provinsi : <code class="text text-grayish">'.$provinsi_pengirim.'</code></li>';
                                    echo '  <li>Kabupaten : <code class="text text-grayish">'.$kabupaten_pengirim.'</code></li>';
                                    echo '  <li>Kecamatan : <code class="text text-grayish">'.$kecamatan_pengirim.'</code></li>';
                                    echo '  <li>Desa/Kel : <code class="text text-grayish">'.$desa_pengirim.'</code></li>';
                                    echo '  <li>RT/RW : <code class="text text-grayish">'.$rt_rw_pengirim.'</code></li>';
                                    echo '  <li>Kode Pos : <code class="text text-grayish">'.$kode_pos_pengirim.'</code></li>';
                                    echo '  <li>Kontak : <code class="text text-grayish">'.$kontak_pengirim.'</code></li>';
                                    echo '</ul>';
                                }else{
                                    echo '<code class="text text-danger">Tidak Ada</code>';
                                }
                            ?>
                        </small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <small class="credit">Tujuan Pengiriman</small>
                    </div>
                    <div class="col-md-8">
                        <small>
                            <?php 
                                if(!empty($tujuan_pengiriman)){
                                    $tujuan_pengiriman_arry=json_decode($tujuan_pengiriman,true);
                                    $nama_tujuan=$tujuan_pengiriman_arry['nama'];
                                    $provinsi_tujuan=$tujuan_pengiriman_arry['provinsi'];
                                    $kabupaten_tujuan=$tujuan_pengiriman_arry['kabupaten'];
                                    $kecamatan_tujuan=$tujuan_pengiriman_arry['kecamatan'];
                                    $desa_tujuan=$tujuan_pengiriman_arry['desa'];
                                    $rt_rw_ptujuan=$tujuan_pengiriman_arry['rt_rw'];
                                    $kode_pos_tujuan=$tujuan_pengiriman_arry['kode_pos'];
                                    $kontak_tujuan=$tujuan_pengiriman_arry['kontak'];
                                    echo '<ul>';
                                    echo '  <li>Nama : <code class="text text-grayish">'.$nama_tujuan.'</code></li>';
                                    echo '  <li>Provinsi : <code class="text text-grayish">'.$provinsi_tujuan.'</code></li>';
                                    echo '  <li>Kabupaten : <code class="text text-grayish">'.$kabupaten_tujuan.'</code></li>';
                                    echo '  <li>Kecamatan : <code class="text text-grayish">'.$kecamatan_tujuan.'</code></li>';
                                    echo '  <li>Desa/Kel : <code class="text text-grayish">'.$desa_tujuan.'</code></li>';
                                    echo '  <li>RT/RW : <code class="text text-grayish">'.$rt_rw_ptujuan.'</code></li>';
                                    echo '  <li>Kode Pos : <code class="text text-grayish">'.$kode_pos_tujuan.'</code></li>';
                                    echo '  <li>Kontak : <code class="text text-grayish">'.$kontak_tujuan.'</code></li>';
                                    echo '</ul>';
                                }else{
                                    echo '<code class="text text-danger">Tidak Ada</code>';
                                }
                            ?>
                        </small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        <small class="credit">Ongkir</small>
                    </div>
                    <div class="col col-md-8">
                        <small>
                            <?php 
                                if(!empty($ongkir)){
                                    $ongkir_format='' . number_format($ongkir, 0, ',', '.');
                                    echo '<code class="text text-grayish">'.$ongkir_format.'</code>';
                                }else{
                                    echo '<code class="text text-danger">Tidak Ada</code>';
                                }
                            ?>
                        </small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        <small class="credit">Link Pengiriman</small>
                    </div>
                    <div class="col col-md-8">
                        <small>
                            <?php 
                                if(!empty($link_pengiriman)){
                                    echo '<a href="'.$link_pengiriman.'">';
                                    echo '  <code class="text text-grayish">'.$link_pengiriman.'</code>';
                                    echo '</a>';
                                }else{
                                    echo '<code class="text text-danger">Tidak Ada</code>';
                                }
                            ?>
                        </small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        <small class="credit">Status Pengiriman</small>
                    </div>
                    <div class="col col-md-8">
                        <small>
                            <?php 
                                if(!empty($status_pengiriman)){
                                    if($status_pengiriman=="Pending"){
                                        echo '<span class="badge rounded-pill bg-warning">Pending</span>';
                                    }else{
                                        if($status_pengiriman=="Batal"){
                                            echo '<span class="badge rounded-pill bg-danger">Batal</span>';
                                        }else{
                                            if($status_pengiriman=="Proses"){
                                                echo '<span class="badge rounded-pill bg-info">Dalam Proses</span>';
                                            }else{
                                                if($status_pengiriman=="Selesai"){
                                                    echo '<span class="badge rounded-pill bg-success">Selesai</span>';
                                                }else{
                                                    
                                                }
                                            }
                                        }
                                    }
                                }else{
                                    echo '<code class="text text-danger">Tidak Ada</code>';
                                }
                            ?>
                        </small>
                    </div>
                </div>
<?php
            }
        }
    }
?>