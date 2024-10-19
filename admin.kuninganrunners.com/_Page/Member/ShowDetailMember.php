<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Harus Login Terlebih Dulu
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Ulang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Tangkap id_member
        if(empty($_POST['id_member'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Event Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_member=$_POST['id_member'];
            //Bersihkan Variabel
            $id_member=validateAndSanitizeInput($id_member);
            //Buka data member
            $ValidasiIdMember=GetDetailData($Conn,'member','id_member',$id_member,'id_member');
            if(empty($ValidasiIdMember)){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
                echo '          <small class="credit">';
                echo '              <code class="text-dark">';
                echo '                  Data Yang Anda Pilih Tidak Ditemukan Pada Database!';
                echo '              </code>';
                echo '          </small>';
                echo '      </div>';
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
?>
            <div class="row">
                <div class="col-md-6">
                    <ul>
                        <li class="mb-5">
                            <span class="mb-3">Identitas Member</span>
                            <div class="row mb-3 mt-3">
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
                        </li>
                        <li class="mb-5">
                            <span class="mb-3">Alamat Member</span>
                            <div class="row mb-3 mt-3">
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
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul>
                        <li class="mb-5">
                            <span class="mb-3">Status Member</span>
                            <div class="row mb-3 mt-3">
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
                        </li>
                    </ul>
                </div>
            </div>
            
<?php 
            } 
        } 
    } 
?>