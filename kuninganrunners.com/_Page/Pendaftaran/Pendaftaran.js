$(document).ready(function() {
    $('#ReloadCaptcha').click(function() {
        var $captchaImg = $('img[src*="Captcha.php"]');
        if ($captchaImg.length) {
            var src = $captchaImg.attr('src');
            $captchaImg.attr('src', src.split('?')[0] + '?' + new Date().getTime());
        }
    });
});