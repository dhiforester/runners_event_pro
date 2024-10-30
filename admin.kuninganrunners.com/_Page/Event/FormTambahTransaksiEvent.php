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
        if(empty($_POST['id_event_peserta'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Peserta Event Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_event_peserta=$_POST['id_event_peserta'];
            //Bersihkan Data
            $id_event_peserta=validateAndSanitizeInput($id_event_peserta);
            //Buka Data
            $id_event_peserta_validasi=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event_peserta');
            if(empty($id_event_peserta_validasi)){
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
                $id_event=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event');
                $id_event_kategori=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_event_kategori');
                $id_member=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'id_member');
                $nama=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'nama');
                $email=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'email');
                $biaya_pendaftaran=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'biaya_pendaftaran');
                $datetime=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'datetime');
                $status=GetDetailData($Conn,'event_peserta','id_event_peserta',$id_event_peserta,'status');
                $kategori=GetDetailData($Conn,'event_kategori','id_event_kategori',$id_event_kategori,'kategori');
                //Pecah Nama
                $explode=explode(' ',$nama);
                $first_name=$explode[0];
                $last_name=$explode[1];
                //Kontak
                $kontak=GetDetailData($Conn,'member','id_member',$id_member,'kontak');
                //Order ID
                $order_id=GenerateToken('36');
?>
        <input type="hidden" name="id_member" value="<?php echo $id_member; ?>">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="kode_transaksi">
                    <small>Kode Transaksi</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" readonly name="kode_transaksi" id="kode_transaksi" class="form-control" value="<?php echo "$id_event_peserta"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="order_id">
                    <small>Order ID</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" readonly name="order_id" id="order_id" class="form-control" value="<?php echo "$order_id"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="first_name">
                    <small>Nama Depan</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo "$first_name"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="last_name">
                    <small>Nama Belakang</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo "$last_name"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="email">
                    <small>Email</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="email" id="email" class="form-control" value="<?php echo "$email"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="kontak">
                    <small>Kontak</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="kontak" id="kontak" class="form-control" value="<?php echo "$kontak"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="biaya_pendaftaran">
                    <small>Biaya Pendaftaran</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="biaya_pendaftaran" id="biaya_pendaftaran" class="form-control" value="<?php echo "$biaya_pendaftaran"; ?>">
            </div>
        </div>
<?php
            }
        }
    }
?>