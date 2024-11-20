<?php
    session_start();
    include "../_Config/Connection.php";
    include "../_Config/GlobalFunction.php";
    //Menangkan xtoken dari session
    if(empty($_SESSION['xtoken'])){
        echo '<div class="col-md-12">';
        echo '  <div class="card mb-3">';
        echo '      <div class="card-body text-center text-danger">';
        echo '          <small>Tidak Ada Sesi Token</small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $xtoken=$_SESSION['xtoken'];
        //Buka Fungsi List Member
        $limit=8;
        $page="";
        $OrderBy="";
        $ShortBy="";
        $WebDataMemberJson=WebListMember($url_server,$xtoken,$limit,$page,$OrderBy,$ShortBy);
        $WebDataMember=json_decode($WebDataMemberJson, true);
        if($WebDataMember['response']['code']!==200){
            echo '<div class="col-md-12">';
            echo '  <div class="card mb-3">';
            echo '      <div class="card-body text-center text-danger">';
            echo '          <small>Terjadi Kesalahan</small><br>';
            echo '          <small>'.$WebDataMember['response']['message'].'</small>';
            echo '          <small>'.$WebDataMemberJson.'</small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $jumlah_data=count($WebDataMember['metadata']);
            if(empty($jumlah_data)){
                echo '<div class="col-md-12">';
                echo '  <div class="card mb-3">';
                echo '      <div class="card-body text-center text-danger">';
                echo '      <small>Belum Ada Data Yang Ditampilkan</small>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $metadata=$WebDataMember['metadata'];
                foreach($metadata as $list_member){
                    $nama=$list_member['nama'];
                    $kontak=$list_member['kontak'];
                    $email=$list_member['email'];
                    $foto=$list_member['foto'];
                    $datetime=$list_member['datetime'];
                    //Mengubah Gambar
                    $new_width=500;
                    $new_height=500;
                    $ImageBase64=resizeImage($foto, $new_width, $new_height);
                    //Format Email Dan Kontak
                    if(!empty($kontak)){
                        $kontak=SensorKontak($kontak);
                    }else{
                        $kontak="None";
                    }
                    if(!empty($email)){
                        $email=SensorEmail($email);
                    }else{
                        $email="None";
                    }
                    //Format Tanggal Daftar
                    $strtotime=strtotime($datetime);
                    $tanggal_daftar=date('d/m/Y H:i', $strtotime);
?>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6">
                    <div class="card mb-3 card-member" id="">
                        <div class="card-body" >
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img src="data:image/jpeg;base64,<?php echo "$ImageBase64"; ?>" class="image_member" width="100px" height="100px">
                                </div>
                                <div class="col-md-12 text-center">
                                    <small class="text text-light"><?php echo $nama; ?></small><br>
                                    <small class="text text-light">
                                        <?php echo $tanggal_daftar; ?>
                                    </small><br>
                                    <small class="text text-light">
                                        <code><?php echo $email; ?></code>
                                    </small><br>
                                    <small class="text text-light">
                                        <code><?php echo $kontak; ?></code>
                                    </small><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php
                }
            }
        }
    }
?>