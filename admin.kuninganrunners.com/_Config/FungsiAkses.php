<?php
    $SessionNama=GetDetailData($Conn,'akses','id_akses',$SessionIdAkses,'nama_akses');
    $SessionKontakAkses=GetDetailData($Conn,'akses','id_akses',$SessionIdAkses,'kontak_akses');
    $SessionEmailAkses=GetDetailData($Conn,'akses','id_akses',$SessionIdAkses,'email_akses');
    $SessionGambar=GetDetailData($Conn,'akses','id_akses',$SessionIdAkses,'image_akses');
    $SessionLevelAkses=GetDetailData($Conn,'akses','id_akses',$SessionIdAkses,'akses');
    $SessionDatetimeDaftar=GetDetailData($Conn,'akses','id_akses',$SessionIdAkses,'datetime_daftar');
    $SessionDatetimeUpdate=GetDetailData($Conn,'akses','id_akses',$SessionIdAkses,'datetime_update');
    $SessionAkses=$SessionModeAkses;
    if(empty($SessionGambar)){
        $SessionGambar="No-Image.png";
    }
?>