$(document).ready(function() {
    // .js-map-region-dealer
    // .region-selected

    // .js-dealer-region-current"

    // .js-dealer-region-option

    // .js-dealler-address
    // .js-dealler-address-<region>


    function selectRegion(regionCode) {
        if (regionCode == 'all') {
            $('.js-dealler-address').show();
        } else {
            $('.js-dealler-address').hide()
                .filter('.js-dealler-address-' + regionCode).show();
        }

        var regionName = $('.js-dealer-region-option[data-region="'+regionCode+'"] .region-name').text();
        $('.js-dealer-region-current').text(regionName);

        if (regionCode == 'all') {
            $('.js-map-region-dealer').removeClass('region-selected')
        } else {
            $('.js-map-region-dealer').removeClass('region-selected')
                .filter('[data-region="'+regionCode+'"]').addClass('region-selected');
        }

        $(".region-selector__list").removeClass('regions-show');
    }

    $(document).on('click', '.js-dealer-region-option, .js-map-region-dealer', function (e) {
        e.preventDefault();

        var regionCode = $(this).data('region');

        selectRegion(regionCode);
    });


    $(document).on('mouseover', '.js-map-region-dealer', function (e) {
        var mapHint = $('.map-obj-hint'),
            target = $('.deallers')[0].getBoundingClientRect(),
            x = e.clientX - target.left - (mapHint.innerWidth() / 2),
            y = e.clientY - target.top - (mapHint.innerHeight() * 1.5);

        var regionCode = $(this).data('region'),
            regionName = $('.js-dealer-region-option[data-region="'+regionCode+'"] .region-name').text(),
            addressesCount = $('.js-dealler-address-' + regionCode).length;

        mapHint.find('.map-obj-area').text(regionName);
        mapHint.find('.link-blue').text(addressesCount + ' ' + declOfNum(addressesCount, ['объект', 'объекта', 'объектов']));

        mapHint.css({'top': y + 'px', 'left': x + 'px'});
        mapHint.show(100)
    });

    $(document).on('mouseout', '.js-map-region-dealer', function (e) {
        var mapHint = $('.map-obj-hint');

        mapHint.hide(100);
    });

    $('.region-filters__item').on('click', function(){
        console.log('dsad');
        $(".region-selector__list").toggleClass('regions-show')
    });
})