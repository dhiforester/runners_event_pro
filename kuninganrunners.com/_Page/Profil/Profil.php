<div class="sub-page-title dark-background">
    <!-- Interval Backgroun -->
</div>
<section id="service-details mt-5" class="service-details section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-3">
                <h4>
                    <i class="bi bi-person-circle"></i> Profil Member
                </h4>
                <small>
                    Berikut ini adalah halaman profil member yang memuat semua informasi identitias member.
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-3">

            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="index.php" class="btn btn-sm btn-outline-dark">
                    <i class="bi bi-chevron-left"></i> Kembali Ke Beranda
                </a>
            </div>
        </div>
    </div>
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
                    echo '      <div class="row">';
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
                }else{
                    $new_expired_date=$response['metadata']['datetime_expired'];
                    $_SESSION['login_expired']=$new_expired_date;
                    //Apabila Berhasil Tampilkan Profil
                    include "_Page/Profil/DetailProfil.php";
                }
            }
        }
    ?>
</section>


