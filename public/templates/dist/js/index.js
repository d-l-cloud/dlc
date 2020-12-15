var arrCaptcha = [];

window.openSubscribePopup = function (success) {
    var subscribePopupLayout = $('.subscribe-popup__layout');

    if (success) {
        subscribePopupLayout.find('.subscribe-confirmation').show();
        subscribePopupLayout.find('.subscribe-confirmation-error').hide();
    } else {
        subscribePopupLayout.find('.subscribe-confirmation').hide();
        subscribePopupLayout.find('.subscribe-confirmation-error').show();
    }

    subscribePopupLayout.addClass('activ-popup');
    $('body').addClass('non-scroll');
}

$(document).ready(function() {
    var closeCross = $('.popup-close, .js-close-popup');

    function openPopupsAll() {

        function openCloseCityPopup() {
            var cityPopupLayout = $('.city-popup__layout');

            $(document).on('click', '.js-current-city', function() {
                cityPopupLayout.addClass('activ-popup');
                $('body').addClass('non-scroll');
            });
        }
        openCloseCityPopup();


        /*function openCloseFeedback() {
            var feedbackSelection = $('.feedback'),
                feedbackPopupLayout = $('.feedback-popup__layout');

            feedbackSelection.on('click', function() {
                feedbackPopupLayout.addClass('activ-popup');
                $('body').addClass('non-scroll');
            });
        }
        openCloseFeedback();*/

        /*function openCloseBackCall() {
            var BackCallSelection = $('.contacts-call'),
                feedbackPopupLayout = $('.feedback-popup__layout');

            BackCallSelection.on('click', function() {
                feedbackPopupLayout.addClass('activ-popup');
                $('body').addClass('non-scroll');
            });
        }
        openCloseBackCall();*/

        function openRegister() {
            var loginPopupLayout = $('.register-layout');

            $(document).on('click', '.js-open-login-popup', function() {
                loginPopupLayout.addClass('activ-popup');
                $('body').addClass('non-scroll');
            });
        }
        openRegister();

        function registerLoginSwitch() {
            $('.register-switch').on('click',function() {
                $('.login').toggle();
                $('.register').toggle();
            });
        }
        registerLoginSwitch();


        //Закрытие попапа кликом вне блока
        $(document).mouseup(function (e){
            var innerPopup = $(".popup"),
                deletePopup = $(".popup-delete");
            if (!innerPopup.is(e.target) && innerPopup.has(e.target).length === 0
                && !deletePopup.is(e.target) && deletePopup.has(e.target).length === 0) {
                $('.popup-layout').removeClass('activ-popup');
                $('body').removeClass('non-scroll');
            }
        });
    }
    openPopupsAll();

    function openCatalog() {
        $('.header-search__catalog').on('click', function() {
            if ($(window).width() > 1100) {
                $('.catalog').toggleClass('show-catalog');
                $('.header-search__catalog').toggleClass('catalog-btn-active');
            } else {
                $('.cataloglist-mobile').toggleClass('show-catalog__mobile');
                $('.header-search__catalog').toggleClass('catalog-btn-active');
            }
        });
        /*$(document).mouseup(function (e){
            var catalog = $(".catalog");
            if (!catalog.is(e.target) && catalog.has(e.target).length === 0) {
                $('.catalog').removeClass('show-catalog');
            }
        });

        $(document).mouseup(function (e){
            var catalogMobile = $(".cataloglist-mobile");
            if (!catalogMobile.is(e.target) && catalogMobile.has(e.target).length === 0) {
                $('.cataloglist-mobile').removeClass('show-catalog__mobile');
            }
        });*/
    }
    openCatalog();

    function forgotPassword() {
        var forgotPasswordBtn = $('.login-forgot');

        forgotPasswordBtn.on('click', function () {
            $('.login, .register').hide();
            $('.restore').show();
        });
    }
    forgotPassword();

    closeCross.on('click', function() {
        $(this).closest('.popup-layout').removeClass('activ-popup');
        $('body').removeClass('non-scroll');
        $('.register').hide();
        $('.restore').hide();
        $('.login').show();
    });



    $('.feddback-textaria textarea').on('focus', function() {
        if ($('.feddback-textaria textarea').val() != '') {
            $('.feddback-textaria textarea').css('border-color', '#1F3664');
        }
    });


    //Slider
    $(document).ready(function(){
        $('.main-slider').slick({
            prevArrow: '<button type="button" class="slick-arrow slick-prev"></button>',
            nextArrow: '<button type="button" class="slick-arrow slick-next"></button>',
            dots: true,
            slidesToShow: 1,
            dotsClass: "my-dots",
            adaptiveHeight: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        arrows: false,
                        slidesToShow: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        slidesToShow: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        slidesToShow: 1
                    }
                }
            ]
        });
    });

    $(document).ready(function(){
        $('.additional-slider').each(function () {
            var $this = $(this),
                bInfinity = ($this.data('infinity') == 0) ? false : true,
                bVariableWidth = ($this.data('variable-width') == 0) ? false : true,
                bCompare = !!$this.data('compare');

            $this.slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: bInfinity,
                variableWidth: bVariableWidth,
                prevArrow: '<button type="button" class="slick-arrow slick-prev arrow-grey '+ ((bCompare) ? 'fc-arrow' : '') +'"></button>',
                nextArrow: '<button type="button" class="slick-arrow slick-next arrow-grey '+ ((bCompare) ? 'fc-arrow' : '') +'"></button>',
                responsive: [
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
                            centerMode: true,
                            slidesToShow: 1
                        }
                    }
                ]
            });
        });
    });
});


