<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/Function.php";
    include "../../_Config/Session.php";
    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Propinsi'"));
    if(empty($jml_data)){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="card">';
        echo '          <div class="card-body text-center text-danger">';
        echo '              Data Wilayah Provinsi Tidak Ada';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12" id="InformationWilayah">';
        echo '  </div>';
        echo '</div>';
        $no = 1;
        //KONDISI PENGATURAN MASING FILTER
        $query = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Propinsi' ORDER BY propinsi ASC");
        while ($data = mysqli_fetch_array($query)) {
            $id_wilayah= $data['id_wilayah'];
            $kategori= $data['kategori'];
            $propinsi= $data['propinsi'];
            //Jumlah Kabupaten
            $JumlahKabupaten = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Kabupaten' AND propinsi='$propinsi'"));
    ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b class="card-title">
                            <a href="javascript:void(0);" id="NamaProvinsi<?php echo "$id_wilayah"; ?>" class="text-info ShowKabupaten" value="<?php echo "$id_wilayah"; ?>" show="true">
                                <?php echo "$no. $propinsi"; ?>
                            </a>
                        </b>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-4">ID Provinsi</div>
                            <div class="col-md-8">
                                <code class="text text-grayish"><?php echo "$id_wilayah"; ?></code>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">Jumlah Kabupaten</div>
                            <div class="col-md-8">
                                <code class="text text-grayish"><?php echo "$JumlahKabupaten Kabupaten"; ?></code>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" id="TampilkanDataKabupatenByProvinsi<?php echo "$id_wilayah"; ?>"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-sm btn-outline-black" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots"></i> Option
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                            <li class="dropdown-header text-start">
                                <h6>Option</h6>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalTambahKabupatenKota" data-id="<?php echo "$id_wilayah"; ?>">
                                    <i class="bi bi-plus"></i> Tambah Kabupaten/Kota
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalEditPropinsi" data-id="<?php echo "$id_wilayah"; ?>">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalHapusPropinsi" data-id="<?php echo "$id_wilayah"; ?>">
                                    <i class="bi bi-x"></i> Hapus
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDownloadKabupaten" data-id="<?php echo "$id_wilayah"; ?>">
                                    <i class="bi bi-download"></i> Download Kabupaten
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
<?php
            $no++; 
        }
    }
?>
<script>
    //Ketika KeywordBy Diubah
    $('.ShowKabupaten').click(function(){
        var id_wilayah = $(this).attr('value');
        var show = $(this).attr('show');
        if(show=="true"){
            $('#TampilkanDataKabupatenByProvinsi'+id_wilayah).html('Loading...');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RegionalData/TabelKabupaten.php',
                data 	    :  {id_wilayah: id_wilayah},
                success     : function(data){
                    $('#TampilkanDataKabupatenByProvinsi'+id_wilayah).html(data);
                    //Remove Class
                    $('#NamaProvinsi'+id_wilayah).removeClass('text-info');
                    $('#NamaProvinsi'+id_wilayah).addClass('text-primary');
                    //Merubah Nilai Atribut Show
                    $('#NamaProvinsi'+id_wilayah).attr('show', 'false');
                }
            });
        }else{
            $('#TampilkanDataKabupatenByProvinsi'+id_wilayah).html("");
            //Remove Class
            $('#NamaProvinsi'+id_wilayah).removeClass('text-primary');
            $('#NamaProvinsi'+id_wilayah).addClass('text-info');
            //Merubah Nilai Atribut Show
            $('#NamaProvinsi'+id_wilayah).attr('show', 'true');
        }
    });
</script>