$('.js-tab-change input').on('change', function () {
    window.location.href = '?sect=' + $(this).val();
});