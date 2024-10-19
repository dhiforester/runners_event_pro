<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Harus Login Terlebih Dulu
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <code>Sesi Login Sudah Berakhir, Silahkan Login Ulang!</code>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Tangkap id_member
        if(empty($_POST['id_member'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <code>ID Member Tidak Boleh Kosong</code>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_member=$_POST['id_member'];
            //Bersihkan Variabel
            $id_member=validateAndSanitizeInput($id_member);
            //Buka data member
            $ValidasiIdMember=GetDetailData($Conn,'member','id_member',$id_member,'id_member');
            if(empty($ValidasiIdMember)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <code>ID Member Tidak Valid Atau Tidak Ditemukan Pada Database</code>';
                echo '  </div>';
                echo '</div>';
            }else{
                $nama=GetDetailData($Conn,'member','id_member',$id_member,'nama');
                $kontak=GetDetailData($Conn,'member','id_member',$id_member,'kontak');
                $email=GetDetailData($Conn,'member','id_member',$id_member,'email');
                $email_validation=GetDetailData($Conn,'member','id_member',$id_member,'email_validation');
                $provinsi=GetDetailData($Conn,'member','id_member',$id_member,'provinsi');
                $kabupaten=GetDetailData($Conn,'member','id_member',$id_member,'kabupaten');
                $kecamatan=GetDetailData($Conn,'member','id_member',$id_member,'kecamatan');
                $desa=GetDetailData($Conn,'member','id_member',$id_member,'desa');
                $kode_pos=GetDetailData($Conn,'member','id_member',$id_member,'kode_pos');
                $rt_rw=GetDetailData($Conn,'member','id_member',$id_member,'rt_rw');
                $datetime=GetDetailData($Conn,'member','id_member',$id_member,'datetime');
                $status=GetDetailData($Conn,'member','id_member',$id_member,'status');
                $sumber=GetDetailData($Conn,'member','id_member',$id_member,'sumber');
?>
            <input type="hidden" name="id_member" value="<?php echo $id_member; ?>">
            <div class="row mb-3 border-1 border-bottom">
                <div class="col-md-12 mb-3">
                    <small>
                        <b>A. Identitias Member</b>
                    </small>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <small>
                                <label for="nama_edit">Nama Member</label>
                            </small>
                        </div>
                        <div class="col col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <i class="bi bi-person"></i>
                                    </small>
                                </span>
                                <input type="text" class="form-control" name="nama" id="nama_edit" value="<?php echo $nama; ?>">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code class="text text-dark" id="nama_edit_length">0/100</code>
                                    </small>
                                </span>
                            </div>
                            <small>
                                <code class="text text-grayish">
                                    <label for="nama_edit">Nama lengkap member</label>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <small>
                                <label for="kontak_edit">Kontak/HP</label>
                            </small>
                        </div>
                        <div class="col col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <i class="bi bi-phone"></i>
                                    </small>
                                </span>
                                <input type="text" class="form-control" name="kontak" id="kontak_edit" placeholder="62" value="<?php echo $kontak; ?>">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code class="text text-dark" id="kontak_edit_length">0/20</code>
                                    </small>
                                </span>
                            </div>
                            <small>
                                <code class="text text-grayish">
                                    <label for="kontak_edit">Nomor HP/WA yang bisa dihubungi</label>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <small>
                                <label for="email_edit">Email</label>
                            </small>
                        </div>
                        <div class="col col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <i class="bi bi-envelope"></i>
                                    </small>
                                </span>
                                <input type="email" class="form-control" name="email" id="email_edit" placeholder="email@domain.com" value="<?php echo $email; ?>">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code class="text text-dark" id="email_edit_length">0/100</code>
                                    </small>
                                </span>
                            </div>
                            <small>
                                <code class="text text-grayish">
                                    <label for="email_edit">Alamat email member yang valid dan dapat dihubungi</label>
                                </code>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3 border-1 border-bottom">
                <div class="col-md-12 mb-3">
                    <small>
                        <b>B. Alamat</b>
                    </small>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <small><label for="provinsi_edit">Provinsi</label></small>
                        </div>
                        <div class="col col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrependProvinsi">
                                    <small>
                                        <i class="bi bi-chevron-down"></i>
                                    </small>
                                </span>
                                <select name="provinsi" id="provinsi_edit" class="form-control">
                                    <option value="">Pilih</option>
                                    <?php
                                        $QryProv = mysqli_query($Conn, "SELECT DISTINCT propinsi FROM wilayah ORDER BY propinsi ASC");
                                        while ($DataProv = mysqli_fetch_array($QryProv)) {
                                            $ListProvinsi= $DataProv['propinsi'];
                                            if($provinsi==$ListProvinsi){
                                                echo '<option selected value="'.$ListProvinsi.'">'.$ListProvinsi.'</option>';
                                            }else{
                                                echo '<option value="'.$ListProvinsi.'">'.$ListProvinsi.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="row mb-3">
                        <div class="col-md-4">
                        <small><label for="kabupaten_edit">Kabupaten/Kota</label></small>
                        </div>
                        <div class="col col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrependKabupaten">
                                    <small>
                                        <i class="bi bi-chevron-down"></i>
                                    </small>
                                </span>
                                <select name="kabupaten" id="kabupaten_edit" class="form-control">
                                    <?php
                                        echo '<option value="">Pilih</option>';
                                        $QryKabupaten = mysqli_query($Conn, "SELECT DISTINCT kabupaten FROM wilayah WHERE propinsi='$provinsi' ORDER BY kabupaten ASC");
                                        while ($DataKabupaten = mysqli_fetch_array($QryKabupaten)) {
                                            if(!empty($DataKabupaten['kabupaten'])){
                                                $ListKabupaten= $DataKabupaten['kabupaten'];
                                                if($kabupaten==$ListKabupaten){
                                                    echo '<option selected value="'.$ListKabupaten.'">'.$ListKabupaten.'</option>';
                                                }else{
                                                    echo '<option value="'.$ListKabupaten.'">'.$ListKabupaten.'</option>';
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="row mb-3">
                        <div class="col-md-4">
                        <small><label for="kecamatan_edit">Kecamatan</label></small>
                        </div>
                        <div class="col col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrependKecamatan">
                                    <small>
                                        <i class="bi bi-chevron-down"></i>
                                    </small>
                                </span>
                                <select name="kecamatan" id="kecamatan_edit" class="form-control">
                                    <?php
                                        echo '<option value="">Pilih</option>';
                                        $QryKecamatan = mysqli_query($Conn, "SELECT DISTINCT kecamatan FROM wilayah WHERE propinsi='$provinsi' AND kabupaten='$kabupaten' ORDER BY kecamatan ASC");
                                        while ($DataKecamatan = mysqli_fetch_array($QryKecamatan)) {
                                            if(!empty($DataKecamatan['kecamatan'])){
                                                $ListKecamatan= $DataKecamatan['kecamatan'];
                                                if($ListKecamatan==$kecamatan){
                                                    echo '<option selected value="'.$ListKecamatan.'">'.$ListKecamatan.'</option>';
                                                }else{
                                                    echo '<option value="'.$ListKecamatan.'">'.$ListKecamatan.'</option>';
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="row mb-3">
                        <div class="col-md-4">
                        <small><label for="desa_edit">Desa/Kelurahan</label></small>
                        </div>
                        <div class="col col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrependDesa">
                                    <small>
                                        <i class="bi bi-chevron-down"></i>
                                    </small>
                                </span>
                                <select name="desa" id="desa_edit" class="form-control">
                                    <?php
                                        echo '<option value="">Pilih</option>';
                                        $QryDesa = mysqli_query($Conn, "SELECT DISTINCT desa FROM wilayah WHERE propinsi='$provinsi' AND kabupaten='$kabupaten' AND kecamatan='$kecamatan' ORDER BY desa ASC");
                                        while ($DataDesa = mysqli_fetch_array($QryDesa)) {
                                            if(!empty($DataDesa['desa'])){
                                                $ListDesa= $DataDesa['desa'];
                                                if($ListDesa==$desa){
                                                    echo '<option selected value="'.$ListDesa.'">'.$ListDesa.'</option>';
                                                }else{
                                                    echo '<option value="'.$ListDesa.'">'.$ListDesa.'</option>';
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="row mb-3">
                        <div class="col-md-4">
                        <small><label for="kode_pos_edit">Kode Pos</label></small>
                        </div>
                        <div class="col col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <i class="bi bi-postcard"></i>
                                    </small>
                                </span>
                                <input type="text" name="kode_pos" id="kode_pos_edit" class="form-control" placeholder="45514" value="<?php echo "$kode_pos"; ?>">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code class="text text-dark" id="kode_pos_edit_length">0/10</code>
                                    </small>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="row mb-3">
                        <div class="col-md-4">
                        <small><label for="rt_rw_edit">RT/RW/Gang</label></small>
                        </div>
                        <div class="col col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <i class="bi bi-map"></i>
                                    </small>
                                </span>
                                <input type="text" name="rt_rw" id="rt_rw_edit" class="form-control" placeholder="RT 20 / RW 04 Jalan Anggrek" value="<?php echo "$rt_rw"; ?>">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code class="text text-dark" id="rt_rw_edit_length">0/50</code>
                                    </small>
                                </span>
                            </div>
                            <small>
                                <code class="text text-grayish">
                                    <label for="rt_rw_edit">Informasi alamat lainnya yang perlu diketahui</label>
                                </code>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 mb-3">
                    <small>
                        <b>C. Status Validasi Akun</b>
                    </small>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <small>
                                <label for="email_validation_edit">Kode Validasi</label>
                            </small>
                        </div>
                        <div class="col col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code class="text text-dark" id="email_validation_edit_length">0/9</code>
                                    </small>
                                </span>
                                <input type="text" class="form-control" name="email_validation" id="email_validation_edit" value="<?php echo "$email_validation"; ?>">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <a href="javascript:void(0);" id="GenerateEmailValidationCodeEdit">
                                        <small>
                                            <code class="text text-primary">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </code>
                                        </small>
                                    </a>
                                </span>
                            </div>
                            <small>
                                <code class="text text-grayish">
                                    <label for="email_validation_edit">
                                        9 Digit kode validasi yang akan dikirim ke email untuk dikonfirmasi pemilik akun
                                    </label>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="row mb-3">
                            <div class="col-md-4">
                            <small><label for="status_edit">Status Validasi</label></small>
                            </div>
                            <div class="col col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        <small>
                                            <i class="bi bi-tag"></i>
                                        </small>
                                    </span>
                                    <select name="status" id="status_edit" class="form-control">
                                        <option <?php if($status=="Pending"){echo "selected";} ?> value="Pending">Pending</option>
                                        <option <?php if($status=="Active"){echo "selected";} ?> value="Active">Active</option>
                                    </select>
                                </div>
                                <small>
                                    <code class="text text-grayish">
                                        <label for="status_edit">
                                            Apabila anda memilih <b>Active</b> maka sistem tidak akan mengirimkan kode validasi.
                                        </label>
                                    </code>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function () {
                    // Fungsi untuk mengupdate jumlah karakter
                    function updateCharacterCount(input, lengthElement, maxLength) {
                        var length = input.val().length;
                        lengthElement.text(length + "/" + maxLength);
                        
                        // Jika panjang melebihi batas, potong teks
                        if (length > maxLength) {
                            input.val(input.val().substring(0, maxLength));
                            lengthElement.text(maxLength + "/" + maxLength);
                        }
                    }

                    // Update jumlah karakter dan batas
                    function setUpCharacterLimit(inputSelector, lengthSelector, maxLength, regex = null) {
                        var input = $(inputSelector);
                        var lengthElement = $(lengthSelector);
                        
                        // Ketika mengetik
                        input.on('input', function () {
                            // Validasi dengan regex jika ada
                            if (regex && !regex.test(input.val())) {
                                input.val(input.val().replace(regex, ''));
                            }
                            updateCharacterCount(input, lengthElement, maxLength);
                        });

                        // Mencegah input melebihi batas
                        input.on('keypress', function (e) {
                            if (input.val().length >= maxLength) {
                                e.preventDefault();
                            }
                        });

                        // Inisialisasi pertama kali
                        updateCharacterCount(input, lengthElement, maxLength);
                    }

                    // Pengaturan untuk setiap input
                    setUpCharacterLimit('#nama_edit', '#nama_edit_length', 100, /^[a-zA-Z\s]*$/);
                    setUpCharacterLimit('#kontak_edit', '#kontak_edit_length', 20, /^[0-9]*$/);
                    setUpCharacterLimit('#email_edit', '#email_edit_length', 100);
                    setUpCharacterLimit('#kode_pos_edit', '#kode_pos_edit_length', 10, /^[0-9]*$/);
                    setUpCharacterLimit('#rt_rw_edit', '#rt_rw_edit_length', 50);
                    setUpCharacterLimit('#email_validation_edit', '#email_validation_edit_length', 9, /^[0-9]*$/);

                    // Wilayah Dan Event lainnya
                    // Reload Kabupaten, Kecamatan, dan Desa
                    $('#provinsi_edit').on('change', function() {
                        var provinsiId = $(this).val();
                        $.ajax({
                            type 	    : 'POST',
                            url 	    : '_Page/Member/ListKabupaten.php',
                            data        : {provinsi: provinsiId},
                            success     : function(data){
                                $('#kabupaten_edit').html(data);
                            }
                        });
                        $('#kecamatan_edit').html('<option value="">Pilih</option>');
                        $('#desa_edit').html('<option value="">Pilih</option>');
                    });

                    $('#kabupaten_edit').on('change', function() {
                        var provinsi =$('#provinsi_edit').val();
                        var kabupaten = $(this).val();
                        $.ajax({
                            type 	    : 'POST',
                            url 	    : '_Page/Member/ListKecamatan.php',
                            data        : {provinsi: provinsi, kabupaten: kabupaten},
                            success     : function(data){
                                $('#kecamatan_edit').html(data);
                            }
                        });
                        $('#desa_edit').html('<option value="">Pilih</option>');
                    });

                    $('#kecamatan_edit').on('change', function() {
                        var provinsi =$('#provinsi_edit').val();
                        var kabupaten =$('#kabupaten_edit').val();
                        var kecamatan = $(this).val();
                        $.ajax({
                            type 	    : 'POST',
                            url 	    : '_Page/Member/ListDesa.php',
                            data        : {provinsi: provinsi, kabupaten: kabupaten, kecamatan: kecamatan},
                            success     : function(data){
                                $('#desa_edit').html(data);
                            }
                        });
                    });

                    // Generate email validation code
                    $('#GenerateEmailValidationCodeEdit').on('click', function() {
                        var randomCode = Math.random().toString(36).substring(2, 11);
                        $('#email_validation_edit').val(randomCode);
                    });
                });
            </script>
<?php 
            } 
        } 
    } 
?>