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
        if(empty($_POST['id_akses_fitur'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Fitur Tidak Dapat Ditangkap Oleh Sistem!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_akses_fitur=$_POST['id_akses_fitur'];
            $id_akses_fitur=$_POST['id_akses_fitur'];
            $NamaFitur=GetDetailData($Conn,'akses_fitur','id_akses_fitur',$id_akses_fitur,'nama');
            $KategoriFitur=GetDetailData($Conn,'akses_fitur','id_akses_fitur',$id_akses_fitur,'kategori');
            $KodeFitur=GetDetailData($Conn,'akses_fitur','id_akses_fitur',$id_akses_fitur,'kode');
            $KeteranganFitur=GetDetailData($Conn,'akses_fitur','id_akses_fitur',$id_akses_fitur,'keterangan');
            echo '<input type="hidden" name="id_akses_fitur" value="'.$id_akses_fitur.'">';
?>
            <div class="row mb-3">
                <div class="col col-md-4"><small>Nama Fitur</small></div>
                <div class="col col-md-8">
                    <small>
                        <code class="text text-grayish"><?php echo $NamaFitur; ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4"><small>Kategori</small></div>
                <div class="col col-md-8">
                    <small>
                        <code class="text text-grayish"><?php echo $KategoriFitur; ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4"><small>Kode</small></div>
                <div class="col col-md-8">
                    <small>
                        <code class="text text-grayish"><?php echo $KodeFitur; ?></code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4"><small>Keterangan</small></div>
                <div class="col col-md-8">
                    <small>
                        <code class="text text-grayish"><?php echo $KeteranganFitur; ?></code>
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">
                        <small class="credit">
                            <code class="text-dark">
                                <b>PENTING!</b>
                                <p>
                                    Menghapus data ini akan menyebabkan pengguna tidak bisa mengakses fitur tersebut.
                                </p>
                                <b>
                                    Apakah anda yakin akan menghapus data ini?
                                </b>
                            </code>
                        </small>
                    </div>
                </div>
            </div>
<?php
        }
    }
?>