
// Счетчик Плюс - Минус
$(document).on('click', '.item-counter__minus', function () {
    if (!$(this).hasClass('counter-limit')) {
        var $input = $(this).parent().find('input');
        var minimum = $input.data('min');

        var oldCount = parseInt($input.val()),
            newCount = oldCount - 1;

        if (minimum > 0) {
            newCount = (newCount < minimum) ? minimum : newCount;
        }

        if (oldCount != newCount) {
            $input.val(newCount);
            $input.change();
        }
        return false;
    }
});
$(document).on('click', '.item-counter__plus', function () {
    if (!$(this).hasClass('counter-limit')) {
        var $input = $(this).parent().find('input');
        var maximum = $input.data('max');

        var oldCount = parseInt($input.val()),
            newCount = oldCount + 1;

        if (maximum > 0) {
            newCount = (newCount > maximum) ? maximum : newCount;
        }

        if (oldCount != newCount) {
            $input.val(parseInt($input.val()) + 1);
            $input.change();
        }
        return false;
    }
})

$(document).on('change', '.js-product-quantity', function () {
    var minimum = $(this).data('min'),
        maximum = $(this).data('max');

    var newValue = parseInt($(this).val(), 10);

    if (minimum > 0) {
        newValue = (newValue < minimum) ? minimum : newValue;
    }

    if (maximum > 0) {
        newValue = (newValue > maximum) ? maximum : newValue;
    }

    $(this).val(newValue);

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


// Open comment
$(document).on('click', '.js-leave-comment', function () {
    var productId = $(this).data('product-id');

    if (productId > 0) {
        var layout = $('.comment-popup__layout');

        layout.find('form input[name="product_id"]').val(productId);

        layout.addClass('activ-popup');
        $('body').addClass('non-scroll');
    }
});

// Ratings
$(function () {
    $('.comment-popup__layout form').validate({
        rules: {
            comment: {
                required: true,
            },
            mark: {
                required: true,
                min: 1,
            },
        },
        messages: {
            mark: {
                min: 'Выставите оценку товару',
            }
        },
        errorPlacement: function(error, element) {
            $(element).closest('div').append(error);
        },
        submitHandler: function (form) {
            var $form = $(form);
            var $errorTextBlock = $('.error-block');

            $.ajax({
                method: "POST",
                dataType: 'json',
                url: "/ajax/product_rating.php",
                data: $form.serializeArray(),
                beforeSend: function(){
                    $form.find('[name="comment"]').val('');
                    $form.find('[name="mark"]').val('');
                    $errorTextBlock.text('');
                },
                success: function(result){
                    if (result.success) {
                        var $parent = $('.comment-popup__layout');

                        $parent.find('form').hide();
                        $parent.find('.confirmation').show();
                    } else if (result.error) {
                        $errorTextBlock.text(result.error);
                    }
                }
            });
        }
    });

    var rating = $('.rating'),
        ratingItem = $('.rating-item');

    rating.on('click', function (e) {
        var target = e.target;
        if (target.classList.contains('rating-item')) {
            ratingItem.removeClass('current-active');
            $(target).addClass('active current-active');

            $(target).closest('form').find('input[name="mark"]').val($(target).data('mark'));
        }
    })

    rating.on('mouseover', function (e) {
        var target = e.target;
        if (target.classList.contains('rating-item')) {
            ratingItem.removeClass('active');
            $(target).addClass('active');

            for (var i = 0, iLen = ratingItem.length; i < iLen; i++) {
                if (ratingItem[i].classList.contains('active')) {
                    break;
                } else {
                    $(ratingItem[i]).addClass('active');
                }
            }
        }
    });

    rating.on('mouseout', function (e) {
        ratingItem.addClass('active');

        if (!ratingItem.hasClass('current-active')) {
            $(ratingItem).removeClass('active');
        } else {
            for (var i = ratingItem.length - 1; i >= 1; i--) {
                if (ratingItem[i].classList.contains('current-active')) {
                    break;
                } else {
                    $(ratingItem[i]).removeClass('active');
                }
            }

        }
    })
});

$(function($){
    $(".page-print").click(function(){
        window.print();
        return false;
    });
});
