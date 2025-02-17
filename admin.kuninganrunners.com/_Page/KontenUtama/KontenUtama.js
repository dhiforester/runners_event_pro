//Ketika nama medsos Diketik
function FormKetik(FormId,FormLengthId) {
    $(FormId).on('input', function() {
        var value = $(this).val();
        var maxLength = 250;
        // Jika panjang melebihi batas, potong sesuai maxLength
        if (value.length > maxLength) {
            value = value.substring(0, maxLength);
        }
        // Update nilai input
        $(this).val(value); 
        // Tampilkan jumlah karakter saat ini
        $(FormLengthId).text(value.length + '/' + maxLength);
    });
}
// Fungsi validasi file
function validateFile(input, validationMessageElement) {
    const file = input[0].files[0];
    const validTypes = ["image/png", "image/jpg", "image/jpeg", "image/gif"];
    const maxSize = 1 * 1024 * 1024; // 1 MB dalam byte

    // Reset pesan validasi
    $(validationMessageElement).html(""); // Mengosongkan elemen kode

    if (file) {
        // Validasi tipe file
        if (!validTypes.includes(file.type)) {
            $(validationMessageElement).html("<span style='color: red;'>Tipe file tidak valid. Harap pilih file dengan tipe PNG, JPG, JPEG, atau GIF.</span><br>");
            input.val(""); // Reset input file
            return false;
        }

        // Validasi ukuran file
        if (file.size > maxSize) {
            $(validationMessageElement).html("<span style='color: red;'>Ukuran file terlalu besar. Maksimal ukuran adalah 1 MB.</span><br>");
            input.val(""); // Reset input file
            return false;
        }

        // Jika validasi berhasil
        $(validationMessageElement).html("<span style='color: green;'>File valid dan siap diunggah.</span><br>");
        return true;
    }
}
//Fungsi Menampilkan Tentang
function ShowTentang() {
    //Ketika Edit Konten Tentang Di Click
    var GetTentangKonten=$('#GetTentangKonten').html();
    tinymce.init({
        selector: '#tentang',
        setup: function (editor) {
            editor.on('init', function (e) {
                editor.setContent(GetTentangKonten);
            });
        },
        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'table emoticons template paste help'
        ],
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
        'bullist numlist outdent indent | link image | print preview media fullscreen charmap | ' +
        'forecolor backcolor emoticons | help',
        menu: {
            favs: {title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons'}
        },
        menubar: 'favs file edit view insert format tools table help',
        content_css: 'assets/css/tinymce.css',
        images_upload_url: '_Page/PostAcceptor/PostAcceptor.php',
        images_upload_credentials: true,
        images_reuse_filename: true,
        image_title: true,
        /* enable automatic uploads of images represented by blob or data URIs*/
        automatic_uploads: true,
        /*
            URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
            images_upload_url: 'postAcceptor.php',
            here we add custom filepicker only to Image dialog
        */
        file_picker_types: 'image',
        /* and here's our custom image picker*/
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            /*
            Note: In modern browsers input[type="file"] is functional without
            even adding it to the DOM, but that might not be the case in some older
            or quirky browsers like IE, so you might want to add it to the DOM
            just in case, and visually hide it. And do not forget do remove it
            once you do not need it anymore.
            */

            input.onchange = function () {
            var file = this.files[0];

            var reader = new FileReader();
            reader.onload = function () {
                /*
                Note: Now we need to register the blob in TinyMCEs image blob
                registry. In the next release this part hopefully won't be
                necessary, as we are looking to handle it internally.
                */
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);

                /* call the callback and populate the Title field with the file name */
                cb(blobInfo.blobUri(), { title: file.name });
            };
            reader.readAsDataURL(file);
            };

            input.click();
        },
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        height : "480"
    });
}
//Fungsi Menampilkan Term Of Service
function ShowTermOfService() {
    //Ketika Edit Konten Tentang Di Click
    var GetTermOfService=$('#GetTermOfService').html();
    tinymce.init({
        selector: '#term_of_service',
        setup: function (editor) {
            editor.on('init', function (e) {
                editor.setContent(GetTermOfService);
            });
        },
        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'table emoticons template paste help'
        ],
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
        'bullist numlist outdent indent | link image | print preview media fullscreen charmap | ' +
        'forecolor backcolor emoticons | help',
        menu: {
            favs: {title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons'}
        },
        menubar: 'favs file edit view insert format tools table help',
        content_css: 'assets/css/tinymce.css',
        images_upload_url: '_Page/PostAcceptor/PostAcceptor.php',
        images_upload_credentials: true,
        images_reuse_filename: true,
        image_title: true,
        /* enable automatic uploads of images represented by blob or data URIs*/
        automatic_uploads: true,
        /*
            URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
            images_upload_url: 'postAcceptor.php',
            here we add custom filepicker only to Image dialog
        */
        file_picker_types: 'image',
        /* and here's our custom image picker*/
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            /*
            Note: In modern browsers input[type="file"] is functional without
            even adding it to the DOM, but that might not be the case in some older
            or quirky browsers like IE, so you might want to add it to the DOM
            just in case, and visually hide it. And do not forget do remove it
            once you do not need it anymore.
            */

            input.onchange = function () {
            var file = this.files[0];

            var reader = new FileReader();
            reader.onload = function () {
                /*
                Note: Now we need to register the blob in TinyMCEs image blob
                registry. In the next release this part hopefully won't be
                necessary, as we are looking to handle it internally.
                */
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);

                /* call the callback and populate the Title field with the file name */
                cb(blobInfo.blobUri(), { title: file.name });
            };
            reader.readAsDataURL(file);
            };

            input.click();
        },
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        height : "480"
    });
}
//Fungsi Menampilkan Term Of Service
function ShowPrivacyPolicy() {
    //Ketika Edit Konten Tentang Di Click
    var GetPrivacyPolecy=$('#GetPrivacyPolecy').html();
    tinymce.init({
        selector: '#privacy_policy',
        setup: function (editor) {
            editor.on('init', function (e) {
                editor.setContent(GetPrivacyPolecy);
            });
        },
        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'table emoticons template paste help'
        ],
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
        'bullist numlist outdent indent | link image | print preview media fullscreen charmap | ' +
        'forecolor backcolor emoticons | help',
        menu: {
            favs: {title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons'}
        },
        menubar: 'favs file edit view insert format tools table help',
        content_css: 'assets/css/tinymce.css',
        images_upload_url: '_Page/PostAcceptor/PostAcceptor.php',
        images_upload_credentials: true,
        images_reuse_filename: true,
        image_title: true,
        /* enable automatic uploads of images represented by blob or data URIs*/
        automatic_uploads: true,
        /*
            URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
            images_upload_url: 'postAcceptor.php',
            here we add custom filepicker only to Image dialog
        */
        file_picker_types: 'image',
        /* and here's our custom image picker*/
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            /*
            Note: In modern browsers input[type="file"] is functional without
            even adding it to the DOM, but that might not be the case in some older
            or quirky browsers like IE, so you might want to add it to the DOM
            just in case, and visually hide it. And do not forget do remove it
            once you do not need it anymore.
            */

            input.onchange = function () {
            var file = this.files[0];

            var reader = new FileReader();
            reader.onload = function () {
                /*
                Note: Now we need to register the blob in TinyMCEs image blob
                registry. In the next release this part hopefully won't be
                necessary, as we are looking to handle it internally.
                */
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);

                /* call the callback and populate the Title field with the file name */
                cb(blobInfo.blobUri(), { title: file.name });
            };
            reader.readAsDataURL(file);
            };

            input.click();
        },
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        height : "480"
    });
}
function ShowFaq() {
    $.ajax({
        type: 'POST',
        url: '_Page/KontenUtama/ShowFaq.php',
        success: function(data) {
            $('#ShowFaq').html(data);
        },
        error: function(xhr, status, error) {
            console.error('Error ShowFaq:', error);
        }
    });
}
function ShowMedsos() {
    $.ajax({
        type: 'POST',
        url: '_Page/KontenUtama/ShowMedsos.php',
        success: function(data) {
            $('#ShowMedsos').html(data);
        },
        error: function(xhr, status, error) {
            console.error('Error ShowMedsos:', error);
        }
    });
}
$(document).ready(function() {
    //Menampilkan Data Pertama kali
    ShowTentang();
    ShowTermOfService();
    ShowPrivacyPolicy();
    ShowFaq();
    ShowMedsos();
    FormKetik('#web_base_url','#web_base_url_length');
    FormKetik('#web_title','#web_title_length');
    FormKetik('#web_description','#web_description_length');
    FormKetik('#web_keyword','#web_keyword_length');
    FormKetik('#web_author','#web_author_length');
    //Validasi File
    // Event listener untuk input file #web_pavicon
    $("#web_pavicon").change(function () {
        validateFile($(this), "#ValidasiWebPavicon");
    });

    // Event listener untuk input file #web_icon
    $("#web_icon").change(function () {
        validateFile($(this), "#ValidasiWebIcon");
    });
    // Proses Simpan Pengaturan Web
    $('#ProsesSimpanPengaturanWebsite').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonSimpanPengaturanWebsite').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/KontenUtama/ProsesSimpanPengaturanWebsite.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses
                    $('#ModalTambahFaq').modal('hide');
                    $('#ButtonSimpanPengaturanWebsite').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#NotifikasiSimpanPengaturanWebsite').html('');
                    Swal.fire('Berhasil!', 'Tambah Konten FAQ Berhasil', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiSimpanPengaturanWebsite').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonSimpanPengaturanWebsite').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiSimpanPengaturanWebsite').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonSimpanPengaturanWebsite').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    //Proses Simpan Tentang
    $('#ClickSimpanTentangKami').click(function(){
        $('#NotifikasiTentangKami').html('Loading..');
        var judul=$('#judul').val();
        var tentang = tinymce.get("tentang").getContent();
        $.ajax({
            type    : 'POST',
            url     : "_Page/KontenUtama/ProsesSimpanTentang.php",
            data    : {judul: judul, tentang: tentang},
            success: function(data) {
                $('#NotifikasiTentangKami').html(data);
                var NotifikasiTentangKamiBerhasil=$('#NotifikasiTentangKamiBerhasil').html();
                if(NotifikasiTentangKamiBerhasil=="Success"){
                    window.location.href = "index.php?Page=KontenUtama";
                }
            }
        });
    });
    //Proses Simpan Term Of Service
    $('#ClickTermOfService').click(function(){
        $('#NotifikasiTermOfService').html('Loading..');
        var term_of_service = tinymce.get("term_of_service").getContent();
        $.ajax({
            type    : 'POST',
            url     : "_Page/KontenUtama/ProsesSimpanTermOfService.php",
            data    : {term_of_service: term_of_service},
            success: function(data) {
                $('#NotifikasiTermOfService').html(data);
                var NotifikasiTermOfServiceBerhasil=$('#NotifikasiTermOfServiceBerhasil').html();
                if(NotifikasiTermOfServiceBerhasil=="Success"){
                    window.location.href = "index.php?Page=KontenUtama";
                }
            }
        });
    });
    //Proses Simpan Privacy Policy
    $('#ClickPrivacyPolicy').click(function(){
        $('#NotifikasiPrivacyPolicy').html('Loading..');
        var privacy_policy = tinymce.get("privacy_policy").getContent();
        $.ajax({
            type    : 'POST',
            url     : "_Page/KontenUtama/ProsesSimpanPrivacyPolicy.php",
            data    : {privacy_policy: privacy_policy},
            success: function(data) {
                $('#NotifikasiPrivacyPolicy').html(data);
                var NotifikasiPrivacyPolicyBerhasil=$('#NotifikasiPrivacyPolicyBerhasil').html();
                if(NotifikasiPrivacyPolicyBerhasil=="Success"){
                    window.location.href = "index.php?Page=KontenUtama";
                }
            }
        });
    });
    //Ketika Pertanyaan Diketik
    $('#pertanyaan').on('input', function() {
        var value = $(this).val();
        var maxLength = 100;
        // Jika panjang melebihi batas, potong sesuai maxLength
        if (value.length > maxLength) {
            value = value.substring(0, maxLength);
        }
        // Update nilai input
        $(this).val(value); 
        // Tampilkan jumlah karakter saat ini
        $('#pertanyaan_length').text(value.length + '/' + maxLength);
    });
    //Ketika Jawaban Diketik
    $('#jawaban').on('input', function() {
        var value = $(this).val();
        var maxLength = 500;
        // Jika panjang melebihi batas, potong sesuai maxLength
        if (value.length > maxLength) {
            value = value.substring(0, maxLength);
        }
        // Update nilai input
        $(this).val(value); 
        // Tampilkan jumlah karakter saat ini
        $('#jawaban_length').text(value.length + '/' + maxLength);
    });
    // Proses Simpan FAQ
    $('#ProsesTambahFaq').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonTambahFaq').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/KontenUtama/ProsesTambahFaq.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowFaq();
                    $('#ProsesTambahFaq')[0].reset();
                    $('#ModalTambahFaq').modal('hide');
                    $('#ButtonTambahFaq').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#NotifikasiTambahFaq').html('');
                    Swal.fire('Berhasil!', 'Tambah Konten FAQ Berhasil', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiTambahFaq').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonTambahFaq').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiTambahFaq').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonTambahFaq').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    //Ketika Modal Detail FAQ
    $('#ModalDetailFaq').on('show.bs.modal', function (e) {
        var id_web_faq = $(e.relatedTarget).data('id');
        $('#FormDetailFaq').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/KontenUtama/FormDetailFaq.php',
            data        : {id_web_faq: id_web_faq},
            success     : function(data){
                $('#FormDetailFaq').html(data);
            }
        });
    });
    //Ketika Modal Edit FAQ
    $('#ModalEditFaq').on('show.bs.modal', function (e) {
        var id_web_faq = $(e.relatedTarget).data('id');
        $('#FormEditFaq').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/KontenUtama/FormEditFaq.php',
            data        : {id_web_faq: id_web_faq},
            success     : function(data){
                $('#FormEditFaq').html(data);
                $('#NotifikasiEditFaq').html('');
            }
        });
    });
    // Proses Edit FAQ
    $('#ProsesEditFaq').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonEditFaq').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/KontenUtama/ProsesEditFaq.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowFaq();
                    $('#ProsesEditFaq')[0].reset();
                    $('#ModalEditFaq').modal('hide');
                    $('#ButtonEditFaq').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#NotifikasiEditFaq').html('');
                    Swal.fire('Berhasil!', 'Edit Konten FAQ Berhasil', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiEditFaq').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonEditFaq').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiEditFaq').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonEditFaq').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    //Ketika Modal Hapus FAQ
    $('#ModalHapusFaq').on('show.bs.modal', function (e) {
        var id_web_faq = $(e.relatedTarget).data('id');
        $('#FormHapusFaq').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/KontenUtama/FormHapusFaq.php',
            data        : {id_web_faq: id_web_faq},
            success     : function(data){
                $('#FormHapusFaq').html(data);
                $('#NotifikasiHapusFaq').html('');
            }
        });
    });
    // Proses Hapus FAQ
    $('#ProsesHapusFaq').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonHapusFaq').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/KontenUtama/ProsesHapusFaq.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowFaq();
                    $('#ProsesHapusFaq')[0].reset();
                    $('#ModalHapusFaq').modal('hide');
                    $('#ButtonHapusFaq').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                    $('#NotifikasiHapusFaq').html('');
                    Swal.fire('Berhasil!', 'Hapus Konten FAQ Berhasil', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiHapusFaq').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonHapusFaq').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiHapusFaq').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonHapusFaq').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
            }
        });
    });
    //Ketika Modal Turun Naik FAQ
    $('#ModalTurunNaik').on('show.bs.modal', function (e) {
        var GetWebFaq = $(e.relatedTarget).data('id');
        $('#FormTurunNaik').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/KontenUtama/FormTurunNaik.php',
            data        : {GetWebFaq: GetWebFaq},
            success     : function(data){
                $('#FormTurunNaik').html(data);
                $('#NotifikasiTurunNaik').html('');
            }
        });
    });
    // Proses Naik Turun FAQ
    $('#ProsesTurunNaik').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonTurunNaik').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/KontenUtama/ProsesTurunNaik.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowFaq();
                    $('#ProsesTurunNaik')[0].reset();
                    $('#ModalTurunNaik').modal('hide');
                    $('#ButtonTurunNaik').html('<i class="bi bi-check"></i> Ya, Tukar').prop('disabled', false);
                    $('#NotifikasiTurunNaik').html('');
                    Swal.fire('Berhasil!', 'Pindahkan Posisi Konten FAQ Berhasil', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiTurunNaik').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonTurunNaik').html('<i class="bi bi-check"></i> Ya, Tukar').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiTurunNaik').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonTurunNaik').html('<i class="bi bi-check"></i> Ya, Tukar').prop('disabled', false);
            }
        });
    });

    //Ketika nama medsos Diketik
    $('#nama_medsos').on('input', function() {
        var value = $(this).val();
        var maxLength = 100;
        // Jika panjang melebihi batas, potong sesuai maxLength
        if (value.length > maxLength) {
            value = value.substring(0, maxLength);
        }
        // Update nilai input
        $(this).val(value); 
        // Tampilkan jumlah karakter saat ini
        $('#nama_medsos_length').text(value.length + '/' + maxLength);
    });
    //Ketika url_medsos Diketik
    $('#url_medsos').on('input', function() {
        var value = $(this).val();
        var maxLength = 250;
        // Jika panjang melebihi batas, potong sesuai maxLength
        if (value.length > maxLength) {
            value = value.substring(0, maxLength);
        }
        // Update nilai input
        $(this).val(value); 
        // Tampilkan jumlah karakter saat ini
        $('#url_medsos_length').text(value.length + '/' + maxLength);
    });
    // Validasi file logo
    $('#logo').on('change', function() {
        var file = this.files[0];
        var validTypes = ['image/jpeg', 'image/png', 'image/gif'];
        var maxSize = 2 * 1024 * 1024; // 2MB
        var validasiMessage = $('#ValidasiLogo');

        if (file) {
            if ($.inArray(file.type, validTypes) == -1) {
                validasiMessage.text('Tipe file tidak valid. Hanya diperbolehkan jpeg, png, atau gif.').css('color', 'red');
                this.value = '';
            } else if (file.size > maxSize) {
                validasiMessage.text('Ukuran file maksimal 2 MB.').css('color', 'red');
                this.value = '';
            } else {
                validasiMessage.text('File sudah valid dan sesuai persyaratan.').css('color', 'green');
            }
        }
    });
    // Proses Tambah Medsos
    $('#ProsesTambahMedsos').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonTambahMedsos').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/KontenUtama/ProsesTambahMedsos.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowMedsos();
                    $('#ProsesTambahMedsos')[0].reset();
                    $('#ModalTambahMedsos').modal('hide');
                    $('#ButtonTambahMedsos').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#NotifikasiTambahMedsos').html('');
                    Swal.fire('Berhasil!', 'Tambah Link Medsos Berhasil', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiTambahMedsos').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonTambahMedsos').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiTambahMedsos').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonTambahMedsos').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    //Ketika Modal Detail Medsos
    $('#ModalDetailMedsos').on('show.bs.modal', function (e) {
        var id_web_medsos = $(e.relatedTarget).data('id');
        $('#FormDetailMedsos').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/KontenUtama/FormDetailMedsos.php',
            data        : {id_web_medsos: id_web_medsos},
            success     : function(data){
                $('#FormDetailMedsos').html(data);
            }
        });
    });
    //Ketika Modal Edit Medsos
    $('#ModalEditMedsos').on('show.bs.modal', function (e) {
        var id_web_medsos = $(e.relatedTarget).data('id');
        $('#FormEditMedsos').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/KontenUtama/FormEditMedsos.php',
            data        : {id_web_medsos: id_web_medsos},
            success     : function(data){
                $('#FormEditMedsos').html(data);
                $('#NotifikasiEditMedsos').html('');
            }
        });
    });
    // Proses Edit Medsos
    $('#ProsesEditMedsos').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonEditMedsos').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/KontenUtama/ProsesEditMedsos.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowMedsos();
                    $('#ProsesEditMedsos')[0].reset();
                    $('#ModalEditMedsos').modal('hide');
                    $('#ButtonEditMedsos').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                    $('#NotifikasiEditMedsos').html('');
                    Swal.fire('Berhasil!', 'Edit Link Medsos Berhasil', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiEditMedsos').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonEditMedsos').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiEditMedsos').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonEditMedsos').html('<i class="bi bi-save"></i> Simpan').prop('disabled', false);
            }
        });
    });
    //Ketika Modal Hapus Medsos
    $('#ModalHapusMedsos').on('show.bs.modal', function (e) {
        var id_web_medsos = $(e.relatedTarget).data('id');
        $('#FormHapusMedsos').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/KontenUtama/FormHapusMedsos.php',
            data        : {id_web_medsos: id_web_medsos},
            success     : function(data){
                $('#FormHapusMedsos').html(data);
                $('#NotifikasiHapusMedsos').html('');
            }
        });
    });
    // Proses Hapus Medsos
    $('#ProsesHapusMedsos').on('submit', function(e) {
        e.preventDefault();
        // Mengubah teks tombol menjadi 'Loading..' dan menonaktifkan tombol
        $('#ButtonHapusMedsos').html('<i class="bi bi-save"></i> Loading..').prop('disabled', true);
        // Membuat objek FormData
        var formData = new FormData(this);
        // Mengirim data melalui AJAX
        $.ajax({
            url             : '_Page/KontenUtama/ProsesHapusMedsos.php',
            type            : 'POST',
            data            : formData,
            contentType     : false,
            processData     : false,
            dataType        : 'json',
            success: function(response) {
                if (response.success) {
                    // Jika sukses, tutup modal dan kembalikan tombol ke semula
                    ShowMedsos();
                    $('#ProsesHapusMedsos')[0].reset();
                    $('#ModalHapusMedsos').modal('hide');
                    $('#ButtonHapusMedsos').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                    $('#NotifikasiHapusMedsos').html('');
                    Swal.fire('Berhasil!', 'Hapus Link Medsos Berhasil', 'success');
                } else {
                    // Jika gagal, tampilkan notifikasi error
                    $('#NotifikasiHapusMedsos').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#ButtonHapusMedsos').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
                }
            },
            error: function() {
                // Jika terjadi error pada request
                $('#NotifikasiHapusMedsos').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
                $('#ButtonHapusMedsos').html('<i class="bi bi-check"></i> Ya, Hapus').prop('disabled', false);
            }
        });
    });
});

