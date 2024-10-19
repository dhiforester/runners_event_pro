<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'OB8vO1nwIdM5QNBprDt');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        if(empty($_GET['Sub'])){
            include "_Page/RegionalData/RegionalDataHome.php";
        }else{
            $Sub=$_GET['Sub'];
            if($Sub=="Perbaikan"){
                include "_Page/RegionalData/Perbaikan.php";
            }else{
                if($Sub=="Group"){
                    include "_Page/RegionalData/RegionalDataGroup.php";
                }else{
                    include "_Page/RegionalData/RegionalDataHome.php";
                }
            }
        }
    }
?>