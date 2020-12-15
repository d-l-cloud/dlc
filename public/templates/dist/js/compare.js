function onItemsLength() {
    $(document).ready(function () {
        if ($('.compare-item').length > 4) {
            $('.compare-arrow').show()
        }
    })

    var distance = 330,
        box = $('.compare-wrap-inner');
    $('.compare-arrow').on('click', function() {
        box.stop().animate({
            scrollLeft: '+=' + (distance * $(this).data('factor'))
        });
    });
}
onItemsLength();
