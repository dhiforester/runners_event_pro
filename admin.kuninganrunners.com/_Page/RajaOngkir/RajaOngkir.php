<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'ajWoorhQIuNH6k4Wr5c');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        //Buka Pengaturan
        $base_url_raja_ongkir=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'base_url');
        $api_key=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'api_key');
        $password=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'password');
        $origin_id=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'origin_id');
        $origin_label=GetDetailData($Conn, 'api_raja_ongkir', 'id_api_raja_ongkir ', '1', 'origin_label');
?>
    <section class="section dashboard">
        <div class="row mb-3">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small class="mobile-text">';
                    echo '      Berikut ini adalah halaman pengaturan koneksi raja ongkir.';
                    echo '      Fitur ini berfungsi untuk melakukan pencarian ongkos kirim menggunakan API raja ongkir.';
                    echo '      Lakukan pengujian (Test) untuk memastikan bahwa parameter yang digunakan sudah sesuai.';
                    echo '      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '  </small>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-12">
                <form action="javascript:void(0);" id="ProsesSettingRajaOngkir">
                    <div class="card">
                        <div class="card-header">
                            <b class="card-title">
                                <i class="bi bi-gear"></i> Form Pengaturan Koneksi API
                            </b>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="base_url_raja_ongkir">URL Raja Ongkir</i></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="url" name="base_url_raja_ongkir" id="base_url_raja_ongkir" class="form-control" required value="<?php echo "$base_url_raja_ongkir"; ?>">
                                    <small class="credit">
                                        <code class="text text-grayish">
                                            URL yang mengarah pada service yang digunakan.
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="api_key">API Key</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="api_key" id="api_key" class="form-control" required value="<?php echo "$api_key"; ?>">
                                    <small class="credit">
                                        <code class="text text-grayish">
                                            Akun email dari web mail pada layanan hosting.
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="password" id="password" class="form-control" required value="<?php echo "$password"; ?>">
                                    <small class="credit">
                                        <code class="text text-grayish">
                                            Password service API.
                                        </code>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="origin_id">ID Asal Pengiriman</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" readonly name="origin_id" id="origin_id" class="form-control" value="<?php echo $origin_id; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="origin_label">Label Asal Pengiriman</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" readonly name="origin_label" id="origin_label" class="form-control" value="<?php echo $origin_label; ?>">
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalCariOriginId">
                                        <small><i class="bi bi-search"></i> Cari Asal Pengiriman</small>
                                    </a>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4"></div>
                                <div class="col-md-8 text-right" id="NotifikasiSettingRajaOngkir">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-md btn-primary btn-rounded">
                                <i class="bi bi-save"></i> Simpan Pengaturan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <form action="javascript:void(0);" id="ProsesTestCariOngkir">
                    <div class="card">
                        <div class="card-header">
                            <b class="card-title">
                                <i class="bi bi-airplane"></i> Cari Ongkir
                            </b>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="destination_content">Tujuan Pengiriman</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" name="destination_content" id="destination_content" class="form-control" placeholder="Contoh : Ciporang" data-bs-toggle="modal" data-bs-target="#ModalCariDestinationContent">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="berat">Berat (Kg)</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" step="0.001" min="0.001" name="berat" id="berat" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="courier">Kurir</label>
                                </div>
                                <div class="col-md-8">
                                    <select name="courier" id="courier" class="form-control">
                                        <option value="">Pilih</option>
                                        <option value="jne">JNE</option>
                                        <option value="sicepat">Sicepat</option>
                                        <option value="jnt">JNT</option>
                                        <option value="ninja">Ninja</option>
                                        <option value="tiki">Tiki</option>
                                        <option value="lion">Lion</option>
                                        <option value="wahana">Wahana</option>
                                        <option value="pos">POS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="price">Kategori Harga</label>
                                </div>
                                <div class="col-md-8">
                                    <select name="price" id="price" class="form-control">
                                        <option value="">Pilih</option>
                                        <option value="lowest">Lowest</option>
                                        <option value="highest">Highest</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4"></div>
                                <div class="col-md-8" id="FormHasilPencarianOngkir">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-md btn-primary btn-rounded">
                                <i class="bi bi-search"></i> Cari Ongkir
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
<?php } ?>