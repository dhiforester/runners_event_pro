<?php
    //Koneksi Dan Setting General
    include "_Config/Connection.php";
    include "_Config/GlobalFunction.php";
    include "_Config/SettingGeneral.php";
    
    //Zona Waktu
    date_default_timezone_set("Asia/Jakarta");
    $datetime_now = date('Y-m-d H:i:s');
    //Validasi Apakah Email Dan Token Ada
    if(empty($_GET['email'])){
        echo "Email Tidak Boleh Kosong!";
    }else{
        if(empty($_GET['token'])){
            echo "Token Tidak Boleh Kosong!";
        }else{
            $email=$_GET['email'];
            $token=$_GET['token'];
            //Bersihkan Variabel
            $email = validateAndSanitizeInput($_GET["email"]);
            $token = validateAndSanitizeInput($_GET["token"]);
            
            //Apakah Email Ada Pada Database Akses
            $id_akses=GetDetailData($Conn,'akses','email_akses',$email,'id_akses');
            if(empty($id_akses)){
                echo "Email yang anda masukan tidak ada pada database kami!";
            }else{
            
                $ussed=0;
                //Validasi Email
                $stmt = $Conn->prepare("SELECT * FROM akses_validasi WHERE id_akses = ? AND ussed = ?");
                $stmt->bind_param("si", $id_akses, $ussed);
                $stmt->execute();
                $result = $stmt->get_result();
                $DataAkses = $result->fetch_assoc();
                if(!$DataAkses){
                    echo "Token Yang Anda Gunakan Tidak Valid!";
                }else{
                    $kode_rahasia=$DataAkses['kode_rahasia'];
                    $datetime_expired=$DataAkses['datetime_expired'];
                    $kode_rahasia=md5($kode_rahasia);
                    if($kode_rahasia!==$token){
                        echo "Token Tidak Valid!";
                    }else{
                        if($datetime_now>$datetime_expired){
                            echo "Token Sudah Expired!";
                        }else{
?>
                        <!DOCTYPE html>
                        <html lang="en">
                            <head>
                                <?php
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
                                                                    <h5 class="card-title text-center pb-0 fs-4">Buat Password Baru</h5>
                                                                    <p class="text-center small">
                                                                        Buat password baru yang mungkin mudah diingat oleh anda.
                                                                    </p>
                                                                </div>
                                                                <form action="javascript:void(0);" class="row g-3" id="ProsesResetPassword">
                                                                    <input type="hidden" name="email_akses" value="<?php echo $email; ?>">
                                                                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                                                                    <div class="col-12">
                                                                        <label for="password1" class="form-label">
                                                                            <small>Masukan Password</small>
                                                                        </label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text" id="inputGroupPrepend">
                                                                                <small>
                                                                                    <i class="bi bi-key"></i>
                                                                                </small>
                                                                            </span>
                                                                            <input type="password" name="password1" id="password1" class="form-control">
                                                                            <span class="input-group-text" id="inputGroupPrepend">
                                                                                <small>
                                                                                    <code class="text text-dark" id="password1_length">0/20</code>
                                                                                </small>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="password2" class="form-label">
                                                                            <small>Ulangi Password</small>
                                                                        </label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text" id="inputGroupPrepend">
                                                                                <small>
                                                                                    <i class="bi bi-key"></i>
                                                                                </small>
                                                                            </span>
                                                                            <input type="password" name="password2" id="password2" class="form-control">
                                                                        </div>
                                                                        <small class="credit">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" value="Tampilkan" id="TampilkanPassword" name="TampilkanPassword">
                                                                                <label class="form-check-label" for="TampilkanPassword">
                                                                                    <code class="text text-grayish">Tampilkan Password</code>
                                                                                </label>
                                                                            </div>
                                                                        </small>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <small class="credit">
                                                                            Password terdiri dari 6-20 karakter angka dan huruf
                                                                        </small>
                                                                    </div>
                                                                    <div class="col-12 mb-2" id="NotifikasiResetPassword">
                                                                        <!-- Notifikasi Proses Dan error Akan Muncul Disini -->
                                                                    </div>
                                                                    <div class="col-12 mb-2">
                                                                        <button class="btn btn-md btn-primary w-100" type="submit" id="ButtonResetPassword">
                                                                            <i class="bi bi-save"></i> Simpan Password
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
                                    var password1_max_length = 20;
                                    var password2_max_length = 20;
                                    // Fungsi untuk membatasi input hanya pada huruf dan spasi
                                    function updateCharCountPasswordAkses1() {
                                        var charCount = $('#password1').val().length;
                                        $('#password1_length').text(charCount + '/' + password1_max_length);
                                    }
                                    function updateCharCountPasswordAkses2() {
                                        var charCount = $('#password2').val().length;
                                        $('#password2_length').text(charCount + '/' + password2_max_length);
                                    }
                                    $(document).ready(function() {
                                        $('#password1').on('input', function() {
                                            var currentValue = $(this).val();
                                            var charCount = currentValue.length;
                                            // Cek apakah jumlah karakter melebihi
                                            if (charCount > password1_max_length) {
                                                // Jika melebihi, batasi input
                                                currentValue = currentValue.substring(0, password1_max_length);
                                            }
                                            // Perbarui nilai input
                                            $('#password1').val(currentValue);
                                            // Update tampilan jumlah karakter
                                            updateCharCountPasswordAkses1();
                                        });
                                        $('#password1').on('change', function() {
                                            var currentValue = $(this).val();
                                            var charCount = currentValue.length;
                                            // Cek apakah jumlah karakter melebihi
                                            if (charCount > password1_max_length) {
                                                // Jika melebihi, batasi input
                                                currentValue = currentValue.substring(0, password1_max_length);
                                            }
                                            // Perbarui nilai input
                                            $('#password1').val(currentValue);
                                            // Update tampilan jumlah karakter
                                            updateCharCountPasswordAkses1();
                                        });
                                        //Kondisi saat tampilkan password
                                        $('.form-check-input').click(function(){
                                            if($(this).is(':checked')){
                                                $('#password1').attr('type','text');
                                                $('#password2').attr('type','text');
                                            }else{
                                                $('#password1').attr('type','password');
                                                $('#password2').attr('type','password');
                                            }
                                        });


                                        $('#ProsesResetPassword').on('submit', function(e) {
                                            e.preventDefault();
                                            // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
                                            $('#ButtonResetPassword').html('<i class="bi bi-send"></i> Loading..').prop('disabled', true);
                                            // Membuat objek FormData
                                            var formData = new FormData(this);
                                            // Mengirim data melalui AJAX
                                            $.ajax({
                                                url: '_Page/LupaPassword/ProsesResetPassword.php',
                                                type: 'POST',
                                                data: formData,
                                                contentType: false,
                                                processData: false,
                                                dataType: 'json',
                                                success: function(response) {
                                                    if (response.success) {
                                                        // Jika sukses, kembalikan tombol ke semula
                                                        $('#NotifikasiResetPassword').html('');
                                                        $('#ButtonResetPassword').html('<i class="bi bi-save"></i> Simpan Password').prop('disabled', false);
                                                        Swal.fire('Berhasil!', 'Password Baru Berhasil Disimpan, Silahkan Lakukan Login.', 'success').then((result) => {
                                                            if (result.isConfirmed || result.dismiss) {
                                                                // Redirect ke halaman Login.php
                                                                window.location.href = 'Login.php';
                                                            }
                                                        });
                                                    } else {
                                                        // Jika gagal, tampilkan notifikasi error
                                                        $('#NotifikasiResetPassword').html('<div class="alert alert-danger">' + response.message + '</div>');
                                                        $('#ButtonResetPassword').html('<i class="bi bi-save"></i> Simpan Password').prop('disabled', false);
                                                    }
                                                },
                                                error: function() {
                                                    // Jika terjadi error pada request
                                                    $('#NotifikasiResetPassword').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                                                    $('#ButtonResetPassword').html('<i class="bi bi-save"></i> Simpan Password').prop('disabled', false);
                                                }
                                            });
                                        });

                                    });
                                </script>
                            </body>
                        </html>
<?php
                        }
                    }
                }
            }
        }
    }
?>