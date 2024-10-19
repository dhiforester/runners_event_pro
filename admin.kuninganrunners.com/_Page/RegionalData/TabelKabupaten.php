<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/Function.php";
    if(empty($_POST['id_wilayah'])){
        echo '<code>ID Kabupaten Tidak Boleh Kosong</code>';
    }else{
        $id_wilayah=$_POST['id_wilayah'];
        $propinsi=getDataDetail($Conn,'wilayah','id_wilayah',$id_wilayah,'propinsi');
        if(empty($propinsi)){
            echo '<code>ID Wilayah Yang Anda maksud Tidak Ditemukan Pada Database</code>';
        }else{
            $JumlahKabupaten = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Kabupaten' AND propinsi='$propinsi'"));
?>
        <div class="table table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td align="center"><b>No</b></td>
                        <td align="center"><b>ID Wilayah</b></td>
                        <td align="center"><b>Kabupaten/Kota</b></td>
                        <td align="center"><b>Jumlah Kecamatan</b></td>
                        <td align="center"><b>Option</b></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //Menampilkan Kabupaten
                        if(empty($JumlahKabupaten)){
                            echo '<tr>';
                            echo '  <td colspan="5" class="text-center text-danger">Tidak Ada Data Kabupaten/Kota Untuk Provinsi '.$propinsi.' Ini</td>';
                            echo '</tr>';
                        }else{
                            $no=1;
                            $query = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Kabupaten' AND propinsi='$propinsi' ORDER BY kabupaten ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $IdWilayahKabupaten= $data['id_wilayah'];
                                $kabupaten= $data['kabupaten'];
                                $JumlahKecamatan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='kecamatan' AND kabupaten='$kabupaten'"));
                                echo '<tr>';
                                echo '  <td align="center">'.$no.'</td>';
                                echo '  <td align="left">'.$IdWilayahKabupaten.'</td>';
                                echo '  <td align="left">'.$kabupaten.'</td>';
                                echo '  <td align="center">'.$JumlahKecamatan.' Kecamatan</td>';
                                echo '  <td align="center">';
                                echo '      <a class="btn btn-sm btn-outline-black" href="#" data-bs-toggle="dropdown" aria-expanded="false">';
                                echo '          <i class="bi bi-three-dots"></i> Option';
                                echo '      </a>';
                                echo '      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">';
                                echo '          <li class="dropdown-header text-start">';
                                echo '              <h6>Option</h6>';
                                echo '          </li>';
                                echo '';
                                echo '';
                                echo '';
                                echo '';
                                echo '';
                                echo '      </ul>';
                                echo '  </td>';
                                echo '</tr>';
                                $no++;
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
<?php }} ?>