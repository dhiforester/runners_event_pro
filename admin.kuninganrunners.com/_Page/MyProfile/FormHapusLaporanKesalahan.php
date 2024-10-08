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
        <input type="hidden" name="id_bug_report" value="<?php echo "$id_bug_report"; ?>">
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
        <div class="row">
            <div class="col col-md-12 text-center">
                <code>Apakah anda yakin akan menghapus laporan ini?</code>
            </div>
        </div>
<?php 
            }
        }
    } 
?>