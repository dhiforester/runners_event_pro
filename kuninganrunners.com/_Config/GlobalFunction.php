<?php
    function formatRupiah($angka) {
        return "Rp " . number_format($angka, 0, ',', '.');
    }
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
    function WebMediaSosial($url_server,$xtoken){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Web/Medsos.php',
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
    function WebGaleri($url_server,$xtoken,$album){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Web/Galeri.php?album='.$album.'',
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
    function WebListEvent($url_server,$xtoken){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Event/ListEvent.php',
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
    function WebListAllEvent($url_server,$xtoken){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Event/AllEvent.php',
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
    function DetailEvent($url_server,$xtoken,$id_event){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Event/DetailEvent.php?id='.$id_event.'',
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
    //Riwayat Event Member
    function RiwayatEventMember($url_server,$xtoken,$email,$id_member_login){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Event/RiwayatPendaftaran.php',
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
    //Detail Event Peserta
    function DetailEventPeserta($url_server,$xtoken,$id_event_peserta){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Event/DetailPendaftaranEvent.php?id='.$id_event_peserta.'',
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
    function ListAssesment($url_server,$xtoken,$id_event){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Assesment/FormAssesment.php?id='.$id_event.'',
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
    //Detail Assesment
    function DetailAssesment($url_server,$xtoken,$id_event_assesment_form,$id_event_peserta){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Assesment/DetailAssesment.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "id_event_assesment_form" : "'.$id_event_assesment_form.'",
            "id_event_peserta" : "'.$id_event_peserta.'"
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
    //Detail Transaksi By ID Peserta
    function DetailTransaksiPeserta($url_server,$xtoken,$email,$id_member_login,$id_event_peserta){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Payment/TransaksiByIdPeserta.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "email" : "'.$email.'",
            "id_member_login" : "'.$id_member_login.'",
            "id_event_peserta" : "'.$id_event_peserta.'"
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
    //Buat Snap Token
    function GenerateSnapToken($url_server,$xtoken,$email,$id_member_login,$id_event_peserta){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Payment/GenerateSnapToken.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "email" : "'.$email.'",
            "id_member_login" : "'.$id_member_login.'",
            "id_event_peserta" : "'.$id_event_peserta.'"
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
    function WebListBarang($url_server,$xtoken,$limit,$page,$OrderBy,$ShortBy){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Merchandise/ListMerchandise.php?limit='.$limit.'&page='.$page.'&OrderBy='.$OrderBy.'&ShortBy='.$ShortBy.'',
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
    function WebListMember($url_server,$xtoken,$limit,$page,$OrderBy,$ShortBy){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Member/ListMember.php?limit='.$limit.'&page='.$page.'&OrderBy='.$OrderBy.'&ShortBy='.$ShortBy.'',
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
    function WebListVidio($url_server,$xtoken,$limit,$page,$OrderBy,$ShortBy){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Vidio/ListVidio.php?limit='.$limit.'&page='.$page.'&OrderBy='.$OrderBy.'&ShortBy='.$ShortBy.'',
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
    function WebDetailVidio($url_server,$xtoken,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_server.'/_Api/Vidio/DetailVidio.php?id='.$id.'',
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
    function resizeImage($file, $new_width, $new_height) {
        // Cek format gambar dan buat resource gambar
        $image_info = getimagesize($file);
        $mime_type = $image_info['mime'];
    
        if ($mime_type == 'image/jpeg') {
            $source_image = imagecreatefromjpeg($file);
        } elseif ($mime_type == 'image/png') {
            $source_image = imagecreatefrompng($file);
        } elseif ($mime_type == 'image/gif') {
            $source_image = imagecreatefromgif($file);
        } else {
            die("Format gambar tidak didukung");
        }
    
        // Ukuran asli gambar
        $original_width = imagesx($source_image);
        $original_height = imagesy($source_image);
    
        // Membuat gambar baru dengan ukuran yang diinginkan
        $resized_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($resized_image, $source_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
    
        // Menyimpan gambar ke output buffer
        ob_start();
        imagejpeg($resized_image);
        $image_data = ob_get_contents();
        ob_end_clean();
    
        // Hapus resource gambar untuk menghemat memori
        imagedestroy($source_image);
        imagedestroy($resized_image);
    
        // Mengonversi gambar ke format base64
        return base64_encode($image_data);
    }
    //Sensor Email
    function SensorEmail($email) {
        // Pisahkan bagian username dan domain
        list($username, $domain) = explode("@", $email);

        // Ambil 2 huruf awal dari username dan gabungkan dengan **
        $masked_username = substr($username, 0, 2) . '**';

        // Gabungkan dengan domain untuk menghasilkan email yang dimodifikasi
        $masked_email = $masked_username . '@' . $domain;
        return $masked_email;
    }
    //Sensor Kontak
    function SensorKontak($kontak) {
       // Ambil panjang nomor kontak
        $length = strlen($kontak);
        // Ganti 3 digit terakhir dengan ***
        $masked_kontak = substr($kontak, 0, $length - 3) . '***';
        return $masked_kontak;
    }
?>