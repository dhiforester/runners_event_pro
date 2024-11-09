$(document).ready(function() {
    //Modal Detail Testimoni
    $('#ModalDetailTestimoni').on('show.bs.modal', function (e) {
        var id_web_testimoni = $(e.relatedTarget).data('id');
        $('#FormDetailTestimoni').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Home/FormDetailTestimoni.php',
            data        : {id_web_testimoni: id_web_testimoni},
            success     : function(data){
                $('#FormDetailTestimoni').html(data);
            }
        });
    });
    //Modal Menampilkan Privacy Policy
    $('#ModalPrivacyPolicy').on('show.bs.modal', function (e) {
        $('#FormPrivacyPolicy').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Partial/PrivacyPolicy.php',
            success     : function(data){
                $('#FormPrivacyPolicy').html(data);
            }
        });
    });
    //Modal Menampilkan Term Of Service
    $('#ModalTermOfService').on('show.bs.modal', function (e) {
        $('#FormTermOfService').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Partial/TermOfService.php',
            success     : function(data){
                $('#FormTermOfService').html(data);
            }
        });
    });
});