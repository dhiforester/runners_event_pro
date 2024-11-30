<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            //Koneksi
            include "_Config/Connection.php";
            include "_Config/SettingGeneral.php";
            include "_Partial/Head.php";
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
                                            <h5 class="card-title text-center pb-0 fs-4">Lupa Password</h5>
                                            <p class="text-center small">
                                                Kami akan mengirimkan tautan ke email untuk mengatur ulang password anda. 
                                                Tautan tersebut hanya berlaku 1 jam setelah dikirim.
                                            </p>
                                        </div>
                                        <form action="javascript:void(0);" class="row g-3" id="ProsesLupaPassword">
                                            <div class="col-12">
                                                <label for="email" class="form-label">Masukan Email</label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend">
                                                        <i class="bi bi-envelope"></i>
                                                    </span>
                                                    <input type="email" name="email" class="form-control" id="email" required>
                                                    <div class="invalid-feedback">Silahkan masukan email anda</div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                Pastikan email yang anda masukan sudah benar.
                                            </div>
                                            <div class="col-12 mb-2" id="NotifikasiLupaPassword">
                                                <!-- Notifikasi Proses Dan error Akan Muncul Disini -->
                                            </div>
                                            <div class="col-12 mb-2">
                                                <button class="btn btn-md btn-primary w-100" type="submit" id="ButtonLupaPassword">
                                                    <i class="bi bi-send"></i> Kirim Tautan
                                                </button>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <a href="Login.php" class="btn btn-md btn-dark w-100">
                                                    <i class="bi bi-arrow-left-circle"></i> Kembali
                                                </a>
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
        ?>
        <script>
            $(document).ready(function() {
                $('#ProsesLupaPassword').on('submit', function(e) {
                    e.preventDefault();
                    // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
                    $('#ButtonLupaPassword').html('<i class="bi bi-send"></i> Loading..').prop('disabled', true);
                    // Membuat objek FormData
                    var formData = new FormData(this);
                    // Mengirim data melalui AJAX
                    $.ajax({
                        url             : '_Page/LupaPassword/ProsesLupaPassword.php',
                        type            : 'POST',
                        data            : formData,
                        contentType     : false,
                        processData     : false,
                        dataType        : 'json',
                        success: function(response) {
                            if (response.success) {
                                // Jika sukses, kembalikan tombol ke semula
                                $('#NotifikasiLupaPassword').html('');
                                $('#ButtonLupaPassword').html('<i class="bi bi-send"></i> Kirim Tautan').prop('disabled', false);
                                Swal.fire('Berhasil!', 'Tautan berhasil dikirim, silahkan periksa inbox email anda!', 'success');
                            } else {
                                // Jika gagal, tampilkan notifikasi error
                                $('#NotifikasiLupaPassword').html('<div class="alert alert-danger">' + response.message + '</div>');
                                $('#ButtonLupaPassword').html('<i class="bi bi-send"></i> Kirim Tautan').prop('disabled', false);
                            }
                        },
                        error: function() {
                            // Jika terjadi error pada request
                            $('#NotifikasiLupaPassword').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                            $('#ButtonLupaPassword').html('<i class="bi bi-send"></i> Kirim Tautan').prop('disabled', false);
                        }
                    });
                });
            });
        </script>
    </body>
</html>