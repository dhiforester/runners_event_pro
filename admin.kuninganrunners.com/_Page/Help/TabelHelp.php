<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Sesi Akses Sudah Berakhir. Silahkan Login Ulang Terlebih Dulu';
        echo '  </div>';
        echo '</div>';
    }else{
        //Keyword_by
        if(!empty($_POST['keyword_by'])){
            $keyword_by=$_POST['keyword_by'];
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
        }else{
            $ShortBy="DESC";
        }
        //OrderBy
        if(!empty($_POST['OrderBy'])){
            $OrderBy=$_POST['OrderBy'];
        }else{
            $OrderBy="id_help";
        }
        //Atur Page dan posisi
        if(!empty($_POST['page'])){
            $page=$_POST['page'];
            $posisi = ( $page - 1 ) * $batas;
        }else{
            $page="1";
            $posisi = 0;
        }
        // Kolom yang digunakan untuk pencarian
        $columns = ['id_help', 'author', 'judul', 'kategori', 'deskripsi', 'datetime_creat', 'datetime_update', 'status'];
        $keyword_qry = mysqli_real_escape_string($Conn, $keyword);
        $conditions = [];
        foreach ($columns as $column) {
            $conditions[] = "$column LIKE '%$keyword_qry%'";
        }
        $whereClause = implode(' OR ', $conditions);

        // Mencari jumlah data
        $query = "SELECT COUNT(*) as jml_data FROM help";
        if (!empty($keyword)) {
            if (empty($keyword_by)) {
                $query .= " WHERE $whereClause";
            } else {
                $keyword_by_qry = mysqli_real_escape_string($Conn, $keyword_by);
                $query .= " WHERE $keyword_by_qry LIKE '%$keyword_qry%'";
            }
        }

        $result = $Conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            $jml_data = $row['jml_data'];
        } else {
            $jml_data=0;
        }
?>
    <script>
        //ketika klik next
        $('#NextPage').click(function() {
            var valueNext=$('#NextPage').val();
            var batas="<?php echo "$batas"; ?>";
            var keyword="<?php echo "$keyword"; ?>";
            var keyword_by="<?php echo "$keyword_by"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            $.ajax({
                url     : "_Page/Help/TabelHelp.php",
                method  : "POST",
                data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#MenampilkanTabelHelp').html(data);
                    $('#PutPage').val(valueNext);

                }
            })
        });
        //Ketika klik Previous
        $('#PrevPage').click(function() {
            var ValuePrev = $('#PrevPage').val();
            var batas="<?php echo "$batas"; ?>";
            var keyword="<?php echo "$keyword"; ?>";
            var keyword_by="<?php echo "$keyword_by"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            $.ajax({
                url     : "_Page/Help/TabelHelp.php",
                method  : "POST",
                data 	:  { page: ValuePrev,batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
                success : function (data) {
                    $('#MenampilkanTabelHelp').html(data);
                    $('#PutPage').val(ValuePrev);
                }
            })
        });
    </script>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td align="center"><b>No</b></td>
                            <td align="center"><b>Konten Bantuan</b></td>
                            <td align="center"><b>Tanggal</b></td>
                            <td align="center"><b>Author</b></td>
                            <td align="center"><b>Status</b></td>
                            <td align="center"><b>Option</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(empty($jml_data)){
                                echo '<tr>';
                                echo '  <td class="text-center text-danger" colspan="6">';
                                echo '      Tidak Ada Data Bantuan Yang Dapat Ditampilkan';
                                echo '  </td>';
                                echo '</tr>';
                            }else{
                                $no = 1+$posisi;
                                //KONDISI PENGATURAN MASING FILTER
                                if(empty($keyword_by)){
                                    if(empty($keyword)){
                                        $query = mysqli_query($Conn, "SELECT*FROM help ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                    }else{
                                        $query = mysqli_query($Conn, "SELECT*FROM help WHERE $whereClause  ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                    }
                                }else{
                                    if(empty($keyword)){
                                        $query = mysqli_query($Conn, "SELECT*FROM help  ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                    }else{
                                        $query = mysqli_query($Conn, "SELECT*FROM help WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                    }
                                }
                                while ($data = mysqli_fetch_array($query)) {
                                    $id_help= $data['id_help'];
                                    $author= $data['author'];
                                    $judul= $data['judul'];
                                    $kategori= $data['kategori'];
                                    $deskripsi= $data['deskripsi'];
                                    $datetime_creat= $data['datetime_creat'];
                                    $datetime_update= $data['datetime_update'];
                                    $status= $data['status'];
                                    //Format Tangga
                                    $strtotime1=strtotime($datetime_creat);
                                    $strtotime2=strtotime($datetime_update);
                                    $TanggalCreatFormat=date('d/m/Y H:i:s T',$strtotime1);
                                    $TanggalUpdateFormat=date('d/m/Y H:i:s T',$strtotime2);
                        ?>
                                <tr>
                                    <td align="center"><?php echo "$no"; ?></td>
                                    <td align="left">
                                        <?php 
                                            echo '<small class="credit">'; 
                                            echo '  '.$judul.'<br>';
                                            echo '  <code class="text-dark">Kategori : </code><code class="text-grayish">'.$kategori.'</code>';
                                            echo '</small>'; 
                                        ?>
                                    </td>
                                    <td align="left">
                                        <?php 
                                            echo '<small class="credit">'; 
                                            echo '  <code class="text-dark">Creat : </code><code class="text-grayish">'.$TanggalCreatFormat.'</code><br>';
                                            echo '  <code class="text-dark">Update : </code><code class="text-grayish">'.$TanggalUpdateFormat.'</code>';
                                            echo '</small>'; 
                                        ?>
                                    </td>
                                    <td align="left"><?php echo "$author"; ?></td>
                                    <td align="center">
                                        <?php 
                                            if($status=="Publish"){
                                                echo '<badge class="badge badge-success">'; 
                                                echo '  Publish';
                                                echo '</badge>'; 
                                            }else{
                                                echo '<badge class="badge badge-warning">'; 
                                                echo '  Draft';
                                                echo '</badge>'; 
                                            }
                                        ?>
                                    </td>
                                    <td align="center">
                                        <a class="btn-sm btn-outline-grayish" href="javascript:void(0);" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetail" data-id="<?php echo "$id_help"; ?>">
                                                    <i class="bi bi-info-circle"></i> Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalEdit" data-id="<?php echo "$id_help"; ?>">
                                                    <i class="bi bi-pencil-square"></i> Ubah/Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalHapus" data-id="<?php echo "$id_help"; ?>">
                                                    <i class="bi bi-x"></i> Hapus
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                    <?php 
                                $no++;
                            }
                        }
                    ?>    
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 text-center">
            <div class="btn-group shadow-0" role="group" aria-label="Basic example">
                <?php
                    //Mengatur Halaman
                    $JmlHalaman = ceil($jml_data/$batas); 
                    $JmlHalaman_real = ceil($jml_data/$batas); 
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
                <button class="btn btn-md btn-info" id="PrevPage" value="<?php echo $prev;?>">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="btn btn-md btn-outline-info">
                    <?php echo "$page/$JmlHalaman"; ?>
                </button>
                <button class="btn btn-md btn-info" id="NextPage" value="<?php echo $next;?>">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
<?php
    }
?>