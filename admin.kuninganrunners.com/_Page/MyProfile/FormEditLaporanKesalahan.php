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
                $JumlahSubjek=strlen($subjek_laporan);
                $JumlahLaporan=strlen($laporan);
?>
        <input type="hidden" name="id_bug_report" value="<?php echo "$id_bug_report"; ?>">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="subjek_laporan_edit">Subjek/Judul</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="subjek_laporan" id="subjek_laporan_edit" class="form-control" value="<?php echo "$subjek_laporan"; ?>">
                <small class="credit">
                    <code class="text text-grayish" id="PanjangKarakterSubjekEdit">
                        Max: <?php echo "$JumlahSubjek"; ?>/200
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="laporan_edit">Isi Laporan</label>
            </div>
            <div class="col-md-8">
                <textarea name="laporan" id="laporan_edit" class="form-control"><?php echo "$laporan"; ?></textarea>
                <small class="credit">
                    <code class="text text-grayish" id="PanjangKarakterLaporanEdit">
                        Max: <?php echo "$JumlahLaporan"; ?>/500
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="lapiran_edit">Lampiran</label>
            </div>
            <div class="col-md-8">
                <input type="file" name="lampiran" id="lapiran_edit" class="form-control">
                <small class="credit">
                    <code class="text text-grayish">
                        File lampiran tidak lebih dari 2 Mb (JPG, JPEG, PNG dan GIF)
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"></div>
            <div class="col-md-8">
                <small class="text text-grayish credit">
                    Pastikan informasi laporan kesalahan yang anda input sudah sesuai.
                </small>
            </div>
        </div>
        <script>
            //Validasi Form Laporan
            $('#subjek_laporan_edit').on('input', function() {
                var charCount = $(this).val().length;
                $('#PanjangKarakterSubjekEdit').text('Max: ' + charCount + '/200');
                if(charCount > 200) {
                    $(this).val($(this).val().substring(0, 200));
                }
            });

            $('#laporan_edit').on('input', function() {
                var charCount = $(this).val().length;
                $('#PanjangKarakterLaporanEdit').text('Max: ' + charCount + '/500');
                if(charCount > 500) {
                    $(this).val($(this).val().substring(0, 500));
                }
            });
        </script>
<?php 
            }
        }
    } 
?>