<?php
    if(empty($_GET['Page'])){
        include "_Page/Dashboard/ModalDashboard.php";
    }else{
        $Page=$_GET['Page'];
        if($Page=="Modal"){
            include "_Page/Modal/ModalModal.php";
        }
    }
?>