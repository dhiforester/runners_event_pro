<?php
    session_start();
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    //Menangkan xtoken dari session
    if(empty($_SESSION['xtoken'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <div class="card mb-3">';
        echo '          <div class="card-body text-center text-danger">';
        echo '              <small>Tidak Ada Sesi Token</small>';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $xtoken=$_SESSION['xtoken'];
        //Buka Fungsi List Barang
        if(empty($_POST['limit'])){
            $limit=4;
        }else{
            $limit=$_POST['limit'];
        }
        if(empty($_POST['page'])){
            $page=1;
        }else{
            $page=$_POST['page'];
        }
        $OrderBy="datetime";
        $ShortBy="DESC";
        $WebDataVidio=WebListVidio($url_server,$xtoken,$limit,$page,$OrderBy,$ShortBy);
        $WebDataVidio=json_decode($WebDataVidio, true);
        if($WebDataVidio['response']['code']!==200){
            echo '<div class="row">';
            echo '  <div class="col-md-12">';
            echo '      <div class="card mb-3">';
            echo '          <div class="card-body text-center text-danger">';
            echo '              <small>'.$WebDataVidio['response']['message'].'</small>';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $jumlah_data=count($WebDataVidio['metadata']);
            if(empty($jumlah_data)){
                echo '<div class="row">';
                echo '  <div class="col-md-12">';
                echo '      <div class="card mb-3">';
                echo '          <div class="card-body text-center text-danger">';
                echo '              <small>Belum Ada Data Yang Ditampilkan</small>';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $metadata=$WebDataVidio['metadata'];
                $list_vidio_arry=$metadata['list_vidio'];
                foreach($list_vidio_arry as $list_vidio){
                    $id_web_vidio=$list_vidio['id_web_vidio'];
                    $sumber_vidio=$list_vidio['sumber_vidio'];
                    $title_vidio=$list_vidio['title_vidio'];
                    $deskripsi=$list_vidio['deskripsi'];
                    $datetime=$list_vidio['datetime'];
                    $thumbnail=$list_vidio['thumbnail'];
                    //Format Datetime
                    $datetime_format=date('d/m/Y', strtotime($datetime));
?>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-6 d-flex align-items-stretch mb-4" data-aos="fade-up" data-aos-delay="100">
                    <a href="javascript:void(0);" class="team-member" data-bs-toggle="modal" data-bs-target="#ModalDetailVidio" data-id="<?php echo $id_web_vidio; ?>">
                        <div class="member-img">
                            <img src="<?php echo "$thumbnail"; ?>" class="img-fluid" alt="">
                        </div>
                        <div class="member-info">
                            <?php echo $title_vidio; ?>
                            <span><?php echo $datetime_format; ?></span>
                        </div>
                    </a>
                </div>
<?php
                }
            }
        }
    }
?>
<script>
    
</script>