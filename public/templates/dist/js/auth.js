$(document).ready(function() {
    // Авторизация по E-mail
    $('#form-email-auth').validate({
        rules: {
            login: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 6,
                maxlength: 16,
            },
        },
        messages: {
            login:{
                required: "Это поле обязательно для заполнения",
                email: "Пожалуйста, введите корректный Email адрес",
            },
            password:{
                required: "Это поле обязательно для заполнения",
                minlength: "Пароль должен быть не менее 6 символов",
                maxlength: "Пароль должен быть не более 16 символов",
            },
        },
        submitHandler: function (form) {
            var $form = $(form);
            $.ajax({
                url: '/bitrix/templates/auth.php',
                type: 'post',
                dataType: 'json',
                data: $form.serialize(),
                success: function (result) {
                    if (result.status === 'success') {
                        if (result.action && result.method && result.action === 'auth' && result.method === 'by_login') {
                            $.ajax({
                                url: '/bitrix/templates/auth.php',
                                type: 'post',
                                dataType: 'json',
                                data: $form.serialize(),
                                success: function (result) {
                                    if (result.status === 'success') {
                                        setTimeout(function(){
                                            if (result.is_basket) {
                                                location.reload();
                                            } else {
                                                location.href = "/personal/";
                                            }
                                        }, 100);
                                    }
                                }
                            });
                        } else {
                            setTimeout(function(){
                                if (result.is_basket) {
                                    location.reload();
                                } else {
                                    location.href = "/personal/";
                                }
                            }, 100);
                        }
                    } else if (result.status === 'sms_sent_success') {

                    } else {
                        $form.find('.form-login__btns').after('<div style="top: -25px;position: relative;"><label class="error">'+result.error_text+'</label></div>');
                    }
                }
            });
        },
    });

    // Авторизация по телефону
    $('#form-phone-auth').validate({
        rules: {
            phone: {
                minLengthPhone: true,
            },
        },
        messages: {},
        submitHandler: function (form) {
            var $form = $(form);
            $.ajax({
                url: '/bitrix/templates/auth.php',
                type: 'post',
                dataType: 'json',
                data: $form.serialize(),
                success: function (result) {
                    if (result.status === 'sms_sent_success') {
                        $('#form-phone-auth-sms-code').show()
                            .find('[name="phone"]').val($form.find('[name="phone"]').val());
                    } else {
                        $form.find('.form-login__btns').after('<div style="top: -25px;position: relative;"><label class="error">'+result.error_text+'</label></div>');
                    }
                }
            });
        },
    });

    $('#form-phone-auth-sms-code .send-again').on('click', function () {
        $('#form-phone-auth').trigger('submit');
    });

    // Код подтверждения авторизации по телефону
    $('#form-phone-auth-sms-code').validate({
        rules: {
            numb1: { required: true },
            numb2: { required: true },
            numb3: { required: true },
            numb4: { required: true },
            numb5: { required: true }
        },
        groups: {
            smsCode: "numb1 numb2 numb3 numb4 numb5"
        },
        messages: {
            numb1: {
                required: 'Введите код подтвердения'
            },
            numb2: {
                required: 'Введите код подтвердения'
            },
            numb3: {
                required: 'Введите код подтвердения'
            },
            numb4: {
                required: 'Введите код подтвердения'
            },
            numb5: {
                required: 'Введите код подтвердения'
            },
        },
        errorPlacement: function(error, element) {
            $(element).closest('div').append(error);
        },
        submitHandler: function (form) {
            var $form = $(form);

            var smsCode = '';
            $form.find('.sms-input').each(function () {
                smsCode += '' + $(this).val();
            });

            var data = {
                mode: 'auth',
                method: 'by_phone',
                phone_action: 'confirm_code',
                sms_code: smsCode,
                phone: $form.find('[name="phone"]').val(),
            };

            $.ajax({
                url: '/bitrix/templates/auth.php',
                type: 'post',
                dataType: 'json',
                data: data,
                success: function (result) {
                    if (result.status === 'success') {
                        setTimeout(function(){
                            if (result.is_basket) {
                                location.reload();
                            } else {
                                location.href = "/personal/";
                            }
                        }, 100);
                    } else {
                        alert(result.error_text);
                    }
                }
            });
        },
    });

    // Регистрация
    $('#form-register').validate({
        rules: {
            'user[NAME]': {
                required: true,
            },
            'user[EMAIL]': {
                required: true,
                email: true
            },
            agreement: {
                required: true,
            },
        },
        messages: {
            password_confirm: {
                equalTo: "Пароли не совпадают"
            },
            'user[EMAIL]': {
                email: "Пожалуйста, введите корректный Email адрес",
            },
        },
        errorPlacement: function(error, element) {
            if (element.is('input[type="checkbox"]')) {
                error.css({marginBottom: "5px"});
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $errorBlock = $form.find('.error_text');

            $.ajax({
                url: '/bitrix/templates/auth.php',
                type: 'post',
                dataType: 'json',
                data: $form.serialize(),
                success: function(register_result){
                    if (register_result.status === 'success') {
                        showNotification('Регистрация', register_result.success_text)

                        if (register_result.location) {
                            setTimeout(function(){
                                location.href = register_result.location;
                            }, 100);
                        }
                    } else {
                        var error = 'Ошибка регистрации';

                        if (typeof register_result.error_text != 'undefined') {
                            error = register_result.error_text;
                        }

                        $errorBlock.text(error).show();
                    }
                }
            });
        }
    });

    // Сброс пароля
    $('#form-reset-password').validate({
        rules: {
            login: {
                required: true,
                email: true,
            },
        },
        messages: {
            login:{
                required: "Это поле обязательно для заполнения",
                email: "Пожалуйста, введите корректный Email адрес",
            },
        },
        submitHandler: function (form) {
            var $form = $(form);
            $.ajax({
                url: '/bitrix/templates/auth.php',
                type: 'post',
                dataType: 'json',
                data: $form.serialize(),
                success: function (result) {
                    if (result.status === 'success') {
                        showNotification('Восстановление пароля',
                            'Перейдите в указанный почтовый ящик для получения дальнейших инструкций по восстановлению пароля.')
                    } else {
                        showNotification('Восстановление пароля', result.error_text)
                    }
                }
            });
        }
    });

    // Установка пароля для нового пользователя
    (function () {
        var setupPasswordLayout = $('.setup-password-popup__layout');
        if (setupPasswordLayout.length) {
            setupPasswordLayout.addClass('activ-popup');
            $('body').addClass('non-scroll');

            $('#form-change-password').validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 16,
                    },
                    password_confirm: {
                        equalTo: "#setup-pass-field-password"
                    },
                },
                messages: {
                    password: {
                        minlength: "Пароль должен быть не менее 6 символов",
                        maxlength: "Пароль должен быть не более 16 символов",
                    },
                    password_confirm: {
                        equalTo: "Пароли не совпадают"
                    }
                },
                submitHandler: function (form) {
                    var $form = $(form),
                        $errorBlock = $form.find('.error_text');

                    $.ajax({
                        url: '/bitrix/templates/auth.php',
                        type: 'post',
                        dataType: 'json',
                        data: $form.serialize(),
                        success: function(register_result){
                            if (register_result.status === 'success') {
                                if (register_result.action && register_result.action === 'reg_email_confirmation') {
                                    /*ingEvents.Event({
                                        category: 'forms',
                                        action: 'submit',
                                        label: 'registr',
                                        ya_label: 'registr',
                                        goalParams: {}
                                    });*/

                                    $.ajax({
                                        url: '/bitrix/templates/auth.php',
                                        type: 'post',
                                        dataType: 'json',
                                        data: {
                                            mode: 'auth',
                                            method: 'by_login',
                                            login: register_result.login,
                                            password: register_result.password,
                                        },
                                        success: function (auth_result) {
                                            if (auth_result.status === 'success') {
                                                showNotification('Регистрация', register_result.success_text)

                                                setTimeout(function(){
                                                    window.location = register_result.location;
                                                }, 100);
                                            }
                                        }
                                    });

                                }
                            } else {
                                var error = 'Ошибка регистрации';

                                if (typeof register_result.error_text != 'undefined') {
                                    error = register_result.error_text;
                                }

                                $errorBlock.text(error).show();
                            }
                        }
                    });
                }
            });
        }
    })();
});