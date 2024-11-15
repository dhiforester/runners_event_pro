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
        if(empty($_POST['kode_transaksi'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Transaksi Tidak Boleh Kosong!';
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
            $id_transaksi_validasi=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kode_transaksi');
            if(empty($id_transaksi_validasi)){
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
                $kode_transaksi=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kode_transaksi');
                $id_member=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'id_member');
                $raw_member=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'raw_member');
                $kategori=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kategori');
                $kode_transaksi=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kode_transaksi');
                $datetime=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'datetime');
                $jumlah=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'jumlah');
                $status=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'status');
                //Format Tanggal
                $strtotime=strtotime($datetime);
                $TanggalTransaksi=date('d/m/Y H:i', $strtotime);
                //Biaya Pendaftaran
                $jumlah_format='Rp ' . number_format($jumlah, 2, ',', '.');
                //Jumlah Riwayat Transaksi
                $RiwayatPembayaran = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_payment FROM transaksi_payment WHERE kode_transaksi ='$kode_transaksi '"));
                //Buka Raw Member
                $raw_member_arry=json_decode($raw_member, true);
                $NamaDepan=$raw_member_arry['first_name'];
                $NamaBelakang=$raw_member_arry['last_name'];
                $NomorKontak=$raw_member_arry['kontak'];
                $EmailMember=$raw_member_arry['email'];

?>
        <input type="hidden" name="id_member" value="<?php echo $id_member; ?>">
        <input type="hidden" name="kode_transaksi" value="<?php echo $kode_transaksi; ?>">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="kode_transaksi">
                    <small>Kode Transaksi</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" readonly name="kode_transaksi" id="kode_transaksi" class="form-control" value="<?php echo "$kode_transaksi"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="first_name">
                    <small>Nama Depan</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo "$NamaDepan"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="last_name">
                    <small>Nama Belakang</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo "$NamaBelakang"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="email">
                    <small>Email</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="email" id="email" class="form-control" value="<?php echo "$EmailMember"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="kontak">
                    <small>Kontak</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="kontak" id="kontak" class="form-control" value="<?php echo "$NomorKontak"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="biaya_pendaftaran">
                    <small>Biaya Pendaftaran</small>
                </label>
            </div>
            <div class="col-md-8">
                <input type="text" name="biaya_pendaftaran" id="biaya_pendaftaran" class="form-control" value="<?php echo "$jumlah"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <small class="credit">
                        Pastikan sebelum mengubah data transaksi tersebut belum menerima pembayaran untuk menghidarkan dari nominal yang tidak sesuai.
                    </small>
                </div>
            </div>
        </div>
<?php
            }
        }
    }
?>