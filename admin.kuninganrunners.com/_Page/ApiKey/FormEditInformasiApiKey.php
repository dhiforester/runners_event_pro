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
            $title_api_key=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id_setting_api_key,'title_api_key');
            $description_api_key=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id_setting_api_key,'description_api_key');
            $user_key_server=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id_setting_api_key,'user_key_server');
            $status=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id_setting_api_key,'status');
            $limit_session=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id_setting_api_key,'limit_session');
            //Menghiutng Jumlah Karakter
            $title_api_key_length = strlen($title_api_key);
            $description_api_key_length = strlen($description_api_key);
            $user_key_server_length = strlen($user_key_server);
?>
    <input type="hidden" name="id_setting_api_key" value="<?php echo "$id_setting_api_key"; ?>">
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="title_api_key_edit">
                <small>Nama API Key</small>
            </label>
        </div>
        <div class="col-md-8">
            <div class="input-group">
                <span class="input-group-text" id="inputGroupPrepend">
                    <small>
                        <code class="text text-dark" id="title_api_key_edit_length"><?php echo $title_api_key_length; ?>/50</code>
                    </small>
                </span>
                <input type="text" name="title_api_key" id="title_api_key_edit" class="form-control" value="<?php echo $title_api_key; ?>">
            </div>
            <small>
                <code class="text text-grayish">Diisi dengan nama aplikasi/pihak yang akan terhubung.</code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="description_api_key_edit">
                <small>
                    Deskripsi
                </small>
            </label>
        </div>
        <div class="col-md-8">
            <div class="input-group">
                <span class="input-group-text" id="inputGroupPrepend">
                    <small>
                        <code class="text text-dark" id="description_api_key_edit_length"><?php echo $description_api_key_length; ?>/200</code>
                    </small>
                </span>
                <input type="text" name="description_api_key" id="description_api_key_edit" class="form-control" value="<?php echo $description_api_key; ?>">
            </div>
            <small>
                <code class="text text-grayish">Diisi dengan informasi keterangan penggunaan</code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="user_key_server_edit">
                <small>User Key</small>
            </label>
        </div>
        <div class="col-md-8">
            <div class="input-group">
                <span class="input-group-text" id="inputGroupPrepend">
                    <small>
                        <code class="text text-dark" id="user_key_server_edit_length"><?php echo $user_key_server_length; ?>/36</code>
                    </small>
                </span>
                <input type="text" name="user_key_server" id="user_key_server_edit" class="form-control" value="<?php echo $user_key_server; ?>">
                <span class="input-group-text" id="inputGroupPrepend">
                    <a href="javascript:void(0);" id="GenerateUserKeyEdit" title="Generate Otomatis API Key">
                        <small>
                            <i class="bi bi-arrow-clockwise"></i>
                        </small>
                    </a>
                </span>
            </div>
            <small>
                <code class="text text-grayish">Maksimal 36 karakter yang terdiri dari huruf dan angka</code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="limit_session_edit">
                <small>Time Limit</small>
            </label>
        </div>
        <div class="col-md-8">
            <select name="limit_session" id="limit_session_edit" class="form-control" required>
                <option <?php if($limit_session==""){echo "selected";} ?> value="">Pilih..</option>
                <option <?php if($limit_session=="60000"){echo "selected";} ?> value="60000">1 Menit</option>
                <option <?php if($limit_session=="300000"){echo "selected";} ?> value="300000">5 Menit</option>
                <option <?php if($limit_session=="600000"){echo "selected";} ?> value="600000">10 Menit</option>
                <option <?php if($limit_session=="1800000"){echo "selected";} ?> value="1800000">30 Menit</option>
            </select>
            <small>
                <code class="text text-grayish">Durasi waktu expired x-token setiap kali dibuat</code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="status_api_key_edit">
                <small>
                    Status
                </small>
            </label>
        </div>
        <div class="col-md-8">
            <select name="status_api_key" id="status_api_key_edit" class="form-control" required>
                <option <?php if($status==""){echo "selected";} ?>  value="">Pilih..</option>
                <option <?php if($status=="Aktif"){echo "selected";} ?>  value="Aktif">Active</option>
                <option <?php if($status=="None"){echo "selected";} ?>  value="None">No Active</option>
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
            // Hasilkan string acak dengan panjang 36 karakter
            var string = generateRandomString(36);
            // Set nilai string ke input #user_key_server
            $('#user_key_server_edit').val(string);
            // Hitung jumlah karakter setelah mengisi nilai otomatis
            countAndLimitCharacters('#user_key_server_edit', '#user_key_server_edit_length', 36);
        });
        //Event ketika #title_api_key_edit diketik
        $('#title_api_key_edit').on('input', function() {
            countAndLimitCharacters('#title_api_key_edit', '#title_api_key_edit_length', 50);
        });

        //Event ketika #description_api_key_edit diketik
        $('#description_api_key_edit').on('input', function() {
            countAndLimitCharacters('#description_api_key_edit', '#description_api_key_edit_length', 200);
        });

        // Event Ketika #user_key_server_edit diketik
        $('#user_key_server_edit').on('input', function() {
            countAndLimitCharacters('#user_key_server_edit', '#user_key_server_edit_length', 36);
        });
    </script>
<?php 
        } 
    }
?>