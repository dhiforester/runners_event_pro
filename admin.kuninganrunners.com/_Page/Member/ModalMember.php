<!-- Filter Data -->
<div class="modal fade" id="ModalFilter" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter">
                <input type="hidden" name="page" id="page">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="batas">
                                <small>Limit/Batas</small>
                            </label>
                        </div>
                        <div class="col col-md-8">
                            <select name="batas" id="batas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="OrderBy">
                                <small>Mode Urutan</small>
                            </label>
                        </div>
                        <div class="col col-md-8">
                            <select name="OrderBy" id="OrderBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="nama">Nama</option>
                                <option value="kontak">Kontak</option>
                                <option value="email">Email</option>
                                <option value="provinsi">Provinsi</option>
                                <option value="kabupaten">Kabupaten</option>
                                <option value="kecamatan">Kecamatan</option>
                                <option value="desa">Desa</option>
                                <option value="kode_pos">Kode Pos</option>
                                <option value="rt_rw">RT/RW</option>
                                <option value="datetime">Tanggal Daftar</option>
                                <option value="status">Status Validasi</option>
                                <option value="sumber">Sumber Data</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="ShortBy">
                                <small>Tipe Urutan</small>
                            </label>
                        </div>
                        <div class="col col-md-8">
                            <select name="ShortBy" id="ShortBy" class="form-control">
                                <option value="ASC">A To Z</option>
                                <option selected value="DESC">Z To A</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="keyword_by">
                                <small>Dasar Pencarian</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="nama">Nama</option>
                                <option value="kontak">Kontak</option>
                                <option value="email">Email</option>
                                <option value="provinsi">Provinsi</option>
                                <option value="kabupaten">Kabupaten</option>
                                <option value="kecamatan">Kecamatan</option>
                                <option value="desa">Desa</option>
                                <option value="kode_pos">Kode Pos</option>
                                <option value="rt_rw">RT/RW</option>
                                <option value="datetime">Tanggal Daftar</option>
                                <option value="status">Status Validasi</option>
                                <option value="sumber">Sumber Data</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="keyword">
                                <small>Kata Kunci</small>
                            </label>
                        </div>
                        <div class="col col-md-8" id="FormFilter">
                            <input type="text" name="keyword" id="keyword" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
                        <i class="bi bi-check"></i> Tampilkan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahMember" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahMember" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                                        <label for="nama">Nama Member</label>
                                    </small>
                                </div>
                                <div class="col col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <i class="bi bi-person"></i>
                                            </small>
                                        </span>
                                        <input type="text" class="form-control" name="nama" id="nama">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <code class="text text-dark" id="nama_length">0/100</code>
                                            </small>
                                        </span>
                                    </div>
                                    <small>
                                        <code class="text text-grayish">
                                            <label for="nama">Nama lengkap member</label>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <small>
                                        <label for="kontak">Kontak/HP</label>
                                    </small>
                                </div>
                                <div class="col col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <i class="bi bi-phone"></i>
                                            </small>
                                        </span>
                                        <input type="text" class="form-control" name="kontak" id="kontak" placeholder="62">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <code class="text text-dark" id="kontak_length">0/20</code>
                                            </small>
                                        </span>
                                    </div>
                                    <small>
                                        <code class="text text-grayish">
                                            <label for="kontak">Nomor HP/WA yang bisa dihubungi</label>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <small>
                                        <label for="email">Email</label>
                                    </small>
                                </div>
                                <div class="col col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <i class="bi bi-envelope"></i>
                                            </small>
                                        </span>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="email@domain.com">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <code class="text text-dark" id="email_length">0/100</code>
                                            </small>
                                        </span>
                                    </div>
                                    <small>
                                        <code class="text text-grayish">
                                            <label for="email">Alamat email member yang valid dan dapat dihubungi</label>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <small>
                                        <label for="password">Password</label>
                                    </small>
                                </div>
                                <div class="col col-md-8">
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
                                        <code class="text text-grayish">
                                            <label for="password">Password maksimal terdiri dari 6-20 karakter huruf dan angka</label>
                                        </code>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Tampilkan" id="TampilkanPassword" name="TampilkanPassword">
                                            <label class="form-check-label" for="TampilkanPassword">
                                                <code class="text text-dark">Tampilkan Password</code>
                                            </label>
                                        </div>
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
                                    <small><label for="provinsi">Provinsi</label></small>
                                </div>
                                <div class="col col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrependProvinsi">
                                            <small>
                                                <i class="bi bi-chevron-down"></i>
                                            </small>
                                        </span>
                                        <select name="provinsi" id="provinsi" class="form-control">
                                            <option value="">Pilih</option>
                                            <?php
                                                $QryProv = mysqli_query($Conn, "SELECT DISTINCT propinsi FROM wilayah ORDER BY propinsi ASC");
                                                while ($DataProv = mysqli_fetch_array($QryProv)) {
                                                    $ListProvinsi= $DataProv['propinsi'];
                                                    echo '<option value="'.$ListProvinsi.'">'.$ListProvinsi.'</option>';
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
                                <small><label for="kabupaten">Kabupaten/Kota</label></small>
                                </div>
                                <div class="col col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrependKabupaten">
                                            <small>
                                                <i class="bi bi-chevron-down"></i>
                                            </small>
                                        </span>
                                        <select name="kabupaten" id="kabupaten" class="form-control">
                                            <option value="">Pilih</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                <small><label for="kecamatan">Kecamatan</label></small>
                                </div>
                                <div class="col col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrependKecamatan">
                                            <small>
                                                <i class="bi bi-chevron-down"></i>
                                            </small>
                                        </span>
                                        <select name="kecamatan" id="kecamatan" class="form-control">
                                            <option value="">Pilih</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                <small><label for="desa">Desa/Kelurahan</label></small>
                                </div>
                                <div class="col col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrependDesa">
                                            <small>
                                                <i class="bi bi-chevron-down"></i>
                                            </small>
                                        </span>
                                        <select name="desa" id="desa" class="form-control">
                                            <option value="">Pilih</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                <small><label for="kode_pos">Kode Pos</label></small>
                                </div>
                                <div class="col col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <i class="bi bi-postcard"></i>
                                            </small>
                                        </span>
                                        <input type="text" name="kode_pos" id="kode_pos" class="form-control" placeholder="45514">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <code class="text text-dark" id="kode_pos_length">0/10</code>
                                            </small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                <small><label for="rt_rw">RT/RW/Gang</label></small>
                                </div>
                                <div class="col col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <i class="bi bi-map"></i>
                                            </small>
                                        </span>
                                        <input type="text" name="rt_rw" id="rt_rw" class="form-control" placeholder="RT 20 / RW 04 Jalan Anggrek">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <code class="text text-dark" id="rt_rw_length">0/50</code>
                                            </small>
                                        </span>
                                    </div>
                                    <small>
                                        <code class="text text-grayish">
                                            <label for="rt_rw">Informasi alamat lainnya yang perlu diketahui</label>
                                        </code>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 border-1 border-bottom">
                        <div class="col-md-12 mb-3">
                            <small>
                                <b>C. Status Validasi Akun</b>
                            </small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <small>
                                        Kode Validasi
                                    </small>
                                </div>
                                <div class="col col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <code class="text text-dark" id="email_validation_length">0/9</code>
                                            </small>
                                        </span>
                                        <input type="text" class="form-control" name="email_validation" id="email_validation">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <a href="javascript:void(0);" id="GenerateEmailValidationCode">
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
                                            <label for="email_validation">
                                                9 Digit kode validasi yang akan dikirim ke email untuk dikonfirmasi pemilik akun
                                            </label>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                    <small><label for="status">Status Validasi</label></small>
                                    </div>
                                    <div class="col col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-text" id="inputGroupPrepend">
                                                <small>
                                                    <i class="bi bi-tag"></i>
                                                </small>
                                            </span>
                                            <select name="status" id="status" class="form-control">
                                                <option value="Pending">Pending</option>
                                                <option value="Active">Active</option>
                                            </select>
                                        </div>
                                        <small>
                                            <code class="text text-grayish">
                                                <label for="status">
                                                    Apabila anda memilih <b>Active</b> maka sistem tidak akan mengirimkan kode validasi.
                                                </label>
                                            </code>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 border-1 border-bottom">
                        <div class="col-md-12 mb-3">
                            <small>
                                <b>D. Lampiran</b>
                            </small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <small>
                                        <label for="foto">Foto Profil</label>
                                    </small>
                                </div>
                                <div class="col col-md-8">
                                    <input type="file" class="form-control" name="foto" id="foto">
                                    <small>
                                        <code class="text text-grayish">
                                            <label for="foto" id="ValidasiFileFoto">File foto maksimal 5 mb (JPEG, JPG, PNG, GIF)</label>
                                        </code>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiTambahMember"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonTambahMember">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailMember" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="index.php" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-info-circle"></i> Detail Member
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormDetailMember">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-rounded">
                        <i class="bi bi-three-dots"></i> Selengkapnya
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditMember" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditMember" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditMember">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEditMember">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonEditMember">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalUbahPasswordMember" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUbahPasswordMember" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-key"></i> Ubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormUbahPasswordMember">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiUbahPasswordMember">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonUbahPasswordMember">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalUbahFoto" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUbahFotoMember">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-image"></i> Ubah Foto Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormUbahFoto">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiUbahFotoMember">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonUbahFoto">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusMember" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusMember" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapusMember">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiHapusMember">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonHapusMember">
                        <i class="bi bi-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tidak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>