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
                if(!empty($datetime_pengiriman)){
                    $strtotime=strtotime($datetime_pengiriman);
                    $tanggal_pengiriman=date('Y-m-d',$strtotime);
                    $jam_pengiriman=date('H:i:s',$strtotime);
                }else{
                    $tanggal_pengiriman="";
                    $jam_pengiriman="";
                }
                //Buka Data Pengirim
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
                }else{
                    $nama_pengirim="";
                    $provinsi_pengirim="";
                    $kabupaten_pengirim="";
                    $kecamatan_pengirim="";
                    $desa_pengirim="";
                    $rt_rw_pengirim="";
                    $kode_pos_pengirim="";
                    $kontak_pengirim="";
                }
                //Buka Data tujuan pengiriman
                if(!empty($tujuan_pengiriman)){
                    $tujuan_pengiriman_arry=json_decode($tujuan_pengiriman,true);
                    $nama_tujuan=$tujuan_pengiriman_arry['nama'];
                    $kontak_tujuan=$tujuan_pengiriman_arry['kontak'];
                    $metode_pengiriman=$tujuan_pengiriman_arry['metode_pengiriman'];
                    $alamt_pengiriman=$tujuan_pengiriman_arry['alamt_pengiriman'];
                    $kurir=$tujuan_pengiriman_arry['kurir'];
                    $cost_ongkir_item=$tujuan_pengiriman_arry['cost_ongkir_item'];
                    $rt_rw=$tujuan_pengiriman_arry['rt_rw'];
                }else{
                    $nama_tujuan="";
                    $kontak_tujuan="";
                    $metode_pengiriman="";
                    $alamt_pengiriman="";
                    $kurir="";
                    $cost_ongkir_item="";
                    $rt_rw="";
                }
