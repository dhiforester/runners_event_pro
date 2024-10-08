<?php
    //Ini adalah halaman untuk melakukan konfigurasi database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "payment_gateway";
    $Conn = new mysqli($servername, $username, $password, $db);
    if ($Conn->connect_error) {
        die("Connection failed: " . $Conn->connect_error);
    }



    //Server Host
    // $servername = "localhost";
    // $username = "u769711720_payment";
    // $password = "&PEMR18s";
    // $db = "u769711720_payment";
    // $Conn = new mysqli($servername, $username, $password, $db);
    // if ($Conn->connect_error) {
    //     die("Connection failed: " . $Conn->connect_error);
    // }
?>