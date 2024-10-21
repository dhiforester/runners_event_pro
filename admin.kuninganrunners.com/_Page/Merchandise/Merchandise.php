<?php
    if(empty($_GET['Sub'])){
        include "_Page/Merchandise/MerchandiseHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="DetailMerchandise"){
            include "_Page/Merchandise/DetailMerchandise.php";
        }else{
            include "_Page/Merchandise/MerchandiseHome.php";
        }
    }
?>