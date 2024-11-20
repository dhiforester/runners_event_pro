//Fungsi Menampilkan Data
function FilterAlbum() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/Galeri/TabelAlbum.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanListAlbum').html(data);
        }
    });
}
$(document).ready(function() {
    //Menampilkan Data Pertama Kali
    FilterAlbum();
});
