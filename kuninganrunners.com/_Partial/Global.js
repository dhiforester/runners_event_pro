$(document).ready(function() {
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