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
        if(empty($_POST['id_member'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Member Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_member=$_POST['id_member'];
            //Bersihkan Data
            $id_member=validateAndSanitizeInput($id_member);
            //Buka Data
            $id_member_validasi=GetDetailData($Conn,'member','id_member',$id_member,'id_member');
            if(empty($id_member_validasi)){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
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
                if(!empty($foto)){
                    $PathFoto="assets/img/Member/$foto";
                }else{
                    $PathFoto="assets/img/user/No-Image.png";
                }
?>
        <input type="hidden" name="id_member" value="<?php echo $id_member; ?>">
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
        <div class="row">
            <div class="col col-md-12">
                <?php
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      <code class="text-dark">';
                    echo '          Apakah anda yakin akan menghapus data tersebut?';
                    echo '      </code>';
                    echo '  </small>';
                    echo '</div>';
                ?>
            </div>
        </div>
<?php
            }
        }
    }
?>