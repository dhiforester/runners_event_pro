<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Harus Login Terlebih Dulu
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <code>Sesi Login Sudah Berakhir, Silahkan Login Ulang!</code>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Tangkap id_akses
        if(empty($_POST['id_akses'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <code>ID Akses Tidak Boleh Kosong</code>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_akses=$_POST['id_akses'];
            //Bersihkan Variabel
            $id_akses=validateAndSanitizeInput($id_akses);
            //Buka data askes
            $nama_akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'nama_akses');
            $kontak_akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'kontak_akses');
            $email_akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'email_akses');
            $image_akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'image_akses');
            $akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'akses');
            $datetime_daftar=GetDetailData($Conn,'akses','id_akses',$id_akses,'datetime_daftar');
            $datetime_update=GetDetailData($Conn,'akses','id_akses',$id_akses,'datetime_update');
?>
        <input type="hidden" name="id_akses" id="id_akses_edit" value="<?php echo "$id_akses"; ?>">
        <div class="row mb-3">
            <div class="co-md-12 border-1 border-bottom">
                <div class="row mb-3">
                    <div class="col col-md-4">
                        <small>Nama Lengkap</small>
                    </div>
                    <div class="col col-md-8">
                        <small>
                            <code class="text text-grayish"><?php echo $nama_akses; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-4">
                        <small>Kontak</small>
                    </div>
                    <div class="col col-md-8">
                        <small>
                            <code class="text text-grayish"><?php echo $kontak_akses; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-4">
                        <small>Email</small>
                    </div>
                    <div class="col col-md-8">
                        <small>
                            <code class="text text-grayish"><?php echo $email_akses; ?></code>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="akses">
                    <small>Pilih Levell/Entitias</small>
                </label>
                <select name="akses" id="akses" class="form-control">
                    <option value="">Pilih</option>
                    <?php
                        //Array Data Mitra
                        $QryAksesEntitias = mysqli_query($Conn, "SELECT akses FROM akses_entitas ORDER BY akses ASC");
                        while ($DataEntitiasAkses = mysqli_fetch_array($QryAksesEntitias)) {
                            $akses_list= $DataEntitiasAkses['akses'];
                            if($akses_list==$akses){
                                echo '<option selected value="'.$akses_list.'">'.$akses_list.'</option>';
                            }else{
                                echo '<option value="'.$akses_list.'">'.$akses_list.'</option>';
                            }
                        }
                    ?>
                </select>
                <small class="credit">
                    <code class="text text-grayish">Tingkat level akses yang digunakan berdasarkan entitias</code>
                </small>
            </div>
        </div>
<?php 
        } 
    } 
?>