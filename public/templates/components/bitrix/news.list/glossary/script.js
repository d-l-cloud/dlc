(function () {
    var lastXhr;
    $('.js-glossary-search').on('input', function () {
        var value = $(this).val().trim(),
            data = {};

        if (value.length > 0) {
            data.q = value;
        }

        if (data?.q.length > 0) {
            if(lastXhr != null) {
                lastXhr.abort();
            }
            lastXhr = $.ajax({
                url: $(this).data('url'),
                dataType: 'html',
                data: data,
                success: function (result) {
                    var content = $(result).find('.js-glossary-content').html();

                    $('.js-glossary-content').html(content);
                },
            });
        }
    });
})();