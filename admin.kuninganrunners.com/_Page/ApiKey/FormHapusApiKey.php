<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Tangkap id_setting_api_key
    if(empty($_POST['id_setting_api_key'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          Api Key ID Tidak Boleh Kosong.';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_setting_api_key=$_POST['id_setting_api_key'];
        $id_setting_api_key=validateAndSanitizeInput($id_setting_api_key);
        $id_setting_api_key=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id_setting_api_key,'id_setting_api_key');
        if(empty($id_setting_api_key)){
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          Api Key ID Tidak Valid Atau Tidak Ditemukan Pada Database.';
            echo '      </div>';
            echo '  </div>';
        }else{
            $datetime_creat=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id_setting_api_key,'datetime_creat');
            $datetime_update=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id_setting_api_key,'datetime_update');
            $title_api_key=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id_setting_api_key,'title_api_key');
            $description_api_key=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id_setting_api_key,'description_api_key');
            $user_key_server=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id_setting_api_key,'user_key_server');
            $status=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id_setting_api_key,'status');
            $limit_session=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id_setting_api_key,'limit_session');
            //Menghitung Jumlah Log
            $JumlahLog = mysqli_num_rows(mysqli_query($Conn, "SELECT id_log_api FROM log_api WHERE id_setting_api_key='$id_setting_api_key'"));
            $JumlahLog=number_format($JumlahLog, 0, ',', '.');
?>
    <input type="hidden" name="id_setting_api_key" value="<?php echo "$id_setting_api_key"; ?>">
    <div class="row mb-3">
        <div class="col-md-4">Nama/Judul</div>
        <div class="col-md-8">
            <code class="text text-grayish">
                <?php echo "$title_api_key"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">Tgl.Dibuat</div>
        <div class="col-md-8">
            <code class="text text-grayish">
                <?php echo "$datetime_creat"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">Tgl.Update</div>
        <div class="col-md-8">
            <code class="text text-grayish">
                <?php echo "$datetime_update"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">User Key</div>
        <div class="col-md-8">
            <code class="text text-grayish">
                <?php echo "$user_key_server"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">Log Aktifitas</div>
        <div class="col-md-8">
            <code class="text text-grayish">
                <?php echo "$JumlahLog Record"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 text-center text-primary">
            <input type="checkbox" name="hapus_log" id="hapus_log" value="Ya">
            <label for="hapus_log">
                <code class="text-dark">Hapus juga log aktifitasnya</code>
            </label>
        </div>
        <div class="col-md-12 text-center text-primary">
            <code class="text text-grayish">
                Apabila anda memutuskan menghapus log aktifitasnya maka anda tidak bisa lagi membuka riwayat penggunaan sumberdaya oleh API key ini.
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 text-center text-primary">
            Apakah anda yakin ingin menghapus data API Key Ini?
        </div>
    </div>
<?php 
        } 
    }
?>