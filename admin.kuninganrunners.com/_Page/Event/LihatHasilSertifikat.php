<?php
    include "../../vendor/autoload.php";
    include "../../assets/vendor/phpqrcode/qrlib.php"; 
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    if(empty($_GET['id'])){
        echo '<b>ID Event Tidak Boleh Kosong!</b>';
    }else{
        $id_event=$_GET['id'];
        //Buka Event
        $tanggal_mulai=GetDetailData($Conn,'event','id_event',$id_event,'tanggal_mulai');
        $nama_event=GetDetailData($Conn,'event','id_event',$id_event,'nama_event');
        //format Data
        $tanggal_mulai_format=date('d M Y H:i',strtotime($tanggal_mulai));
        //Nama Peserta
        $nama_peserta="Jhon Doe";
        //Buka Pengaturan Sertifikat
        $sertifikat=GetDetailData($Conn,'event','id_event',$id_event,'sertifikat');
        $sertifikat_arry=json_decode($sertifikat,true);
        //Buka nama file background
        $background_image=$sertifikat_arry['background_image'];
        //Ukuran Halaman
        $canvas_length_value=$sertifikat_arry['canvas']['length']['value'];
        $canvas_length_unit=$sertifikat_arry['canvas']['length']['unit'];
        $canvas_wide_value=$sertifikat_arry['canvas']['wide']['value'];
        $canvas_wide_unit=$sertifikat_arry['canvas']['wide']['unit'];
        //Posisi Text dan jarak text Dari Atas
        $participant_name_text_align=$sertifikat_arry['participant_name']['text-align'];
        $padding_top_content_value = convertToPx($sertifikat_arry['margin_top_content']['value'], $sertifikat_arry['margin_top_content']['unit']);
        $safe_text_align = htmlspecialchars($participant_name_text_align, ENT_QUOTES, 'UTF-8');
        $safe_padding_top = htmlspecialchars($padding_top_content_value, ENT_QUOTES, 'UTF-8');
        //konversi ukuran halaman ke mm
        $canvas_length = convertToMm($sertifikat_arry['canvas']['length']['value'], $sertifikat_arry['canvas']['length']['unit']);
        $canvas_wide = convertToMm($sertifikat_arry['canvas']['wide']['value'], $sertifikat_arry['canvas']['wide']['unit']);
        //Tipe, style dan gaya font untuk text
        $participant_name_font_size=$sertifikat_arry['participant_name']['font-size'];
        $participant_name_font_size_value=$sertifikat_arry['participant_name']['font-size']['value'];
        $participant_name_font_size_unit=$sertifikat_arry['participant_name']['font-size']['unit'];
        $participant_name_font_family=$sertifikat_arry['participant_name']['font-family'];
        $participant_name_font_color=$sertifikat_arry['participant_name']['font-color'];
        $participant_name_font_style=$sertifikat_arry['participant_name']['font-style'];
        $participant_name_font_weight=$sertifikat_arry['participant_name']['font-weight'];
        $participant_name_font_decoration=$sertifikat_arry['participant_name']['font-decoration'];
        //---
        $font_size_value = htmlspecialchars($participant_name_font_size_value, ENT_QUOTES, 'UTF-8');
        $font_size_unit = htmlspecialchars($participant_name_font_size_unit, ENT_QUOTES, 'UTF-8');
        $font_family = htmlspecialchars($participant_name_font_family, ENT_QUOTES, 'UTF-8');
        $font_color = htmlspecialchars($participant_name_font_color, ENT_QUOTES, 'UTF-8');
        $font_style = htmlspecialchars($participant_name_font_style, ENT_QUOTES, 'UTF-8');
        $font_weight = htmlspecialchars($participant_name_font_weight, ENT_QUOTES, 'UTF-8');
        $font_decoration = htmlspecialchars($participant_name_font_decoration, ENT_QUOTES, 'UTF-8');
        //Ukuran text small 2 tahap lebih rendah
        $font_size_value_small =$font_size_value-4;
        //Pengaturan Qr Code
        $qr_code_correction=$sertifikat_arry['qr_code']['correction'];
        $qr_code_pixel_block=$sertifikat_arry['qr_code']['pixel_block'];
        $text_on_qr="$base_url/_Page/Event/LihatHasilSertifikat.php?id=$id_event";
        // Tangkap QR Code dalam buffer
        ob_start();
        QRcode::png($text_on_qr, null, $qr_code_correction, $qr_code_pixel_block);
        $qrcode_image_data = ob_get_clean();
        // Konversi QR Code ke Base64
        $base64_qrcode = 'data:image/png;base64,' . base64_encode($qrcode_image_data);

        //Buka Logo
        $logo_path="$base_url/assets/img/$favicon";
        // Konfigurasi Mpdf
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [$canvas_wide, $canvas_length], // Format kustom: [lebar, tinggi]
            'orientation' => 'P' // Orientasi: 'P' untuk Potret, 'L' untuk Lanskap
        ]);

        $nama_dokumen = "Sertifikat";

        // HTML dan gaya
        $html = '
        <html>
        <head>
            <style>
                @page {
                    margin: 0;
                    background-image: url("../../assets/img/Sertifikat/'.$background_image.'");
                    background-repeat: no-repeat;
                    background-size: cover;
                }
                body {
                    margin: 0;
                    font-family: '.$font_family.';
                    color: '.$font_color.';
                    font-style: '.$font_style.';
                    font-weight: '.$font_weight.';
                    text-decoration: '.$font_decoration.';
                }
                .content {
                    text-align: '.$safe_text_align.';
                    padding-top: '.$safe_padding_top.'px;
                }
                .content h1 {
                    font-size: 36px;
                    margin: 0;
                }
                .content p {
                    font-size: '.$font_size_value.''.$font_size_unit.';
                    margin: 10px 0 0 0;
                }
                .small-text {
                    font-size: '.$font_size_value_small.''.$font_size_unit.';
                }
            </style>
        </head>
        <body>
            <div class="content">
                <img src="'.$logo_path.'" width="70px"><br>
                <h1>Sertifikat Penghargaan</h1>
                <p>Diserahkan kepada</p>
                <h2>'.$nama_peserta.'</h2>
                <p>Atas kontribusi luar biasa dalam acara :</p>
                <h3><i>"'.$nama_event.'"</i></h3>
                <span class="small-text">'.$tanggal_mulai_format.'</span><br>
                <img src="'.$base64_qrcode.'" width="100px">
            </div>
        </body>
        </html>
        ';
        // Menulis HTML ke PDF
        $mpdf->WriteHTML($html);
        // Output PDF
        $mpdf->Output($nama_dokumen . ".pdf", 'I');
        exit;
    }
?>