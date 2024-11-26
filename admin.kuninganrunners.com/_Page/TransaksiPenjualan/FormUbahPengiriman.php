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
                    $provinsi_tujuan=$tujuan_pengiriman_arry['provinsi'];
                    $kabupaten_tujuan=$tujuan_pengiriman_arry['kabupaten'];
                    $kecamatan_tujuan=$tujuan_pengiriman_arry['kecamatan'];
                    $desa_tujuan=$tujuan_pengiriman_arry['desa'];
                    $rt_rw_ptujuan=$tujuan_pengiriman_arry['rt_rw'];
                    $kode_pos_tujuan=$tujuan_pengiriman_arry['kode_pos'];
                    $kontak_tujuan=$tujuan_pengiriman_arry['kontak'];
                }else{
                    $nama_tujuan="";
                    $provinsi_tujuan="";
                    $kabupaten_tujuan="";
                    $kecamatan_tujuan="";
                    $desa_tujuan="";
                    $rt_rw_ptujuan="";
                    $kode_pos_tujuan="";
                    $kontak_tujuan="";
                }
?>
                <input type="hidden" name="kode_transaksi" value="<?php echo "$kode_transaksi"; ?>">
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
                        <label for="asal_pengiriman2">
                            <small class="credit">
                                Asal Pengiriman
                            </small>
                        </label>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-person-add"></i>
                                    </span>
                                    <input type="text" name="asal_pengiriman_nama" id="asal_pengiriman_nama2" class="form-control" placeholder="Nama Pengirim" value="<?php echo "$nama_pengirim"; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-pin-map"></i>
                                    </span>
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
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-pin-map"></i>
                                    </span>
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
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-pin-map"></i>
                                    </span>
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
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-pin-map"></i>
                                    </span>
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
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-map"></i>
                                    </span>
                                    <input type="text" name="asal_pengiriman_rt_rw" id="asal_pengiriman_rt_rw2" class="form-control" placeholder="Jalan, Nomor, RT/RW" value="<?php echo "$rt_rw_pengirim"; ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <small class="credit">
                                            <i class="bi bi-signpost"></i>
                                        </small>
                                    </span>
                                    <input type="text" name="asal_pengiriman_kode_pos" id="asal_pengiriman_kode_pos2" class="form-control" placeholder="Kode Pos" value="<?php echo "$kode_pos_pengirim"; ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-phone"></i>
                                    </span>
                                    <input type="text" name="asal_pengiriman_kontak" id="asal_pengiriman_kontak2" class="form-control" placeholder="Nomor Kontak (62)" value="<?php echo "$kontak_pengirim"; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <label for="tujuan_pengiriman2">
                            <small class="credit">
                                Tujuan Pengiriman
                            </small>
                        </label>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-person-add"></i>
                                    </span>
                                    <input type="text" name="tujuan_pengiriman_nama" id="tujuan_pengiriman_nama2" class="form-control" placeholder="Nama Penerima" value="<?php echo "$nama_tujuan"; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-pin-map"></i>
                                    </span>
                                    <select name="tujuan_pengiriman_provinsi" id="tujuan_pengiriman_provinsi2" class="form-control">
                                        <option value="">-Provinsi-</option>
                                        <?php
                                            $query = mysqli_query($Conn, "SELECT id_wilayah, propinsi FROM wilayah WHERE kategori='Propinsi'");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $id_wilayah= $data['id_wilayah'];
                                                $propinsi= $data['propinsi'];
                                                if($provinsi_tujuan==$propinsi){
                                                    echo '<option selected value="'.$propinsi.'">'.$propinsi.'</option>';
                                                }else{
                                                    echo '<option value="'.$propinsi.'">'.$propinsi.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-pin-map"></i>
                                    </span>
                                    <select name="tujuan_pengiriman_kabupaten" id="tujuan_pengiriman_kabupaten2" class="form-control">
                                        <option value="">Kab/Kota</option>
                                        <?php
                                            if(!empty($provinsi_tujuan)){
                                                $query = mysqli_query($Conn, "SELECT id_wilayah, kabupaten FROM wilayah WHERE kategori='Kabupaten' AND propinsi='$provinsi_tujuan'");
                                                    while ($data = mysqli_fetch_array($query)) {
                                                        $id_wilayah= $data['id_wilayah'];
                                                        $kabupaten= $data['kabupaten'];
                                                        if($kabupaten_tujuan==$kabupaten){
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
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-pin-map"></i>
                                    </span>
                                    <select name="tujuan_pengiriman_kecamatan" id="tujuan_pengiriman_kecamatan2" class="form-control">
                                        <option value="">Kecamatan</option>
                                        <?php
                                            if(!empty($kabupaten_tujuan)){
                                                $query = mysqli_query($Conn, "SELECT id_wilayah, kecamatan FROM wilayah WHERE kategori='Kecamatan' AND propinsi='$provinsi_tujuan' AND kabupaten='$kabupaten_tujuan'");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $id_wilayah= $data['id_wilayah'];
                                                    $kecamatan= $data['kecamatan'];
                                                    if($kecamatan_tujuan==$kecamatan){
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
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-pin-map"></i>
                                    </span>
                                    <select name="tujuan_pengiriman_desa" id="tujuan_pengiriman_desa2" class="form-control">
                                        <option value="">Desa/Kelurahan</option>
                                        <?php
                                            if(!empty($kecamatan_tujuan)){
                                                $query = mysqli_query($Conn, "SELECT id_wilayah, desa FROM wilayah WHERE kategori='desa' AND propinsi='$provinsi_tujuan' AND kabupaten='$kabupaten_tujuan' AND kecamatan='$kecamatan_tujuan'");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $id_wilayah= $data['id_wilayah'];
                                                    $desa= $data['desa'];
                                                    if($desa_tujuan==$desa){
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
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-map"></i>
                                    </span>
                                    <input type="text" name="tujuan_pengiriman_rt_rw" id="tujuan_pengiriman_rt_rw2" class="form-control" placeholder="Jalan, Nomor, RT/RW" value="<?php echo "$rt_rw_ptujuan"; ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-signpost"></i>
                                    </span>
                                    <input type="text" name="tujuan_pengiriman_kode_pos" id="tujuan_pengiriman_kode_pos2" class="form-control" placeholder="Kode Pos" value="<?php echo "$kode_pos_tujuan"; ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-phone"></i>
                                    </span>
                                    <input type="text" name="tujuan_pengiriman_kontak" id="tujuan_pengiriman_kontak2" class="form-control" placeholder="Nomor Kontak (62)" value="<?php echo "$kontak_tujuan"; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <label for="tanggal_pengiriman">
                            <small class="credit">
                                Tanggal Pengiriman
                            </small>
                        </label>
                    </div>
                    <div class="col-md-8">
                        <input type="date" class="form-control" name="tanggal_pengiriman" id="tanggal_pengiriman" value="<?php echo $tanggal_pengiriman; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <label for="jam_pengiriman">
                            <small class="credit">
                                Jam Pengiriman
                            </small>
                        </label>
                    </div>
                    <div class="col-md-8">
                        <input type="time" class="form-control" name="jam_pengiriman" id="jam_pengiriman" value="<?php echo $jam_pengiriman; ?>">
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
                <script>
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