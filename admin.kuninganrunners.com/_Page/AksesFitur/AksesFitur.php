<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'rA8MRFArw1qPeVySjAC');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                    echo '  <small class="credit">';
                    echo '      <code class="text-dark">';
                    echo '          Berikut ini adalah halaman pengelolaan data fitur aplikasi yang digunakan oleh pengembang untuk memetakan ijin akses setiap pengguna pada halaman dan modul aplikasi.';
                    echo '          Penting untuk diketahui bahwa mengubah data pada halaman ini, akan merubah aturan khusus pada fitur yang digunakan.';
                    echo '          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '      </code>';
                    echo '  </small>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="javascript:void(0);" id="ProsesBatas">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    
                                </div>
                                <div class="col col-md-2 mb-3">
                                    <button type="button" class="btn btn-md btn-outline-dark btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalFilter">
                                        <i class="bi bi-funnel"></i> Filter
                                    </button>
                                </div>
                                <div class="col col-md-2 mb-3">
                                    <button type="button" class="btn btn-md btn-primary btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalTambahFitur">
                                        <i class="bi bi-plus"></i> Tambah
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" id="MenampilkanTabelFitur">
                <!-- Data Fitur Akses Akan Ditampilkan Disini -->
            </div>
        </div>
    </section>
<?php } ?>