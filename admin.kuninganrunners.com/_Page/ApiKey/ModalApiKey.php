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
                                <small>Batas/Limit</small>
                            </label>
                        </div>
                        <div class="col col-md-8">
                            <select name="batas" id="batas" class="form-control">
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
                                <option value="title_api_key">Nama API Key</option>
                                <option value="description_api_key">Deskripsi/Keterangan</option>
                                <option value="user_key_server">User Key</option>
                                <option value="status">Status</option>
                                <option value="datetime_creat">Datetime Creat</option>
                                <option value="datetime_update">Updatetime</option>
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
                                <option value="title_api_key">Nama API Key</option>
                                <option value="description_api_key">Deskripsi/Keterangan</option>
                                <option value="user_key_server">User Key</option>
                                <option value="status">Status</option>
                                <option value="datetime_creat">Datetime Creat</option>
                                <option value="datetime_update">Updatetime</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="keyword">
                                <small>Kata Kunci</small>
                            </label>
                        </div>
                        <div class="col-md-8" id="FormFilter">
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
<div class="modal fade" id="ModalTambahApiKey" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahApiKey" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Buat Api Key</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="title_api_key">
                                <small>Nama API Key</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code class="text text-dark" id="title_api_key_length">0/50</code>
                                    </small>
                                </span>
                                <input type="text" name="title_api_key" id="title_api_key" class="form-control">
                            </div>
                            <small>
                                <code class="text text-grayish">Diisi dengan nama aplikasi/pihak yang akan terhubung.</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="description_api_key">
                                <small>
                                    Deskripsi
                                </small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code class="text text-dark" id="description_api_key_length">0/200</code>
                                    </small>
                                </span>
                                <input type="text" name="description_api_key" id="description_api_key" class="form-control">
                            </div>
                            <small>
                                <code class="text text-grayish">Diisi dengan informasi keterangan penggunaan</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="user_key_server">
                                <small>User Key</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code class="text text-dark" id="user_key_server_length">0/36</code>
                                    </small>
                                </span>
                                <input type="text" name="user_key_server" id="user_key_server" class="form-control">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <a href="javascript:void(0);" id="GenerateUserKey" title="Generate Otomatis API Key">
                                        <small>
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </small>
                                    </a>
                                </span>
                            </div>
                            <small>
                                <code class="text text-grayish">Maksimal 36 karakter yang terdiri dari huruf dan angka</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="password_server">
                                <small>Password</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code class="text text-dark" id="password_server_length">0/20</code>
                                    </small>
                                </span>
                                <input type="text" name="password_server" id="password_server" class="form-control">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <a href="javascript:void(0);" id="GeneratePasswordServer" title="Generate Otomatis Password Server">
                                        <small>
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </small>
                                    </a>
                                </span>
                            </div>
                            <small>
                                <code class="text text-grayish">
                                    Password server maksimal 20 karakter yang terdiri dari huruf dan angka.<br>
                                    (Catatlah password ini karena tidak akan ditampilkan setelah disimpan)
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="limit_session">
                                <small>Time Limit</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="limit_session" id="limit_session" class="form-control" required>
                                <option value="">Pilih..</option>
                                <option value="60000">1 Menit</option>
                                <option value="300000">5 Menit</option>
                                <option value="600000">10 Menit</option>
                                <option value="1800000">30 Menit</option>
                            </select>
                            <small>
                                <code class="text text-grayish">Durasi waktu expired x-token setiap kali dibuat</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="status_api_key">
                                <small>
                                    Status
                                </small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="status_api_key" id="status_api_key" class="form-control" required>
                                <option value="">Pilih..</option>
                                <option value="Aktif">Active</option>
                                <option value="None">No Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <small class="text-primary">Pastikan Data API Key Yang Anda Buat Sudah Sesuai</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-8" id="NotifikasiTambahApiKey">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
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
<div class="modal fade" id="ModalDetailInformasiApiKey" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="index.php">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Detail Api Key</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormDetailInformasiApiKey">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-rounded">
                        <i class="bi bi-three-dots"></i> Selengkapnya
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditInformasiApiKey" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditInformasiApiKey">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Informasi Api Key</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormEditInformasiApiKey"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"></div>
                        <div class="col-md-8" id="NotifikasiEditInformasiApiKey"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
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
<div class="modal fade" id="ModalEditPasswordApiKey" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditPasswordApiKey">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Password Api Key</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditPasswordApiKey"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-8" id="NotifikasiEditPasswordApiKey"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
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
<div class="modal fade" id="ModalHapusApiKey" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusApiKey">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus API Key</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormHapusApiKey"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiHapusApiKey"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
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
<div class="modal fade" id="ModalLogApiKey" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="index.php" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-table"></i> Log API Key</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormLogApiKey"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-three-dots"></i> Lihat Selengkapnya
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalFilterPeriodeGrafik" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="index.php" method="GET" id="ProsesFilterGrafikApiKey">
                <input type="hidden" name="Page" value="ApiKey">
                <input type="hidden" name="Sub" value="Detail">
                <input type="hidden" name="id" id="PutIdSettingApi" value="">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-calendar"></i> Pilih Periode Data
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="Periode">Periode</label>
                        </div>
                        <div class="col-md-8">
                            <select name="Periode" id="Periode" class="form-control">
                                <option <?php if($Periode=="Tahunan"){echo "selected";} ?> value="Tahunan">Tahunan</option>
                                <option <?php if($Periode=="Bulanan"){echo "selected";} ?> value="Bulanan">Bulanan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="Tahun">Tahun</label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" id="Tahun" name="Tahun" class="form-control" value="<?php echo $Tahun; ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="Bulan">Bulan</label>
                        </div>
                        <div class="col-md-8">
                            <?php
                                echo '  <select name="Bulan" id="Bulan" class="form-control">';
                                $months = [
                                    "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
                                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                                ];
                                
                                for ($i = 0; $i < 12; $i++) {
                                    // Menambahkan leading zero pada bulan yang nomornya kurang dari 10
                                    $monthNumber = str_pad($i + 1, 2, "0", STR_PAD_LEFT);
                                    if($monthNumber==$Bulan){
                                        echo '<option selected value="'.$monthNumber.'">'. $months[$i] .'</option>';
                                    }else{
                                        echo '<option value="'.$monthNumber.'">'. $months[$i] .'</option>';
                                    }
                                }
                                echo '  </select>';
                            ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
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
<div class="modal fade" id="ModalListLogTokenApiKey" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-table"></i> List Log X-Token
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="ListLogTokenApiKey">
                <div class="row mb-3">
                    <div class="col-md-12">
                        
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
<div class="modal fade" id="ModalListLogApiKey" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-table"></i> List Log API Key
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="ListLogApiKey">
                <div class="row mb-3">
                    <div class="col-md-12">
                        
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