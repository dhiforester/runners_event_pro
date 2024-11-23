<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'Uh6eRRIoBS026VsAaEf');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        if(empty($_GET['id'])){
            echo '<section class="section dashboard">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12">';
            echo '          <div class="alert alert-warning alert-dismissible fade show" role="alert">';
            echo '              <small>';
            echo '                  <code class="text-dark">';
            echo '                      ID testimoni tidak boleh kosong!';
            echo '                  </code>';
            echo '              </small>';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</section>';
        }else{
            $id_web_testimoni=$_GET['id'];
            echo '<input type="hidden" id="GetIdTestimoni" value="'.$id_web_testimoni.'">';
?>
        <section class="section dashboard">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                        echo '  <small>';
                        echo '      <code class="text-dark">';
                        echo '          Berikut ini adalah detail informasi testimoni yang digunakan untuk memoderasi penilain member terhadap pelayanan ';
                        echo '          yang bersumber dari website. Pada halaman ini anda bisa menentukan status testimoni dan mengubah informasi lainnya pada data tersebut.';
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
                        <div class="card-header">
                            <h4 class="card-title">
                                <i class="bi bi-info-circle"></i> Detail Testimoni
                            </h4>
                            <div class="filter">
                                <a class="icon text-grayish" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                    <small>
                                        <i class="bi bi-three-dots"></i> Opsi
                                    </small>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                    <li class="dropdown-header text-start">
                                        <h6>Option</h6>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="index.php?Page=Testimoni">
                                            <i class="bi bi-chevron-left"></i> Kembali
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModelEditTestimoni" data-id="<?php echo "$id_web_testimoni"; ?>">
                                            <i class="bi bi-pencil"></i> Edit Konten
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahStatus" data-id="<?php echo "$id_web_testimoni"; ?>">
                                            <i class="bi bi-tag"></i> Ubah Status
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahFoto" data-id="<?php echo "$id_web_testimoni"; ?>">
                                            <i class="bi bi-image"></i> Ubah Foto
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body" id="MenampilkanDetailTestimoni">

                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php
        }
    }
?>