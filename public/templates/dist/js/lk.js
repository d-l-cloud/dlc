$(document).ready(function () {
    // Изменение номера и пароля
    function changeNumber() {
        $('.change-number').on('click', function() {
            $('.account-number__change').removeClass('hide-account-elem');
            $('.account-number__current').addClass('hide-account-elem');
        });
        $('.regect-number').on('click', function() {
            $('.account-number__change').addClass('hide-account-elem');
            $('.account-number__current').removeClass('hide-account-elem');
        });
    }
    changeNumber();

    function chsngePassword() {
        $('.change-password').on('click', function() {
            $('.account-password__change').removeClass('hide-account-elem');
            $('.account-password__current').addClass('hide-account-elem');
        });
        $('.regect-password').on('click', function() {
            $('.account-password__change').addClass('hide-account-elem');
            $('.account-password__current').removeClass('hide-account-elem');
        });
    }
    chsngePassword();


    ( function( factory ) {
        $('#date').datepicker({
            changeYear: true,
            changeMonth: true,
            yearRange: "-70:+0"
        });
        if ( typeof define === "function" && define.amd ) {

            // AMD. Register as an anonymous module.
            define( [ "../widgets/datepicker" ], factory );
        } else {

            // Browser globals
            factory( jQuery.datepicker );
        }
    }( function( datepicker ) {

        datepicker.regional.ru = {
            closeText: "Закрыть",
            prevText: "&#x3C;Пред",
            nextText: "След&#x3E;",
            currentText: "Сегодня",
            monthNames: [ "Январь","Февраль","Март","Апрель","Май","Июнь",
                "Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь" ],
            monthNamesShort: [ "Янв","Фев","Мар","Апр","Май","Июн",
                "Июл","Авг","Сен","Окт","Ноя","Дек" ],
            dayNames: [ "воскресенье","понедельник","вторник","среда","четверг","пятница","суббота" ],
            dayNamesShort: [ "вск","пнд","втр","срд","чтв","птн","сбт" ],
            dayNamesMin: [ "Вс","Пн","Вт","Ср","Чт","Пт","Сб" ],
            weekHeader: "Нед",
            dateFormat: "dd.mm.yy",
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: "" };
        datepicker.setDefaults( datepicker.regional.ru );

        return datepicker.regional.ru;

    } ) );
});


//Confirm reject subscription
$('.lk-confirmation__item').on('click', function () {
    var $el = $(this);
    var val = $el.data('value');

    $('.lk-confirmation__item').removeClass('active-confirmation');

    $el.addClass('active-confirmation');
    $('.lk-signin__confirmation input[name="SUBSCRIBE"]').val(val);
});

function changePersonalInfo() {
    let chengeInfoTrigger = document.querySelector('.personal-change'),
        currentPersonalInfo = document.querySelector('.lk-info__personal'),
        changePersonalInfo = document.querySelector('.lk-personal__change'),
        regectPersonalChange = document.querySelector('.regect-personal-data');

    if (!!chengeInfoTrigger) {
        chengeInfoTrigger.addEventListener('click', function () {
            currentPersonalInfo.style.display = 'none';
            changePersonalInfo.style.display = 'block';
        });
    }
    if (!!regectPersonalChange) {
        regectPersonalChange.addEventListener('click', function () {
            currentPersonalInfo.style.display = 'block';
            changePersonalInfo.style.display = 'none';
        });
    }
}
changePersonalInfo();

//Переключение табов
(function($) {
    $(function() {
        $('.lk-menu__main').on('click', 'div.tab', function() {
            var tabId = $(this).data('tab-id');
            if (tabId == '#orders') {
                $('.orders-detail').hide();
                $('.orders-list').show();
            }
            location.hash = tabId;

            $(this).addClass('menu-item__active').siblings().removeClass('menu-item__active');
            $('.lk-info__wrap').find('.lk-info').removeClass('lk-info__active').eq($(this).index()).addClass('lk-info__active');
        });

        var currentTab = location.hash;
        if (!!currentTab) {
            $('.lk-menu__main div.tab').filter('[data-tab-id="'+currentTab+'"]').trigger('click');
        }
    });
})(jQuery);


