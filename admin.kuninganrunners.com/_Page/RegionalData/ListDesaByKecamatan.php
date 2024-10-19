<?php
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    if(!empty($_POST['id_wilayah'])){
        $id_wilayah=$_POST['id_wilayah'];
        $kecamatan=GetDetailData($Conn,'wilayah','id_wilayah',$id_wilayah,'kecamatan');
?>
<ul>
    <?php
        //Menampilkan Kabupaten
        $JumlahDesa = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='desa' AND kecamatan='$kecamatan'"));
        if(!empty($JumlahDesa)){
            $no=1;
            $query = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='desa' AND kecamatan='$kecamatan' ORDER BY desa ASC");
            while ($data = mysqli_fetch_array($query)) {
                $IdWilayahDesa= $data['id_wilayah'];
                $desa= $data['desa'];
                echo '<li class="mb-2">';
                echo '  <small class="credit"><code class="text text-grayish">'.$desa.'</code></small>';
                echo '</li>';
                $no++;
            }
        }
    ?>
</ul>
<?php } ?>