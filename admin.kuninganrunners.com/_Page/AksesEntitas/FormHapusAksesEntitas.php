<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Uang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['uuid_akses_entitas'])){
            echo '<code>ID Entitias Tidak Boleh Kosong!</code>';
        }else{
            $uuid_akses_entitas=$_POST['uuid_akses_entitas'];
            //Bersihkan Data
            $uuid_akses_entitas=validateAndSanitizeInput($uuid_akses_entitas);
            $uuid_akses_entitas=GetDetailData($Conn,'akses_entitas','uuid_akses_entitas',$uuid_akses_entitas,'uuid_akses_entitas');
            if(empty($uuid_akses_entitas)){
                echo '<code>ID Entitias Tidak Valid, Atau Tidak Ditemukan Pada Database!</code>';
            }else{
                $NamaAkses=GetDetailData($Conn,'akses_entitas','uuid_akses_entitas',$uuid_akses_entitas,'akses');
                $KeteranganEntitias=GetDetailData($Conn,'akses_entitas','uuid_akses_entitas',$uuid_akses_entitas,'keterangan');
?>
        <input type="hidden" name="uuid_akses_entitas" value="<?php echo $uuid_akses_entitas; ?>">
        <div class="row mb-3">
            <div class="col col-md-4">Nama Entitias</div>
            <div class="col col-md-8">
                <small class="credit">
                    <code class="text text-grayish"><?php echo "$NamaAkses"; ?></code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4 mb-3">Keterangan</div>
            <div class="col col-md-8 mb-3">
                <small class="credit">
                    <code class="text text-grayish"><?php echo "$KeteranganEntitias"; ?></code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-12 mb-3 text-center text-danger">
                Apakah anda yakin akan menghapus data ini?
            </div>
        </div>
<?php
            }
        }
    }
?>