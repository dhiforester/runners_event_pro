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
                                <option value="nama_event">Nama Event</option>
                                <option value="keterangan">Keterangan</option>
                                <option value="tanggal_mulai">Tanggal Pelaksanaan</option>
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
                        <div class="col col-md-4">
                            <label for="keyword_by">
                                <small>Dasar Pencarian</small>
                            </label>
                        </div>
                        <div class="col col-md-8">
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="nama_event">Nama Event</option>
                                <option value="keterangan">Keterangan</option>
                                <option value="tanggal_mulai">Tanggal Pelaksanaan</option>
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
<!-- Filter Data Peserta-->
<div class="modal fade" id="ModalFilterPeserta" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterPeserta">
                <input type="hidden" name="page_peserta" id="page_peserta" value="1">
                <input type="hidden" name="id_event_peserta" id="id_event_peserta">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="batas_peserta">
                                <small>Limit/Batas</small>
                            </label>
                        </div>
                        <div class="col col-md-8">
                            <select name="batas_peserta" id="batas_peserta" class="form-control">
                                <option value="2">2</option>
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
                            <label for="OrderByPeserta">
                                <small>Mode Urutan</small>
                            </label>
                        </div>
                        <div class="col col-md-8">
                            <select name="OrderByPeserta" id="OrderByPeserta" class="form-control">
                                <option value="">Pilih</option>
                                <option value="nama">Nama Member</option>
                                <option value="datetime">Tanggal Daftar</option>
                                <option value="kategori">Kategori Event</option>
                                <option value="biaya_pendaftaran">Biaya Pendaftaran</option>
                                <option value="status">Status Pembayaran</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="ShortByPeserta">
                                <small>Tipe Urutan</small>
                            </label>
                        </div>
                        <div class="col col-md-8">
                            <select name="ShortByPeserta" id="ShortByPeserta" class="form-control">
                                <option value="ASC">A To Z</option>
                                <option selected value="DESC">Z To A</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="KeywordByPeserta">
                                <small>Dasar Pencarian</small>
                            </label>
                        </div>
                        <div class="col col-md-8">
                            <select name="KeywordByPeserta" id="KeywordByPeserta" class="form-control">
                                <option value="">Pilih</option>
                                <option value="nama">Nama Member</option>
                                <option value="email">Email</option>
                                <option value="datetime">Tanggal Daftar</option>
                                <option value="id_event_kategori">Kategori Event</option>
                                <option value="biaya_pendaftaran">Biaya Pendaftaran</option>
                                <option value="status">Status Pembayaran</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="keyword_peserta">
                                <small>Kata Kunci</small>
                            </label>
                        </div>
                        <div class="col col-md-8" id="FormFilterPeserta">
                            <input type="text" name="keyword_peserta" id="keyword_peserta" class="form-control">
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
<div class="modal fade" id="ModalTambahEvent" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahEvent" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 border-1 border-bottom">
                        <div class="col-md-12 mb-3">
                            <small>
                                <b>A. Tanggal & Waktu Event</b>
                            </small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4 mb-3">
                                    <small>
                                        A.1 Tanggal & Waktu Mulai
                                    </small>
                                </div>
                                <div class="col col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <i class="bi bi-calendar"></i>
                                            </small>
                                        </span>
                                        <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai">
                                    </div>
                                    <small>
                                        <code class="text text-grayish">
                                            <label for="tanggal_mulai">Tanggal</label>
                                        </code>
                                    </small>
                                </div>
                                <div class="col col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <i class="bi bi-clock"></i>
                                            </small>
                                        </span>
                                        <input type="time" class="form-control" name="jam_mulai" id="jam_mulai">
                                    </div>
                                    <small>
                                        <code class="text text-grayish">
                                            <label for="jam_mulai">Waktu/Jam</label>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 mb-3">
                                    <small>
                                        A.2 Tanggal & Waktu Selesai
                                    </small>
                                </div>
                                <div class="col col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <i class="bi bi-calendar"></i>
                                            </small>
                                        </span>
                                        <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai">
                                    </div>
                                    <small>
                                        <code class="text text-grayish">
                                            <label for="tanggal_selesai">Tanggal</label>
                                        </code>
                                    </small>
                                </div>
                                <div class="col col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <i class="bi bi-clock"></i>
                                            </small>
                                        </span>
                                        <input type="time" class="form-control" name="jam_selesai" id="jam_selesai">
                                    </div>
                                    <small>
                                        <code class="text text-grayish">
                                            <label for="jam_selesai">Waktu/Jam</label>
                                        </code>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 border-1 border-bottom">
                        <div class="col-md-12 mb-3">
                            <small>
                                <b>B. Tanggal & Waktu Pendaftaran</b>
                            </small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4 mb-3">
                                    <small>
                                        B.1 Tanggal & Waktu Mulai
                                    </small>
                                </div>
                                <div class="col col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <i class="bi bi-calendar"></i>
                                            </small>
                                        </span>
                                        <input type="date" class="form-control" name="tanggal_mulai_pendaftaran" id="tanggal_mulai_pendaftaran">
                                    </div>
                                    <small>
                                        <code class="text text-grayish">
                                            <label for="tanggal_mulai_pendaftaran">Tanggal</label>
                                        </code>
                                    </small>
                                </div>
                                <div class="col col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <i class="bi bi-clock"></i>
                                            </small>
                                        </span>
                                        <input type="time" class="form-control" name="jam_mulai_pendaftaran" id="jam_mulai_pendaftaran">
                                    </div>
                                    <small>
                                        <code class="text text-grayish">
                                            <label for="jam_mulai_pendaftaran">Waktu/Jam</label>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 mb-3">
                                    <small>
                                        B.2 Tanggal & Waktu Selesai
                                    </small>
                                </div>
                                <div class="col col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <i class="bi bi-calendar"></i>
                                            </small>
                                        </span>
                                        <input type="date" class="form-control" name="tanggal_selesai_pendaftaran" id="tanggal_selesai_pendaftaran">
                                    </div>
                                    <small>
                                        <code class="text text-grayish">
                                            <label for="tanggal_selesai_pendaftaran">Tanggal</label>
                                        </code>
                                    </small>
                                </div>
                                <div class="col col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <i class="bi bi-clock"></i>
                                            </small>
                                        </span>
                                        <input type="time" class="form-control" name="jam_selesai_pendaftaran" id="jam_selesai_pendaftaran">
                                    </div>
                                    <small>
                                        <code class="text text-grayish">
                                            <label for="jam_selesai_pendaftaran">Waktu/Jam</label>
                                        </code>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 border-1 border-bottom">
                        <div class="col-md-12 mb-3">
                            <small>
                                <b>C. Informasi Umum</b>
                            </small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <small>
                                        C.1 Judul/Nama Event
                                    </small>
                                </div>
                                <div class="col col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">
                                            <small>
                                                <code class="text text-dark" id="nama_event_length">0/100</code>
                                            </small>
                                        </span>
                                        <input type="text" class="form-control" name="nama_event" id="nama_event">
                                    </div>
                                    <small>
                                        <code class="text text-grayish">
                                            <label for="nama_event">Nama event yang merepresentasikan penyelenggaraan kegiatan</label>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <small>
                                        C.2 Keterangan/Deskripsi
                                    </small>
                                </div>
                                <div class="col col-md-8">
                                    <small>
                                        <code class="text text-dark" id="keterangan_length">0/500</code>
                                    </small>
                                    <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                                    <small>
                                        <code class="text text-grayish">
                                            <label for="keterangan">Gambaran umum tentang event/kegiatan yang akan dilaksanakan</label>
                                        </code>
                                    </small>
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
                                        D.1 Poster
                                    </small>
                                </div>
                                <div class="col col-md-8">
                                    <input type="file" class="form-control" name="poster" id="poster">
                                    <small>
                                        <code class="text text-grayish">
                                            <label for="poster">File poster maksimal 5 mb (JPEG, JPG, PNG, GIF)</label>
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <small>
                                        D.2 Rute
                                    </small>
                                </div>
                                <div class="col col-md-8">
                                    <input type="file" class="form-control" name="rute" id="rute">
                                    <small>
                                        <code class="text text-grayish">
                                            <label for="rute">File rute menggunakan format gpx</label>
                                        </code>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center" id="NotifikasiTambahEvent"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonTambahEvent">
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
<div class="modal fade" id="ModalDetailEvent" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="index.php" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-info-circle"></i> Detail Event
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormDetailEvent">
                            
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
<div class="modal fade" id="ModalEditEvent" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditEvent" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditEvent">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEditEvent">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonEditEvent">
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
<div class="modal fade" id="ModalUbahPoster" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUbahPoster" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-image"></i> Ubah Poster</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormUbahPoster">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiUbahPoster">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonUbahPoster">
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
<div class="modal fade" id="ModalGantiRute" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesGantiRute" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pin-map"></i> Ganti Rute</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormGantiRute">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiGantiRute">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonGantiRute">
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
<div class="modal fade" id="ModalHapusEvent" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusEvent" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapusEvent">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiHapusEvent">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonHapusEvent">
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
<div class="modal fade" id="ModalTambahKategori" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahKategori" autocomplete="off">
                <input type="hidden" name="id_event" id="PutIdEventOnAddKategori">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Kategori Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormTambahKategori">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiTambahKategori">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonTambahKategori">
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
<div class="modal fade" id="ModalDetailKategori" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-info-circle"></i> Detail Kategori Event
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormDetailKategori">
                        
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
<div class="modal fade" id="ModalEditKategori" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditKategori" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Edit Kategori Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditKategori">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiEditKategori">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonEditKategori">
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
<div class="modal fade" id="ModalHapusKategori" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusKategori" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Kategori Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapusKategori">
                            <!-- Form Hapus Kategori -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiHapusKategori">
                            <!-- Notifiksi Hapus Kategori -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonHapusKategori">
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
<div class="modal fade" id="ModalTambahPeserta" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Peserta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesPencarianMember">
                    <input type="hidden" name="page_member" id="page_member" value="1">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="keyword_member">
                                <small>Cari Member</small>
                            </label>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" name="keyword_member" id="keyword_member" class="form-control" placeholder="Cari Member">
                                <button type="submit" class="btn btn-grayish">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="javascript:void(0);" id="ProsesTambahPeserta">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="id_member_list">
                                <small>Pilih Member</small>
                            </label>
                        </div>
                        <div class="col-md-12" id="FormListMember">
                            
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="kategori_event">
                                <small>Kategori Event</small>
                            </label>
                            <select name="kategori_event" id="kategori_event" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="status_pembayaran">
                                <small>Status Pembayaran</small>
                            </label>
                            <select name="status_pembayaran" id="status_pembayaran" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Lunas">Lunas</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <small>
                                Pastikan data peserta yang anda input sudah sesuai.
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center" id="NotifikasiTambahPeserta">
                            
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-rounded" id="ButtonTambahPeserta">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle"></i> Tutup
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailPeserta" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="index.php" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-info-circle"></i> Detail Peserta
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormDetailPeserta">
                            <!-- Menampilkan Detail Peserta Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-success btn-rounded">
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
<div class="modal fade" id="ModalEditPeserta" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditPeserta" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Peserta Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditPeserta">
                            <!-- Form Hapus Peserta -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiEditPeserta">
                            <!-- Notifiksi Hapus Peserta -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonEditPeserta">
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
<div class="modal fade" id="ModalHapusPeserta" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusPeserta" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Peserta Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapusPeserta">
                            <!-- Form Hapus Peserta -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiHapusPeserta">
                            <!-- Notifiksi Hapus Peserta -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonHapusPeserta">
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
<div class="modal fade" id="ModalTambahTransaksiEvent" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahTransaksiEvent" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Buat Tagihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormTambahTransaksiEvent">
                            <!-- Form Tambah Transaksi Event -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiTambahTransaksiEvent">
                            <!-- Notifikasi Tambah Transaksi Event -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonTambahTransaksiEvent">
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
<div class="modal fade" id="ModalBayarEvent" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-coin"></i> Bayar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormBayarEvent">
                        <!-- Form Bayar Event -->
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
<div class="modal fade" id="ModalTambahAssesmentForm" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahAssesmentForm" autocomplete="off">
                <input type="hidden" name="id_event" id="PutIdEventOnAssesmentForm">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Assesment Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="form_name"><small>Nama Form</small></label>
                            <div class="input-group">
                                <input type="text" name="form_name" id="form_name" class="form-control">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code id="form_name_length" class="text text-grayish">0/50</code>
                                    </small>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="form_type"><small>Tipe Form</small></label>
                            <select name="form_type" id="form_type" class="form-control">
                                <option value="">Pilih</option>
                                <option value="text">Text</option>
                                <option value="textarea">Textarea</option>
                                <option value="select_option">Select Option</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="radio">Radio Button</option>
                                <option value="file_foto">File Foto</option>
                                <option value="file_pdf">File PDF</option>
                            </select>
                            <small>
                                <code class="text text-grayish" id="KeteranganTypeForm">
                                    <!-- Keterangan Type Form Disini -->
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="mandatori"><small>Mandatori</small></label>
                            <select name="mandatori" id="mandatori" class="form-control">
                                <option value="">Pilih</option>
                                <option value="true">Wajib Terisi</option>
                                <option value="false">Tidak Wajib</option>
                            </select>
                            <small>
                                <code class="text text-grayish">
                                    Menyatakan apakah form tersebut wajib untuk diisi.
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="komentar"><small>Komentar</small></label>
                            <textarea name="komentar" id="komentar" class="form-control"></textarea>
                            <small>
                                <code id="komentar_length" class="text text-grayish">0/500</code>
                            </small>
                        </div>
                    </div>
                    <div id="KategoriListForAssesment">
                        <!-- List Check Kategori Akan Muncul Disini -->
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="AlternatifButton">
                            <button type="button" class="btn btn-sm btn-outline-info btn-block" id="TambahAlternatif">
                                <i clas="bi bi-plus"></i> Tambah Alternatif
                            </button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="AlternatifList">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiTambahAssesmentForm">
                            <!-- Notifikasi Tambah Assesment Form -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonTambahAssesmentForm">
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
<div class="modal fade" id="ModalDetailAssesmentForm" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-info-circle"></i> Detail Assesment Form
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormDetailAssesmentForm">
                        <!-- Form Detail Assesment Form -->
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
<div class="modal fade" id="ModalEditAssesmentForm" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditAssesmentForm" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Assesment Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditAssesmentForm">
                            <!-- Form Hapus Peserta -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiEditAssesmentForm">
                            <!-- Notifiksi Hapus Peserta -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonEditAssesmentForm">
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
<div class="modal fade" id="ModalHapusAssesmentForm" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusAssesmentForm" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Assesment Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapusAssesmentForm">
                            <!-- Form Hapus Assesment Form -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiHapusAssesmentForm">
                            <!-- Notifiksi Hapus Assesment Form -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonHapusAssesmentForm">
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
<div class="modal fade" id="ModalUbahAssesmentPeserta" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUbahAssesmentPeserta" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Assesment Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormUbahAssesmentPeserta">
                            <!-- Form Assesment Peserta -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiUbahAssesmentPeserta">
                            <!-- Notifiksi Assesment Peserta -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonUbahAssesmentPeserta">
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
<div class="modal fade" id="ModalDetailAssesmentPeserta" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-info-circle"></i> Detail Assesment Peserta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormDetailAssesmentPeserta">
                        <!-- Form Detail Assesment Peserta -->
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
<div class="modal fade" id="ModalStatusAssesmentPeserta" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesStatusAssesmentPeserta" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-check-circle"></i> Status Assesment Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormStatusAssesmentPeserta">
                            <!-- Form Assesment Peserta -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiStatusAssesmentPeserta">
                            <!-- Notifiksi Assesment Peserta -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonStatusAssesmentPeserta">
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
<div class="modal fade" id="ModalHapusAssesmentPeserta" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusAssesmentPeserta" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Assesment Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapusAssesmentPeserta">
                            <!-- Form Hapus Assesment Form -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiHapusAssesmentPeserta">
                            <!-- Notifiksi Hapus Assesment Form -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonHapusAssesmentPeserta">
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
<div class="modal fade" id="ModalDetailTransaksi" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-info-circle"></i> Detail Transaksi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormDetailTransaksi">
                        <!-- Form Detail Transaksi -->
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
<div class="modal fade" id="ModalEditTransaksi" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditTransaksi" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Ubah/Edit Tagihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditTransaksi">
                            <!-- Form Edit Transaksi -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiEditTransaksi">
                            <!-- Notifiksi Edit Transaksi -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonEditTransaksi">
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
<div class="modal fade" id="ModalHapusTransaksi" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusTransaksi" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-trash"></i> Hapus Transaksi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapusTransaksi">
                            <!-- Form Hapus Transaksi-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiHapusTransaksi">
                            <!-- Notifiksi Hapus Transaksi -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonHapusTransaksi">
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
<div class="modal fade" id="ModalLogPembayaran" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-clock-history"></i> Riwayat Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormLogPembayaran">
                        <!-- Form Detail Transaksi -->
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalInfoPeninjauan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-info-circle"></i> Info Peninjauan Peserta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <small>
                            Peninjauan peserta event dilakukan untuk menyeleksi peserta yang memenuhi syarat dan ketentuan penyelenggaraan kegiatan.
                            Syarat dan ketentuan yang berlaku mungkin akan berbeda dalam setiap event yang dilaksanakan. 
                            Oleh sebab itu, perlu adanya assesment serta validasi kelengkapan data peserta yang dilakukan secara manual oleh admin yang 
                            berwenang. Proses seleksi peserta perlu dilakukan dengan tahapan sebagai berikut :
                        </small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <small>
                            <ol>
                                <li class="mb-2">
                                    Periksa status peserta pada data member, apakah yang bersangkutan sudah melakukan 
                                    validasi email sebagai salah satu bukti kepemilikan data informasi yang sah.
                                </li>
                                <li class="mb-2">
                                    Pastikan bahwa peserta telah mendaftar pada event dan kategori yang tepat. 
                                    Hal ini mungkin memiliki cara khusus apabila pada setiap kategori peserta memiliki syarat yang telah ditetapkan panitia.
                                </li>
                                <li class="mb-2">
                                    Apabila pada event ini diperlukan assesment khusus yang harus diisi oleh peserta secara mandiri, 
                                    pastikan keaslian dan keabsahan informasi yang diberikan.
                                </li>
                                <li class="mb-2">
                                    Apabila semua syarat telah terpenuhi, admin atau panitia bisa menambahkan data pembayaran pada <i>Tab Pembayaran</i>
                                    pada bagian akhir halaman ini.
                                </li>
                                <li class="mb-2">
                                    Pastikan uraian pembayaran sudah sesuai. Apabila proses berhasil, 
                                    peserta akan memperoleh link pembayaran pada akun membership sesuai jumlah nominal tagihan.
                                </li>
                            </ol>
                        </small>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalPreviewSertifikat" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-clock-history"></i> Preview Sertifikat
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormPreviewSertifikat">
                        <!-- Hasil Preview Sertifikat Akan Ditampilkan Disini -->
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>