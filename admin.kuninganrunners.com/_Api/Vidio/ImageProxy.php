<?php
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    if (isset($_GET['thumbnail'])) {
        $thumbnail=$_GET['thumbnail'];
        $thumbnail_path="../../assets/img/Vidio/$thumbnail";
        if (is_readable($thumbnail_path)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $thumbnail_path);
            finfo_close($finfo);
            // Set header untuk jenis gambar
            header('Content-Type: ' . $mimeType);
            header('Content-Disposition: inline; filename="'.$thumbnail.'"');

            // Baca dan kirimkan konten gambar
            readfile($thumbnail_path);
            exit;
        }else{
            echo "Gambar Tidak Terbaca";
        }
    }
?>