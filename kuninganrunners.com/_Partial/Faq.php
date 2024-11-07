<?php
    //Menangkan xtoken dari session
    session_start();
    if(empty($_SESSION['xtoken'])){
        echo "Silahkan Muat Ulang Halaman Terlebih Dulu!";
    }else{
        $xtoken=$_SESSION['xtoken'];
        include "../_Config/Connection.php";
        include "../_Config/GlobalFunction.php";
        //Mengatur Properti halaman
        $page_album=1;
        $limit_album=8;
        $WebFaq=WebFaq($url_server,$xtoken);
        $WebFaq=json_decode($WebFaq, true);
        if($WebFaq['response']['code']!==200){
            echo "Terjadi kesalahan pada server";
        }else{
            $metadata=$WebFaq['metadata'];
            if(empty(count($metadata))){
                echo "Tidak Ada Data Konten Yang Ditampilkan";
            }else{
                foreach($metadata as $faq_list){
                    $urutan=$faq_list['urutan'];
                    $pertanyaan=$faq_list['pertanyaan'];
                    $jawaban=$faq_list['jawaban'];
                    echo '<div class="accordion-item">';
                    echo '  <h2 class="mb-0">';
                    echo '      <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-'.$urutan.'">';
                    echo '          '.$pertanyaan.'';
                    echo '      </button>';
                    echo '  </h2>';
                    echo '  <div id="collapse-faq-'.$urutan.'" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-faq">';
                    echo '      <div class="accordion-body">';
                    echo '         '.$jawaban.'';
                    echo '      </h4>';
                    echo '  </div>';
                    echo '</div>';
                }
            }
        }
    }
?>
