<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="datetime"){
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="raw_member"){
                echo '<input type="text" name="keyword" id="keyword" class="form-control" placeholder="Nama/Email Member">';
            }else{
                if($keyword_by=="status"){
                    $jumlah_Lunas=mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi WHERE status='Lunas' AND kategori='Pembelian'"));
                    $jumlah_Pending=mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi WHERE status='Pending' AND kategori='Pembelian'"));
                    $jumlah_Menunggu=mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi WHERE status='Menunggu' AND kategori='Pembelian'"));
                    echo '<select name="keyword" id="keyword" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                    echo '  <option value="Lunas">Lunas ('.$jumlah_Lunas.')</option>';
                    echo '  <option value="Menunggu">Menunggu ('.$jumlah_Menunggu.')</option>';
                    echo '  <option value="Pending">Pending ('.$jumlah_Pending.')</option>';
                    echo '</select>';
                }else{
                    echo '<input type="text" name="keyword" id="keyword" class="form-control">';
                }
            }
        }
    }
?>