<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Uang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_member'])){
            $nama="";
            $kontak="";
            $email="";
            $provinsi_member="";
            $kabupaten_member="";
            $kecamatan_member="";
            $desa_member="";
            $kode_pos_member="";
            $rt_rw_member="";
        }else{
            $id_member=$_POST['id_member'];
            //Menampilkan Data Member
            $nama=GetDetailData($Conn,'member','id_member',$id_member,'nama');
            $kontak=GetDetailData($Conn,'member','id_member',$id_member,'kontak');
            $email=GetDetailData($Conn,'member','id_member',$id_member,'email');
            $provinsi_member=GetDetailData($Conn,'member','id_member',$id_member,'provinsi');
            $kabupaten_member=GetDetailData($Conn,'member','id_member',$id_member,'kabupaten');
            $kecamatan_member=GetDetailData($Conn,'member','id_member',$id_member,'kecamatan');
            $desa_member=GetDetailData($Conn,'member','id_member',$id_member,'desa');
            $kode_pos_member=GetDetailData($Conn,'member','id_member',$id_member,'kode_pos');
            $rt_rw_member=GetDetailData($Conn,'member','id_member',$id_member,'rt_rw');
        }
?>
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="bi bi-person-add"></i>
                        </span>
                        <input type="text" name="tujuan_pengiriman_nama" id="tujuan_pengiriman_nama" class="form-control" placeholder="Nama Penerima" value="<?php echo "$nama"; ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="bi bi-pin-map"></i>
                        </span>
                        <select name="tujuan_pengiriman_provinsi" id="tujuan_pengiriman_provinsi" class="form-control">
                            <option value="">-Provinsi-</option>
                            <?php
                                $query = mysqli_query($Conn, "SELECT id_wilayah, propinsi FROM wilayah WHERE kategori='Propinsi'");
                                while ($data = mysqli_fetch_array($query)) {
                                    $id_wilayah= $data['id_wilayah'];
                                    $propinsi= $data['propinsi'];
                                    if($provinsi_member==$propinsi){
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
                        <select name="tujuan_pengiriman_kabupaten" id="tujuan_pengiriman_kabupaten" class="form-control">
                            <option value="">Kab/Kota</option>
                            <?php
                                if(!empty($provinsi_member)){
                                    $query = mysqli_query($Conn, "SELECT id_wilayah, kabupaten FROM wilayah WHERE kategori='Kabupaten' AND propinsi='$provinsi_member'");
                                        while ($data = mysqli_fetch_array($query)) {
                                            $id_wilayah= $data['id_wilayah'];
                                            $kabupaten= $data['kabupaten'];
                                            if($kabupaten_member==$kabupaten){
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
                        <select name="tujuan_pengiriman_kecamatan" id="tujuan_pengiriman_kecamatan" class="form-control">
                            <option value="">Kecamatan</option>
                            <?php
                                if(!empty($kabupaten_member)){
                                    $query = mysqli_query($Conn, "SELECT id_wilayah, kecamatan FROM wilayah WHERE kategori='Kecamatan' AND propinsi='$provinsi_member' AND kabupaten='$kabupaten_member'");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_wilayah= $data['id_wilayah'];
                                        $kecamatan= $data['kecamatan'];
                                        if($kecamatan_member==$kecamatan){
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
                        <select name="tujuan_pengiriman_desa" id="tujuan_pengiriman_desa" class="form-control">
                            <option value="">Desa/Kelurahan</option>
                            <?php
                                if(!empty($kecamatan_member)){
                                    $query = mysqli_query($Conn, "SELECT id_wilayah, desa FROM wilayah WHERE kategori='desa' AND propinsi='$provinsi_member' AND kabupaten='$kabupaten_member' AND kecamatan='$kecamatan_member'");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_wilayah= $data['id_wilayah'];
                                        $desa= $data['desa'];
                                        if($desa_member==$desa){
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
                        <input type="text" name="tujuan_pengiriman_rt_rw" id="tujuan_pengiriman_rt_rw" class="form-control" placeholder="Jalan, Nomor, RT/RW" value="<?php echo "$rt_rw_member"; ?>">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="bi bi-signpost"></i>
                        </span>
                        <input type="text" name="tujuan_pengiriman_kode_pos" id="tujuan_pengiriman_kode_pos" class="form-control" placeholder="Kode Pos" value="<?php echo "$kode_pos_member"; ?>">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="bi bi-phone"></i>
                        </span>
                        <input type="text" name="tujuan_pengiriman_kontak" id="tujuan_pengiriman_kontak" class="form-control" placeholder="Nomor Kontak (62)" value="<?php echo "$kontak"; ?>">
                    </div>
                </div>
            </div>
<?php
    }
?>

