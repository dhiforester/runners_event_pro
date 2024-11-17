<?php
    //routing Halaman
    if(empty($_GET['album'])){
        //Apabila Nama Album Kosong
        include "_Page/Galeri/ListAlbum.php";
    }else{
        $album=$_GET['album'];
        include "_Page/Galeri/ListGaleri.php";
    }
?>