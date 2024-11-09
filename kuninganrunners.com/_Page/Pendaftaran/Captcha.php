<?php
    session_start();
    // Membuat gambar
    $image = imagecreate(120, 40);
    $background_color = imagecolorallocate($image, 192, 192, 192);
    $text_color = imagecolorallocate($image, 0, 0, 0);
    
    // Teks acak
    $captcha_code = substr(str_shuffle("ABCDEFGHJKMNPRSTUVWXYZ23456789"), 0, 6);
    $_SESSION["captcha-validation-form"] = $captcha_code;
    
    // Menghitung posisi teks agar berada di tengah
    $font_size = 5; // Ukuran font untuk imagestring
    $image_width = imagesx($image);
    $image_height = imagesy($image);
    $text_width = imagefontwidth($font_size) * strlen($captcha_code);
    $text_height = imagefontheight($font_size);
    
    $x = ($image_width - $text_width) / 2;
    $y = ($image_height - $text_height) / 2;
    
    // Tambahkan teks ke gambar
    imagestring($image, $font_size, $x, $y, $captcha_code, $text_color);
    
    // Header untuk menampilkan gambar
    header("Content-Type: image/png");
    imagepng($image);
    imagedestroy($image);
?>