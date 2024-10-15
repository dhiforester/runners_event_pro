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
        //Tangkap id_akses
        if(empty($_POST['id_akses'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <code>ID Akses Tidak Boleh Kosong</code>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_akses=$_POST['id_akses'];
            //Menangkap Periode awal dan akhir
            if(empty($_POST['periode1'])){
                $tahun=date('Y');
                $bulan=date('m');
                $periode1="$tahun-$bulan-01";
            }else{
                $periode1=$_POST['periode1'];
            }
            if(empty($_POST['periode2'])){
                $periode2=date('Y-m-d');
            }else{
                $periode2=$_POST['periode2'];
            }
            if($periode1>$periode2){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <code>Periode Awal Tidak Boleh Lebih Besar Dari Periode Akhir</code>';
                echo '  </div>';
                echo '</div>';
            }else{
                //Bersihkan Variabel
                $id_akses=validateAndSanitizeInput($id_akses);
                //Buka data askes
                $nama_akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'nama_akses');
                $kontak_akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'kontak_akses');
                $email_akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'email_akses');
                $image_akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'image_akses');
                $akses=GetDetailData($Conn,'akses','id_akses',$id_akses,'akses');
                $datetime_daftar=GetDetailData($Conn,'akses','id_akses',$id_akses,'datetime_daftar');
                $datetime_update=GetDetailData($Conn,'akses','id_akses',$id_akses,'datetime_update');
                //Jumlah Total Aktivitas
                $JumlahAktivitas =mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses FROM log WHERE id_akses='$id_akses' AND datetime_log>='$periode1' AND datetime_log<='$periode2'"));
?>
            <div class="row mb-3">
                <div class="col-md-12">
                    <form action="javascript:void(0);" id="ProsesRekapAktivitasAkses">
                        <input type="hidden" name="id_akses" id="id_akses_edit" value="<?php echo "$id_akses"; ?>">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <input type="date" name="periode1" id="periode1" class="form-control" value="<?php echo $periode1; ?>">
                                <label for="periode1">
                                    <small>
                                        <code class="text-dark">Periode Awal</code>
                                    </small>
                                </label>
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="date" name="periode2" id="periode2" class="form-control" value="<?php echo $periode2; ?>">
                                <label for="periode1">
                                    <small>
                                        <code class="text-dark">Periode Akhir</code>
                                    </small>
                                </label>
                            </div>
                            <div class="col-md-4 mb-3">
                                <button type="submit" class="btn btn-md btn-block btn-primary">
                                    <i class="bi bi-search"></i> Tampilkan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td align="left"><b>No</b></td>
                                    <td align="left"><b>Kategori</b></td>
                                    <td align="center"><b>Jumlah</b></td>
                                    <td align="center"><b>%</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(empty($JumlahAktivitas)){
                                        echo '<tr>';
                                        echo '  <td class="text-center text-danger" colspan="4">Record Aktivitas Tidak Ditemukan</td>';
                                        echo '</tr>';
                                    }else{
                                        $no=1;
                                        $JumlahTotalAktivitas=0;
                                        $JumlahTotalPersentase=0;
                                        $query = mysqli_query($Conn, "SELECT DISTINCT kategori_log FROM log WHERE id_akses='$id_akses' ORDER BY id_log DESC");
                                        while ($data = mysqli_fetch_array($query)) {
                                            $kategori_log= $data['kategori_log'];
                                            //Menghitung Jumlah LOG
                                            $JumlahLog = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE id_akses='$id_akses' AND kategori_log='$kategori_log' AND datetime_log>='$periode1' AND datetime_log<='$periode2'"));
                                            if(empty($JumlahAktivitas)){
                                                $persentase=0;
                                            }else{
                                                $persentase=($JumlahLog/$JumlahAktivitas)*100;
                                                $persentase=round($persentase);
                                            }
                                            $JumlahLogFormat='' . number_format($JumlahLog, 0, ',', '.');
                                            //Tambahkan Data
                                            $JumlahTotalAktivitas=$JumlahTotalAktivitas+$JumlahLog;
                                            $JumlahTotalPersentase=$JumlahTotalPersentase+$persentase;
                                            //Tampilkan Data
                                            echo '<tr>';
                                            echo '  <td class="text-left">'.$no.'</td>';
                                            echo '  <td class="text-left">'.$kategori_log.'</td>';
                                            echo '  <td class="text-center">'.$JumlahLogFormat.'</td>';
                                            echo '  <td class="text-center">'.$persentase.'</td>';
                                            echo '</tr>';
                                            $no++;
                                        }
                                        $JumlahTotalAktivitasFormat='' . number_format($JumlahTotalAktivitas, 0, ',', '.');
                                        $JumlahTotalPersentaseFormat='' . number_format($JumlahTotalPersentase, 0, ',', '.');
                                        echo '<tr>';
                                        echo '  <td class="text-left"></td>';
                                        echo '  <td class="text-left"><b>TOTAL</b></td>';
                                        echo '  <td class="text-center"><b>'.$JumlahTotalAktivitasFormat.'</b></td>';
                                        echo '  <td class="text-center"><b>'.$JumlahTotalPersentaseFormat.'</b></td>';
                                        echo '</tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <script>
                //Proses Ubah Foto Profil
                $('#ProsesRekapAktivitasAkses').submit(function(){
                    var form = $('#ProsesRekapAktivitasAkses')[0];
                    var data = new FormData(form);
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/Akses/FormLogAkses.php',
                        data 	    :  data,
                        cache       : false,
                        processData : false,
                        contentType : false,
                        enctype     : 'multipart/form-data',
                        success     : function(data){
                            $('#FormLogAkses').html(data);
                        }
                    });
                });
            </script>
<?php 
            } 
        } 
    } 
?>