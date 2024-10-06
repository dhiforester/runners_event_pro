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
        <div class="col-md-4">Keterangan</div>
        <div class="col-md-8">
            <code class="text text-grayish">
                <?php echo "$description_api_key"; ?>
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
        <div class="col-md-4">Limit Session</div>
        <div class="col-md-8">
            <code class="text text-grayish">
                <?php echo "$limit_session ms ($menit min)"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">Status</div>
        <div class="col-md-8">
            <?php
                if($status=="Aktif"){
                    echo '<span class="badge badge-sm bg-success">Active</span>';
                }else{
                    echo '<span class="badge badge-sm bg-danger">None</span>';
                }
            ?>
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
        <div class="col-md-4">API Session</div>
        <div class="col-md-8">
            <code class="text text-grayish">
                <?php echo "$JumlahApiSession Record"; ?>
            </code>
        </div>
    </div>
<?php 
        } 
    }
?>