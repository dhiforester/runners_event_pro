//Proses Simpan Setting Payment
$('#ProsesSettingPayment').submit(function(){
    $('#NotifikasiSimpanSettingPayment').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesSettingPayment')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SettingService/ProsesSettingPayment.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiSimpanSettingPayment').html(data);
            var NotifikasiSimpanSettingPaymentBerhasil=$('#NotifikasiSimpanSettingPaymentBerhasil').html();
            if(NotifikasiSimpanSettingPaymentBerhasil=="Success"){
                window.location.href = "index.php?Page=SettingPayment";
            }
        }
    });
});
//Snap Token Test
$('#ModalTestSnapToken').on('show.bs.modal', function (e) {
    var ServerKey=$('#server_key').val();
    var production=$('#production').val();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12 text-center"><div class="spinner-border text-secondary" role="status"><span class="sr-only">Loading...</span></div></div></div></div>';
    $('#TestSnapToken').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SettingService/TestSnapToken.php',
        data        :  {ServerKey: ServerKey, production: production},
        success     : function(data){
            $('#TestSnapToken').html(data);
            $('#ProsesTestSnapToken').submit(function(){
                $('#NotifikasiSnapToken').html("Loading..");
                var form = $('#ProsesTestSnapToken')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SettingService/ProsesTestSnapToken.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiSnapToken').html(data);
                        var GetDataToken=$('#TokenDiperoleh').html();
                        if(GetDataToken!=""){
                            $('#snap_token').val(GetDataToken);
                        }
                    }
                });
            });
            $('#GenerateSnapButton').click(function(){
                $('#NotifikasiSnapToken').html("Loading..");
                var form = $('#ProsesTestSnapToken')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SettingService/ProsesTestGenerateButton.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiSnapToken').html(data);
                    }
                });
            });
        }
    });
});
//Proses Simpan Setting Payment
$('#ProsesSettingPayment').submit(function(){
    $('#NotifikasiSimpanSettingPayment').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesSettingPayment')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SettingService/ProsesSettingPayment.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiSimpanSettingPayment').html(data);
            var NotifikasiSimpanSettingPaymentBerhasil=$('#NotifikasiSimpanSettingPaymentBerhasil').html();
            if(NotifikasiSimpanSettingPaymentBerhasil=="Success"){
                window.location.href = "index.php?Page=SettingPayment";
            }
        }
    });
});