<div class="modal fade" id="ModalPetunjukPesanan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-info-circle"></i> Petunjuk Pemesanan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <ol>
                            <li>
                                <b>Kirim Pesanan</b>
                                <p>
                                    <small>
                                        Kirim pesanan berdasarkan item barang yang ada pada halaman keranjang.
                                    </small>
                                </p>
                            </li>
                            <li>
                                <b>Validasi Pesanan</b>
                                <p>
                                    <small>
                                        Admin akan melakukan validasi pesanan anda, termasuk melakukan konfirmasi ketersediaan barang, 
                                        jumlah biaya ongkir, pajak (jika ada) dan informasi pengiriman.
                                    </small>
                                </p>
                            </li>
                            <li>
                                <b>Konfirmasi Link Pembayaran</b>
                                <p>
                                    <small>
                                        Setelah pemesanan dinyatakan valid, selanjutnya anda akan menerima pemberitahuan melalui email, 
                                        ataupun melalui kontak yang anda sertakan pada pemesanan tersebut. 
                                        Langkah selanjutnya, anda tinggal kembali ke halaman riwayat pemesanan pada halaman profil untuk menyelesaikan pemesanan. 
                                    </small>
                                </p>
                            </li>
                            <li>
                                <b>Proses Pemabayaran</b>
                                <p>
                                    <small>
                                        Apabila data pemesanan sudah valid, anda bisa melakukan pembayaran pada detail riwayat pembelian yang ada pada halaman profil.
                                        Ikuti langkah-langkah pembayaran yang ada pada halaman tersebut.
                                    </small>
                                </p>
                            </li>
                            <li>
                                <b>Pengiriman</b>
                                <p>
                                    <small>
                                        Setelah pembayaran valid, kami akan segera mengirimkan barang pesanan anda. 
                                        Ikuti terus update perkembangan proses pengiriman melalui resi yang kami kirimkan.
                                    </small>
                                </p>
                            </li>
                            <li>
                                <b>Pembatalan Pesanan</b>
                                <p>
                                    <small>
                                        Pembatalan pemesanan hanya bisa dilakukan sebelum anda menyelesaikan pembayaran.
                                    </small>
                                </p>
                            </li>
                            <li>
                                <b>Penyelesaian Maslaah</b>
                                <p>
                                    <small>
                                        Apabila terdapat masalah pada saat pengiriman atau pemesanan, jangan ragu menghubungi kami pada kontak yang tersedia.
                                    </small>
                                </p>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditKeranjang" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditKeranjang">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-pencil"></i> Ubah Item Keranjang
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormEditKeranjang">
                            
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiEditKeranjang">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="button button_pendaftaran" id="ButtonEditKeranjang">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCariAlamat" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesCariAlamat">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-search"></i> Cari Lokasii Tujuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-12">
                            <div class="input-group">
                                <input type="text" name="keyword_alamat" id="keyword_alamat" class="form-control" placeholder="Contoh : Cijoho">
                                <button type="submit" class="btn btn-secondary" id="ButtonCariAlamat">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <small>Hasil Pencarian :</small>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12" id="list_alamat">
                            <div class="alert alert-danger">
                                Silahkan Lakukan Pencarian Lokasi Tujuan Pengiriman
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiCariAlamat">
                            <!-- Notifikasi Cari Alamat ID Disini -->
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