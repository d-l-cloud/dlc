const players = Array.from(document.querySelectorAll('.js-player')).map(p => new Plyr(p));

$(document).ready(function() {
    setTimeout(function() {
        $('.select').styler({
            filePlaceholder: 'Компания'
        });
    }, 100)
});

// Выбор региона из списка Диллеров
$('.region-name').on('click', function () {
    var regionText =  $(this).text();
    var currentText = $(this).parent().parent().parent().find('.region-current');

    currentText.text(regionText);
});


(function () {
    var lastXhr;
    function sendFilter() {
        var $form = $('.js-video-filters');
        var data = $form.serialize();

        if(lastXhr != null) {
            lastXhr.abort();
        }
        lastXhr = $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            dataType: 'json',
            data: data,
            success: function (result) {
                if (result.hasOwnProperty('FILTER_AJAX_URL')) {
                    lastXhr = $.ajax({
                        url: $.parseHTML(result.FILTER_AJAX_URL)[0].textContent,
                        type: 'GET',
                        data: {
                            ajax_video_filter: 'Y',
                        },
                        success: function (result) {
                            $('.js-video-ajax-block').html(result);
                            Array.from(document.querySelectorAll('.js-player')).map(p => new Plyr(p));
                        }
                    });
                }
            },
        });
    }

    $(document).on('change', '.js-video-filters input', function () {
        sendFilter();
    });

    $(document).on('click', '.js-video-filter-close', function () {
        var inputName = $(this).data('name');
        var inputValue = $(this).data('value');

        $('[name="'+inputName+'"]').filter('[value="'+inputValue+'"]')
            .prop('checked', false)
            .trigger('change');
    });

    $(document).on('click', '.js-video-close-all', function () {
        $('.js-video-filters input:checked')
            .prop('checked', false)
            .trigger('change');
    });
})();