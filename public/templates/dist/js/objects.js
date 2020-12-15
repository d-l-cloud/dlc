$(document).ready(function() {
    function initObjectsSlider() {
        $('.object-slide-big').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            prevArrow: '<button type="button" class="slick-arrow slick-prev arrow-grey object-slider__prev"></button>',
            nextArrow: '<button type="button" class="slick-arrow slick-next arrow-grey object-slider__next"></button>',
            fade: true,
            asNavFor: '.object-slide-small',
            dots: false,
            infinite: false
        });
        $('.object-slide-small').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            variableWidth: true,
            asNavFor: '.object-slide-big',
            centerMode: false,
            infinite: false,
            arrows: false,
            focusOnSelect: true
        });
    }

    $('.detail-img__main, .img-add__more').on('click', function () {
        $('.object-popup__layout').addClass('activ-popup');
        $('body').addClass('non-scroll');
        setTimeout(initObjectsSlider(), 300);
    });


    function selectRegion(regionCode) {
        if (regionCode == 'all') {
            $('.js-objects-address').show();

            $('.js-objects-address-option').show();
        } else {
            $('.js-objects-address').hide()
                .filter('[data-region="'+regionCode+'"]')
                .show();

            $('.js-objects-address-option').hide()
                .filter('[data-region="'+regionCode+'"]')
                .show();
        }

        var regionName = $('.js-objects-region-option[data-region="'+regionCode+'"] .region-name').text();
        $('.js-objects-region-current').text(regionName);
        $('.js-objects-address-current').data('region', regionCode);
        $('.js-objects-address-option[data-object-id="all"]').click();

        if (regionCode == 'all') {
            $('.js-map-region-objects').removeClass('region-selected')
        } else {
            $('.js-map-region-objects').removeClass('region-selected')
                .filter('[data-region="'+regionCode+'"]').addClass('region-selected');
        }

        $('.region-selector__list').removeClass('regions-show');
    }

    function selectObject(regionCode, objectId) {
        if (objectId == 'all') {
            if (regionCode == 'all') {
                $('.js-objects-address').show();
            } else {
                $('.js-objects-address').filter('[data-object-id="'+objectId+'"]').show();
            }
        } else {
            if (regionCode == 'all') {
                $('.js-objects-address').hide()
                    .filter('[data-region="'+regionCode+'"]')
                    .show();
            } else {
                $('.js-objects-address').hide()
                    .filter('[data-region="'+regionCode+'"]')
                    .filter('[data-object-id="'+objectId+'"]')
                    .show();
            }
        }

        var objectName = $('.js-objects-address-option[data-object-id="'+objectId+'"]').text();
        $('.js-objects-address-current').text(objectName);

        $('.region-selector__list').removeClass('regions-show');
    }

    $(document).on('click', '.js-objects-region-option, .js-map-region-objects', function (e) {
        e.preventDefault();

        var regionCode = $(this).data('region');

        selectRegion(regionCode);
    });

    $(document).on('click', '.js-objects-address-option', function (e) {
        e.preventDefault();

        var objectId = $(this).data('object-id'),
            regionCode = $('.js-objects-address-current').data('region');

        selectObject(regionCode, objectId);
    });


    $(document).on('mouseover', '.js-map-region-objects', function (e) {
        var mapHint = $('.map-obj-hint'),
            target = $('.js-map')[0].getBoundingClientRect(),
            x = e.clientX - target.left - (mapHint.innerWidth() / 2),
            y = e.clientY - target.top - (mapHint.innerHeight() * 1.5);

        var regionCode = $(this).data('region'),
            regionName = $('.js-objects-region-option[data-region="' + regionCode + '"] .region-name').text(),
            addressesCount = $('.js-objects-address[data-region="' + regionCode + '"]').length;

        mapHint.find('.map-obj-area').text(regionName);
        mapHint.find('.link-blue').text(addressesCount + ' ' + declOfNum(addressesCount, ['объект', 'объекта', 'объектов']));

        mapHint.css({'top': y + 'px', 'left': x + 'px'});
        mapHint.show(100)
    });

    $(document).on('mouseout', '.js-map-region-objects', function (e) {
        var mapHint = $('.map-obj-hint');

        mapHint.hide(100);
    });

    $('.region-filters__item').on('click', function(){
        var currentList = $(this).parent().find('.region-selector__list');

        $('.region-selector__list').not(currentList).removeClass('regions-show');
        currentList.toggleClass('regions-show');
    });
})