(function($) {
    var a = $('.main-slider');
    window.addEventListener('resize', function() {a.slick('setPosition')});
})(jQuery);


(function($) {
    $(function() {
        $('.catalog-tabs').on('click', 'div:not(.active-tab)', function() {
            $(this).addClass('active-tab').siblings().removeClass('active-tab');
            $('.catalog-content').find('.tab-content__item').removeClass('active-tab__content').eq($(this).index()).addClass('active-tab__content');
        });
    });
})(jQuery);
(function($) {
    $(function() {
        $('.tabs-switcher').on('click', 'div:not(.tab-active)', function() {
            $(this).addClass('tab-active').siblings().removeClass('tab-active');
            $('.form-tab__content').find('.form-content__item').removeClass('active-form__content').eq($(this).index()).addClass('active-form__content');
            $('.form-email input').not('[type="hidden"]').val('').removeClass('error');
            $('.form-email label.error').remove();
        });
    });
})(jQuery);


// Валидация
$(document).ready(function(){
    $(".form-validate").on('keyup blur', 'input', function () {
        var $form = $(this).closest('form');
        if ($form.valid()) {
            $form.find('button[type="submit"]').prop('disabled', false).addClass('active-btn');
        } else {
            $form.find('button[type="submit"]').prop('disabled', 'disabled').removeClass('active-btn');
        }
    })

    $('.valid-phone').inputmask("+7 (999) 999-99-99");
    $('.mask-inn-organization').inputmask('9999999999');
    $('.mask-ogrn').inputmask('9999999999999');
    $('.mask-ogrnip').inputmask('999999999999999');
    $('.mask-kpp').inputmask('999999999');
    //$('.mask-bik').inputmask('999999999');
    $('.mask-account').inputmask('99999999999999999999');
});

$('.popup-socials__item').click(function () {
    $('.popup-layout').removeClass('activ-popup');
    $('body').removeClass('non-scroll');
});

function showNotification(title = false, text = false) {
    $('.popup-layout').removeClass('activ-popup');

    var $layout = $('.notification-popup__layout'),
        $title = $layout.find('.popup-header'),
        $text = $layout.find('.notification-text');

    if (!!title) {
        $title.text(title).show();
    } else {
        $title.hide();
    }

    if (!!text) {
        $text.text(text).show();
    } else {
        $text.hide();
    }

    if (!title && !text) {
        $title.text('Ошибка').show();
    }

    $layout.addClass('activ-popup');
    $('body').addClass('non-scroll');
}


// Загрузка веб форм
$(document).on('click', '.js-load-web-form-pop-up', function () {
    var $self = $(this),
        formId = $self.data('web_form_text_id'),
        $modal = $('.webform-popup__wrap'),
        $confirmation = $('.webform-popup__layout').find('.confirmation');


});


$(document).on('input', 'input', function () {
    if ($(this).val() != '') {
        $(this).addClass('active-input')
    } else {
        $(this).removeClass('active-input')
    }
})

$(function () {
    $('input').not('[type="hidden"], [type="tel"]').trigger('input');
});


$(document).on('focus', 'input', function (e) {
    $(this).addClass('active-input')
});
$(document).on('blur', 'input', function (e) {
    if ($(this).val() === '') {
        $(this).removeClass('active-input')
        console.log('Input empty', e.target)
    }
});
