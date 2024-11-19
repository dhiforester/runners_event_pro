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
});