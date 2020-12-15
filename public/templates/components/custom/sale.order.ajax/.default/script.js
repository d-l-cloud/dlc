var yaDostPickpointData = {};

function enableLoader() {

}

function disableLoader() {

}



function openDeliveryDetails() {
    $('.delivery-place__wrap, .tick').on('click', function(e) {
        let target = e.target;
        $('.delivery-place__details').toggleClass('delivery-visible');
        $('.tick').toggleClass('spin');
        if ($(this).hasClass('tick')) {
            $(this).toggleClass('spin');
            $('.delivery-place__details').toggleClass('delivery-visible');
        }
    });
}
openDeliveryDetails();

$('.delivery-type:not(.features-active)').on('click', function() {
    $(this).addClass('features-active').siblings().removeClass('features-active');

    var $this = $(this);
    var isAjax = $this.data('ajax');
    var action = $this.data('action');


    var $deliveryMethod = $('.delivery-method'),
        $allContentWrappers = $deliveryMethod.find('.delivery-content-wrapper'),
        $allContents = $allContentWrappers.find('.delivery-content'),
        $contentWrapper = $allContentWrappers.eq($this.index()),
        $content = $contentWrapper.find('.delivery-content')


    if (isAjax == 'Y') {
        if (action.length) {
            enableLoader();

            var postData = $this.data('post-data');
            var data = {};
            if (postData) {
                data = postData;
            }

            $.ajax({
                url: action,
                type: "POST",
                data: data,
                dataType: "html",
                error: function (XMLHttpRequest, textStatus)
                {
                    console.log(XMLHttpRequest.responseText);
                    console.log(textStatus);
                },
                success: function (data)
                {
                    $allContentWrappers.find('input')
                        .not('.disabled').not('.disabled-person')
                        .prop('disabled', true);
                    $allContents.removeClass('delivery-content__active');

                    $content.html(data)
                        .addClass('delivery-content__active');

                    $contentWrapper.find('input')
                        .not('.disabled').not('.disabled-person')
                        .prop('disabled', false);
                },
                complete: function () {
                    disableLoader();
                }
            });
        }
    } else {
        $allContentWrappers.find('input')
            .not('.disabled').not('.disabled-person')
            .prop('disabled', true);

        $allContents.removeClass('delivery-content__active');
        $content.addClass('delivery-content__active');

        $contentWrapper.find('input')
            .not('.disabled').not('.disabled-person')
            .prop('disabled', false);
    }

    reloadCheckout(true);
});


