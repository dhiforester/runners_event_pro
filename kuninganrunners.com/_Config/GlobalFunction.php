<?php
    function validateAndSanitizeInput($input) {
        // Menghapus karakter yang tidak diinginkan
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        $input = addslashes($input);
        return $input;
    }
    function ShowTrueContent($input) {
        $input =stripslashes($input);
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');;
        return $input;
    }
    function WebSetting($url_server,$xtoken){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Web/Setting.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'x-token: '.$xtoken.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function GenerateXtoken($url_server,$user_key_server,$password_server,$limit){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/GenerateToken/GenerateToken.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "user_key_server" : "'.$user_key_server.'",
            "password_server" : "'.$password_server.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        $curl_error = curl_error($curl);
        if ($curl_error) {
            $response=$curl_error;
        }
        curl_close($curl);
        return $response;
    }
    function WebAlbum($url_server,$xtoken,$page,$limit){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Web/Album.php?limit='.$limit.'&page='.$page.'',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'x-token: '.$xtoken.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function WebTestimoni($url_server,$xtoken,$page,$limit){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Web/Testimoni.php?limit='.$limit.'&page='.$page.'',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'x-token: '.$xtoken.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function WebDetailTestimoni($url_server,$xtoken,$id_web_testimoni){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Web/TestimoniDetail.php?id='.$id_web_testimoni.'',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'x-token: '.$xtoken.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function WebFaq($url_server,$xtoken){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Web/FAQ.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'x-token: '.$xtoken.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function WebPrivacyPolicy($url_server,$xtoken){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Web/PrivacyPolicy.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'x-token: '.$xtoken.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function WebTermOfService($url_server,$xtoken){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Web/TermOfService.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'x-token: '.$xtoken.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
?>