<?php
    //Menangkap Data
    if(empty($_POST['GetData'])){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '  <small>';
        echo '      <code>Tidak Ada Data yang Dikirim!</code>';
        echo '  </small>';
        echo '</div>';
    }else{
        $GetData=$_POST['GetData'];
        $explode=explode('|',$GetData);
        //Buka Masing-masing Data
        $id_transaksi_keranjang=$explode[0];
        $nama_barang=$explode[1];
        $harga_fix=$explode[2];
        $qty=$explode[3];
        //Format Harga
        $harga_fix_format='Rp ' . number_format($harga_fix, 0, ',', '.');

        echo '<input type="hidden" name="id_transaksi_keranjang" value="'.$id_transaksi_keranjang.'">';
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-4">';
        echo '      <small>Nama Barang</small>';
        echo '  </div>';
        echo '  <div class="col col-md-8">';
        echo '      <small><code class="text text-grayish">'.$nama_barang.'</code></small>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-4">';
        echo '      <small>Harga</small>';
        echo '  </div>';
        echo '  <div class="col col-md-8">';
        echo '      <small><code class="text text-grayish">'.$harga_fix_format.'</code></small>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-4">';
        echo '      <label for="QtyEdit"><small>Kuantitias (Qty)</small></label>';
        echo '  </div>';
        echo '  <div class="col-md-8">';
        echo '      <input type="number" min="0" id="QtyEdit" name="qty" class="form-control" value="'.$qty.'">';
        echo '      <small>';
        echo '          <code class="text text-grayish">Kosongkan kuantitas untuk menghapus item barang dari keranjang</code>';
        echo '      </small>';
        echo '  </div>';
        echo '</div>';
    }
?>