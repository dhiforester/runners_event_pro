<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'R3qMqa8o0yYCvLIaGdn');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        if(empty($_GET['Sub'])){
            include "_Page/Event/EventHome.php";
        }else{
            $Sub=$_GET['Sub'];
            if($Sub=="DetailEvent"){
                include "_Page/Event/DetailEvent.php";
            }else{
                if($Sub=="DetailPeserta"){
                    include "_Page/Event/DetailPeserta.php";
                }else{
                    
                }
            }
        }
    }
?>