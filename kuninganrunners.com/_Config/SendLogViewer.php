<?php
    // Fungsi untuk mendapatkan OS dari user agent
    function getOS() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_array = [
            'Windows' => 'Windows',
            'Mac' => 'Macintosh',
            'Linux' => 'Linux',
            'Android' => 'Android',
            'iPhone' => 'iPhone',
            'iPad' => 'iPad'
        ];
        
        foreach ($os_array as $os => $match) {
            if (stripos($user_agent, $match) !== false) {
                return $os;
            }
        }
        return "Unknown OS";
    }

    // Fungsi untuk mendapatkan browser dari user agent
    function getBrowser() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $browser_array = [
            'Chrome' => 'Chrome',
            'Firefox' => 'Firefox',
            'Safari' => 'Safari',
            'Opera' => 'Opera',
            'MSIE' => 'Internet Explorer',
            'Trident' => 'Internet Explorer'
        ];

        foreach ($browser_array as $browser => $match) {
            if (stripos($user_agent, $match) !== false) {
                return $browser;
            }
        }
        return "Unknown Browser";
    }

    // Mendapatkan informasi IP pengunjung
    $visitor_ip = $_SERVER['REMOTE_ADDR'];

    // Mendapatkan URL halaman yang diakses
    $current_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    // Mendapatkan informasi OS dan Browser
    $visitor_os = getOS();
    $visitor_browser = getBrowser();

    // Contoh penyimpanan ke database (sesuaikan koneksi sesuai kebutuhan)
    $curl2 = curl_init();
    curl_setopt_array($curl2, array(
        CURLOPT_URL => ''.$url_server.'/_Api/PageViewer/SendLog.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "page_url":"'.$current_url.'",
            "ip_viewer":"'.$visitor_ip.'",
            "os_viewer":"'.$visitor_os.'",
            "browser_viewer":"'.$visitor_browser.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'x-token: '.$xtoken.'',
            'Content-Type: application/json'
        ),
    ));
    $response = curl_exec($curl2);
    $curl_error = curl_error($curl2);
    if ($curl_error) {
        $ValidasiSimpanLog ='Curl error: ' . $curl_error;
    }else{
        $arry_res = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $ValidasiSimpanLog ='Invalid JSON response: ' . $response;
        }else{
            if($arry_res['response']['code']!==200) {
                $message = $arry_res['response']['message'];
                $ValidasiSimpanLog ='Terjadi kesalahan pada saat mengirim data ke server(Keterangan: ' . $message . ')';
            }else{
                $ValidasiSimpanLog ="Valid";
            }
        }
    }
    curl_close($curl2);
?>
