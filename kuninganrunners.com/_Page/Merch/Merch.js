//Fungsi Menampilkan List Event All
function ShowMerchandiseList() {
    var page=$('#put_page').val();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Merch/ListMerch.php',
        data    : {page: page},
        success: function(data) {
            $('#ShowMerchandiseList').html(data);
        }
    });
}
//Menampilkan Data Pertama Kali
$(document).ready(function() {
    //Menampilkan Data Pertama kali
    ShowMerchandiseList();
    // Proses Tambah Keranjang
    $('#ProsesTambahKeranjang').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#ButtonTambahKeranjang').html('Loading...').prop('disabled', true);

        $.ajax({
            url             : '_Page/Merch/ProsesTambahKeranjang.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            success: function (response) {
                $('#ButtonTambahKeranjang').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                var result;
                try {
                    // Mencoba untuk parse JSON
                    result = JSON.parse(response);
                } catch (e) {
                    $('#NotifikasiTambahKeranjang').html('<div class="alert alert-danger">Gagal memproses respons dari server.</div>');
                    // Keluar dari fungsi jika JSON tidak valid
                    return;
                }
                if (result.code === 200) {
                    var id_barang = result.id_barang;
                    //Reset Form
                    $('#ProsesTambahKeranjang')[0].reset();
                    //Tutup Modal
                    $('#ModalTambahKeranjang').modal('hide');
                    // Menampilkan swal pemberitahuan
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Barang berhasil ditambahkan ke keranjang.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Reload halaman setelah swal ditutup
                            location.reload();
                        }
                    });
                } else {
                    // Menampilkan pesan kesalahan dari server
                    $('#NotifikasiTambahKeranjang').html('<div class="alert alert-danger"><small><code class="text-dark">' + result.message + '</code></small></div>');
                }
            },
            error: function () {
                $('#ButtonTambahKeranjang').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                $('#NotifikasiTambahKeranjang').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi nanti.</div>');
            }
        });
    });
});