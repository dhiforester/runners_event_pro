<div class="modal fade" id="ModalPendaftaranEvent" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPendaftaranEvent">
                <input type="hidden" name="id_event" value="<?php echo $id_event; ?>">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Pendaftaran Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="email">Email Member</label>
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <i class="bi bi-envelope"></i>
                                    </small>
                                </span>
                                <input type="email" class="form-control" readonly name="email" id="email" value="<?php echo $_SESSION['email']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            Pilih Kategori Event
                            <?php
                                foreach($kategori as $list_kategori){
                                    $id_event_kategori=$list_kategori['id_event_kategori'];
                                    $nama_kategori=$list_kategori['kategori'];
                                    $deskripsi=$list_kategori['deskripsi'];
                                    $biaya_pendaftaran=$list_kategori['biaya_pendaftaran'];
                                    //Format Rupiah
                                    $BiayaPendaftaran="Rp " . number_format($biaya_pendaftaran, 0, ',', '.');
                                    echo '<div class="form-check">';
                                    echo '  <input class="form-check-input" type="radio" name="id_event_kategori" id="id_event_kategori'.$id_event_kategori.'" value="'.$id_event_kategori.'">';
                                    echo '  <label class="form-check-label" for="id_event_kategori'.$id_event_kategori.'">';
                                    echo '      '.$nama_kategori.' ('.$BiayaPendaftaran.')<br>';
                                    echo '      <small>'.$deskripsi.'</small>';
                                    echo '  </label>';
                                    echo '</div>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiPendaftaranEvent">
                            <!-- Notifikasi Pendaftaran Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="css-button-fully-rounded--green" id="ButtonPendaftaranEvent">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
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