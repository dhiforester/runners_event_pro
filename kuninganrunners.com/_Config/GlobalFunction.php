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
    function GenerateXtoken($url_server,$user_key_server,$password_server){
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
    function ListProvinsi($url_server,$xtoken){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Wilayah/Provinsi.php',
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
    function ListKabupaten($url_server,$xtoken,$id_propinsi){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Wilayah/Kabupaten.php?id_propinsi='.$id_propinsi.'',
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
    function ListKecamatan($url_server,$xtoken,$id_kabupaten){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Wilayah/Kecamatan.php?id_kabupaten='.$id_kabupaten.'',
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
    function ListDesa($url_server,$xtoken,$id_kecamatan){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Wilayah/Desa.php?id_kecamatan='.$id_kecamatan.'',
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
    //Update Session Membver Login
    function UpdateSessionMemberLogin($url_server,$xtoken,$email,$id_member_login){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Member/UpdateSession.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "email" : "'.$email.'",
            "id_member_login" : "'.$id_member_login.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'x-token: '.$xtoken.''
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
    //Detail Profile Member
    function DetailProfilMember($url_server,$xtoken,$email,$id_member_login){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Member/DetailMember.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "email" : "'.$email.'",
            "id_member_login" : "'.$id_member_login.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'x-token: '.$xtoken.''
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
?>