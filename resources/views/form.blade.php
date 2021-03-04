<!doctype html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Отправка запроса с сайта - @yield('title'){{ config('app.name', 'Laravel') }} {!! Helper::siteSettings('city','1') !!}</title>
</head>
<body>
<form class="m-5" method="post" action="{{route('validateSiteForm')}}" onsubmit="yaCounter73141390.reachGoal ('svyaz')">
    @csrf
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @elseif ((Request::segment(2)==0) AND (Request::segment(3)==0))

    @else
    <div class="controls">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="form_name">Тип вопроса</label>
                    <input id="form_name" type="text" name="questionType" class="form-control" value="{{ $questionTypeName }}" readonly>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="form_lastname">Товар</label>
                    <input id="form_lastname" type="text" name="productName" class="form-control" value="{{ $productName }}" readonly>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="form_name">ФИО *</label>
                    <input id="form_name" type="text" name="name" class="form-control" placeholder="Укажите свое имя *" required="required"
                           data-error="Firstname is required." value="{{ old('name') }}">
                    <div class="help-block with-errors"></div>
                    @error('name')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="form_lastname">Email *</label>
                    <input id="form_lastname" type="email" name="email" class="form-control" placeholder="Укажите email *" required="required"
                           data-error="Lastname is required." value="{{ old('email') }}">
                    <div class="help-block with-errors"></div>
                    @error('email')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="form_email">Телефон *</label>
                    <input id="form_email" type="text" name="phone" class="form-control phone" placeholder="" required="required"
                           data-error="Valid email is required." value="{{ old('phone') }}">
                    <div class="help-block with-errors"></div>
                    @error('phone')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="form_message">Сообщение *</label>
            <textarea id="form_message" name="text" class="form-control" placeholder="Если необходимо оставьте сообщение" rows="4"
                      data-error="Please, leave us a message.">{{ old('text') }}</textarea>
            <div class="help-block with-errors"></div>
            @error('text')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="captcha">Проверка от ботов</label>
            {!! NoCaptcha::renderJs() !!}
            {!! NoCaptcha::display() !!}
            @error('g-recaptcha-response')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
        </div>
    <button type="submit" class="btn btn-primary">Отправить</button>
    @endif
</form>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('.phone').mask('+7(000)000-00-00', {placeholder: "+7(___)___-__-__"});
    });
</script>

@if ($_SERVER['SERVER_NAME']=='doorlock52.ru')
    <!-- Yandex.Metrika counter --> <script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(73141390, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/73141390" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
@endif
@if ($_SERVER['SERVER_NAME']=='d-l.cloud')
    <!-- Yandex.Metrika counter --> <script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(36936, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, trackHash:true, ecommerce:"dataLayer" }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/36936" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
@endif
</body>
</html>
