//Fungsi Menampilkan Data Aktivitas User
function ShowMyActivity() {
    $('#MenampilkanTabelAktivitas').html('Loading...');
    var ProsesFilterAktivitas = $('#ProsesFilterAktivitas').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/MyProfile/TabelAktivitas.php',
        data    :  ProsesFilterAktivitas,
        success: function(data) {
            $('#MenampilkanTabelAktivitas').html(data);
        }
    });
}
//Menampilkan Data Pertama Kali
$(document).ready(function() {
    ShowMyActivity();
});
//Ketika keyword_by_aktivitas Diubah
$('#keyword_by_aktivitas').change(function(){
    $('#FormKeywordAktivitas').html('....');
    var keyword_by_aktivitas = $('#keyword_by_aktivitas').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/MyProfile/FormKeywordAktivitas.php',
        data        : {keyword_by_aktivitas: keyword_by_aktivitas},
        success     : function(data){
            $('#FormKeywordAktivitas').html(data);
        }
    });
});
//Proses Pencarian Aktivitas
$('#ProsesFilterAktivitas').submit(function(){
    $('#PageFilterAktivitas').val('1');
    ShowMyActivity();
    $('#ModalFilterAktivitas').modal('hide');
});
//Edit Akses 
$('#ProsesEditAkses123').submit(function(){
    $('#NotifikasiEditProfile').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesEditAkses123')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/MyProfile/ProsesEditAkses.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditProfile').html(data);
            var NotifikasiEditAksesBerhasil=$('#NotifikasiEditAksesBerhasil').html();
            if(NotifikasiEditAksesBerhasil=="Success"){
                location.reload();
            }
        }
    });
});
//Modal Ubah Foto Profil
$('#ModalUbahFotoProfil').on('show.bs.modal', function (e) {
    $('#FormUbahFotoProfil').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/MyProfile/FormUbahFotoProfil.php',
        success     : function(data){
            $('#FormUbahFotoProfil').html(data);
            $('#NotifikasiUbahFotoProfil').html("");
        }
    });
});
//Proses Upload Foto
$('#ProsesUbahFotoProfil').submit(function(){
    $('#NotifikasiUbahFotoProfil').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesUbahFotoProfil')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/MyProfile/ProsesUbahFotoProfil.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiUbahFotoProfil').html(data);
            var NotifikasiUbahFotoProfilBerhasil=$('#NotifikasiUbahFotoProfilBerhasil').html();
            if(NotifikasiUbahFotoProfilBerhasil=="Success"){
                window.location.href = "index.php?Page=MyProfile";
            }
        }
    });
});
//Modal Ubah Profil
$('#ModalUbahInformasiProfil').on('show.bs.modal', function (e) {
    $('#FormUbahInformasiProfil').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/MyProfile/FormUbahInformasiProfil.php',
        success     : function(data){
            $('#FormUbahInformasiProfil').html(data);
            $('#NotifikasiUbahInformasiProfil').html("");
        }
    });
});
//Proses Ubah Informasi Profile  
$('#ProsesUbahInformasiProfil').submit(function(){
    $('#NotifikasiUbahInformasiProfil').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesUbahInformasiProfil')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/MyProfile/ProsesUbahInformasiProfil.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiUbahInformasiProfil').html(data);
            var NotifikasiUbahInformasiProfilBerhasil=$('#NotifikasiUbahInformasiProfilBerhasil').html();
            if(NotifikasiUbahInformasiProfilBerhasil=="Success"){
                window.location.href = "index.php?Page=MyProfile";
            }
        }
    });
});

//Modal Ubah Pasword
$('#ModalUbahPassword').on('show.bs.modal', function (e) {
    $('#FormUbahPassword').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/MyProfile/FormUbahPassword.php',
        success     : function(data){
            $('#FormUbahPassword').html(data);
            $('#NotifikasiUbahPassword').html("");
        }
    });
});
//Edit Password 
$('#ProsesUbahPassword').submit(function(){
    $('#NotifikasiUbahPassword').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesUbahPassword')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/MyProfile/ProsesUbahPassword.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiUbahPassword').html(data);
            var NotifikasiUbahPasswordBerhasil=$('#NotifikasiUbahPasswordBerhasil').html();
            if(NotifikasiUbahPasswordBerhasil=="Success"){
                window.location.href = "index.php?Page=MyProfile";
            }
        }
    });
});