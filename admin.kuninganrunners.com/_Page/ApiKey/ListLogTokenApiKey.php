<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Session Login
    if(empty($SessionIdAkses)){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          Sessi Login Sudah Berakhir, Silahkan Login Ulang.';
        echo '      </div>';
        echo '  </div>';
    }else{
        //Tangkap GetData
        if(empty($_POST['GetData'])){
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          Tidak ada data yang ditangkap oleh sistem';
            echo '      </div>';
            echo '  </div>';
        }else{
            $GetData=$_POST['GetData'];
            //Explode
            $explode=explode(',',$GetData);
            $id_setting_api_key=$explode[0];
            $periode=$explode[1];
            $Keyword=$explode[2];
            //Bersihkan Variabel
            $id_setting_api_key=validateAndSanitizeInput($id_setting_api_key);
            $periode=validateAndSanitizeInput($periode);
            $Keyword=validateAndSanitizeInput($Keyword);
            $id_setting_api_key=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id_setting_api_key,'id_setting_api_key');
            if(empty($id_setting_api_key)){
                echo '  <div class="row">';
                echo '      <div class="col-md-12 text-center text-danger">';
                echo '          Api Key ID Tidak Valid Atau Tidak Ditemukan Pada Database.';
                echo '      </div>';
                echo '  </div>';
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_api_session FROM api_session WHERE (id_setting_api_key='$id_setting_api_key') AND (datetime_creat LIKE '%$Keyword%')"));
?>
    <div class="row mb-3">
        <div class="col-md-12 text-center">
            <b class="card-title text-dark">List Log X-Token Api Key</b>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 table table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <td align="center"><b>No</b></td>
                        <td align="center"><b>Creat</b></td>
                        <td align="center"><b>Expired</b></td>
                        <td align="center"><b>Token</b></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($jml_data)){
                            echo '<tr>';
                            echo '  <td align="center" colspan="4" class="text-danger">Tidak ada log session x-token yang ditemukan</td>';
                            echo '</tr>';
                        }else{
                            $no=1;
                            $query = mysqli_query($Conn, "SELECT*FROM api_session WHERE (id_setting_api_key='$id_setting_api_key') AND (datetime_creat LIKE '%$Keyword%') ORDER BY id_api_session ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_api_session= $data['id_api_session'];
                                $datetime_creat= $data['datetime_creat'];
                                $datetime_expired= $data['datetime_expired'];
                                $xtoken= $data['xtoken'];
                                echo '<tr>';
                                echo '  <td align="center">'.$no.'</td>';
                                echo '  <td align="left">'.$datetime_creat.'</td>';
                                echo '  <td align="left">'.$datetime_expired.'</td>';
                                echo '  <td align="left">'.$xtoken.'</td>';
                                echo '</tr>';
                                $no++;
                            }
                            $Conn->close();
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php 
            } 
        } 
    }
?>