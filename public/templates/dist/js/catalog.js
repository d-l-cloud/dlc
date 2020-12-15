$('.js-catalog-range').each(function () {
    var $el = $(this),
        $slider = $el.find('.js-catalog-slider'),
        $inputMin = $el.find('.js-catalog-range-min'),
        $inputMax = $el.find('.js-catalog-range-max'),
        minValue = $el.data('min-value'),
        maxValue = $el.data('max-value'),
        curMinValue = $el.data('cur-min-value'),
        curMaxValue = $el.data('cur-max-value');

    if ($slider.length) {
        $slider.slider({
            min: minValue,
            max: maxValue,
            values: [curMinValue, curMaxValue],
            range: true,
            stop: function (event, ui) {
                $inputMin.val($slider.slider("values", 0));
                $inputMax.val($slider.slider("values", 1));
                $inputMin.trigger('keyup');
                $inputMax.trigger('keyup');
            },
            slide: function (event, ui) {
                $inputMin.val($slider.slider("values", 0));
                $inputMax.val($slider.slider("values", 1));
            }
        });

        $inputMin.change(function () {
            var value1 = $inputMin.val();
            var value2 = $inputMax.val();

            if (parseInt(value1) > parseInt(value2)) {
                value1 = value2;
                $inputMin.val(value1);
            }
            $slider.slider("values", 0, value1);
        });


        $inputMax.change(function () {
            var value1 = $inputMin.val();
            var value2 = $inputMax.val();

            if (value2 > maxValue) {
                value2 = maxValue;
                $inputMax.val(value2)
            }

            if (parseInt(value1) > parseInt(value2)) {
                value2 = value1;
                $inputMax.val(value2);
            }
            $slider.slider("values", 1, value2);
        });
    }
});

// Open Filter
function openFilter() {
    $('.filter-header, .tick').on('click', function(e) {
        let target = e.target;
       $(this).siblings('.filter-hidden').toggleClass('filter-visible');
        $(this).siblings('.tick').toggleClass('spin');
        if ($(this).hasClass('tick')) {
            $(this).toggleClass('spin');
        }
    });
}
openFilter();

// Проверка высоты блока фильтра и добавление кнопки "показать еще"

function checkFilterHeight() {
    let filterBlock = $('.color-wrap'),
        tick = $('.tick');

    tick.on('click', function () {
        function getFilterHeight() {
            if (filterBlock.innerHeight() > 185) {
                filterBlock.addClass('more-filters');
                filterBlock.css
            }
        }
        setTimeout(getFilterHeight(), 100);
    });
}
checkFilterHeight();

//Переключение отображения товара табом
(function($) {
    $(function() {
        $('.apearance-ico').on('click',  function() {
            $(this).addClass('active-ico').siblings().removeClass('active-ico');
            $('.cat-col__right').find('.goods-tab__content').removeClass('goods-active__content').eq($(this).index()).addClass('goods-active__content');
        });

        $(function(){
            $('.js-catalog-chars').each(function () {
                var $this = $(this),
                    $chars = $this.find('.chars-col__row'),
                    $moreChars = $this.find('.char-more');

                if ($chars.length > 10) {
                    $moreChars.on('click', function () {
                        $chars.filter(':nth-child(n+10)').toggleClass('slide-char');

                        var text = $(this).text();
                        $(this).text(text === 'Скрыть характеристики' ? 'Еще характеристики' : 'Скрыть характеристики')
                    });
                } else {
                    $moreChars.hide();
                }
            });
        });
    });
})(jQuery);

// Стилизация селекта
$(document).ready(function() {
    setTimeout(function() {
        if ($('.sort-filter').length) {
            $('.sort-filter').styler();
        }
    }, 100)
});

// Categories slider

$(document).ready(function () {
    $('.categories-slide').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        variableWidth: false,
        prevArrow: '<button type="button" class="slick-arrow slick-prev arrow-grey categories-arrow"></button>',
        nextArrow: '<button type="button" class="slick-arrow slick-next arrow-grey categories-arrow"></button>',
        responsive: [
            {
                breakpoint: 1300,
                settings: {
                    arrows: true,
                    centerMode: false,
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 960,
                settings: {
                    arrows: false,
                    centerMode: true,
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: false,
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: true,
                    centerMode: false,
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 320,
                settings: {
                    arrows: true,
                    centerMode: false,
                    slidesToShow: 1
                }
            }
        ]
    });
})

// Высота блока с описанием бренда
$(document).ready(function () {
    let div = document.querySelector('.brand-info'),
        more = document.querySelector('.brand-info__more'),
        less = document.querySelector('.brand-info__less');

    if (!!div) {
        if (div.clientHeight > 60) {
            div.classList.add('short');
        }
        more.addEventListener('click', function() {
            div.classList.remove('short');
            more.style.display = 'none';
            less.style.display = 'block';
        });
        less.addEventListener('click', function() {
            div.classList.add('short');
            less.style.display = 'none';
            more.style.display = 'block';
        });
    }
});

$(document).on('change', 'select.js-catalog-list-input-sort', function(e){
    var need_url = document.location.search;

    var need_val = $(this).val();
    if (need_val) {
        if(need_url){
            if(need_url.match(/sort=[A-aZ-z]*/))
                need_url = need_url.replace(/sort=[A-aZ-z]*/, "sort=" + need_val);
            else
                need_url = need_url + "&sort=" + need_val;
        } else
            need_url = "?sort=" + need_val;
    } else {
        if(need_url){
            if(need_url.match(/sort=[A-aZ-z]*/))
                need_url = need_url.replace(/sort=[A-aZ-z]*/, "");
        }
    }

    document.location.search = need_url;
})

$(document).on('change', 'select.js-catalog-list-input-count', function(e){
    var need_url = document.location.search;

    var need_val = $(this).val();
    if (need_val) {
        if(need_url){
            if(need_url.match(/count=[0-9]*/))
                need_url = need_url.replace(/count=[0-9]*/, "count=" + need_val);
            else
                need_url = need_url + "&count=" + need_val;
        } else
            need_url = "?count=" + need_val;
    } else {
        if(need_url){
            if(need_url.match(/count=[0-9]*/))
                need_url = need_url.replace(/count=[0-9]*/, "");
        }
    }

    document.location.search = need_url;
});

$(document).on('click', '.js-btn-show-more', function () {
    var nextPage = $(this).data('next-page');
    var url = '';

    if (location.search)
        url = location.href + "&PAGEN_1=" + nextPage;
    else
        url = location.href + "?PAGEN_1=" + nextPage;

    $.ajax({
        type: "GET",
        url: url,
        success: function(html){
            var $html = $(html),
                $productsInCol = $html.find('.js-products-in-col'),
                $productsInRow = $html.find('.js-products-in-row'),
                $btnShowMore = $html.find('.js-btn-show-more'),
                $pagination = $html.find('.js-pagination');

            $('.js-products-in-col').append($productsInCol.html());
            $('.js-products-in-row').append($productsInRow.html());

            if ($btnShowMore.length) {
                $('.js-btn-show-more').data('next-page', $btnShowMore.data('next-page'));
            } else {
                $('.js-btn-show-more').hide();
            }

            if ($pagination.length) {
                $('.js-pagination').html($pagination.html()).show();
            } else {
                $('.js-pagination').hide();
            }
        }
    });
})