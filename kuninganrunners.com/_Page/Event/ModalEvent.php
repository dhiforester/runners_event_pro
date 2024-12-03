<div class="modal fade" id="ModalBayarEvent" tabindex="-1">
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
                    <div class="col-md-12" id="FormBayarEvent">
                        <!-- Form Pembayaran Akan Muncul Disini -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalPembatalanEvent" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPembatalanEvent">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-trash"></i> Batalkan Pendaftaran
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormPembatalanEvent">
                            <!-- Form Pembatalan Pendaftaran Event Akan Muncul Disini -->
                            <?php 
                                echo '<input type="hidden" name="id_event_peserta" value="'.$id_event_peserta.'">';
                                echo '<img src="assets/img/batalkan_transaksi.png" width="100%">';
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <small>Apakah anda yakin akan membatalkan pendaftaran pada event ini?</small>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3 text-center" id="NotifikasiPembatalanEvent">
                            <!-- Notifikasi Pembatalan Event -->
                        </div>
                        <div class="col-md-12 mb-3 text-center">
                            <button type="submit" class="button_more" id="ButtonPembatalanEvent">
                                <i class="bi bi-check-circle"></i> Ya, Batalkan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>