// Стилизация селекта
$(document).ready(function() {
    setTimeout(function() {
        $('.select').styler({
            filePlaceholder: 'Компания'
        });
    }, 100)
});


function openCompanyPopup() {
    var addCompany = $('.add-company'),
        addCompanyLayout = $('.company-popup__layout');

    addCompany.on('click', function() {
        addCompanyLayout.addClass('activ-popup');
        $('body').addClass('non-scroll');
    });

    $('.input').on('blur', function () {
        if ($(this).siblings().val() != '') {
            console.log('full');
        }
    });
}
openCompanyPopup();


$('.manual-trigger').on('click', function () {
    $('.automatic-trigger').show(250);
    $('.manual-enter').show(250);
    $('.manual-trigger').hide(250);
});
$('.automatic-trigger').on('click', function () {
    $('.automatic-trigger').hide(250);
    $('.manual-enter').hide(250);
    $('.manual-trigger').show(250);
});

$('.account-number__input').inputmask("+7 (999) 999-99-99");

(function () {
    var oCompanyValidateRules = {
        rules: {
            NAME: {
                required: true,
            },
            UF_INN: {
                required: true,
                inn: true,
            },
            UF_BIK: {
                required: true,
            },
            UF_CORRESPONDENT_ACCOUNT: {
                required: true,
            },
            UF_ACCOUNT: {
                required: true,
            },
            UF_BANK_NAME: {
                required: true,
            },
            UF_BANK_ADDRESS: {
                required: true,
            },
            UF_NAME: {
                required: true,
            },
            UF_URADDRESS: {
                required: true,
            },
            UF_PHONE: {
                required: true,
            },
        },
        messages: {
            NAME: {
                required: "Это поле обязательно для заполнения",
            },
            UF_INN: {
                required: "Это поле обязательно для заполнения",
            },
            UF_BIK: {
                required: "Это поле обязательно для заполнения",
            },
            UF_CORRESPONDENT_ACCOUNT: {
                required: "Это поле обязательно для заполнения",
            },
            UF_ACCOUNT: {
                required: "Это поле обязательно для заполнения",
            },
            UF_BANK_NAME: {
                required: "Это поле обязательно для заполнения",
            },
            UF_BANK_ADDRESS: {
                required: "Это поле обязательно для заполнения",
            },
            UF_NAME: {
                required: "Это поле обязательно для заполнения",
            },
            UF_URADDRESS: {
                required: "Это поле обязательно для заполнения",
            },
            UF_PHONE: {
                required: "Это поле обязательно для заполнения",
            },
        }
    };

    $(document).on('click', '.js-change-company', function () {
        var changeCompanyLayout = $('.change-company__layout');
        var profileId = $(this).data('profile');

        if (!!profileId) {
            $.ajax({
                url: '/personal/profiles.php',
                type: 'get',
                dataType: 'html',
                data: {
                    profile: profileId,
                },
                success: function (result) {
                    var $form = $('.js-popup-change-company').find('.popup-inner');
                    $form.html(result);


                    changeCompanyLayout.addClass('activ-popup');
                    $('body').addClass('non-scroll');

                    var dadataToken = $('#dadata_token').val();

                    if (dadataToken) {
                        $form.find('input[name="UF_INN"]').suggestions({
                            token: dadataToken,
                            type: "PARTY",
                            mobileWidth: 200,
                            onSelect: function(suggestion) {
                                $form.find('input[name="UF_KPP"]').val(suggestion.data.kpp);
                                $form.find('input[name="UF_NAME"]').val(suggestion.value);
                                $form.find('input[name="UF_URADDRESS"]').val(suggestion.data.address.value);

                                $('input').not('[type="hidden"], [type="tel"]').trigger('input');
                            },
                            formatSelected: function(suggestion) {
                                return suggestion.data.inn;
                            },
                        });

                        $form.find('input[name="UF_BIK"]').suggestions({
                            token: dadataToken,
                            type: 'BANK',
                            mobileWidth: 200,
                            onSelect: function(suggestion) {
                                $form.find('input[name="UF_BANK_ADDRESS"]').val(suggestion.data.address.value);
                                $form.find('input[name="UF_CORRESPONDENT_ACCOUNT"]').val(suggestion.data.correspondent_account);
                                $form.find('input[name="UF_BANK_NAME"]').val(suggestion.data.name.short);
                                $form.find('input[name="UF_BIK"]').val(suggestion.data.bic);

                                $('input').not('[type="hidden"], [type="tel"]').trigger('input');
                            }
                        });
                    }

                    $('.mask-inn-organization').inputmask('9999999999');
                    $('.mask-ogrn').inputmask('9999999999999');
                    $('.mask-ogrnip').inputmask('999999999999999');
                    $('.mask-kpp').inputmask('999999999');
                    //$('.mask-bik').inputmask('999999999');
                    $('.mask-account').inputmask('99999999999999999999');


                    $('.js-change-company-form').validate($.extend(oCompanyValidateRules,{
                        submitHandler: function (form) {
                            var $form = $(form);

                            $.ajax({
                                url: $form.attr('action'),
                                type: $form.attr('method'),
                                dataType: 'json',
                                data: $form.serialize(),
                                success: function (response) {
                                    if (response.hasOwnProperty('errors')) {
                                        console.log(response.errors);
                                    } else {
                                        location.reload(true);
                                    }
                                }
                            });
                        }
                    }));

                    $('input').not('[type="hidden"], [type="tel"]').trigger('input');
                }
            });
        }
    });

    (function () {
        var $form = $('.js-add-company-form');
        var dadataToken = $('#dadata_token').val();

        if (dadataToken) {
            $form.find('input[name="UF_INN"]').suggestions({
                token: dadataToken,
                type: "PARTY",
                mobileWidth: 200,
                onSelect: function(suggestion) {
                    $form.find('input[name="UF_KPP"]').val(suggestion.data.kpp);
                    $form.find('input[name="UF_NAME"]').val(suggestion.value);
                    $form.find('input[name="UF_URADDRESS"]').val(suggestion.data.address.value);

                    $('input').not('[type="hidden"], [type="tel"]').trigger('input');
                },
                formatSelected: function(suggestion) {
                    return suggestion.data.inn;
                },
            });

            $form.find('input[name="UF_BIK"]').suggestions({
                token: dadataToken,
                type: 'BANK',
                mobileWidth: 200,
                onSelect: function(suggestion) {
                    $form.find('input[name="UF_BANK_ADDRESS"]').val(suggestion.data.address.value);
                    $form.find('input[name="UF_CORRESPONDENT_ACCOUNT"]').val(suggestion.data.correspondent_account);
                    $form.find('input[name="UF_BANK_NAME"]').val(suggestion.data.name.short);
                    $form.find('input[name="UF_BIK"]').val(suggestion.data.bic);

                    $('input').not('[type="hidden"], [type="tel"]').trigger('input');
                }
            });
        }
    })();

    $('.js-add-company-form').validate($.extend(oCompanyValidateRules,{
        submitHandler: function (form) {
            var $form = $(form);

            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                dataType: 'json',
                data: $form.serialize(),
                success: function (response) {
                    if (response.hasOwnProperty('errors')) {
                        console.log(response.errors);
                    } else {
                        location.reload(true);
                    }
                }
            });
        }
    }));

    $('input').not('[type="hidden"], [type="tel"]').trigger('input');
})();


