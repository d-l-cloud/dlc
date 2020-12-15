// Инициализация детальной страницы каталога
function initCatalogDetail(parentBlockSelector, isFastReview = false) {
    function showSlider(elSelector, isFastReview) {
        if (!isFastReview) {
            $(elSelector).find('.big-slide').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                infinite: false,
                asNavFor: elSelector + ' .slides-feed'
            });
            $(elSelector).find('.slides-feed').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                asNavFor: elSelector + ' .big-slide',
                infinite: false,
                dots: false,
                arrows: true,
                prevArrow: '<button type="button" class="slick-arrow slick-prev arrow-grey vertical-prev"></button>',
                nextArrow: '<button type="button" class="slick-arrow slick-next arrow-grey vertical-next"></button>',
                focusOnSelect: true,
                vertical: true,
                responsive: [
                    {
                        breakpoint: 650,
                        settings: {
                            vertical: false
                        }
                    },
                    {
                        breakpoint: 550,
                        settings: {
                            vertical: false,
                            slidesToShow: 3
                        }
                    }
                ],
            });
        } else {
            $(elSelector).find('.review-slide__main').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                fade: true,
                arrows: false,
                asNavFor: elSelector + ' .review-slide__thumbnail'
            });
            $(elSelector).find('.review-slide__thumbnail').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                asNavFor: elSelector + ' .review-slide__main',
                infinite: false,
                dots: false,
                arrows: true,
                prevArrow: '<button type="button" class="slick-arrow slick-prev arrow-grey review-slider__prev"></button>',
                nextArrow: '<button type="button" class="slick-arrow slick-next arrow-grey review-slider__next"></button>',
                focusOnSelect: true
            });
        }
    }

    function hideSlider(elSelector, isFastReview) {
        if (!isFastReview) {
            $(elSelector).find('.big-slide').filter('.slick-initialized').slick('unslick');
            $(elSelector).find('.slides-feed').filter('.slick-initialized').slick('unslick');
        } else {
            $(elSelector).find('.review-slide__main').filter('.slick-initialized').slick('unslick');
            $(elSelector).find('.review-slide__thumbnail').filter('.slick-initialized').slick('unslick');
        }
    }


    function intersect_count(a, b){
        var count = 0;
        $.each(a, function(k,v){
            if(b[k] == a[k]) {
                count++;
            }
        })
        return count
    }

    var afterInit = false;

    function reloadInputs(obj) {
        var curr_name = $(obj).attr('name').toLowerCase();
        var curr_val = $(obj).attr('prop_id');
        var enabled = [];//какие доступны варианты с выбранным свойством
        var first_var = {}; //первый найденный вариант
        var intersectFields = 0;

        var currentVariant = [];

        var $offerPropBlock = $(parentBlockSelector + ' .offer_prop_block:visible');
        if (!$offerPropBlock.length) {
            return false;
        }

        var propsCurrent = $offerPropBlock.attr('variant').split('|');
        $.each(propsCurrent, function(k,v){
            currentVariant[v.split(':')[0]] = v.split(':')[1];
        });


        $.each($(parentBlockSelector + ' .offer_prop_variant[prop_' + curr_name + ' = ' + curr_val + ']'), function(key,val) {
            var props = $(val).attr('variant').split('|');
            var current = {};

            $.each(props, function(k,v){
                current[v.split(':')[0]] = v.split(':')[1];
                if(enabled[v.split(':')[0].toLowerCase()] === undefined) enabled[v.split(':')[0].toLowerCase()] = [];
                enabled[v.split(':')[0].toLowerCase()][key] = v.split(':')[1];
            });

            intersect = intersect_count(current, currentVariant);
            if(key == 0 || intersect > intersectFields){
                first_var = current;
                intersectFields = intersect;
            }
        });

        $.each($(parentBlockSelector + ' .prop_input'), function(){
            var input = $(this);
            var propId = $(input).attr('prop_id');
            var propName = $(input).attr('name').toLowerCase();

            if ($.inArray(propId, enabled[propName]) !== -1) {
                if ($(input).attr('name') == "COLOR") {
                    $(input).prop('disabled', false).css('opacity', '1');
                    $(input).next().show();
                } else {
                    // if(k == 0) $(input).attr('checked', true);
                    $(input).parent().show();
                    if(afterInit) {
                        if(curr_name == 'color'){
                            $(input).parent().show();
                        }
                        $(input).prop('disabled', false).parent().css('opacity', '1');
                    }
                }
            } else if (!$(input).parent().parent().is($(obj).parent().parent())) {
                if ($(input).attr('name') == "COLOR") {
                    $(input).prop('disabled', true).parent().css('opacity', '0.3');
                } else {
                    if(afterInit) {
                        $(input).prop('disabled', true).parent().css('opacity', '0.4');
                    }
                }
            }

            if($.inArray('color', Object.keys(enabled)) == -1){
                $(parentBlockSelector + ' .color input:checked').prop('checked', false);
            }

            if ($(this).attr('prop_id') == first_var[$(this).attr('name').toUpperCase()]) {
                $(this).prop('checked', true);
            }
        });

        if(afterInit) {
            $.each($(parentBlockSelector + ' .options'), function () {
                var $line = $(this).find('.form_radio_btn:visible');
                if ($line.length == 1 && $.inArray($line.find('input').attr('name').toLowerCase(), Object.keys(enabled)) > -1) {
                    $line.find('input').prop('checked', true);
                } else if ($line.length > 1 && $line.find('input:checked').length == 0 && $.inArray($line.find('input').attr('name').toLowerCase(), Object.keys(enabled)) > -1) {
                    var name = $(this).find('input:eq(0)').attr('name');
                    $(this).find(parentBlockSelector + ' input[prop_id=' + first_var[name] + ']').prop('checked', true);
                } else if ($line.length == 0 || $.inArray($line.find('input').attr('name').toLowerCase(), Object.keys(enabled)) == -1) {
                    $(this).find('input:checked').prop('checked', false);
                }
            });

            if ($(parentBlockSelector + ' .color label:visible').length == 1 && $.inArray('color', Object.keys(enabled)) > -1) {
                $(parentBlockSelector + ' .color label:visible').prev().attr('checked', true);
            } else if ($('.color label:visible').length > 1 && $(parentBlockSelector + ' .color').find('input:checked').length == 0 && $.inArray('color', Object.keys(enabled)) > -1) {
                var name = $(parentBlockSelector + ' .color').find('input:eq(0)').attr('name');
                $(parentBlockSelector + ' .color').find('input[prop_id=' + first_var[name] + ']').prop('checked', true);
            }
        }
    }

    if ($(parentBlockSelector + ' .prop_input').length) {
        $(parentBlockSelector + ' .prop_input').on('change', function () {
            if (afterInit) {
                reloadInputs(this);
            }

            var input = $(this);

            var variant = '';
            $.each($(parentBlockSelector + ' .prop_input'), function () {
                if ($(this).is(':checked')) {
                    variant = variant + $(this).attr('prop') + '|';
                }
            });

            var find = 0;
            var amount = 0;

            $.each($(parentBlockSelector + ' .offer_prop_block_amount'), function () {
                if ($(this).attr('variant') == variant) {
                    var cur_var = $('.' + $(this).attr('class').replace(/ /g, '.') + '[variant="' + variant + '"]');

                    if ($(cur_var).length > 1) {
                        $(cur_var).first().css({'display': 'flex'});
                        amount = +$(cur_var).first().attr('quant');
                        find = $(cur_var).first().attr('prod_id');
                    } else {
                        $(this).css({'display': 'flex'});
                        amount = +$(this).attr('quant');
                        find = $(this).attr('prod_id');
                    }
                } else {
                    $(this).hide();
                }
            });

            $.each($(parentBlockSelector + ' .offer_prop_block'), function () {
                if ($(this).attr('variant') == variant) {
                    var cur_var = $('.' + $(this).attr('class').replace(/ /g, '.') + '[variant="' + variant + '"]');

                    cur_var.show();

                    if (typeof $(this).attr('prop_art') != 'undefined' && !isFastReview) {
                        let article = $(this).attr('prop_art');
                        let newUrl = '';
                        if (window.location.search.indexOf('article=') > -1) {
                            newUrl = window.location.search.replace(/article=(\d{1,30})/, 'article=' + article);
                        } else {
                            newUrl = location.href + (window.location.search ? '&' : '?') + 'article=' + article;
                        }
                        window.history.pushState({}, '', newUrl);
                    }
                } else $(this).hide();
            });

            $(parentBlockSelector + ' .offer_prop_block_main').hide();

            $(parentBlockSelector + ' .offer_prop_block_imgs').each(function () {
                var el;
                if ($(this).attr('variant') == variant) {
                    var cur_var = $('.' + $(this).attr('class').replace(/ /g, '.') + '[variant="' + variant + '"]');
                    if ($(cur_var).length > 1) {
                        $(cur_var).first().show();
                        el = $(cur_var);
                    } else {
                        el = $(this)
                    }

                    el.show();
                    showSlider(parentBlockSelector + ' .offer_prop_block_imgs[variant="' + variant + '"]', isFastReview);
                } else {
                    $(this).hide();
                    hideSlider(parentBlockSelector + ' .offer_prop_block_imgs[variant="' + $(this).attr('variant') + '"]', isFastReview);
                }
            });


            setTimeout(function () {
                if (!$(parentBlockSelector + ' .images:visible').length) {
                    $(parentBlockSelector + ' .images.main').show();
                    showSlider(parentBlockSelector + ' .images.main', isFastReview);
                } else {
                    $(parentBlockSelector + ' .images.main').hide();
                    hideSlider(parentBlockSelector + ' .images.main', isFastReview);
                }

                if (find && (amount > 0)) {
                    //$(parentBlockSelector + ' .offers_buy_block').css({'display':'flex'});
                    $(parentBlockSelector + ' .offers_buy_block input').attr('data-max', amount);
                    $(parentBlockSelector + ' .offers_buy_block input').attr('prod_id', find);

                    if ($(parentBlockSelector + ' .offers_buy_block input').val() > amount)
                        $(parentBlockSelector + ' .offers_buy_block input').val(amount);
                }



                // Печать
                (function () {
                    var sProductHeader = $(parentBlockSelector + ' .product-header.offer_prop_block:visible').text();
                    var sArticle = $(parentBlockSelector + ' .rate-articul:visible').data('value');
                    var sCurPrice = $(parentBlockSelector + ' .product-price:visible .item-price__current').text().trim();
                    var sOldPrice = $(parentBlockSelector + ' .product-price:visible .item-price__old').data("text");
                    var sCharacteristics = $(parentBlockSelector + ' .characteristics:visible').html();
                    var sDescription = $(parentBlockSelector + ' .description:visible').html();
                    var $Images = $(parentBlockSelector + ' .product-slider:visible .big-slide__item img');
                    var arImages = [];

                    $Images.each(function () {
                        arImages.push($(this).attr('src'));
                    });

                    var $productPrint = $('.product-print');


                    if (arImages.length >= 1) {
                        $productPrint.find('.print-img__main').show().find('img').attr('src', arImages[0]);
                    } else {
                        $productPrint.find('.print-img__main').hide();
                    }

                    if (arImages.length >= 2) {
                        $productPrint.find('.print-img__secondary-item.first').show().find('img').attr('src', arImages[1]);
                    } else {
                        $productPrint.find('.print-img__secondary-item.first').hide();
                    }

                    if (arImages.length >= 3) {
                        $productPrint.find('.print-img__secondary-item.second').show().find('img').attr('src', arImages[2]);
                    } else {
                        $productPrint.find('.print-img__secondary-item.second').hide();
                    }

                    $productPrint.find('.product-header').text(sProductHeader);
                    $productPrint.find('.rate-articul').text('Артикул ' + sArticle);
                    $productPrint.find('.item-price__current').text(sCurPrice);

                    var $printDesc = $productPrint.find('.print-card-description');
                    if (sDescription?.length > 0) {
                        $printDesc.find('.description').html(sDescription);
                        $printDesc.show();
                    } else {
                        $printDesc.hide();
                    }

                    if (sOldPrice?.length > 0) {
                        $productPrint.find('.item-price__old').show().text(sOldPrice);
                    } else {
                        $productPrint.find('.item-price__old').hide();
                    }
                    $productPrint.find('.characteristics').html(sCharacteristics);
                })();
            }, 100);
        });


        // находим минимальный артикул тп, чтобы выставить значения свойств
        var min;

        if (window.location.search.match(/article=(\d{1,30})/) && !isFastReview) {
            min = window.location.search.match(/article=(\d{1,30})/).pop();
        } else {
            var arts = [];
            $.each($(parentBlockSelector + ' .js-catalog-detail-articul.offer_prop_block'), function () {
                arts.push($(this).attr('prop_art'));
            });
            min = arts[0];
            $.each(arts, function () {
                if (this < min) min = this;
            });
        }

        var cur_var = $(parentBlockSelector + ' .js-catalog-detail-articul.offer_prop_block[prop_art = ' + min + ']').attr('variant');
        var props = cur_var.split('|');
        var cur = [];
        $.each(props, function (k, v) {
            cur[v.split(':')[0]] = v.split(':')[1];
        })

        $.each($(parentBlockSelector + ' .options'), function () {
            $(this).find('.prop_input[prop_id=' + cur[$(this).find('.prop_input:first').attr('name')] + ']').attr('checked', true).change();
        });

        if ($(parentBlockSelector + ' .color').length > 0) {
            $('.color').find('input[prop_id=' + cur["COLOR"] + ']').attr('checked', true).change();
        }

        afterInit = true;
    }
}

