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
//Fungsi Menampilkan List Event All
function ShowEventAll() {
    $('#ListAllEvent').html('Loading...');
    $.ajax({
        type    : 'POST',
        url     : '_Partial/Event.php',
        success: function(data) {
            $('#ListAllEvent').html(data);
        }
    });
}
//Fungsi Menampilkan List Event All
function ShowMerchandise() {
    $('#ShowMerchandise').html('Loading...');
    $.ajax({
        type    : 'POST',
        url     : '_Partial/Merchandise.php',
        success: function(data) {
            $('#ShowMerchandise').html(data);
        }
    });
}
//Fungsi Menampilkan List Member Baru
function ShowMemberList() {
    $('#ShowMemberList').html('Loading...');
    $.ajax({
        type    : 'POST',
        url     : '_Partial/Member.php',
        success: function(data) {
            $('#ShowMemberList').html(data);
        }
    });
}
//Fungsi Menampilkan List Vidio
function ShowVidio() {
    $('#ShowVidio').html('Loading...');
    $.ajax({
        type    : 'POST',
        url     : '_Page/Vidio/Vidio.php',
        success: function(data) {
            $('#ShowVidio').html(data);
        }
    });
}
//Menampilkan Data Pertama Kali
$(document).ready(function() {
    //Proses Penanganan Konten Tentang Kami
    // Ambil elemen konten dan tombol
    const $konten = $('#KontenTentangKami');
    const $buttonMore = $('#ButtonTentangKamiMore');

    // Baca isi konten
    const fullContent = $konten.text().trim();
    const wordLimit = 150;

    // Pisahkan isi konten menjadi array kata
    const words = fullContent.split(/\s+/);

    // Cek jumlah kata
    if (words.length > wordLimit) {
        // Potong konten jika jumlah kata lebih dari 150
        const previewContent = words.slice(0, wordLimit).join(' ') + '...';
        $konten.text(previewContent);
    } else {
        // Sembunyikan tombol jika kata kurang dari atau sama dengan 150
        $buttonMore.hide();
    }

    // Event listener untuk tombol "Lihat Selengkapnya"
    $buttonMore.on('click', function () {
        // Tampilkan seluruh konten
        $konten.text(fullContent);

        // Sembunyikan tombol
        $buttonMore.hide();
    });
    //Menampilkan Data Pertama kali
    ShowHero();
    ShowAlbum();
    ShowTestimonial();
    ShowFaq();
    ShowEventAll();
    ShowMerchandise();
    ShowMemberList();
    ShowVidio();
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