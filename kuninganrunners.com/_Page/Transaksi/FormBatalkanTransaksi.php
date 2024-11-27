<?php
    if(empty($_POST['kode_transaksi'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">';
        echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '          <small>';
        echo '              Tidak ada kode transaksi yang dipilih!';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $kode_transaksi=$_POST['kode_transaksi'];
        echo '<input type="hidden" name="kode_transaksi" value="'.$kode_transaksi.'">';
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <img src="assets/img/batalkan_transaksi.png" width="100%">';
        echo '  </div>';
        echo '</div>';
    }
?>