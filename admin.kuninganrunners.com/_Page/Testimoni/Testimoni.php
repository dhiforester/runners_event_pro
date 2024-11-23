<?php
    if(empty($_GET['Sub'])){
        include "_Page/Testimoni/TestimoniHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="Detail"){
            include "_Page/Testimoni/DetailTestimoni.php";
        }
    }
?>