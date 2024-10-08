<?php
    //Memanggil Detail Data
    function getDataDetail($Conn,$NamaDb,$NamaParam,$IdParam,$Kolom){
        $QryParam = mysqli_query($Conn,"SELECT * FROM $NamaDb WHERE $NamaParam='$IdParam'")or die(mysqli_error($Conn));
        $DataParam = mysqli_fetch_array($QryParam);
        if(empty($DataParam[$Kolom])){
            $Response="";
        }else{
            $Response=$DataParam[$Kolom];
        }
        return $Response;
    }
    //Membersihkan karakter
    function validateAndSanitizeInput($input) {
        // Menghapus karakter yang tidak diinginkan
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
    //Membuat Token
    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        $charLength = strlen($characters);
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charLength - 1)];
        }
        return $randomString;
    }
    function InsertKodeTransaksi($Conn,$order_id,$kode_transaksi,$JsonLog){
        $entry="INSERT INTO order_transaksi (
            order_id,
            kode_transaksi,
            log_payment
        ) VALUES (
            '$order_id',
            '$kode_transaksi',
            '$JsonLog'
        )";
        $Input=mysqli_query($Conn, $entry);
        if($Input){
            $Response="Berhasil";
        }else{
            $Response="Input Data Gagal";
        }
        return $Response;
    }
    function UpdateKodeTransaksi($Conn, $order_id, $kode_transaksi, $JsonLog){
        $query = "UPDATE order_transaksi SET 
            order_id='$order_id',
            log_payment='$JsonLog'
            WHERE kode_transaksi='$kode_transaksi'";
        $UpdateOrderId = mysqli_query($Conn, $query);
    
        if ($UpdateOrderId) {
            $Response = "Berhasil";
        } else {
            $Response = "Update Data Gagal: " . mysqli_error($Conn); 
            // Menggabungkan pesan error dari MySQL
        }
    
        return $Response;
    }
    //Delete Data
    function DeleteData($Conn,$NamaDb,$NamaParam,$IdParam){
        $HapusData = mysqli_query($Conn, "DELETE FROM $NamaDb WHERE $NamaParam='$IdParam'") or die(mysqli_error($Conn));
        if($HapusData){
            $Response="Success";
        }else{
            $Response="Hapus Data Gagal";
        }
        return $Response;
    }
    //Update Status Transaksi Admin
    function UpdateStatusTransaksiAdmin($api_key,$AdminBaseUrl,$kode_transaksi,$status){
       //Krim data dengan CURL
        $headers = array(
            'Content-Type:Application/x-www-form-urlencoded',         
        );
        //CURL send data
        $arr = array(
            "api_key" => "$api_key",
            "kode_transaksi" => "$kode_transaksi",
            "status" => "$status"
        );
        $json = json_encode($arr);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "$AdminBaseUrl/_API/CallBack/UpdateStatusPembayaran.php");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_TIMEOUT, 3); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $data =json_decode($response, true);
        $Response=$data;
        return $Response;
    }
?>