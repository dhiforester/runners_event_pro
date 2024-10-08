<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/GlobalFunction.php";
    $Sekarang=date('Y-m-d H:i:s');
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col col-md-12 text-center">';
        echo '      <code class="text-danger">Sesi Akses Sudah Habis, Silahkan Login Ulang</code>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_bug_report'])){
            echo '<div class="row">';
            echo '  <div class="col col-md-12 text-center">';
            echo '      <code class="text-danger">ID Bug Report Tidak Boleh Kosong!</code>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_bug_report=$_POST['id_bug_report'];
            $id_bug_report=validateAndSanitizeInput($id_bug_report);
            $id_bug_report=GetDetailData($Conn,'bug_report','id_bug_report',$id_bug_report,'id_bug_report');
            if(empty($id_bug_report)){
                echo '<div class="row">';
                echo '  <div class="col col-md-12 text-center">';
                echo '      <code class="text-danger">ID Bug Report Tidak Boleh Kosong!</code>';
                echo '  </div>';
                echo '</div>';
            }else{
                $tanggal_report=GetDetailData($Conn,'bug_report','id_bug_report',$id_bug_report,'tanggal_report');
                $tanggal_selesai=GetDetailData($Conn,'bug_report','id_bug_report',$id_bug_report,'tanggal_selesai');
                $nama=GetDetailData($Conn,'bug_report','id_bug_report',$id_bug_report,'nama');
                $subjek_laporan=GetDetailData($Conn,'bug_report','id_bug_report',$id_bug_report,'subjek_laporan');
                $laporan=GetDetailData($Conn,'bug_report','id_bug_report',$id_bug_report,'laporan');
                $lampiran=GetDetailData($Conn,'bug_report','id_bug_report',$id_bug_report,'lampiran');
                $status=GetDetailData($Conn,'bug_report','id_bug_report',$id_bug_report,'status');
                $petugas=GetDetailData($Conn,'bug_report','id_bug_report',$id_bug_report,'petugas');
                //Format Tanggal
                $strtotime=strtotime($tanggal_report);
                $tanggal_report=date('d/m/Y H:i:s T',$strtotime);
                //Routing Status
                if($status=="Terkirim"){
                    $LabelStatus='<span class="badge bg-warning">Terkirim</span>';
                }else{
                    if($status=="Dibaca"){
                        $LabelStatus='<span class="badge bg-info">Dibaca</span>';
                    }else{
                        $LabelStatus='<span class="badge bg-success">Selesai</span>';
                    }
                }
?>
        <div class="row mb-3">
            <div class="col col-md-4">Tanggal Report</div>
            <div class="col col-md-8">
                <small class="text text-grayish"><?php echo "$tanggal_report"; ?></small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Nama Pelapor</div>
            <div class="col col-md-8">
                <small class="text text-grayish"><?php echo "$nama"; ?></small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Subjek</div>
            <div class="col col-md-8">
                <small class="text text-grayish"><?php echo "$subjek_laporan"; ?></small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Laporan</div>
            <div class="col col-md-8">
                <small class="text text-grayish"><?php echo "$laporan"; ?></small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Lampiran</div>
            <div class="col col-md-8">
                <small class="text text-grayish">
                    <?php
                        if(empty($lampiran)){
                            echo 'None';
                        }else{
                    ?>
                        <a href="assets/img/Lampiran/<?php echo "$lampiran"; ?>" target="_blank" class="text-primary">
                            <?php echo "$lampiran"; ?>
                        </a>
                    <?php } ?>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Status</div>
            <div class="col col-md-8">
                <small class="text text-grayish"><?php echo "$LabelStatus"; ?></small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-12">Progress</div>
            <div class="col col-md-12">
                <small class="text text-grayish">
                    <?php
                        if(empty($petugas)){
                            echo 'None';
                        }else{
                            $petugas_array=json_decode($petugas, true);
                            echo '<ol>';
                            foreach($petugas_array as $petugas_list){
                                $NamaPetugas=$petugas_list['petugas'];
                                $TanggalUpdate=$petugas_list['datetime'];
                                $StatusPerubahan=$petugas_list['status'];
                                $keterangan=$petugas_list['keterangan'];
                                $strtotime2=strtotime($TanggalUpdate);
                                $TanggalUpdate=date('d/m/Y H:i:s T',$strtotime2);
                                echo '<li class="mb-3">';
                                echo '  <b>'.$TanggalUpdate.'</b><br>';
                                echo '  Status : <code class="text text-grayish">'.$StatusPerubahan.'</code><br>';
                                echo '  Petugas : <code class="text text-grayish">'.$NamaPetugas.'</code><br>';
                                echo '  Keterangan : <code class="text text-grayish">'.$keterangan.'</code><br>';
                                echo '</li>';
                            }
                            echo '</ol>';
                        }
                    ?>
                </small>
            </div>
        </div>
<?php 
            }
        }
    } 
?>