(function () {
    var oAddressValidateRules = {
        rules: {
            city: {
                required: true,
            },
            street: {
                required: true,
            },
            house: {
                required: true,
            },
        },
        messages: {
            city: {
                required: "Это поле обязательно для заполнения",
            },
            street: {
                required: "Это поле обязательно для заполнения",
            },
            house: {
                required: "Это поле обязательно для заполнения",
            },
        }
    };

    $(document).on('click', '.js-add-address', function () {
        var profileId = $(this).data('profile');

        $('#address_add_form').find('input[name="profile"]').val(profileId);

        $('.add-adress-popup__layout').addClass('activ-popup');
        $('body').addClass('non-scroll');

        $('input').not('[type="hidden"], [type="tel"]').trigger('input');
    });


    $('.js-address-add-form').validate($.extend(oAddressValidateRules, {
        submitHandler: function (form) {
            var $form = $(form);

            $.ajax({
                url: $form.attr('action'),
                type: 'GET',
                dataType: 'html',
                data: $form.serialize(),
                success: function (result) {
                    location.reload(true);
                }
            });
        }
    }));

    $('#PERSONAL_CHANGE_PASSWORD').validate({
        rules: {
            NEW_PASSWORD: {
                required: true,
                minlength: 6,
                maxlength: 16,
            },
            NEW_PASSWORD_CONFIRM: {
                equalTo: "#setup-pass-field-password2"
            },
        },
        messages: {
            NEW_PASSWORD: {
                minlength: "Пароль должен быть не менее 6 символов",
                maxlength: "Пароль должен быть не более 16 символов",
            },
            NEW_PASSWORD_CONFIRM: {
                equalTo: "Пароли не совпадают"
            }
        },
    });

    $('#PERSONAL_CHANGE_DATA').validate({
        rules: {
            LAST_NAME: {
                required: true,
            },
            NAME: {
                required: true,
            },
        },
        messages: {},
    })


    $('#personal-change-phone').validate({
        rules: {
            phone: {
                minLengthPhone: true,
            },
        },
        messages: {},
        submitHandler: function (form) {
            var $form = $(form);
            $.ajax({
                url: '/personal/ajax.php',
                type: 'post',
                dataType: 'json',
                data: $form.serialize(),
                success: function (result) {
                    if (result.status === 'sms_sent_success') {
                        $('#personal-change-phone-sms-code').show(250)
                            .find('[name="phone"]').val($form.find('[name="phone"]').val());
                    } else {
                        alert(result.error);
                    }
                }
            });
        }
    });

    $('#personal-change-phone-sms-code .send-again').on('click', function () {
        $('#personal-change-phone').trigger('submit');
    });

    $('#personal-change-phone-sms-code').validate({
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
                action: $form.find('[name="action"]').val(),
                step: $form.find('[name="step"]').val(),
                code: smsCode,
                phone: $form.find('[name="phone"]').val(),
            };

            $.ajax({
                url: '/personal/ajax.php',
                type: 'post',
                dataType: 'json',
                data: data,
                success: function (result) {
                    if (result.status === 'sms_confirmed_success') {
                        $('.success-phone__layout').addClass('activ-popup');
                        $('body').addClass('non-scroll');
                        setTimeout(function(){
                            location.reload();
                        }, 500);
                    } else {
                        alert(result.error);
                    }
                }
            });
        },
    });

    $(document).on('click', '.js-change-address', function () {
        var profileId = $(this).data('profile');
        var addrId = $(this).data('addr');


        var addressEditForm = $('#address_edit_form');
        addressEditForm.find('input[name="profile"]').val(profileId);
        addressEditForm.find('input[name="addr_id"]').val(addrId);

        $.ajax({
            url: '/personal/addresses.php',
            type: 'post',
            dataType: 'json',
            data: {get_addr: 1, addr_id: addrId, profile: profileId},
            success: function (ob) {
                var data = ob[addrId].split(',');

                $.each(data, function (k, v) {
                    addressEditForm.find('input[data-num='+k+']').val(v);
                })

                $('.change-adress-popup__layout').addClass('activ-popup');
                $('body').addClass('non-scroll');

                $('.js-address-edit-form').validate($.extend(oAddressValidateRules, {
                    submitHandler: function (form) {
                        var $form = $(form);

                        $.ajax({
                            url: $form.attr('action'),
                            type: 'GET',
                            dataType: 'html',
                            data: $form.serialize(),
                            success: function (result) {
                                location.reload(true);
                            }
                        });
                    }
                }));

                $('input').not('[type="hidden"], [type="tel"]').trigger('input');
            }
        });
    });


    $(document).on('change', '.js-default-address', function () {
        var profileId = $(this).data('profile');
        var addrId = $(this).data('addr');

        $.ajax({
            url: '/personal/addresses.php',
            type: 'post',
            dataType: 'html',
            data: {default: 1, addr_id: addrId, profile: profileId},
            success: function (ob) {
                //location.reload(true);
            }
        });
    });


    $(document).on('click', '.js-remove-address', function () {
        var profileId = $(this).data('profile');
        var addrId = $(this).data('addr');

        $.ajax({
            url: '/personal/addresses.php',
            type: 'post',
            dataType: 'html',
            data: {delete: 1, addr_id: addrId, profile: profileId},
            success: function (ob) {
                $('#shipment-row-'+profileId+'-'+addrId).remove();
            }
        })
    });

    (function () {
        var dadataToken = $('#dadata_token').val();
        $('#address_add_form, #address_edit_form').each(function () {
            var $form = $(this);

            if ($form.length) {
                var $city = $form.find('input[name="city"]');
                var $street = $form.find('input[name="street"]');
                var $house  = $form.find('input[name="house"]');
                var $index  = $form.find('input[name="index"]');

                function showPostalCode(suggestion) {
                    $index.val(suggestion.data.postal_code);

                    $('input').not('[type="hidden"], [type="tel"]').trigger('input');
                }

                function clearPostalCode() {
                    $index.val("");
                }

                // город и населенный пункт
                $city.suggestions({
                    token: dadataToken,
                    type: "ADDRESS",
                    hint: false,
                    bounds: "city-settlement",
                    onSelect: showPostalCode,
                    onSelectNothing: clearPostalCode
                });

                // улица
                $street.suggestions({
                    token: dadataToken,
                    type: "ADDRESS",
                    hint: false,
                    bounds: "street",
                    constraints: $city,
                    onSelect: showPostalCode,
                    onSelectNothing: clearPostalCode
                });

                // дом
                $house.suggestions({
                    token: dadataToken,
                    type: "ADDRESS",
                    hint: false,
                    noSuggestionsHint: false,
                    bounds: "house",
                    constraints: $street,
                    onSelect: showPostalCode,
                    onSelectNothing: clearPostalCode
                });
            }
        });
    })();
})();

