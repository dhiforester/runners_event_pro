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
                $tagihan=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'tagihan');
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
                $tanggal_transaksi=date('d M Y H:i T',$strtotime1);
                //Format Rupiah
                $JumlahPembayaran='' . number_format($jumlah, 0, ',', '.');
                $Subtotal='' . number_format($tagihan, 0, ',', '.');
                //Routing Label Status
                if($status=="Lunas"){
                    $LabelStatus='<code class="text-success">Lunas <i class="bi bi-pencil-square"></i></code>';
                }else{
                    if($status=="Menunggu"){
                        $LabelStatus='<code class="text-danger">Menunggu Validasi <i class="bi bi-pencil-square"></i></code>';
                    }else{
                        $LabelStatus='<code class="text-warning">Pending <i class="bi bi-pencil-square"></i></code>';
                    }
                }
                //Sensor Kode Transaksi
                $last_three_kode = substr($kode_transaksi, -5);
                $masked_kode_transaksi = '***' . $last_three_kode;
                //Buka Raw Member
                if(!empty($raw_member)){
                    $raw_member_arry=json_decode($raw_member,true);
                    $nama=$raw_member_arry['nama'];
                    $email=$raw_member_arry['email'];
                    $kontak=$raw_member_arry['kontak'];
                    $provinsi=$raw_member_arry['provinsi'];
                    $kabupaten=$raw_member_arry['kabupaten'];
                    $kecamatan=$raw_member_arry['kecamatan'];
                    $desa=$raw_member_arry['desa'];
                    $rt_rw=$raw_member_arry['rt_rw'];
                    $kode_pos=$raw_member_arry['kode_pos'];
                }else{
                    $nama="";
                    $email="";
                    $kontak="";
                    $provinsi="";
                    $kabupaten="";
                    $kecamatan="";
                    $desa="";
                    $rt_rw="";
                    $kode_pos="";
                }
