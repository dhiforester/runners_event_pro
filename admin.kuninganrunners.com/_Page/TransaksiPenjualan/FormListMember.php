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
        if(empty($_POST['keyword_member'])){
            $keyword_member="";
        }else{
            $keyword_member=$_POST['keyword_member'];
        }
        //Mencari Jumlah Data
        if(empty($keyword_member)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_member FROM member"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_member FROM member WHERE nama like '%$keyword_member%' OR email like '%$keyword_member%' OR kontak like '%$keyword_member%'"));
        }
        if(empty($jml_data)){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  Tidak Ada Data Member Yang Ditemukan';
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
                $('#NextPageMember').click(function() {
                    var page=$('#NextPageMember').val();
                    $('#put_page_member').val(page);
                    ShowListMember();
                });
                //Ketika klik Previous
                $('#PrevPageMember').click(function() {
                    var page = $('#PrevPageMember').val();
                    $('#put_page_member').val(page);
                    ShowListMember();
                });
                //Ketika  Salah Satu Data Dipilih
                $('.pilih_member').click(function(){
                    var id_member = $(this).data('id');
                    $('#ModalMember').modal('hide');
                    //Tempelkan id_member
                    $('#put_id_member').val(id_member);
                    // Reload Keranjang Dan Rincian Lainnya
                    ListKeranjang();
                    MenampilkanMember();
                    RingkasanTransaksi();
                    MenampilkanFormTujuanPengiriman();
                });
            </script>
            <div class="row mb-3">
                <div class="col-md-12 mb-3">
                    <ol class="list-group list-group-numbered">
                        <?php
                            $no=1+$posisi;
                            if(empty($keyword_member)){
                                $query = mysqli_query($Conn, "SELECT*FROM member ORDER BY nama ASC LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM member WHERE nama like '%$keyword_member%' OR email like '%$keyword_member%' OR kontak like '%$keyword_member%' ORDER BY nama ASC LIMIT $posisi, $batas");
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $id_member= $data['id_member'];
                                $nama= $data['nama'];
                                $email= $data['email'];
                                $kontak= $data['kontak'];
                                $status= $data['status'];
                                //Inisiasi Status Label
                                if($status=="Pending"){
                                    $LabelStatus='<badge class="badge badge-warning">Pending</badge>';
                                }else{
                                    $LabelStatus='<badge class="badge badge-success">Active</badge>';
                                }
                                echo '<li class="list-group-item d-flex justify-content-between align-items-start">';
                                echo '  <div class="ms-2 me-auto">';
                                echo '       <div class="fw-bold">';
                                echo '          <small>'.$nama.'</small>';
                                echo '       </div>';
                                echo '      <small><code class="text text-grayish">'.$email.'</code></small><br>';
                                echo '      <small><code class="text text-grayish">'.$kontak.'</code></small>';
                                echo '  </div>';
                                echo '  <a href="javascript:void(0);" class="text text-grayish pilih_member" data-id="'.$id_member.'">';
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
                        <button class="btn btn-sm btn-grayish" id="PrevPageMember" value="<?php echo $prev;?>">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-grayish">
                            <?php echo "$page of $JmlHalaman"; ?>
                        </button>
                        <button class="btn btn-sm btn-grayish" id="NextPageMember" value="<?php echo $next;?>">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
<?php
        }
    }
?>
