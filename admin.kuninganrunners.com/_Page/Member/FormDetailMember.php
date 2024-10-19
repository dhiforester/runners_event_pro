<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Harus Login Terlebih Dulu
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <code>Sesi Login Sudah Berakhir, Silahkan Login Ulang!</code>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Tangkap id_member
        if(empty($_POST['id_member'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <code>ID Member Tidak Boleh Kosong</code>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_member=$_POST['id_member'];
            //Bersihkan Variabel
            $id_member=validateAndSanitizeInput($id_member);
            //Buka data member
            $ValidasiIdMember=GetDetailData($Conn,'member','id_member',$id_member,'id_member');
            if(empty($ValidasiIdMember)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <code>ID Member Tidak Valid Atau Tidak Ditemukan Pada Database</code>';
                echo '  </div>';
                echo '</div>';
            }else{
                $nama=GetDetailData($Conn,'member','id_member',$id_member,'nama');
                $kontak=GetDetailData($Conn,'member','id_member',$id_member,'kontak');
                $email=GetDetailData($Conn,'member','id_member',$id_member,'email');
                $email_validation=GetDetailData($Conn,'member','id_member',$id_member,'email_validation');
                $provinsi=GetDetailData($Conn,'member','id_member',$id_member,'provinsi');
                $kabupaten=GetDetailData($Conn,'member','id_member',$id_member,'kabupaten');
                $kecamatan=GetDetailData($Conn,'member','id_member',$id_member,'kecamatan');
                $desa=GetDetailData($Conn,'member','id_member',$id_member,'desa');
                $kode_pos=GetDetailData($Conn,'member','id_member',$id_member,'kode_pos');
                $rt_rw=GetDetailData($Conn,'member','id_member',$id_member,'rt_rw');
                $datetime=GetDetailData($Conn,'member','id_member',$id_member,'datetime');
                $status=GetDetailData($Conn,'member','id_member',$id_member,'status');
                $sumber=GetDetailData($Conn,'member','id_member',$id_member,'sumber');
                $foto=GetDetailData($Conn,'member','id_member',$id_member,'foto');
                //Format Tanggal
                $strtotime1=strtotime($datetime);
                //Menampilkan Tanggal
                $DateDaftar=date('d/m/Y H:i:s T', $strtotime1);
                if(!empty($foto)){
                    $PathFoto="assets/img/Member/$foto";
                }else{
                    $PathFoto="assets/img/user/No-Image.png";
                }
?>
            <input type="hidden" name="Page" value="Member">
            <input type="hidden" name="Sub" value="DetailMember">
            <input type="hidden" name="id" value="<?php echo $id_member; ?>">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                            A. Identitias Member
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
                        <div class="accordion-body">
                            <div class="row mb-3 mt-3">
                                <div class="col-md-12 mb-4">
                                    <div class="row mb-3">
                                        <div class="col col-md-4">
                                            <small>Nama Lengkap</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo $nama; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col col-md-4">
                                            <small>Kontak</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo $kontak; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col col-md-4">
                                            <small>Email</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo $email; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col col-md-4">
                                            <small>Tanggal Daftar</small>
                                        </div>
                                        <div class="col col-md-8">
                                            <small>
                                                <code class="text text-grayish"><?php echo $DateDaftar; ?></code>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            B. Alamat Member
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="row mb-3">
                                <div class="col col-md-4">
                                    <small>Provinsi</small>
                                </div>
                                <div class="col col-md-8">
                                    <small>
                                        <code class="text text-grayish">
                                            <?php echo $provinsi; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col col-md-4">
                                    <small>Kabupaten/Kota</small>
                                </div>
                                <div class="col col-md-8">
                                    <small>
                                        <code class="text text-grayish">
                                            <?php echo $kabupaten; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col col-md-4">
                                    <small>Kecamatan</small>
                                </div>
                                <div class="col col-md-8">
                                    <small>
                                        <code class="text text-grayish">
                                            <?php echo $kecamatan; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col col-md-4">
                                    <small>Desa/Kelurahan</small>
                                </div>
                                <div class="col col-md-8">
                                    <small>
                                        <code class="text text-grayish">
                                            <?php echo $desa; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col col-md-4">
                                    <small>Kode Pos</small>
                                </div>
                                <div class="col col-md-8">
                                    <small>
                                        <code class="text text-grayish">
                                            <?php echo $kode_pos; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col col-md-4">
                                    <small>RT/RW/Jalan</small>
                                </div>
                                <div class="col col-md-8">
                                    <small>
                                        <code class="text text-grayish">
                                            <?php echo $rt_rw; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            C. Status Member
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="row mb-3">
                                <div class="col col-md-4">
                                    <small>Status</small>
                                </div>
                                <div class="col col-md-8">
                                    <small>
                                        <code class="text text-grayish">
                                            <?php echo $status; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col col-md-4">
                                    <small>Sumber Data</small>
                                </div>
                                <div class="col col-md-8">
                                    <small>
                                        <code class="text text-grayish">
                                            <?php echo $sumber; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col col-md-4">
                                    <small>Kode Validitas</small>
                                </div>
                                <div class="col col-md-8">
                                    <small>
                                        <code class="text text-grayish">
                                            <?php echo $email_validation; ?>
                                        </code>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                            D. Foto Profil
                        </button>
                    </h2>
                    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="row mb-3 mt-3">
                                <div class="col col-md-12 text-center">
                                    <img src="<?php echo $PathFoto; ?>" alt="" width="50%" class="rounded-circle">
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
?>