<?php
    //Ini adalah service API untuk mengirim email 
    //Panggil semua fungsi mailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    require 'mail/src/Exception.php';
    require 'mail/src/PHPMailer.php';
    require 'mail/src/SMTP.php';
    //Tangkap Data Post
	$fp = fopen('php://input', 'r');
	$raw = stream_get_contents($fp);
	$Tangkap = json_decode($raw,true);
    if(empty($Tangkap['subjek'])){
        $Array = Array (
            "code" => "201",
            "pesan" => "subjek Tidak Boleh Kosong",
        );
    }else{
        if(empty($Tangkap['email_asal'])){
            $Array = Array (
                "code" => "201",
                "pesan" => "Email Asal Tidak Boleh Kosong",
            );
        }else{
            if(empty($Tangkap['password_email_asal'])){
                $Array = Array (
                    "code" => "201",
                    "pesan" => "Email Asal Tidak Boleh Kosong",
                );
            }else{
                 if(empty($Tangkap['url_provider'])){
                    $Array = Array (
                        "code" => "201",
                        "pesan" => "URL Provider Tidak Boleh Kosong",
                    );
                }else{
                    if(empty($Tangkap['nama_pengirim'])){
                        $Array = Array (
                            "code" => "201",
                            "pesan" => "Nama Pengirim Tidak Boleh Kosong",
                        );
                    }else{
                        if(empty($Tangkap['email_tujuan'])){
                            $Array = Array (
                                "code" => "201",
                                "pesan" => "Nama Pengirim Tidak Boleh Kosong",
                            );
                        }else{
                            if(empty($Tangkap['nama_tujuan'])){
                                $Array = Array (
                                    "code" => "201",
                                    "pesan" => "Nama Pengirim Tidak Boleh Kosong",
                                );
                            }else{
                                if(empty($Tangkap['port'])){
                                    $Array = Array (
                                        "code" => "201",
                                        "pesan" => "Port SMTP Tidak Boleh Kosong",
                                    );
                                }else{
                                    if(empty($Tangkap['pesan'])){
                                        $Array = Array (
                                            "code" => "201",
                                            "pesan" => "Isi Pesan Tidak Boleh Kosong",
                                        );
                                    }else{
                                        $subjek=$Tangkap['subjek'];
                                        $email_asal=$Tangkap['email_asal'];
                                        $password_email_asal=$Tangkap['password_email_asal'];
                                        $url_provider=$Tangkap['url_provider'];
                                        $nama_pengirim=$Tangkap['nama_pengirim'];
                                        $email_tujuan=$Tangkap['email_tujuan'];
                                        $nama_tujuan=$Tangkap['nama_tujuan'];
                                        $pesan=$Tangkap['pesan'];
                                        $port=$Tangkap['port'];
                                        //Create an instance; passing `true` enables exceptions
                                        $mail = new PHPMailer(true);
                                        try {
                                            //Server settings
                                            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                                            $mail->isSMTP();                                            //Send using SMTP
                                            $mail->Host       = ''.$url_provider.'';                     //Set the SMTP server to send through
                                            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                            $mail->Username   = ''.$email_asal.'';                     //SMTP username
                                            $mail->Password   = ''.$password_email_asal.'';                               //SMTP password
                                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                                            $mail->Port       = ''.$port.'';                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                            //Recipients
                                            $mail->setFrom(''.$email_asal.'', ''.$nama_pengirim.'');
                                            $mail->addAddress(''.$email_tujuan.'', ''.$nama_tujuan.'');     //Add a recipient

                                            // //Attachments
                                            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                                            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                                            //Content
                                            $mail->isHTML(true);                                  //Set email format to HTML
                                            $mail->Subject = ''.$subjek.'';
                                            $mail->Body    = ''.$pesan.'';
                                            $mail->AltBody = ''.$pesan.'';
                                            if($mail->send()){
                                                $Array = Array (
                                                    "code" => "200",
                                                    "pesan" => "Email Terkirim",
                                                );
                                            }else{
                                                $Array = Array (
                                                    "code" => "201",
                                                    "pesan" => "Email Tidak Terkirim",
                                                );
                                            }
                                        } catch (Exception $e) {
                                            $Array = Array (
                                                "code" => "201",
                                                "pesan" => "$e",
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    $json = json_encode($Array, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    // header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (10 * 60)));
    // header("Cache-Control: no-store, no-cache, must-revalidate");
    // header('Content-Type: application/json');
    // header('Pragma: no-chache');
    // header('Access-Control-Allow-Origin: *');
    // header('Access-Control-Allow-Credentials: true');
    // header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 
    // header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, x-token, token"); 
    echo $json;
?>