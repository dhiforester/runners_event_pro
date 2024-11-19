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
});