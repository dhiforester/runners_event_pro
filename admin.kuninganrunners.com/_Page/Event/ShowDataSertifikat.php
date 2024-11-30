<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

    if (empty($SessionIdAkses)) {
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Ulang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    } else {
        if (empty($_POST['id_event'])) {
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12 text-center">';
            echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Event Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        } else {
            $id_event = validateAndSanitizeInput($_POST['id_event']);
            // Validasi apakah data event ada di database
            $id_event_validasi = GetDetailData($Conn, 'event', 'id_event', $id_event, 'id_event');

            if (empty($id_event_validasi)) {
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12 text-center">';
                echo '      <div class="alert alert-danger border-1 alert-dismissible fade show" role="alert">';
                echo '          <small class="credit">';
                echo '              <code class="text-dark">';
                echo '                  Data Yang Anda Pilih Tidak Ditemukan Pada Database!';
                echo '              </code>';
                echo '          </small>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            } else {
                //Buka Pengaturan Sertifikat
                $sertifikat = GetDetailData($Conn, 'event', 'id_event', $id_event, 'sertifikat');
                $sertifikat_arry=json_decode($sertifikat,true);
                //Membuka File Font
                $json_font = file_get_contents('font-family.json');
                $data_font = json_decode($json_font, true);
                // Baca file JSON ukuran
                $json_satuan = file_get_contents('panjang-satuan.json');
                $data_satuan = json_decode($json_satuan, true);
                // Baca file JSON ukuran halaman pdf
                $json_satuan_pdf = file_get_contents('panjang-satuan-pdf.json');
                $data_satuan_pdf = json_decode($json_satuan_pdf, true);
?>
                <input type="hidden" name="id_event" value="<?php echo $id_event; ?>">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <b>Pengaturan Ukuran Halaman</b>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><label for="panjang">Panjang Halaman</label></div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" min="0" step="0.01" name="canvas_length_value" class="form-control" value="<?php echo $sertifikat_arry['canvas']['length']['value']; ?>">
                            <select name="canvas_length_unit" class="form-control">
                                <?php
                                    foreach ($data_satuan_pdf['units'] as $unit){
                                        if($sertifikat_arry['canvas']['length']['unit']==$unit['value']){
                                            echo '<option selected value="'.$unit['value'].'">'.$unit['name'].'</option>';
                                        }else{
                                            echo '<option value="'.$unit['value'].'">'.$unit['name'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><label for="lebar">Lebar Halaman</label></div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" min="0" step="0.01" name="canvas_wide_value" class="form-control" value="<?php echo $sertifikat_arry['canvas']['wide']['value']; ?>">
                            <select name="canvas_wide_unit" class="form-control">
                                <?php
                                    foreach ($data_satuan_pdf['units'] as $unit){
                                        if($sertifikat_arry['canvas']['wide']['unit']==$unit['value']){
                                            echo '<option selected value="'.$unit['value'].'">'.$unit['name'].'</option>';
                                        }else{
                                            echo '<option value="'.$unit['value'].'">'.$unit['name'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><label for="margin">Margin Atas</label></div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" min="0" step="0.01" name="canvas_margin_top_value" class="form-control" value="<?php echo $sertifikat_arry['canvas']['margin-top']['value']; ?>">
                            <select name="canvas_margin_top_unit" class="form-control">
                                <?php
                                    foreach ($data_satuan['units'] as $unit){
                                        if($sertifikat_arry['canvas']['margin-top']['unit']==$unit['value']){
                                            echo '<option selected value="'.$unit['value'].'">'.$unit['name'].'</option>';
                                        }else{
                                            echo '<option value="'.$unit['value'].'">'.$unit['name'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><label for="margin">Margin Bawah</label></div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" min="0" step="0.01" name="canvas_margin_bottom_value" class="form-control" value="<?php echo $sertifikat_arry['canvas']['margin-bottom']['value']; ?>">
                            <select name="canvas_margin_bottom_unit" class="form-control">
                                <?php
                                    foreach ($data_satuan['units'] as $unit){
                                        if($sertifikat_arry['canvas']['margin-bottom']['unit']==$unit['value']){
                                            echo '<option selected value="'.$unit['value'].'">'.$unit['name'].'</option>';
                                        }else{
                                            echo '<option value="'.$unit['value'].'">'.$unit['name'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><label for="margin">Margin Kiri</label></div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" min="0" step="0.01" name="canvas_margin_left_value" class="form-control" value="<?php echo $sertifikat_arry['canvas']['margin-left']['value']; ?>">
                            <select name="canvas_margin_left_unit" class="form-control">
                                <?php
                                    foreach ($data_satuan['units'] as $unit){
                                        if($sertifikat_arry['canvas']['margin-left']['unit']==$unit['value']){
                                            echo '<option selected value="'.$unit['value'].'">'.$unit['name'].'</option>';
                                        }else{
                                            echo '<option value="'.$unit['value'].'">'.$unit['name'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><label for="margin">Margin Kanan</label></div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" min="0" step="0.01" name="canvas_margin_right_value" class="form-control" value="<?php echo $sertifikat_arry['canvas']['margin-right']['value']; ?>">
                            <select name="canvas_margin_right_unit" class="form-control">
                                <?php
                                    foreach ($data_satuan['units'] as $unit){
                                        if($sertifikat_arry['canvas']['margin-right']['unit']==$unit['value']){
                                            echo '<option selected value="'.$unit['value'].'">'.$unit['name'].'</option>';
                                        }else{
                                            echo '<option value="'.$unit['value'].'">'.$unit['name'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <b>Pengaturan Text</b>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><label for="participant_name_font_family">Nama Font</label></div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <select name="participant_name_font_family" class="form-control">
                                <?php 
                                    foreach ($data_font['fonts'] as $font){
                                        if($sertifikat_arry['participant_name']['font-family']==$font['value']){
                                            echo '<option selected value="'.$font['value'].'">'.$font['name'].'</option>';
                                        }else{
                                            echo '<option value="'.$font['value'].'">'.$font['name'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><label for="participant_name_font_color">Warna Font</label></div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="text" name="participant_name_font_color" id="participant_name_font_color" class="form-control" value="<?php echo $sertifikat_arry['participant_name']['font-color']; ?>">
                            <input type="color" class="form-control form-control-color" id="participant_name_font_color_pilih" value="<?php echo $sertifikat_arry['participant_name']['font-color']; ?>" title="Choose your color">
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><label for="head_quot_font_size">Ukuran Font</label></div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" min="0" step="0.01" name="participant_name_font_size_value" class="form-control" value="<?php echo $sertifikat_arry['participant_name']['font-size']['value']; ?>">
                            <select name="participant_name_font_size_unit" class="form-control">
                                <option <?php if($sertifikat_arry['participant_name']['font-size']['unit']=="pt"){echo "selected";} ?> value="pt">pt</option>
                                <option <?php if($sertifikat_arry['participant_name']['font-size']['unit']=="em"){echo "selected";} ?> value="em">em</option>
                                <option <?php if($sertifikat_arry['participant_name']['font-size']['unit']=="px"){echo "selected";} ?> value="px">px</option>
                                <option <?php if($sertifikat_arry['participant_name']['font-size']['unit']=="rem"){echo "selected";} ?> value="rem">rem</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><label for="participant_name_text_align">Posisi Font</label></div>
                    <div class="col-md-9">
                        <select name="participant_name_text_align" id="participant_name_text_align" class="form-control">
                            <option <?php if($sertifikat_arry['participant_name']['text-align']=="left"){echo "selected";} ?> value="left">Left</option>
                            <option <?php if($sertifikat_arry['participant_name']['text-align']=="center"){echo "selected";} ?> value="center">Center</option>
                            <option <?php if($sertifikat_arry['participant_name']['text-align']=="right"){echo "selected";} ?> value="right">Right</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><label for="participant_name_font_style">Style</label></div>
                    <div class="col-md-9">
                        <select name="participant_name_font_style" id="participant_name_font_style" class="form-control">
                            <option <?php if($sertifikat_arry['participant_name']['font-style']=="italic"){echo "selected";} ?> value="italic">italic</option>
                            <option <?php if($sertifikat_arry['participant_name']['font-style']=="normal"){echo "selected";} ?> value="normal">normal</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><label for="participant_name_font_weight">Weight</label></div>
                    <div class="col-md-9">
                        <select name="participant_name_font_weight" id="participant_name_font_weight" class="form-control">
                            <option <?php if($sertifikat_arry['participant_name']['font-weight']=="bold"){echo "selected";} ?> value="bold">bold</option>
                            <option <?php if($sertifikat_arry['participant_name']['font-weight']=="normal"){echo "selected";} ?> value="normal">normal</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><label for="participant_name_font_decoration">Decoration</label></div>
                    <div class="col-md-9">
                        <select name="participant_name_font_decoration" id="participant_name_font_decoration" class="form-control">
                            <option <?php if($sertifikat_arry['participant_name']['font-decoration']=="underline"){echo "selected";} ?> value="underline">underline</option>
                            <option <?php if($sertifikat_arry['participant_name']['font-decoration']=="none"){echo "selected";} ?> value="none">none</option>
                            <option <?php if($sertifikat_arry['participant_name']['font-decoration']=="line-through"){echo "selected";} ?> value="line-through">line-through</option>
                            <option <?php if($sertifikat_arry['participant_name']['font-decoration']=="overline"){echo "selected";} ?> value="overline">overline</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><label for="margin_top_content_value">Jarak Dari Atas</label></div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" min="0" step="0.01" name="margin_top_content_value" class="form-control" value="<?php echo $sertifikat_arry['margin_top_content']['value']; ?>">
                            <select name="margin_top_content_unit" class="form-control">
                                <option <?php if($sertifikat_arry['margin_top_content']['unit']=="mm"){echo "selected";} ?> value="mm">mm</option>
                                <option <?php if($sertifikat_arry['margin_top_content']['unit']=="cm"){echo "selected";} ?> value="cm">cm</option>
                                <option <?php if($sertifikat_arry['margin_top_content']['unit']=="px"){echo "selected";} ?> value="px">px</option>
                                <option <?php if($sertifikat_arry['margin_top_content']['unit']=="in"){echo "selected";} ?> value="in">in</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <b>Pengaturan Tampilan QR Code</b>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><label for="qr_code_correction">Tipe Correction</label></div>
                    <div class="col-md-9">
                        <select name="qr_code_correction" id="qr_code_correction" class="form-control">
                            <option <?php if($sertifikat_arry['qr_code']['correction']=="QR_ECLEVEL_L"){echo "selected";} ?> value="QR_ECLEVEL_L">QR_ECLEVEL_L</option>
                            <option <?php if($sertifikat_arry['qr_code']['correction']=="QR_ECLEVEL_M"){echo "selected";} ?> value="QR_ECLEVEL_M">QR_ECLEVEL_M</option>
                            <option <?php if($sertifikat_arry['qr_code']['correction']=="QR_ECLEVEL_Q"){echo "selected";} ?> value="QR_ECLEVEL_Q">QR_ECLEVEL_Q</option>
                            <option <?php if($sertifikat_arry['qr_code']['correction']=="QR_ECLEVEL_H"){echo "selected";} ?> value="QR_ECLEVEL_H">QR_ECLEVEL_H</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><label for="qr_code_pixel_block">Pixel Block</label></div>
                    <div class="col-md-9">
                        <input type="number" min="0" class="form-control" name="qr_code_pixel_block" id="qr_code_pixel_block" value="<?php echo $sertifikat_arry['qr_code']['pixel_block']; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <b>File Background</b>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="background_image">Background Image</label><br>
                        <small>
                            <code class="text text-grayish">
                                Pastikan bahwa ukuran gambar sesuai dengan lembar sertifikat.
                            </code>
                        </small>
                    </div>
                    <div class="col-md-9">
                        <div class="input-group mb-3">
                            <input type="file" name="background_image" id="background_image" class="form-control">
                            <span class="input-group-text" id="basic-addon2">
                                <?php
                                    if(!empty($sertifikat_arry['background_image'])){
                                        echo '<a href="assets/img/Sertifikat/'.$sertifikat_arry['background_image'].'" target="_blank">';
                                        echo '  <i class="bi bi-image"></i>';
                                        echo '</a>';
                                    }else{
                                        echo '<i class="bi bi-image"></i>';
                                    }
                                ?>
                            </span>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="publish_sertifikat" name="publish" value="Ya" <?php if($sertifikat_arry['publish']=="Ya"){echo "checked";} ?>>
                            <label class="form-check-label" for="publish_sertifikat">
                                <small>
                                    Publikasikan Sertifikat
                                </small>
                            </label>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        // Ketika participant_name_font_color_pilih diubah
                        $('#participant_name_font_color_pilih').on('input', function() {
                            var selectedColor = $(this).val();
                            $('#participant_name_font_color').val(selectedColor);
                        });

                        // Ketika participant_name_font_color diketik secara manual
                        $('#participant_name_font_color').on('input', function() {
                            var typedColor = $(this).val();
                            // Validasi apakah format kode warna valid (harus diawali dengan '#' dan memiliki 6 karakter hex)
                            if (/^#[0-9A-Fa-f]{6}$/.test(typedColor)) {
                                $('#participant_name_font_color_pilih').val(typedColor);
                            }
                        });
                    });

                </script>
<?php
            }
        }
    }
?>