function reloadCheckout(selectChanged = false)
{
    var $form = $('[name="ORDER_FORM"]');

    var data = $form.serializeArray();
    data.push({"name": 'via_ajax:', "value": "Y"});
    data.push({"name": 'soa-action', "value": "refreshOrderAjax"});

    if (selectChanged) {
        data.push({"name": 'selectChanged', "value": "Y"});
    }

    enableLoader();
    $.ajax({
        url: '/bitrix/components/custom/sale.order.ajax/ajax.php',
        type: "POST",
        data: data,
        dataType: "json",
        error: function (XMLHttpRequest, textStatus)
        {
            console.log(XMLHttpRequest.responseText);
            console.log(textStatus);
        },
        success: function (data)
        {
            var order = data.order,
                props = data.order.ORDER_PROP.properties;

            var $paySystem = $('.checkout-payment-type .features-item');

            $paySystem.hide();
            order.PAY_SYSTEM.forEach(function (system) {
                $paySystem.filter('[data-pay-system-id="'+system.ID+'"]').show();
            });


            var orderTotalValues = [
                {
                    'VISIBLE': (order.TOTAL.ORDER_PRICE > 0),
                    'CODE': 'SUM',
                    'VALUE': order.TOTAL.PRICE_WITHOUT_DISCOUNT
                },
                {
                    'VISIBLE': (order.TOTAL.DISCOUNT_PRICE > 0),
                    'CODE': 'DISCOUNT',
                    'VALUE': '- ' + order.TOTAL.DISCOUNT_PRICE_FORMATED
                },
                {
                    'VISIBLE': (order.TOTAL.DELIVERY_PRICE > 0),
                    'CODE': 'DELIVERY',
                    'VALUE': order.TOTAL.DELIVERY_PRICE_FORMATED
                },
                {
                    'VISIBLE': (order.TOTAL.ORDER_TOTAL_PRICE > 0),
                    'CODE': 'TOTAL',
                    'VALUE': order.TOTAL.ORDER_TOTAL_PRICE_FORMATED
                },
            ];

            orderTotalValues.forEach(function (totalValue) {
                var $row = $('.basket-total .table-row-' + totalValue.CODE);

                if (totalValue.VISIBLE) {
                    $row.show();
                } else {
                    $row.hide();
                }

                $row.find('.js-total-value').text(totalValue.VALUE);
            });

            $('.js-delivery-cost').text(order.TOTAL.DELIVERY_PRICE_FORMATED);


            for (var i in props) {
                if (props.hasOwnProperty(i)) {
                    var prop = props[i];

                    var $input = $('[name="order[ORDER_PROP_'+prop.ID+']"]'),
                        $orderForm = $('form[name="ORDER_FORM"]');

                    if (prop.TYPE == 'STRING' || prop.TYPE == 'NUMBER') {
                        $input.val(prop.VALUE.shift());
                    } else if (prop.TYPE == 'ENUM' && prop.CODE == 'ADDRESSES') {
                        if (prop.OPTIONS_SORT.length) {
                            // Если есть сохранённые адреса
                            $('.js-open-addresses-popup').show();
                            $('.js-open-addresses-page').hide();
                            if (selectChanged && $input.val() == '') {
                                $input.val(prop.OPTIONS_SORT.shift());
                            }
                        } else {
                            // Если сохраненных адресов нет
                            $('.js-open-addresses-popup').hide();
                            $('.js-open-addresses-page').show();
                        }
                    } else if (prop.TYPE == 'LOCATION') {
                        var newVal = prop.VALUE.shift();

                        if (newVal?.length) {
                            $input.val(newVal);
                        }
                        if (prop?.DISPLAY.length) {
                            $orderForm.find('.js-current-city input').val(prop.DISPLAY);
                        }

                        if (prop?.ERROR) {
                            $orderForm.find('.js-location-error').show();
                        } else {
                            $orderForm.find('.js-location-error').hide();
                        }
                    }
                }
            }

            for (var i in order.USER_PROFILES) {
                if (order.USER_PROFILES.hasOwnProperty(i)) {
                    $('[name="order[PROFILE_ID]"]').val(order.USER_PROFILES[i].ID);
                    break;
                }
            }

            /*var arProfiles = [];
            var arProfileIds = [];
            if (order.hasOwnProperty('USER_PROFILES')) {
                for (var i in order.USER_PROFILES) {
                    if (order.USER_PROFILES.hasOwnProperty(i)) {
                        arProfiles.push(order.USER_PROFILES[i]);
                        arProfileIds.push(order.USER_PROFILES[i].ID + '~~' . order.USER_PROFILES[i]['~NAME']);
                    }
                }

                if (arProfiles.length) {
                    $('.js-open-profiles-popup').show().data('addresses', arProfileIds.join('||'));
                    $('.js-open-profiles-page').hide();
                } else {
                    $('.js-open-profiles-popup').hide();
                    $('.js-open-profiles-page').show();
                }
            }*/

            $('input').not('[type="hidden"], [type="tel"]').trigger('input');
        },
        complete: function () {
            disableLoader();
        }
    });
}


$('.customer-data__double-active').on('click', 'div:not(.features-active)', function() {
    var $allContents = $('.checkout-customer-form').find('.customer-data__item');
    var $content = $allContents.eq($(this).index());

    $allContents.find('input, textarea').not('.disabled').prop('disabled', true);

    $content.find('input, textarea').not('.disabled').prop('disabled', false);

    $(this).addClass('features-active').siblings().removeClass('features-active');

    $allContents.removeClass('customer-content__active');
    $content.addClass('customer-content__active');

    var personType = $(this).data('person-type');
    var allPersonWrap = $('.js-person-type');
    var personWrap = $('.js-person-type-' + personType);

    allPersonWrap.hide().find('input, textarea').not('.disabled').prop('disabled', true).addClass('disabled-person');
    personWrap.show().find('input, textarea').not('.disabled').filter(':visible').prop('disabled', false).removeClass('disabled-person');

    reloadCheckout(true);
});

$(document).on('click', '.checkout-payment-type .features-item', function () {
    var paySystemId = $(this).data('pay-system-id');

    $('[name="order[PAY_SYSTEM_ID]"]').val(paySystemId);
});


$('.checkout-payment-type').on('click', 'div:not(.features-active)', function() {
    if ($('.checkout-payment-type div:first-child').hasClass('features-active')) {
        $('.delivery-dateprice').addClass('delivery-dateprice__active');
    }
    $(this).addClass('features-active').siblings().removeClass('features-active');
});

