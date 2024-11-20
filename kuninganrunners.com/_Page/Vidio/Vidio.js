//Fungsi Menampilkan Data
function FilterVidio() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/Vidio/TabelVidio.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanListVidio').html(data);
        }
    });
}
$(document).ready(function() {
    //Menampilkan Data Pertama Kali
    FilterVidio();
    //Ketika Modal Detail
    $('#ModalDetailVidio').on('show.bs.modal', function (e) {
        var id_web_vidio = $(e.relatedTarget).data('id');
        $('#FormDetailVidio').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Vidio/FormDetail.php',
            data        : {id_web_vidio: id_web_vidio},
            success     : function(data){
                $('#FormDetailVidio').html(data);
            }
        });
    });
    $('#ModalDetailVidio').on('hidden.bs.modal', function (e) {
        // Kosongkan konten form detail
        $('#FormDetailVidio').html(""); 
    });
});
