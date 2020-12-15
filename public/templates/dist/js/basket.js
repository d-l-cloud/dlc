(function () {
    function checkPanels()
    {
        if ($('.js-available-item').length) {
            $('.js-available-panel').show();
        } else {
            $('.js-available-panel').hide();
        }

        if ($('.js-notavailable-item').length) {
            $('.js-notavailable-panel').show();
        } else {
            $('.js-notavailable-panel').hide();
        }
    }

    $('#basket-form').on('submit', function (e) {
        e.preventDefault();
    });
    function updateBasket() {
        var basketForm = $('#basket-form');

        if (basketForm.length) {
            var data = basketForm.serialize();

            $.ajax({
                method: 'POST',
                dataType: 'json',
                url: '/bitrix/components/bitrix/sale.basket.basket/ajax.php',
                data: data,
                success: function(result) {
                    var $basketValues = $('.js-basket-value'),
                        $basketFields = $('.js-basket-field');

                    if (result.hasOwnProperty('BASKET_DATA')) {
                        var basketData = result.BASKET_DATA;

                        if (basketData.hasOwnProperty('BASKET_ITEMS_COUNT')) {
                            var sText = declOfNum(basketData.BASKET_ITEMS_COUNT, ['товар', 'товара', 'товаров'])
                            $basketValues.filter('[data-name="ITEMS_COUNT"]').text(basketData.BASKET_ITEMS_COUNT + ' ' + sText);
                        }

                        if (basketData.hasOwnProperty('allWeight_FORMATED')) {
                            $basketValues.filter('[data-name="allWeight_FORMATED"]').text(basketData.allWeight_FORMATED);
                        }

                        if (basketData.hasOwnProperty('PRICE_WITHOUT_DISCOUNT')) {
                            $basketValues.filter('[data-name="PRICE_WITHOUT_DISCOUNT"]').text(basketData.PRICE_WITHOUT_DISCOUNT);
                        }

                        if (basketData.hasOwnProperty('DISCOUNT_PRICE_ALL')) {
                            if (basketData.DISCOUNT_PRICE_ALL > 0) {
                                $basketFields.filter('[data-name="DISCOUNT_PRICE_ALL_FORMATED"]').show();
                                if (basketData.hasOwnProperty('DISCOUNT_PRICE_ALL_FORMATED')) {
                                    $basketValues.filter('[data-name="DISCOUNT_PRICE_ALL_FORMATED"]').text(basketData.DISCOUNT_PRICE_ALL_FORMATED);
                                }
                            } else {
                                $basketFields.filter('[data-name="DISCOUNT_PRICE_ALL_FORMATED"]').hide();
                            }
                        }

                        if (basketData.hasOwnProperty('allSum_FORMATED')) {
                            $basketValues.filter('[data-name="allSum_FORMATED"]').text(basketData.allSum_FORMATED);
                        }


                        if (basketData.hasOwnProperty('ITEMS') && basketData.ITEMS.hasOwnProperty('AnDelCanBuy')){
                            var $basketItems = $('.js-basket-item');

                            basketData.ITEMS.AnDelCanBuy.forEach(function(item, i, arr) {
                                var itemId = item.ID,
                                    $item = $basketItems.filter('[data-item-id="'+itemId+'"]'),
                                    $itemFields = $item.find('.js-basket-item-field'),
                                    $itemValues = $item.find('.js-basket-item-value');

                                var $quantityInput = $item.find('#QUANTITY_INPUT_' + itemId),
                                    $quantity = $item.find('#QUANTITY_' + itemId),
                                    $quantityField = $itemFields.filter('[data-name="QUANTITY_SUM"]'),
                                    $quantityFieldValue = $itemValues.filter('[data-name="QUANTITY_SUM"]'),
                                    $sumValue = $itemValues.filter('[data-name="SUM"]'),
                                    $sumFullValue = $itemValues.filter('[data-name="SUM_FULL_PRICE_FORMATED"]'),
                                    quantity = item.QUANTITY,
                                    maxQuantity = item.AVAILABLE_QUANTITY;

                                $sumValue.text(item.SUM);
                                $sumFullValue.text(item.SUM_FULL_PRICE_FORMATED);

                                if (quantity > 1) {
                                    $quantityField.show();
                                    $quantityFieldValue.text(quantity);
                                } else {
                                    $quantityField.hide();
                                }

                                $quantityInput.val(quantity)
                                    .data('max', maxQuantity);

                                $quantity.val(quantity);
                            });
                        }
                    }
                }
            });
        }
    }

    function filterAllCheckbox()
    {
        var $items = $('.js-basket-item-checkbox'),
            panels = {};

        $items.each(function () {
            var $this = $(this),
                panelClass = $this.data('panel-class');

            if ($this.is(':checked')) {
                if (!Array.isArray(panels[panelClass])) {
                    panels[panelClass] = [];
                }
                panels[panelClass].push($this.closest('.js-basket-item').data('item-id'));
            }
        })

        var $panels = $('.js-basket-panel');

        $panels.find('.js-basket-item-favorite').hide();
        $panels.find('.js-basket-item-delete').hide();
        for (var panelClass in panels) {
            if (panels.hasOwnProperty(panelClass)) {
                var panel = $('.' + panelClass),
                    itemIds = panels[panelClass];

                panel.find('.js-basket-item-favorite').data('item-id', itemIds.join(',')).show();
                panel.find('.js-basket-item-delete').data('item-id', itemIds.join(',')).show();
            }
        }
    }

    $(document).on('change', '.js-basket-item-checkbox-all', function () {
        var itemClass = $(this).data('item-class');
        var $items = $('.' + itemClass);
        var $checkboxes = $items.find('.js-basket-item-checkbox');

        if ($(this).is(':checked')) {
            $checkboxes.each(function () {
                $(this).prop('checked', true)
            });
        } else {
            $checkboxes.each(function () {
                $(this).prop('checked', false)
            });
        }

        filterAllCheckbox();
    });

    $(document).on('change', '.js-basket-item-checkbox', function () {
        filterAllCheckbox();
    });



    $(document).on('click', '.js-basket-item-delete', function (e) {
        e.preventDefault();
        var itemId = $(this).data('item-id');

        if (!!itemId) {
            $('.delete-confirm-layout .js-basket-item-delete-confirm').data('item-id', itemId);
            $('.delete-confirm-layout').addClass('activ-popup');
            $('body').addClass('non-scroll');
        }
    });


    $(document).on('click', '.js-basket-item-favorite', function () {
        var itemClass = $(this).data('item-class'),
            $items = $('.' + itemClass),
            $checkboxes = $items.find('.js-basket-item-checkbox:checked');

        $checkboxes.each(function () {
            var $parent = $(this).closest('.js-basket-item'),
                $favButton = $parent.find('.js-item-favourites');

            if (!$favButton.hasClass('checked')) {
                $favButton.trigger('click');
            }
        });
    });

    $(document).on('click', '.js-basket-item-delete-confirm', function () {
        var itemId = $(this).data('item-id') + '';

        if (!!itemId) {
            $.ajax({
                type: "POST",
                url: '/bitrix/templates/del_from_cart.php',
                data: {id: itemId},
                dataType: "html",
                success: function(filter){
                    itemId.split(',').forEach(function (id) {
                        $('.js-basket-item').filter('[data-item-id="'+id+'"]').remove();
                    });
                    checkPanels();

                    $('.popup-layout').removeClass('activ-popup');
                    $('body').removeClass('non-scroll');
                    updateBasket();
                    conversionCart();
                }
            });
        }
    });

    $(document).on('focus', '.js-basket-item-quantity', function () {
        $(this).data('old-value', $(this).val());
    });

    $(document).on('change', '.js-basket-item-quantity', function () {
        var minimum = $(this).data('min'),
            maximum = $(this).data('max');

        var oldValue = $(this).data('old-value'),
            newValue = parseInt($(this).val(), 10);

        if (minimum > 0) {
            newValue = (newValue < minimum) ? minimum : newValue;
        }

        if (maximum > 0) {
            newValue = (newValue > maximum) ? maximum : newValue;
        }
        $(this).parent().find('input').val(newValue);

        if (newValue != oldValue) {
            updateBasket();
            conversionCart();
        }

        var $inputWrapper = $(this).parent(),
            minusButton = $inputWrapper.find('.item-counter__minus'),
            plusButton = $inputWrapper.find('.item-counter__plus'),
            $textRemains = $inputWrapper.parent().find('.goods-remains');

        if (newValue == maximum) {
            plusButton.addClass('counter-limit');
            $textRemains.removeClass('goods-remains-hidden');
        } else {
            plusButton.removeClass('counter-limit');
            $textRemains.addClass('goods-remains-hidden');
        }
        if (newValue == minimum) {
            minusButton.addClass('counter-limit');
        } else {
            minusButton.removeClass('counter-limit');
        }
    });
})();



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

