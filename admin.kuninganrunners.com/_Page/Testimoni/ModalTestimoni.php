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
                                <!-- <option value="2">2</option> -->
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
                                <option value="member.nama">Nama Member</option>
                                <option value="member.email">Email</option>
                                <option value="web_testimoni.penilaian">Penilaian</option>
                                <option value="web_testimoni.sumber">Sumber</option>
                                <option value="web_testimoni.datetime">Tanggal</option>
                                <option value="web_testimoni.status">Status</option>
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
                                <option value="member.nama">Nama Member</option>
                                <option value="member.email">Email</option>
                                <option value="web_testimoni.penilaian">Penilaian</option>
                                <option value="web_testimoni.sumber">Sumber</option>
                                <option value="web_testimoni.datetime">Tanggal</option>
                                <option value="web_testimoni.status">Status</option>
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
<div class="modal fade" id="ModalTambahTestimoni" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Testimoni</h5>
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
                <form action="javascript:void(0);" id="ProsesTambahTestimoni">
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
                            <label for="penilaian">
                                <small>Penilaian</small>
                            </label>
                            <select name="penilaian" id="penilaian" class="form-control">
                                <option value="">Pilih</option>
                                <option value="5">Sangat Baik</option>
                                <option value="4">Baik</option>
                                <option value="3">Sedang</option>
                                <option value="2">Kurang</option>
                                <option value="1">Buruk</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="testimoni">
                                <small>Testimoni</small>
                            </label>
                            <textarea name="testimoni" id="testimoni" class="form-control"></textarea>
                            <small>
                                <code class="text text-grayish" id="testimoni_length">0/500</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="status">
                                <small>Status</small>
                            </label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Publish">Publish</option>
                                <option value="Draft">Draft</option>
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
                        <div class="col-md-12 text-center" id="NotifikasiTambahTestimoni">
                            
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-rounded" id="ButtonTambahTestimoni">
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
<div class="modal fade" id="ModelDetailTestimoni" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Detail Testimoni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormDetailTestimoni">
                        <!-- Detail Testimoni -->
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
<div class="modal fade" id="ModelEditTestimoni" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditTestimoni" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Testimoni</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditTestimoni">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEditTestimoni">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonEditTestimoni">
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
<div class="modal fade" id="ModelHapusTestimoni" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusTestimoni" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Testimoni</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapusTestimoni">
                            <!-- Form Hapus Testimoni -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiHapusTestimoni">
                            <!-- Notifiksi Hapus Testimoni -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonHapusTestimoni">
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