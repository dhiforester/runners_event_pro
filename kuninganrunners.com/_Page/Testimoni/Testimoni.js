//Fungsi Menampilkan Data
function FilterTestimoni() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/Testimoni/TabelTestimoni.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanListTestimoni').html(data);
        }
    });
}
$(document).ready(function() {
    //Menampilkan Data Pertama Kali
    FilterTestimoni();
});
