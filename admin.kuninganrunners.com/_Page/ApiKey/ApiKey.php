<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'gd7YgKyL1WMQctJLgaq');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        //Routing Sub Page
        if(empty($_GET['Sub'])){
            include "_Page/ApiKey/ApiKeyHome.php";
        }else{
            $Sub=$_GET['Sub'];
            if($Sub=="Detail"){
                include "_Page/ApiKey/DetailApiKey.php";
            }
        }
    }
?>