$('.delivery-methods__types').on('click', 'div:not(.features-active)', function() {
    console.log('click');
    f();
    $('.customer-data__double').addClass('customer-data__double-active');
    $(this).addClass('features-active').siblings().removeClass('features-active');
    $('.delivery-method').find('.delivery-content').removeClass('delivery-content__active').eq($(this).index()).addClass('delivery-content__active');
});

function f() {
    $('.customer-data__double-active').on('click', 'div:not(.features-active)', function() {
        $(this).addClass('features-active').siblings().removeClass('features-active');
        $('.checkout-customer-form').find('.customer-data__item').removeClass('customer-content__active').eq($(this).index()).addClass('customer-content__active');
    });
}

$('.checkout-payment-type').on('click', 'div:not(.features-active)', function() {
    if ($('.checkout-payment-type div:first-child').hasClass('features-active')) {
        $('.delivery-dateprice').addClass('delivery-dateprice__active');
    }
    $(this).addClass('features-active').siblings().removeClass('features-active');
});

// Карта яндекс
/*
$(document).ready(function () {
    console.log('map-loaded', myMap);
    var myMap;

// Дождёмся загрузки API и готовности DOM.
    ymaps.ready(init);

    function init () {
        // Создание экземпляра карты и его привязка к контейнеру с
        // заданным id ("map").
        myMap = new ymaps.Map('map', {
            // При инициализации карты обязательно нужно указать
            // её центр и коэффициент масштабирования.
            center: [55.76, 37.64], // Москва
            zoom: 10,
            controls: []
        });


    }
});

$('.pickpoint-adresses__item').on('click', function () {
    $('.pickpoint-selected').show();
    $('.pickpoint-adresses').hide();
});

$('.pickpoint-approve').on('click', function () {
    $('.pickpoint-selected').addClass('approved-pickpoint');
    $(this).hide();
    $('.pickpoint-another').show();
});

$('.pickpoint-another').on('click', function () {
    $('.pickpoint-selected').hide();
    $('.pickpoint-adresses').show();
    $('.pickpoint-selected').removeClass('approved-pickpoint');
    $('.pickpoint-approve').show();
    $('.pickpoint-another').hide();
});

$('.authorize-question .close').on('click', function () {
    $('.authorize-question').hide();
});
*/