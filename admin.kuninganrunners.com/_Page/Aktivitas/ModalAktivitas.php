<div class="modal fade" id="ModalFilterAktivitasUmum" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter">
                <input type="hidden" name="page" id="PutPage" class="form-control">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Aktivitas Umum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="batas">Batas</label>
                        </div>
                        <div class="col-md-8">
                            <select name="batas" id="batas" class="form-control">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="OrderBy">Mode Urutan</label>
                        </div>
                        <div class="col-md-8">
                            <select name="OrderBy" id="OrderBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="id_akses">Akses</option>
                                <option value="datetime_log">Tanggal</option>
                                <option value="kategori_log">Kategori</option>
                                <option value="deskripsi_log">Deskripsi</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="ShortBy">Tipe Urutan</label>
                        </div>
                        <div class="col-md-8">
                            <select name="ShortBy" id="ShortBy" class="form-control">
                                <option value="DESC">Z To A</option>
                                <option value="ASC">A To Z</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="keyword_by">Dasar Pencarian</label>
                        </div>
                        <div class="col-md-8">
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="id_akses">Akses</option>
                                <option value="datetime_log">Tanggal</option>
                                <option value="kategori_log">Kategori</option>
                                <option value="deskripsi_log">Deskripsi</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="keyword">Kata Kunci</label>
                        </div>
                        <div class="col-md-8" id="FormFilter">
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
<div class="modal fade" id="ModalGrafik" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-graph-down"></i> Grafik Data
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="FormGrafikBy">
                    <div class="row mb-2">
                        <div class="col-md-3 mb-3">
                            <select name="select_data" id="select_data" class="form-control">
                                <option value="id_akses">User Akses</option>
                                <option value="kategori_log">Kategori</option>
                            </select>
                            <small class="credit">
                                <label for="select_data">Select Data</label>
                            </small>
                        </div>
                        <div class="col-md-3 mb-3">
                            <select name="mode_data" id="mode_data" class="form-control">
                                <option value="semua">Semua</option>
                                <option value="harian">Harian</option>
                                <option value="bulanan">Bulanan</option>
                                <option value="tahunan">Tahunan</option>
                            </select>
                            <small class="credit">
                                <label for="mode_data">Mode/Periode</label>
                            </small>
                        </div>
                        <div class="col-md-4 mb-3" id="FormPeriode">
                            <!-- Form Periode Akan Muncul Disini -->
                            <input type="date" readonly name="form_date" id="form_date" class="form-control">
                            <small class="credit">
                                <label for="form_date">Tanggal</label>
                            </small>
                        </div>
                        <div class="col-md-2 mb-3">
                            <button type="submit" class="btn btn-md btn-primary btn-block">
                                <i class="bi bi-check-circle"></i> Tampilkan
                            </button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12" id="GrafikAktivitasBy"></div>
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
<div class="modal fade" id="ModalHapusItemLog" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusItemLogAktivitas">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-trash"></i> Hapus Log Aktivitas
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12 text-center" id="FormHapusItemLog"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            Apakah anda yakin akan menghapus log aktivitas tersebut?
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center" id="NotifikasiHapusItemLog">
                            
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