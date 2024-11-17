<div class="modal fade" id="ModalFilter" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter">
                <input type="hidden" name="page" id="PutPage" class="form-control">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Web Viewer</h5>
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
                                <option value="tanggal">Tanggal</option>
                                <option value="page_url">URL</option>
                                <option value="ip_viewer">Alamat IP</option>
                                <option value="os_viewer">Sistem Operasi</option>
                                <option value="browser_viewer">Browser</option>
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
                                <option value="tanggal">Tanggal</option>
                                <option value="page_url">URL</option>
                                <option value="ip_viewer">Alamat IP</option>
                                <option value="os_viewer">Sistem Operasi</option>
                                <option value="browser_viewer">Browser</option>
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
<div class="modal fade" id="ModalHapusItemLog" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusItemLog">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-trash"></i> Hapus Log Viewer
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12 text-center" id="FormHapusItemLog"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            Apakah anda yakin akan menghapus Log Viewer tersebut?
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
<div class="modal fade" id="ModalStat" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-bar-chart"></i> Rekapitulasi Log Viewer
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="javascript:void(0);" id="FormFilterStat">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="SearchBy">
                                        <small>Search By</small>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <select name="SearchBy" id="SearchBy" class="form-control">
                                        <option value="ip_viewer">Alamat IP</option>
                                        <option value="page_url">Page URL</option>
                                        <option value="os_viewer">Sistem Operasi</option>
                                        <option value="browser_viewer">Browser</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="SearchKeyword">
                                        <small>Keyword</small>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="SearchKeyword" id="SearchKeyword" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="Rekapitulasi">
                                        <small>Rekapitulasi</small>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <select name="Rekapitulasi" id="Rekapitulasi" class="form-control">
                                        <option value="Tahunan">Tahunan</option>
                                        <option value="Bulanan">Bulanan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="PeriodeStat">
                                        <small>Periode</small>
                                    </label>
                                </div>
                                <div class="col-md-8" id="PeriodeStatForm">
                                    <!-- Stat Form Akan Tampil Disini -->
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-md btn-outline-primary btn-block btn-rounded">
                                        Tampilkan Data
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12" id="TabelStatViewer">
                        <!-- Tabel Rekapitulasi Log Viewer Akan Ditampilkan Disini -->
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