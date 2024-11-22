<div class="modal fade" id="ModalTambahKeranjang" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahKeranjang">
                <input type="hidden" name="id_barang" value="<?php echo $id_barang; ?>">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambahkan Ke Keranjang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="qty">Jumlah/Kuantitas</label>
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <i class="bi bi-box"></i>
                                    </small>
                                </span>
                                <input type="number" min="1" class="form-control" name="qty" id="qty" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <?php
                                if(!empty($JumlahVarian)){
                                    echo 'Pilih Varian';
                                    foreach($varian as $varian_list){
                                        $id_varian=$varian_list['id_varian'];
                                        $foto_varian=$varian_list['foto_varian'];
                                        $nama_varian=$varian_list['nama_varian'];
                                        $stok_varian=$varian_list['stok_varian'];
                                        $harga_varian=$varian_list['harga_varian'];
                                        $keterangan_varian=$varian_list['keterangan_varian'];
                                        //Format Harga Varian
                                        $harga_varian_format='Rp ' . number_format($harga_varian, 2, ',', '.');
                            ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="id_varian" id="id_varian<?php echo $id_varian;?>" value="<?php echo $id_varian;?>">
                                        <label class="form-check-label" for="id_varian<?php echo $id_varian;?>">
                                            <small><?php echo $nama_varian;?></small><br>
                                            <small><code class="text-grayish">Harga : <?php echo $harga_varian_format;?></code></small><br>
                                            <small><code class="text-grayish">Stok : <?php echo $stok_varian;?></code></small><br>
                                        </label>
                                    </div>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiTambahKeranjang">
                            <!-- Notifikasi Tambahkan Data Ke Keranjang -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="css-button-fully-rounded--green" id="ButtonTambahKeranjang">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>