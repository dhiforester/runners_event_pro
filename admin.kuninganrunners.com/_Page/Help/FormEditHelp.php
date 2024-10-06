<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'GA4iqizxbIlTU5mMo0W');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        if(empty($_GET['id'])){
            echo "<span>ID cannot be empty</span>";
        }else{
            $id_help=$_GET['id'];
            $author=GetDetailData($Conn,'help','id_help',$id_help,'author');
            $judul=GetDetailData($Conn,'help','id_help',$id_help,'judul');
            $kategori=GetDetailData($Conn,'help','id_help',$id_help,'kategori');
            $deskripsi=GetDetailData($Conn,'help','id_help',$id_help,'deskripsi');
            $datetime_creat=GetDetailData($Conn,'help','id_help',$id_help,'datetime_creat');
            $datetime_update=GetDetailData($Conn,'help','id_help',$id_help,'datetime_update');
            $status=GetDetailData($Conn,'help','id_help',$id_help,'status');
?>
    <input type="hidden" name="id_help" id="id_help" value="<?php echo "$id_help"; ?>">
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                    echo '  Berikut ini adalah halaman form untuk merubah data bantuan pengguna.';
                    echo '  Tulis informasi secara lengkap dengan judul yang mewakili keseluruhan isi konten.';
                    echo '  Gunakan juga kalimat yang sering dicari sehingga pengguna dapat menemukan informasi yang sesuai';
                    echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="card-title">
                                    <i class="bi bi-pencil"></i> Ubah/Edit Konten Bantuan
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="judul">Judul Bantuan</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="judul" id="judul" class="form-control" value="<?php echo "$judul"; ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="kategori">Kategori Bantuan</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="kategori" id="kategori" list="ListCategori" class="form-control" value="<?php echo "$kategori"; ?>">
                                <datalist id="ListCategori">
                                    <?php
                                        //Tampilkan list categori help
                                        $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM help ORDER BY kategori ASC");
                                        while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                                            $kategori_list=$DataKategori['kategori'];
                                            echo '<option value="'.$kategori_list.'">';
                                        }
                                    ?>
                                </datalist>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="status">Status</label>
                            </div>
                            <div class="col-md-9">
                                <select name="status" id="status" class="form-control">>
                                    <option <?php if($status==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($status=="Publish"){echo "selected";} ?> value="Publish">Publish</option>
                                    <option <?php if($status=="Draft"){echo "selected";} ?> value="Draft">Draft</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="deskripsi">Isi Konten</label>
                            </div>
                            <div class="col-md-9">
                                <textarea name="deskripsi" id="deskripsi_edit" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                <span class="text-dark">Pastikan data yang anda input sudah sesuai</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3"></div>
                            <div class="col-md-9" id="NotifikasiEditHelp"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="submit" class="btn btn-md btn-rounded btn-primary btn-block" id="ClickSimpanEditHelp">
                                    <i class="bi bi-save"></i> Simpan
                                </button>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a href="index.php?Page=Help&Sub=HelpData" class="btn btn-md btn-dark btn-rounded btn-block">
                                    <i class="bi bi-chevron-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php 
        } 
    } 
?>