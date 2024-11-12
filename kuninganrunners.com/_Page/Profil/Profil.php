<!-- Page Title -->
<div class="sub-page-title dark-background">
    <!-- <div class="row">
        <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">
            <img src="assets/img/login.png" alt="" width="100%">
        </div>
    </div> -->
</div>
<!-- End Page Title -->
<?php
    //Sebelum Menampilkan Halaman Login, Lakukan Validasi Terhadap Session id_member_login
    //Apabila Session Tidak Ada
    if(empty($_SESSION['id_member_login'])&&empty($_SESSION['id_member_login'])){
        include "_Page/Profil/no_access_member.php";
    }else{
        //Apabila Session Sudah Expired
        if($_SESSION['login_expired']<date('Y-m-d H:i:s')){
            include "_Page/Profil/no_access_member.php";
        }else{
           //Perpanjang Session Akses Member
            $email_member=$_SESSION['email'];
            $id_member_login=$_SESSION['id_member_login'];
            $UpdateSessionMemberLogin=UpdateSessionMemberLogin($url_server,$xtoken,$email_member,$id_member_login);
            $response=json_decode($UpdateSessionMemberLogin,true);
            //Apabila Terjadi Kesalahan Pada Saat Memperpanjang Session
            if($response['response']['code']!==200){
                echo '<section id="service-details mt-5" class="service-details section">';
                echo '  <div class="container">';
                echo '      <div class="row gy-5">';
                echo '          <div class="col-md-4"></div>';
                echo '              <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">';
                echo '                  <div class="service-box">';
                echo '                      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo '                          <small>';
                echo '                              '.$response['response']['message'].'';
                echo '                          </small>';
                echo '                      </div>';
                echo '                  </div>';
                echo '              </div>';
                echo '          <div class="col-md-4"></div>';
                echo '      </div>';
                echo '  </div>';
                echo '</section>';
            }else{
                $new_expired_date=$response['metadata']['datetime_expired'];
                $_SESSION['login_expired']=$new_expired_date;
                //Apabila Berhasil Tampilkan Profil
                include "_Page/Profil/DetailProfil.php";
            }
        }
    }
?>

