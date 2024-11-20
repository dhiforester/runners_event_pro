<?php
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    if (isset($_GET['vidio'])) {
        $vidio=$_GET['vidio'];
        $vidio_path="$base_url/assets/img/Vidio/$vidio";
        // Set header untuk video
        header('Content-Type: video/mp4');
        header('Content-Disposition: inline; filename="'.$vidio.'"');
        // Baca dan kirimkan konten video
        readfile($vidio_path);
        exit;
    }
?>