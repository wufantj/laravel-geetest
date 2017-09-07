<template>
    <div>
        <div id="embed-captcha"></div>
        <p id="wait" class="form-control-static">正在加载验证码......</p>
    </div>
</template>

<script>
    export default {
        props: ['url', 'validation', 'value'],
        data: function () {
            return {
                captchaObj: null
            };
        },
        created: function () {
            window.geetest = {};

            this.init();

            const self = this;

            this.$on('init', function () {
                self.init();
            });

            this.$on('validate', function () {
                self.validate();
            });

            this.$on('get', function () {
                self.getValue();
            });
        },
        methods: {
            init: function () {
                $('#embed-captcha').empty();
                $('#wait').removeClass('hidden');

                const self = this;

                axios.get(this.url + '?t=' + _.now())
                    .then(function (response) {
                        initGeetest({
                            gt: response.data.gt,
                            challenge: response.data.challenge,
                            new_captcha: response.data.new_captcha,
                            product: 'embed',
                            offline: !response.data.success,
                            width: '100%'
                        }, self.handlerEmbed);
                    });
            },
            handlerEmbed: function (captchaObj) {
                captchaObj.appendTo('#embed-captcha');
                captchaObj.onReady(function () {
                    $('#wait').addClass('hidden');
                });

                this.captchaObj = captchaObj;
            },
            validate: function () {
                let result = true;

                if (!this.captchaObj.getValidate()) {
                    result = false;
                }

                this.$emit('update:validation', result);
            },
            getValue: function () {
                this.$emit('update:value', {
                    geetestChallenge: $('input[name=geetest_challenge]').val(),
                    geetestValidate: $('input[name=geetest_validate]').val(),
                    geetestSeccode: $('input[name=geetest_seccode]').val()
                })
            }
        }
    }
</script>
