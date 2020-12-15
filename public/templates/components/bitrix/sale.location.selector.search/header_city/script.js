function selectHeaderCity(cityElement) {
    var city = cityElement.data('name'),
        cityCode = cityElement.data('code');

    if (city) {
        $.cookie('header_city', city, { path: '/'});
        $.cookie('header_city_code', cityCode, { path: '/'});

        $('.js-current-city').each(function () {
            var $this = $(this),
                type = $this.data('type');

            if (type == 'header') {
                $this.text(city);
            } else if (type == 'checkout') {
                $this.find('input').val(city);
            }
        });

        var checkoutProps = $('[name="order[ORDER_PROP_64]"], [name="order[ORDER_PROP_65]"]');
        if (typeof reloadCheckout == 'function' && checkoutProps.length) {
            checkoutProps.val(cityCode);
            reloadCheckout();
        }

        $('.popup-layout').removeClass('activ-popup');
        $('body').removeClass('non-scroll');
    }

    var l_city = city.toLowerCase();
    var view_phone = '';
    if (arCityPhones[l_city]) {
        view_phone = arCityPhones[l_city];
    } else {
        for (var key in arCityPhones) {
            view_phone = arCityPhones[key];
            break;
        }
    }

    $('.js-current-header-phone').attr('href', 'tel:' + view_phone.replace(/[^\d+]/g, '')).find('span').text(view_phone);
}

if (!$.cookie('header_city')?.length) {
    $.cookie('header_city', 'Москва', { path: '/'});
}
if (!$.cookie('header_city_code')?.length) {
    $.cookie('header_city_code', '0000073738', { path: '/'});
}

$(document).on('click', '.js-sc-variant-item', function () {
    var cityElement = $(this);

    if (cityElement) {
        selectHeaderCity(cityElement);
    }
});

function createVariantElement(cityName, displayName, code) {
    return $('<div class="city-variants__item js-sc-variant-item" data-name="'+cityName+'" data-code="'+code+'">'+displayName+'</div>');
}


$(document).on('input', '.js-sc-input', function () {
    var $form = $('.js-sc-form');
    var data = $form.serializeArray();
    var val = $(this).val().trim();

    if (val.length >= 2) {
        data.push({
            name: 'filter[=PHRASE]',
            value: val,
        });

        console.log(data);
        $.ajax({
            method: "POST",
            dataType: 'json',
            url: $form.attr('action'),
            data: data,
            success: function(res) {
                if (res.result) {
                    var items = res.data.ITEMS,
                        searchBlock = $('.js-sc-variants-search');
                    searchBlock.html('');

                    if (items.length) {
                        items.forEach(function (item) {
                            var $item = createVariantElement(item.DISPLAY, item.DISPLAY, item.CODE);
                            searchBlock.append($item);
                        });
                    } else {
                        searchBlock.html('<div>Ничего не найдено</div>')
                    }

                    $('.js-sc-variants-main').hide();
                    searchBlock.show();
                } else {
                    $('.js-sc-variants-main').show();
                    $('.js-sc-variants-search').hide();
                }
            }
        });

    } else {
        $('.js-sc-variants-main').show();
        $('.js-sc-variants-search').hide();
    }
});
