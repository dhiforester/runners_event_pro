<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingEmail.php";
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    if (empty($SessionIdAkses)) {
        echo '  <div class="row">';
        echo '      <div class="col-md-12 mb-3 text-center">';
        echo '          <small class="text-dark">Sesi akses sudah berakhir, silahkan login ulang!</small>';
        echo '      </div>';
        echo '  </div>';
    }else{
        //Tangkap id_wilayah
        if(empty($_POST['id_wilayah'])){
            echo '  <div class="row">';
            echo '      <div class="col-md-12 mb-3 text-center">';
            echo '          <small class="text-dark">ID Wilayah Tidak Dapat Ditangkap Oleh Sistem.</small>';
            echo '      </div>';
            echo '  </div>';
        }else{
            $id_wilayah=$_POST['id_wilayah'];
            //Buka data askes
            $QryWilayah = mysqli_query($Conn,"SELECT * FROM wilayah WHERE id_wilayah='$id_wilayah'")or die(mysqli_error($Conn));
            $DataWilayah = mysqli_fetch_array($QryWilayah);
            $id_wilayah= $DataWilayah['id_wilayah'];
            $kategori= $DataWilayah['kategori'];
?>
    <input type="hidden" name="id_wilayah" id="id_wilayah" value="<?php echo "$id_wilayah"; ?>">
    <div class="row mb-3">
        <div class="col col-md-4"><small>ID Wilayah</small></div>
        <div class="col col-md-8">
            <small>
                <code class="text text-grayish">
                    <?php echo "$id_wilayah"; ?>
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4"><small>Kategori</small></div>
        <div class="col col-md-8">
            <small>
                <code class="text text-grayish">
                    <?php echo "$kategori"; ?>
                </code>
            </small>
        </div>
    </div>
    <?php
        if($kategori=="Propinsi"){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><small><label for="editValue">Provinsi</label></small></div>';
            echo '  <div class="col-md-8">';
            echo '      <input type="text" name="editValue" id="editValue" class="form-control" value="'.$DataWilayah['propinsi'].'">';
            echo '  </div>';
            echo '</div>';
        }else{
            if($kategori=="Kabupaten"){
                echo '<div class="row mb-3">';
                echo '  <div class="col col-md-4"><small>Provinsi</small></div>';
                echo '  <div class="col col-md-8"><small><code class="text text-grayish">'.$DataWilayah['propinsi'].'</code></small></div>';
                echo '</div>';
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-4"><label for="editValue"><small>Kabupaten/Kota</small></label></div>';
                echo '  <div class="col-md-8">';
                echo '      <input type="text" name="editValue" id="editValue" class="form-control" value="'.$DataWilayah['kabupaten'].'">';
                echo '  </div>';
                echo '</div>';
            }else{
                if($kategori=="Kecamatan"){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col col-md-4"><small>Provinsi</small></div>';
                    echo '  <div class="col col-md-8"><small><code class="text text-grayish">'.$DataWilayah['propinsi'].'</code></small></div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col col-md-4"><small>Kabupaten/Kota</small></div>';
                    echo '  <div class="col col-md-8"><small><code class="text text-grayish">'.$DataWilayah['kabupaten'].'</code></small></div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4"><label for="editValue"><small>Kecamatan</small></label></div>';
                    echo '  <div class="col-md-8">';
                    echo '      <input type="text" name="editValue" id="editValue" class="form-control" value="'.$DataWilayah['kecamatan'].'">';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    echo '<div class="row mb-3">';
                    echo '  <div class="col col-md-4"><small>Provinsi</small></div>';
                    echo '  <div class="col col-md-8"><small><code class="text text-grayish">'.$DataWilayah['propinsi'].'</code></small></div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col col-md-4"><small>Kabupaten/Kota</small></div>';
                    echo '  <div class="col col-md-8"><small><code class="text text-grayish">'.$DataWilayah['kabupaten'].'</code></small></div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col col-md-4"><small>Kecamatan</small></div>';
                    echo '  <div class="col col-md-8"><small><code class="text text-grayish">'.$DataWilayah['kecamatan'].'</code></small></div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4"><label for="editValue"><small>Desa/Kelurahan</small></label></div>';
                    echo '  <div class="col-md-8">';
                    echo '      <input type="text" name="editValue" id="editValue" class="form-control" value="'.$DataWilayah['desa'].'">';
                    echo '  </div>';
                    echo '</div>';
                }
            }
        }
    ?>
<?php 
        } 
    } 
?>