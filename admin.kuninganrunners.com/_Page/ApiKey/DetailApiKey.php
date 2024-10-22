<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'gd7YgKyL1WMQctJLgaq');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        //Validasi Parameter 'id'
        if(empty($_GET['id'])){
            echo '<section class="section dashboard">';
            echo '  <div class="row mb-3">';
            echo '      <div class="col-md-12">';
            echo '          <div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '              ID API Key Tidak Boleh Kosong!';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</section>';
        }else{
            $id=$_GET['id'];
            //Bersihkan Variabel
            $id=validateAndSanitizeInput($id);
            //Validasi Data 'id'
            $id_setting_api_key=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id,'id_setting_api_key');
            if(empty($id_setting_api_key)){
                echo '<section class="section dashboard">';
                echo '  <div class="row mb-3">';
                echo '      <div class="col-md-12">';
                echo '          <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo '              ID API Key Tidak Valid';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '</section>';
            }else{
                $id_setting_api_key=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id,'id_setting_api_key');
                $datetime_creat=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id,'datetime_creat');
                $datetime_update=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id,'datetime_update');
                $title_api_key=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id,'title_api_key');
                $user_key_server=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id,'user_key_server');
                $description_api_key=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id,'description_api_key');
                $limit_session=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id,'limit_session');
                $status=GetDetailData($Conn,'setting_api_key','id_setting_api_key',$id,'status');
                //Mengnakap Informasi Periode
                $Periode = empty($_GET['Periode']) ? "Tahunan" : $_GET['Periode'];
                $Tahun = empty($_GET['Tahun']) ? date('Y') : $_GET['Tahun'];
                $Bulan = empty($_GET['Bulan']) ? date('m') : $_GET['Bulan'];
?>
    <input type="hidden" id="id_setting_api_key" value="<?php echo $id_setting_api_key; ?>">
    <section class="section dashboard">
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <small>
                        <code class="text-dark">
                            Berikut ini detail informasi penggunaan API Key.
                            Pada halaman ini anda bisa memantau penggunaan API key yang terhubung berdasarkan grafik harian token yang dibuat dan aktivitas service yang digunakan.
                        </code>
                    </small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <b class="card-title">
                                    <i class="bi bi-info-circle"></i> Detail Informasi API Key
                                </b>
                            </div>
                            <div class="col-md-2">
                                <a href="index.php?Page=ApiKey" class="btn btn-md btn-rounded btn-black btn-block">
                                    <i class="bi bi-chevron-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <div class="col col-md-4"><small>Nama/Title</small></div>
                                    <div class="col col-md-8">
                                        <small class="credit">
                                            <code class="text text-grayish"><?php echo "$title_api_key"; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4"><small>User Key</small></div>
                                    <div class="col col-md-8">
                                        <code class="text text-grayish"><small class="credit"><?php echo "$user_key_server"; ?></small></code>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4"><small>Datetime Creat</small></div>
                                    <div class="col col-md-8">
                                        <code class="text text-grayish"><small class="credit"><?php echo "$datetime_creat"; ?></small></code>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <div class="col col-md-4"><small>Updatetime</small></div>
                                    <div class="col col-md-8">
                                        <code class="text text-grayish"><small class="credit"><?php echo "$datetime_update"; ?></small></code>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4"><small>Limit Time</small></div>
                                    <div class="col col-md-8">
                                        <code class="text text-grayish"><small class="credit"><?php echo "$limit_session ms"; ?></small></code>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4"><small>Status</small></div>
                                    <div class="col col-md-8">
                                        <code class="text text-grayish"><small class="credit"><?php echo "$status"; ?></small></code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <h5 class="card-title">
                                    <i class="bi bi-clock-history"></i> Riwayat Penggunaan API Key
                                </h5>
                            </div>
                            <div class="col-md-2">
                                <a href="javascript:void(0);" class="btn btn-md btn-rounded btn-outline-black btn-block" data-bs-toggle="modal" data-bs-target="#ModalFilterPeriodeGrafik">
                                    <i class="bi bi-calendar"></i> Periode
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Bordered Tabs Justified -->
                        <ul class="nav nav-tabs nav-tabs-bordered d-flex border-1 border-bottom" id="borderedTabJustified" role="tablist">
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-home" type="button" role="tab" aria-controls="home" aria-selected="true">
                                    X-Token
                                </button>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-contact" type="button" role="tab" aria-controls="contact" aria-selected="false" tabindex="-1">
                                    Log
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                            <div class="tab-pane fade active show" id="bordered-justified-home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row mb-3">
                                    <div class="col-md-12" id="GrafikTokenApiKey">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" id="TabelRekapTokenApiKey">

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="bordered-justified-contact" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="row mb-3">
                                    <div class="col-md-12" id="GrafikAktivitasApiKey">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" id="TabelRekapLogApiKey">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php 
            } 
        } 
    } 
?>