?>
                <input type="hidden" name="kode_transaksi" value="<?php echo "$kode_transaksi"; ?>">
                <div class="row mb-2">
                    <div class="col-md-4">
                        <label for="metode">
                            <small>
                                <b>A. Metode Pengiriman</b>
                            </small>
                        </label>
                    </div>
                    <div class="col-md-8">
                        <select name="metode" id="metode" class="form-control">
                            <option <?php if($metode_pengiriman=="Dikirim"){echo "selected";} ?> value="Dikirim">Dikirim</option>
                            <option <?php if($metode_pengiriman=="Diambil"){echo "selected";} ?> value="Diambil">Diambil</option>
                        </select>
                    </div>
                </div>
                <div id="uraian_pengiriman">
                    <div class="row mt-4 border-top border-1">
                        <div class="col-md-12">
                            <small>
                                <b>B. Informasi Umum Pengiriman</b>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="no_resi">
                                <small class="credit">
                                    No.Resi
                                </small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="no_resi" id="no_resi" value="<?php echo $no_resi; ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="kurir">
                                <small class="credit">
                                    Kurir
                                </small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="kurir" id="kurir" value="<?php echo $kurir; ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="tanggal_pengiriman">
                                <small class="credit">
                                    Tanggal/Jam Pengiriman
                                </small>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="tanggal_pengiriman" id="tanggal_pengiriman" value="<?php echo $tanggal_pengiriman; ?>">
                            <small>Tanggal</small>
                        </div>
                        <div class="col-md-4">
                            <input type="time" class="form-control" name="jam_pengiriman" id="jam_pengiriman" value="<?php echo $jam_pengiriman; ?>">
                            <small>Jam</small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="ongkir">
                                <small class="credit">
                                    Ongkos Kirim
                                </small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" min="0" step="1" class="form-control" name="ongkir" id="ongkir" value="<?php echo $ongkir; ?>" placeholder="Rp">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="link_pengiriman">
                                <small class="credit">
                                    Link Pengiriman
                                </small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="link_pengiriman" id="link_pengiriman" value="<?php echo $link_pengiriman; ?>" placeholder="https://">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="status_pengiriman">
                                <small class="credit">
                                    Status Pengiriman
                                </small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="status_pengiriman" id="status_pengiriman" class="form-control">
                                <option <?php if($status_pengiriman==""){echo "selected";} ?> value="">Pilih</option>
                                <option <?php if($status_pengiriman=="Pending"){echo "selected";} ?> value="Pending">Pending</option>
                                <option <?php if($status_pengiriman=="Batal"){echo "selected";} ?> value="Batal">Batal</option>
                                <option <?php if($status_pengiriman=="Proses"){echo "selected";} ?> value="Proses">Proses</option>
                                <option <?php if($status_pengiriman=="Selesai"){echo "selected";} ?> value="Selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-4 border-1 border-top">
                        <div class="col-md-12">
                            <small>
                                <b>C. Asal Pengiriman</b>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="asal_pengiriman_nama">
                                <small class="credit">
                                    Nama
                                </small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="asal_pengiriman_nama" id="asal_pengiriman_nama2" class="form-control" placeholder="Nama Pengirim" value="<?php echo "$nama_pengirim"; ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="asal_pengiriman_provinsi">
                                <small class="credit">Provinsi</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="asal_pengiriman_provinsi" id="asal_pengiriman_provinsi2" class="form-control">
                                <option value="">-Provinsi-</option>
                                <?php
                                    $query = mysqli_query($Conn, "SELECT id_wilayah, propinsi FROM wilayah WHERE kategori='Propinsi'");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_wilayah= $data['id_wilayah'];
                                        $propinsi= $data['propinsi'];
                                        if($provinsi_pengirim==$propinsi){
                                            echo '<option selected value="'.$propinsi.'">'.$propinsi.'</option>';
                                        }else{
                                            echo '<option value="'.$propinsi.'">'.$propinsi.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="asal_pengiriman_kabupaten">
                                <small class="credit">Kabupaten/Kota</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="asal_pengiriman_kabupaten" id="asal_pengiriman_kabupaten2" class="form-control">
                                <option value="">Kab/Kota</option>
                                <?php
                                    if(!empty($provinsi_pengirim)){
                                        $query = mysqli_query($Conn, "SELECT id_wilayah, kabupaten FROM wilayah WHERE kategori='Kabupaten' AND propinsi='$provinsi_pengirim'");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $id_wilayah= $data['id_wilayah'];
                                                $kabupaten= $data['kabupaten'];
                                                if($kabupaten_pengirim==$kabupaten){
                                                    echo '<option selected value="'.$kabupaten.'">'.$kabupaten.'</option>';
                                                }else{
                                                    echo '<option value="'.$kabupaten.'">'.$kabupaten.'</option>';
                                                }
                                            }
                                    }
                                    
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="asal_pengiriman_kabupaten">
                                <small class="credit">Kabupaten/Kota</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="asal_pengiriman_kecamatan" id="asal_pengiriman_kecamatan2" class="form-control">
                                <option value="">Kecamatan</option>
                                <?php
                                    if(!empty($kabupaten_pengirim)){
                                        $query = mysqli_query($Conn, "SELECT id_wilayah, kecamatan FROM wilayah WHERE kategori='Kecamatan' AND propinsi='$provinsi_pengirim' AND kabupaten='$kabupaten_pengirim'");
                                        while ($data = mysqli_fetch_array($query)) {
                                            $id_wilayah= $data['id_wilayah'];
                                            $kecamatan= $data['kecamatan'];
                                            if($kecamatan_pengirim==$kecamatan){
                                                echo '<option selected value="'.$kecamatan.'">'.$kecamatan.'</option>';
                                            }else{
                                                echo '<option value="'.$kecamatan.'">'.$kecamatan.'</option>';
                                            }
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="asal_pengiriman_desa">
                                <small class="credit">Desa/Kelurahan</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="asal_pengiriman_desa" id="asal_pengiriman_desa2" class="form-control">
                                <option value="">Desa/Kelurahan</option>
                                <?php
                                    if(!empty($kecamatan_pengirim)){
                                        $query = mysqli_query($Conn, "SELECT id_wilayah, desa FROM wilayah WHERE kategori='desa' AND propinsi='$provinsi_pengirim' AND kabupaten='$kabupaten_pengirim' AND kecamatan='$kecamatan_pengirim'");
                                        while ($data = mysqli_fetch_array($query)) {
                                            $id_wilayah= $data['id_wilayah'];
                                            $desa= $data['desa'];
                                            if($desa_pengirim==$desa){
                                                echo '<option selected value="'.$desa.'">'.$desa.'</option>';
                                            }else{
                                                echo '<option value="'.$desa.'">'.$desa.'</option>';
                                            }
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="asal_pengiriman_rt_rw2">
                                <small class="credit">RT/RW</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="asal_pengiriman_rt_rw" id="asal_pengiriman_rt_rw2" class="form-control" placeholder="Jalan, Nomor, RT/RW" value="<?php echo "$rt_rw_pengirim"; ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="asal_pengiriman_kode_pos2">
                                <small class="credit">Kode POS</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="asal_pengiriman_kode_pos" id="asal_pengiriman_kode_pos2" class="form-control" placeholder="Kode Pos" value="<?php echo "$kode_pos_pengirim"; ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="asal_pengiriman_kontak2">
                                <small class="credit">Kontak</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="asal_pengiriman_kontak" id="asal_pengiriman_kontak2" class="form-control" placeholder="Nomor Kontak (62)" value="<?php echo "$kontak_pengirim"; ?>">
                        </div>
                    </div>
                    <div class="row mt-4 mb-2 border-top border-1">
                        <div class="col-md-12">
                            <small>
                                <b>D. Tujuan Pengiriman</b>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <label for="tujuan_pengiriman_nama">
                                <small class="credit">
                                    Nama
                                </small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="tujuan_pengiriman_nama" id="tujuan_pengiriman_nama2" class="form-control" placeholder="Nama Penerima" value="<?php echo "$nama_tujuan"; ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="tujuan_pengiriman_kontak">
                                <small class="credit">
                                    No.Kontak
                                </small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="tujuan_pengiriman_kontak" id="tujuan_pengiriman_kontak2" class="form-control" placeholder="Nomor Kontak (62)" value="<?php echo "$kontak_tujuan"; ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="alamt_pengiriman">
                                <small class="credit">
                                    Alamat 1
                                </small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="alamt_pengiriman" id="alamt_pengiriman" class="form-control" value="<?php echo "$alamt_pengiriman"; ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="tujuan_pengiriman_rt_rw">
                                <small class="credit">
                                    Alamat 2
                                </small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="tujuan_pengiriman_rt_rw" id="tujuan_pengiriman_rt_rw" class="form-control" value="<?php echo "$rt_rw"; ?>">
                        </div>
                    </div>
                </div>
                <script>
                    //Tangkap Metode Pengiriman
                    var metode_pengiriman=$('#metode').val();
                    if(metode_pengiriman=="Diambil"){
                        //Sembunyikan Form Uraian
                        $('#uraian_pengiriman').hide();
                    }else{
                        $('#uraian_pengiriman').show();
                    }
                    //Apabila Terdapat perubahan pada metode
                    $(document).on('change', '#metode', function() {
                        var metode_pengiriman=$('#metode').val();
                        if(metode_pengiriman=="Diambil"){
                            //Sembunyikan Form Uraian
                            $('#uraian_pengiriman').hide();
                        }else{
                            $('#uraian_pengiriman').show();
                        }
                    });
                    // ---------------Form Pengiriman ------------
                    //Apabila provinsi diubah maka tampilkan kabupaten (asal pengiriman)
                    $(document).on('input', '#asal_pengiriman_provinsi2', function() {
                        var asal_pengiriman_provinsi2 = $('#asal_pengiriman_provinsi2').val();
                        $.ajax({
                            type        : 'POST',
                            url         : '_Page/TransaksiPenjualan/ListWilayahKabupaten.php',
                            data        : { propinsi: asal_pengiriman_provinsi2 },
                            success     : function(data) {
                                $('#asal_pengiriman_kabupaten2').html(data);
                            }
                        });
                        $('#asal_pengiriman_kecamatan2').html('<option>-Kecamatan-</option>');
                        $('#asal_pengiriman_desa2').html('<option>-Desa/Kelurahan-</option>');
                    });
                    //Apabila kabupaten diubah maka tampilkan kabupaten (asal pengiriman)
                    $(document).on('input', '#asal_pengiriman_kabupaten2', function() {
                        var asal_pengiriman_provinsi2 = $('#asal_pengiriman_provinsi2').val();
                        var asal_pengiriman_kabupaten2 = $('#asal_pengiriman_kabupaten2').val();
                        $.ajax({
                            type        : 'POST',
                            url         : '_Page/TransaksiPenjualan/ListWilayahKecamatan.php',
                            data        : { propinsi: asal_pengiriman_provinsi2, kabupaten: asal_pengiriman_kabupaten2 },
                            success     : function(data) {
                                $('#asal_pengiriman_kecamatan2').html(data);
                            }
                        });
                        $('#asal_pengiriman_desa2').html('<option>-Desa/Kelurahan-</option>');
                    });
                    //Apabila kecamatan diubah maka tampilkan kabupaten (asal pengiriman)
                    $(document).on('input', '#asal_pengiriman_kecamatan2', function() {
                        var asal_pengiriman_provinsi2 = $('#asal_pengiriman_provinsi2').val();
                        var asal_pengiriman_kabupaten2 = $('#asal_pengiriman_kabupaten2').val();
                        var asal_pengiriman_kecamatan2 = $('#asal_pengiriman_kecamatan2').val();
                        $.ajax({
                            type        : 'POST',
                            url         : '_Page/TransaksiPenjualan/ListWilayahDesa.php',
                            data        : { propinsi: asal_pengiriman_provinsi2, kabupaten: asal_pengiriman_kabupaten2, kecamatan: asal_pengiriman_kecamatan2 },
                            success     : function(data) {
                                $('#asal_pengiriman_desa2').html(data);
                            }
                        });
                    });

                    //Apabila provinsi diubah maka tampilkan kabupaten (tujuan pengiriman)
                    $(document).on('input', '#tujuan_pengiriman_provinsi2', function() {
                        var tujuan_pengiriman_provinsi2 = $('#tujuan_pengiriman_provinsi2').val();
                        $.ajax({
                            type        : 'POST',
                            url         : '_Page/TransaksiPenjualan/ListWilayahKabupaten.php',
                            data        : { propinsi: tujuan_pengiriman_provinsi2 },
                            success     : function(data) {
                                $('#tujuan_pengiriman_kabupaten2').html(data);
                            }
                        });
                        $('#tujuan_pengiriman_kecamatan2').html('<option>-Kecamatan-</option>');
                        $('#tujuan_pengiriman_desa2').html('<option>-Desa/Kelurahan-</option>');
                    });
                    //Apabila kabupaten diubah maka tampilkan kabupaten (tujuan pengiriman)
                    $(document).on('input', '#tujuan_pengiriman_kabupaten2', function() {
                        var tujuan_pengiriman_provinsi2 = $('#tujuan_pengiriman_provinsi2').val();
                        var tujuan_pengiriman_kabupaten2 = $('#tujuan_pengiriman_kabupaten2').val();
                        $.ajax({
                            type        : 'POST',
                            url         : '_Page/TransaksiPenjualan/ListWilayahKecamatan.php',
                            data        : { propinsi: tujuan_pengiriman_provinsi2, kabupaten: tujuan_pengiriman_kabupaten2 },
                            success     : function(data) {
                                $('#tujuan_pengiriman_kecamatan2').html(data);
                            }
                        });
                        $('#tujuan_pengiriman_desa2').html('<option>-Desa/Kelurahan-</option>');
                    });
                    //Apabila kecamatan diubah maka tampilkan kabupaten (tujuan pengiriman)
                    $(document).on('input', '#tujuan_pengiriman_kecamatan2', function() {
                        var tujuan_pengiriman_provinsi2 = $('#tujuan_pengiriman_provinsi2').val();
                        var tujuan_pengiriman_kabupaten2 = $('#tujuan_pengiriman_kabupaten2').val();
                        var tujuan_pengiriman_kecamatan2 = $('#tujuan_pengiriman_kecamatan2').val();
                        $.ajax({
                            type        : 'POST',
                            url         : '_Page/TransaksiPenjualan/ListWilayahDesa.php',
                            data        : { propinsi: tujuan_pengiriman_provinsi2, kabupaten: tujuan_pengiriman_kabupaten2, kecamatan: tujuan_pengiriman_kecamatan2 },
                            success     : function(data) {
                                $('#tujuan_pengiriman_desa2').html(data);
                            }
                        });
                    });
                </script>
<?php
            }
        }
    }
?>