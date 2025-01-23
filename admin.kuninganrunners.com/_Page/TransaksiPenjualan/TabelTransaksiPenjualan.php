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
            $OrderBy="datetime";
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
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi WHERE kategori='Pembelian'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi WHERE kategori='Pembelian' AND (raw_member like '%$keyword%' OR datetime like '%$keyword%' OR jumlah like '%$keyword%' OR status like '%$keyword%')"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi WHERE kategori='Pembelian'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi WHERE kategori='Pembelian' AND ($keyword_by like '%$keyword%')"));
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
                $('#page').val(page);
                filterAndLoadTable();
            });
            //Ketika klik Previous
            $('#PrevPage').click(function() {
                var page = $('#PrevPage').val();
                $('#page').val(page);
                filterAndLoadTable();
            });
        </script>
        <?php
            if(empty($jml_data)){
                echo '<div class="card">';
                echo '  <div class="card-body text-center">';
                echo '      <code class="text-danger">';
                echo '          Tidak Ada Data Yang Ditampilkan';
                echo '      </code>';
                echo '  </div>';
                echo '</div>';
            }else{
                $no = 1+$posisi;
                //KONDISI PENGATURAN MASING FILTER
                if(empty($keyword_by)){
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM transaksi WHERE kategori='Pembelian' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM transaksi WHERE kategori='Pembelian' AND (raw_member like '%$keyword%' OR datetime like '%$keyword%' OR jumlah like '%$keyword%' OR status like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }else{
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM transaksi WHERE kategori='Pembelian' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM transaksi WHERE kategori='Pembelian' AND ($keyword_by like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }
                while ($data = mysqli_fetch_array($query)) {
                    $kode_transaksi= $data['kode_transaksi'];
                    $id_member= $data['id_member'];
                    $kategori= $data['kategori'];
                    $datetime= $data['datetime'];
                    $raw_member= $data['raw_member'];
                    $jumlah= $data['jumlah'];
                    $pengiriman= $data['pengiriman'];
                    $status= $data['status'];
                    //Hitung Varian
                    $raw_member_arry=json_decode($raw_member, true);
                    $NamaMember=$raw_member_arry['nama'];
                    $EmailMember=$raw_member_arry['email'];
                    $KontakMember=$raw_member_arry['kontak'];
                    //Format Tanggal
                    $strtotime1=strtotime($datetime);
                    $DatetimeFormat=date('d M Y H:i',$strtotime1);
                    //Jumlah Format
                    $jumlah_format='' . number_format($jumlah, 0, ',', '.');
                    if($status=="Lunas"){
                        $LabelStatus='<badge class="badge badge-success">Lunas</badge>';
                    }else{
                        if($status=="Menunggu"){
                            $LabelStatus='<code class="text-danger">Menunggu Validasi</code>';
                        }else{
                            $LabelStatus='<badge class="badge badge-warning">Pending</badge>';
                        }
                    }
                    //Sensor ID Member
                    $last_three = substr($id_member, -5);
                    $masked_id_member = '***' . $last_three;
                    //Sensor Email
                    list($username, $domain) = explode('@', $EmailMember);
                    $last_three = substr($username, -3);
                    $masked_email = '**' . $last_three . '@' . $domain;
                    //Sensor Kode Transaksi
                    $last_three_kode = substr($kode_transaksi, -5);
                    $masked_kode_transaksi = '***' . $last_three_kode;

                    //Buka Data Pengiriman
                    $status_pengiriman=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'status_pengiriman');
        ?>
                    <div class="card hover-shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <b>
                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetail" data-id="<?php echo "$kode_transaksi"; ?>">
                                            <?php echo "$no. $NamaMember"; ?>
                                        </a>
                                    </b>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small class="mobile-text">Kode Transaksi</small>
                                        </div>
                                        <div class="col col-md-8 ">
                                            <small class="mobile-text">
                                                <code class="text text-grayish">
                                                    <?php echo "$masked_kode_transaksi.."; ?>
                                                </code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small class="mobile-text">Tgl.Transaksi</small>
                                        </div>
                                        <div class="col col-md-8 ">
                                            <small class="mobile-text">
                                                <code class="text text-grayish">
                                                    <?php echo "$DatetimeFormat.."; ?>
                                                </code>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small class="mobile-text">Jumlah</small>
                                        </div>
                                        <div class="col col-md-8 ">
                                            <small class="mobile-text">
                                                <code class="text text-grayish"><?php echo $jumlah_format; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small class="mobile-text">Pembayaran</small>
                                        </div>
                                        <div class="col col-md-8 ">
                                            <small class="mobile-text">
                                                <?php echo "$LabelStatus"; ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small class="mobile-text">Metode </small>
                                        </div>
                                        <div class="col col-md-8 ">
                                            <small class="mobile-text">
                                                <code class="text text-grayish">
                                                    <?php echo "$pengiriman"; ?>
                                                </code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small class="mobile-text">Status Order</small>
                                        </div>
                                        <div class="col col-md-8 ">
                                            <small class="mobile-text">
                                                <?php
                                                    if($status_pengiriman=="Pending"){
                                                        echo '<code class="text-warning text-decoration-underline">Menunggu</code>';
                                                    }else{
                                                        if($status_pengiriman=="Batal"){
                                                            echo '<code class="text-danger text-decoration-underline">Batal</code>';
                                                        }else{
                                                            if($status_pengiriman=="Proses"){
                                                                echo '<code class="text-info text-decoration-underline">Dikirim</code>';
                                                            }else{
                                                                if($status_pengiriman=="Selesai"){
                                                                    echo '<code class="text-success text-decoration-underline">Selesai</code>';
                                                                }else{
                                                                    echo '<code class="text-grayish text-decoration-underline">None</code>';
                                                                }
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="filter">
                                <a class="icon text-secondary" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                    <li class="dropdown-header text-start">
                                        <h6>Option</h6>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetail" data-id="<?php echo "$kode_transaksi"; ?>">
                                            <i class="bi bi-info-circle"></i> Detail
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapus" data-id="<?php echo "$kode_transaksi"; ?>">
                                            <i class="bi bi-x"></i> Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
        <?php
                    $no++; 
                }
            }
        ?>
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="btn-group shadow-0" role="group" aria-label="Basic example">
                    <button class="btn btn-md btn-grayish" id="PrevPage" value="<?php echo $prev;?>">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="btn btn-md btn-outline-grayish">
                        <?php echo "$page of $JmlHalaman"; ?>
                    </button>
                    <button class="btn btn-md btn-grayish" id="NextPage" value="<?php echo $next;?>">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
<?php 
    } 
?>