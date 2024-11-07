//Fungsi Menampilkan Data Hero
function ShowHero() {
    $('#hero-carousel').html('Loading...');
    $.ajax({
        type    : 'POST',
        url     : '_Partial/Hero.php',
        success: function(data) {
            $('#hero-carousel').html(data);
        }
    });
}
//Fungsi Menampilkan Data Album
function ShowAlbum() {
    $('#ShowAlbum').html('Loading...');
    $.ajax({
        type    : 'POST',
        url     : '_Partial/Album.php',
        success: function(data) {
            $('#ShowAlbum').html(data);
        }
    });
}
//Fungsi Menampilkan Data Testimonial
function ShowTestimonial() {
    $('#ShowTestimonial').html('Loading...');
    $.ajax({
        type    : 'POST',
        url     : '_Partial/Testimonial.php',
        success: function(data) {
            $('#ShowTestimonial').html(data);
        }
    });
}
//Fungsi Menampilkan FAQ
function ShowFaq() {
    $('#accordion-faq').html('Loading...');
    $.ajax({
        type    : 'POST',
        url     : '_Partial/Faq.php',
        success: function(data) {
            $('#accordion-faq').html(data);
        }
    });
}
//Menampilkan Data Pertama Kali
$(document).ready(function() {
    //Menampilkan Data Pertama kali
    ShowHero();
    ShowAlbum();
    ShowTestimonial();
    ShowFaq();
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
});