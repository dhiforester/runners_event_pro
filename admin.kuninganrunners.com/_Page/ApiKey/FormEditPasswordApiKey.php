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
?>
    <input type="hidden" name="id_setting_api_key" value="<?php echo "$id_setting_api_key"; ?>">
    <div class="row mb-3">
        <div class="col-md-12">
            <label for="password_server_edit">
                <small>Password Baru</small>
            </label>
        </div>
        <div class="col-md-12">
            <div class="input-group">
                <span class="input-group-text" id="inputGroupPrepend">
                    <small>
                        <code class="text text-dark" id="password_server_edit_length">0/20</code>
                    </small>
                </span>
                <input type="text" name="password_server" id="password_server_edit" class="form-control">
                <span class="input-group-text" id="inputGroupPrepend">
                    <a href="javascript:void(0);" id="GeneratePasswordServerEdit" title="Generate Otomatis Password Server">
                        <small>
                            <i class="bi bi-arrow-clockwise"></i>
                        </small>
                    </a>
                </span>
            </div>
            <small>
                <code class="text text-grayish">
                    Password server maksimal 20 karakter yang terdiri dari huruf dan angka.<br>
                    (Catatlah password ini karena tidak akan ditampilkan setelah disimpan)
                </code>
            </small>
        </div>
    </div>
    <script>
        //Generate Password Server
        $('#GeneratePasswordServerEdit').click(function(){
            //Hasilkan string password sebanyak 20 karakter
            var password_server=generateRandomString(20);
            // Set Nilai password tersebut ke #password_server
            $('#password_server_edit').val(password_server);
            // Hitung jumlah karakter setelah mengisi nilai otomatis
            countAndLimitCharacters('#password_server_edit', '#password_server_edit_length', 20);
        });
        // Event Ketika #password_server_edit diketik
        $('#password_server_edit').on('input', function() {
            countAndLimitCharacters('#password_server_edit', '#password_server_edit_length', 20);
        });
    </script>
<?php 
        } 
    }
?>