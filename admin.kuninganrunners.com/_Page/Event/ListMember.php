<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    $now=date('Y-m-d H:i');
    //Validasi Session Akses Masih ADa
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <code class="text-danger">';
        echo '          Sesi akses sudah berakhir, silahkan login ulang!';
        echo '      </code>';
        echo '  </div>';
        echo '</div>';
    }else{
        //keyword_member
        if(!empty($_POST['keyword_member'])){
            $keyword=$_POST['keyword_member'];
        }else{
            $keyword="";
        }
        $batas="10";
        $ShortBy="DESC";
        $OrderBy="nama";
        //Atur page_member
        if(!empty($_POST['page_member'])){
            $page=$_POST['page_member'];
            $posisi = ( $page - 1 ) * $batas;
        }else{
            $page="1";
            $posisi = 0;
        }
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_member FROM member"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_member FROM member WHERE nama like '%$keyword%' OR email like '%$keyword%'"));
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
        if(empty($jml_data)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center">';
            echo '      <code class="text-danger">';
            echo '          Tidak ada data member yang ditampilkan';
            echo '      </code>';
            echo '  </div>';
            echo '</div>';
        }else{
?>
            <script>
                //ketika klik next
                $('#NextPageMember').click(function() {
                    var NextPageMember=<?php echo $next;?>;
                    $('#page_member').val(NextPageMember);
                    var ProsesPencarianMember = $('#ProsesPencarianMember').serialize();
                    $.ajax({
                        type    : 'POST',
                        url     : '_Page/Event/ListMember.php',
                        data    : ProsesPencarianMember,
                        success: function(data) {
                            $('#FormListMember').html(data);
                        }
                    });
                });
                //Ketika klik Previous
                $('#PrevPageMember').click(function() {
                    var PrevPageMember =<?php echo $prev;?>;
                    $('#page_member').val(PrevPageMember);
                    var ProsesPencarianMember = $('#ProsesPencarianMember').serialize();
                    $.ajax({
                        type    : 'POST',
                        url     : '_Page/Event/ListMember.php',
                        data    : ProsesPencarianMember,
                        success: function(data) {
                            $('#FormListMember').html(data);
                        }
                    });
                });
            </script>
            <div class="row mb-3">
                <div class="col-md-12">
                    <select class="form-select" multiple="" aria-label="multiple select example"  name="id_member" id="id_member_list">
                        <?php
                            $no = 1+$posisi;
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM member ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM member WHERE nama like '%$keyword%' OR email like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $id_member= $data['id_member'];
                                $nama= $data['nama'];
                                $email= $data['email'];
                                echo '<option value="'.$id_member.'">'.$no.'. '.$nama.' ('.$email.')</option>';
                                $no++; 
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="btn-group shadow-0" role="group" aria-label="Basic example">
                        <small>
                            <a href="javascript:void(0);" id="PrevPageMember">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                            <a href="javascript:void(0);">
                                <?php echo "$page / $JmlHalaman"; ?>
                            </a>
                            <a href="javascript:void(0);" id="NextPageMember">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </small>
                    </div>
                </div>
            </div>
<?php 
        } 
    } 
?>