(function () {
    $('.js-lk-docs-inner form').validate({
        rules: {
            form_text_14: {
                required: true,
            },
            'form_checkbox_SIMPLE_QUESTION_328[]': {
                required: true,
            },
            'form_checkbox_SIMPLE_QUESTION_345[]': {
                required: true,
            },
            form_email_19: {
                required: true,
                email: true,
            },
            form_text_20: {
                required: true,
            },
            agree: {
                required: true,
            },
        },
        errorPlacement: function(error, element) {
            var $errorBlock = $('<div class="lk-error"></div>');
            $errorBlock.html(error);
            if (element.hasClass('docs-input')) {
                $errorBlock.insertBefore(element);
            } else {
                $errorBlock.insertBefore(element.parent());
            }
        },
        errorElement: "div",
        errorClass: "lk-error-message",
        errorLabelContainer: ".lk-error",
        messages: {
            form_text_14: {
                required: "Это поле обязательно для заполнения",
            },
            'form_checkbox_SIMPLE_QUESTION_328[]': {
                required: "Это поле обязательно для заполнения",
            },
            'form_checkbox_SIMPLE_QUESTION_345[]': {
                required: "Это поле обязательно для заполнения",
            },
            form_email_19: {
                required: "Это поле обязательно для заполнения",
                email: "Пожалуйста, введите корректный Email адрес",
            },
            form_text_20: {
                required: "Это поле обязательно для заполнения",
            },
            agree: {
                required: "Это поле обязательно для заполнения",
            },
        },
        submitHandler: function (form) {
            $(form).submit();
        }
    });


    $(document).on('click', '.orders__wrap .js-lk-order-item', function (e) {
        var orderId = $(this).data('order-id');

        if ($(e.target).hasClass('regect-order')) {
            $.get('/personal/cancel_order.php', {ID: orderId}, function(res){
                $('.webform-popup__layout')
                    .addClass('activ-popup')
                    .find('.webform-popup__wrap').html(res);
                $('body').addClass('non-scroll');
            });
        } else {
            $('.orders-list').hide();
            $('.orders-detail').hide().filter('.order-detail-' + orderId).show();
        }
    });



    $(document).on('click', '.js-form-submit-cancel-order', function(e){
        e.preventDefault();
        $.post($(this).closest('form').attr('action'), $(this).closest('form').serialize() , function(res){
            $('.webform-popup__layout')
                .find('.webform-popup__wrap').html(res);
        });
    });


    $(document).on('click', '.js-lk-add-phone-btn', function () {
        $('.change-number').trigger('click');
    });


    $(document).on('click', '.js-lk-confirm-phone-btn', function () {
        $('.change-number').trigger('click');

        $('#personal-change-phone').trigger('submit');
    });
})();