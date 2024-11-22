<?php
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    if (isset($_GET['foto'])) {
        $foto=$_GET['foto'];
        $foto_path="../../assets/img/Marchandise/$foto";
        if (is_readable($foto_path)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $foto_path);
            finfo_close($finfo);
            // Set header untuk jenis gambar
            header('Content-Type: ' . $mimeType);
            header('Content-Disposition: inline; filename="'.$foto.'"');

            // Baca dan kirimkan konten gambar
            readfile($foto_path);
            exit;
        }else{
            echo "Gambar Tidak Terbaca";
        }
    }
?>