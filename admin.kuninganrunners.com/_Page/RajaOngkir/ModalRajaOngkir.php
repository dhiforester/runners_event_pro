<div class="modal fade" id="ModalCariOriginId" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesAddOriginId">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-search"></i> Cari Origin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-12">
                            <div class="input-group">
                                <input type="text" name="origin_keyword" id="origin_keyword" class="form-control" placeholder="Contoh : Cijoho">
                                <button type="button" class="btn btn-grayish" id="button_cari_origin">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="form_origin">
                            <div class="alert alert-danger">
                                Silahkan Lakukan Pencarian Lokasi Asal Pengiriman
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiAddOriginId">
                            <!-- Notifikasi Proses Add Origin ID Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonAddOriginId">
                        <i class="bi bi-plus"></i> Tambahkan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCariDestinationContent" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesCariDestinationContent">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-search"></i> Cari Lokasii Tujuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-12">
                            <div class="input-group">
                                <input type="text" name="destinatiion_keyword" id="destinatiion_keyword" class="form-control" placeholder="Contoh : Cijoho">
                                <button type="submit" class="btn btn-grayish" id="button_cari_destinatiion">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="form_destinatiion">
                            <div class="alert alert-danger">
                                Silahkan Lakukan Pencarian Lokasi Tujuan Pengiriman
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiCariDestinationContent">
                            <!-- Notifikasi Cari Destination Content ID Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>