$.validator.messages.required = 'Это поле обязательно для заполнения';

$.validator.addMethod("minLengthPhone", function (value, element) {
        return value.replace(/\D+/g, '').length > 10;
    },
    "Введите корректный телефон");
$.validator.addMethod("requiredPhone", function (value, element) {
        return value.replace(/\D+/g, '').length > 1;
    },
    "Введите телефон");
$.validator.addMethod("inn", function (value, element) {
    var multipliers = [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8],
        inn = value.split(''), i, j, ch = [0, 0, 0];
    for (i = 0; i < 12; i++)
        for (j = 0; j < 3; j++)
            if (multipliers[i + j])
                ch[j] = ch[j] + inn[i] * multipliers[i + j];
    if (inn.length == 10)
        return inn[9] == ch[2] % 11 % 10;
    else if (inn.length == 12)
        return inn[10] == ch[1] % 11 % 10 && inn[11] == ch[0] % 11 % 10;
    else
        return !value;
}, "Ошибка при наборе ИНН");

$.validator.setDefaults({
    ignore: ".ignore",
})



function declOfNum(number, titles) {
    var cases = [2, 0, 1, 1, 1, 2];
    return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
}


function readTextFile(file, callback) {
    var rawFile = new XMLHttpRequest();
    rawFile.overrideMimeType("application/json");
    rawFile.open("GET", file, true);
    rawFile.onreadystatechange = function() {
        if (rawFile.readyState === 4 && rawFile.status == "200") {
            callback(rawFile.responseText);
        }
    }
    rawFile.send(null);
}
function conversionCart() {
    readTextFile("https://www.doorlock.ru/ajax/count_cart.php", function(text){
        var cartHalfItemsJson = text;
        try{
            convead('event', 'update_cart', {
                items:JSON.parse(cartHalfItemsJson)
            });
        }catch (e) {
            console.log(e)
        }
        //console.log(cartHalfItemsJson);
    });
}
function conversionOrder() {
    readTextFile("https://www.doorlock.ru/ajax/count_order.php?ORDER_ID="+$('#bx-soa-order-confirm').data('order_id'), function(text){
        var cartHalfItemsJson = text;
        if (cartHalfItemsJson != 0) {
            if (localStorage.getItem("ordedDone") != 1){
                try{
                    convead('event', 'purchase', JSON.parse(cartHalfItemsJson));
                }catch (e) {
                    console.log(e)
                }
                localStorage.setItem("ordedDone", 1);
            }
        }
        //console.log(cartHalfItemsJson);
    });
}