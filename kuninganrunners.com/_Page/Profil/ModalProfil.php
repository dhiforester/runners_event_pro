<div class="modal fade" id="ModalUbahFotoProfil" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUbahFotoProfil">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Ubah Foto Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="foto">File Foto</label>
                            <input type="file" class="form-control" name="foto" id="foto">
                            <small>
                                <code class="text-dark">
                                    File foto tidak lebih dari 5 Mb (Tipe file : PNG, JPG, JPEG, GIF)
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiUbahFotoProfil">
                            <!-- Notifikasi Ubah Foto Profil Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="css-button-fully-rounded--green" id="ButtonUbahFotoProfil">
                        <i class="bi bi-upload"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalUbahProfil" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUbahProfil">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Ubah Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nama">Nama Lengkap</label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <i class="bi bi-person"></i>
                                    </small>
                                </span>
                                <input type="text" class="form-control" name="nama" id="nama" value="<?php echo "$nama"; ?>">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code class="text text-dark" id="nama_length"><?php echo strlen($nama); ?>/100</code>
                                    </small>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kontak">Kontak (HP)</label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <i class="bi bi-phone"></i>
                                    </small>
                                </span>
                                <input type="text" class="form-control" name="kontak" id="kontak" placeholder="62" value="<?php echo "$kontak"; ?>">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code class="text text-dark" id="kontak_length"><?php echo strlen($kontak); ?>/20</code>
                                    </small>
                                </span>
                            </div>
                            <small>
                                <code class="text-dark">
                                    <label for="kontak">Nomor HP/WA yang bisa dihubungi</label>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="provinsi">Provinsi</label>
                        </div>
                        <div class="col-md-8">
                            <select name="provinsi" id="provinsi" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    $ListProvinsi=ListProvinsi($url_server,$xtoken);
                                    $array_provinsi= json_decode($ListProvinsi, true);
                                    if($array_provinsi['response']['code']==200) {
                                        if(!empty($array_provinsi['metadata'])){
                                            $provinsi_data = $array_provinsi['metadata'];
                                            foreach($provinsi_data as $list_provinsi){
                                                $id_propinsi=$list_provinsi['id_propinsi'];
                                                $propinsi=$list_provinsi['propinsi'];
                                                if($provinsi==$propinsi){
                                                    echo '<option selected value="'.$id_propinsi.'">'.$propinsi.'</option>';
                                                }else{
                                                    echo '<option value="'.$id_propinsi.'">'.$propinsi.'</option>';
                                                }
                                            }
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kabupaten">Kabupaten/Kota</label>
                        </div>
                        <div class="col-md-8">
                            <select name="kabupaten" id="kabupaten" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kecamatan">Kecamatan</label>
                        </div>
                        <div class="col-md-8">
                            <select name="kecamatan" id="kecamatan" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="desa">Desa/Kelurahan</label>
                        </div>
                        <div class="col-md-8">
                            <select name="desa" id="desa" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="rt_rw">RT/RW/Gang</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="rt_rw" id="rt_rw" class="form-control" value="<?php echo "$rt_rw"; ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kode_pos">Kode Pos</label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <i class="bi bi-postcard"></i>
                                    </small>
                                </span>
                                <input type="text" name="kode_pos" id="kode_pos" class="form-control" placeholder="45514" value="<?php echo "$kode_pos"; ?>">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code class="text text-dark" id="kode_pos_length"><?php echo strlen($kode_pos); ?>/10</code>
                                    </small>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiUbahProfil">
                            <!-- Notifikasi Ubah Profil Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="css-button-fully-rounded--green" id="ButtonUbahProfil">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalUbahPassword" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUbahPassword">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Ubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="password">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <i class="bi bi-key"></i>
                                    </small>
                                </span>
                                <input type="password" class="form-control" name="password" id="password">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code class="text text-dark" id="password_length">0/20</code>
                                    </small>
                                </span>
                            </div>
                            <small class="credit">
                                <code class="text-dark">
                                    <label for="password">Password maksimal terdiri dari 6-20 karakter huruf dan angka</label>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="password">Password Baru</label>
                            <input type="password" class="form-control" name="ulangi_password" id="ulangi_password">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="tampilkan_password">
                                <label class="form-check-label" for="tampilkan_password">
                                    Tampilkan Password
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                Setelah berhasil mengubah password, anda akan logout secara otomatis dan perlu login ulang.
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiUbahPassword">
                            <!-- Notifikasi Ubah Foto Profil Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="css-button-fully-rounded--green" id="ButtonUbahPassword">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalLogout" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-dark"><i class="bi bi-lock"></i> Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <img src="assets/img/logout.png" alt="" width="100%">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            Apakah anda yakin akan keluar dari akun saat ini?
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 text-center">
                <a href="_Page/Profil/Logout.php" class="button_more">
                    <i class="bi bi-lock"></i> Logout
                </a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalKirimTestimoni" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesKirimTestimoni">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-send"></i> Kirim Survey
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="penilaian">Penilaian Tentang Website Kami</label>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="penilaian" id="penilaian-5" value="5">
                                <label class="form-check-label" for="penilaian-5">
                                    <small class="credit">
                                        <code class="text-dark">
                                            Website berjalan dengan sempurna, proses mudah dan sangat membantu.
                                        </code>
                                    </small>
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="penilaian" id="penilaian-4" value="4">
                                <label class="form-check-label" for="penilaian-4">
                                    <small class="credit">
                                        <code class="text-dark">
                                            Website berjalan dengan baik walapun terdapat kendala dalam beberapa proses.
                                        </code>
                                    </small>
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="penilaian" id="penilaian-3" value="3">
                                <label class="form-check-label" for="penilaian-3">
                                    <small class="credit">
                                        <code class="text-dark">
                                            Website berjalan kurang baik dan terdapat sedikit kendala dalam beberapa proses.
                                        </code>
                                    </small>
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="penilaian" id="penilaian-2" value="2">
                                <label class="form-check-label" for="penilaian-2">
                                    <small class="credit">
                                        <code class="text-dark">
                                            Website berjalan kurang baik dan terdapat banyak sekali kendala dalam beberapa proses.
                                        </code>
                                    </small>
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="penilaian" id="penilaian-1" value="1">
                                <label class="form-check-label" for="penilaian-1">
                                    <small class="credit">
                                        <code class="text-dark">
                                            Website berjalan sangat buruk dan terdapat banyak sekali kendala dalam beberapa proses sehingga tidak layak digunakan.
                                        </code>
                                    </small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="testimoni">Saran Dan Kritik</label>
                            <textarea name="testimoni" id="testimoni" class="form-control"></textarea>
                            <small>
                                <code class="text text-grayish" id="testimoni_length">0/500</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiKirimTestimoni">
                            <!-- Notifikasi Kirim Testimoni Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="css-button-fully-rounded--green" id="ButtonKirimTestimoni">
                        <i class="bi bi-send"></i> Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>