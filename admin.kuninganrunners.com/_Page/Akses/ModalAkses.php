<div class="modal fade" id="ModalFilterAkses" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter">
                <input type="hidden" name="page" id="page">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Akses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="batas">
                                <small class="credit">Limit/Batas</small>
                            </label>
                        </div>
                        <div class="col col-md-8">
                            <select name="batas" id="batas" class="form-control">
                                <option value="10">10</option>
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
                                <option value="nama_akses">Nama</option>
                                <option value="kontak_akses">Nomor Kontak</option>
                                <option value="email_akses">Email</option>
                                <option value="akses">Akses</option>
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
                                <option value="DESC">Z To A</option>
                                <option value="ASC">A To Z</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="keyword_by">
                                <small>Dasar Pencarian</small>
                            </label>
                        </div>
                        <div class="col col-md-8">
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="nama_akses">Nama</option>
                                <option value="kontak_akses">Nomor Kontak</option>
                                <option value="email_akses">Email</option>
                                <option value="akses">Akses</option>
                            </select>
                        </div>
                    </div>
                    <div class="row  mb-3">
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
                        <i class="bi bi-save"></i> Filter
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahAkses" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahAkses" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dak"><i class="bi bi-plus"></i> Tambah Akses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nama_akses">
                                <small>Nama Lengkap</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" name="nama_akses" id="nama_akses" class="form-control">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code class="text text-dark" id="nama_akses_length">0/100</code>
                                    </small>
                                </span>
                            </div>
                            <small>
                                <code class="text text-grayish">Nama lengkap pengguna</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kontak_akses">
                                <small>No Kontak/HP</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <i class="bi bi-phone"></i>
                                </span>
                                <input type="text" name="kontak_akses" id="kontak_akses" class="form-control" placeholder="62">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code class="text text-dark" id="kontak_akses_length">0/20</code>
                                    </small>
                                </span>
                            </div>
                            <small>
                                <code class="text text-grayish">Kontak/HP yang bisa dihubungi</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="email_akses">
                                <small>Email</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <i class="bi bi-envelope"></i>
                                    </small>
                                </span>
                                <input type="email" name="email_akses" id="email_akses" class="form-control" placeholder="email@domain.com">
                            </div>
                            <small>
                                <code class="text text-grayish">Alamat email pengguna yang valid</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="akses">
                                <small>Akses/Entitias</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="akses" id="akses" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    $Jumlah = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_entitas"));
                                    if(!empty($Jumlah)){
                                        //Array Data Mitra
                                        $QryMitra = mysqli_query($Conn, "SELECT akses FROM akses_entitas ORDER BY akses ASC");
                                        while ($DataMitra = mysqli_fetch_array($QryMitra)) {
                                            $akses= $DataMitra['akses'];
                                            echo '<option value="'.$akses.'">'.$akses.'</option>';
                                        }
                                    }else{
                                        echo '<option value="">Tidak Ada Entitas Akses</option>';
                                    }
                                ?>
                            </select>
                            <small>
                                <code class="text text-grayish">Tingkat level akses yang digunakan berdasarkan entitias</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="image_akses">
                                <small>Photo Profile</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" name="image_akses" id="image_akses" class="form-control">
                            <small class="credit">
                                <code class="text text-grayish">Maximum File 2 Mb (PNG, JPG, JPEG, GIF)</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="password1">
                                <small>Password</small>
                            </label>
                        </div>
                        <div class="col-md-8">
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
                            <small class="credit">
                                <code class="text text-grayish">Password terdiri dari 6-20 karakter angka dan huruf</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="password2">
                                <small>Ulangi Password</small>
                            </label>
                        </div>
                        <div class="col-md-8">
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
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <small id="NotifikasiTambahAkses">
                                <code class="text text-primary">
                                    Pastikan data yang anda input sudahh sesuai
                                </code>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
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
<div class="modal fade" id="ModalDetailAkses" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Detail Akses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormDetailAkses">
                        <!-- Detail Akses Akan di tampilkan disini -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditAkses" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditAkses">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Akses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditAkses">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-8" id="NotifikasiEditAkses">
                            <!-- Notifikasi Edit Akses Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
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
<div class="modal fade" id="ModalEditLevelAkses" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditLevelAkses">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-tag"></i> Ubah Level Akses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditLevelAkses">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-8 mt-3" id="NotifikasiEditLevelAkses">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
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
<div class="modal fade" id="ModalUbahFotoAkses" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUbahFotoAkses">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-image"></i> Ubah Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormUbahFotoAkses">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiUbahFotoAkses">
                            <!-- Notifikasi Ubah Foto Akses Akan Muncul Disini-->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
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
<div class="modal fade" id="ModalUbahPassword" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUbahPassword">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-key"></i> Ubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormUbahPassword">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <small class="text-primary">Pastikan data yang anda input sudah sesuai</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiUbahPassword">
                            <!-- Notifikasi Ubah Password Akan Tampil Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
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
<div class="modal fade" id="ModalUbahIzinAkses" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUbahIzinAkses">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-key"></i> Ubah Izin Akses
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormUbahIzinAkses">
                            <!-- Form Ubah Izin Akses -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <small class="credit">
                                <code class="text text-primary">Pastikan Data Yang Anda Input Sudah Sesuai</code>
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiUbahIzinAkses">
                            <!-- Notifikasi Ubah Izin Akses -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
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
<div class="modal fade" id="ModalLogAkses" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-list-check"></i> Data Log Akses
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormLogAkses">
                        <!-- Form Ubah Izin Akses -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusAkses" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusAkses">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-trash"></i> Hapus Akses
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapusAkses">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <small class="text-danger">
                                Apakah anda yakin akan menghapus data akses ini?
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiHapusAkses">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
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