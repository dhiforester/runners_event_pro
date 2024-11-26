<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-2">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit mobile-text">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Uang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['kode_transaksi'])){
            echo '<div class="row mb-2">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit mobile-text">';
            echo '              <code class="text-dark">';
            echo '                  Kode Transaksi Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $kode_transaksi=$_POST['kode_transaksi'];
            //Bersihkan Data
            $kode_transaksi=validateAndSanitizeInput($kode_transaksi);
            //Buka Data
            $kode_transaksi_validasi=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kode_transaksi');
            if(empty($kode_transaksi_validasi)){
                echo '<div class="row mb-2">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                echo '          <small class="credit mobile-text">';
                echo '              <code class="text-dark">';
                echo '                  Data Yang Anda Pilih Tidak Ditemukan Pada Database!';
                echo '              </code>';
                echo '          </small>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $id_member=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'id_member');
                $raw_member=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'raw_member');
                //Buka Raw Member
                if(!empty($raw_member)){
                    $raw_member_arry=json_decode($raw_member,true);
                    $nama=$raw_member_arry['nama'];
                    $email=$raw_member_arry['email'];
                    $kontak=$raw_member_arry['kontak'];
                    $provinsi=$raw_member_arry['provinsi'];
                    $kabupaten=$raw_member_arry['kabupaten'];
                    $kecamatan=$raw_member_arry['kecamatan'];
                    $desa=$raw_member_arry['desa'];
                    $rt_rw=$raw_member_arry['rt_rw'];
                    $kode_pos=$raw_member_arry['kode_pos'];
                }else{
                    $nama="";
                    $email="";
                    $kontak="";
                    $provinsi="";
                    $kabupaten="";
                    $kecamatan="";
                    $desa="";
                    $rt_rw="";
                    $kode_pos="";
                }
                //Sensor id_member
                $last_three_kode = substr($id_member, -5);
                $id_member_mask = '***' . $last_three_kode;
?>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        <small class="credit mobile-text">ID.Member</small>
                    </div>
                    <div class="col col-md-8">
                        <small class="credit mobile-text">
                            <code class="text text-grayish"><?php echo $id_member_mask; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        <small class="credit mobile-text">Nama</small>
                    </div>
                    <div class="col col-md-8">
                        <small class="credit mobile-text">
                            <code class="text text-grayish"><?php echo $nama; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        <small class="credit mobile-text">Email</small>
                    </div>
                    <div class="col col-md-8">
                        <small class="credit mobile-text">
                            <code class="text text-grayish"><?php echo $email; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        <small class="credit mobile-text">Kontak</small>
                    </div>
                    <div class="col col-md-8">
                        <small class="credit mobile-text">
                            <code class="text text-grayish"><?php echo $kontak; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        <small class="credit mobile-text">Provinsi</small>
                    </div>
                    <div class="col col-md-8">
                        <small class="credit mobile-text">
                            <code class="text text-grayish"><?php echo $provinsi; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        <small class="credit mobile-text">Kabupaten/Kota</small>
                    </div>
                    <div class="col col-md-8">
                        <small class="credit mobile-text">
                            <code class="text text-grayish"><?php echo $kabupaten; ?></code>
                        </small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        <small class="credit mobile-text">Kecamatan</small>
                    </div>
                    <div class="col col-md-8">
                        <small class="credit mobile-text">
                            <code class="text text-grayish"><?php echo $kecamatan; ?></code>
                        </small>
                    </div>
                </div>
<?php
            }
        }
    }
?>