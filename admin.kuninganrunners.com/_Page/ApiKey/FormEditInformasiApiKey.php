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
?>
    <input type="hidden" name="id_setting_api_key" value="<?php echo "$id_setting_api_key"; ?>">
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="title_api_key_edit">Nama/Judul</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="title_api_key" id="title_api_key_edit" class="form-control" value="<?php echo "$title_api_key"; ?>">
            <small>
                <code class="text text-grayish">Diisi dengan nama aplikasi/pihak yang akan terhubung.</code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="description_api_key_edit">Keterangan</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="description_api_key" id="description_api_key_edit" class="form-control" value="<?php echo "$description_api_key"; ?>">
            <small>
                <code class="text text-grayish">Diisi dengan informasi alasan/tujuan penggunaan</code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="user_key_server_edit">User Key Server</label>
        </div>
        <div class="col-md-8">
            <div class="input-group">
                <input type="text" name="user_key_server" id="user_key_server_edit" class="form-control" value="<?php echo "$user_key_server"; ?>">
                <button type="button" class="btn btn-md btn-dark" id="GenerateUserKeyEdit">
                    <i class="bi bi-arrow-clockwise"></i> Generate
                </button>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="limit_session_edit">Limit Session</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="limit_session" id="limit_session_edit" class="form-control" value="<?php echo "$limit_session"; ?>">
            <small>
                <code class="text text-grayish">Durasi waktu expired x-token setiap kali dibuat (1 s = 1000 ms)</code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="status_edit">Status</label>
        </div>
        <div class="col-md-8">
            <select name="status_api_key" id="status_api_key_edit" class="form-control" required>
                <option <?php if($status==""){echo "selected";} ?> value="">Pilih..</option>
                <option <?php if($status=="Aktif"){echo "selected";} ?> value="Aktif">Aktif</option>
                <option <?php if($status=="None"){echo "selected";} ?> value="None">None</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-8">
            <small class="text-primary">Pastikan Data API Key Yang Anda Buat Sudah Sesuai</small>
        </div>
    </div>
    <script>
        //Generate Password Server
        $('#GenerateUserKeyEdit').click(function(){
            $('#user_key_server_edit').val('...');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/ApiKey/ProsesGenerateKode.php',
                success     : function(data){
                    $('#user_key_server_edit').val(data);
                }
            });
        });
    </script>
<?php 
        } 
    }
?>