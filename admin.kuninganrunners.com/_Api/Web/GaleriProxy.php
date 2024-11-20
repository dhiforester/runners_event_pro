<?php
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    if (isset($_GET['galeri'])) {
        $galeri=$_GET['galeri'];
        $galeri_path="../../assets/img/Galeri/$galeri";
        if (is_readable($galeri_path)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $galeri_path);
            finfo_close($finfo);
            // Set header untuk jenis gambar
            header('Content-Type: ' . $mimeType);
            header('Content-Disposition: inline; filename="'.$galeri.'"');

            // Baca dan kirimkan konten gambar
            readfile($galeri_path);
            exit;
        }else{
            echo "Gambar Tidak Terbaca";
        }
    }
?>