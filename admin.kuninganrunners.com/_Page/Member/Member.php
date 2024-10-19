<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'65Wekl5jp7EZAOtWn9P');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        if(empty($_GET['Sub'])){
            include "_Page/Member/MemberHome.php";
        }else{
            $Sub=$_GET['Sub'];
            if($Sub=="DetailMember"){
                include "_Page/Member/DetailMember.php";
            }else{
                
            }
        }
    }
?>