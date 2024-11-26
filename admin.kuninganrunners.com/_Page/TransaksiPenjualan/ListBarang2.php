<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Uang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['keyword_barang'])){
            $keyword_barang="";
        }else{
            $keyword_barang=$_POST['keyword_barang'];
        }
        //Mencari Jumlah Data
        if(empty($keyword_barang)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang FROM barang"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang FROM barang WHERE nama_barang like '%$keyword_barang%'"));
        }
        if(empty($jml_data)){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  Tidak Ada Data Barang Yang Ditemukan';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $batas="10";
            //Atur Page
            if(!empty($_POST['page'])){
                $page=$_POST['page'];
                $posisi = ( $page - 1 ) * $batas;
            }else{
                $page="1";
                $posisi = 0;
            }
            //Mengatur Halaman
            $JmlHalaman = ceil($jml_data/$batas); 
            $prev=$page-1;
            $next=$page+1;
            if($next>$JmlHalaman){
                $next=$page;
            }else{
                $next=$page+1;
            }
            if($prev<"1"){
                $prev="1";
            }else{
                $prev=$page-1;
            }
?>
            <script>
                //ketika klik next
                $('#NextPageBarang2').click(function() {
                    var NextPageBarang=$('#NextPageBarang2').val();
                    $('#put_page_barang2').val(NextPageBarang);
                    ListBarang2();
                });
                //Ketika klik Previous
                $('#PrevPageBarang2').click(function() {
                    var PrevPageBarang = $('#PrevPageBarang2').val();
                    $('#put_page_barang2').val(PrevPageBarang);
                    ListBarang2();
                });
                //Ketika  Salah Satu Data Dipilih
            </script>
            <div class="row mb-3">
                <div class="col-md-12 mb-3">
                    <ol class="list-group list-group-numbered">
                        <?php
                            $no=1+$posisi;
                            if(empty($keyword_barang)){
                                $query = mysqli_query($Conn, "SELECT*FROM barang ORDER BY nama_barang ASC LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM barang WHERE nama_barang like '%$keyword_barang%' ORDER BY nama_barang ASC LIMIT $posisi, $batas");
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $id_barang= $data['id_barang'];
                                $nama_barang= $data['nama_barang'];
                                $harga= $data['harga'];
                                $stok= $data['stok'];
                                $harga='Rp ' . number_format($harga, 0, ',', '.');
                                echo '<li class="list-group-item d-flex justify-content-between align-items-start">';
                                echo '  <div class="ms-2 me-auto">';
                                echo '       <div class="fw-bold">';
                                echo '          <small>'.$nama_barang.'</small>';
                                echo '       </div>';
                                echo '      <small><code class="text text-grayish">'.$harga.'</code></small><br>';
                                echo '      <small><code class="text text-grayish">Stok: '.$stok.'</code></small>';
                                echo '  </div>';
                                echo '  <a href="javascript:void(0);" class="text text-grayish" data-bs-toggle="modal" data-bs-target="#ModalPilihBarang2" data-id="'.$id_barang.'">';
                                echo '      <small><code class="text text-primary">Pilih</code></small>';
                                echo '  </a>';
                                echo '</li>';
                            }
                        ?>
                    </ol>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 text-center">
                    <div class="btn-group shadow-0" role="group" aria-label="Basic example">
                        <button class="btn btn-sm btn-grayish" id="PrevPageBarang2" value="<?php echo $prev;?>">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-grayish">
                            <?php echo "$page of $JmlHalaman"; ?>
                        </button>
                        <button class="btn btn-sm btn-grayish" id="NextPageBarang2" value="<?php echo $next;?>">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
<?php
        }
    }
?>
