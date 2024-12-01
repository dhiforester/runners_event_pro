<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Harus Login Terlebih Dulu
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <code>Sesi Login Sudah Berakhir, Silahkan Login Ulang!</code>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Tangkap id_barang
        if(empty($_POST['id_barang'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <code>ID Barang Tidak Boleh Kosong</code>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_barang=$_POST['id_barang'];
            //Bersihkan Variabel
            $id_barang=validateAndSanitizeInput($id_barang);
            //Buka data member
            $ValidasiIdBarang=GetDetailData($Conn,'barang','id_barang',$id_barang,'id_barang');
            if(empty($ValidasiIdBarang)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <code>ID Barang Tidak Valid Atau Tidak Ditemukan Pada Database</code>';
                echo '  </div>';
                echo '</div>';
            }else{
                $marketplace=GetDetailData($Conn,'barang','id_barang',$id_barang,'marketplace');
?>
                <form action="javascript:void(0);" id="ProsesTambahMarketplace">
                    <input type="hidden" name="id_barang" value="<?php echo $id_barang; ?>">
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <button type="button" class="btn btn-md btn-outline-primary btn-block" id="add_row">
                                <i class="bi bi-plus"></i> Tambah Baris
                            </button>
                        </div>
                        <div class="col-md-10 text-left"></div>
                    </div>
                    <div class="row mb-3" id="ListForm">
                        <?php
                            //Apabila Sebelumnya Sudah Ada Data List Marketplace
                            if(!empty($marketplace)){
                                $marketplace_arry=json_decode($marketplace, true);
                                if(!empty(count($marketplace_arry))){
                                    foreach($marketplace_arry as $marketplace_list){
                                        $nama_marketplace=$marketplace_list['nama_marketplace'];
                                        $url_marketplace=$marketplace_list['url_marketplace'];
                                        echo '<div class="col-md-12 mb-3">';
                                        echo '  <div class="input-group">';
                                        echo '      <input type="text" name="nama_marketplace[]" class="form-control" placeholder="Marketplace" value="'.$nama_marketplace.'">';
                                        echo '      <input type="text" name="url_marketplace[]" class="form-control" placeholder="URL/Link" value="'.$url_marketplace.'">';
                                        echo '      <button type="button" class="btn btn-sm btn-danger remove_row_form">';
                                        echo '          <i class="bi bi-x"></i>';
                                        echo '      </button>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }
                                }
                            }else{
                                echo '<div class="col-md-12 mb-3">';
                                echo '  <div class="input-group">';
                                echo '      <input type="text" name="nama_marketplace[]" class="form-control" placeholder="Marketplace">';
                                echo '      <input type="text" name="url_marketplace[]" class="form-control" placeholder="URL/Link">';
                                echo '      <button type="button" class="btn btn-sm btn-danger remove_row_form">';
                                echo '          <i class="bi bi-x"></i>';
                                echo '      </button>';
                                echo '  </div>';
                                echo '</div>';
                            }
                        ?>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-left" id="NotifikasiTambahMarketplace"> 
                            <!-- Notifikasi Tambah Marketplace -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-left"> 
                            <button type="submit" class="btn btn-md btn-primary" id="ButtonTambahMarketplace">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </div>
                    </div>
                </form>
<?php 
            } 
        } 
    } 
?>
<script>
    $(document).ready(function () {
        // Tambahkan baris baru ke dalam #ListForm saat tombol Tambah Baris di klik
        $('#add_row').click(function () {
            const newRow = `
                <div class="col-md-12 mb-3">
                    <div class="input-group">
                        <input type="text" name="nama_marketplace[]" class="form-control" placeholder="Marketplace">
                        <input type="text" name="url_marketplace[]" class="form-control" placeholder="URL/Link">
                        <button type="button" class="btn btn-sm btn-danger remove_row_form">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>`;
            $('#ListForm').append(newRow);
        });

        // Hapus baris saat tombol Hapus Baris (remove_row_form) di klik
        $(document).on('click', '.remove_row_form', function () {
            $(this).closest('.col-md-12').remove();
        });
        //Proses Simpan Marketplace
        $('#ProsesTambahMarketplace').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#ButtonTambahMarketplace').html('Loading...').prop('disabled', true);
            
            $.ajax({
                url: '_Page/Merchandise/ProsesTambahMarketplace.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#ButtonTambahMarketplace').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    var result;
                    try {
                        result = JSON.parse(response); // Mencoba untuk parse JSON
                    } catch (e) {
                        $('#NotifikasiTambahMarketplace').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                        return; // Keluar dari fungsi jika JSON tidak valid
                    }
                    if (result.success) {
                        $('#ButtonTambahMarketplace').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                        $('#NotifikasiTambahMarketplace').html('');
                        ShowMarketplace();
                        Swal.fire('Berhasil!', 'Marketplace Barang Berhasil Diatur', 'success');
                    } else {
                        // Menampilkan pesan kesalahan dari server
                        $('#NotifikasiTambahMarketplace').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                    }
                },
                error: function () {
                    $('#ButtonTambahMarketplace').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#NotifikasiTambahMarketplace').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
                }
            });
        });
    });
</script>