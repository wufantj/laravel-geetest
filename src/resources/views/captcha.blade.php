<div id="embed-captcha"></div>
<p id="wait" class="form-control-static">正在加载验证码......</p>
<span id="notice" class="hidden help-block">
    <strong>请先完成验证</strong>
</span>

<script language="javascript" src="{{ asset('vendor/geetest/js/gt.js') }}"></script>
<script>
    const handlerEmbed = function (captchaObj) {
        $('#embed-submit').click(function (e) {
            const validate = captchaObj.getValidate();

            if (!validate) {
                $('#notice')[0].className = 'show';
                setTimeout(function () {
                    $('#notice')[0].className = 'hide';
                }, 2000);
                e.preventDefault();
            }
        });

        captchaObj.appendTo('#embed-captcha');
        captchaObj.onReady(function () {
            $('#wait')[0].className = 'hide';
        });
    };
    $.ajax({
        url: "{{ route('geetest') }}?t=" + (new Date()).getTime(),
        type: 'get',
        dataType: 'json',
        success: function (data) {
            initGeetest({
                gt: data.gt,
                challenge: data.challenge,
                new_captcha: data.new_captcha,
                product: 'embed',
                offline: !data.success,
                width: '100%'
            }, handlerEmbed);
        }
    });
</script>
