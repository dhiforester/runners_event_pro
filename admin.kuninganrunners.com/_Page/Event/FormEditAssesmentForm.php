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
        if(empty($_POST['id_event_assesment_form'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Assesment Form Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_event_assesment_form=$_POST['id_event_assesment_form'];
            //Bersihkan Data
            $id_event_assesment_form=validateAndSanitizeInput($id_event_assesment_form);
            //Buka Data
            $id_event_assesment_form=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'id_event_assesment_form');
            if(empty($id_event_assesment_form)){
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
                $form_name=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'form_name');
                $form_type=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'form_type');
                $mandatori=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'mandatori');
                $alternatif=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'alternatif');
                $komentar=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'komentar');
                //Jumlah Karakter
                $form_name_length=strlen($form_name);
                $komentar_length=strlen($komentar);
?>
        <input type="hidden" name="id_event_assesment_form" value="<?php echo $id_event_assesment_form; ?>">
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="form_name_edit"><small>Nama Form</small></label>
                <div class="input-group">
                    <input type="text" name="form_name" id="form_name_edit" class="form-control" value="<?php echo $form_name; ?>">
                    <span class="input-group-text" id="inputGroupPrepend">
                        <small>
                            <code id="form_name_edit_length" class="text text-grayish"><?php echo $form_name_length; ?>/50</code>
                        </small>
                    </span>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="mandatori_edit"><small>Mandatori</small></label>
                <select name="mandatori" id="mandatori_edit" class="form-control">
                    <option <?php if($mandatori==""){echo "selected";} ?> value="">Pilih</option>
                    <option <?php if($mandatori=="true"){echo "selected";} ?> value="true">Wajib Terisi</option>
                    <option <?php if($mandatori=="false"){echo "selected";} ?> value="false">Tidak Wajib</option>
                </select>
                <small>
                    <code class="text text-grayish">
                        Menyatakan apakah form tersebut wajib untuk diisi.
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="komentar_edit"><small>Komentar</small></label>
                <textarea name="komentar" id="komentar_edit" class="form-control"><?php echo $komentar; ?></textarea>
                <small>
                    <code id="komentar_edit_length" class="text text-grayish"><?php echo $komentar_length; ?>/500</code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <?php
                    if($form_type=="checkbox"||$form_type=="radio"){
                        echo '<button type="button" class="btn btn-sm btn-outline-info btn-block" id="TambahAlternatifEdit">';
                        echo '  <i clas="bi bi-plus"></i> Tambah Alternatif';
                        echo '</button>';
                    }
                ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="AlternatifListEdit">
                <?php
                    if($form_type=="checkbox"||$form_type=="radio"||$form_type=="select_option"){
                        $alternatif_array=json_decode($alternatif, true);
                        //Jumlah Alternatif
                        $JumlahAlternatif=count($alternatif_array);
                        $no=1;
                        foreach($alternatif_array as $alternatif_list){
                            $alternatif_display=$alternatif_list['display'];
                            $alternatif_value=$alternatif_list['value'];
                            echo '<div class="input-group mb-3" id="alternatif_display_edit" data-id="'.$no.'">';
                            echo '  <span class="input-group-text" id="AlternatifNumberEdit">';
                            echo '      <small><code class="text text-grayish"><i class="bi bi-check"></i></code></small>';
                            echo '  </span>';
                            echo '  <input type="text" name="alternatif_display[]" class="form-control" placeholder="Display" value="'.$alternatif_display.'">';
                            echo '  <input type="text" name="alternatif_value[]" class="form-control" placeholder="Value" value="'.$alternatif_value.'">';
                            echo '  <span class="input-group-text" id="AlternatifRemoveButtonEdit">';
                            echo '      <a href="#" class="text-danger remove-alternatif-edit" data-id="'.$no.'">';
                            echo '          <i class="bi bi-x-circle"></i>';
                            echo '      </a>';
                            echo '  </span>';
                            echo ' </div>';
                            $no++;
                        }
                    }else{
                        $JumlahAlternatif=0;
                    }
                    $NextAlternatif=$JumlahAlternatif+1;
                ?>
            </div>
        </div>
        <script>
            // Fungsi untuk mengecek panjang input form_name
            $('#form_name_edit').on('input keyup keydown', function (e) {
                    var maxLength = 50;
                    var currentLength = $(this).val().length;
                    
                    // Memperbarui penghitung panjang karakter di tampilan
                    $('#form_name_edit_length').text(currentLength + '/' + maxLength);
                    
                    // Batasi input tepat di 50 karakter dan cegah tambahan input
                    if (currentLength >= maxLength && e.key !== 'Backspace' && e.key !== 'Delete') {
                        e.preventDefault();
                        $(this).val($(this).val().substring(0, maxLength));
                    }
                });
                // Fungsi untuk mengecek panjang input form_name
                $('#komentar_edit').on('input keyup keydown', function (e) {
                    var maxLength = 500;
                    var currentLength = $(this).val().length;
                    
                    // Memperbarui penghitung panjang karakter di tampilan
                    $('#komentar_edit_length').text(currentLength + '/' + maxLength);
                    
                    // Batasi input tepat di 500 karakter dan cegah tambahan input
                    if (currentLength >= maxLength && e.key !== 'Backspace' && e.key !== 'Delete') {
                        e.preventDefault();
                        $(this).val($(this).val().substring(0, maxLength));
                    }
                });
                var count = <?php echo $NextAlternatif; ?>; // Untuk melacak nomor alternatif

            // Ketika tombol TambahAlternatifEdit ditekan
            $('#TambahAlternatifEdit').on('click', function (e) {
                e.preventDefault(); // Mencegah halaman reload jika tombol di dalam form

                // HTML untuk form baru yang akan ditambahkan
                var alternatifHTML = `
                    <div class="input-group mb-3" id="alternatif_display_edit" data-id="${count}">
                        <span class="input-group-text" id="AlternatifNumber">
                            <small><code class="text text-grayish"><i class="bi bi-check"></i></code></small>
                        </span>
                        <input type="text" name="alternatif_display[]" class="form-control" placeholder="Display">
                        <input type="text" name="alternatif_value[]" class="form-control" placeholder="Value">
                        <span class="input-group-text" id="AlternatifRemoveButtonEdit">
                            <a href="#" class="text-danger remove-alternatif-edit" data-id="${count}">
                                <i class="bi bi-x-circle"></i>
                            </a>
                        </span>
                    </div>
                `;

                // Menambahkan elemen baru ke #AlternatifList
                $('#AlternatifListEdit').append(alternatifHTML);
                count++; // Menambah nomor untuk alternatif berikutnya
            });

            // Event listener untuk menghapus form alternatif
            $('#AlternatifListEdit').on('click', '.remove-alternatif-edit', function (e) {
                e.preventDefault(); // Mencegah reload halaman
                $(this).closest('.input-group').remove(); // Menghapus elemen terkait
            });
        </script>
<?php
            }
        }
    }
?>