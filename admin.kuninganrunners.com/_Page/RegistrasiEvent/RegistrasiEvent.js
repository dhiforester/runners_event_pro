function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/RegistrasiEvent/TabelRegistrasiEvent.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanTabelRegistrasiEvent').html(data);
        }
    });
}
//Menampilkan Data Pertama Kali
$(document).ready(function() {
    //Menampilkan Data Pertama kali
    filterAndLoadTable();
    //Ketika Keyword By Diubah
    $('#keyword_by').change(function(){
        var keyword_by =$('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RegistrasiEvent/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });
    //Filter Data
    $('#ProsesFilter').submit(function(){
        $('#page').val("1");
        filterAndLoadTable();
        $('#ModalFilter').modal('hide');
    });
    $('#ModalDetail').on('show.bs.modal', function (e) {
        var kode_transaksi = $(e.relatedTarget).data('id');
        $('#FormDetail').html("Loading...");
        $.ajax({
            type        : 'POST',
            url         : '_Page/RegistrasiEvent/FormDetail.php',
            data        : { kode_transaksi: kode_transaksi },
            success     : function(data) {
                $('#FormDetail').html(data);
            }
        });
    });
});