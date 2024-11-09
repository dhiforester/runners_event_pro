//Kondisi saat tampilkan password
$('#tampilkan_password').click(function(){
    if($(this).is(':checked')){
        $('#password').attr('type','text');
    }else{
        $('#password').attr('type','password');
    }
});