?>
                <div class="row mb-3">
                    <div class="col-md-10 mb-3">
                        <span class="text text-decoration-underline">1. Informasi Transaksi</span>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="button" class="btn btn-md btn-outline-success btn-block" data-bs-toggle="modal" data-bs-target="#ModalCetakNota" data-id="<?php echo "$kode_transaksi"; ?>">
                            <i class="bi bi-printer"></i> Cetak
                        </button>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="row mb-2">
                            <div class="col col-md-4"><small class="credit mobile-text">Kode Transaksi</small></div>
                            <div class="col col-md-8">
                                <small class="credit mobile-text">
                                    <code class="text text-grayish"><?php echo "$masked_kode_transaksi"; ?></code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col col-md-4"><small class="credit mobile-text">Tgl/Jam</small></div>
                            <div class="col col-md-8">
                                <small class="credit mobile-text">
                                    <code>
                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalUbahTanggalTransaksi" data-id="<?php echo "$kode_transaksi"; ?>">
                                            <?php echo "$tanggal_transaksi"; ?>
                                        </a>
                                    </code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col col-md-4"><small class="credit mobile-text">Nama Member</small></div>
                            <div class="col col-md-8">
                                <small class="credit mobile-text">
                                    <code class="text text-grayish"><?php echo "$NamaMember"; ?></code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col col-md-4"><small class="credit mobile-text">Total Transaksi</small></div>
                            <div class="col col-md-8">
                                <small class="credit mobile-text">
                                    <code class="text text-grayish"><?php echo "$JumlahPembayaran"; ?></code>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col col-md-4"><small class="credit mobile-text">Status</small></div>
                            <div class="col col-md-8">
                                <small class="credit mobile-text">
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalUbahStatusTransaksi" data-id="<?php echo "$kode_transaksi"; ?>">
                                        <?php echo "$LabelStatus"; ?>
                                    </a>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-10 mb-3">
                        <span class="text text-decoration-underline">
                            2. Uraian Barang
                        </span><br>
                    </div>
                    <div class="col col-md-2 mb-3 text-end">
                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalBarang2" data-id="<?php echo "$kode_transaksi"; ?>">
                            <small class="credit">
                                <i class="bi bi-plus-square"></i> Tambah
                            </small>
                        </a>
                    </div>
                    <div class="col-md-12 mb-3">
                        <?php
                            //Menampilkan Rincian Pembelanjaan
                            $query = mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE kode_transaksi='$kode_transaksi'");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_transaksi_rincian= $data['id_transaksi_rincian'];
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
                                $harga='' . number_format($harga, 0, ',', '.');
                                $jumlah='' . number_format($jumlah, 0, ',', '.');
                                echo '<div class="row mb-2">';
                                echo '  <div class="col col-md-4">';
                                echo '      <small class="mobile-text">'.$nama_barang.'</small><br>';
                                if(!empty($varian)){
                                    $varian_arry=json_decode($varian,true);
                                    if(!empty($varian_arry['nama_varian'])){
                                        $nama_varian=$varian_arry['nama_varian'];
                                    }else{
                                        $nama_varian="";
                                    }
                                    
                                    if(!empty( $nama_varian)){
                                        echo '<small class="mobile-text"><code class="text text-grayish">('.$nama_varian.')</code></small><br>';
                                    }
                                }
                                echo '  </div>';
                                echo '  <div class="col col-md-4">';
                                echo '      <small class="mobile-text"><code class="text text-grayish">'.$harga.' x '.$qty.'</code></small>';
                                echo '  </div>';
                                echo '  <div class="col col-md-4 text-end">';
                                echo '      <small class="mobile-text">';
                                echo '          <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalUbahRincianTransaksi" data-id="'.$id_transaksi_rincian.'">';
                                echo '              <code class="text text-primary">'.$jumlah.'</code>';
                                echo '          </a>';
                                echo '      </small>';
                                echo '  </div>';
                                echo '</div>';
                            }
                            if(!empty($Subtotal)){
                                echo '<div class="row border-1 border-bottom mb-3">';
                                echo '  <div class="col col-md-6 mb-3 mt-3">';
                                echo '      <small class="credit">SUBTOTAL</small>';
                                echo '  </div>';
                                echo '  <div class="col col-md-6 mb-3 mt-3 text-end">';
                                echo '      <small class=""><code class="text text-grayish">'.$Subtotal.'</code></small>';
                                echo '  </div>';
                                echo '</div>';
                            }
                            echo '<div class="row mb-3 mt-3">';
                            echo '  <div class="col col-md-10">';
                            echo '      <span class="text text-decoration-underline">3. Rincian Lain</span>';
                            echo '  </div>';
                            echo '  <div class="col col-md-2 text-end">';
                            echo '      <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalUbahRincianLainnya" data-id="'.$kode_transaksi.'">';
                            echo '          <small class="credit"><i class="bi bi-pencil-square"></i> Ubah</small>';
                            echo '      </a>';
                            echo '  </div>';
                            echo '</div>';
                            if(!empty($ongkir)){
                                $ongkir_format='' . number_format($ongkir, 0, ',', '.');
                                echo '<div class="row mb-2">';
                                echo '  <div class="col col-md-6">';
                                echo '      <small class="credit">Ongkir</small>';
                                echo '  </div>';
                                echo '  <div class="col col-md-6 text-end">';
                                echo '      <small><code class="text text-grayish">'.$ongkir_format.'</code></small>';
                                echo '  </div>';
                                echo '</div>';
                            }
                            if(!empty($ppn_pph)){
                                //Hitung persen ppn
                                if(!empty($ppn_pph)){
                                    if(!empty($tagihan)){
                                        $persen_ppn=($ppn_pph/$tagihan)*100;
                                        $persen_ppn=round($persen_ppn);
                                    }else{
                                        $persen_ppn=0;
                                    }
                                }else{
                                    $persen_ppn=0;
                                }
                                $ppn_pph_format='' . number_format($ppn_pph, 0, ',', '.');
                                echo '<div class="row mb-2">';
                                echo '  <div class="col col-md-6">';
                                echo '      <small class="credit">PPN ('.$persen_ppn.' %)</small>';
                                echo '  </div>';
                                echo '  <div class="col col-md-6 text-end">';
                                echo '      <small><code class="text text-grayish">'.$ppn_pph_format.'</code></small>';
                                echo '  </div>';
                                echo '</div>';
                            }
                            if(!empty($biaya_layanan)){
                                $biaya_layanan_format='' . number_format($biaya_layanan, 0, ',', '.');
                                echo '<div class="row mb-2">';
                                echo '  <div class="col col-md-6">';
                                echo '      <small class="credit">Biaya Layanan</small>';
                                echo '  </div>';
                                echo '  <div class="col col-md-6 text-end">';
                                echo '      <small><code class="text text-grayish">'.$biaya_layanan_format.'</code></small>';
                                echo '  </div>';
                                echo '</div>';
                            }
                            echo '<div class="row mb-2 mt-3">';
                            echo '  <div class="col col-md-12">';
                            echo '      <span class="text">Biaya Lain-lain</span>';
                            echo '  </div>';
                            echo '</div>';
                            if(!empty($biaya_lainnya)){
                                $biaya_lainnya_arry=json_decode($biaya_lainnya,true);
                                if(!empty(count($biaya_lainnya_arry))){
                                    foreach ($biaya_lainnya_arry as $biaya_lainnya_list) {
                                        $nama_biaya=$biaya_lainnya_list['nama_biaya'];
                                        $nominal_biaya=$biaya_lainnya_list['nominal_biaya'];
                                        $nominal_biaya_format='Rp ' . number_format($nominal_biaya, 0, ',', '.');
                                        echo '<div class="row mb-2">';
                                        echo '  <div class="col col-md-6">';
                                        echo '      <small class="credit"><code class="text text-dark">- '.$nama_biaya.'</code></small>';
                                        echo '  </div>';
                                        echo '  <div class="col col-md-6 text-end">';
                                        echo '      <small><code class="text text-grayish">'.$nominal_biaya_format.'</code></small>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }
                                }
                            }
                            echo '<div class="row mb-2 mt-3">';
                            echo '  <div class="col col-md-12">';
                            echo '      <span class="text">Potongan Lain-lain</span>';
                            echo '  </div>';
                            echo '</div>';
                            if(!empty($potongan_lainnya)){
                                $potongan_lainnya_arry=json_decode($potongan_lainnya,true);
                                if(!empty(count($potongan_lainnya_arry))){
                                    foreach ($potongan_lainnya_arry as $potongan_lainnya_list) {
                                        $nama_potongan=$potongan_lainnya_list['nama_potongan'];
                                        $nominal_potongan=$potongan_lainnya_list['nominal_potongan'];
                                        $nominal_potongan_format='Rp ' . number_format($nominal_potongan, 0, ',', '.');
                                        echo '<div class="row mb-2">';
                                        echo '  <div class="col col-md-6">';
                                        echo '      <small class="credit"><code class="text text-dark">- '.$nama_potongan.'</code></small>';
                                        echo '  </div>';
                                        echo '  <div class="col col-md-6 text-end">';
                                        echo '      <small><code class="text text-danger">'.$nominal_potongan_format.'</code></small>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }
                                }
                            }
                            echo '<div class="row mb-3 border-1 border-top">';
                            echo '  <div class="col col-md-6 mb-3 mt-3">';
                            echo '      <small class="text text-decoration-underline">4. JUMLAH TOTAL</small>';
                            echo '  </div>';
                            echo '  <div class="col col-md-6 mb-3 mt-3 text-end">';
                            echo '      <small class="text text-decoration-underline">'.$JumlahPembayaran.'</small>';
                            echo '  </div>';
                            echo '</div>';
                        ?>
                    </div>
                </div>
<?php
            }
        }
    }
?>