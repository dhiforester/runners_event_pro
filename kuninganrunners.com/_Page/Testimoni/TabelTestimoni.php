<?php
    session_start();
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    //Menangkan xtoken dari session
    if(empty($_SESSION['xtoken'])){
        echo '<div class="row mb-4">';
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
        //Mengatur Properti halaman
        //Buka Fungsi List Barang
        $limit=8;
        if(empty($_POST['page'])){
            $page=1;
        }else{
            $page=$_POST['page'];
        }
        $WebTestimoni=WebTestimoni($url_server,$xtoken,$page,$limit);
        $WebTestimoni=json_decode($WebTestimoni, true);
        if($WebTestimoni['response']['code']!==200){
            echo '<div class="row mb-4">';
            echo '  <div class="col-md-12">';
            echo '      <div class="card mb-3">';
            echo '          <div class="card-body text-center text-danger">';
            echo '              '.$WebTestimoni['response']['message'].'';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $jumlah_testimoni=$WebTestimoni['metadata']['jumlah_testimoni'];
            $jumlah_halaman=$WebTestimoni['metadata']['jumlah_halaman'];
            $testimoni_list=$WebTestimoni['metadata']['testimoni_list'];
            if(empty($jumlah_testimoni)){
                echo '<div class="row mb-4">';
                echo '  <div class="col-md-12">';
                echo '      <div class="card mb-3">';
                echo '          <div class="card-body text-center text-danger">';
                echo '              Tidak Ada Data Yang Ditampilkan';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }
            echo '<div class="row mb-4">';
            foreach($testimoni_list as $testimoni_list_row){
                $id_web_testimoni=$testimoni_list_row['id_web_testimoni'];
                $nama=$testimoni_list_row['nama'];
                $penilaian=$testimoni_list_row['penilaian'];
                $datetime=$testimoni_list_row['datetime'];
                $foto_profil=$testimoni_list_row['foto_profil'];
                if(empty($foto_profil)){
                    $foto_profil="assets/img/No-Image.png";
                }
                //Format Datetime
                $strtotime=strtotime($datetime);
                $datetime_format=date('d M Y H:i',$strtotime);
                echo '<div class="col-md-3">';
                echo '  <div class="card mb-3">';
                echo '      <div class="card-body">';
                echo '          <div class="row">';
                echo '              <div class="col-md-12 mb-3 text-center">';
                echo '                  <img src="' . $foto_profil . '" class="image_testimoni" alt="">';
                echo '              </div>';
                echo '              <div class="col-md-12 mb-3 text-center">';
                echo '                  <small><b>'.$nama.'</b></small><br>';
                echo '                  <small>'.$datetime_format.'</small><br>';
                for ($i = 1; $i <= $penilaian; $i++) {
                    echo '<i class="bi bi-star-fill text-warning"></i>';
                }
                echo '              </div>';
                echo '              <div class="col-md-12 mb-3 text-center">';
                echo '                  <button type="button" class="btn btn-sm btn-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalDetailTestimoni" data-id="'.$id_web_testimoni.'">';
                echo '                      Baca Komentar';
                echo '                  </button>';
                echo '              </div>';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }
            echo '</div>';
            echo '  <div class="row mb-4 mt-4">';
            echo '      <section id="blog-pagination" class="blog-pagination section">';
            echo '          <div class="container">';
            echo '              <div class="d-flex justify-content-center">';
            echo '                  <ul>';
            for ($i=1; $i <=$jumlah_halaman; $i++) { 
                if($i==$page){
                    echo '<li><a href="javascript:void(0);" class="page active">'.$i.'</a></li>';
                }else{
                    echo '<li><a href="javascript:void(0);" class="page">'.$i.'</a></li>';
                }
            }
            echo '                  </ul>';
            echo '              </div>';
            echo '          </div>';
            echo '      </section>';
            echo '  </div>';
            echo '</div>';
        }
    }
?>
<script>
    $(document).on('click', '.page', function () {
        // Ambil nilai teks dari elemen yang diklik
        let pageValue = $(this).text();
        $('#put_page').val(pageValue);
        FilterTestimoni();
    });
</script>