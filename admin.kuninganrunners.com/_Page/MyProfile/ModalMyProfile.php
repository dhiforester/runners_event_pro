<div class="modal fade" id="ModalFilterAktivitas" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterAktivitas">
                <input type="hidden" name="page" id="PageFilterAktivitas">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Data Aktivitas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label for="batas_aktivitas">Data</label>
                            <select name="batas" id="batas_aktivitas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="OrderByAktivitas">Mode Urutan</label>
                            <select name="OrderBy" id="OrderByAktivitas" class="form-control">
                                <option value="">Pilih</option>
                                <option value="datetime_log">Tanggal</option>
                                <option value="kategori_log">Kategori</option>
                                <option value="deskripsi_log">Deskripsi</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label for="ShortByAktivitas">Tipe Urutan</label>
                            <select name="ShortBy" id="ShortByAktivitas" class="form-control">
                                <option value="DESC">Z To A</option>
                                <option value="ASC">A To Z</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="keyword_by_aktivitas">Pencarian</label>
                            <select name="keyword_by" id="keyword_by_aktivitas" class="form-control">
                                <option value="">Pilih</option>
                                <option value="datetime_log">Tanggal</option>
                                <option value="kategori_log">Kategori</option>
                                <option value="deskripsi_log">Deskripsi</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3" id="FormKeywordAktivitas">
                            <label for="keyword_aktivitas">Kata Kunci</label>
                            <input type="text" name="keyword" id="keyword_aktivitas" class="form-control">
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
<div class="modal fade" id="ModalFilterLaporanKesalahan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterLaporanKesalahan">
                <input type="hidden" name="page" id="PageFilterLaporanKesalahan">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Data Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label for="batas_laporan_kesalahan">Data</label>
                            <select name="batas" id="batas_laporan_kesalahan" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="OrderByLaporanKesalahan">Mode Urutan</label>
                            <select name="OrderBy" id="OrderByLaporanKesalahan" class="form-control">
                                <option value="">Pilih</option>
                                <option value="tanggal_report">Tanggal Report</option>
                                <option value="tanggal_selesai">Tanggal Selesai</option>
                                <option value="subjek_laporan">Subjek</option>
                                <option value="laporan">Laporan</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label for="ShortByLaporanKesalahan">Tipe Urutan</label>
                            <select name="ShortBy" id="ShortByLaporanKesalahan" class="form-control">
                                <option value="DESC">Z To A</option>
                                <option value="ASC">A To Z</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="keyword_by_laporan_kesalahan">Pencarian</label>
                            <select name="keyword_by" id="keyword_by_laporan_kesalahan" class="form-control">
                                <option value="">Pilih</option>
                                <option value="tanggal_report">Tanggal Report</option>
                                <option value="tanggal_selesai">Tanggal Selesai</option>
                                <option value="subjek_laporan">Subjek</option>
                                <option value="laporan">Laporan</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3" id="FormKeywordLaporanKesalahan">
                            <label for="keyword_laporan_kesalahan">Kata Kunci</label>
                            <input type="text" name="keyword" id="keyword_laporan_kesalahan" class="form-control">
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
<div class="modal fade" id="ModalEditProfile" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditAkses">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-light"><i class="bi bi-building"></i> Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="FormEditAkses">
                    
                </div>
                <div class="modal-footer bg-primary">
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
<div class="modal fade" id="ModalUbahFotoProfil" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUbahFotoProfil" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-image"></i> Ubah Foto Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormUbahFotoProfil">
                            <!-- Form Edit Password Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiUbahFotoProfil">
                            <!-- Form Edit Password Disini -->
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
<div class="modal fade" id="ModalUbahInformasiProfil" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUbahInformasiProfil" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-person-circle"></i> Ubah Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormUbahInformasiProfil">
                            <!-- Form Informasi Profile Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiUbahInformasiProfil">
                            <!-- Notifikasi Ubah Profil  Disini -->
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
            <form action="javascript:void(0);" id="ProsesUbahPassword" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-key"></i> Ubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormUbahPassword">
                            <!-- Form Edit Password Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiUbahPassword">
                            <!-- Form Edit Password Disini -->
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
<div class="modal fade" id="ModalTambahLaporanKesalahan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahLaporanKesalahan">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Buat Laporan Kesalahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="subjek_laporan">Subjek/Judul</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="subjek_laporan" id="subjek_laporan" class="form-control">
                            <small class="credit">
                                <code class="text text-grayish" id="PanjangKarakterSubjek">
                                    Max: 0/200
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="laporan">Isi Laporan</label>
                        </div>
                        <div class="col-md-8">
                                <textarea name="laporan" id="laporan" class="form-control"></textarea>
                                <small class="credit">
                                    <code class="text text-grayish" id="PanjangKarakterLaporan">
                                        Max: 0/500
                                    </code>
                                </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="lapiran">Lampiran</label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" name="lapiran" id="lapiran" class="form-control">
                            <small class="credit">
                                <code class="text text-grayish">
                                    File lampiran tidak lebih dari 2 Mb (JPG, JPEG, PNG dan GIF)
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <small class="text text-grayish credit">
                                Pastikan informasi laporan kesalahan yang anda input sudah sesuai.
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <small class="credit" id="NotifikasiTambahLaporanKesalahan">
                                
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
<div class="modal fade" id="ModalDetailLaporanKesalahan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Detail Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12" id="FormDetailLaporanKesalahan">
                        <!-- Form Detail Laporan Disini -->
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
<div class="modal fade" id="ModalEditLaporanKesalahan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditLaporanKesalahan" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Ubah Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormEditLaporanKesalahan">
                            <!-- Form Edit Laporan Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiEditLaporanKesalahan">
                            <!-- Notifikasi Edit Laporan Disini -->
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
<div class="modal fade" id="ModalHapusLaporanKesalahan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusLaporanKesalahan" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormHapusLaporanKesalahan">
                            <!-- Form Hapus Laporan Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiHapusLaporanKesalahan">
                            <!-- Notifikasi Hapus Laporan Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
                        <i class="bi bi-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>