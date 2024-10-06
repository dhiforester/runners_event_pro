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
            <label for="password_server_edit">Password Server</label>
        </div>
        <div class="col-md-8">
            <div class="input-group">
                <input type="text" name="password_server" id="password_server_edit" class="form-control">
                <button type="button" class="btn btn-md btn-dark" id="GeneratePasswordServerEdit">
                    <i class="bi bi-arrow-clockwise"></i> Generate
                </button>
            </div>
            <small>
                <code class="text text-grayish">Password server akan disimpan dengan format enkripsi MD5. Oleh sebab itu, sebaiknya anda mencatat parameter ini terlebih dulu.</code>
            </small>
        </div>
    </div>
    <script>
        //Generate Password Server
        $('#GeneratePasswordServerEdit').click(function(){
            $('#password_server_edit').val('...');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/ApiKey/ProsesGenerateKode.php',
                success     : function(data){
                    $('#password_server_edit').val(data);
                }
            });
        });
    </script>
<?php 
        } 
    }
?>