<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center text-danger">';
        echo '      Sesi Akses Sudah Berakhir, Silahkan Login Ulang';
        echo '  </div>';
        echo '</div>';
    }else{
        $QryTentang = mysqli_query($Conn,"SELECT * FROM web_tentang WHERE id_web_tentang='1'")or die(mysqli_error($Conn));
        $DataTentang = mysqli_fetch_array($QryTentang);
        if(!empty($DataTentang['judul'])){
            $JudulTentang= $DataTentang['judul'];
            $TentangSafe= $DataTentang['tentang'];
        }else{
            $JudulTentang="";
            $TentangSafe="";
        }
        
?>
    
    <script>
        
    </script>
<?php } ?>