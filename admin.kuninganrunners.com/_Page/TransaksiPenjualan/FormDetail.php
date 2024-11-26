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
                $ongkir=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'ongkir');
                $ppn_pph=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'ppn_pph');
                $biaya_layanan=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'biaya_layanan');
                $biaya_lainnya=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'biaya_lainnya');
                $potongan_lainnya=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'potongan_lainnya');
                $status=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'status');
                //Buka Data Member
                $NamaMember=GetDetailData($Conn,'member','id_member',$id_member,'nama');
                //format Data Tanggal Transaksi
                $strtotime1=strtotime($datetime);
                $tanggal_transaksi=date('d M Y H:i',$strtotime1);
                //Format Rupiah
                $JumlahPembayaran='Rp ' . number_format($jumlah, 0, ',', '.');
                //Routing Label Status
                if($status=="Lunas"){
                    $LabelStatus='<code class="text-success">Lunas</code>';
                }else{
                    if($status=="Menunggu"){
                        $LabelStatus='<code class="text-danger">Menunggu Validasi</code>';
                    }else{
                        $LabelStatus='<code class="text-warning">Pending</code>';
                    }
                }
                //Format Atribut RP Transaksi
                
?>
                <input type="hidden" name="Page" value="TransaksiPenjualan">
                <input type="hidden" name="Sub" value="Detail">
                <input type="hidden" name="id" value="<?php echo $kode_transaksi; ?>">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <b>1. Informasi Transaksi</b>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                            <div class="accordion-body">
                                <div class="row mb-3">
                                    <div class="col col-md-4"><small class="credit">Kode Transaksi</small></div>
                                    <div class="col col-md-8">
                                        <small class="credit mobile-text">
                                            <code class="text text-grayish"><?php echo "$kode_transaksi"; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4"><small class="credit">Tgl/Jam</small></div>
                                    <div class="col col-md-8">
                                        <small class="credit">
                                            <code class="text text-grayish"><?php echo "$tanggal_transaksi"; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4 mb-3"><small class="credit">Nama Member</small></div>
                                    <div class="col col-md-8 mb-3">
                                        <small class="credit">
                                            <code class="text text-grayish"><?php echo "$NamaMember"; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4 mb-3"><small class="credit">Total Transaksi</small></div>
                                    <div class="col col-md-8 mb-3">
                                        <small class="credit">
                                            <code class="text text-grayish"><?php echo "$JumlahPembayaran"; ?></code>
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
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <b>2. Uraian/Rincian</b>
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <?php
                                    //Menampilkan Rincian Pembelanjaan
                                    $query = mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE kode_transaksi='$kode_transaksi'");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $nama_barang= $data['nama_barang'];
                                        $varian= $data['varian'];
                                        if(empty($data['harga'])){
                                            $harga=0;
                                        }else{
                                            $harga= $data['harga'];
                                        }
                                        if(empty($data['qty'])){
                                            $qty=0;
                                        }else{
                                            $qty= $data['qty'];
                                        }
                                        $jumlah= $data['jumlah'];
                                        //Format Rupiah
                                        $harga='Rp ' . number_format($harga, 0, ',', '.');
                                        $jumlah='Rp ' . number_format($jumlah, 0, ',', '.');
                                        echo '<div class="row border-1 border-bottom mb-3">';
                                        echo '  <div class="col col-md-6 mb-3">';
                                        echo '      <small>'.$nama_barang.'</small><br>';
                                        if(!empty($varian)){
                                            $varian_arry=json_decode($varian,true);
                                            if(!empty($varian_arry['nama_varian'])){
                                                echo '<small><code class="text text-grayish">('.$varian_arry['nama_varian'].')</code></small><br>';
                                            }
                                        }
                                        echo '      <small><code class="text text-grayish">'.$harga.' x '.$qty.'</code></small>';
                                        echo '  </div>';
                                        echo '  <div class="col col-md-6 mb-3 text-end">';
                                        echo '      <small><code class="text text-grayish">'.$jumlah.'</code></small>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }
                                    if(!empty($ongkir)){
                                        $ongkir_format='Rp ' . number_format($ongkir, 0, ',', '.');
                                        echo '<div class="row border-1 border-bottom mb-3">';
                                        echo '  <div class="col col-md-6 mb-3">';
                                        echo '      <small>Ongkir</small>';
                                        echo '  </div>';
                                        echo '  <div class="col col-md-6 mb-3 text-end">';
                                        echo '      <small><code class="text text-grayish">'.$ongkir_format.'</code></small>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }
                                    if(!empty($ppn_pph)){
                                        $ppn_pph_format='Rp ' . number_format($ppn_pph, 0, ',', '.');
                                        echo '<div class="row border-1 border-bottom mb-3">';
                                        echo '  <div class="col col-md-6 mb-3">';
                                        echo '      <small>PPN/PPH</small>';
                                        echo '  </div>';
                                        echo '  <div class="col col-md-6 mb-3 text-end">';
                                        echo '      <small><code class="text text-grayish">'.$ppn_pph_format.'</code></small>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }
                                    if(!empty($biaya_layanan)){
                                        $biaya_layanan_format='Rp ' . number_format($biaya_layanan, 0, ',', '.');
                                        echo '<div class="row border-1 border-bottom mb-3">';
                                        echo '  <div class="col col-md-6 mb-3">';
                                        echo '      <small>Biaya Layanan</small>';
                                        echo '  </div>';
                                        echo '  <div class="col col-md-6 mb-3 text-end">';
                                        echo '      <small><code class="text text-grayish">'.$biaya_layanan_format.'</code></small>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }
                                    if(!empty($biaya_lainnya)){
                                        $biaya_lainnya_arry=json_decode($biaya_lainnya,true);
                                        if(!empty(count($biaya_lainnya_arry))){
                                            foreach ($biaya_lainnya_arry as $biaya_lainnya_list) {
                                                $nama_biaya=$biaya_lainnya_list['nama_biaya'];
                                                $nominal_biaya=$biaya_lainnya_list['nominal_biaya'];
                                                $nominal_biaya_format='Rp ' . number_format($nominal_biaya, 0, ',', '.');
                                                echo '<div class="row border-1 border-bottom mb-3">';
                                                echo '  <div class="col col-md-6 mb-3">';
                                                echo '      <small>'.$nama_biaya.'</small>';
                                                echo '  </div>';
                                                echo '  <div class="col col-md-6 mb-3 text-end">';
                                                echo '      <small><code class="text text-grayish">'.$nominal_biaya_format.'</code></small>';
                                                echo '  </div>';
                                                echo '</div>';
                                            }
                                        }
                                    }
                                    if(!empty($potongan_lainnya)){
                                        $potongan_lainnya_arry=json_decode($potongan_lainnya,true);
                                        if(!empty(count($potongan_lainnya_arry))){
                                            foreach ($potongan_lainnya_arry as $potongan_lainnya_list) {
                                                $nama_potongan=$potongan_lainnya_list['nama_potongan'];
                                                $nominal_potongan=$potongan_lainnya_list['nominal_potongan'];
                                                $nominal_potongan_format='Rp ' . number_format($nominal_potongan, 0, ',', '.');
                                                echo '<div class="row border-1 border-bottom mb-3">';
                                                echo '  <div class="col col-md-6 mb-3">';
                                                echo '      <small>'.$nama_potongan.'</small>';
                                                echo '  </div>';
                                                echo '  <div class="col col-md-6 mb-3 text-end">';
                                                echo '      <small><code class="text text-danger">'.$nominal_potongan_format.'</code></small>';
                                                echo '  </div>';
                                                echo '</div>';
                                            }
                                        }
                                    }
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col col-md-6 mb-3">';
                                    echo '      <small>JUMLAH TOTAL</small>';
                                    echo '  </div>';
                                    echo '  <div class="col col-md-6 mb-3 text-end">';
                                    echo '      <small>'.$JumlahPembayaran.'</small>';
                                    echo '  </div>';
                                    echo '</div>';
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <b>3. Pembayaran</b>
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <?php
                                    //Membuka Data Pembayaran
                                    $id_transaksi_payment=GetDetailData($Conn,'transaksi_payment','kode_transaksi',$kode_transaksi,'id_transaksi_payment');
                                    if(empty($id_transaksi_payment)){
                                        echo '<div class="row">';
                                        echo '  <div class="col col-md-12 text-center">';
                                        echo '      <small class="text-danger">Belum Ada Data Pembayaran</small>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }else{
                                        $query_payment = mysqli_query($Conn, "SELECT*FROM transaksi_payment WHERE kode_transaksi='$kode_transaksi'");
                                        while ($data_payment = mysqli_fetch_array($query_payment)) {
                                            $id_transaksi_payment= $data_payment['id_transaksi_payment'];
                                            $order_id= $data_payment['order_id'];
                                            $snap_token= $data_payment['snap_token'];
                                            $datetime= $data_payment['datetime'];
                                            $status_pengiriman= $data_payment['status'];
                                            echo '<div class="row mb-3 border-1 border-bottom">';
                                            echo '  <div class="col col-md-12 mb-3">';
                                            echo '      <div class="row mb-3">';
                                            echo '          <div class="col col-md-6 mb-3">';
                                            echo '              <small><code class="text-dark">Order ID</code></small>';
                                            echo '          </div>';
                                            echo '          <div class="col col-md-6 mb-3 text-end">';
                                            echo '              <small><code class="text text-grayish">'.$order_id.'</code></small>';
                                            echo '          </div>';
                                            echo '      </div>';
                                            echo '      <div class="row mb-3">';
                                            echo '          <div class="col col-md-6 mb-3">';
                                            echo '              <small><code class="text-dark">Snap Token</code></small>';
                                            echo '          </div>';
                                            echo '          <div class="col col-md-6 mb-3 text-end">';
                                            echo '              <small><code class="text text-grayish">'.$snap_token.'</code></small>';
                                            echo '          </div>';
                                            echo '      </div>';
                                            echo '      <div class="row mb-3">';
                                            echo '          <div class="col col-md-6 mb-3">';
                                            echo '              <small><code class="text-dark">Datetime</code></small>';
                                            echo '          </div>';
                                            echo '          <div class="col col-md-6 mb-3 text-end">';
                                            echo '              <small><code class="text text-grayish">'.$datetime.'</code></small>';
                                            echo '          </div>';
                                            echo '      </div>';
                                            echo '      <div class="row mb-3">';
                                            echo '          <div class="col col-md-6 mb-3">';
                                            echo '              <small><code class="text-dark">Status</code></small>';
                                            echo '          </div>';
                                            echo '          <div class="col col-md-6 mb-3 text-end">';
                                            echo '              <small><code class="text text-grayish">'.$status_pengiriman.'</code></small>';
                                            echo '          </div>';
                                            echo '      </div>';
                                            echo '  </div>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <b>4. Pengiriman</b>
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <?php
                                    //Membuka Data Pengiriman
                                    $id_transaksi_pengiriman=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'id_transaksi_pengiriman');
                                    if(empty($id_transaksi_pengiriman)){
                                        echo '<div class="row">';
                                        echo '  <div class="col col-md-12 text-center">';
                                        echo '      <small class="text-danger">Belum Ada Data Pengiriman</small>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }else{
                                        $qry_pengiriman = mysqli_query($Conn, "SELECT*FROM transaksi_pengiriman WHERE kode_transaksi='$kode_transaksi'");
                                        while ($data_pengiriman = mysqli_fetch_array($qry_pengiriman)) {
                                            $no_resi= $data_pengiriman['no_resi'];
                                            $kurir= $data_pengiriman['kurir'];
                                            $status_pengiriman= $data_pengiriman['status_pengiriman'];
                                            $datetime_pengiriman= $data_pengiriman['datetime_pengiriman'];
                                            $ongkir= $data_pengiriman['ongkir'];
                                            $link_pengiriman= $data_pengiriman['link_pengiriman'];
                                            $ongkir_format='Rp ' . number_format($ongkir, 0, ',', '.');
                                            echo '<div class="row mb-3 border-1 border-bottom">';
                                            echo '  <div class="col col-md-12 mb-3">';
                                            echo '      <div class="row mb-3">';
                                            echo '          <div class="col col-md-6 mb-3">';
                                            echo '              <small><code class="text-dark">No.Resi</code></small>';
                                            echo '          </div>';
                                            echo '          <div class="col col-md-6 mb-3 text-end">';
                                            echo '              <small><code class="text text-grayish">'.$no_resi.'</code></small>';
                                            echo '          </div>';
                                            echo '      </div>';
                                            echo '      <div class="row mb-3">';
                                            echo '          <div class="col col-md-6 mb-3">';
                                            echo '              <small><code class="text-dark">Kurir</code></small>';
                                            echo '          </div>';
                                            echo '          <div class="col col-md-6 mb-3 text-end">';
                                            echo '              <small><code class="text text-grayish">'.$kurir.'</code></small>';
                                            echo '          </div>';
                                            echo '      </div>';
                                            echo '      <div class="row mb-3">';
                                            echo '          <div class="col col-md-6 mb-3">';
                                            echo '              <small><code class="text-dark">Datetime</code></small>';
                                            echo '          </div>';
                                            echo '          <div class="col col-md-6 mb-3 text-end">';
                                            echo '              <small><code class="text text-grayish">'.$datetime_pengiriman.'</code></small>';
                                            echo '          </div>';
                                            echo '      </div>';
                                            echo '      <div class="row mb-3">';
                                            echo '          <div class="col col-md-6 mb-3">';
                                            echo '              <small><code class="text-dark">Tarif Ongkir</code></small>';
                                            echo '          </div>';
                                            echo '          <div class="col col-md-6 mb-3 text-end">';
                                            echo '              <small><code class="text text-grayish">'.$ongkir_format.'</code></small>';
                                            echo '          </div>';
                                            echo '      </div>';
                                            echo '      <div class="row mb-3">';
                                            echo '          <div class="col col-md-6 mb-3">';
                                            echo '              <small><code class="text-dark">Status</code></small>';
                                            echo '          </div>';
                                            echo '          <div class="col col-md-6 mb-3 text-end">';
                                            echo '              <small><code class="text text-grayish">'.$status.'</code></small>';
                                            echo '          </div>';
                                            echo '      </div>';
                                            echo '  </div>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
<?php
            }
        }
    }
?>