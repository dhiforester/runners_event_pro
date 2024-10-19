<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    $now=date('Y-m-d H:i');
    //Validasi Session Akses Masih ADa
    if(empty($SessionIdAkses)){
        echo '<div class="card">';
        echo '  <div class="card-body text-center">';
        echo '      <code class="text-danger">';
        echo '          Sesi akses sudah berakhir, silahkan login ulang!';
        echo '      </code>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Keyword_by
        if(!empty($_POST['KeywordBy'])){
            $keyword_by=$_POST['KeywordBy'];
        }else{
            $keyword_by="";
        }
        //keyword
        if(!empty($_POST['keyword'])){
            $keyword=$_POST['keyword'];
        }else{
            $keyword="";
        }
        //batas
        if(!empty($_POST['batas'])){
            $batas=$_POST['batas'];
        }else{
            $batas="10";
        }
        //ShortBy
        if(!empty($_POST['ShortBy'])){
            $ShortBy=$_POST['ShortBy'];
            if($ShortBy=="ASC"){
                $NextShort="DESC";
            }else{
                $NextShort="ASC";
            }
        }else{
            $ShortBy="DESC";
            $NextShort="ASC";
        }
        //OrderBy
        if(!empty($_POST['OrderBy'])){
            $OrderBy=$_POST['OrderBy'];
        }else{
            $OrderBy="id_wilayah";
        }
        //Atur Page
        if(!empty($_POST['page'])){
            $page=$_POST['page'];
            $posisi = ( $page - 1 ) * $batas;
        }else{
            $page="1";
            $posisi = 0;
        }
        if(empty($keyword_by)){
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_wilayah FROM wilayah"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_wilayah FROM wilayah WHERE kategori like '%$keyword%' OR propinsi like '%$keyword%' OR kabupaten like '%$keyword%' OR kecamatan like '%$keyword%' OR desa like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_wilayah FROM wilayah"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_wilayah FROM wilayah WHERE $keyword_by like '%$keyword%'"));
            }
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
        $('#NextPage').click(function() {
            var page=$('#NextPage').val();
            var batas="<?php echo "$batas"; ?>";
            var keyword="<?php echo "$keyword"; ?>";
            var keyword_by="<?php echo "$keyword_by"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            $('#MenampilkanTabelRegionalData').html("Loading...");
            $.ajax({
                url     : "_Page/RegionalData/TabelRegionalData.php",
                method  : "POST",
                data 	:  { page: page, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#MenampilkanTabelRegionalData').html(data);
                    $('#page').val(page);
                }
            })
        });
        //Ketika klik Previous
        $('#PrevPage').click(function() {
            var page = $('#PrevPage').val();
            var batas="<?php echo "$batas"; ?>";
            var keyword="<?php echo "$keyword"; ?>";
            var keyword_by="<?php echo "$keyword_by"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            $('#MenampilkanTabelRegionalData').html("Loading...");
            $.ajax({
                url     : "_Page/RegionalData/TabelRegionalData.php",
                method  : "POST",
                data 	:  { page: page,batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
                success : function (data) {
                    $('#MenampilkanTabelRegionalData').html(data);
                    $('#page').val(page);
                }
            })
        });
    </script>
    <?php
        if(empty($jml_data)){
            echo '<div class="card">';
            echo '  <div class="card-body text-center">';
            echo '      <code class="text-danger">';
            echo '          Tidak ada data wilayah yang bisa ditampilkan!';
            echo '      </code>';
            echo '  </div>';
            echo '</div>';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM wilayah ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori like '%$keyword%' OR propinsi like '%$keyword%' OR kabupaten like '%$keyword%' OR kecamatan like '%$keyword%' OR desa like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM wilayah ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM wilayah WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_wilayah= $data['id_wilayah'];
                $kategori= $data['kategori'];
                $propinsi= $data['propinsi'];
                $kabupaten= $data['kabupaten'];
                $kecamatan= $data['kecamatan'];
                $desa= $data['desa'];
        ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                <li class="dropdown-header text-start">
                                    <h6>Option</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalEditRegionalData" data-id="<?php echo "$id_wilayah"; ?>">
                                        <i class="bi bi-pencil"></i> Edit Wilayah
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDeleteRegionalData" data-id="<?php echo "$id_wilayah"; ?>">
                                        <i class="bi bi-x"></i> Hapus Wilayah
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <?php
                            if($kategori=="desa"){
                                echo '<div class="card-header">';
                                echo '  <b class="card-title">'.$no.'. '.$desa.'</b><br>';
                                echo '  <small class="credit"><code class="text text-grayish"><i class="bi bi-tag"></i> '.$kategori.'</code></small>';
                                echo '</div>';
                                echo '<div class="card-body">';
                                echo '  <div class="row">';
                                echo '      <div class="col-md-4">';
                                echo '          <div class="row">';
                                echo '              <div class="col col-md-6"><small>Kategori</small></div>';
                                echo '              <div class="col col-md-6"><small><code class="text text-grayish">'.$kategori.'</code></small></div>';
                                echo '          </div>';
                                echo '          <div class="row">';
                                echo '              <div class="col col-md-6"><small>Kode</small></div>';
                                echo '              <div class="col col-md-6"><small><code class="text text-grayish">'.$id_wilayah.'</code></small></div>';
                                echo '          </div>';
                                echo '      </div>';
                                echo '      <div class="col-md-4">';
                                echo '          <div class="row">';
                                echo '              <div class="col col-md-6"><small>Provinsi</small></div>';
                                echo '              <div class="col col-md-6"><small><code class="text text-grayish">'.$propinsi.'</code></small></div>';
                                echo '          </div>';
                                echo '          <div class="row">';
                                echo '              <div class="col col-md-6"><small>Kab/Kota</small></div>';
                                echo '              <div class="col col-md-6"><small><code class="text text-grayish">'.$kabupaten.'</code></small></div>';
                                echo '          </div>';
                                echo '      </div>';
                                echo '      <div class="col-md-4">';
                                echo '          <div class="row">';
                                echo '              <div class="col col-md-6"><small>Kecamatan</small></div>';
                                echo '              <div class="col col-md-6"><small><code class="text text-grayish">'.$kecamatan.'</code></small></div>';
                                echo '          </div>';
                                echo '          <div class="row">';
                                echo '              <div class="col col-md-6"><small>Desa/Kel</small></div>';
                                echo '              <div class="col col-md-6"><small><code class="text text-grayish">'.$desa.'</code></small></div>';
                                echo '          </div>';
                                echo '      </div>';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                if($kategori=="Kecamatan"){
                                    //Hitung Jumlah Desa
                                    $query_jumlah = mysqli_query($Conn, "SELECT COUNT(*) AS jumlah_desa FROM wilayah WHERE kategori='desa' AND kecamatan='$kecamatan'");
                                    $Baris = mysqli_fetch_assoc($query_jumlah);
                                    $JumlahDesa = $Baris['jumlah_desa'];
                                    echo '<div class="card-header">';
                                    echo '  <b class="card-title">'.$no.'. '.$kecamatan.'</b><br>';
                                    echo '  <small class="credit"><code class="text text-grayish"><i class="bi bi-tag"></i> '.$kategori.'</code></small>';
                                    echo '</div>';
                                    echo '<div class="card-body">';
                                    echo '  <div class="row">';
                                    echo '      <div class="col-md-4">';
                                    echo '          <div class="row">';
                                    echo '              <div class="col col-md-6"><small>Kategori</small></div>';
                                    echo '              <div class="col col-md-6"><small><code class="text text-grayish">'.$kategori.'</code></small></div>';
                                    echo '          </div>';
                                    echo '          <div class="row">';
                                    echo '              <div class="col col-md-6"><small>Kode</small></div>';
                                    echo '              <div class="col col-md-6"><small><code class="text text-grayish">'.$id_wilayah.'</code></small></div>';
                                    echo '          </div>';
                                    echo '      </div>';
                                    echo '      <div class="col-md-4">';
                                    echo '          <div class="row">';
                                    echo '              <div class="col col-md-6"><small>Provinsi</small></div>';
                                    echo '              <div class="col col-md-6"><small><code class="text text-grayish">'.$propinsi.'</code></small></div>';
                                    echo '          </div>';
                                    echo '          <div class="row">';
                                    echo '              <div class="col col-md-6"><small>Kab/Kota</small></div>';
                                    echo '              <div class="col col-md-6"><small><code class="text text-grayish">'.$kabupaten.'</code></small></div>';
                                    echo '          </div>';
                                    echo '      </div>';
                                    echo '      <div class="col-md-4">';
                                    echo '          <div class="row">';
                                    echo '              <div class="col col-md-6"><small>Kecamatan</small></div>';
                                    echo '              <div class="col col-md-6"><small><code class="text text-grayish">'.$kecamatan.'</code></small></div>';
                                    echo '          </div>';
                                    echo '          <div class="row">';
                                    echo '              <div class="col col-md-6"><small>Desa/Kel</small></div>';
                                    echo '              <div class="col col-md-6"><small><code class="text text-grayish">'.$JumlahDesa.' Record</code></small></div>';
                                    echo '          </div>';
                                    echo '      </div>';
                                    echo '  </div>';
                                    echo '</div>';
                                }else{
                                    if($kategori=="Kabupaten"){
                                        //Hitung Jumlah Kecamatan dan Desa
                                        $sql = "
                                            SELECT 
                                                SUM(CASE WHEN kategori = 'Kecamatan' THEN 1 ELSE 0 END) AS JumlahKecamatan,
                                                SUM(CASE WHEN kategori = 'desa' THEN 1 ELSE 0 END) AS JumlahDesa
                                            FROM wilayah
                                            WHERE kabupaten = ?
                                        ";
                                        $stmt = $Conn->prepare($sql);
                                        $stmt->bind_param('s', $kabupaten);
                                        $stmt->execute();
                                        $stmt->bind_result($JumlahKecamatan, $JumlahDesa);
                                        $stmt->fetch();
                                        $stmt->close();
                                        echo '<div class="card-header">';
                                        echo '  <b class="card-title">'.$no.'. '.$kabupaten.'</b><br>';
                                        echo '  <small class="credit"><code class="text text-grayish"><i class="bi bi-tag"></i> '.$kategori.'</code></small>';
                                        echo '</div>';
                                        echo '<div class="card-body">';
                                        echo '  <div class="row">';
                                        echo '      <div class="col-md-4">';
                                        echo '          <div class="row">';
                                        echo '              <div class="col col-md-6"><small>Kategori</small></div>';
                                        echo '              <div class="col col-md-6"><small><code class="text text-grayish">'.$kategori.'</code></small></div>';
                                        echo '          </div>';
                                        echo '          <div class="row">';
                                        echo '              <div class="col col-md-6"><small>Kode</small></div>';
                                        echo '              <div class="col col-md-6"><small><code class="text text-grayish">'.$id_wilayah.'</code></small></div>';
                                        echo '          </div>';
                                        echo '      </div>';
                                        echo '      <div class="col-md-4">';
                                        echo '          <div class="row">';
                                        echo '              <div class="col col-md-6"><small>Provinsi</small></div>';
                                        echo '              <div class="col col-md-6"><small><code class="text text-grayish">'.$propinsi.'</code></small></div>';
                                        echo '          </div>';
                                        echo '          <div class="row">';
                                        echo '              <div class="col col-md-6"><small>Kab/Kota</small></div>';
                                        echo '              <div class="col col-md-6"><small><code class="text text-grayish">'.$kabupaten.'</code></small></div>';
                                        echo '          </div>';
                                        echo '      </div>';
                                        echo '      <div class="col-md-4">';
                                        echo '          <div class="row">';
                                        echo '              <div class="col col-md-6"><small>Kecamatan</small></div>';
                                        echo '              <div class="col col-md-6"><small><code class="text text-grayish">'.$JumlahKecamatan.' Record</code></small></div>';
                                        echo '          </div>';
                                        echo '          <div class="row">';
                                        echo '              <div class="col col-md-6"><small>Desa/Kel</small></div>';
                                        echo '              <div class="col col-md-6"><small><code class="text text-grayish">'.$JumlahDesa.' Record</code></small></div>';
                                        echo '          </div>';
                                        echo '      </div>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }else{
                                        //Hitung Jumlah Desa
                                        $query_jumlah = mysqli_query($Conn, "SELECT COUNT(*) AS jumlah_desa FROM wilayah WHERE kategori='desa' AND propinsi='$propinsi'");
                                        $Baris = mysqli_fetch_assoc($query_jumlah);
                                        $JumlahDesa = $Baris['jumlah_desa'];
                                        //Hitung Jumlah Kecamatan
                                        $query_jumlah_kecamatan = mysqli_query($Conn, "SELECT COUNT(*) AS jumlah_kecamatan FROM wilayah WHERE kategori='Kecamatan' AND propinsi='$propinsi'");
                                        $BarisKecamatan = mysqli_fetch_assoc($query_jumlah_kecamatan);
                                        $JumlahKecamatan = $BarisKecamatan['jumlah_kecamatan'];
                                        //Hitung Jumlah Kabupaten
                                        $query_jumlah_kabupaten = mysqli_query($Conn, "SELECT COUNT(*) AS jumlah_kabupaten FROM wilayah WHERE kategori='Kabupaten' AND propinsi='$propinsi'");
                                        $BarisKabupaten = mysqli_fetch_assoc($query_jumlah_kabupaten);
                                        $JumlahKabupaten = $BarisKabupaten['jumlah_kabupaten'];
                                        echo '<div class="card-header">';
                                        echo '  <b class="card-title">'.$no.'. '.$propinsi.'</b><br>';
                                        echo '  <small class="credit"><code class="text text-grayish"><i class="bi bi-tag"></i> '.$kategori.'</code></small>';
                                        echo '</div>';
                                        echo '<div class="card-body">';
                                        echo '  <div class="row">';
                                        echo '      <div class="col-md-4">';
                                        echo '          <div class="row">';
                                        echo '              <div class="col col-md-6"><small class="credit">Kategori</small></div>';
                                        echo '              <div class="col col-md-6"><small class="credit"><code class="text text-grayish">'.$kategori.'</code></small></div>';
                                        echo '          </div>';
                                        echo '          <div class="row">';
                                        echo '              <div class="col col-md-6"><small class="credit">Kode</small></div>';
                                        echo '              <div class="col col-md-6"><small class="credit"><code class="text text-grayish">'.$id_wilayah.'</code></small></div>';
                                        echo '          </div>';
                                        echo '      </div>';
                                        echo '      <div class="col-md-4">';
                                        echo '          <div class="row">';
                                        echo '              <div class="col col-md-6"><small class="credit">Provinsi</small></div>';
                                        echo '              <div class="col col-md-6"><small class="credit"><code class="text text-grayish">'.$propinsi.'</code></small></div>';
                                        echo '          </div>';
                                        echo '          <div class="row">';
                                        echo '              <div class="col col-md-6"><small class="credit">Kab/Kota</small></div>';
                                        echo '              <div class="col col-md-6"><small class="credit"><code class="text text-grayish">'.$JumlahKabupaten.' Record</code></small></div>';
                                        echo '          </div>';
                                        echo '      </div>';
                                        echo '      <div class="col-md-4">';
                                        echo '          <div class="row">';
                                        echo '              <div class="col col-md-6"><small class="credit">Kecamatan</small></div>';
                                        echo '              <div class="col col-md-6"><small class="credit"><code class="text text-grayish">'.$JumlahKecamatan.' Record</code></small></div>';
                                        echo '          </div>';
                                        echo '          <div class="row">';
                                        echo '              <div class="col col-md-6"><small class="credit">Desa/Kel</small></div>';
                                        echo '              <div class="col col-md-6"><small class="credit"><code class="text text-grayish">'.$JumlahDesa.' Record</code></small></div>';
                                        echo '          </div>';
                                        echo '      </div>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
    <?php
                $no++; 
            }
        }
    ?>
    <div class="row mb-3 mt-3">
        <div class="col-md-12 text-center">
            <div class="btn-group shadow-0" role="group" aria-label="Basic example">
                <button class="btn btn-md btn-grayish" id="PrevPage" value="<?php echo $prev;?>">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="btn btn-md btn-outline-grayish" id="PrevPage" value="<?php echo $prev;?>">
                    <?php echo "$page OF $JmlHalaman"; ?>
                </button>
                <button class="btn btn-md btn-grayish" id="NextPage" value="<?php echo $next;?>">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
<?php } ?>