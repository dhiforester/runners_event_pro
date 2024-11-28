<!-- Page Title -->
<div class="sub-page-title dark-background"></div>
<!-- End Page Title -->
<section id="service-details" class="service-details section">
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12 text-center">
                <h4>
                    <i class="bi bi-info-circle"></i> Detail Pendaftaran
                </h4>
                <small>Uraian dan informasi lengkap mengenai status pendaftaran event</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                    //Menampilkan Notifikasi Proses
                    if(!empty($_SESSION['notifikasi_proses'])){
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                        echo '  '.$_SESSION['notifikasi_proses'].'';
                        echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '</div><br>';
                        //Hapus Session Notifikasi Proses
                        unset($_SESSION['notifikasi_proses']);
                    }
                ?>
            </div>
        </div>
        <?php
            //Apabila ID Tidak Ada
            if(empty($_GET['id'])){
                include "_Page/Error/no_id.php";
            }else{
                //Buat Variabel
                $id_event_peserta=$_GET['id'];
                //Bersihkan id
                $id_event_peserta=validateAndSanitizeInput($_GET['id']);
                if(empty($_SESSION['id_member_login'])&&empty($_SESSION['id_member_login'])){
                    include "_Page/Error/no_access.php";
                    $_SESSION['url_back']="index.php?Page=DetailPendaftaranEvent&id=$id_event_peserta";
                }else{
                    //Apabila Session Sudah Expired
                    if($_SESSION['login_expired']<date('Y-m-d H:i:s')){
                        include "_Page/Error/no_access.php";
                        $_SESSION['url_back']="index.php?Page=DetailPendaftaranEvent&id=$id_event_peserta";
                    }else{
                        //Perpanjang Session Akses Member
                        $email_member=$_SESSION['email'];
                        $id_member_login=$_SESSION['id_member_login'];
                        $UpdateSessionMemberLogin=UpdateSessionMemberLogin($url_server,$xtoken,$email_member,$id_member_login);
                        //Bersihkan Variabel
                        $id_event_peserta=validateAndSanitizeInput($id_event_peserta);
                        //Buka Detail Event Peserta
                        $GetDetailEventPeserta=DetailEventPeserta($url_server,$xtoken,$id_event_peserta);
                        $response=json_decode($GetDetailEventPeserta,true);
                        //Apabila Terjadi Kesalahan Pada Saat Memperpanjang Session
                        if($response['response']['code']!==200){
                            echo '<div class="row">';
                            echo '  <div class="col-md-4"></div>';
                            echo '      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">';
                            echo '                  <div class="service-box">';
                            echo '                      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                            echo '                          <small>';
                            echo '                              '.$response['response']['message'].'';
                            echo '                          </small>';
                            echo '                      </div>';
                            echo '                  </div>';
                            echo '      </div>';
                            echo '  <div class="col-md-4"></div>';
                            echo '</div>';
                        }else{
                            $metadata=$response['metadata'];
                            //Buka Informasi Pendaftaran Event
                            $id_event=$metadata['id_event'];
                            $id_event_kategori=$metadata['id_event_kategori'];
                            $nama=$metadata['nama'];
                            $email=$metadata['email'];
                            $biaya_pendaftaran=$metadata['biaya_pendaftaran'];
                            $datetime=$metadata['datetime'];
                            $status=$metadata['status'];
                            $kategori=$metadata['kategori'];
                            $event=$metadata['event'];
                            //Buka Detail Kategori
                            $kategori_nama=$kategori['kategori'];
                            $deskripsi=$kategori['deskripsi'];
                            $strtotime1=strtotime($datetime);
                            $tangaal_daftar_format=date('d/m/Y',$strtotime1);
                            $jam_daftar_format=date('H:i T',$strtotime1);
                            //Buka Informasi Event
                            $nama_event=$event['nama_event'];
                            //Format Biaya Pendaftaran
                            $biaya_pendaftaran_format=formatRupiah($biaya_pendaftaran);
                            //Format Email
                            // Pisahkan bagian sebelum dan sesudah @
                            list($username, $domain) = explode('@', $email);
                            // Ambil 3 digit terakhir dari username
                            $last_three_chars = substr($username, -3);
                            // Gabungkan tanda bintang, 3 digit terakhir, dan domain
                            $formatted_email = '***' . $last_three_chars . '@' . $domain;
        ?>
                        <div class="container">
                            <div class="row">
                                <div class="col-xxl-3 col-lg-3 col-md-3 col-sm-6 col-6">
                                    <a href="index.php?Page=Profil">
                                        <div class="box_custome">
                                            <div class="services-list text-center">
                                                <i class="bi bi-person-circle"></i> <small class="mobile-text">Profil</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xxl-3 col-lg-3 col-md-3 col-sm-6 col-6">
                                    <a href="index.php?Page=DetailEvent&id=<?php echo "$id_event"; ?>">
                                        <div class="box_custome">
                                            <div class="services-list text-center">
                                                <i class="bi bi-info-circle"></i> <small class="mobile-text">Detail Event</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xxl-3 col-lg-3 col-md-3 col-sm-6 col-6">
                                    <a href="index.php?Page=RiwayatEvent">
                                        <div class="box_custome">
                                            <div class="services-list text-center">
                                                <i class="bi bi-clock-history"></i> <small class="mobile-text">Riwayat Event</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xxl-3 col-lg-3 col-md-3 col-sm-6 col-6">
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalPembatalanEvent">
                                        <div class="box_custome">
                                            <div class="services-list text-center">
                                                <i class="bi bi-x-circle"></i><small class="mobile-text"> Batalkan</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box_custome">
                                        <div class="box_custome_content">
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <b>Informasi Umum Pendaftaran</b>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col col-md-4">
                                                    <small class="credit mobile-text">ID.Reg</small>
                                                </div>
                                                <div class="col col-md-8">
                                                    <small class="credit mobile-text text-grayish">
                                                        <?php 
                                                            // Ambil 5 digit terakhir
                                                            $last_five_digits = substr($id_event_peserta, -5);
                                                            // Gabungkan dengan tiga tanda bintang
                                                            $formatted_id = '***' . $last_five_digits;
                                                            echo "$formatted_id"; 
                                                        ?>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col col col-md-4">
                                                    <small class="credit mobile-text">Event</small>
                                                </div>
                                                <div class="col col col-md-8">
                                                    <small class="credit mobile-text text-grayish">
                                                        <?php echo "$nama_event"; ?>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col col-md-4">
                                                    <small class="credit mobile-text">Kategori</small>
                                                </div>
                                                <div class="col col-md-8">
                                                    <small class="credit mobile-text text-grayish">
                                                        <?php echo "$kategori_nama"; ?>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col col-md-4">
                                                    <small class="credit mobile-text">Peserta</small>
                                                </div>
                                                <div class="col col-md-8">
                                                    <small class="credit mobile-text text-grayish">
                                                        <?php echo "$nama"; ?>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col col-md-4">
                                                    <small class="credit mobile-text">Email</small>
                                                </div>
                                                <div class="col col-md-8">
                                                    <small class="credit mobile-text text-grayish">
                                                        <?php echo "$formatted_email"; ?>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col col-md-4">
                                                    <small class="credit mobile-text">Biaya Daftar</small>
                                                </div>
                                                <div class="col col-md-8">
                                                    <small class="credit mobile-text text-dark text-decoration-underline">
                                                        <?php echo "$biaya_pendaftaran_format"; ?>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col col-md-4">
                                                    <small class="credit mobile-text">Status</small>
                                                </div>
                                                <div class="col col-md-8">
                                                    <small class="credit mobile-text">
                                                        <?php 
                                                            if($status=="Pending"){
                                                                echo '<span class="text-danger">Pending</span>';
                                                            }else{
                                                                echo '<span class="text-success">'.$status.'</span>';
                                                            }
                                                        ?>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col col-md-4">
                                                    <small class="credit mobile-text">Tanggal Daftar</small>
                                                </div>
                                                <div class="col col-md-8">
                                                    <small class="credit mobile-text text-grayish">
                                                        <?php echo "$tangaal_daftar_format"; ?>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col col-md-4">
                                                    <small class="credit mobile-text">Jam Daftar</small>
                                                </div>
                                                <div class="col col-md-8">
                                                    <small class="credit mobile-text text-grayish">
                                                        <?php echo "$jam_daftar_format"; ?>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-3 mt-4">
                                                <div class="col-md-12">
                                                    <b>Assesment Pendaftaran</b><br>
                                                    <small>
                                                        Assesment pendaftaran adalah informasi tambahan yang harus anda isi untuk membantu admin melakukan peninjauan terhadap pendaftaran anda.
                                                    </small>
                                                </div>
                                            </div>
                                            <?php
                                                //Membuka Assesment Event
                                                $assesment=ListAssesment($url_server,$xtoken,$id_event);
                                                $assesment_arry=json_decode($assesment, true);
                                                if($assesment_arry['response']['code']!==200){
                                                    echo '<div class="row mb-3">';
                                                    echo '  <div class="col-md-12">';
                                                    echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                                    echo '          <small>';
                                                    echo '              '.$assesment_arry['response']['message'].'';
                                                    echo '          </small>';
                                                    echo '      </div>';
                                                    echo '  </div>';
                                                    echo '</div>';
                                                }else{
                                                    $metadata_assesment=$assesment_arry['metadata'];
                                                    $assesment_count=count($metadata_assesment);
                                                    //Jika Tidak Ada Assesment Untuk Event Ini
                                                    if(empty($assesment_count)){
                                                        echo '<div class="row mb-3">';
                                                        echo '  <div class="col-md-12">';
                                                        echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                                        echo '          <small>';
                                                        echo '              Tidak Ada Assesment Yang Perlu Diisi Untuk Event Ini.';
                                                        echo '          </small>';
                                                        echo '      </div>';
                                                        echo '  </div>';
                                                        echo '</div>';
                                                    }else{
                                                        echo '<div class="row mb-3">';
                                                        echo '  <div class="col-md-12">';
                                                        echo '      <div class="accordion" id="accordionExample">';
                                                        $no=1;
                                                        foreach($metadata_assesment as $list_assesement){
                                                            $id_event_assesment_form=$list_assesement['id_event_assesment_form'];
                                                            $form_name=$list_assesement['form_name'];
                                                            $form_type=$list_assesement['form_type'];
                                                            $mandatori=$list_assesement['mandatori'];
                                                            $komentar=$list_assesement['komentar'];
                                                            //Buka Detail Assesment
                                                            $DetailAssesment=DetailAssesment($url_server,$xtoken,$id_event_assesment_form,$id_event_peserta);
                                                            $DetailAssesmentArry=json_decode($DetailAssesment, true);
                                                            if($DetailAssesmentArry['response']['code']!==200){
                                                                $value_fix="";
                                                                $status='<i class="bi bi-x-circle text-danger"></i>';
                                                                $assesment_value='<code class="text-danger">None</code>';
                                                            }else{
                                                                //Apabila Tidak Ada Metadata
                                                                if(empty($DetailAssesmentArry['metadata']['assesment_value'])){
                                                                    $value_fix="";
                                                                    $status='<i class="bi bi-question-circle text-warning"></i>';
                                                                    $assesment_value='<code class="text-danger">None</code>';
                                                                }else{
                                                                    $status_assesment=$DetailAssesmentArry['metadata']['status_assesment']['status_assesment'];
                                                                    if($status_assesment=="Pending"){
                                                                        $status='<i class="bi bi-check-circle text-info"></i>';
                                                                    }else{
                                                                        if($status_assesment=="Refisi"){
                                                                            $status='<i class="bi bi-exclamation-circle text-danger"></i>';
                                                                        }else{
                                                                            $status='<i class="bi bi-check-circle text-primary"></i>';
                                                                        }
                                                                    }
                                                                    //Apabila Belum Terisi
                                                                    if(empty($DetailAssesmentArry['metadata']['assesment_value'])){
                                                                        $assesment_value='<code class="text-danger">None</code>';
                                                                        $value_fix="";
                                                                    }else{
                                                                        $value_fix=$DetailAssesmentArry['metadata']['assesment_value'];
                                                                        if($form_type=="checkbox"){
                                                                            $assesment_value = implode(", ", $DetailAssesmentArry['metadata']['assesment_value']);
                                                                            $assesment_value='<code class="text-dark">'.$assesment_value.'</code>';
                                                                        }else{
                                                                            if($form_type=="file_foto"||$form_type=="file_pdf"){
                                                                                $assesment_value=$DetailAssesmentArry['metadata']['assesment_value'];
                                                                                $assesment_value='<a href="'.$assesment_value.'"><code class="text-primary"><i class="bi bi-paperclip"></i> Lihat Lampiran</code></a>';
                                                                            }else{
                                                                                $assesment_value=$DetailAssesmentArry['metadata']['assesment_value'];
                                                                                $assesment_value='<code class="text-dark">'.$assesment_value.'</code>';
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                            ?>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="heading<?php echo $no; ?>">
                                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $no; ?>" aria-expanded="false" aria-controls="collapse<?php echo $no; ?>">
                                                                        <?php echo "$status &nbsp; &nbsp; <small>$form_name</small>"; ?>
                                                                    </button>
                                                                </h2>
                                                                <div id="collapse<?php echo $no; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $no; ?>" data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">
                                                                        <div class="row mb-3">
                                                                            <div class="col col-md-4">
                                                                                <small>Status</small>
                                                                            </div>
                                                                            <div class="col col-md-8">
                                                                                <small>
                                                                                    <?php
                                                                                        //Apabila Belum Terisi
                                                                                        if(empty($DetailAssesmentArry['metadata']['assesment_value'])){
                                                                                            echo '<code class="text-warning">Belum Diisi</code>';
                                                                                        }else{
                                                                                            if($status_assesment=="Pending"){
                                                                                                echo '<code class="text-info">Dalam peninjauan</code>';
                                                                                            }else{
                                                                                                if($status_assesment=="Refisi"){
                                                                                                    echo '<code class="text-danger">Perlu Tindakan</code>';
                                                                                                }else{
                                                                                                    echo '<code class="text-primary">Selesai</code>';
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                </small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <div class="col col-md-4">
                                                                                <small>Jawaban</small>
                                                                            </div>
                                                                            <div class="col col-md-8">
                                                                                <small>
                                                                                    <?php echo  $assesment_value; ?>
                                                                                </small>
                                                                            </div>
                                                                        </div>
                                                                        <?php 
                                                                            //Kondisi Jika Ada Komentar
                                                                            if(!empty($DetailAssesmentArry['metadata']['status_assesment']['komentar'])){
                                                                                $komentar=$DetailAssesmentArry['metadata']['status_assesment']['komentar'];
                                                                                echo '<div class="row mb-3">';
                                                                                echo '  <div class="col-md-12">';
                                                                                echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                                                                echo '          <small>';
                                                                                echo '              Komentar Perbaikan :<br>';
                                                                                echo '              <code class="text-dark"><i>"'.$komentar.'"</i></code>';
                                                                                echo '          </small>';
                                                                                echo '      </div>';
                                                                                echo '  </div>';
                                                                                echo '</div>';
                                                                            }
                                                                        ?>
                                                                        <?php 
                                                                            //Apabila Status Assesment Belum Valid
                                                                            if(empty($DetailAssesmentArry['metadata']['status_assesment']['status_assesment'])||$DetailAssesmentArry['metadata']['status_assesment']['status_assesment']!=="Valid"){
                                                                        ?>
                                                                            <div class="row mb-3">
                                                                                <div class="col col-md-4">
                                                                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-block w-100" data-bs-toggle="modal" data-bs-target="#ModalAssesment<?php echo "$id_event_assesment_form"; ?>">
                                                                                        <i class="bi bi-pencil"></i> Isi Assesment
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal fade" id="ModalAssesment<?php echo $id_event_assesment_form; ?>" tabindex="-1">
                                                                <div class="modal-dialog modal-md">
                                                                    <div class="modal-content">
                                                                        <form action="javascript:void(0);" class="ProsesAssesment">
                                                                            <input type="hidden" name="id_event_assesment_form" value="<?php echo $id_event_assesment_form; ?>">
                                                                            <input type="hidden" name="id_event_peserta" value="<?php echo $id_event_peserta; ?>">
                                                                            <input type="hidden" name="id_event" value="<?php echo $id_event; ?>">
                                                                            <input type="hidden" name="form_type" value="<?php echo $form_type; ?>">
                                                                            <div class="modal-header border-0">
                                                                                <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Form Assesment</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row mb-3">
                                                                                    <div class="col-md-12">
                                                                                        <label for="<?php echo $id_event_assesment_form; ?>"><?php echo "$form_name"; ?></label>
                                                                                        <?php
                                                                                            if($form_type=="text"){
                                                                                                if($DetailAssesmentArry['response']['code']==200){
                                                                                                    echo '<input type="text" name="form_value" id="'.$id_event_assesment_form.'" class="form-control" value="'.$value_fix.'">';
                                                                                                }else{
                                                                                                    echo '<input type="text" name="form_value" id="'.$id_event_assesment_form.'" class="form-control" value="">';
                                                                                                }
                                                                                            }else{
                                                                                                if($form_type=="file_foto"||$form_type=="file_pdf"){
                                                                                                    echo '<input type="file" name="form_value" id="'.$id_event_assesment_form.'" class="form-control">';
                                                                                                }else{
                                                                                                    if($form_type=="textarea"){
                                                                                                        if($DetailAssesmentArry['response']['code']==200){
                                                                                                            echo '<textarea class="form-control" name="form_value" id="'.$id_event_assesment_form.'">'.$value_fix.'</textarea>';
                                                                                                        }else{
                                                                                                            echo '<textarea class="form-control" name="form_value" id="'.$id_event_assesment_form.'">'.$value_fix.'</textarea>';
                                                                                                        }
                                                                                                            
                                                                                                    }else{
                                                                                                        if($form_type=="select_option"){
                                                                                                            $alternatif=$list_assesement['alternatif'];
                                                                                                            echo '<select class="form-control" name="form_value" id="'.$id_event_assesment_form.'">';
                                                                                                            echo '  <option value="">Pilih</option>';
                                                                                                            foreach($alternatif as $alternatif_list){
                                                                                                                $alt_value=$alternatif_list['value'];
                                                                                                                $alt_display=$alternatif_list['display'];
                                                                                                                if($DetailAssesmentArry['response']['code']==200){
                                                                                                                    if($value_fix==$alt_value){
                                                                                                                        echo '  <option selected value="'.$alt_value.'">'.$alt_display.'</option>';
                                                                                                                    }else{
                                                                                                                        echo '  <option value="'.$alt_value.'">'.$alt_display.'</option>';
                                                                                                                    }
                                                                                                                }else{
                                                                                                                    echo '  <option value="'.$alt_value.'">'.$alt_display.'</option>';
                                                                                                                }
                                                                                                            }
                                                                                                            echo '</select>';
                                                                                                        }else{
                                                                                                            if($form_type=="radio"){
                                                                                                                $alternatif=$list_assesement['alternatif'];
                                                                                                                $no_alt=1;
                                                                                                                foreach($alternatif as $alternatif_list){
                                                                                                                    $alt_value=$alternatif_list['value'];
                                                                                                                    $alt_display=$alternatif_list['display'];
                                                                                                                    if($DetailAssesmentArry['response']['code']==200){
                                                                                                                        if($value_fix==$alt_value){
                                                                                                                            echo '<div class="form-check">';
                                                                                                                            echo '  <input class="form-check-input" checked type="radio" name="form_value" id="'.$id_event_assesment_form.'_'.$no_alt.'" value="'.$alternatif_list['value'].'">';
                                                                                                                            echo '  <label class="form-check-label" for="'.$id_event_assesment_form.'_'.$no_alt.'"><small>'.$alternatif_list['display'].'</small></label>';
                                                                                                                            echo '</div>';
                                                                                                                        }else{
                                                                                                                            echo '<div class="form-check">';
                                                                                                                            echo '  <input class="form-check-input" type="radio" name="form_value" id="'.$id_event_assesment_form.'_'.$no_alt.'" value="'.$alternatif_list['value'].'">';
                                                                                                                            echo '  <label class="form-check-label" for="'.$id_event_assesment_form.'_'.$no_alt.'"><small>'.$alternatif_list['display'].'</small></label>';
                                                                                                                            echo '</div>';
                                                                                                                        }
                                                                                                                    }else{
                                                                                                                        echo '<div class="form-check">';
                                                                                                                        echo '  <input class="form-check-input" type="radio" name="form_value" id="'.$id_event_assesment_form.'_'.$no_alt.'" value="'.$alternatif_list['value'].'">';
                                                                                                                        echo '  <label class="form-check-label" for="'.$id_event_assesment_form.'_'.$no_alt.'"><small>'.$alternatif_list['display'].'</small></label>';
                                                                                                                        echo '</div>';
                                                                                                                    }
                                                                                                                    $no_alt++;
                                                                                                                }
                                                                                                            }else{
                                                                                                                if($form_type=="checkbox"){
                                                                                                                    $alternatif = $list_assesement['alternatif'];
                                                                                                                    $no_alt = 1;

                                                                                                                    foreach($alternatif as $alternatif_list){
                                                                                                                        $alt_value = $alternatif_list['value'];
                                                                                                                        $alt_display = $alternatif_list['display'];

                                                                                                                        if ($DetailAssesmentArry['response']['code'] == 200) {
                                                                                                                            // Pastikan 'assesment_value' terdefinisi dan adalah array
                                                                                                                            if (isset($DetailAssesmentArry['metadata']['assesment_value']) && is_array($DetailAssesmentArry['metadata']['assesment_value'])) {
                                                                                                                                if (in_array($alt_value, $DetailAssesmentArry['metadata']['assesment_value'])) {
                                                                                                                                    echo '<div class="form-check">';
                                                                                                                                    echo '  <input class="form-check-input" checked type="checkbox" name="form_value[]" id="'.$id_event_assesment_form.'_'.$no_alt.'" value="'.$alternatif_list['value'].'">';
                                                                                                                                    echo '  <label class="form-check-label" for="'.$id_event_assesment_form.'_'.$no_alt.'"><small>'.$alternatif_list['display'].'</small></label>';
                                                                                                                                    echo '</div>';
                                                                                                                                } else {
                                                                                                                                    echo '<div class="form-check">';
                                                                                                                                    echo '  <input class="form-check-input" type="checkbox" name="form_value[]" id="'.$id_event_assesment_form.'_'.$no_alt.'" value="'.$alternatif_list['value'].'">';
                                                                                                                                    echo '  <label class="form-check-label" for="'.$id_event_assesment_form.'_'.$no_alt.'"><small>'.$alternatif_list['display'].'</small></label>';
                                                                                                                                    echo '</div>';
                                                                                                                                }
                                                                                                                            } else {
                                                                                                                                // Jika 'assesment_value' tidak ada atau bukan array, tampilkan checkbox tidak tercentang
                                                                                                                                echo '<div class="form-check">';
                                                                                                                                echo '  <input class="form-check-input" type="checkbox" name="form_value[]" id="'.$id_event_assesment_form.'_'.$no_alt.'" value="'.$alternatif_list['value'].'">';
                                                                                                                                echo '  <label class="form-check-label" for="'.$id_event_assesment_form.'_'.$no_alt.'"><small>'.$alternatif_list['display'].'</small></label>';
                                                                                                                                echo '</div>';
                                                                                                                            }
                                                                                                                        } else {
                                                                                                                            echo '<div class="form-check">';
                                                                                                                            echo '  <input class="form-check-input" type="checkbox" name="form_value[]" id="'.$id_event_assesment_form.'_'.$no_alt.'" value="'.$alternatif_list['value'].'">';
                                                                                                                            echo '  <label class="form-check-label" for="'.$id_event_assesment_form.'_'.$no_alt.'"><small>'.$alternatif_list['display'].'</small></label>';
                                                                                                                            echo '</div>';
                                                                                                                        }

                                                                                                                        $no_alt++;
                                                                                                                    }

                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                        <small>
                                                                                            <code class="text-dark"><?php echo $komentar; ?></code>
                                                                                        </small>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-md-12" id="NotifikasiAssesment<?php echo $id_event_assesment_form; ?>">
                                                                                        <!-- Notifikasi Pendaftaran Akan Muncul Disini -->
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer border-0">
                                                                                <button type="submit" class="css-button-fully-rounded--green" id="ButtonAssesment<?php echo $id_event_assesment_form; ?>">
                                                                                    <i class="bi bi-save"></i> Simpan
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                            <?php
                                                            $no++;
                                                        }
                                                        echo '';
                                                        echo '      </div>';
                                                        echo '  </div>';
                                                        echo '</div>';
                                                    }
                                                }
                                            ?>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <b>Transaksi & Pembayaran</b><br>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <?php
                                                        //Cek Data Transaksi Peserta
                                                        $GetDetailTransaksi=DetailTransaksiPeserta($url_server,$xtoken,$email_member,$id_member_login,$id_event_peserta);
                                                        $detail_transaksi_arry=json_decode($GetDetailTransaksi,true);
                                                        if($detail_transaksi_arry['response']['code']!==200){
                                                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                                            echo '  <small>';
                                                            echo '      '.$detail_transaksi_arry['response']['message'].'';
                                                            echo '  </small>';
                                                            echo '</div>';
                                                        }else{
                                                            $metadata_transaksi=$detail_transaksi_arry['metadata'];
                                                            $kode_transaksi=$metadata_transaksi['kode_transaksi'];
                                                            $raw_member=$metadata_transaksi['raw_member'];
                                                            $kategori=$metadata_transaksi['kategori'];
                                                            $datetime=$metadata_transaksi['datetime'];
                                                            $subtotal=$metadata_transaksi['subtotal'];
                                                            $ongkir=$metadata_transaksi['ongkir'];
                                                            $ppn_pph=$metadata_transaksi['ppn_pph'];
                                                            $biaya_layanan=$metadata_transaksi['biaya_layanan'];
                                                            $biaya_lainnya=$metadata_transaksi['biaya_lainnya'];
                                                            $potongan_lainnya=$metadata_transaksi['potongan_lainnya'];
                                                            $total=$metadata_transaksi['jumlah'];
                                                            $status_pembayaran=$metadata_transaksi['status'];
                                                            //Format Nominal
                                                            $subtotal_format="Rp " . number_format($subtotal, 0, ',', '.');
                                                            $total_format="Rp " . number_format($total, 0, ',', '.');
                                                            //Routing Label Status
                                                            if($status_pembayaran=="Lunas"){
                                                                $LabelStatusPembayaran='<code class="text-success"><i class="bi bi-check-circle"></i> Lunas</code>';
                                                            }else{
                                                                $LabelStatusPembayaran='<code class="text-danger"><i class="bi bi-clock-history"></i> Pending</code>';
                                                            }
                                                            $strtotime_transaksi=strtotime($datetime);
                                                            $tanggal_transaksi=date('d/m/Y',$strtotime_transaksi);
                                                            $jam_transaksi=date('H:i T',$strtotime_transaksi);
                                                            //Masking Kode Transaksi
                                                            $last_five_digits = substr($kode_transaksi, -5);
                                                            $kode_transaksi_format = '***' . $last_five_digits;
                                                            
                                                            //Tampilkan Data
                                                            echo '<div class="row mb-2">';
                                                            echo '  <div class="col col-md-4"><small class="mobile-text">ID Pembayaran</small></div>';
                                                            echo '  <div class="col col-md-8 text-end">';
                                                            echo '      <small class="mobile-text">';
                                                            echo '          <code class="text-grayish">';
                                                            echo '              '.$kode_transaksi_format.'';
                                                            echo '          </code>';
                                                            echo '      </small>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            echo '<div class="row mb-2">';
                                                            echo '  <div class="col col-md-4"><small class="mobile-text">Tanggal</small></div>';
                                                            echo '  <div class="col col-md-8 text-end">';
                                                            echo '      <small class="mobile-text">';
                                                            echo '          <code class="text-grayish">';
                                                            echo '              '.$tanggal_transaksi.'';
                                                            echo '          </code>';
                                                            echo '      </small>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            echo '<div class="row mb-2">';
                                                            echo '  <div class="col col-md-4"><small class="mobile-text">Jam</small></div>';
                                                            echo '  <div class="col col-md-8 text-end">';
                                                            echo '      <small class="mobile-text">';
                                                            echo '          <code class="text-grayish">';
                                                            echo '              '.$jam_transaksi.'';
                                                            echo '          </code>';
                                                            echo '      </small>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            echo '<div class="row mb-2">';
                                                            echo '  <div class="col col-md-4"><small class="mobile-text">Status</small></div>';
                                                            echo '  <div class="col col-md-8 text-end">';
                                                            echo '      <small class="mobile-text">';
                                                            echo '          <code class="text-grayish">';
                                                            echo '              '.$LabelStatusPembayaran.'';
                                                            echo '          </code>';
                                                            echo '      </small>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            echo '<div class="row mb-2">';
                                                            echo '  <div class="col col-md-4"><small class="mobile-text">Subtotal</small></div>';
                                                            echo '  <div class="col col-md-8 text-end">';
                                                            echo '      <small class="mobile-text">';
                                                            echo '          <code class="text-grayish">';
                                                            echo '              '.$subtotal_format.'';
                                                            echo '          </code>';
                                                            echo '      </small>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            //Apabila Ada PPN
                                                            if(!empty($ppn_pph)){
                                                                $ppn_persen=($ppn_pph/$subtotal)*100;
                                                                $ppn_persen=round($ppn_persen);
                                                                $ppn_pph_format="Rp " . number_format($ppn_pph, 0, ',', '.');
                                                                echo '<div class="row mb-2">';
                                                                echo '  <div class="col col-md-4"><small class="mobile-text">PPN ('.$ppn_persen.' %)</small></div>';
                                                                echo '  <div class="col col-md-8 text-end">';
                                                                echo '      <small class="mobile-text">';
                                                                echo '          <code class="text-grayish">';
                                                                echo '              '.$ppn_pph_format.'';
                                                                echo '          </code>';
                                                                echo '      </small>';
                                                                echo '  </div>';
                                                                echo '</div>';
                                                            }
                                                            //Apabila Ada Biaya Layanan
                                                            if(!empty($biaya_layanan)){
                                                                $biaya_layanan_format="Rp " . number_format($biaya_layanan, 0, ',', '.');
                                                                echo '<div class="row mb-2">';
                                                                echo '  <div class="col col-md-4"><small class="mobile-text">Biaya Layanan</small></div>';
                                                                echo '  <div class="col col-md-8 text-end">';
                                                                echo '      <small class="mobile-text">';
                                                                echo '          <code class="text-grayish">';
                                                                echo '              '.$biaya_layanan_format.'';
                                                                echo '          </code>';
                                                                echo '      </small>';
                                                                echo '  </div>';
                                                                echo '</div>';
                                                            }
                                                            //Apabila Ada Biaya Lain-lain
                                                            if(!empty($biaya_lainnya)){
                                                                if(!empty(count($biaya_lainnya))){
                                                                    echo '<div class="row mb-2 mt-3">';
                                                                    echo '  <div class="col col-md-12"><small class="mobile-text">Biaya Lain-lain</small></div>';
                                                                    echo '</div>';
                                                                    foreach ($biaya_lainnya as $biaya_lainnya_list) {
                                                                        $nama_biaya=$biaya_lainnya_list['nama_biaya'];
                                                                        $nominal_biaya=$biaya_lainnya_list['nominal_biaya'];
                                                                        $nominal_biaya_format="Rp " . number_format($nominal_biaya, 0, ',', '.');
                                                                        echo '<div class="row mb-2">';
                                                                        echo '  <div class="col col-md-4"><small class="mobile-text text-grayish">- '.$nama_biaya.'</small></div>';
                                                                        echo '  <div class="col col-md-8 text-end">';
                                                                        echo '      <small class="mobile-text">';
                                                                        echo '          <code class="text-grayish">';
                                                                        echo '              '.$nominal_biaya_format.'';
                                                                        echo '          </code>';
                                                                        echo '      </small>';
                                                                        echo '  </div>';
                                                                        echo '</div>';
                                                                    }
                                                                }
                                                            }
                                                            //Apabila Ada Potongan Lain-lain
                                                            if(!empty($potongan_lainnya)){
                                                                if(!empty(count($potongan_lainnya))){
                                                                    echo '<div class="row mb-2 mt-3">';
                                                                    echo '  <div class="col col-md-12"><small class="mobile-text">Biaya Lain-lain</small></div>';
                                                                    echo '</div>';
                                                                    foreach ($potongan_lainnya as $potongan_lainnya_list) {
                                                                        $nama_potongan=$potongan_lainnya_list['nama_potongan'];
                                                                        $nominal_potongan=$potongan_lainnya_list['nominal_potongan'];
                                                                        $nominal_potongan_format="- Rp " . number_format($nominal_potongan, 0, ',', '.');
                                                                        echo '<div class="row mb-2">';
                                                                        echo '  <div class="col col-md-4"><small class="mobile-text text-grayish">- '.$nama_potongan.'</small></div>';
                                                                        echo '  <div class="col col-md-8 text-end">';
                                                                        echo '      <small class="mobile-text">';
                                                                        echo '          <code class="text-danger">';
                                                                        echo '              '.$nominal_potongan_format.'';
                                                                        echo '          </code>';
                                                                        echo '      </small>';
                                                                        echo '  </div>';
                                                                        echo '</div>';
                                                                    }
                                                                }
                                                            }
                                                            echo '<div class="row mb-2 border-dashed-bottom border-dashed-top">';
                                                            echo '  <div class="col col-md-4"><small class="mobile-text">Total</small></div>';
                                                            echo '  <div class="col col-md-8 text-end">';
                                                            echo '      <small class="mobile-text">';
                                                            echo '          <code class="text-dark text-decoration-underline">';
                                                            echo '              '.$total_format.'';
                                                            echo '          </code>';
                                                            echo '      </small>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            //Apabila Status Masih Pending
                                                            if($status_pembayaran!=="Lunas"){
                                                                //Tampilkan Petunjuk Pembayaran
                                                                echo '<div class="row mb-3 mt-3">';
                                                                echo '  <div class="col-md-12">';
                                                                echo '      <div class="alert alert-warning alert-dismissible fade show" role="alert">';
                                                                echo '          <small class="mobile-text">';
                                                                echo '              Berikut ini langkah-langkah pembayaran yang perlu anda ketahui :';
                                                                echo '              <ol>';
                                                                echo '                  <li>Klik pada tombol <i>Bayar Sekarang</i> pada bagian akhir halaman.</li>';
                                                                echo '                  <li>Sistem akan menampilkan pesan <i>Popup</i> yang berisi kode transaksi dan uraian pembayaran.</li>';
                                                                echo '                  <li>Klik pada tombol <i>Lanjutkan Pembayaran</i> kemudian pilih metode pembayaran yang anda inginkan.</li>';
                                                                echo '                  <li>Ikuti petunjuk pembayaran sesuai metode yang anda pilih.</li>';
                                                                echo '                  <li>Setelah anda menyelesaikan pembayaran, silahkan refresh halaman ini untuk mengetahui pembaharuan status pendaftaran anda.</li>';
                                                                echo '                  <li>Apabila terdapat kendala dalam proses pembayaran tersebut, silahkan hubungi kami pada kontak yang ada pada halaman beranda.</li>';
                                                                echo '              </ol>';
                                                                echo '          </small>';
                                                                echo '      </div>';
                                                                echo '  </div>';
                                                                echo '</div>';
                                                                //Tampilkan Tombol
                                                                echo '<div class="row mb-3">';
                                                                echo '  <div class="col-md-12">';
                                                                echo '      <button type="button" class="button_pendaftaran" data-bs-toggle="modal" data-bs-target="#ModalBayarEvent" data-id="'.$kode_transaksi.'">';
                                                                echo '          <i class="bi bi-coin"></i> Bayar Sekarang';
                                                                echo '      </button>';
                                                                echo '  </div>';
                                                                echo '</div>';
                                                            }else{
                                                                echo '<div class="row mb-3 mt-5">';
                                                                echo '  <div class="col-md-12 text-center">';
                                                                echo '      <h1 class="text-success"><i class="bi bi-check-circle"></i></h1>';
                                                                echo '      <small class="mobile-text text-success">';
                                                                echo '          Anda sudah menyelesaikan pendaftaran event ini.';
                                                                echo '      </small>';
                                                                echo '  </div>';
                                                                echo '</div>';
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
<?php
                }
            }
        }
    }
?>
    </div>
</section>

