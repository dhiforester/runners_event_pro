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
                        <div class="col-md-4">
                            <label for="KeywordBy">
                                <small>Dasar Pencarian</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="KeywordBy" id="KeywordBy" class="form-control">
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