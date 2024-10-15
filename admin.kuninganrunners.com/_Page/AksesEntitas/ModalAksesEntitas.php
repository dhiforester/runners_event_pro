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
                                <option value="akses">Nama Entitas</option>
                                <option value="keterangan">Keterangan</option>
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
                        <div class="col-md-4">
                            <label for="KeywordBy">
                                <small>Dasar Pencarian</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="KeywordBy" id="KeywordBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="akses">Nama Entitas</option>
                                <option value="keterangan">Keterangan</option>
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
<div class="modal fade" id="ModalTambahAksesEntitas" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahAksesEntitas" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Akses Entitas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="akses">Nama Entitias</label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code class="text text-dark" id="akses_length">0/20</code>
                                    </small>
                                </span>
                                <input type="text" class="form-control" name="akses" id="akses">
                            </div>
                            <small>
                                <code class="text text-grayish">
                                    Nama level akses, unit kerja atau bisa diisi dengan nama jabatan.
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="keterangan">Keterangan</label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <small>
                                        <code class="text text-dark" id="keterangan_length">0/200</code>
                                    </small>
                                </span>
                                <input type="text" class="form-control" name="keterangan" id="keterangan">
                            </div>
                            <small>
                                <code class="text text-grayish">
                                    Gambaran umum tugas dan fungsi entitas tersebut.
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            Ijin Akses
                        </div>
                        <div class="col-md-12">
                            <?php
                                //Tampilkan Kategori Ijin Akses
                                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_fitur"));
                                if(empty($jml_data)){
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-12 text-center text-danger">';
                                    echo '      <smal>';
                                    echo '          <code cass="text-danger">';
                                    echo '              Belum Ada Data Akses Yang Dibuat';
                                    echo '          </code>';
                                    echo '      </smal>';
                                    echo '  </div>';
                                    echo '</div>';
                                }else{
                                    echo '<div class="accordion" id="accordionExample">';
                                    $no_kategori=1;
                                    $QryKategoriFitur = mysqli_query($Conn, "SELECT DISTINCT kategori FROM akses_fitur ORDER BY kategori ASC");
                                    while ($DataKategori = mysqli_fetch_array($QryKategoriFitur)) {
                                        $kategori= $DataKategori['kategori'];
                                        echo '<div class="accordion-item">';
                                        echo '  <h2 class="accordion-header" id="heading'.$no_kategori.'">';
                                        echo '      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$no_kategori.'" aria-expanded="false" aria-controls="collapse'.$no_kategori.'">';
                                        echo '          <small class="credit">'.$no_kategori.'. '.$kategori.'</small>';
                                        echo '      </button>';
                                        echo '  </h2>';
                                        echo '  <div id="collapse'.$no_kategori.'" class="accordion-collapse collapse" aria-labelledby="heading'.$no_kategori.'" data-bs-parent="#accordionExample" style="">';
                                        echo '      <div class="accordion-body">';
                                        echo '          <input type="checkbox" class="KelasKategori" id="IdKategori'.$no_kategori.'" value="'.$no_kategori.'">';
                                        echo '          <label for="IdKategori'.$no_kategori.'"><small class="credit">Pilih Semua</small></label>';
                                        echo '          <ul class="">';
                                                            $no_fitur=1;
                                                            $QryFitur = mysqli_query($Conn, "SELECT * FROM akses_fitur WHERE kategori='$kategori' ORDER BY nama ASC");
                                                            while ($DataFitur = mysqli_fetch_array($QryFitur)) {
                                                                $id_akses_fitur= $DataFitur['id_akses_fitur'];
                                                                $nama= $DataFitur['nama'];
                                                                $keterangan= $DataFitur['keterangan'];
                                                                $kode= $DataFitur['kode'];
                                                                echo '<li class="">';
                                                                echo '  <div cass="row">';
                                                                echo '      <div cass="col-md-12">';
                                                                echo '          <input type="checkbox" name="rules[]" class="ListFitur" kategori="'.$no_kategori.'" id="IdFitur'.$id_akses_fitur.'" value="'.$id_akses_fitur.'">';
                                                                echo '          <label for="IdFitur'.$id_akses_fitur.'" title="'.$keterangan.'"><smal><code class="text text-grayish">'.$nama.'</code></smal></label>';
                                                                echo '      </div>';
                                                                echo '  </div>';
                                                                echo '</li>';
                                                            }
                                        echo '          </ul>';
                                        echo '      </div>';
                                        echo '  </div>';
                                        echo '</div>';
                                        $no_kategori++;
                                    }
                                    echo '</div>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center" id="NotifikasiTambahAksesEntitias"></div>
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
<div class="modal fade" id="ModalDetailEntitias" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-info-circle"></i> Detail Entitas Akses
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormDetailEntitias">
                        
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
<div class="modal fade" id="ModalHapusAksesEntitas" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusAksesEntitas" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus AksesEntitas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapusAksesEntitas">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiHapusAksesEntitas">
                            
                        </div>
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
<div class="modal fade" id="ModalEditAksesEntitas" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditAksesEntitas" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit AksesEntitas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditAksesEntitas">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEditAksesEntitas">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tidak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>