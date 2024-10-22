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
            //Format Tanggal
            $strtotime1=strtotime($datetime_creat);
            $strtotime2=strtotime($datetime_update);
            $datetime_creat=date('d/m/y H:i:s T',$strtotime1);
            $datetime_update=date('d/m/y H:i:s T',$strtotime2);
            //Menghitung Jumlah Log
            $JumlahLog = mysqli_num_rows(mysqli_query($Conn, "SELECT id_log_api FROM log_api WHERE id_setting_api_key='$id_setting_api_key'"));
            $JumlahLog=number_format($JumlahLog, 0, ',', '.');
            //Milisekon tu menit
            if(!empty($limit_session)){
                $limit_session=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id_setting_api_key,'limit_session');
                $detik=$limit_session/1000;
                $menit=$detik/60;
            }else{
                $limit_session=0;
                $detik=0;
                $menit=0;
            }
            //Hitung Jumlah API Session
            $JumlahApiSession= mysqli_num_rows(mysqli_query($Conn, "SELECT id_api_session FROM api_session WHERE id_setting_api_key='$id_setting_api_key'"));
            $JumlahApiSession=number_format($JumlahApiSession, 0, ',', '.');
?>
    <input type="hidden" name="Page" value="ApiKey">
    <input type="hidden" name="Sub" value="Detail">
    <input type="hidden" name="id" value="<?php echo "$id_setting_api_key"; ?>">
    <div class="row mb-3">
        <div class="col col-md-4">
            <small>Nama API Key</small>
        </div>
        <div class="col col-md-8">
            <small>
                <code class="text text-grayish">
                    <?php echo "$title_api_key"; ?>
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <small>Deskripsi</small>
        </div>
        <div class="col col-md-8">
            <small>
                <code class="text text-grayish">
                    <?php echo "$description_api_key"; ?>
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <small>User Key</small>
        </div>
        <div class="col col-md-8">
            <small>
                <code class="text text-grayish">
                    <?php echo "$user_key_server"; ?>
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <small>Time Limit</small>
        </div>
        <div class="col col-md-8">
            <small>
                <code class="text text-grayish">
                    <?php echo "$menit min"; ?>
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <small>Datetime Creat</small>
        </div>
        <div class="col col-md-8">
            <small>
                <code class="text text-grayish">
                    <?php echo "$datetime_creat"; ?>
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <small>
                Updatetime
            </small>
        </div>
        <div class="col col-md-8">
            <small>
                <code class="text text-grayish">
                    <?php echo "$datetime_update"; ?>
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <small>API Session</small>
        </div>
        <div class="col col-md-8">
            <small>
                <code class="text text-grayish">
                    <?php echo "$JumlahApiSession Record"; ?>
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <small>Log Aktifitas</small>
        </div>
        <div class="col col-md-8">
            <small>
                <code class="text text-grayish">
                    <?php echo "$JumlahLog Record"; ?>
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <small>Status</small>
        </div>
        <div class="col col-md-8">
            <small>
                <?php
                    if($status=="Aktif"){
                        echo '<code class="text text-success"><i class="bi bi-check-circle"></i> Active</code>';
                    }else{
                        echo '<code class="text text-danger"><i class="bi bi-x-circle"></i> No Active</code>';
                    }
                ?>
            </small>
        </div>
    </div>
<?php 
        } 
    }
?>