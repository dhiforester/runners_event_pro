<?php
    //Zona Waktu
    date_default_timezone_set("Asia/Jakarta");
    session_start();
    include "_Config/Connection.php";
    //Memanggil xtoken pertama kali
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
    //Apabila Terjadi kesalahan Pada CURL
    if ($curl_error) {
        $xtoken ="";
        $datetime_expired ="";
        echo 'Curl error: ' . $curl_error;
    }else{
        //Apabila Response Bukan JSON
        $arry_res = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $xtoken ="";
            $datetime_expired ="";
            echo 'Invalid JSON response: ' . $response;
        }else{
            //Apabila Otentifikasi token tidak valid
            if($arry_res['response']['code']!==200) {
                $xtoken ="";
                $datetime_expired ="";
                $message = $arry_res['response']['message'];
                echo 'Terjadi kesalahan pada saat update data pengaturan ke server (Keterangan: ' . $message . ')';
            }else{
                //Apabila Berhasil
                $metadata = $arry_res['metadata'];
                $datetime_expired = $metadata['datetime_expired'];
                $xtoken = $metadata['x-token'];
            }
        }
    }
    curl_close($curl);
    if(!empty($xtoken)){
        //Apabila X-token berhasil dibuat simpan dalam session
        $_SESSION['datetime_expired'] = $datetime_expired;
        $_SESSION['xtoken'] = $xtoken;
        //Rekam Log Halaman
        include "_Config/SendLogViewer.php";
        if($ValidasiSimpanLog!=="Valid"){
            echo $ValidasiSimpanLog;
        }else{
            include "_Config/GlobalFunction.php";
            //Membuka Web Setting Dari Server
            $WebSetting=WebSetting($url_server,$xtoken);
            $WebSetting = json_decode($WebSetting, true);
            $title_web=ShowTrueContent($WebSetting['metadata']['title']);
            $description_web=ShowTrueContent($WebSetting['metadata']['description']);
            $keyword_web=ShowTrueContent($WebSetting['metadata']['keyword']);
            $author_web=ShowTrueContent($WebSetting['metadata']['x-author']);
            $icon_web=ShowTrueContent($WebSetting['metadata']['icon']);
            $pavicon_web=ShowTrueContent($WebSetting['metadata']['pavicon']);
            $tentang_judul=ShowTrueContent($WebSetting['metadata']['tentang']['judul']);
            $tentang_preview=$WebSetting['metadata']['tentang']['preview'];
            //Kontak
            $kontak_alamat=ShowTrueContent($WebSetting['metadata']['kontak']['alamat']);
            $kontak_email=ShowTrueContent($WebSetting['metadata']['kontak']['email']);
            $kontak_telepon=ShowTrueContent($WebSetting['metadata']['kontak']['telepon']);
?>
    <!DOCTYPE html>
    <html lang="en">
        <?php
            include "_Partial/Head.php";
        ?>
        <body>
            <?php
                include "_Partial/Header.php";
            ?>
            <main class="main">
                <?php
                    if(empty($_GET['Page'])){
                        include "_Page/Home/Home.php";
                        include "_Page/Home/ModalHome.php";
                    }else{
                        $Page=$_GET['Page'];
                        if($Page=="Login"){
                            include "_Page/Login/Login.php";
                        }else if($Page=="LoginBerhasil"){
                            include "_Page/Login/LoginBerhasil.php";
                        }else if($Page=="Pendaftaran"){
                            include "_Page/Pendaftaran/Pendaftaran.php";
                        }else if($Page=="Pendaftaran-Berhasil"){
                            include "_Page/Pendaftaran/Pendaftaran-Berhasil.php";
                        }else if($Page=="VerifikasiPendaftaran"){
                            include "_Page/Pendaftaran/VerifikasiPendaftaran.php";
                        }else if($Page=="Selesai"){
                            include "_Page/Pendaftaran/Selesai.php";
                        }else if($Page=="ResetPassword"){
                            include "_Page/ResetPassword/ResetPassword.php";
                        }else if($Page=="Album"){
                            include "_Partial/Album.php";
                        }else if($Page=="Profil"){
                            include "_Page/Profil/Profil.php";
                            include "_Page/Profil/ModalProfil.php";
                        }else if($Page=="UbahPassword"){
                            include "_Page/ResetPassword/UbahPassword.php";
                        }else if($Page=="PermintaanResetPasswordBerhasil"){
                            include "_Page/ResetPassword/PermintaanResetPasswordBerhasil.php";
                        }else if($Page=="UbahPasswordBerhasil"){
                            include "_Page/ResetPassword/UbahPasswordBerhasil.php";
                        }else if($Page=="DetailEvent"){
                            include "_Page/Event/DetailEvent.php";
                            include "_Page/Event/ModalEvent.php";
                        }else if($Page=="RiwayatEvent"){
                            include "_Page/Event/RiwayatEvent.php";
                            include "_Page/Event/ModalEvent.php";
                        }else if($Page=="DetailPendaftaranEvent"){
                            include "_Page/Event/DetailPendaftaranEvent.php";
                            include "_Page/Event/ModalEvent.php";
                        }else if($Page=="Galeri"){
                            include "_Page/Galeri/Galeri.php";
                        }
                    }
                    include "_Partial/Modal.php";
                ?>
                <!-- Footer Section -->
                <section id="footer_section" class="footer_section section dark-background mt-4">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalPrivacyPolicy">
                                <small>Privacy Policy</small>
                            </a>
                            |
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalTermOfService">
                                <small>Term Of Service</small>
                            </a>
                        </div>
                        <div class="col-md-12 text-center">
                            <span>Copyright</span> <strong><?php echo $title_web; ?></strong> <span>All Rights Reserved</span>
                            <div class="credits">
                                Designed by <a href="https://parasilva.tech/"><?php echo $author_web; ?></a>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
            <footer id="footer" class="footer dark-background">
                <!-- <p>
                    <div class="social-links d-flex justify-content-center">
                        <a href="https://www.instagram.com/kuningan_runners/">
                        <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://linktr.ee/KNGR?fbclid=PAZXh0bgNhZW0CMTEAAaaaMCMp47B3nqIHA4cpm1ZgSVx04ZL6fVMJKjrfrDMuzKiALXxNx4wiGVY_aem_yglyOzhYjlAq9p97WqygXw">
                        <i class="bi bi-link"></i>
                        </a>
                        <a href="https://www.strava.com/clubs/kuninganrunners">
                        <i class="bi bi-strava"></i>
                        </a>
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLScUG4JZmxnAbXVo6z9xOBxhSzLny73d3t96qko0M1ngELRrkA/viewform">
                        <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </p> -->
                
            </footer>
            <!-- Scroll Top -->
            <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
            <!-- Preloader -->
            <div id="preloader"></div>
            <!-- Vendor JS Files -->
            <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="assets/vendor/php-email-form/validate.js"></script>
            <script src="assets/vendor/aos/aos.js"></script>
            <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
            <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
            <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
            <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
            <script src="assets/js/main.js"></script>
            <?php
                //script jquery berdasarkan halaman (page)
                if(empty($_GET['Page'])){
                    echo '<script src="_Page/Home/Home.js"></script>';
                }else{
                    if($_GET['Page']=="Login"){
                        echo '<script src="_Page/Login/Login.js"></script>';
                    }else{
                        if($_GET['Page']=="Pendaftaran"||$_GET['Page']=="Pendaftaran-Berhasil"){
                            echo '<script src="_Page/Pendaftaran/Pendaftaran.js"></script>';
                        }else{
                            if($_GET['Page']=="VerifikasiPendaftaran"){
                                echo '<script src="_Page/Pendaftaran/Pendaftaran.js"></script>';
                            }else{
                                if($_GET['Page']=="ResetPassword"||$_GET['Page']=="UbahPassword"){
                                    echo '<script src="_Page/ResetPassword/ResetPassword.js"></script>';
                                }else{
                                    if($_GET['Page']=="Profil"){
                                        echo '<script src="_Page/Profil/Profil.js"></script>';
                                    }else{
                                        if($_GET['Page']=="DetailEvent"||$_GET['Page']=="DetailPendaftaranEvent"){
                                            echo '<script src="_Page/Event/Event.js"></script>';
                                        }else{
                                            if($_GET['Page']=="Galeri"){
                                                echo '<script src="_Page/Galeri/Galeri.js"></script>';
                                            }else{
                                                
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                echo '<script src="_Partial/Global.js"></script>';
            ?>
        </body>
    </html>
<?php 
    } 
} 
?>