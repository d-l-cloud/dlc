@extends('layouts.admin')
@section('title', '| Настройка сайта ')
@section('content')

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Настройка сайта</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Главная</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Настройки</a>
                            </li>
                            <li class="breadcrumb-item active">Сайт
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Configuration option table -->
            <section id="configuration">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    @if(Session::has('success'))
                                        <div class="alert bg-success alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                                            <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <strong>Отлично!</strong> {{ Session::get('success') }}
                                        </div>
                                    @endif
                                    <form method="POST" action="{{ route('admin.settings.site') }}" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        <input type="hidden" name="setId" value="1">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-12">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Город для логотипа</label>
                                                            <input type="text" name="city" class="form-control" value="{{ $settingsList->city }}" data-validation-required-message="{{ __('This field is required') }}" required>
                                                            <p class="text-left"><small class="text-muted">Будет указан под логотипом в шапке и подвале сайта</small></p>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Адрес</label>
                                                            <input id="address" type="text" name="address" class="form-control" value="{{ $settingsList->address }}" data-validation-required-message="{{ __('This field is required') }}" required>
                                                            <p class="text-left"><small class="text-muted">Полный адрес, пример: <strong>117630, г. Москва, Старокалужское шоссе, дом 62, этаж.4, пом. I, ком. 11.</strong></small></p>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Email для уведомлений</label>
                                                            <input type="email" name="emailNotifications" class="form-control" value="{{ $settingsList->emailNotifications }}" data-validation-email-message="Неверный формат Email" data-validation-required-message="{{ __('This field is required') }}" required>
                                                            <p class="text-left"><small class="text-muted">На данный ящик будут приходить уведомления от пользователей сайта и сервисные сообщения</small></p>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Номер телефона</label>
                                                            <input type="text" name="phone" class="form-control phone" value="{{ $settingsList->phone}}">
                                                            <p class="text-left"><small class="text-muted">Номер телефона для сайта</small></p>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Время работы</label>
                                                            <input type="text" name="workingHours" class="form-control" value="{{ $settingsList->workingHours }}">
                                                            <p class="text-left"><small class="text-muted">Необходимо указывать в следующем формате: ПН-ПТ 08:00-18:00, СБ-ВС Выходной </small></p>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group form-check">
                                                            <input type="hidden" name="maintenance" value="0">
                                                            <input @if (old('maintenance') == 1 || $settingsList->maintenance == 1) checked @endif type="checkbox" class="form-check-input @error('maintenance') is-invalid @enderror" name="maintenance" value="1">
                                                            <label class="form-check-label">Закрыть сайт на профилактику?</label>
                                                            <div class="help-block">
                                                                @if($errors->has('maintenance'))
                                                                    <ul role="alert">
                                                                        @foreach($errors->get('maintenance') as $error)
                                                                            <li>{{ $error }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group">
                                                    <label>Код для размещения на сайте</label>
                                                    <textarea class="form-control" name="javaCode" rows="10">{{ $settingsList->javaCode }}</textarea>
                                                    <p class="text-left"><small class="text-muted">Счетчики, чаты, обратные звонки</small></p>
                                                    <div class="help-block"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Карта для контактов</label>
                                                    <div></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">Сохранить</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection
@section('csstt')
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/vendors/css/forms/icheck/icheck.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/vendors/css/forms/toggle/switchery.min.css') }}">
@endsection
@section('csstb')
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/css/plugins/forms/validation/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/css/plugins/forms/switch.css') }}">
    <script src="https://cdn.tiny.cloud/1/mz7qzfuil56pc60lx3eo8swmbjgodpcj7i913beymjqyoqup/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endsection
@section('javascriptft')
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') }}"></script>
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js') }}"></script>
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/forms/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/forms/toggle/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/forms/toggle/switchery.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/css/suggestions.min.css" rel="stylesheet" />
@endsection
@section('javascriptfb')
    <script src="{{ asset('adminTemplate/app-assets/js/scripts/forms/validation/form-validation.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/js/jquery.suggestions.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('.phone').mask('+7(000)000-00-00', {placeholder: "+7(___)___-__-__"});
    });
</script>
@endsection
