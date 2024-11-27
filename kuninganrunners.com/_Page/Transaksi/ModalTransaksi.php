<div class="modal fade" id="ModalPembayaran" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-coin"></i> Form Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12" id="FormPembayaran">
                        <!-- Form Pembayaran Akan Muncul Disini -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalBatalkanTransaksi" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesBatalkanTransaksi">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-trash"></i> Batalkan Transaksi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormBatalkanTransaksi">
                            <!-- Form Pembatalan Transaksi Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <small>Apakah anda yakin akan membatalkan transaksi ini?</small>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3 text-center" id="NotifikasiBatalkanTransaksi">
                            <!-- Notifikasi Pembatalan Transaksi -->
                        </div>
                        <div class="col-md-12 mb-3 text-center">
                            <button type="submit" class="button_more" id="ButtonBatalkanTransaksi">
                                <i class="bi bi-check-circle"></i> Ya, Batalkan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>