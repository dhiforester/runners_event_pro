<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            //Koneksi
            include "_Config/Connection.php";
            include "_Config/SettingGeneral.php";
            $Page="Login";
            include "_Partial/Head.php";
            if(!empty($_GET['Notifikasi'])){
                $Notifikasi=$_GET['Notifikasi'];
            }else{
                $Notifikasi="";
            }
        ?>
    </head>
    <body>
        <main class="login_background">
            <div class="container">
                <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="pb-2 text-center">
                                            <img src="assets/img/<?php echo "$logo"; ?>" alt="" width="200px">
                                            <h5 class="card-title text-center pb-0 fs-4">Login Ke Akun Anda</h5>
                                            <p class="text-center small">Masukan Email Dan Password Untuk Melakukan Login</p>
                                        </div>
                                        <form action="javascript:void(0);" class="row g-3" id="ProsesLogin">
                                            <div class="col-12">
                                                <label for="email" class="form-label">Email</label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend">
                                                        <i class="bi bi-envelope"></i>
                                                    </span>
                                                    <input type="email" name="email" class="form-control" id="email" required>
                                                    <div class="invalid-feedback">Silahkan masukan email anda</div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="password" class="form-label">Password</label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend">
                                                        <i class="bi bi-key"></i>
                                                    </span>
                                                    <input type="password" name="password" class="form-control" id="password" required>
                                                    <div class="invalid-feedback">Silahkan masukan password anda</div>
                                                </div>
                                                <small class="credit">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="Tampilkan" id="TampilkanPassword2" name="TampilkanPassword2">
                                                        <label class="form-check-label" for="TampilkanPassword2">
                                                            Tampilkan Password
                                                        </label>
                                                    </div>
                                                </small>
                                            </div>
                                            <div class="col-12">
                                                Pastikan email dan password sudah benar.
                                            </div>
                                            <div class="col-12 mb-2" id="NotifikasiLogin"></div>
                                            <div class="col-12">
                                                <button class="btn btn-primary w-100" type="submit">
                                                    <i class="bi bi-check-circle"></i> Login
                                                </button>
                                            </div>
                                            <!-- <div class="col-12">
                                                <a href="Pendaftaran.php" class="btn btn-warning w-100">
                                                    Daftar
                                                </a>
                                            </div> -->
                                            <div class="col-12">
                                                <p class="small mb-0">Anda Lupa Password? <a href="LupaPassword.php">Reset password</a></p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
    </main>
        <?php
            include "_Partial/FooterJs.php";
            include "_Partial/RoutingJs.php";
            echo '<script type="text/javascript" src="_Page/Login/Login.js"></script>';
        ?>
        <script>
            //Kondisi saat tampilkan password
            $('#TampilkanPassword2').click(function(){
                if($(this).is(':checked')){
                    $('#password').attr('type','text');
                }else{
                    $('#password').attr('type','password');
                }
            });
        </script>
    </body>
</html>