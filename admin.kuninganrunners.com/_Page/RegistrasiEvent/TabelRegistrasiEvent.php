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
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi WHERE kategori='Pendaftaran'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi WHERE kategori='Pendaftaran' AND (raw_member like '%$keyword%' OR datetime like '%$keyword%' OR jumlah like '%$keyword%' OR status like '%$keyword%')"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi WHERE kategori='Pendaftaran'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT kode_transaksi FROM transaksi WHERE kategori='Pendaftaran' AND ($keyword_by like '%$keyword%')"));
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
                echo '          Tidak Ada Data Merchandise Yang Dapat Ditampilkan';
                echo '      </code>';
                echo '  </div>';
                echo '</div>';
            }else{
                $no = 1+$posisi;
                //KONDISI PENGATURAN MASING FILTER
                if(empty($keyword_by)){
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM transaksi WHERE kategori='Pendaftaran' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM transaksi WHERE kategori='Pendaftaran' AND (raw_member like '%$keyword%' OR datetime like '%$keyword%' OR jumlah like '%$keyword%' OR status like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }else{
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM transaksi WHERE kategori='Pendaftaran' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM transaksi WHERE kategori='Pendaftaran' AND ($keyword_by like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }
                while ($data = mysqli_fetch_array($query)) {
                    $kode_transaksi= $data['kode_transaksi'];
                    $id_member= $data['id_member'];
                    $kategori= $data['kategori'];
                    $datetime= $data['datetime'];
                    $raw_member= $data['raw_member'];
                    $jumlah= $data['jumlah'];
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
                        $LabelStatus='<badge class="badge badge-danger">Pending</badge>';
                    }
                    //Buka Event
                    $id_event=GetDetailData($Conn,'event_peserta','id_event_peserta',$kode_transaksi,'id_event');
                    $id_event_kategori=GetDetailData($Conn,'event_peserta','id_event_peserta',$kode_transaksi,'id_event_kategori');
                    $KategoriEvent=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'kategori');
                    $nama_event=GetDetailData($Conn,'event','id_event',$id_event,'nama_event');
                    $tanggal_mulai=GetDetailData($Conn,'event','id_event',$id_event,'tanggal_mulai');
                    //Sensor ID Member
                    $last_three = substr($id_member, -5);
                    $masked_id_member = '***' . $last_three;
                    //Sensor Email
                    list($username, $domain) = explode('@', $EmailMember);
                    $last_three = substr($username, -3);
                    $masked_email = '**' . $last_three . '@' . $domain;
                    //Sensor Nama Event
                    $words = explode(' ', $nama_event);
                    $limited_words = array_slice($words, 0, 2);
                    $masked_event = implode(' ', $limited_words);
                    //Sensor Kategori Event
                    $KategoriEventWord = explode(' ', $KategoriEvent);
                    $limited_words_kategori = array_slice($KategoriEventWord, 0, 2);
                    $masked_kategori_event = implode(' ', $limited_words_kategori);
                    //Format Tanggal Event
                    $strtotime2=strtotime($tanggal_mulai);
                    $tanggal_mulai_format=date('d M Y',$strtotime2);

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
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Event</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish">
                                                    <?php echo "$masked_event.."; ?>
                                                </code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Kategori</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish">
                                                    <?php echo "$masked_kategori_event.."; ?>
                                                </code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Pelaksanaan</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish">
                                                    <?php echo "$tanggal_mulai_format"; ?>
                                                </code>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Biaya Daftar</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo $jumlah_format; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Tgl.Transaksi</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo "$DatetimeFormat"; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <small>Status</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <?php echo "$LabelStatus"; ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
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