$(document).on('input', '.pickpoint-adresses .pickpoint-search', function () {
    var $addresses = $('.pickpoint-adresses .pickpoint-adresses__item');
    var text = $(this).val().trim().toLowerCase();

    if (text.length > 2) {
        $addresses.each(function () {
            var address = $(this).find('.adress-item__adress').text().trim().toLowerCase();

            if (address.indexOf(text) !== -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    } else {
        $addresses.show();
    }
})


$(document).on('click', '.pickpoint-adresses__item', function () {
    var $this = $(this),
        id = $this.data('id');

    $('.pickpoint-adresses').hide();
    $('.pickpoint-selected').filter('[data-id="' + id + '"]').show();
});


$(document).on('click', '.pickpoint-approve', function () {
    var $this = $(this),
        block = $this.parents('.pickpoint-selected'),
        id = block.data('id'),
        contentBlock = $this.parents('.delivery-content-wrapper');

    var address = yaDostPickpointData[id]['ADDRESS_STRING'],
        deliveryData = JSON.stringify(yaDostPickpointData[id]),
        ajaxDeliveryPrice = JSON.stringify(yaDostPickpointData[id]['AJAX_DELIVERY_PRICE']);

    block.addClass('approved-pickpoint');
    $this.hide();
    block.find('.pickpoint-another').show();

    contentBlock.find('input[name="order[yd_pvzAddressValue]"]').val(address);
    contentBlock.find('input[name="order[yd_deliveryData]"]').val(deliveryData);
    contentBlock.find('input[name="order[yd_ajaxDeliveryPrice]"]').val(ajaxDeliveryPrice);

    reloadCheckout();
});

$(document).on('click', '.pickpoint-another', function () {
    $('.pickpoint-adresses').show();
    $('.pickpoint-selected').hide();
});


$('[name="ORDER_FORM"]').validate({
    rules: {
        'order[ORDER_PROP_23]': {
            email: true,
        },
    },
    messages: {
        'order[ORDER_PROP_23]': {
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
        var $form = $(form);

        var newData = [];
        var data = $form.serializeArray();

        data.forEach(function (item) {
            var result = item.name.match(/order\[(.+)\]/);

            if (result?.length) {
                newData.push({
                    name: result[1],
                    value: item.value,
                });
            }
        });

        enableLoader();
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: newData,
            dataType: "json",
            error: function (XMLHttpRequest, textStatus)
            {
                console.log(XMLHttpRequest.responseText);
                console.log(textStatus);
            },
            success: function (data)
            {
                if (data?.order?.REDIRECT_URL) {
                    location.href = data.order.REDIRECT_URL;
                }
            },
            complete: function () {
                disableLoader();
            }
        });
    }
});

$(document).on('click', '.js-open-addresses-popup', function () {
    var $this = $(this);
    var $personType = $this.closest('.js-person-type');
    var curAddress = '';

    if ($personType.hasClass('js-person-type-2')) {
        curAddress = $personType.find('[name="order[ORDER_PROP_37]"]').val();
    } else if ($personType.hasClass('js-person-type-1')) {
        curAddress = $personType.find('[name="order[ORDER_PROP_34]"]').val();
    }

    enableLoader();
    $.ajax({
        url: '/ajax/getProfileAddresses.php',
        type: "POST",
        data: {
            PROFILE_ID: $('[name="order[PROFILE_ID]"]').val(),
        },
        dataType: "json",
        error: function (XMLHttpRequest, textStatus)
        {
            console.log(XMLHttpRequest.responseText);
            console.log(textStatus);
        },
        success: function (result)
        {
            if (result.success) {
                var $popupWrapper = $('.adresses-layout .adress-popup-wrap');
                $popupWrapper.html('');

                if (result?.data.length) {
                    result.data.forEach(function (item) {
                        var html = '<div class="adress-popup-item js-address-popup-item" data-name="'+item.NAME+'">\n' +
                            '<div class="adress-popup-item__header">\n' +
                            item.NAME +
                            '</div>\n' +
                            '<div class="adress-popup-item__text">\n' +
                            item.ADDRESS +
                            '</div>\n' +
                            '</div>';
                        var $item = $(html);

                        if (item.NAME == curAddress) {
                            $item.addClass('adress-popup-item__active');
                        }

                        $popupWrapper.prepend($item);
                    });

                    $('.adresses-layout').toggleClass('activ-popup');
                }
            }
        },
        complete: function () {
            disableLoader();
        }
    });
});

$(document).on('click', '.js-address-popup-item', function () {
    var sName = $(this).data('name');

    $('[name="order[ORDER_PROP_37]"], [name="order[ORDER_PROP_34]"]').val(sName);
    $('.adresses-layout').removeClass('activ-popup');

    reloadCheckout(true);
});


$('.delivery-methods__types .delivery-type').eq(0).trigger('click');
$('.checkout-payment-type .features-item').eq(0).trigger('click');
